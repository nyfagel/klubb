<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->language('klubb');
		$this->load->model('system_model');
		$this->load->model('user_model');
		$this->load->helper('html');
		$this->load->helper('form');
		
		$this->load->library('javascript');
	}

	public function login() {
		if ($this->auth->loggedin()) {
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
		
		$data['title'] = "Medlemsregistret";
		
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
	
	public function logout() {
		$this->auth->logout();
		redirect('user/login');
	}
}

?>