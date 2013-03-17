<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Home class.
 * 
 * @extends CI_Controller
 * @version 0.1
 * @author Jan Lindblom <jan@nyfagel.se>
 * @copyright Copyright (c) 2012-2013 Ung Cancer.
 */
class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('member_model');
		log_message('debug', 'Controller loaded: home');
	}

	/**
	 * index function.
	 * 
	 * @access public
	 * @return void
	 */
	public function index() {
		$this->output->enable_profiler(false);
		$this->benchmark->mark('auth_start');
		if (!$this->auth->loggedin()) {
			redirect('user/login');
		}
		$uid = intval($this->auth->userid());
		$this->benchmark->mark('auth_end');
		$user = $this->user_model->get_user($uid);
		
		$greeting = '';
		if (isset($user['firstname'])) {
			$greeting = ' '.$user['firstname'];
			$data['firstname'] = $user['firstname'];
		} else {
			$greeting = ' '.$user['username'];
			$data['firstname'] = $user['firstname'];
		}
		
		$data['title'] = $this->system_model->get('app_name');
		$data['stylesheets'] = array('buttons_purple');
		$data['partial'] = 'home';
		
		$data['org_name'] = $this->system_model->get('org_name');
		$data['app_name'] = $this->system_model->get('app_name');
		
		$data['members'] = $this->member_model->count_members();
		$data['users'] = $this->user_model->count_users();
		
		$memberdata = heading(ucfirst(lang('members')), 5);
		$ofeachtype = array();
		$this->benchmark->mark('members_process_start');
		foreach ($this->member_model->get_types() as $type) {
			$count = $this->member_model->count_members_type($type['id']);
			array_push($ofeachtype, $count.' '.strtolower($type['plural']));
		}
		$data['membertypes'] = $ofeachtype;
		$memberdata .= p(ucfirst($data['org_name']).' har totalt '.anchor('members', $data['members'].' '.lang('members')).' varav:');
		$memberdata .= ul($data['membertypes'], array('class' => 'disc'));
		$memberdata .= button_group(
			array(
				button_anchor('members', ucfirst(lang('administer')).' '.lang('members'), 'radius'),
				button_anchor('member/register', ucfirst(lang('register_member')), 'radius')), 'radius');
		$this->benchmark->mark('members_process_end');
		$userdata = heading(ucfirst(lang('users')), 5);
		$this->benchmark->mark('users_process_start');
		$userdata .= p(ucfirst($data['app_name']).' har totalt '.anchor('admin/users', $data['users'].' '.lang('users')).'.');
		$active = $this->user_model->get_active();
		$ausers = array();
		foreach ($active as $aid) {
			$auser = $this->user_model->get_user($aid);
			array_push($ausers, $auser['firstname'].' '.$auser['lastname']);
		}
		$data['loggedon'] = $ausers;
		
		$userdata .= heading(ucfirst(lang('currently_logged_on')).':', 6).ul($ausers, array('class' => 'disc'));
		$userdata .= button_group(
			array(
				button_anchor('admin/users', ucfirst(lang('administer')).' '.lang('users'), 'radius'),
				button_anchor('user/create', ucfirst(lang('create_user')), 'radius')), 'radius');
		$this->benchmark->mark('users_process_end');
		$content = heading(ucfirst(lang('welcome')).$greeting.'!', 1);
		$content .= row(columns($memberdata, 6).columns($userdata, 6));
		$html = $content;
		$data['html'] = $html;
		$this->system_model->view('template', $data);
	}
}

?>