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
		$this->load->library('javascript');
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
	}
	
	public function view($template = '', $data = array()) {
		$this->javascript->compile();
		$this->load->view($template, $data);
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
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			return $row['value'];
		}
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