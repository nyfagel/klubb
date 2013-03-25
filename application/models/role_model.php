<?php
/**
 * Role_model class.
 * 
 * @extends CI_Model
 * @version 0.9.1
 * @author Jan Lindblom <jan@nyfagel.se>
 * @copyright Copyright (c) 2013 Ung Cancer.
 */
class Role_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		log_message('debug', 'Model loaded: role_model');
	}
	
	/**
	 * list_roles function.
	 * 
	 * @access public
	 * @return void
	 */
	public function list_roles() {
		$query = $this->db->get('roles');
		if ($query->num_rows() > 0) {
			$result = array();
			foreach ($query->result_array() as $row) {
				$result[$row['id']] = $row['name'];
			}
			return $result;
		}
		return array();
	}
	
	/**
	 * get_role function.
	 * 
	 * @access public
	 * @param float $id (default: -1)
	 * @return void
	 */
	public function get_role($id = -1) {
		$query = $this->db->get_where('roles', array('id' => intval($id)));
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return array();
	}
	
	/**
	 * get_default_role function.
	 * 
	 * @access public
	 * @return void
	 */
	public function get_default_role() {
		$query = $this->db->get_where('role_view', array('add_users' => false, 'add_members' => false, 'system_role' => true));
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return array();
	}
	
	/**
	 * map function.
	 * 
	 * @access public
	 * @param float $user (default: -1)
	 * @param float $role (default: -1)
	 * @return void
	 */
	public function map($user = -1, $role = -1) {
		$query = $this->db->get_where('user_role', array('user' => intval($user), 'role' => intval($role)));
		if ($query->num_rows() < 1) {
			return $this->db->insert('user_role', array('user' => intval($user), 'role' => intval($role)));
		}
		return true;
	}
	
	/**
	 * unmap function.
	 * 
	 * @access public
	 * @param float $user (default: -1)
	 * @param float $role (default: -1)
	 * @return void
	 */
	public function unmap($user = -1, $role = -1) {
		$query = $this->db->get_where('user_role', array('user' => intval($user), 'role' => intval($role)));
		if ($query->num_rows() > 0) {
			$this->db->where(array('user' => intval($user), 'role' => intval($role)));
			return $this->db->delete('user_role');
		}
		return true;
	}
	
	/**
	 * user_mapping function.
	 * 
	 * @access public
	 * @param float $user (default: -1)
	 * @return void
	 */
	public function user_mapping($user = -1) {
		$query = $this->db->get_where('user_role', array('user' => intval($user)));
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return null;
	}
}
?>