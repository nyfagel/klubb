<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index() {
		$data['title'] = "Medlemsregistret";
		
		$html = row(columns(heading($this->lang->line('welcome'), 1), 12));
		$html .= row(columns(p($this->lang->line('intro_text')), 12));
		$data['html'] = $html;
		$this->load->view('template', $data);
	}
}

?>