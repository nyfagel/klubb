<?php
/**
 * Member_model class.
 * 
 * @extends CI_Model
 * @version 0.9.1
 * @author Jan Lindblom <jan@nyfagel.se>
 * @copyright Copyright (c) 2013 Ung Cancer.
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
		$this->update_member(intval($row['id']), $data);
		return intval($row['id']);
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
		$data = array('id' => intval($user));

		$query = $this->db->get_where('members', $data);
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return null;
	}
	
	public function get_name($member = -1) {
		$data = array('id' => intval($member));
		
		$query = $this->db->get_where('members', $data);
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			return ucfirst($row['firstname']).' '.ucfirst($row['lastname']);
		}
		return "J. Doe";
	}
	
	public function get_type_of($member = -1) {
		$data = array('id' => intval($member));
		
		$query = $this->db->get_where('members', $data);
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			$type = $this->get_type($row['type']);
			return lcfirst($type['name']);
		}
		return "unknown";
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
	public function list_members($type = -1) {
		if ($type > 0) {
			$this->db->where('type', intval($type));
		}
		$query = $this->db->get('members');
		return $query->result_array();
	}
	
	/**
	 * search_members function.
	 * 
	 * @access public
	 * @param string $query (default: "")
	 * @return void
	 */
	public function search_members($query = "") {
		$this->db->where("firstname ILIKE '%".$query."%'");
		$this->db->or_where("lastname ILIKE '%".$query."%'");
		$this->db->or_where("CONCAT(firstname, ' ', lastname) ILIKE '%".$query."%'");
		$this->db->or_where("cancer ILIKE '%".$query."%'");
		$this->db->or_where("to_char(diagnos, '9999') ILIKE '%".$query."%'");
		$this->db->or_where("ssid ILIKE '%".$query."%'");
		$this->db->or_where("city ILIKE '%".$query."%'");
		/*
			members.firstname ILIKE '%j%' OR 
			members.lastname ILIKE '%j%' OR 
			members.cancer ILIKE '%j%' OR 
			to_char(members.diagnos, '9999') ILIKE '%j%' OR 
			members.city ILIKE '%j%';
		*/
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
//		$this->db->where('type' => intval($type));
//		return $this->db->count_all_results('members');
		$query = $this->db->get_where('members', array('type' => intval($type)));
		return $query->num_rows();
	}
	
	/**
	 * get_type function.
	 * 
	 * @access public
	 * @param mixed $id
	 * @return void
	 */
	public function get_type($id) {
		log_message('debug', "member_model->get_type($id)");
		$query = $this->db->get_where('types', array('id' => intval($id)));
		return $query->row_array();
	}
	
	/**
	 * get_types function.
	 * 
	 * @access public
	 * @return void
	 */
	public function get_types() {
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('types');
		return $query->result_array();
	}
	
	/**
	 * get_type_requirements function.
	 * 
	 * @access public
	 * @param float $type (default: -1)
	 * @return void
	 */
	public function get_type_requirements($type = -1) {
		log_message('debug', "member_model->get_type_requirements($type)");
		$this->db->order_by('sort_order ASC, row ASC, column ASC');
		$query = $this->db->get_where('types_requirements', array('type' => intval($type)));
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
	}
	
	/**
	 * get_type_flag function.
	 * 
	 * @access public
	 * @param int $type (default: -1)
	 * @param string $key (default: '')
	 * @return void
	 */
	public function get_type_flag($type = -1, $key = '') {
		$query = $this->db->get_where('member_flags', array('type' => intval($type), 'key' => $key));
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			return $row['desc'];
		}
		return null;
	}
	
	/**
	 * set_type_flag function.
	 * 
	 * @access public
	 * @param int $type (default: -1)
	 * @param string $key (default: '')
	 * @param string $value (default: '')
	 * @return void
	 */
	public function set_type_flag($type = -1, $key = '', $value = '') {
		$this->db->where('type', intval($type));
		$this->db->where('key', $key);
		$this->db->set('value', $value);
		return $this->db->update('member_flags');
	}
}
?>