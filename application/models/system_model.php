<?php
/**
 * System_model class.
 * 
 * @extends CI_Model
 * @version 0.9.1
 * @author Jan Lindblom <jan@nyfagel.se>
 * @copyright Copyright (c) 2013 Ung Cancer.
 */
class System_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
//		$this->load->database();
//		$this->load->library('javascript');
		$this->jquery->plugin(base_url('assets/js/foundation/jquery.cookie.js'), true);
		$this->jquery->plugin(base_url('assets/js/foundation/jquery.event.move.js'), true);
		$this->jquery->plugin(base_url('assets/js/foundation/jquery.event.swipe.js'), true);
		$this->jquery->plugin(base_url('assets/js/foundation/jquery.offcanvas.js'), true);
		$this->jquery->plugin(base_url('assets/js/foundation/jquery.placeholder.js'), true);
		
		/*
<script src="<?php echo asset_url('js/foundation/jquery.event.move.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.event.swipe.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.offcanvas.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.placeholder.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.accordion.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.alerts.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.buttons.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.clearing.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.forms.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.joyride.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.magellan.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.mediaQueryToggle.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.navigation.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.orbit.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.reveal.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.tabs.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.tooltips.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.topbar.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/app.js'); ?>"></script>
		*/
		
		log_message('debug', 'Model loaded: system_model');
	}
	
	/**
	 * view function.
	 * 
	 * @access public
	 * @param string $template (default: '')
	 * @param array $data (default: array())
	 * @return void
	 */
	public function view($template = '', $data = array()) {
		if ($template != 'ajax') {
			$this->javascript->compile();
			$this->load->view('_header', $data);
			$this->load->view('_topbar', $data);
		}
		
		if (array_key_exists('partial', $data)) {
			$this->load->view('partials/'.$data['partial'], $data);
		} else {
			$this->load->view($template, $data);
		}
		if ($template != 'ajax') {
			$this->load->view('_footer', $data);
		}
	}
	
	/**
	 * encrypt_data function.
	 * 
	 * @access public
	 * @param mixed $data (default: null)
	 * @param mixed $key (default: null)
	 * @return void
	 */
	public function encrypt_data($data = null, $key = null) {
		$this->load->library('encrypt');
		return $this->encrypt->encode($data, $key);
	}
	
	/**
	 * decrypt_data function.
	 * 
	 * @access public
	 * @param mixed $data (default: null)
	 * @param mixed $key (default: null)
	 * @return void
	 */
	public function decrypt_data($data = null, $key = null) {
		$this->load->library('encrypt');
		return $this->encrypt->decode($data, $key);
	}
	
	/**
	 * get function.
	 * 
	 * @access public
	 * @param string $key (default: '')
	 * @return void
	 */
	public function get($key = '') {
		$this->benchmark->mark('system_model_get_start');
		$query = $this->db->get_where('system', array('key' => $key));
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			$this->benchmark->mark('system_model_get_end');
			return $row['value'];
		}
		$this->benchmark->mark('system_model_get_end');
		return null;
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
	 * set function.
	 * 
	 * @access public
	 * @param string $key (default: '')
	 * @param string $value (default: '')
	 * @return void
	 */
	public function set($key = '', $value = '') {
		return $this->add($key, $value);
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