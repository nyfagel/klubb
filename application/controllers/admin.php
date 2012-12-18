<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

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
		
		$data['title'] = "Medlemsregistret";
		
		$content = heading(ucfirst(lang('welcome')).$greeting.'!', 1);
		
		$html = row(columns($content, 12));
		$data['html'] = $html;
		$this->load->view('template', $data);
	}
	
	public function org() {
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
		
		$content = row(columns(heading(ucfirst(lang('welcome')).$greeting.'!', 1),12));
		$content .= row(columns(breadcrumbs(array(array('data' => anchor('admin', ucfirst(lang('administration')))), array('data' => anchor('admin/org', ucfirst(lang('the_organization'))), 'mode' => 'current'))),12));
		$html = $content;
		$data['html'] = $html;
		$this->load->view('template', $data);
	}
}

?>