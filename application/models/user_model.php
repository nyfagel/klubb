<?php
/**
 * User_model class.
 * 
 * @extends CI_Model
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
	}
	
	/**
	 * create_user function.
	 * 
	 * @access public
	 * @param array $data (default: array())
	 * @return int user id.
	 */
	public function create_user($data = array()) {
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
		$this->db->select('name, email, phone, password, key');
		$query = $this->db->get_where('users', array('id' => intval($user)));
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
		return $this->db->update('users', $data);
	}
	
	public function forge() {
		
	}
}
?>