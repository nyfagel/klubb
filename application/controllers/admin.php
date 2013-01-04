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
		$this->load->language('klubb');
		$this->load->model('user_model');
		$this->load->helper('form');
		$this->load->library('table');
		$this->load->library('form_validation');
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
		
		$content = row(columns(heading(ucfirst(lang('administer')).' '.lang('users'), 1), 12));
		$users = $this->user_model->list_users();
		$tdata = array(array('ID', 'Användarnamn', 'Namn', 'E-post', nbs()));
		foreach ($users as $user) {
			$row = array($user['id'], $user['username'], $user['firstname'].' '.$user['lastname'], mailto($user['email'], '<i class="general-foundicon-mail"></i>'.nbs().$user['email']), anchor('user/edit/'.$user['id'], '<i class="general-foundicon-edit"></i>'.nbs().'Visa').nbs().anchor(current_url().'#', '<i class="general-foundicon-trash"></i>'.nbs().'Ta bort'));
			array_push($tdata, $row);
		}
		$content .= row(columns(button_anchor('user/create', 'Skapa ny användare', 'small'), 12));
		$content .= row(columns($this->table->generate($tdata), 12));
		
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
		
		$content .= form_open('admin/org', array('class' => 'custom')).div_open('row').div_open('six columns');
		$content .= heading('Om '.$call_org.lang('org_pluralizer'), 3);
		$content .= form_label(sprintf(lang('input_org_name'), $call_org), 'org_name');
		$content .= form_input(array('type' => 'text', 'name' => 'org_name', 'id' => 'org_name', 'class' => (form_error('org_name'))?'twelve error':'twelve', 'value' => $org_name));
		$content .= form_label(lang('input_app_name'), 'app_name');
		$content .= form_input(array('type' => 'text', 'name' => 'app_name', 'id' => 'app_name', 'class' => (form_error('app_name'))?'twelve error':'twelve', 'value' => $app_name));
		$content .= form_label(lang('input_org_type'), 'org_type');
		$content .= ($org_type) ? form_input(array('type' => 'text', 'name' => 'org_type', 'id' => 'org_type', 'class' => 'twelve', 'value' => $call_org)) : form_input(array('type' => 'text', 'name' => 'org_type', 'id' => 'org_type', 'class' => 'twelve', 'placeholder' => $call_org));
		$content .= div_close().div_open('six columns');
		$content .= heading('Om '.lang('members').' '.lang('and').' '.lang('users'), 3);
		$content .= form_fieldset(ucfirst(lang('users')));
		
		$content .= form_fieldset_close();
		$content .= form_fieldset(ucfirst(lang('members')));
		
		$content .= form_fieldset_close();
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