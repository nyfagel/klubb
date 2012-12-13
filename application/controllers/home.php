<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index() {
		$data['title'] = "Medlemsregistret";
		$data['html'] = heading($this->lang->line('welcome'),1);
		$data['html'] .= $this->lang->lang();
		$data['html'] .= anchor($this->lang->switch_uri('en'),'Display current page in English');
		$this->load->view('template', $data);
	}
}

?>