<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {

	/**
	 * 
	 */

	public function __construct(){
		//$this->delete_temp();
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'dashboard');
//echo $this->db->last_query();exit;
		$this->load->model('chart_model');
		$this->load->model('dash_model');
		$r = $this->menu_model->get_rules('admin');
		//$this->load->model('settings/configuration_model', 'config_model');

		if(!isset($r['panel'])){
			foreach ($r as $key => $value) {
				if($value){
					redirect(base_url($key));
				}
			}
		}

		if(!isset($this->menu['rule']['panel'])){
			show_404();
		}
	}

	public function index(){
		$data['menu'] = $this->menu;
		
		$this->template->set_auth($this->menu['rule']['panel']['v']);
		// check log configuration and do action
		/*$this->auto_check_logs();

		$data['all_call_records']		=	$this->chart_model->all_call_records();
		$data['failed_rating'] 			=	$this->chart_model->failed_rating();
		$data['number_of_calls']		=	$this->chart_model->number_of_calls();
		//$data['for_off_date']			=	$this->chart_model->number_of_calls($off_date);
		$data['total_call_duration']	=	$this->chart_model->total_call_duration();
		$data['average_call']			=	$this->chart_model->average_call_duration();
		$data['total_sellcost']			=	$this->chart_model->total_sell_cost();
		$data['avg_call_perhour']		=	$this->chart_model->average_call_perhour();
		$data['call_status_cancel']		=	$this->chart_model->call_status_cancel();
		$data['call_status_chaunavail']	=	$this->chart_model->call_status_chaunavail();
		$data['call_status_answer']		=	$this->chart_model->call_status_answer();
		$data['call_status_busy']		=	$this->chart_model->call_status_busy();
		$data['cus_sip']				=	$this->dash_model->stat_sip_group();
		$data['last_call']				=	$this->dash_model->last_call();*/
		$this->template->view('view_dashboard', $data);
	}

	private function is_aday($time){
		$datetime1 = new DateTime(date("Y-m-d H:i:s",$time));
	    $datetime2 = new DateTime("now");;
	    
	    $diff = $datetime2->diff($datetime1);
	    
	    return $diff->days;
	}

	private function delete_temp(){
		$dir = array_diff(scandir('tmp/'), array('.', '..'));
		foreach ($dir as $value) {
			if(is_dir($d = 'tmp/'.$value) && $value != 'rating'){
				$files = array_diff(scandir('tmp/'.$value.'/'), array('.', '..'));
				$count = count($files);
				$fdel = array();
				foreach ($files as $f) {
					if($this->is_aday(filectime($d.'/'.$f))>=1){
						$fdel['files'][] = $d.'/'.$f;
						$count--;
					}
				}
				if($count<1){
					#rmdir($d);
					$fdel['dir'][] = $d;
				}
				$response = shell_exec('nohup python '.FCPATH.'application/py/delete_file.py ' . escapeshellarg(json_encode($fdel)).' > /dev/null 2>/dev/null &');
			}
		}
	}

	private function auto_check_logs(){
		$conf = $this->config_model->find_by_conf_string('user log max time to keep');
		if($conf->conf_value!=0){
			$this->dash_model->delete_log('v_userlog', 'date',$conf->conf_value);
		}
		$conf = $this->config_model->find_by_conf_string('api log max time to keep');
		if($conf->conf_value!=0){
			$this->dash_model->delete_log('v_log_api', 'date',$conf->conf_value);
		}
		$conf = $this->config_model->find_by_conf_string('call log max time to keep');
		if($conf->conf_value!=0){
			$this->dash_model->delete_log('v_log', 'date',$conf->conf_value);
		}
		$conf = $this->config_model->find_by_conf_string('cdr max time to keep');
		if($conf->conf_value!=0){
			$this->dash_model->delete_log('v_cdr', 'cdr_starttime',$conf->conf_value);
		}
	}

	public function chart_result(){
		if($_POST){
			if($_POST['type']	==	'callperday'){
				$summary_charts	=	$this->chart_model->get_callperday_chart();
				echo json_encode($summary_charts);
			}
		}else{
			return 'invalid';
		}
	}

}
