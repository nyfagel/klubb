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
    public function memberlist($page = -1) {
        $this->output->enable_profiler(false);
        if (!$this->auth->loggedin()) {
            redirect('user/login');
        }

        $limit = 15;

        $config['base_url'] = base_url('members/page');
        $config['total_rows'] = $this->member_model->count_members();
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = true;
        $config['uri_segment'] = 3;
        $config['num_links'] = 2;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="current"><a href="'.current_url().'">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="arrow">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="arrow">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['last_link'] = false;
        $config['first_link'] = false;

        $this->pagination->initialize($config);

        $uid = intval($this->auth->userid());
        $user = $this->user_model->get_user($uid);

        $data['title'] = $this->system_model->get('app_name');
        $data['breadcrumbs'] = array(
            array('data' => anchor('/', $this->system_model->get('app_name')), 'mode' => 'unavailable'),
            array('data' => anchor('members', ucfirst(lang('members'))), 'mode' => 'current'));
        $data['stylesheets'] = array('buttons_purple');
        $html = heading(ucfirst(lang('members')), 1);
        // !TODO: generate users table

        $page = $this->uri->segment(3);
        $offset = -1;
        if (!is_null($page)) {
            $offset = intval($page) * $limit;
        }

        $tdata = array(array('Namn', 'Personnummer', 'Telefon'));
        $members = $this->member_model->list_members($offset, $limit);

        if (!empty($members)) {
            foreach ($members as $member) {
                array_push($tdata, array($member['firstname'].' '.$member['lastname'], $member['ssid'], $member['phone']));
            }
        } else {
            array_push($tdata, array(array('data' => 'Inget resultat!', 'colspan' => 3)));
        }

        $html .= $this->table->generate($tdata);
        $html .= $this->pagination->create_links();

        $data['html'] = $html;
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

        $type = ($this->input->post('type')) ? $this->input->post('type') : false;

        if ($type) {
            $requirements = $this->member_model->get_type_required_fields($type);
            foreach ($requirements as $req) {
                // !TODO: Add requirement parsing and apply rules accordingly!
            }
        }
        /*
		$this->form_validation->set_rules('firstname', ucfirst(lang('firstname')), 'trim|required');
		$this->form_validation->set_rules('lastname', ucfirst(lang('lastname')), 'trim|required');
		$this->form_validation->set_rules('email', ucfirst(lang('email_address')), 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_message('is_unique', '%s finns redan i systemet.');
*/

        $this->form_validation->set_error_delimiters('<small class="error">', '</small>');

        $data['title'] = $this->system_model->get('app_name');
        $data['breadcrumbs'] = array(array('data' => anchor('/', $this->system_model->get('app_name')), 'mode' => 'unavailable'), array('data' => anchor('members', ucfirst(lang('members')))), array('data' => anchor('member/register', ucfirst(lang('register_member'))), 'mode' => 'current'));
        $data['stylesheets'] = array('buttons_purple');

        $html = heading(ucfirst(lang('register_member')), 1);

        if ($this->form_validation->run() == true) {
            $member = array();
            $html .= p('Grattis, nu har du lagt till '.$member['firstname'].' '.$member['lastname'].' som '.$membertype['name'].'!', 'lead');
            $html .= p($member['firstname'].' '.'registrerades med följande uppgifter:');
            $html .= ul(
                array(
                    strong('Namn:').nbs().$member['firstname'].' '.$member['lastname'],
                    strong('E-postadress:').nbs().mailto($member['email'], $member['email']),
                    strong('Telefonnummer:').nbs().$member['phone']
                ), array('class' => 'no-bullet'));
            $html .= button_anchor('member/register', ucfirst(lang('register_another_member')));
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
	        $html .= $tabs['tabs'].$tabs['content'];
//	        $html .= $this->registration_form();
        }

        $data['html'] = $html;
        $this->system_model->view('template', $data);
    }

    /**
     * registration_form function.
     * 
     * @access private
     * @return void
     */
    private function registration_form($type = -1) {
        $html = p('Använd formuläret nedan för att lägga till en ny medlem i '.$this->system_model->get('org_name').'.', 'lead');
        $html .= form_open('member/register', array('class' => 'custom'));
        $html .= '<div class="row"><div class="eight columns">';
/*
        $membertypes = $this->member_model->get_types();
        $types = array();
        foreach ($membertypes as $type) {
            $types[$type['id']] = $type['name'];
        }

        $this->javascript->change('#type', 'alert($("#type").val());');
        $type_extras = (form_error('type')) ? 'id="type" class="expand error"' : 'id="type" class="expand"';
*/
				$html .= form_hidden('type', $type);
        $html .= row(
            columns(
//                form_label('Medlemstyp:', 'type').
//                form_dropdown(
//                    'type',
//                    $types,
//                    1,
//                    $type_extras), 6).
//            columns(
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


        //   $html .= row(
        //    );
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
        $html .= '</div></div>';
        $html .= form_close();
        return $html;
    }

    /**
     * edit function.
     *
     * @access public
     * @return void
     */
    public function edit() {
        $this->output->enable_profiler(TRUE);
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