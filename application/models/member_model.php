<?php
/**
 * Member_model class.
 * 
 * @extends CI_Model
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
		$this->load->database();
		$this->load->library('encrypt');
	}
	
	public function create_member($data = array()) {
		$query = $this->db->get_where('members', $data);
		if ($query->num_rows() < 1) {
			$this->db->insert('members', $data);
			return $this->db->insert_id();
		}
		$row = $query->row_array();
		return $this->update_member(intval($row['id']), $data);
	}
	
	public function remove_member($user = 0) {
		$this->db->where('id', intval($user));
		return $this->db->delete('members');
	}
	
	public function get_member($user = 0) {
		$data = array();
		$data = array('id' => intval($user));

		$query = $this->db->get_where('members', $data);
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return null;
	}
	
	public function update_member($user = 0, $data = array()) {
		$this->db->where('id', intval($user));
		return $this->db->update('members', $data);
	}
	
	public function list_members() {
		$this->db->select('id, firstname, lastname, email');
		$query = $this->db->get('members');
		return $query->result_array();
	}
	
	public function count_members() {
		$query = $this->db->get('members');
		return $query->num_rows();
	}
	
	public function count_members_type($type = 0) {
		$query = $this->db->get_where('members', array('type' => intval($type)));
		return $query->num_rows();
	}
	
	public function get_types() {
		$query = $this->db->get('types');
		return $query->result_array();
	}
}
?>