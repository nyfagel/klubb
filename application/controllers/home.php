<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->language('klubb');
		$this->load->model('user_model');
		$this->load->model('member_model');
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
		$ofeachtype = array();
		foreach ($this->member_model->get_types() as $type) {
			$count = $this->member_model->count_members_type($type['id']);
			array_push($ofeachtype, $count.' '.strtolower($type['plural']));
		}
		$memberdata .= p(ucfirst($this->system_model->get('org_name')).' har totalt '.anchor('members', $this->member_model->count_members().' '.lang('members')).' varav:');
		$memberdata .= ul($ofeachtype, array('class' => 'disc'));
		$memberdata .= button_group(array(button_anchor('members', ucfirst(lang('administer')).' '.lang('members'), 'small'),button_anchor('member/register', ucfirst(lang('register_member')), 'small')));
		
		$userdata = heading(ucfirst(lang('users')), 5);
		$userdata .= p(ucfirst($this->system_model->get('app_name')).' har totalt '.anchor('admin/users', $this->user_model->count_users().' '.lang('users')).'.');
		$active = $this->user_model->get_active();
		$ausers = array();
		foreach ($active as $aid) {
			$auser = $this->user_model->get_user($aid);
			array_push($ausers, $auser['firstname'].' '.$auser['lastname']);
		}
		$userdata .= heading('Inloggade just nu:', 6).ul($ausers, array('class' => 'disc'));
		$userdata .= button_group(array(button_anchor('admin/users', ucfirst(lang('administer')).' '.lang('users'), 'small'),button_anchor('user/create', ucfirst(lang('create_user')), 'small')));
		
		$content = heading(ucfirst(lang('welcome')).$greeting.'!', 1);
		$content .= row(columns(panel($memberdata, 'radius'), 6).columns(panel($userdata, 'radius'), 6));
		$content .= row(columns(panel('box3', 'radius'), 6).columns(panel('box4', 'radius'), 6));
		$html = $content;
		$data['html'] = $html;
		$this->system_model->view('template', $data);
	}
}

?>