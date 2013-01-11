<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * About class.
 * 
 * @extends CI_Controller
 */
class About extends CI_Controller {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		
		$this->load->language('klubb');
		$this->load->model('log_model');
		$this->load->model('user_model');
		$this->load->model('member_model');
		$this->load->model('system_model');
		
		$this->load->helper('language');
		$this->load->helper('date');
		log_message('debug', 'Controller loaded: about');
	}

	/**
	 * index function.
	 * 
	 * @access public
	 * @return void
	 */
	public function index() {
		$this->output->enable_profiler(false);
		if (!$this->auth->loggedin()) {
			redirect('user/login');
		}
		$data['title'] = $this->system_model->get('app_name');
		
		$html = row(columns(heading(ucfirst(lang('about')).' '.$this->system_model->get('app_name'), 1), 12));
		$uptime_array = explode(" ", exec("cat /proc/uptime"));
		$seconds = round($uptime_array[0], 0);
		$minutes = $seconds / 60;
		$hours = $minutes / 60;
		$days = floor($hours / 24);
		$hours = sprintf('%02d', floor($hours - ($days * 24)));
		$minutes = sprintf('%02d', floor($minutes - ($days * 24 * 60) - ($hours * 60)));
		if ($days == 0):
			$uptime = $hours.":".$minutes;
		elseif($days == 1):
			$uptime = $days." ".lang('day').", ".$hours.":".$minutes;
		else:
			$uptime = $days . " ".lang('days').", ".$hours.":".$minutes;
		endif;
		
		$infolist = ul(array(
			heading('Applikation', 5).ul(array(
				strong('Klubb-'.lang('version').': ').KLUBB_VERSION,
				strong('CodeIgniter-'.lang('version').': ').CI_VERSION,
				strong(ucfirst(lang('database')).': ').$this->db->platform().', '.lang('version').': '.$this->db->version(),
				strong(ucfirst(lang('environment').': ')).lang(ENVIRONMENT))),
			heading('Server', 5).ul(array(
				strong('Namn: ').php_uname('n'),
				strong('System: ').php_uname('s').' '.php_uname('r').' '.php_uname('v').' '.php_uname('m'),
				strong('Upptid: ').$uptime,
				strong('Apache-version: ').apache_get_version(),
				strong('Apache-moduler: ').implode(', ', apache_get_modules()),
				strong('PHP-version: ').phpversion(),
				strong('PHP-moduler: ').implode(', ', get_loaded_extensions())))), array('class' => 'no-bullet'));
		$html .= row(columns($infolist));
		$data['breadcrumbs'] = array(array('data' => anchor('/', $this->system_model->get('app_name')), 'mode' => 'unavailable'), array('data' => anchor('about', ucfirst(lang('about').' '.$data['title'])), 'mode' => 'current'));
		$data['html'] = $html;
		$this->system_model->view('template', $data);
	}
}

?>