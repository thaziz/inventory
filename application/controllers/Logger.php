<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logger extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct(){
		parent::__construct();
	}

	public function writexhrlog(){
   $act = isset($_POST['act'])?$_POST['act']:'';
   $ext = $this->session->userdata('ext');
		$xhr = $_POST['xhr'];
		$error = $_POST['error'];
		$status = $_POST['status'];
    write_file(FCPATH.'logs/js_'.date('Y-m-d').'.log', date('Y-m-d H:i:s').': '.$ext.'  act '.$act.PHP_EOL);
		write_file(FCPATH.'logs/js_'.date('Y-m-d').'.log', date('Y-m-d H:i:s').': JQXHR response text '.$xhr.PHP_EOL);
		write_file(FCPATH.'logs/js_'.date('Y-m-d').'.log', date('Y-m-d H:i:s').': Status '.$status.PHP_EOL);
		write_file(FCPATH.'logs/js_'.date('Y-m-d').'.log', date('Y-m-d H:i:s').': Error '.$error.PHP_EOL);
	}

}
