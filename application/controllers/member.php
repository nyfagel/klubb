<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Member controller.
 * 
 * @extends CI_Controller
 * @version 0.1
 * @author Jan Lindblom <jan@nyfagel.se>
 * @copyright Copyright (c) 2012-2013 Ung Cancer.
 */
class Member extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->language('klubb');
		$this->load->model('system_model');
		$this->load->model('user_model');
		$this->load->model('member_model');
		$this->load->helper('html');
		$this->load->helper('form');
		
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('table');
		log_message('debug', 'Controller loaded: member');
	}
	
	public function memberlist($page = -1) {
		$this->output->enable_profiler(TRUE);
		if (!$this->auth->loggedin()) {
			redirect('user/login');
		}
		
		$limit = 15;
		
		$config['base_url'] = base_url('members/page');
		$config['total_rows'] = $this->member_model->count_members();
		$config['per_page'] = $limit;
		$config['use_page_numbers'] = true;
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="current"><a href="'.current_url().'">';
		$config['cur_tag_close'] = '</a></li>';
		$config['next_link'] = '&raquo;';
		$config['next_tag_open'] = '<li class="arrow">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li class="arrow">';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = false;
		$config['first_link'] = false;

		$this->pagination->initialize($config);
		
		$uid = intval($this->auth->userid());
		$user = $this->user_model->get_user($uid);
		
		$data['title'] = $this->system_model->get('app_name');
		$data['breadcrumbs'] = array(array('data' => anchor('/', $this->system_model->get('app_name')), 'mode' => 'unavailable'), array('data' => anchor('members', ucfirst(lang('members'))), 'mode' => 'current'));
		$html = heading(ucfirst(lang('members')), 1);
		// !TODO: generate users table
		
		$page = $this->uri->segment(3);
		$offset = -1;
		if (!is_null($page)) {
			$offset = intval($page) * $limit;
		}
		
		$tdata = array(array('Namn', 'Personnummer', 'Telefon'));
		$members = $this->member_model->list_members($offset, $limit);
		
		if (!empty($members)) {
			foreach ($members as $member) {
				array_push($tdata, array($member['firstname'].' '.$member['lastname'], $member['ssid'], $member['phone']));
			}
		} else {
			array_push($tdata, array(array('data' => 'Inget resultat!', 'colspan' => 3)));
		}
		
		$html .= $this->table->generate($tdata);
		$html .= $this->pagination->create_links();
		
		$data['html'] = $html;
		$this->system_model->view('template', $data);
	}
	
	public function register() {
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
		$data['breadcrumbs'] = array(array('data' => anchor('/', $this->system_model->get('app_name')), 'mode' => 'unavailable'), array('data' => anchor('members', ucfirst(lang('members')))), array('data' => anchor('member/register', ucfirst(lang('register_member'))), 'mode' => 'current'));
		
		$html = heading(ucfirst(lang('register_member')), 1);
		
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
			$html .= button_group(array(button_anchor('members', lang('button_cancel')), form_input(array('type' => 'submit', 'class' => 'button', 'value' => lang('button_save')))), 'right');
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
		$html = heading(ucfirst(lang('edit_member')), 1);
		
		$html .= form_open('member/register', array('class' => 'custom'));
		$html .= row(columns(form_label(ucfirst(lang('username')).':'.span('*', 'required'), 'username').
			form_input(array('type' => 'text', 'name' => 'username', 'id' => 'username', 'class' => 'expand', 'value' => $user['username'])), 6, 'end'));
		$html .= row(columns(form_label(ucfirst(lang('email_address')).':'.span('*', 'required'), 'email').
			form_input(array('type' => 'email', 'name' => 'email', 'id' => 'email', 'class' => 'expand', 'value' => $user['email'])), 6).
			columns(form_label(ucfirst(lang('phone_number')).':', 'phone').
			form_input(array('type' => 'text', 'name' => 'phone', 'id' => 'phone', 'class' => 'expand', 'value' => $user['phone'])), 6));
		$html .= row(
			columns(
				form_label(ucfirst(lang('firstname')).':', 'firstname').
				form_input(array('type' => 'text', 'name' => 'firstname', 'id' => 'firstname', 'class' => 'expand', 'value' => $user['firstname'])), 6).
			columns(
				form_label(ucfirst(lang('lastname')).':', 'lastname').
				form_input(array('type' => 'text', 'name' => 'lastname', 'id' => 'lastname', 'value' => $user['lastname'])), 6));
		$html .= button_group(array(button_anchor('members', lang('button_cancel')), form_input(array('type' => 'submit', 'class' => 'button', 'value' => lang('button_save')))), 'right');
		$html .= form_close();
		$data['html'] = $html;
		$this->system_model->view('template', $data);
	}
}

?>