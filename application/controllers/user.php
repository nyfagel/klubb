<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->language('klubb');
		$this->load->model('system_model');
		$this->load->model('user_model');
		$this->load->helper('html');
		$this->load->helper('form');
		
		$this->load->library('form_validation');
	}

	public function login() {
		$this->output->enable_profiler(TRUE);
		if ($this->auth->loggedin()) {
			$this->user_model->set_active($user['id']);
			redirect('home');
		}
		
		$error = '';
		
		// form submitted
		if ($this->input->post('username') && $this->input->post('password')) {
			$remember = $this->input->post('remember') ? TRUE : FALSE;
			
			// get user from database
			$user = $this->user_model->get_user($this->input->post('username'));
			
			if ($user) {
				// compare passwords
				if ($this->user_model->check_password($this->input->post('password'), $user['password'])) {
					// mark user as logged in
					$this->auth->login($user['id'], $remember);
					$this->user_model->set_active($user['id']);
					redirect('home');
				} else {
					$error = 'Wrong password';
				}
			} else {
				$error = 'User does not exist';
			}
		}
		
		if (!empty($error)) {
			$this->messages->add($error, "error");
		}
		
		$data['title'] = $this->system_model->get('app_name');
		
		$html = row(columns(heading(ucfirst(lang('welcome')), 1), 12));
		$html .= row(columns(p(lang('intro_text')), 12));
		
		$html .= form_open('user/login', array('class' => 'custom'));
		$html .= row(columns(panel(
			row(
				columns(form_label(ucfirst(lang('username')).':', 'username', array('class' => 'inline right')), 4).
				columns(form_input(array('type' => 'text', 'name' => 'username', 'id' => 'username')), 8),
			'collapse').
			row(
				columns(form_label(ucfirst(lang('password')).':', 'password', array('class' => 'inline right')), 4).
				columns(form_input(array('type' => 'password', 'name' => 'password', 'id' => 'password')), 8),
			'collapse').
			row(columns(form_label(form_input(array('type' => 'checkbox', 'name' => 'remember', 'id' => 'remember', 'value' => 1)).nbs().ucfirst(lang('remember_me')), 'remember', array('class' => 'right')), 12)).
			row(columns(form_input(array('type' => 'submit', 'class' => 'right button', 'value' => ucfirst(lang('login')))), 12))), 6, 'centered'));
		$html .= form_close();
		
		$data['html'] = $html;
		$this->system_model->view('template', $data);
	}
	
	public function create() {
		$this->output->enable_profiler(TRUE);
		if (!$this->auth->loggedin()) {
			redirect('user/login');
		}
		$uid = intval($this->auth->userid());
		$user = $this->user_model->get_user($uid);
		
		$this->form_validation->set_rules('username', ucfirst(lang('username')), 'trim|required|is_unique[users.username]');
		$this->form_validation->set_rules('email', ucfirst(lang('email_address')), 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_message('is_unique', '%s finns redan i systemet.');
		
		$this->form_validation->set_error_delimiters('<small class="error">', '</small>');
		
		$data['title'] = $this->system_model->get('app_name');
		$html = heading(ucfirst(lang('create_user')), 1);
		
		if ($this->form_validation->run() == true) {
			$user = array();
			if ($this->input->post('username')) {
				$user['username'] = $this->input->post('username');
			}
			if ($this->input->post('firstname')) {
				$user['firstname'] = $this->input->post('firstname');
			}
			if ($this->input->post('lastname')) {
				$user['lastname'] = $this->input->post('lastname');
			}
			if ($this->input->post('email')) {
				$user['email'] = $this->input->post('email');
			}
			if ($this->input->post('phone')) {
				$user['phone'] = $this->input->post('phone');
			}
			$user['password'] = very_random_string();
			
			$id = $this->user_model->create_user($user);
			
			$html .= p('Grattis, nu har du lagt till användaren '.$user['username'].'!', 'lead');
			$html .= p('Användaren registrerades med följande uppgifter:');
			$html .= ul(
				array(
					strong('Användarnamn:').nbs().$user['username'],
					strong('E-postadress:').nbs().mailto($user['email'], $user['email']),
					strong('Förnamn:').nbs().$user['firstname'],
					strong('Efternamn:').nbs().$user['lastname'],
					strong('Telefonnummer:').nbs().$user['phone']
				), array('class' => 'no-bullet'));
			$html .= p('Ett tillfälligt lösenord har skapats åt '.$user['username'].' som bara går att använda vid första inloggningen, se till att användaren får detta för att kunna logga in:');
			$html .= ul(array(strong($user['password'])), array('class' => 'no-bullet'));
			$html .= button_anchor('user/create', ucfirst(lang('create_another_user')));
		} else {
			$html .= p('Använd formuläret nedan för att lägga till en ny användare av '.$this->system_model->get('app_name').' hos '.$this->system_model->get('org_name').'.', 'lead');
			$html .= '<div class="row"><div class="eight centered columns">';
			$html .= form_open('user/create', array('class' => 'custom'));
			$html .= row(
				columns(
					form_label(ucfirst(lang('username')).':'.span('*', 'required'), 'username', array('class' => (form_error('email'))?'error':'')).
					form_input(array('type' => 'text', 'name' => 'username', 'id' => 'username', 'class' => (form_error('username'))?'expand error':'expand', 'value' => $this->input->post('username'))).form_error('username'), 6, 'end'));
			$html .= row(
				columns(
					form_label(ucfirst(lang('email_address')).':'.span('*', 'required'), 'email', array('class' => (form_error('email'))?'error':'')).
					form_input(array('type' => 'text', 'name' => 'email', 'id' => 'email', 'class' => (form_error('email'))?'expand error':'expand', 'value' => $this->input->post('email'))).form_error('email'), 6).
				columns(
					form_label(ucfirst(lang('phone_number')).':', 'phone').
					form_input(array('type' => 'text', 'name' => 'phone', 'id' => 'phone', 'class' => 'expand', 'value' => $this->input->post('phone'))), 6));
			$html .= row(
				columns(
					form_label(ucfirst(lang('firstname')).':', 'firstname').
					form_input(array('type' => 'text', 'name' => 'firstname', 'id' => 'firstname', 'class' => 'expand', 'value' => $this->input->post('firstname'))), 6).
				columns(
					form_label(ucfirst(lang('lastname')).':', 'lastname').
					form_input(array('type' => 'text', 'name' => 'lastname', 'id' => 'lastname', 'value' => $this->input->post('lastname'))), 6));
			$html .= button_group(array(button_anchor('admin/users', lang('button_cancel')), form_input(array('type' => 'submit', 'class' => 'button', 'value' => lang('button_save')))), 'right');
			$html .= form_close();
			$html .= '</div></div>';
		}
		
		$data['html'] = $html;
		$this->system_model->view('template', $data);
	}
	
	public function edit() {
		$this->output->enable_profiler(TRUE);
		if (!$this->auth->loggedin()) {
			redirect('user/login');
		}
		$uid = intval($this->auth->userid());
		$user = $this->user_model->get_user($uid);
		
		$data['title'] = $this->system_model->get('app_name');
		$html = heading(ucfirst(lang('edit_user')), 1);
		
		$html .= form_open('user/edit', array('class' => 'custom'));
		$html .= row(columns(form_label(ucfirst(lang('username')).':'.span('*', 'required'), 'username').
			form_input(array('type' => 'text', 'name' => 'username', 'id' => 'username', 'class' => 'expand')), 6, 'end'));
		$html .= row(columns(form_label(ucfirst(lang('email_address')).':'.span('*', 'required'), 'email').
			form_input(array('type' => 'email', 'name' => 'email', 'id' => 'email', 'class' => 'expand')), 6).
			columns(form_label(ucfirst(lang('phone_number')).':', 'phone').
			form_input(array('type' => 'text', 'name' => 'phone', 'id' => 'phone', 'class' => 'expand')), 6));
		$html .= row(
			columns(
				form_label(ucfirst(lang('firstname')).':', 'firstname').
				form_input(array('type' => 'text', 'name' => 'firstname', 'id' => 'firstname', 'class' => 'expand')), 6).
			columns(
				form_label(ucfirst(lang('lastname')).':', 'lastname').
				form_input(array('type' => 'text', 'name' => 'lastname', 'id' => 'lastname')), 6));
		$html .= button_group(array(button_anchor('admin/users', lang('button_cancel')), form_input(array('type' => 'submit', 'class' => 'button', 'value' => lang('button_save')))), 'right');
		$html .= form_close();
		$data['html'] = $html;
		$this->system_model->view('template', $data);
	}
	
	public function logout() {
		$this->user_model->set_inactive($user['id']);
		$this->auth->logout();
		redirect('user/login');
	}
}

?>