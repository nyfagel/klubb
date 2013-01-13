<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin controller.
 * 
 * @extends CI_Controller
 * @version 0.1
 * @author Jan Lindblom <jan@nyfagel.se>
 * @copyright Copyright (c) 2012-2013 Ung Cancer.
 */
class Admin extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('role_model');
		$this->load->model('rights_model');
		
		$this->load->helper('form');
		$this->load->helper('url');
		
		$this->load->library('table');
		$this->load->library('form_validation');
		
		log_message('debug', 'Controller loaded: admin');
	}

	public function index() {
		$this->output->enable_profiler(TRUE);
		if (!$this->auth->loggedin()) {
			redirect('user/login');
		}
		$uid = intval($this->auth->userid());
		$user = $this->user_model->get_user($uid);
		
		$data['title'] = $this->system_model->get('app_name');
		
		$data['breadcrumbs'] = array(array('data' => anchor('/', $this->system_model->get('app_name')), 'mode' => 'unavailable'), array('data' => anchor('admin', ucfirst(lang('administration'))), 'mode' => 'current'));
		
		$content = row(columns(heading(ucfirst(lang('administration')), 1), 12));
		
		$html = $content;
		$data['html'] = $html;
		$this->system_model->view('template', $data);
	}
	
	public function users() {
		$this->output->enable_profiler(TRUE);
		if (!$this->auth->loggedin()) {
			redirect('user/login');
		}
		$uid = intval($this->auth->userid());
		$user = $this->user_model->get_user($uid);
		
		$data['title'] = $this->system_model->get('app_name');
		
		$data['breadcrumbs'] = array(array('data' => anchor('/', $this->system_model->get('app_name')), 'mode' => 'unavailable'), array('data' => anchor('admin', ucfirst(lang('administration')))), array('data' => anchor('admin/users', ucfirst(lang('users'))), 'mode' => 'current'));
		
		$allroles = $this->role_model->list_roles();
		$default_role = $this->role_model->get_default_role();
		$this->javascript->ready('$.get("/role/rights/role/'.$default_role['id'].'", function(html) { $("#role_rights_div").html(html); $("#role_rights_div").foundationCustomForms(); }, "html");');
		
		$content = row(columns(heading(ucfirst(lang('administer')).' '.lang('users'), 1), 12));
		$users = $this->user_model->list_users();
		$tdata = array(array(ucfirst(lang('name')), ucfirst(lang('role')), ucfirst(lang('email')), nbs()));
		foreach ($users as $user) {
			$role = $this->role_model->user_mapping($user['id']);
			$role = $this->role_model->get_role($role['role']);
			$row = array(
				$user['firstname'].' '.$user['lastname'],
				form_open('user/role', array('class' => 'custom collapse', 'style' => 'margin: 0;')).
					form_hidden('role_'.$user['id'], $role['id']).
					form_hidden('source', $this->encrypt->encode(current_url())).
					form_dropdown('user_role_'.$user['id'], $allroles, $role['id'], 'class="expand" style="margin: 0;"').form_close(),
				mailto($user['email'],
				'<i class="general-foundicon-mail"></i>'.nbs().$user['email']),
				anchor('user/edit/'.$user['id'], '<i class="general-foundicon-edit"></i>'.nbs().'Visa').nbs().
				anchor(current_url().'#', '<i class="general-foundicon-trash"></i>'.nbs().'Ta bort'));
			array_push($tdata, $row);
		}
		
		$roles = div_open('radius panel').heading('Användarroller', 4).
			form_open('role/add', array('class' => 'custom')).
			form_hidden('source', $this->encrypt->encode(current_url())).
			form_label('Skapa ny roll:', 'new_role_name').
			form_input(array('type' => 'text', 'name' => 'new_role_name', 'id' => 'new_role_name')).
			form_submit(array('type' => 'submit', 'name' => 'submit_new_role', 'id' => 'submit_new_role', 'class' => 'small button', 'value' => 'Skapa roll')).
			form_close().
			hr().
			form_open('role/update', array('class' => 'custom')).
			form_hidden('source', $this->encrypt->encode(current_url())).
			form_label('Uppdatera befintlig roll:', 'select_role').
			form_dropdown('select_role', $allroles, $default_role['id'], 'class="expand" onchange="switchRole(this);"').
			form_fieldset('Rättigheter för &ldquo;'.span($default_role['name'], '', 'role_name_span').'&rdquo;').
			div('','','role_rights_div').
			form_fieldset_close().
			button_group(array(form_submit(array('type' => 'submit', 'name' => 'submit_update_role', 'id' => 'submit_update_role', 'class' => 'small button', 'value' => 'Uppdatera roll')), form_button(array('type' => 'button', 'name' => 'delete_role', 'id' => 'delete_role', 'content' => 'Radera roll', 'class' => 'small button')))).
			form_close().
			div_close();
		
		$content .= row(
			columns($this->table->generate($tdata).button_group(array(button_anchor('user/create', 'Skapa ny användare', 'small'))), 8).
			columns($roles, 4));
		
		$html = $content;
		$data['html'] = $html;
		$this->system_model->view('template', $data);
	}
	
	public function org() {
		$this->output->enable_profiler(TRUE);
		if (!$this->auth->loggedin()) {
			redirect('user/login');
		}
		$uid = intval($this->auth->userid());
		$user = $this->user_model->get_user($uid);
		
		$this->form_validation->set_rules('org_name', lang('org_name'), 'trim|required');
		$this->form_validation->set_rules('app_name', lang('app_name'), 'trim|required');
		
		if ($this->form_validation->run() == true) {
			if ($this->input->post('org_name') && strlen($this->input->post('org_name')) > 0) {
				$this->system_model->set('org_name', $this->input->post('org_name'));
			}
			if ($this->input->post('app_name') && strlen($this->input->post('app_name')) > 0) {
				$this->system_model->set('app_name', $this->input->post('app_name'));
			}
			if ($this->input->post('org_type') && strlen($this->input->post('org_type')) > 0) {
				$this->system_model->set('org_type', $this->input->post('org_type'));
			}
		}
		
		$org_type = $this->system_model->get('org_type');
		$app_name = $this->system_model->get('app_name');
		$org_name = $this->system_model->get('org_name');
		
		$call_org = ($org_type) ? $org_type : lang('organization');
		
		$data['title'] = $app_name;
		
		$data['breadcrumbs'] = array(array('data' => anchor('/', $app_name), 'mode' => 'unavailable'), array('data' => anchor('admin', ucfirst(lang('administration')))), array('data' => anchor('admin/org', ucfirst(lang('the_organization'))), 'mode' => 'current'));
		
		$content = row(columns(heading(ucfirst(lang('administer')).' '.span($call_org, 'org_type', 'org_type').lang('org_pluralizer'), 1), 12));
		
		$content .= form_open('admin/org', array('class' => 'custom')).div_open('row').div_open('six columns end');
		$content .= form_label(sprintf(lang('input_org_name'), $call_org), 'org_name');
		$content .= form_input(array('type' => 'text', 'name' => 'org_name', 'id' => 'org_name', 'class' => (form_error('org_name'))?'twelve error':'twelve', 'value' => $org_name));
		$content .= form_label(lang('input_app_name'), 'app_name');
		$content .= form_input(array('type' => 'text', 'name' => 'app_name', 'id' => 'app_name', 'class' => (form_error('app_name'))?'twelve error':'twelve', 'value' => $app_name));
		$content .= form_label(lang('input_org_type'), 'org_type');
		$content .= ($org_type) ? form_input(array('type' => 'text', 'name' => 'org_type', 'id' => 'org_type', 'class' => 'twelve', 'value' => $call_org)) : form_input(array('type' => 'text', 'name' => 'org_type', 'id' => 'org_type', 'class' => 'twelve', 'placeholder' => $call_org));
		$content .= div_close(2);
		$content .= form_input(array('type' => 'submit', 'class' => 'button', 'value' => lang('button_save')));
		$content .= form_close();
		$this->javascript->keyup('#org_type', '$("#org_name").val($("#org_type").val());');
		
		$html = $content;
		$data['html'] = $html;
		$this->system_model->view('template', $data);
	}
}

?>