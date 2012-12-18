<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->language('klubb');
		$this->load->model('user_model');
	}

	public function index() {
		if (!$this->auth->loggedin()) {
			redirect('user/login');
		}
		$uid = intval($this->auth->userid());
		$user = $this->user_model->get_user($uid);
		
		$greeting = '';
		if (isset($user['firstname'])) {
			$greeting = ' '.$user['firstname'];
		} else {
			$greeting = ' '.$user['username'];
		}
		
		$data['title'] = $this->system_model->get('app_name');
		$data['breadcrumbs'] = array(array('data' => anchor('/', $this->system_model->get('app_name')), 'mode' => 'unavailable'), array('data' => anchor('home', ucfirst(lang('home'))), 'mode' => 'current'));
		
		$content = heading(ucfirst(lang('welcome')).$greeting.'!', 1);
		
		$html = row(columns($content, 12));
		$data['html'] = $html;
		$this->load->view('template', $data);
	}
}

?>