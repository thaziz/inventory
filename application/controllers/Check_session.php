<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	header('Content-Type: text/event-stream');
	header('Cache-Control: no-cache');
	date_default_timezone_set('Asia/Jakarta');
	/**
	 * 
	 */
	class Check_session extends CI_Controller
	{
		
		public function sess_avail()
		{
			echo json_encode((isset($this->session->userdata['logged_in'])) ? $this->session->userdata['logged_in'] : false);
			/*echo (isset($this->session->userdata['logged_in'])) ? $this->session->userdata['logged_in'] : 0;*/
		}
	}
?>