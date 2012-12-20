<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->language('klubb');
		$this->load->model('user_model');
	}

	public function index() {
		$this->output->enable_profiler(TRUE);
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
		
		$memberdata = heading(ucfirst(lang('members')), 5);
		$userdata = heading(ucfirst(lang('users')), 5);
		$userdata .= p(ucfirst($this->system_model->get('app_name')).' har totalt '.anchor('admin/users', $this->user_model->count_users().' '.lang('users')).'.');
		$active = $this->user_model->get_active();
		$ausers = array();
		foreach ($active as $aid) {
			$auser = $this->user_model->get_user($aid);
			array_push($ausers, $auser['firstname'].' '.$auser['lastname']);
		}
		$userdata .= heading('Inloggade just nu:', 6).ul($ausers, array('class' => 'disc'));
		
		$content = heading(ucfirst(lang('welcome')).$greeting.'!', 1);
		$content .= row(columns(panel($memberdata, 'radius'), 6).columns(panel($userdata, 'radius'), 6));
		$content .= row(columns(panel('box3', 'radius'), 6).columns(panel('box4', 'radius'), 6));
		$html = $content;
		$data['html'] = $html;
		$this->system_model->view('template', $data);
	}
}

?>