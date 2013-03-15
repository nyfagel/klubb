<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Member controller.
 *
 * @extends CI_Controller
 * @version 0.1
 * @author Jan Lindblom <jan@nyfagel.se>
 * @copyright Copyright (c) 2012-2013 Ung Cancer.
 */
class Member extends CI_Controller {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->load->language('klubb');
		$this->load->model('system_model');
		$this->load->model('user_model');
		$this->load->model('member_model');
		$this->load->helper('html');
		$this->load->helper('form');

		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('table');
		$this->load->library('javascript');
		log_message('debug', 'Controller loaded: member');
	}

	/**
	 * memberlist function.
	 *
	 * @access public
	 * @param float $page (default: -1)
	 * @return void
	 */
	public function memberlist() {
		$this->output->enable_profiler(false);
		if (!$this->auth->loggedin()) {
			redirect('user/login');
		}

		$uid = intval($this->auth->userid());
		$user = $this->user_model->get_user($uid);

		$data['title'] = $this->system_model->get('app_name');
		$data['breadcrumbs'] = array(
			array('data' => anchor('/', $this->system_model->get('app_name')), 'mode' => 'unavailable'),
			array('data' => anchor('members', ucfirst(lang('members'))), 'mode' => 'current'));
		$data['stylesheets'] = array('buttons_purple');
		$html = heading(ucfirst(lang('members')), 1);

		$membertypes = $this->member_model->get_types();
		$typeselect = array();
		$selected = ($this->input->get('type')) ? $this->input->get('type') : -1;
		if ($this->input->get('type')) {
			array_push($typeselect, form_label(form_input(array('type' => 'radio', 'value' => 'all', 'name' => 'type', 'id' => 'type0', 'onchange' => "window.location.href='/members'")).nbs().'Alla medlemmar'));
		} else {
			array_push($typeselect, form_label(form_input(array('type' => 'radio', 'checked' => 'checked', 'value' => 'all', 'name' => 'type', 'id' => 'type0', 'onchange' => "window.location.href='/members'")).nbs().'Alla medlemmar'));
		}
		
		foreach ($membertypes as $type) {
			$typeselectradio = array(
				'type' => 'radio',
				'value' => $type['id'],
				'name' => 'type',
				'id' => 'type'.$type['id'],
				'onchange' => "window.location.href='/members?type=".$type['id']."'"
			);
			if ($type['id'] == $selected) {
				$typeselectradio['checked'] = 'checked';
			}
			array_push($typeselect, form_label(form_input($typeselectradio).nbs().$type['plural']));
		}
		$typeselect = ul($typeselect, array('class' => 'inline-list'));
		
		$data['filters'] = 
			row(
				columns(
					form_open('members').row(
					columns(
						form_input(
							array(
								'type' => 'text',
								'name' => 'q',
								'id' => 'q',
								'placeholder' => 'Sök fritt bland alla medlemmar!'
							)
						), 10).
					columns(
						form_input(
							array(
								'type' => 'submit',
								'value' => 'Sök',
								'class' => 'postfix button'
							)
						), 2
					), 'collapse').form_close(), 6, 'centered'
				)
			, 'search', 'search-bar');//.
//			row(
	//		columns(
		//		form_open('/members', array('class' =>'custom')).$typeselect.form_close(), 12));
//		$colspan = 3;
//		if ($selected == 1) {
			$tdata = array(array('Medlemstyp', 'Namn', 'Cancersjukdom', 'Diagnosår', 'Kön', 'E-post', 'Adress', 'Telefon', 'Personnummer'));
			$colspan = 6;
//		} else if ($selected == 2) {
//			$tdata = array(array('Namn', 'Personnummer', 'Telefon', 'Ort', 'Anhörig'));
//			$colspan = 5;
//		} else {
//			$tdata = array(array('Namn', 'E-post'));
//			$colspan = 2;
//		}
		
		$members = $this->member_model->list_members($selected);

		if (!empty($members)) {
			foreach ($members as $member) {
//				if ($selected == 1) {
					array_push($tdata, array($membertypes[($member['type']-1)]['short'], $member['firstname'].' '.$member['lastname'], $member['cancer'], $member['diagnos'], $member['sex'], $member['email'], $member['address'], $member['phone'], $member['ssid']));
//				} else if ($selected == 2) {
//					array_push($tdata, array($member['firstname'].' '.$member['lastname'], $member['ssid'], $member['phone'], $member['city'], $member['relation']));
//				} else {
//					array_push($tdata, array($member['firstname'].' '.$member['lastname'], $member['email']));
//				}
				
			}
		} else {
			array_push($tdata, array(array('data' => 'Inget resultat!', 'colspan' => $colspan)));
		}

		$this->table->set_template(array('table_open' => '<table class="expand" id="members">'));
		$data['table'] = $this->table->generate($tdata);
		$this->javascript->ready('$("#members").tablesorter({usNumberFormat: false, widgets: ["filter", "zebra"]}); $("#members").tablesorterPager({container: $("#pager"), size: 2});');
		//  $html .= $this->pagination->create_links();
		$data['partial'] = 'members';
		$this->system_model->view('template', $data);
	}

	/**
	 * register function.
	 *
	 * @access public
	 * @return void
	 */
	public function register() {
		$this->output->enable_profiler(false);
		if (!$this->auth->loggedin()) {
			redirect('user/login');
		}
		$uid = intval($this->auth->userid());
		$user = $this->user_model->get_user($uid);
		$ajax = ($this->input->get('ajax')) ? true : false;
		
		$type = ($this->input->post('type')) ? $this->input->post('type') : false;
		$member = array();
		if ($type) {
			$reqs = $this->member_model->get_type_requirements($type);
			foreach ($reqs as $req) {
				$this->form_validation->set_rules($req['fieldname'], $req['fieldname'], 'trim|'.$req['rule']);
				$member[$req['fieldname']] = ($this->input->post($req['fieldname'])) ? $this->input->post($req['fieldname']) : null;
			}
		}

		$this->form_validation->set_error_delimiters('<small class="error">', '</small>');

		$data['title'] = $this->system_model->get('app_name');
		$data['breadcrumbs'] = array(array('data' => anchor('/', $this->system_model->get('app_name')), 'mode' => 'unavailable'), array('data' => anchor('members', ucfirst(lang('members')))), array('data' => anchor('member/register', ucfirst(lang('register_member'))), 'mode' => 'current'));
		$data['stylesheets'] = array('buttons_purple');

		$html = heading(ucfirst(lang('register_member')), 1);

		if ($this->form_validation->run() == true) {
			$member['type'] = $type;
			$newid = $this->member_model->create_member($member);
			$member = $this->member_model->get_member($newid);
			$membertype = $this->member_model->get_type($type);
			$html .= p('Grattis, nu har du lagt till '.$member['firstname'].' '.$member['lastname'].' som '.$membertype['name'].'!', 'lead');
			$html .= p($member['firstname'].' '.'registrerades med följande uppgifter:');
			$html .= ul(
				array(
					strong('Namn:').nbs().$member['firstname'].' '.$member['lastname'],
					strong('E-postadress:').nbs().mailto($member['email'], $member['email']),
					strong('Telefonnummer:').nbs().$member['phone']
				), array('class' => 'no-bullet'));
			$html .= button_anchor('member/register', ucfirst(lang('register_another_member')), 'radius');
			$tabs = '';
		} else {
			$tabs = array();
			$first = true;
			$membertypes = $this->member_model->get_types();
			foreach ($membertypes as $type) {
				$tabs['type'.$type['id']] = array(
					'title' => $type['name'],
					'content' => $this->registration_form($type['id']));
				if ($first) {
					$tabs['type'.$type['id']]['active'] = true;
					$first = false;
				}
			}
			$tabs = tabs($tabs, 'contained', 'register');
			$data['partial'] = 'register_member';
		}
		$data['ajax'] = $ajax;
		$data['html'] = $html;
		$data['tabs'] = $tabs;
		$data['org_name'] = $this->system_model->get('org_name');
		
		//  $this->javascript->ready('$(".gridster ul").gridster({widget_margins: [10, 10], widget_base_dimensions: [14, 14]});');
		if ($ajax) {
			$this->system_model->view('ajax', $data);
		} else {
			$this->system_model->view('template', $data);
		}
	}

	/**
	 * registration_form function.
	 *
	 * @access private
	 * @return void
	 */
	private function registration_form($type = -1) {
		$html = form_open('member/register', array('class' => 'custom'));
		$html .= '<div class="row"><div class="eight columns">';
		$side = '';
		$main = '<div class="gridster"><ul class="no-bullet">';
		$html .= form_hidden('type', $type);

		$reqs = $this->member_model->get_type_requirements($type);
		log_message('debug', print_r($reqs, true));
		foreach ($reqs as $field) {
			if ($field['rule'] == 'optional') {
				$side .= $this->format_input_field($field);
			} else {
				$main .= '<li data-row="'.$field['row'].'" data-col="'.$field['column'].'"  data-sizex="1" data-sizey="1" class="six columns">'.$this->format_input_field($field).'</li>';
			}
		}

		$html .= $main.'</ul></div>';
		$html .= row(columns(button_group(
					array(
						button_anchor('members', lang('button_cancel'), 'radius'),
						form_input(
							array(
								'type' => 'submit',
								'class' => 'radius button',
								'value' => lang('button_save')))), 'radius left'), 12));
		$html .= '</div><div class="four columns">';
		$html .= $side;
		$html .= '</div></div>';

		/*
		$html .= row(
			columns(
				form_label(
					ucfirst(lang('ssid')).':'.span('*', 'required'),
					'ssid',
					array('class' => (form_error('ssid'))?'error':'')).
				form_input(array(
						'type' => 'text',
						'name' => 'ssid',
						'id' => 'ssid',
						'class' => (form_error('ssid'))?'expand error':'expand',
						'value' => $this->input->post('ssid'),
						'placeholder' => lang('ssid_placeholder'),
						'size' => 10,
						'maxlength' => 10)).
				form_error('ssid'), 6, 'end'));
*/
		/*
		$html .= row(
			columns(
				form_label(
					ucfirst(lang('firstname')).':'.span('*', 'required'),
					'firstname').
				form_input(array(
						'type' => 'text',
						'name' => 'firstname',
						'id' => 'firstname',
						'class' => 'expand',
						'value' => $this->input->post('firstname'))).
				form_error('firstname'), 6).
			columns(
				form_label(
					ucfirst(lang('lastname')).':'.span('*', 'required'),
					'lastname').
				form_input(array(
						'type' => 'text',
						'name' => 'lastname',
						'id' => 'lastname',
						'value' => $this->input->post('lastname'))).
				form_error('lastname'), 6), 'name', 'name_row');
*/
		/*

		$html .= row(
			columns(
				form_label(ucfirst(lang('email_address')).':'.span('*', 'required'), 'email', array('class' => (form_error('email'))?'error':'')).
				form_input(array('type' => 'email', 'name' => 'email', 'id' => 'email', 'class' => (form_error('email'))?'expand error':'expand', 'value' => $this->input->post('email'))).form_error('email'), 6).
			columns(
				form_label(ucfirst(lang('phone_number')).':'.span('*', 'required'), 'phone').
				form_input(array('type' => 'tel', 'name' => 'phone', 'id' => 'phone', 'class' => 'expand', 'value' => $this->input->post('phone'))), 6));
		$html .= row(
			columns(
				form_label(ucfirst(lang('address')).':'.span('*', 'required'), 'address', array('class' => (form_error('address'))?'error':'')).
				form_input(array('type' => 'text', 'name' => 'address', 'id' => 'address', 'value' => $this->input->post('address'), 'class' => (form_error('address'))?'expand error':'expand')).form_error('adress'), 6, 'end'));
		$html .= row(
			columns(form_label(ucfirst(lang('zipcode')).':'.span('*', 'required'), 'zipcode', array('class' => (form_error('zipcode'))?'error':'')).
				form_input(array('type' => 'text', 'name' => 'zipcode', 'id' => 'zipcode', 'value' => $this->input->post('zipcode'), 'class' => (form_error('zipcode'))?'expand error':'expand')).form_error('zipcode'), 2).
			columns(form_label(ucfirst(lang('city')).':'.span('*', 'required'), 'city', array('class' => (form_error('city'))?'error':'')).
				form_input(array('type' => 'text', 'name' => 'city', 'id' => 'city', 'value' => $this->input->post('city'), 'class' => (form_error('city'))?'expand error':'expand')).form_error('city'), 4, 'end'));
		$html .= row(
			columns(
				form_label('Diagnos år:'.span('*', 'required'), 'diagnos', array('class' => (form_error('diagnos'))?'error':'')).
				form_input(array('type' => 'text', 'name' => 'diagnos', 'id' => 'diagnos', 'class' => (form_error('diagnos'))?'expand error':'expand', 'value' => $this->input->post('diagnos'))).form_error('diagnos'), 6).
			columns(
				form_label('Cancersjukdom:'.span('*', 'required'), 'cancer').
				form_input(array('type' => 'text', 'name' => 'cancer', 'id' => 'cancer', 'class' => 'expand', 'value' => $this->input->post('cancer'))).form_error('cancer'), 6));
		$html .= button_group(
			array(
				button_anchor('members', lang('button_cancel'), 'radius'),
				form_input(array('type' => 'submit', 'class' => 'radius button', 'value' => lang('button_save')))), 'radius left');
		$html .= '</div><div class="four columns">';
		$html .= heading('Kan tänka sig att', 6);
		$html .= form_label(form_checkbox(array('type' => 'checkbox', 'name' => 'tell', 'id' => 'tell')).nbs().'berätta min historia på ungcancer.se för andra att ta del av', 'tell');
		$html .= form_label(form_checkbox(array('type' => 'checkbox', 'name' => 'participate', 'id' => 'participate')).nbs().'delta på möten, föreläsningar och/eller andra aktiviteter', 'participate');
		$html .= form_label(form_checkbox(array('type' => 'checkbox', 'name' => 'talking_partner', 'id' => 'talking_partner')).nbs().'bli samtalsvän och låta Ung Cancer ge ut min mailadress till andra medlemmar', 'talking_partner');
		$html .= '<hr>';
		$html .= form_label(ucfirst(lang('other')).':', 'other').form_textarea(array('name' => 'other', 'id' => 'other'));
*/
		//   $html .= form_fieldset_close();
		/*			$html .= row(
				columns(
					form_label(ucfirst(lang('address')).':'.span('*', 'required'), 'address' array('class' => (form_error('address'))?'error':'')).
					form_input(array('type' => 'text', 'name' => 'address', 'id' => 'address', 'value' => $this->input->post('address'), 'class' => (form_error('address'))?'expand error':'expand')), 8, 'end')).
			row(
				columns(
					form_label(ucfirst(lang('address')).':'.span('*', 'required'), 'address' array('class' => (form_error('address'))?'error':'')).
					form_input(array('type' => 'text', 'name' => 'address', 'id' => 'address', 'value' => $this->input->post('address'), 'class' => (form_error('address'))?'expand error':'expand')), 8, 'end')
			);
			*/
		$html .= form_close();
		return $html;
	}

	/**
	 * format_input_field function.
	 *
	 * @access private
	 * @param array $data (default: array())
	 * @return void
	 */
	private function format_input_field($data = array()) {
		if (empty($data)) {
			return null;
		}
		$html = '';

		if ($data['fieldtype'] == 'textarea') {
			$html .= form_label(ucfirst(lang($data['fieldname'])).':'.span('*', $data['rule']), 'type'.$data['type'].$data['fieldname']);
			$html .= form_textarea(
				array(
					'name' => $data['fieldname'],
					'id' => 'type'.$data['type'].$data['fieldname'],
					'placeholder' => $data['placeholder'],
					'value' => $this->input->post($data['fieldtype'])
				)
			);
		} else if ($data['fieldtype'] == 'checkbox') {
				$html .= form_label(
					form_checkbox(
						array(
							'type' => 'checkbox',
							'name' => $data['fieldname'],
							'id' => 'type'.$data['type'].$data['fieldname']
						)
					).nbs().lang($data['fieldname']), 'type'.$data['type'].$data['fieldname']);
			} else {
			$html .= form_label(ucfirst(lang($data['fieldname'])).':'.span('*', $data['rule']), 'type'.$data['type'].$data['fieldname']);
			$html .= form_input(
				array(
					'type' => $data['fieldtype'],
					'name' => $data['fieldname'],
					'id' => 'type'.$data['type'].$data['fieldname'],
					'placeholder' => $data['placeholder'],
					'class' => 'expand',
					'value' => $this->input->post($data['fieldtype'])
				)
			);
		}
		$html .= form_error($data['fieldname']);

		return $html;
	}

	/**
	 * edit function.
	 *
	 * @access public
	 * @return void
	 */
	public function edit() {
		$this->output->enable_profiler(false);
		if (!$this->auth->loggedin()) {
			redirect('user/login');
		}
		$uid = intval($this->auth->userid());
		$user = $this->user_model->get_user($uid);

		$data['title'] = $this->system_model->get('app_name');
		$html = heading(ucfirst(lang('edit_member')), 1);

		$html .= form_open('member/register', array('class' => 'custom'));
		$html .= row(columns(form_label(ucfirst(lang('username')).':'.span('*', 'required'), 'username').
				form_input(array('type' => 'text', 'name' => 'username', 'id' => 'username', 'class' => 'expand', 'value' => $user['username'])), 6, 'end'));
		$html .= row(columns(form_label(ucfirst(lang('email_address')).':'.span('*', 'required'), 'email').
				form_input(array('type' => 'email', 'name' => 'email', 'id' => 'email', 'class' => 'expand', 'value' => $user['email'])), 6).
			columns(form_label(ucfirst(lang('phone_number')).':', 'phone').
				form_input(array('type' => 'text', 'name' => 'phone', 'id' => 'phone', 'class' => 'expand', 'value' => $user['phone'])), 6));
		$html .= row(
			columns(
				form_label(ucfirst(lang('firstname')).':', 'firstname').
				form_input(array('type' => 'text', 'name' => 'firstname', 'id' => 'firstname', 'class' => 'expand', 'value' => $user['firstname'])), 6).
			columns(
				form_label(ucfirst(lang('lastname')).':', 'lastname').
				form_input(array('type' => 'text', 'name' => 'lastname', 'id' => 'lastname', 'value' => $user['lastname'])), 6));
		$html .= button_group(array(button_anchor('members', lang('button_cancel')), form_input(array('type' => 'submit', 'class' => 'button', 'value' => lang('button_save')))), 'right');
		$html .= form_close();
		$data['html'] = $html;
		$this->system_model->view('template', $data);
	}
}

?>