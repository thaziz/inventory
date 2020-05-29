<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Wallboard extends MX_Controller {

	/**
	 *
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'campaign');
		if(!isset($this->menu['rule']['panel/campaign'])){
			show_404();
		}
		$this->load->model('Dashboard_campaign_model','dashboard_campaign');

	}

	public function widget($id){
		header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache');
		//$this->printflush('retry: 5000\n');
		/*if ($this->session->userdata('widget_run')) {
			$has_run = $this->session->userdata('widget_run');
		} else {
			$has_run = true;
			$this->session->set_userdata('widget_run', $has_run);
		}
		if ($has_run) {*/
			//while(connection_status() == CONNECTION_NORMAL){
				$data = $this->dashboard_campaign->get_widget_values($id);
				$data = $data[0];
				//sleep(100);
				echo "data: {\n";
				echo "data: \"total_ptp\":\"".$data->total_ptp."\",\n";
				echo "data: \"total_ptp_amount\":\"Rp ".$data->total_ptp_amount."\",\n";
				echo "data: \"total_bp\":\"".$data->total_bp."\",\n";
				echo "data: \"total_bp_amount\":\"Rp ".$data->total_bp_amount."\",\n";
				echo "data: \"total_paid\":\"".$data->total_paid."\",\n";
				echo "data: \"total_apid_amount\":\"Rp ".$data->total_paid_amount."\",\n";
				echo "data: \"total_paidoff\":\"".$data->total_paidoff."\",\n";
				echo "data: \"total_paidoff_amount\":\"Rp ".$data->total_paid_amount."\"\n";
				echo "data: }\n\n";

				ob_flush();
	    		flush();
			//}
		//}

	}

	public function agent_wb($id){
		header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache');
		//$this->printflush('retry: 5000\n');
		/*if ($this->session->userdata('widget_run')) {
			$has_run = $this->session->userdata('widget_run');
		} else {
			$has_run = true;
			$this->session->set_userdata('widget_run', $has_run);
		}
		if ($has_run) {*/
			//while(connection_status() == CONNECTION_NORMAL){
				$data = $this->dashboard_campaign->get_agent_wb($id);
				//sleep(100);
				echo "data: {\n";
				echo "data: \"data_agent\":".json_encode($data)."\n";
				echo "data: }\n\n";

				ob_flush();
	    		flush();
			//}
		//}
	}

	private function jsonflush($data)
	{

	    $r = json_encode($data);
	    $this->printflush("data: $r\n\n");
	}

	private function printflush($s)
	{
	    print $s;
	    ob_flush();
	    flush();
	}

}