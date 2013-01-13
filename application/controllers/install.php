<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Install class.
 * 
 * @extends CI_Controller
 */
class Install extends CI_Controller {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->load->language('klubb');
		$this->load->model('system_model');
		$this->load->model('user_model');
		$this->load->helper('html');
		
		$this->load->library('migration');
		log_message('debug', 'Controller loaded: install');
	}
	
	/**
	 * database function.
	 * 
	 * @access public
	 * @return void
	 */
	public function database() {
		$this->output->enable_profiler(true);
		$this->load->database();
		$this->load->dbutil();
		$this->load->dbforge();
		
		$data['title'] = $this->system_model->get('app_name');
		$data['breadcrumbs'] = array(array('data' => anchor('/', $this->system_model->get('app_name')), 'mode' => 'unavailable'), array('data' => anchor('install', ucfirst(lang('install'))), 'mode' => 'unavailable'), array('data' => anchor('install/database', ucfirst(lang('install').' '.lang('database'))), 'mode' => 'current'));
		$html = heading(ucfirst(lang('install')).' '.lang('database'), 1);
		$current = $this->migration->current();
		
		if ( is_null($current)) {
			$html .= div($this->migration->error_string(), 'alert-box error');
		} else {
			$html .= div('Klubb database version: '.$current, 'alert-box success');
		}
		
		$tables = $this->db->list_tables();
		foreach ($tables as $table) {
			$fields = $this->db->list_fields($table);
			array_unshift($fields, strong('Fält:'));
			$fields = ul($fields, array('class' => 'inline-list'));
			$html .= div(heading('Tabell: '.$table, 4).$fields,'radius panel');
		}
		
		$data['html'] = $html;
		$this->system_model->view('template', $data);
	}
}

?>