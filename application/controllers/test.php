<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Test class.
 * 
 * @extends CI_Controller
 */
class Test extends CI_Controller {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		
		$this->load->language('klubb');
		$this->load->model('log_model');
		$this->load->model('user_model');
		$this->load->model('member_model');
		$this->load->model('system_model');
		
		$this->load->helper('language');
		
		$this->load->library('unit_test');
		
		$str = '<tr>
		{rows}
			<td>{result}</td>
		{/rows}
		</tr>';

		$this->unit->set_template($str);
		$this->unit->set_test_items(array('test_name', 'result', 'notes'));
	}

	/**
	 * index function.
	 * 
	 * @access public
	 * @return void
	 */
	public function index() {
		$this->output->enable_profiler(true);
		if (!$this->auth->loggedin()) {
			redirect('user/login');
		}
		$th = '<thead><tr><th>'.lang('ut_test_name').'</th><th>'.lang('ut_result').'</th><th>'.lang('ut_notes').'</th></tr></thead>';
		$data['title'] = $this->system_model->get('app_name');
		
		$html = row(columns(heading('Test Results', 1), 12));
		$html .= '<table cellspacing="0">'.$th.'<tbody>';
		
		$create_user['result'] = $this->create_user();
		$create_user['query'] = $this->db->last_query();
		$get_user['result'] = $this->get_user($create_user['result']);
		$get_user['query'] = $this->db->last_query();
		$update_user['result'] = $this->update_user($create_user['result'], $get_user['result']);
		$update_user['query'] = $this->db->last_query();
		$log_write['result'] = $this->log_write($create_user['result']);
		$log_write['query'] = $this->db->last_query();
		$log_read['result'] = $this->log_read($log_write['result']);
		$log_read['query'] = $this->db->last_query();
		$remove_log['result'] = $this->remove_log($log_write['result']);
		$remove_log['query'] = $this->db->last_query();
		$remove_user['result'] = $this->remove_user($create_user['result']);
		$remove_user['query'] = $this->db->last_query();
		
		$create_members['result'] = $this->add_members();
		$create_members['query'] = $this->db->last_query();
		$remove_members['result'] = $this->remove_members($create_members['result']);
		$remove_members['query'] = $this->db->last_query();
		
		$html .= $this->unit->run($create_user['result'], 'is_int', 'user_model::create_user()', $create_user['query']);
		$html .= $this->unit->run($get_user['result'], 'is_array', 'user_model::get_user()', $get_user['query']);
		$html .= $this->unit->run($update_user['result'], 'is_true', 'user_model::update_user()', $update_user['query']);
		$html .= $this->unit->run($remove_user['result'], 'is_true', 'user_model::remove_user()', $remove_user['query']);
		
		$html .= $this->unit->run($log_write['result'], 'is_int', 'log_model::add_entry()', $log_write['query']);
		$html .= $this->unit->run($log_read['result'], 'is_array', 'log_model::get_entry()', $log_read['query']);
		$html .= $this->unit->run($remove_log['result'], 'is_true', 'log_model::remove_entry()', $remove_log['query']);
		
		$html .= $this->unit->run($create_members['result'], 'is_array', 'member_model::create_member()', $create_members['query']);
		$html .= $this->unit->run($remove_members['result'], 'is_true', 'member_model::remove_member()', $remove_members['query']);
		
		$html .= '</tbody></table>';
		$data['html'] = $html;
		$this->system_model->view('template', $data);
	}
	
	/**
	 * create_user function.
	 * 
	 * @access private
	 * @return void
	 */
	private function create_user() {
		return $this->user_model->create_user(array('username' => 'test', 'password' => 'test', 'email' => 'test@nyfagel.se', 'password' => very_random_string()));
	}
	
	/**
	 * get_user function.
	 * 
	 * @access private
	 * @param mixed $user
	 * @return void
	 */
	private function get_user($user) {
		return $this->user_model->get_user($user);
	}
	
	/**
	 * update_user function.
	 * 
	 * @access private
	 * @param mixed $user
	 * @param mixed $data
	 * @return void
	 */
	private function update_user($user, $data) {
		return $this->user_model->update_user($user, $data);
	}
	
	/**
	 * remove_user function.
	 * 
	 * @access private
	 * @param mixed $user
	 * @return void
	 */
	private function remove_user($user) {
		return $this->user_model->remove_user(intval($user));
	}
	
	/**
	 * log_write function.
	 * 
	 * @access private
	 * @param mixed $user
	 * @return void
	 */
	private function log_write($user) {
		return $this->log_model->add_entry($user);
	}
	
	/**
	 * log_read function.
	 * 
	 * @access private
	 * @param mixed $entry
	 * @return void
	 */
	private function log_read($entry) {
		return $this->log_model->get_entry($entry);
	}
	
	/**
	 * remove_log function.
	 * 
	 * @access private
	 * @param mixed $entry
	 * @return void
	 */
	private function remove_log($entry) {
		return $this->log_model->remove_entry(intval($entry));
	}
	
	/**
	 * add_members function.
	 * 
	 * @access private
	 * @return void
	 */
	private function add_members() {
		$firstnames = array('Jan', 'Eric', 'Tobias', 'Sam', 'Erik', 'Petra', 'Veronica', 'Pelle', 'Calle', 'Nisse', 'Linn');
		$lastnames = array('Lindblom', 'Landeberg', 'Öderyd');
		$added = array();
		
		foreach ($lastnames as $last) {
			foreach ($firstnames as $first) {
				$phone = substr(number_format(time() * rand(),0,'',''),0,10);
				$ssid = substr(number_format(time() * rand(),0,'',''),0,6).'-'.substr(number_format(time() * rand(),0,'',''),0,4);
				$id = $this->add_member($first, $last, $ssid, $phone);
				array_push($added, $id);
			}
		}
		return $added;
	}
	
	/**
	 * remove_members function.
	 * 
	 * @access private
	 * @param mixed $list
	 * @return void
	 */
	private function remove_members($list) {
		return $this->remove_member($list);
	}
	
	/**
	 * add_member function.
	 * 
	 * @access private
	 * @param mixed $first
	 * @param mixed $last
	 * @param mixed $ssid
	 * @param mixed $phone
	 * @return void
	 */
	private function add_member($first, $last, $ssid, $phone) {
		return $this->member_model->create_member(array('firstname' => $first, 'lastname' => $last, 'ssid' => $ssid, 'phone' => $phone));
	}
	
	/**
	 * remove_member function.
	 * 
	 * @access private
	 * @param mixed $id
	 * @return void
	 */
	private function remove_member($id) {
		return $this->member_model->remove_member($id);
	}
}

?>