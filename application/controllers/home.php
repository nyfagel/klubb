<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index() {
		$data['title'] = "Medlemsregistret";
		$data['html'] = "blabla";
		$this->load->view('template', $data);
	}
}

?>