<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'/third_party/Box/Spout/Autoloader/autoload.php';
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\Style;
use Box\Spout\Writer\Style\Border;
use Box\Spout\Writer\Style\BorderBuilder;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\WriterFactory;

class request_order extends MX_Controller {

	/**
	 *
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'Request Order');
		if(!isset($this->menu['rule']['panel/request_order'])){
			show_404();
		}
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		var_dump(1);exit();

	}

	public function index(){
		var_dump(1);exit();
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/request_order']['v']);
		if($_POST && $auth){
			$list = $this->campaign_model->get_load_result($this->menu['rule']['panel/request_order']);
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $campaign) {
	            $no++;
	            $row = array();
	            $row[] = $campaign->campaign_id;
	            $row[] = $no;
	            $row[] = $campaign->campaign_name;
	            $row[] = $campaign->date_range;
	            $row[] = $campaign->adm_name;
	            $data[] = $row;
	        }

	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->campaign_model->count_all($this->menu['rule']['panel/campaign']),
	                        "recordsFiltered" => $this->campaign_model->count_filtered($this->menu['rule']['panel/campaign']),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			//write user activity to logger
            $data['rules'] = $this->menu['rule']['panel/request_order'];
			$data['created_by'] = $this->campaign_model->get_campaign_creator();
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS CAMPAIGN MENU');
			$this->template->view('view_campaign', $data);
		}
	}

}
