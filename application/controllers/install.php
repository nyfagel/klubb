<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install extends CI_Controller {

	public function index() {
		$this->load->view('install_start');
	}
	
	public function database() {
		$this->load->view('install_database');
	}
}

?>