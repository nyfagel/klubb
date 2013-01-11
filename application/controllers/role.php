<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Role class.
 * 
 * @extends CI_Controller
 */
class Role extends REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->language('klubb');
		$this->load->model('role_model');
		$this->load->model('rights_model');
		$this->load->helper('html');
		
		log_message('debug', 'Controller loaded: role');
	}
	
	/**
	 * role_rights function.
	 * 
	 * @access public
	 * @return void
	 */
	public function role_rights_get() {
		$role_id = $this->get('role');
		if (!$role_id) {
			show_error(ucfirst(lang('system_error')), 500);
		} else {
			$role_rights = $this->rights_model->get_for_role($default_role['id']);
			$rights_html = ul(
				array(
					form_label(form_checkbox(array('name' => 'use_system', 'id' => 'use_system', 'value' => $default_role['id'], 'checked' => ($role_rights['use_system'])?true:false)).nbs().ucfirst(lang('use_system')), 'use_system'),
					form_label(form_checkbox(array('name' => 'add_members', 'id' => 'add_members', 'value' => $default_role['id'], 'checked' => ($role_rights['add_members'])?true:false)).nbs().ucfirst(lang('add_members')), 'add_members'),
					form_label(form_checkbox(array('name' => 'add_users', 'id' => 'add_users', 'value' => $default_role['id'], 'checked' => ($role_rights['add_users'])?true:false)).nbs().ucfirst(lang('add_users')), 'add_users')
				),
				array('class' => 'no-bullet'));
			$this->output->set_output($rights_html);
		}
	}
}

?>