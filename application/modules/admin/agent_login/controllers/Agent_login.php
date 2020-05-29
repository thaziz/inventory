<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'/third_party/Box/Spout/Autoloader/autoload.php';
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\Style;
use Box\Spout\Writer\Style\Border;
use Box\Spout\Writer\Style\BorderBuilder;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\WriterFactory;

class Agent_login extends MX_Controller {

	/**
	 * 
	 */
	var $time_limit = 0;

	public function __construct(){
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'administrator');
		$this->load->model('agent_login_model');
		$this->load->model('config_model');
		$this->time_limit = (int)$this->config_model->get_config('php_max_execution_time');
	}

	public function index(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/agent_login']['v']);
		if($_POST && $auth){
			$list = $this->agent_login_model->get_load_result();
	        $data = array();
	        $no = $_POST['start'];
	        $sell = 0;
	        foreach ($list as $cdr) {
	            $no++;
	            $row = array();
	            $row[] = $no;
	            $row[] = $cdr->adm_name;
	            $row[] = $cdr->adm_ext;
	            $row[] = $cdr->login_time;
	            $row[] = $cdr->logout_time;
	            $row[] = $cdr->total;
	            $data[] = $row;
	        }
	        /*$query = $this->db->last_query();
	        $this->load->helper('file');
	        write_file('application/file.txt',$query);*/
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->agent_login_model->count_all(),
	                        "recordsFiltered" => $this->agent_login_model->count_filtered(),
	                        "data" => $data,
	                );
	        //$query = $this->db->last_query();
	        //$this->load->helper('file');
	        //write_file('application/file.txt',$query);
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			$data['rules'] = $this->menu['rule']['panel/agent_login'];
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS AGENT LOGIN REPORT');
			$this->template->view('view_agent_login', $data);
		}
	}

	/*public function test(){
		set_time_limit(1800);
		$border = (new BorderBuilder())
		    ->setBorderBottom(Color::GREEN, Border::WIDTH_THIN, Border::STYLE_DASHED)
		    ->build();

		$style = (new StyleBuilder())
		    ->setBorder($border)
		    ->setShouldWrapText()
		    ->setShouldShrinkToFit()
	        //->setHorizontalAlignment(Style::H_ALIGN_CENTER)
		    ->build();

		$writer = WriterFactory::create(Type::XLSX);
		$filename='call_reports_detail.xlsx';
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		$writer->openToFile('php://output');
		$writer->addMergeCell('A1','D1');
		$writer->addRowWithStyle(['Hello This is'], $style);
		$data = array();
        for ($i=0; $i<7; $i++) {
           	$value = new stdClass();
           	$value->cdr_starttime = 'start_time';
           	$value->cus_name = 'cus name';
           	$value->ext = 'extends';
           	$value->pre_destination = 'destination';
           	$value->cdr_dialednumber = 'numbrs';
           	$value->cus_cdr_duration = 'duration';
           	$value->trunk_ip = '10913.31.112';
           	$value->trunk_name = 'rtatas';
           	$value->cus_cal_name = 'calfnmgfd';
           	$value->lis_name = 'sfafsfd';
           	$value->loc_name = 'faa';
           	$value->cdr_customersellprice = 'dsasdas';
           	$value->rat_time = 'asdsa';
           	$value->dep_name = 'asdsad';
			$writer->addRowWithStyle((array) $value, $style);
        }

		$writer->close();
		echo 'done';
	}*/

	public function total_usage(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/cdr']['v']);
		if($auth){
			echo number_format($this->agent_login_model->get_total_usage(), $this->agent_login_model->get_decimal_format());
		}else{
			$this->template->view('view_cdr');
		}
	}

	public function export_summary(){
		set_time_limit($this->time_limit);
		$auth = $this->template->set_auth($this->menu['rule']['panel/cdr']['v']);
		if($_POST && $auth){
			//format start date from filter
			$start = date_format(date_create($_POST['filter_field']['start_date']), 'd-M-Y')
							.' '.$_POST['filter_field']['start_time'];
			//format end date from filter
        	$end = date_format(date_create($_POST['filter_field']['to_date']), 'd-M-Y')
        					.' '.$_POST['filter_field']['to_time'];
        	//get decimal format from setting
        	$dec = $this->agent_login_model->get_decimal_format();
        	//generate advanced search field
        	$search=$this->agent_login_model->get_search_detail($_POST['adv_search'], $_POST['opt']);
        	//get data from database;
			$data = $this->agent_login_model->get_data_summary();
			//create border style
			$border = (new BorderBuilder())
		    ->setBorderBottom(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
		    ->build();
			$header_style = (new StyleBuilder())
				->setFontBold()
			    ->setBorder($border)
			    ->setShouldWrapText()
			    ->build();

			$content_style = (new StyleBuilder())
			    ->setBorder($border)
	           	->setFontSize(11)
			    ->setShouldWrapText()
			    ->build();

			//create title style
			$title_style = (new StyleBuilder())
	           ->setFontBold()
	           ->setFontSize(15)
	           ->setFontColor(Color::RED)
	           ->setHorizontalAlignment(Style::H_ALIGN_CENTER)
	           ->setShouldWrapText()
	           ->build();

			//start writer Spout
			$writer = WriterFactory::create(Type::XLSX);
			$filename='call_reports_summary.xlsx';
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			$writer->openToFile('php://output'); //write output to download browser

			//set sheet name
			$sheet = $writer->getCurrentSheet();
			$sheet->setName('CBilling Call Reports Detail');

			$writer->addMergeCell('A1','J1');
			$writer->addRowWithStyle(['Summary Telephony Usage '.$start.' To '.$end], $title_style);
			$writer->addRow(['']);

			foreach ($search as $key=>$value) {
			    $writer->addRow([$key, $value]);
			}

			$writer->addRow(['Periode', $start, 'To', $end]);

			$writer->addRow(['']);
			$writer->addRowsWithStyle($data, $content_style);
            
			$writer->close();
			$this->userlog->add_log($this->session->userdata['name'], 'EXPORT CALL REPORT CDR');
		}else{
			$this->template->view('view_cdr');
		}
	}

	/*public function export_detail(){
		set_time_limit($this->time_limit);
		$auth = $this->template->set_auth($this->menu['rule']['panel/cdr']['v']);
		if($_POST && $auth){
			//format start date from filter
			$start = date_format(date_create($_POST['filter_field']['start_date']), 'd-M-Y')
							.' '.$_POST['filter_field']['start_time'];
			//format end date from filter
        	$end = date_format(date_create($_POST['filter_field']['to_date']), 'd-M-Y')
        					.' '.$_POST['filter_field']['to_time'];
        	//get decimal format from setting
        	$dec = $this->agent_login_model->get_decimal_format();
        	//generate advanced search field
        	$search=$this->agent_login_model->get_search_detail($_POST['adv_search'], $_POST['opt']);
        	//get data from database;
			$data = $this->agent_login_model->get_data_filtered();
			
			//create border style
			$border = (new BorderBuilder())
		    ->setBorderBottom(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
		    ->build();
			$header_style = (new StyleBuilder())
				->setFontBold()
			    ->setBorder($border)
			    ->setShouldWrapText()
			    ->build();

			$content_style = (new StyleBuilder())
			    ->setBorder($border)
			    ->setShouldWrapText()
			    ->build();

			//create title style
			$title_style = (new StyleBuilder())
	           ->setFontBold()
	           ->setFontSize(15)
	           ->setFontColor(Color::RED)
	           ->setHorizontalAlignment(Style::H_ALIGN_CENTER)
	           ->setShouldWrapText()
	           ->build();

			//start writer Spout
			$writer = WriterFactory::create(Type::XLSX);
			$filename='call_reports_detail.xlsx';
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			$writer->openToFile('php://output'); //write output to download browser

			//set sheet name
			$sheet = $writer->getCurrentSheet();
			$sheet->setName('CBilling Call Reports Detail');

			$writer->addMergeCell('A1','N1');
			$writer->addRowWithStyle(['Export Data Billing From '.$start.' To '.$end], $title_style);
			$writer->addRow(['']);

			foreach ($search as $key=>$value) {
			    $writer->addRow([$key, $value]);
			}

			$writer->addRow(['Periode', $start, 'To', $end]);

			$writer->addRow(['']);

			//build header array and write them to row
			$header = array('Date', 'User', 'Extension', 'Destination', 'Dialed Number', 
						'Duration', 'Trunk IP', 'Trunk Name', 'Call name', 'List name',
						'Loc Name', 'Customer Price', 'Rate Time', 'Department Name');
			$writer->addRowWithStyle($header, $header_style);

            //write data row to excel
            foreach ($data as $value) {
            	$content = array($value->cdr_starttime, $value->cus_name, $value->ext, 
            				$value->pre_destination, $value->cdr_dialednumber, $value->cus_cdr_duration, 
            				$value->trunk_ip, $value->trunk_name, $value->cus_cal_name, $value->lis_name, 
            				$value->loc_name, $value->cdr_customersellprice, $value->rat_time, $value->dep_name);
            	$writer->addRowWithStyle($content, $content_style);
            }
			$writer->close();
			$this->userlog->add_log($this->session->userdata['name'], 'EXPORT CALL REPORT CDR');
		}else{
			$this->template->view('view_cdr');
		}
	}*/

	public function export_detail(){
		set_time_limit($this->time_limit);
		$auth = $this->template->set_auth($this->menu['rule']['panel/cdr']['v']);
		if($_POST && $auth){
			//format start date from filter
			$start = date_format(date_create($_POST['filter_field']['start_date']), 'd-M-Y')
							.' '.$_POST['filter_field']['start_time'];
			//format end date from filter
        	$end = date_format(date_create($_POST['filter_field']['to_date']), 'd-M-Y')
        					.' '.$_POST['filter_field']['to_time'];
        	//get decimal format from setting
        	$dec = $this->agent_login_model->get_decimal_format();
        	//generate advanced search field
        	$search=$this->agent_login_model->get_search_detail($_POST['adv_search'], $_POST['opt']);
        	//get data from database;
			$query = $this->agent_login_model->get_data_filtered();
			$header = array();
			foreach ($_POST['col_name'] as $key => $value) {
				if($value!='0'){
					$header[] = $value;
				}
			}

			$username = $this->session->userdata['name'];

			if(!is_dir('tmp/'.$username)){
				if(mkdir('tmp/'.$username))
					echo 'directory was created';
			}
			
			$xlsx_data['file_name'] = 'tmp/'.$username.'/call_reports_detail_'.date('Y-m-d_H-i').'n.xlsx';
			$xlsx_data['sheet_name'] = 'CBilling Call Reports Detail';
			$xlsx_data['title'] = ['cell'=>'A1:N1', 'text'=>'Export Data Billing From '.$start.' To '.$end];

			foreach ($search as $key=>$value) {
			    $xlsx_data['search'][] = [$key, $value];
			}
			$xlsx_data['search'][] = ['Periode',$start, 'To', $end];
			$xlsx_data['header'] = $header;/*['Date', 'Customer', 'Extension', 'Call Plan', 'CallerID', 'Dialed Number', 
						'Call List','Duration', 'Customer Price', 'Call Status'];*/
			//to determine column data with specific format
			$price_index = array_search('Customer Price', $header);
			$xlsx_data['date_col'] = [0];
			if($price_index!=false){
				$xlsx_data['money_col'] = [$price_index];
			}else{
				$xlsx_data['money_col'] = [];
			}
			$xlsx_data['sql'] = $query;
            
            $response = shell_exec('nohup python '.FCPATH.'application/py/create_excel.py ' . str_replace('\n',' ',escapeshellarg(json_encode($xlsx_data))).' > /dev/null 2>/dev/null &');
            echo str_replace('\n',' ',escapeshellarg(json_encode($xlsx_data)));
            var_dump($response);
			$this->userlog->add_log($this->session->userdata['name'], 'EXPORT CALL REPORT CDR');
		}else{
			$this->template->view('view_cdr');
		}
	}

	public function load_dep(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/cdr']['v']);
		if($auth){
			$cbu_id = empty($_POST['cbu_id'])?null: $_POST['cbu_id'];
			$list = $this->agent_login_model->get_dep_list($cbu_id);
			$html = array();
			$html[] = '<option value></option>';
			foreach ($list as $key => $value) {
				$html[] = '<option value="'.$key.'">'.$value.'</option>';
			}
			echo implode('', $html);
		}else{
			$this->template->view('view_cdr');
		}
	}

	public function load_calllist(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/cdr']['v']);
		if($auth){
			$html = array();
			$html[] = '<option value></option>';
			if(!empty($_POST['call_id'])){
				$list = $this->agent_login_model->get_calllist($_POST['call_id']);
				foreach ($list as $key => $value) {
					$html[] = '<option value="'.$key.'">'.$value.'</option>';
				}
			}
			echo implode('', $html);
		}else{
			$this->template->view('view_cdr');
		}
	}


	public function cdr_delete(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/cdr']['d']);
		if($auth){
			if($this->agent_login_model->delete()){
				$this->userlog->add_log($this->session->userdata['name'], 'DELETE CALL REPORT CDR');
				$data['status'] = true;
			}else{
				$data['status'] = false;
			}
			print_r(json_encode($data));
		}
	}

}
