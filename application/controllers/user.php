<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User class.
 *
 * @extends CI_Controller
 * @version 0.9.1
 * @author Jan Lindblom <jan@nyfagel.se>
 * @copyright Copyright (c) 2013 Ung Cancer.
 */
class User extends CI_Controller {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();

		$this->load->model('system_model');
		$this->load->model('user_model');
		$this->load->model('role_model');

		$this->load->helper('html');
		$this->load->helper('email');
		$this->load->helper('form');
		$this->load->helper('url');

		$this->load->library('form_validation');

		log_message('debug', 'Controller loaded: user');
	}

	/**
	 * login function.
	 *
	 * @access public
	 * @return void
	 */
	public function login() {
		$this->output->enable_profiler(false);
		if ($this->auth->loggedin()) {
			$this->user_model->set_active($user['id']);
			redirect('home');
		}

		$error = '';

		// form submitted
		if ($this->input->post('username') && $this->input->post('password')) {
			$remember = $this->input->post('remember') ? true : false;
			$password = $this->input->post('password');
			$username = $this->input->post('username');
			// get user from database
			$user = $this->user_model->get_user($username);

			if ($user) {
				// compare passwords
				if ($this->user_model->check_password($password, $user['password'])) {
					// mark user as logged in
					$this->auth->login($user['id'], $remember);
					$this->user_model->set_active($user['id']);
					redirect('home');
				} else {
					$error = 'Wrong password';
				}
			} else {
				$error = 'User does not exist';
			}
		}

		if (!empty($error)) {
			$this->messages->add($error, "error");
		}

		$data['title'] = $this->system_model->get('app_name');

		$html = row(columns(heading(ucfirst(lang('welcome')), 1), 12));
		$html .= row(columns(p(lang('intro_text')), 12));

		$html .= form_open('user/login', array('class' => 'custom'));
		$html .= row(columns(panel(
					row(
						columns(
							form_label(
								ucfirst(lang('username')).':', 'username',
								array('class' => 'inline right')), 4).
						columns(form_input(array(
									'type' => 'text',
									'name' => 'username',
									'id' => 'username')), 8), 'collapse').
					row(
						columns(
							form_label(
								ucfirst(lang('password')).':',
								'password',
								array('class' => 'inline right')), 4).
						columns(
							form_input(array(
									'type' => 'password',
									'name' => 'password',
									'id' => 'password')), 8), 'collapse').
					row(
						columns(
							form_label(
								form_input(array(
										'type' => 'checkbox',
										'name' => 'remember',
										'id' => 'remember',
										'value' => 1)).
								nbs().ucfirst(lang('remember_me')),
								'remember',
								array('class' => 'right')), 12)).
					row(
						columns(
							form_input(array(
									'type' => 'submit',
									'class' => 'right button',
									'value' => ucfirst(lang('login')))), 12)
					), 'radius'), 6, 'centered'));
		$html .= form_close();

		$data['html'] = $html;
		$this->system_model->view('template', $data);
	}

	/**
	 * create function.
	 *
	 * @access public
	 * @return void
	 */
	public function create() {
		$this->output->enable_profiler(false);
		if (!$this->auth->loggedin()) {
			redirect('user/login');
		}
		$uid = intval($this->auth->userid());
		$user = $this->user_model->get_user($uid);

		$this->form_validation->set_rules(
			'username',
			ucfirst(lang('username')),
			'trim|required|is_unique[users.username]');
		$this->form_validation->set_rules(
			'email',
			ucfirst(lang('email_address')),
			'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_message('is_unique', '%s finns redan i systemet.');

		$this->form_validation->set_error_delimiters(
			'<small class="error">',
			'</small>');

		$data['title'] = $this->system_model->get('app_name');
		$heading = ucfirst(lang('create_user'));

		$data['breadcrumbs'] = array(
			array('data' => anchor('/', $data['title']), 'mode' => 'unavailable'),
			array('data' => anchor('admin', ucfirst(lang('administration')))),
			array('data' => anchor('admin/users', ucfirst(lang('users')))),
			array('data' => anchor('user/create', $heading), 'mode' => 'current'));


		$html = heading($heading, 1);

		if ($this->form_validation->run() == true) {
			$user = array();
			$username = $this->input->post('username');
			$firstname = $this->input->post('firstname');
			$lastname = $this->input->post('lastname');
			$email = $this->input->post('email');
			$phone = $this->input->post('phone');
			if ($username) {
				$user['username'] = $username;
			}
			if ($firstname) {
				$user['firstname'] = $firstname;
			}
			if ($lastname) {
				$user['lastname'] = $lastname;
			}
			if ($email) {
				$user['email'] = $email;
			}
			if ($phone) {
				$user['phone'] = $phone;
			}
			$user['password'] = very_random_string();

			$id = $this->user_model->create_user($user);

			$html .= p('Grattis, nu har du lagt till användaren '.$user['username'].'!', 'lead');
			$html .= p('Användaren registrerades med följande uppgifter:');
			$html .= ul(
				array(
					strong('Användarnamn:').nbs().$user['username'],
					strong('E-postadress:').nbs().mailto($user['email'], $user['email']),
					strong('Förnamn:').nbs().$user['firstname'],
					strong('Efternamn:').nbs().$user['lastname'],
					strong('Telefonnummer:').nbs().$user['phone']
				), array('class' => 'no-bullet'));
			$html .= p('Ett tillfälligt lösenord har skapats åt '.
				$user['username'].
				' som bara går att använda vid första inloggningen, se till'.
				' att användaren får detta för att kunna logga in:');
			$html .= ul(
				array(
					strong($user['password'])),
				array('class' => 'no-bullet'));
			$html .= button_anchor(
				'user/create',
				ucfirst(lang('create_another_user')));
		} else {
			$html .= $this->create_form();
		}

		$data['html'] = $html;
		$this->system_model->view('template', $data);
	}

	/**
	 * create_form function.
	 *
	 * @access private
	 * @return void
	 */
	private function create_form() {
		// Pre-fill some variables.
		$appname = $this->system_model->get('app_name');
		$orgname = $this->system_model->get('org_name');
		$username = $this->input->post('username');
		$firstname = $this->input->post('firstname');
		$lastname = $this->input->post('lastname');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');

		$html = p('Använd formuläret nedan för att lägga till en ny användare'.
			' av '.$appname.' hos '.$orgname.'.', 'lead');
		$html .= '<div class="row"><div class="eight centered columns">';
		$html .= form_open('user/create', array('class' => 'custom'));
		$html .= row(
			columns(
				form_label(
					ucfirst(lang('username')).':'.span('*', 'required'),
					'username',
					array(
						'class' => (form_error('email'))?'error':'')).
				form_input(array(
						'type' => 'text',
						'name' => 'username',
						'id' => 'username',
						'class' => (form_error('username'))?'expand error':'expand',
						'value' => $username)).form_error('username'), 6, 'end'));
		$html .= row(
			columns(
				form_label(
					ucfirst(lang('email_address')).':'.span('*', 'required'),
					'email',
					array(
						'class' => (form_error('email'))?'error':'')).
				form_input(array(
						'type' => 'text',
						'name' => 'email',
						'id' => 'email',
						'class' => (form_error('email'))?'expand error':'expand',
						'value' => $email)).form_error('email'), 6).
			columns(
				form_label(ucfirst(lang('phone_number')).':', 'phone').
				form_input(array(
						'type' => 'text',
						'name' => 'phone',
						'id' => 'phone',
						'class' => 'expand',
						'value' => $phone)), 6));
		$html .= row(
			columns(
				form_label(ucfirst(lang('firstname')).':', 'firstname').
				form_input(array(
						'type' => 'text',
						'name' => 'firstname',
						'id' => 'firstname',
						'class' => 'expand',
						'value' => $firstname)), 6).
			columns(
				form_label(ucfirst(lang('lastname')).':', 'lastname').
				form_input(array(
						'type' => 'text',
						'name' => 'lastname',
						'id' => 'lastname',
						'value' => $lastname)), 6));
		$html .= button_group(array(
				button_anchor('admin/users', lang('button_cancel')),
				form_input(array(
						'type' => 'submit',
						'class' => 'button',
						'value' => lang('button_save')))), 'right');
		$html .= form_close();
		$html .= '</div></div>';
		return $html;
	}

	/**
	 * edit function.
	 *
	 * @access public
	 * @param int $id (default: 0)
	 * @return void
	 */
	public function edit($id = 0) {
		$this->output->enable_profiler(false);
		if (!$this->auth->loggedin()) {
			redirect('user/login');
		}

		$uid = ($id > 0) ? intval($id) : intval($this->auth->userid());
		$user = $this->user_model->get_user($uid);

		$data['title'] = $this->system_model->get('app_name');
		$data['partial'] = 'admin_users';
		$data['stylesheets'] = array('buttons_purple');

		$data['breadcrumbs'] = array(
			array(
				'data' => anchor('/', $data['title']),
				'mode' => 'unavailable'),
			array(
				'data' => anchor('admin', ucfirst(lang('administration')))),
			array(
				'data' => anchor('admin/users', ucfirst(lang('users')))),
			array(
				'data' => anchor('user/edit', ucfirst(lang('edit_user'))),
				'mode' => 'current'));

		$html = '<br>'; //heading(ucfirst(lang('edit_user')), 1);

		$html .= div_open('row').div_open('eight centered columns');
		if ($this->input->post()) {
			// !Process updated fields.
			$user = array();
			$username = $this->input->post('username');
			$firstname = $this->input->post('firstname');
			$lastname = $this->input->post('lastname');
			$email = $this->input->post('email');
			$phone = $this->input->post('phone');
			if ($username) {
				$user['username'] = $username;
			}
			if ($firstname) {
				$user['firstname'] = $firstname;
			}
			if ($lastname) {
				$user['lastname'] = $lastname;
			}
			if ($email) {
				$user['email'] = $email;
			}
			if ($phone) {
				$user['phone'] = $phone;
			}
			$ok = $this->user_model->update_user($id, $user);
			$html .= p('updated: '.$ok);
		}
		
		$html .= form_open(uri_string(), array('class' => 'custom'));
		$html .= form_hidden('id', $id);
		$html .= row(
			columns(
				form_label(
					ucfirst(lang('username')).':'.span('*', 'required'),
					'username').
				form_input(array(
						'type' => 'text',
						'name' => 'username',
						'id' => 'username',
						'class' => 'expand',
						'value' => $user['username'])), 6, 'end'));
		$html .= row(
			columns(
				form_label(
					ucfirst(lang('email_address')).':'.span('*', 'required'),
					'email').
				form_input(array(
						'type' => 'email',
						'name' => 'email',
						'id' => 'email',
						'class' => 'expand',
						'value' => $user['email'])), 6).
			columns(
				form_label(
					ucfirst(lang('phone_number')).':',
					'phone').
				form_input(array(
						'type' => 'text',
						'name' => 'phone',
						'id' => 'phone',
						'class' => 'expand',
						'value' => $user['phone'])), 6));
		$html .= row(
			columns(
				form_label(ucfirst(lang('firstname')).':', 'firstname').
				form_input(array(
						'type' => 'text',
						'name' => 'firstname',
						'id' => 'firstname',
						'class' => 'expand',
						'value' => $user['firstname'])), 6).
			columns(
				form_label(ucfirst(lang('lastname')).':', 'lastname').
				form_input(array(
						'type' => 'text',
						'name' => 'lastname',
						'id' => 'lastname',
						'value' => $user['lastname'])), 6));
		$html .= button_group(array(
				button_anchor('admin/users', lang('button_cancel'), 'radius'),
				form_input(array(
						'type' => 'submit',
						'class' => 'radius button',
						'value' => lang('button_save')))), 'radius right');
		$html .= form_close().div_close();
/*
		$html .= div_open('four columns');
		$html .= div_open('radius panel');
		$html .= heading(ucfirst(lang('role')), 4);
		$html .= form_open('user/role', array('class' => 'custom'));
		$html .= form_hidden('source', $this->encrypt->encode(current_url()));
		$allroles = $this->role_model->list_roles();
		$role = $this->role_model->user_mapping($uid);
		$role = $this->role_model->get_role($role['role']);
		$html .= form_label(
			ucfirst(lang('select')).' '.lang('role').':',
			'role');
		$html .= form_dropdown(
			'role',
			$allroles,
			$role['id'],
			'class="expand" id="role"');
		$html .= form_input(array(
				'type' => 'submit',
				'class' => 'small radius button',
				'value' => lang('button_save')));
		$html .= form_close();
*/
		$html .= div_close();

		$data['html'] = $html;
		$this->system_model->view('template', $data);
	}

	/**
	 * logout function.
	 *
	 * @access public
	 * @return void
	 */
	public function logout() {
		$this->user_model->set_inactive($user['id']);
		$this->auth->logout();
		redirect('user/login');
	}

	/**
	 * password function.
	 *
	 * @access public
	 * @param string $action (default: '')
	 * @return void
	 */
	public function password($action = '') {
		$this->output->enable_profiler(false);
		if ($action == 'change') {
			if (!$this->auth->loggedin()) {
				redirect('user/login');
			}

			$newpass = ($this->input->post('new_password')) ? $this->input->post('new_password') : null;
			$repeatpass = ($this->input->post('repeat_password')) ? $this->input->post('repeat_password') : null;
			$currpass = ($this->input->post('current_password')) ? $this->input->post('current_password') : null;
			$id = ($this->input->post('user')) ? $this->input->post('user') : 0;

			$uid = ($id > 0) ? intval($id) : intval($this->auth->userid());
			$user = $this->user_model->get_user($uid);

			$this->form_validation->set_rules('new_password', ucfirst(lang('new_password')), 'trim|required|min_length[8]');
			$this->form_validation->set_rules('repeat_password', ucfirst(lang('repeat_password')), 'trim|required|matches[new_password]|min_length[8]');
			$this->form_validation->set_rules('current_password', ucfirst(lang('current_password')), 'trim|required');
			$this->form_validation->set_error_delimiters('<small class="error">', '</small>');

			$data['breadcrumbs'] = array(
				array('data' => anchor('/', $this->system_model->get('app_name')), 'mode' => 'unavailable'),
				array('data' => anchor('admin', ucfirst(lang('administration')))),
				array('data' => anchor('admin/users', ucfirst(lang('users')))),
				array('data' => anchor('user/password/change', ucfirst(lang('change_password'))), 'mode' => 'current'));
		} else if ($action == 'forgot') {
				$data['breadcrumbs'] = array(
					array('data' => anchor('/', $this->system_model->get('app_name')), 'mode' => 'unavailable'),
					array('data' => anchor('admin', ucfirst(lang('administration')))), array('data' => anchor('admin/users', ucfirst(lang('users')))),
					array('data' => anchor('user/password/forgot', ucfirst(lang('change_password'))), 'mode' => 'current'));
			} else {
			if (!$this->auth->loggedin()) {
				redirect('user/login');
			}
			$id = (is_int($action)) ? $action : 0;
			$uid = ($id > 0) ? intval($id) : intval($this->auth->userid());
			$user = $this->user_model->get_user($uid);
			$data['breadcrumbs'] = array(
				array('data' => anchor('/', $this->system_model->get('app_name')), 'mode' => 'unavailable'),
				array('data' => anchor('admin', ucfirst(lang('administration')))),
				array('data' => anchor('admin/users', ucfirst(lang('users')))),
				array('data' => anchor('user/password', ucfirst(lang('change_password'))), 'mode' => 'current'));
		}

		$data['title'] = $this->system_model->get('app_name');

		$html = heading(ucfirst(lang('change_password')), 1);
		$html .= p(lang('change_password_instructions'), 'lead');
		if ($this->form_validation->run() == false) {
			$html .= form_open('/user/password/change');
			$html .= form_hidden('user', $id);
			$html .= row(columns(panel(
						form_label(ucfirst(lang('new_password')).span('*', 'required').':', 'new_password').
						form_input(array(
								'type' => 'password',
								'id' => 'new_password',
								'name' => 'new_password',
								'class' => (form_error('new_password'))?'error expand':'expand',
								'value' => $newpass)).form_error('new_password').
						form_label(ucfirst(lang('repeat_password')).span('*', 'required').':', 'repeat_password').
						form_input(array(
								'type' => 'password',
								'id' => 'repeat_password',
								'name' => 'repeat_password',
								'class' => (form_error('repeat_password'))?'error expand':'expand',
								'value' => $repeatpass)).form_error('repeat_password').
						'<hr>'.
						form_label(ucfirst(lang('current_password')).span('*', 'required').':', 'current_password').
						form_input(array(
								'type' => 'password',
								'id' => 'current_password',
								'name' => 'current_password',
								'class' => (form_error('current_password'))?'error expand':'expand')).form_error('current_password').
						form_submit(array(
								'type' => 'submit',
								'name' => 'submit_change_password',
								'class' => 'button',
								'value' => ucfirst(lang('change_password')))) ), 6, 'centered end'));
			$html .= form_close();
		}

		$data['html'] = $html;
		$this->system_model->view('template', $data);
	}

	/**
	 * role function.
	 *
	 * @access public
	 * @return void
	 */
	public function role() {
		if (!$this->auth->loggedin()) {
			redirect('user/login');
		}
		$uid = intval($this->auth->userid());
		$user = $this->user_model->get_user($uid);
	}
}

?>