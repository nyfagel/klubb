<?php
/**
 * Rights_model class.
 * 
 * @extends CI_Model
 * @version 0.9.1
 * @author Jan Lindblom <jan@nyfagel.se>
 * @copyright Copyright (c) 2013 Ung Cancer.
 */
class Rights_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		log_message('debug', 'Model loaded: rights_model');
	}
	
	/**
	 * get_entry function.
	 * 
	 * @access public
	 * @param float $id (default: -1)
	 * @return void
	 */
	public function get_entry($id = -1) {
		$query = $this->db->get_where('rights', array('id' => intval($id)));
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return array();
	}
	
	/**
	 * get_for_role function.
	 * 
	 * @access public
	 * @param float $role (default: -1)
	 * @return void
	 */
	public function get_for_role($role = -1) {
		$query = $this->db->get_where('role_view', array('id' => intval($role)));
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return array();
	}
}
?>