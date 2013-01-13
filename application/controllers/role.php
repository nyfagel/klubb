<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'/libraries/REST_Controller.php');

/**
 * Role class.
 * 
 * @extends CI_Controller
 */
class Role extends REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('rights_model');
		$this->load->model('user_model');
		$this->load->helper('form');
		
		log_message('debug', 'Controller loaded: role');
	}
	
	/**
	 * rights_get function.
	 * 
	 * @access public
	 * @return void
	 */
	public function rights_get() {
		if (!$this->auth->loggedin()) {
			redirect('user/login');
		}
		$uid = intval($this->auth->userid());
		$user = $this->user_model->get_user($uid);
		
		
		$role_id = $this->get('role');
		if (!$role_id) {
			show_error('Invalid request.', 500);
		} else {
			$role_rights = $this->rights_model->get_for_role($role_id);
			$rights_html = ul(
				array(
					form_label(form_checkbox(array('name' => 'use_system', 'id' => 'use_system', 'value' => $role_id, 'checked' => ($role_rights['use_system'])?true:false)).nbs().ucfirst(lang('use_system')), 'use_system'),
					form_label(form_checkbox(array('name' => 'add_members', 'id' => 'add_members', 'value' => $role_id, 'checked' => ($role_rights['add_members'])?true:false)).nbs().ucfirst(lang('add_members')), 'add_members'),
					form_label(form_checkbox(array('name' => 'add_users', 'id' => 'add_users', 'value' => $role_id, 'checked' => ($role_rights['add_users'])?true:false)).nbs().ucfirst(lang('add_users')), 'add_users')
				),
				array('class' => 'no-bullet'));
			$this->output->set_output($rights_html);
		}
	}
}

?>