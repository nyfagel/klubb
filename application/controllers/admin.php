<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->language('klubb');
		$this->load->model('user_model');
		$this->load->helper('form');
		$this->load->library('table');
	}

	public function index() {
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
			$row = array($user['id'], $user['username'], $user['firstname'].' '.$user['lastname'], mailto($user['email'],$user['email']), anchor('user/details/'.$user['id'], 'Visa'));
			array_push($tdata, $row);
		}
		$content .= row(columns(button_anchor('user/create', 'Skapa ny användare', 'small'), 12));
		$content .= row(columns($this->table->generate($tdata), 12));
		
		$html = $content;
		$data['html'] = $html;
		$this->system_model->view('template', $data);
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
		$call_org = ($this->system_model->get('org_type')) ? $this->system_model->get('org_type') : lang('organization');
		
		$data['title'] = $this->system_model->get('app_name');
		
		$data['breadcrumbs'] = array(array('data' => anchor('/', $this->system_model->get('app_name')), 'mode' => 'unavailable'), array('data' => anchor('admin', ucfirst(lang('administration')))), array('data' => anchor('admin/org', ucfirst(lang('the_organization'))), 'mode' => 'current'));
		
		$content = row(columns(heading(ucfirst(lang('administer')).' '.span($call_org, 'org_type', 'org_type').lang('org_pluralizer'), 1), 12));
		
		$content .= form_open('admin/org', array('class' => 'custom'));
		
		$content .= form_label(sprintf(lang('input_org_name'), $call_org), 'org_name');
		$content .= form_input(array('type' => 'text', 'name' => 'org_name', 'id' => 'org_name', 'class' => 'eight', 'value' => $this->system_model->get('org_name')));
		$content .= form_label(lang('input_app_name'), 'app_name');
		$content .= form_input(array('type' => 'text', 'name' => 'app_name', 'id' => 'app_name', 'class' => 'eight', 'value' => $this->system_model->get('app_name')));
		$content .= form_label(lang('input_org_type'), 'org_type');
		$content .= ($this->system_model->get('org_type')) ? form_input(array('type' => 'text', 'name' => 'org_type', 'id' => 'org_type', 'class' => 'eight', 'value' => $call_org)) : form_input(array('type' => 'text', 'name' => 'org_type', 'id' => 'org_type', 'class' => 'eight', 'placeholder' => $call_org));
		$content .= form_input(array('type' => 'submit', 'class' => 'button', 'value' => 'Spara'));
		$content .= form_close();
		$this->javascript->keyup('#org_type', '$("#org_name").val($("#org_type").val());');
		
		$html = $content;
		$data['html'] = $html;
		$this->system_model->view('template', $data);
	}
}

?>