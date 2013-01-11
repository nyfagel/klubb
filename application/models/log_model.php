<?php
/**
 * Logmodel class.
 * 
 * @extends CI_Model
 * @version 0.1
 * @author Jan Lindblom <jan@nyfagel.se>
 * @copyright Copyright (c) 2012-2013 Ung Cancer.
 */
class Log_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper('date');
		log_message('debug', 'Model loaded: log_model');
	}
	
	/**
	 * add_entry function.
	 * 
	 * @access public
	 * @param int $user (default: 0)
	 * @param string $action (default: '')
	 * @param string $path (default: '')
	 * @return void
	 */
	public function add_entry($user = 0) {
		$action = $this->uri->segment(1);
		$path = ($this->uri->segment(2)) ? $this->uri->segment(2) : 'index';
		if ($this->db->insert('log', array('user' => intval($user), 'action' => $action, 'path' => $path))) {
			return $this->db->insert_id();
		}
		return null;
	}
	
	/**
	 * remove_entry function.
	 * 
	 * @access public
	 * @param int $entry (default: 0)
	 * @return bool
	 */
	public function remove_entry($entry = 0) {
		$this->db->where('id', intval($entry));
		return $this->db->delete('log');
	}
	
	/**
	 * get_entry function.
	 * 
	 * @access public
	 * @param int $entry (default: 0)
	 * @return void
	 */
	public function get_entry($entry = 0) {
		$query = $this->db->get_where('log', array('id' => intval($entry)));
		return $query->row_array();
	}
	
	/**
	 * get_entries function.
	 * 
	 * @access public
	 * @param int $limit (default: 0)
	 * @param int $offset (default: 0)
	 * @return void
	 */
	public function get_entries($limit = 0, $offset = 0) {
		if ($limit > 0) {
			$this->db->limit(intval($limit));
		}
		if ($offset > 0) {
			$this->db->offset(intval($offset));
		}
		$query = $this->db->get('log');
		return $query->result_array();
	}
}
?>