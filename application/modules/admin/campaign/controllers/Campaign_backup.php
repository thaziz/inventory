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

class Campaign extends MX_Controller {

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
		$this->load->model('campaign_model');
		$this->load->model('data_campaign_model', 'data_campaign');
		$this->load->model('agent_campaign_model', 'agent_campaign');
        $this->load->model('assign_campaign_model', 'assign_campaign');
		$this->load->model('report_campaign_model', 'report_campaign');
		$this->load->model('Dashboard_campaign_model','dashboard_campaign');
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		
	}

	public function index(){
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['v']);
		if($_POST && $auth){
			$list = $this->campaign_model->get_load_result();
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
	                        "recordsTotal" => $this->campaign_model->count_all(),
	                        "recordsFiltered" => $this->campaign_model->count_filtered(),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/campaign'];
			$data['created_by'] = $this->campaign_model->get_campaign_creator();
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS CAMPAIGN MENU');
			$this->template->view('view_campaign', $data);
		}
	}

	public function campaign_insert(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['c']);
		if($_POST && $auth){
			$flag = true;
            $this->form_validation->set_rules('campaign_name', 'Name', 'required');
            $this->form_validation->set_rules('retries', 'retries', 'required');
            $this->form_validation->set_rules('script', 'Script', 'required');
            $this->form_validation->set_rules('date_range', 'Date Range', 'required');
            if(empty($_POST['stime_perday'])){
            	$flag = false;
            	$data['e']['stime_perday'] = '<div class="has-error">Schedule per day is required</div>';
            }
            if(empty($_POST['etime_perday'])){
            	$flag = false;
            	$data['e']['etime_perday'] = '<div class="has-error">Schedule per day is required</div>';
            }
            if(!isset($_POST['el'])){
            	$flag = false;
            	$data['e']['form'] = '<div class="has-error">Form is required</div>';
            }
            if ($this->form_validation->run() == false || !$flag){
            	$data['status'] = false;
            	$data['e']['campaign_name'] = form_error('campaign_name', '<div class="has-error">', '</div>');
            	$data['e']['retries'] = form_error('retries', '<div class="has-error">', '</div>');
            	$data['e']['script'] = form_error('script', '<div class="has-error">', '</div>');
            	$data['e']['date_range'] = form_error('date_range', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else{
            	$el = array();
                foreach ($_POST['el'] as $key => $value) {
                    $value['label'] = $value['name'];
                    $value['name'] = strtolower(preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', $value['label'])));
                    $el[] = $value;
                }
                $_POST['form']= json_encode($el);
                $_POST['el'] = $el;
                //secho json_encode($el);
            	if($id = $this->campaign_model->insert()){
            		//write_log($this->session->userdata['name'], 'INSERT CAMPAIGN ID: '.$this->db->insert_id().' NAME: '.$_POST['campaign_name']);
            		echo json_encode(array('status'=>true, 'id'=>$id));
            	}else{
            		echo json_encode(array('status'=>false, 'msg'=>'FAILED INSERTING DATA'));
            	}
            }
		}else{
			$data['menu'] = $this->menu;
	        //$this->userlog->add_log($this->session->userdata['name'], 'ACCESS INSERT CAMPAIGN MENU');
			$this->template->view('view_campaign_insert', $data);
		}
	}

	public function campaign_detail($id){
		$data['menu'] = $this->menu;
		if($this->template->set_auth($this->menu['rule']['panel/campaign']['v'])){
			$data['data'] = $this->campaign_model->detail_id($id);
			//$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW CAMPAIGN ID: '.$id.' NAME: '.$data['data']->cus_name);
		}
		$this->template->view('view_campaign_detail', $data);
	}

	public function campaign_edit($id){
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['e']);
		if($_POST && $auth){
			$flag = true;
            $this->form_validation->set_rules('campaign_name', 'Name', 'required');
            $this->form_validation->set_rules('retries', 'retries', 'required');
            $this->form_validation->set_rules('script', 'Script', 'required');
            $this->form_validation->set_rules('date_range', 'Date Range', 'required');
            if(empty($_POST['stime_perday'])){
            	$flag = false;
            	$data['e']['stime_perday'] = '<div class="has-error">Schedule per day is required</div>';
            }
            if(empty($_POST['etime_perday'])){
            	$flag = false;
            	$data['e']['etime_perday'] = '<div class="has-error">Schedule per day is required</div>';
            }
            unset($_POST['el']);
            unset($_POST['form']);
            if ($this->form_validation->run() == false || !$flag){
            	$data['status'] = false;
            	$data['e']['campaign_name'] = form_error('campaign_name', '<div class="has-error">', '</div>');
            	$data['e']['retries'] = form_error('retries', '<div class="has-error">', '</div>');
            	$data['e']['script'] = form_error('script', '<div class="has-error">', '</div>');
            	$data['e']['date_range'] = form_error('date_range', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else{
                //secho json_encode($el);
            	if($this->campaign_model->update($id)){
            		//write_log($this->session->userdata['name'], 'INSERT CAMPAIGN ID: '.$this->db->insert_id().' NAME: '.$_POST['campaign_name']);
            		echo json_encode(array('status'=>true, 'id'=>$id));
            	}else{
            		echo json_encode(array('status'=>false, 'msg'=>'FAILED EDIT DATA'));
            	}
            }
		}else{
			$data['menu'] = $this->menu;
			$data['data'] = $this->campaign_model->find_by_id($id);
	        //$this->userlog->add_log($this->session->userdata['name'], 'ACCESS INSERT CAMPAIGN MENU');
			$this->template->view('view_campaign_edit', $data);
		}
	}

	public function campaign_delete(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['d']);
		if($auth){
			//$info = json_encode($this->campaign_model->find_name($_POST['cus_id']));
			//$info = str_replace('cus_','',str_replace('[', '', str_replace(']', '', $info)));
			if($this->campaign_model->delete()){
				//$this->userlog->add_log($this->session->userdata['name'], 
				//	'DELETE CAMPAIGN ID '.$info);
				$data['status'] = true;
			}else{
				$data['status'] = false;
			}
			print_r(json_encode($data));
		}else{
			$this->template->view('');
		}
	}

	public function data($id){
		$form = $this->campaign_model->get_form($id);
		$form = json_decode($form);
		$list = $this->data_campaign->get_load_data($id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $campaign) {
            $no++;
            $row = array();
            $row[] = $campaign->data_id;
            $row[] = $no;
            foreach ($form as $value) {
            	$row[] = $campaign->{'form_'.$value->name};
            }
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->data_campaign->count_all($id),
                        "recordsFiltered" => $this->data_campaign->count_filtered($id),
                        "data" => $data,
                );
        echo json_encode($output);
	}

	public function insert_data($id){
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['e']);
		$data['campaign'] = $this->campaign_model->find_by_id($id);
		if($_POST && $auth){
			$form = json_decode($data['campaign']->form, true);
			$idx = 0;
			foreach ($form as $val) {
				$label = $val['label'];
                $name = $val['name'];
                $names[] = $name;
                if(isset($val['required'])){
                    $min = '';
                    $max = '';
                    if($val['type']=='text'||$val['type']=='password'||$val['type']=='email'){
                        if($val['min']>0){
                            $min = '|min_length['.$val['min'].']';
                        }
                        if($val['max']>0){
                            $max = '|max_length['.$val['max'].']';
                        }
                    }
                    $email = '';
                    if($val['type']=='email'){
                        $email = '|valid_email';
                    }
                    $rule = 'required'.$email.$min.$max;
                    if($val['type']=='file'){
                    	if(empty($_FILES[$name]['name'])){
                    		$this->form_validation->set_rules($name, $label, $rule);
                    	}
                    }else{
                    	$this->form_validation->set_rules($name, $label, $rule);
                    }
                    $idx++;
                }
			}
			if ($this->form_validation->run() == false && $idx>0){
                $data = array();
                $data['status'] = false;
                foreach ($names as $key => $value) {
                    $data['e'][$value] = form_error($value, '<div class="has-error">', '</div>');
                }
                echo json_encode($data);
            }else{
            	$data = array();
                if(count($_FILES)>0){
                    $this->load->library('upload');
                    foreach ($_FILES as $key => $value) {
                        $path = '/uploads/project_files/'.date('Y-m-d').'/';
                        if (!is_dir($dir = 'assets'.$path)) {
                            mkdir($dir);
                        }
                        $config['allowed_types'] = '*';
                        $config['upload_path']   = $dir;

                        $this->upload->initialize($config);
                        if(!$this->upload->do_upload($key)){
                            //echo json_encode(array('status'=>'ERROR', 'errors'=>$this->upload->display_errors()));
                        }else{
                            $dataFile  = $this->upload->data();
                            $data['form_'.$key] = 'assets'.$path.$dataFile['file_name'];
                        }
                    }
                }
                foreach ($_POST as $key => $vp) {
                	$data['form_'.$key] = $vp;
                }
                if($this->data_campaign->insert($id, $data)){
                	echo json_encode(array('status'=>true));
                }else{
                	echo json_encode(array('status'=>false));
                }
            }
		}else{
			$data['menu'] = $this->menu;
			$this->template->view('view_data_form', $data);
		}
	}
	public function edit_data($id, $data_id){
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['e']);
		$data['campaign'] = $this->campaign_model->find_by_id($id);
		if($_POST && $auth){
			$form = json_decode($data['campaign']->form, true);
			$idx = 0;
			foreach ($form as $val) {
				$label = $val['label'];
                $name = $val['name'];
                $names[] = $name;
                if(isset($val['required'])){
                    $min = '';
                    $max = '';
                    if($val['type']=='text'||$val['type']=='password'||$val['type']=='email'){
                        if($val['min']>0){
                            $min = '|min_length['.$val['min'].']';
                        }
                        if($val['max']>0){
                            $max = '|max_length['.$val['max'].']';
                        }
                    }
                    $email = '';
                    if($val['type']=='email'){
                        $email = '|valid_email';
                    }
                    if($val['type']=='file'){
                    	if(empty($_FILES[$name]['name'])){
                    		$this->form_validation->set_rules($name, $label, 'required'.$email.$min.$max);
                    	}
                    }else{
                    	$this->form_validation->set_rules($name, $label, 'required'.$email.$min.$max);
                    }
                    $idx++;
                }
			}
			if ($this->form_validation->run() == false && $idx>0){
                $data = array();
                $data['status'] = false;
                foreach ($names as $key => $value) {
                    $data['e'][$value] = form_error($value, '<div class="has-error">', '</div>');
                }
                echo json_encode($data);
            }else{
            	$data = array();
                if(count($_FILES)>0){
                    $this->load->library('upload');
                    foreach ($_FILES as $key => $value) {
                        $path = '/uploads/project_files/'.date('Y-m-d').'/';
                        if (!is_dir($dir = 'assets'.$path)) {
                            mkdir($dir);
                        }
                        $config['allowed_types'] = '*';
                        $config['upload_path']   = $dir;

                        $this->upload->initialize($config);
                        if(!$this->upload->do_upload($key)){
                            //echo json_encode(array('status'=>'ERROR', 'errors'=>$this->upload->display_errors()));
                        }else{
                            $dataFile  = $this->upload->data();
                            $data['form_'.$key] = 'assets'.$path.$dataFile['file_name'];
                        }
                    }
                }
                foreach ($_POST as $key => $vp) {
                	$data['form_'.$key] = $vp;
                }
                if($this->data_campaign->update($id, $data_id, $data)){
                	echo json_encode(array('status'=>true));
                }else{
                	echo json_encode(array('status'=>false));
                }
            }
		}else{
			$data['menu'] = $this->menu;
			$data['data'] = $this->data_campaign->find_by_id($id, $data_id);
			$this->template->view('view_data_form', $data);
		}
	}

	public function delete_data($id){
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['e']);
		if($_POST && $auth){
			if($this->data_campaign->delete($id)){
				echo json_encode(array('status'=>true));
			}else{
				echo json_encode(array('status'=>false));
			}
		}
	}

	public function import_data($id){
        set_time_limit(900);
        $form = $this->campaign_model->get_form($id);
        $form = json_decode($form);
        $call = array();
        for ($i=0;$i<count($form);$i++) {
            $call[] = isset($form[$i]->call);
        }

		$this->load->library('upload');
        $path = '/uploads/'.date('Y-m-d-H_i_s').'/';
        if (!is_dir($dir = 'assets'.$path)) {
            mkdir($dir);
        }
        $config['allowed_types'] = 'xlsx';
        $config['upload_path']   = $dir;

        $this->upload->initialize($config);
        if(!$this->upload->do_upload('file')){
            echo json_encode(array('status'=>'ERROR', 'errors'=>$this->upload->display_errors()));
        }else{
            $dataFile  = $this->upload->data();
            $file = 'assets'.$path.$dataFile['file_name'];
			$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
			$reader->open(FCPATH.'/'.$file);
			$data = array();
            $header = array();
            for($i=0;$i<count($form);$i++) {
                $header[] = $form[$i]->label;
            }
			foreach ($reader->getSheetIterator() as $sheet) {
				$index=0;
				if ($sheet->getIndex() === 0) {
					//$rows = $sheet->getRowIterator();
					//print_r($rows);
					foreach ($sheet->getRowIterator() as $row) {
					    $index++;
                        $skip=false;
						if($index==1 && isset($_POST['header'])){
                            for($i=0;$i<count($header);$i++) {
                                $cell = trim($row[$i]);
                                $header[] = $cell;
                            }
			        		continue;
			        	}else{
					    	$data_row = array();
					        for($i=0;$i<count($header);$i++) {
                                $cell = '';
					        	if(is_object($row[$i])){
					        		$cell = $row[$i]->format('Y-m-d H:i:s');
					        	}else{
					        		$cell = $row[$i];
					        	}
                                if($call[$i]){
                                    $cell = str_replace(')','',$cell);
                                    $cell = str_replace('(','',$cell);
                                    $cell = str_replace('-','',$cell);
                                    $cell = str_replace(' ','',$cell);
                                    preg_match('/[0-9]+/', $cell, $match);
                                    if(count($match)>0){                                 
                                        $number = $match[0];
                                        if(substr($number,0,2)=='62'){
                                            $data_row[] = '0'.substr($number,2);
                                        }elseif(substr($number,0,1)!='0'){
                                            $data_row[] = '0'.$number;
                                        }else{
                                            $data_row[] = $number;
                                        }
                                    }else{
                                        $data_row[] = '-';
                                        $skip=true;
                                    }
                                }else{
                                    $data_row[] = $cell;
                                }
					        }
                            if(!$skip){
					           $data[] = $data_row;
                            }
					    }
				    }
			    }
			}
			$reader->close();
			if(unlink($file)){
				rmdir('assets'.$path);
			}
			$result = $this->data_campaign->insert_batch($id, $data);
            set_time_limit(30);
			echo json_encode($result);
        }


	}

	public function dashboard($id)
    {
        $data['menu'] = $this->menu;
        $auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['v']);
        if ($_POST && $auth) {
            
        }else{
            $data['data'] = $this->campaign_model->detail_id($id);
            $data['total'] = $this->dashboard_campaign->total_data($id);
            $data['call_status'] = $this->dashboard_campaign->call_status($id);
            $data['rules'] = $this->menu['rule']['panel/campaign'];
            $this->template->view('view_campaign_dashboard', $data);
        }
    }

	public function agents($id){
		$data['menu'] = $this->menu;
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['v']);
		if($_POST && $auth){
			$list = $this->agent_campaign->get_load_agents($id);
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $agent) {
	            $no++;
	            $row = array();
	            $row[] = $agent->assign_id;
	            $row[] = $no;
	            $row[] = $agent->adm_name;
	            $row[] = $agent->adm_ext;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->agent_campaign->count_all($id),
	                        "recordsFiltered" => $this->agent_campaign->count_filtered($id),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['data'] = $this->campaign_model->detail_id($id);
			$data['agent_count'] = $this->agent_campaign->count_all($id);
			$data['in'] = $this->agent_campaign->agents_in($id);
			$data['not_in'] = $this->agent_campaign->agents_not_in($id);
			$this->template->view('view_campaign_agents', $data);
		}		
	}

	public function submit_agents($id){
		if(isset($_POST['to'])){
			$data = array();
			foreach ($_POST['to'] as $value) {
				$data[] = array('adm_id'=>$value, 'campaign_id'=>$id);
			}
			if($this->agent_campaign->insert($id, $data)){
				echo json_encode(array('status'=>true));
			}else{
				echo json_encode(array('status' => false, 'msg'=>'Add agent(s) failed, cannot insert to database.'));
			}
		}else{
			echo json_encode(array('status' => false, 'msg'=>'Add agent(s) failed, you don\'t select any data.'));
		}
	}

	public function delete_agents($id){
		if($_POST){
			if($this->agent_campaign->delete($id)){
				echo json_encode(array('status'=>true));
			}else{
				echo json_encode(array('status'=>false));
			}
		}
	}

	public function assignment($id){
		$data['menu'] = $this->menu;
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['v']);
		if($_POST && $auth){
			$form = $this->campaign_model->get_form($id);
			$form = json_decode($form);
			$list = $this->assign_campaign->get_load_data($id);
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $campaign) {
	            $no++;
	            $row = array();
	            $row[] = $campaign->data_id;
	            $row[] = $no;
	            foreach ($form as $value) {
	            	$row[] = $campaign->{'form_'.$value->name};
	            }
	            $row[] = $campaign->adm_name;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->assign_campaign->count_all($id),
	                        "recordsFiltered" => $this->assign_campaign->count_filtered($id),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['data'] = $this->campaign_model->detail_id($id);
			$data['agent_count'] = $this->agent_campaign->count_all($id);
			$data['in'] = $this->assign_campaign->agents($id);
			//$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW CAMPAIGN ID: '.$id.' NAME: '.$data['data']->cus_name);
			$this->template->view('view_campaign_assign', $data);
		}
	}

	public function assign_to($id){
		$data = array();
		$ids = explode(',', $_POST['data_id']);
		if(is_array($ids)){
			for ($i=0;$i<count($ids);$i++) {
				$data[] = array('data_id'=>$ids[$i], 'assign_id'=>$_POST['assign_id']);
			}
		}else{
			$data[] = array('data_id'=>$ids, 'assign_id'=>$_POST['assign_id']);
		}

		if($this->assign_campaign->update_data($id, $data)){
			echo json_encode(array('status'=>true));
		}else{
			echo json_encode(array('status'=>false));
		}
	}

	public function unassign_agents($id){
		if($_POST){
			if($this->assign_campaign->unassign_agents($id)){
				echo json_encode(array('status'=>true));
			}else{
				echo json_encode(array('status'=>false));
			}
		}
	}

	public function auto_assign($id){
		if($this->assign_campaign->auto_assign($id)){
			echo json_encode(array('status'=>true));
		}else{
			echo json_encode(array('status'=>false));
		}
	}


    public function report($id)
    {
        $data['menu'] = $this->menu;
        $auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['v']);
        if($_POST && $auth){
            $form = $this->campaign_model->get_form($id);
            $form = json_decode($form);
            $list = $this->report_campaign->get_load_data($id);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $report) {
                $no++;
                $row = array();
                $row[] = $report->data_id;
                $row[] = $no;
                foreach ($form as $value) {
                    $row[] = $report->{'form_'.$value->name};
                }
                $row[] = !empty($report->adm_name)?$report->adm_name:'n/a';
                $row[] = !empty($report->caller)?$report->caller:'n/a';
                $row[] = !empty($report->retries)?$report->retries:'n/a';
                $row[] = !empty($report->call_date)?$report->call_date:'n/a';
                $row[] = !empty($report->api_status)?$report->api_status:'n/a';
                $row[] = !empty($report->call_status)?$report->call_status:'n/a';
                $row[] = !empty($report->duration)?$report->duration:'n/a';
                $row[] = !empty($report->merchant_status)?$report->merchant_status:'&nbsp;';
                $row[] = !empty($report->note)?$report->note:'n/a';
                $data[] = $row;
            }
     
            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->report_campaign->count_all($id),
                            "recordsFiltered" => $this->report_campaign->count_filtered($id),
                            "data" => $data,
                    );
            echo json_encode($output);
        }else{
            $data['data'] = $this->campaign_model->detail_id($id);
            $data['assigns'] = $this->assign_campaign->agents($id);
            $data['agents'] = $this->agent_campaign->agents_in($id);
            $data['canchange'] = $this->template->set_auth($this->menu['rule']['panel/campaign']['e']);
            //$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW CAMPAIGN ID: '.$id.' NAME: '.$data['data']->cus_name);
            $this->template->view('view_campaign_report', $data);
        }
    }

    public function change_status($id){
        $auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['e']);
        if($_POST && $auth){
            if($this->data_campaign->set_status($id)){
                echo json_encode(array('status'=>true));
            }else{
                echo json_encode(array('status'=>false));
            }
        }else{
            echo json_encode(array('status'=>false));
        }
    }

    public function export($id){
        $campaign = $this->campaign_model->detail_id($id);
        $form = json_decode($campaign->form);
        $list = $this->report_campaign->get_data_report($id);


        $border = (new BorderBuilder())
            ->setBorderBottom(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
            ->setBorderTop(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
            ->setBorderLeft(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
            ->setBorderRight(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
            ->build();

        $tstyle = (new StyleBuilder())
            //->setShouldWrapText()
            //->setShouldShrinkToFit()
            //->setHorizontalAlignment(Style::H_ALIGN_CENTER)
            ->build();

        $headstyle = (new StyleBuilder())
            ->setBorder($border)
            ->setFontBold()
            //->setShouldWrapText()
            //->setShouldShrinkToFit()
            //->setHorizontalAlignment(Style::H_ALIGN_CENTER)
            ->build();
        $style = (new StyleBuilder())
            ->setBorder($border)
            //->setShouldWrapText()
            //->setShouldShrinkToFit()
            //->setHorizontalAlignment(Style::H_ALIGN_CENTER)
            ->build();

        $header = array();
        $header[] = 'No';
        $alpha = 'I';
        foreach ($form as $value) {
            $header[] = $value->label;
            $alpha++;
        }

        $header[] = 'Assignment';
        $header[] = 'Caller';
        $header[] = 'Attemp';
        $header[] = 'Call Date';
        $header[] = 'Call Status';
        $header[] = 'Duration';
        $header[] = 'Merchant Status';
        $header[] = 'Note';

        $writer = WriterFactory::create(Type::XLSX);
        $filename='campaign '.strtolower($campaign->campaign_name).' report.xlsx';
        //header('Content-type: application/vnd.ms-excel');
        //header('Content-Disposition: attachment; filename="'.$filename.'"');
        //$writer->openToFile('php://output');
        //$writer->addMergeCell('A1',$alpha.'1');
        $writer->openToBrowser($filename);
        //$writer->addRow(['Data Report Campaign '.$campaign->campaign_name]);
        $writer->addRowWithStyle(['Data Report Campaign '.$campaign->campaign_name], $tstyle);
        //echo json_encode($list);
        //exit;
        $writer->addRowWithStyle($header, $headstyle);
        

        $no = 0;
        $data = array();
        foreach ($list as $report) {
            $no++;
            $row = array();
            $row[] = $no;
            foreach ($form as $value) {
                $row[] = $report->{'form_'.$value->name};
            }
            $row[] = !empty($report->adm_name)?$report->adm_name:'n/a';
            $row[] = !empty($report->caller)?$report->caller:'n/a';
            $row[] = !empty($report->retries)?$report->retries:'n/a';
            $row[] = !empty($report->call_date)?$report->call_date:'n/a';
            $row[] = !empty($report->call_status)?$report->call_status:'n/a';
            $row[] = !empty($report->duration)?$report->duration:'n/a';
            $row[] = !empty($report->merchant_status)?$report->merchant_status:'';
            $row[] = !empty($report->note)?str_replace('&nbsp', '',strip_tags($report->note)):'n/a';
            $data[] = $row;
        }
        $writer->addRowsWithStyle($data, $style);
        $writer->close();
        exit;


	}
	
	public function import()
	{
		echo '<pre>';
		print_r($_POST);
		echo '</pre>';
	}

    public function status_call()
    {
        $data['labels']     =   array();
        $data['datasets']   =   array();
        $datasets           =   '';
        $status_call    =   $this->dashboard_campaign->status_call($_GET);
        /*echo '<pre>';
        print_r($status_call);
        echo '</pre>';
        exit;*/
        for ($i=0; $i < count($status_call); $i++) {
            if($status_call[$i]->call_status == ''){
                $status_call[$i]->call_status = 'status empty';
            }

            $datasets = array(
                'fillColor'     =>  'rgba(220,220,220,0.5)',
                'strokeColor'   =>  'rgba(220,220,220,1)',
                'data'          =>  array($status_call[$i]->call_status_count)
            );
            array_push($data['labels'],$status_call[$i]->call_status);
            array_push($data['datasets'],$datasets);
        }
        /*echo '<pre>';
        print_r($data);
        echo '</pre>';*/
        echo json_encode(array('result' =>  $data));
    }

    public function status_data()
    {
        /*$data['labels']       =   array();
        $data['datasets']   =   array();*/
        $datasets           =   '';
        $status_call    =   $this->dashboard_campaign->status_data($_GET);
        for ($i=0; $i < count($status_call); $i++) { 
            if(trim($status_call[$i]->status) == ''){
                $status_call[$i]->status = 'status empty';
            }
            $datasets[$i] = array(
                'status'        =>  $status_call[$i]->status,
                'status_count'  =>  $status_call[$i]->status_count
            );
        }
        /*for ($i=0; $i < count($status_call); $i++) {
            if($status_call[$i]->status == ''){
                $status_call[$i]->status = 'status empty';
            }

            $datasets = array(
                'fillColor'     =>  'rgba(220,220,220,0.5)',
                'strokeColor'   =>  'rgba(220,220,220,1)',
                'data'          =>  array($status_call[$i]->status_count)
            );
            array_push($data['labels'],$status_call[$i]->status);
            array_push($data['datasets'],$datasets);
        }*/
        echo json_encode(array('result' =>  $datasets));
    }

    public function get_line_chart()
    {
        if($_POST)
        {
            if($_POST['type']   ==  'callperday')
            {
                $start_date_time    =   $_POST['start_date'].' '.$_POST['start_time'];
                $end_date_time      =   $_POST['end_date'].' '.$_POST['end_time'];
                $line_chart =    $this->dashboard_campaign->call_status_date($_POST['id'],$start_date_time,$end_date_time);
                echo json_encode(array('graph'=>$line_chart));
            }
            else if($_POST['type']  ==  'merchant_status')
            {
                $data = '';
                $datasets = '';
                $start_date_time    =   $_POST['start_date'].' '.$_POST['start_time'];
                $end_date_time      =   $_POST['end_date'].' '.$_POST['end_time'];
                $pie_chart  =   $this->dashboard_campaign->merchant_status($_POST['id'],$start_date_time,$end_date_time);

                /*echo '<pre>';
                print_r($pie_chart);
                echo '</pre>';
                exit;*/
                echo json_encode(array('graph'  =>  $pie_chart));
            }
        }
    }
}