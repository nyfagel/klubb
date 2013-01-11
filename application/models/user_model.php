<?php
/**
 * User_model class.
 * 
 * @extends CI_Model
 * @version 0.1
 * @author Jan Lindblom <jan@nyfagel.se>
 * @copyright Copyright (c) 2012-2013 Ung Cancer.
 */
class User_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library("auth");
		$this->load->library('encrypt');
		log_message('debug', 'Model loaded: user_model');
	}
	
	/**
	 * create_user function.
	 * 
	 * @access public
	 * @param array $data (default: array())
	 * @return int user id.
	 */
	public function create_user($data = array()) {
		$data['password'] = $this->hash($data['password']);
		$data['registered'] = time();
		$data['key'] = $this->encrypt->encode($data['email'], $data['password']);
		
		$query = $this->db->get_where('users', $data);
		if ($query->num_rows() < 1) {
			$this->db->insert('users', $data);
			return $this->db->insert_id();
		}
		$row = $query->row_array();
		return $this->update_user(intval($row['id']), $data);
	}
	
	/**
	 * remove_user function.
	 * 
	 * @access public
	 * @param int $user (default: 0)
	 * @return bool true on success, false otherwise.
	 */
	public function remove_user($user = 0) {
		$this->db->where('id', intval($user));
		return $this->db->delete('users');
	}
	
	/**
	 * get_user function.
	 * 
	 * @access public
	 * @param int $user (default: 0)
	 * @return void
	 */
	public function get_user($user = 0) {
		$data = array();
		if (is_int($user)) {
			$data = array('id' => intval($user));
		} else if (is_string($user)) {
			$data = array('username' => $user);
		}
		$query = $this->db->get_where('users', $data);
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return null;
	}
	
	/**
	 * update_user function.
	 * 
	 * @access public
	 * @param int $user (default: 0)
	 * @param array $data (default: array())
	 * @return int user id.
	 */
	public function update_user($user = 0, $data = array()) {
		$this->db->where('id', intval($user));
		if (isset($data['password']) && $data['password']) {
			$data['password'] = $this->hash($data['password']);
		} else {
			unset($data['password']);
		}
		return $this->db->update('users', $data);
	}
	
	/**
	 * list_users function.
	 * 
	 * @access public
	 * @return void
	 */
	public function list_users() {
		$this->db->select('id, username, firstname, lastname, email');
		$query = $this->db->get('users');
		return $query->result_array();
	}
	
	/**
	 * count_users function.
	 * 
	 * @access public
	 * @return void
	 */
	public function count_users() {
		$query = $this->db->get('users');
		return $query->num_rows();
	}
	
	/**
	 * set_active function.
	 * 
	 * @access public
	 * @param int $id (default: 0)
	 * @return void
	 */
	public function set_active($id = 0) {
		$this->db->where('id', intval($id));
		return $this->db->update('users', array('loggedin' => true));
	}
	
	/**
	 * set_inactive function.
	 * 
	 * @access public
	 * @param int $id (default: 0)
	 * @return void
	 */
	public function set_inactive($id = 0) {
		$this->db->where('id', intval($id));
		return $this->db->update('users', array('loggedin' => false));
	}
	
	/**
	 * is_active function.
	 * 
	 * @access public
	 * @param int $id (default: 0)
	 * @return void
	 */
	public function is_active($id = 0) {
		$query = $this->db->get_where('users', array('id' => intval($id)));
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			return ($row['loggedin']);
		}
		return false;
	}
	
	/**
	 * get_active function.
	 * 
	 * @access public
	 * @return void
	 */
	public function get_active() {
		$query = $this->db->get_where('users', array('loggedin' => true));
		$active = array();
		foreach ($query->result_array() as $row) {
			array_push($active, intval($row['id']));
		}
		return $active;
	}
	
	/**
	 * Password hashing function
	 * 
	 * @param string $password
	 */
	public function hash($password) {
		$this->load->library('PasswordHash', array('iteration_count_log2' => 8, 'portable_hashes' => false));
		
		// hash password
		return $this->passwordhash->HashPassword($password);
	}
	
	/**
	 * Compare user input password to stored hash
	 * 
	 * @param string $password
	 * @param string $stored_hash
	 */
	public function check_password($password, $stored_hash) {
		$this->load->library('PasswordHash', array('iteration_count_log2' => 8, 'portable_hashes' => false));
		
		// check password
		return $this->passwordhash->CheckPassword($password, $stored_hash);
	}
}
?>