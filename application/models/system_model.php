<?php
/**
 * System_model class.
 * 
 * @extends CI_Model
 */
class System_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * get function.
	 * 
	 * @access public
	 * @param string $key (default: '')
	 * @return void
	 */
	public function get($key = '') {
		$query = $this->db->get_where('system', array('key' => $key));
		$row = $query->row_array();
		return $row['value'];
	}
	
	/**
	 * add function.
	 * 
	 * @access public
	 * @param string $key (default: '')
	 * @param string $value (default: '')
	 * @return void
	 */
	public function add($key = '', $value = '') {
		$query = $this->db->get_where('system', array('key' => $key));
		if ($query->num_rows() > 0) {
			return $this->update($key, $value);
		}
		return $this->db->insert('system', array('key' => $key, 'value' => $value));
	}
	
	/**
	 * update function.
	 * 
	 * @access public
	 * @param string $key (default: '')
	 * @param string $value (default: '')
	 * @return void
	 */
	public function update($key = '', $value = '') {
		$this->db->where('key', $key);
		return $this->db->update('system', array('value' => $value));
	}
	
	/**
	 * drop function.
	 * 
	 * @access public
	 * @param string $key (default: '')
	 * @return void
	 */
	public function drop($key = '') {
		$this->db->where('key', $key);
		return $this->db->delete('system');
	}
}
?>