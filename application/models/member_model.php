<?php
/**
 * Member_model class.
 * 
 * @extends CI_Model
 * @version 0.1
 * @author Jan Lindblom <jan@nyfagel.se>
 * @copyright Copyright (c) 2012-2013 Ung Cancer.
 */
class Member_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
//		$this->load->database();
//		$this->load->library('encrypt');
		log_message('debug', 'Model loaded: member_model');
	}
	
	/**
	 * create_member function.
	 * 
	 * @access public
	 * @param array $data (default: array())
	 * @return void
	 */
	public function create_member($data = array()) {
		$query = $this->db->get_where('members', $data);
		if ($query->num_rows() < 1) {
			$this->db->insert('members', $data);
			return $this->db->insert_id();
		}
		$row = $query->row_array();
		return $this->update_member(intval($row['id']), $data);
	}
	
	/**
	 * remove_member function.
	 * 
	 * @access public
	 * @param int $user (default: 0)
	 * @return void
	 */
	public function remove_member($user = null) {
		if (is_array($user)) {
			$this->db->where_in('id', $user);
		} else {
			$this->db->where('id', intval($user));
		}
		
		return $this->db->delete('members');
	}
	
	/**
	 * create_member_data function.
	 * 
	 * @access public
	 * @param int $member (default: 0)
	 * @param array $data (default: array())
	 * @return void
	 */
	public function create_member_data($member = 0, $data = array()) {
		$this->db->insert('member_data', $data);
		return $this->db->update('members', array('data' => $this->db->insert_id()));
	}
	
	/**
	 * update_member_data function.
	 * 
	 * @access public
	 * @param int $id (default: 0)
	 * @param array $data (default: array())
	 * @return void
	 */
	public function update_member_data($id = 0, $data = array()) {
		$this->db->where('id', intval($id));
		return $this->db->update('member_data', $data);
	}
	
	/**
	 * get_data_entry function.
	 * 
	 * @access public
	 * @param int $member (default: 0)
	 * @return void
	 */
	public function get_data_entry($member = 0) {
		$this->db->select('data');
		$query = $this->db->get_where('members', array('id' => intval($member)));
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			return $row['data'];
		}
		return null;
	}
	
	/**
	 * get_member function.
	 * 
	 * @access public
	 * @param int $user (default: 0)
	 * @return void
	 */
	public function get_member($user = 0) {
		$data = array();
		$data = array('id' => intval($user));

		$query = $this->db->get_where('members', $data);
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return null;
	}
	
	/**
	 * update_member function.
	 * 
	 * @access public
	 * @param int $user (default: 0)
	 * @param array $data (default: array())
	 * @return void
	 */
	public function update_member($user = 0, $data = array()) {
		$this->db->where('id', intval($user));
		return $this->db->update('members', $data);
	}
	
	/**
	 * list_members function.
	 * 
	 * @access public
	 * @param float $offset (default: -1)
	 * @param float $limit (default: -1)
	 * @return void
	 */
	public function list_members($offset = -1, $limit = -1) {
		if ($limit > 0) {
			if ($offset > 0) {
				$this->db->limit(intval($limit), intval($offset));
			} else {
				$this->db->limit(intval($limit));
			}
		}
		$query = $this->db->get('members');
		return $query->result_array();
	}
	
	/**
	 * count_members function.
	 * 
	 * @access public
	 * @return void
	 */
	public function count_members() {
		$query = $this->db->get('members');
		return $query->num_rows();
	}
	
	/**
	 * count_members_type function.
	 * 
	 * @access public
	 * @param int $type (default: 0)
	 * @return void
	 */
	public function count_members_type($type = 0) {
		$query = $this->db->get_where('members', array('type' => intval($type)));
		return $query->num_rows();
	}
	
	/**
	 * get_types function.
	 * 
	 * @access public
	 * @return void
	 */
	public function get_types() {
		$query = $this->db->get('types');
		return $query->result_array();
	}
}
?>