<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MX_Controller {

	/**
	 * 
	 */

	public function __construct(){
		$this->load->model('call_model');
		$this->load->model('ticketing_model');
	}

	public function index(){
		echo md5('annas');
	}

	public function status_call(){
		if($this->call_model->update_status()){
			echo json_encode(array('status'=>'OK'));
		}else{
			echo json_encode(array('status'=>'ERROR'));			
		}
	}

	public function testid(){
		$ext=20223;
		echo $this->ticketing_model->generate_ticket_id($ext);
	}

	public function form_ticket($auth){
		if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
			if($_GET){
				$data = array();
				if(isset($_GET['phone'])){
					$phone = $_GET['phone'];//preg_replace('/^0/', '62', $_GET['phone']);
				}else{
					$phone = '';
				}
				$data['agent'] = preg_replace('/[^0-9]/', '','SIP/'.$_GET['agent']);
				$data['ticket_id'] = $this->ticketing_model->generate_ticket_id($data['agent']);
				$data['call_id'] = isset($_GET['call_id'])?$_GET['call_id']:0;
				$cus = $this->ticketing_model->check_caller($phone);
				if($cus !== false) {
					$data['data'] = $cus;
				}
				
				$data['province'] = $this->ticketing_model->get_province();
				$data['auth'] = $auth;
				$data['phone'] = $phone;
				$data['departments'] = $this->ticketing_model->department_list();
				$data['category'] = $this->get_category();
				//$data['departments'] = $this->ticketing_model->depart_list();
				$this->load->view('forms/ticketing', $data);
			}else{
				echo 'Invalid URL';
			}
		}else{
			echo 'Authentication failed';
		}
	}
	public function get_category(){
		$category = $this->ticketing_model->category();
		return $category;
		exit;
		if($_POST){
			$cat = $this->ticketing_model->category($_POST['id']);
			echo json_encode($cat);
		}
	}
	public function get_meta_category(){
		if($_POST){
			$cat = $this->ticketing_model->meta_category($_POST['id']);
			echo json_encode($cat);
		}
	}
	public function get_subcategory(){
		if($_POST){
			$cat = $this->ticketing_model->subcategory($_POST['id']);
			echo json_encode($cat);
		}
	}
	public function show_subcat_info(){
		if($_POST){
			$html = array();
			if(!empty($_POST['subcat'])){
				$cat = $this->ticketing_model->subcategory_info($_POST['subcat']);
				foreach ($cat as $key => $value) {
					$html[] = '<tr><td>'.implode('</td><td>',array_values($value)).'</td></tr>';
				}
			}
			if(count($html)>0){
				echo implode("\n", $html);
			}else{
				echo '<tr><td colspan="4" align="center"><i>Sub Category not found</i></td></tr>';
			}
		}
	}
	public function save_ticket($auth){
		if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
			if($_POST){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('cus_name', 'Nama', 'required');
	            $this->form_validation->set_rules('cus_phone', 'Phone', 'required');
	            $this->form_validation->set_rules('subject', 'Subject', 'required');
	            $this->form_validation->set_rules('content', 'Isi Ticket', 'required');
	            $this->form_validation->set_rules('status', 'Status', 'required');
	            $this->form_validation->set_rules('source', 'Source', 'required');
	            //$this->form_validation->set_rules('category', 'Category', 'required');
	            //$this->form_validation->set_rules('sub_category', 'Sub Category', 'required');

            	if ($this->form_validation->run() == false){
            		$data['status'] = false;
            		$data['code'] = 200;
            		$data['e']['cus_name'] = form_error('cus_name', '<div class="has-error">', '</div>');
            		$data['e']['cus_phone'] = form_error('cus_phone', '<div class="has-error">', '</div>');
            		$data['e']['subject'] = form_error('subject', '<div class="has-error">', '</div>');
            		$data['e']['content'] = form_error('content', '<div class="has-error">', '</div>');
            		$data['e']['status'] = form_error('status', '<div class="has-error">', '</div>');
            		$data['e']['source'] = form_error('source', '<div class="has-error">', '</div>');
            		//$data['e']['category'] = form_error('category', '<div class="has-error">', '</div>');
            		//$data['e']['sub_category'] = form_error('sub_category', '<div class="has-error">', '</div>');
            		echo json_encode($data);
            	}else{
            		if($this->ticketing_model->save_ticket()){
            			echo json_encode(array('status'=>true));
            		}else{
            			echo json_encode(array('status'=>false, 'code'=>500));
            		}
            	}
			}else{
				echo 'Invalid Action';
			}
		}else{
			echo 'Authentication failed';
		}
	}

	public function get_ticket($auth){
		if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
			if($_POST){
				$list = $this->ticketing_model->get_load_ticket();
				//echo $this->db->last_query();exit;
		        $data = array();
		        $no = $_POST['start'];
		        foreach ($list as $ticket) {
		            $no++;
		            $row = array();
		            $row[] = $ticket->id;
		            $row[] = $no;
		            $row[] = $ticket->ticket_id;
		            $row[] = $ticket->category;
		            $row[] = $ticket->subject;
		            $row[] = $ticket->open_date;
		            //$row[] = $ticket->store_name;
		            $row[] = $ticket->status;
		            $data[] = $row;
		        }
		 
		        $output = array(
		                        "draw" => $_POST['draw'],
		                        "recordsTotal" => $this->ticketing_model->count_ticket_all(),
		                        "recordsFiltered" => $this->ticketing_model->count_ticket_filtered(),
		                        "data" => $data,
		                );
		        echo json_encode($output);
			}else{
				echo 'invalid request';
			}
		}else{
			echo 'Invalid auth';
		}
	}

	public function ticket_detail($auth){
		if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
			$ticket = $this->ticketing_model->get_ticket_detail($_POST['id']);
			echo json_encode($ticket);
		}else{
			echo 'Invalid auth';
		}
	}

	public function get_city(){
		if($_POST){
			$data = $this->ticketing_model->get_city($_POST['province'], true);
			echo json_encode(array('status'=>true, 'data'=>$data));
		}else{
			echo json_encode(array('status'=>false));
		}
	}

	public function get_district(){
		if($_POST){
			$data = $this->ticketing_model->get_district($_POST['city'], true);
			echo json_encode(array('status'=>true, 'data'=>$data));
		}else{
			echo json_encode(array('status'=>false));
		}
	}

	public function outgoing_call(){
		//require_once APPPATH.'third_party/php-ami.php';
		$this->load->library('astman');
		$this->astman = new AstMan;
		$this->astman->amiHost = 'localhost';
		$this->astman->amiPort = '5038';
		$this->astman->amiUsername = 'admin';
		$this->astman->amiPassword = 'dut4_MEDIA';
		//$this->astman -> Login();
		//$users = $this->astman->GetUser('514251');
		//print_r($users);
		//exit();
		    
	    $dn = preg_replace('/^62/', '0', $_POST['dn']);
	    $dn = substr($dn, 0,1)!='0'?'0'.$dn:$dn;

	    if (strlen($dn)<7) {
	        echo("DN Number too short ".$dn);
	        exit();
	    }
	    if (!isset($_POST['ext'])) {
	        echo json_encode(array('status'=>false, 'msg'=>'Number must be set'));
	        exit();
	    }
	    if ($this->astman->Login()) {
	        $userData = $this->astman->GetUser($_POST['ext']);
	        //print_r($userData);
	        if (strpos($userData, "Status: OK") !== false) {
	            $idCall = date('YmdHis').substr($_POST['ext'], -2).substr($dn, -4);
	            $originateRequest = "Action: Originate\r\n";
	            $originateRequest .= "Channel: SIP/".$_POST['ext']."\r\n";
	            $originateRequest .= "Callerid: ".$_POST['ext']."\r\n";
	            $originateRequest .= "Exten: ".$dn."\r\n";
	            $originateRequest .= "Context: from-internal\r\n";
	            $originateRequest .= "Priority: 1\r\n";
	            $originateRequest .= "Variable: CALLID=".$idCall."\r\n";
	            $originateRequest .= "Variable: CALLBACK=".base_url('api/return_outgoing/3ec8112b9e277cf4d24c85136fc9ee95')."\r\n";
		    $originateRequest .= "Variable: _SIPADDHEADER51=X-AUTOANSWER: TRUE\r\n";
	            $originateRequest .= "Async: yes\r\n\r\n";
	            $return = array('outgoing_id'=>$idCall,
	                    'ext'=>$_POST['ext'],
	                    'calldate'=>date('Y-m-d H:i:s'),
	                    'phone'=>$dn);
	            if ($res = $this->astman->Query($originateRequest)) {
	                //echo($originateRequest);
		            $return['outgoing_id'] = $this->ticketing_model->save_outgoing($return);
	                $return['status'] = true;
	                $return['result'] = $res;
	            }
	        } elseif (strpos($userData, "Status") !== false) {
	            $return['status']=false;
	            $return['msg']='User not Online';
	        } else {
	            $return['status']=false;
	            $return['msg']=$userData;
	        }
	    } else {
	        $return['status']=false;
	        $return['msg']="Could not authenticate";
	    }

		echo json_encode($return);
	}

	public function return_outgoing($auth){
		if ($auth=='3ec8112b9e277cf4d24c85136fc9ee95') {
			$data['call_status'] = $_GET['dialstatus'];
			$data['outgoing_id'] = $_GET['callid'];
			$data['duration'] = $_GET['billsec'];
			$data['recordingfile'] = $_GET['recordingfile'];
			if($this->ticketing_model->save_return_outgoing($data)){
				echo 'success';
			}else{
				echo 'failed';
			}
		}else{
			echo 'Invalid Authentication';
		}
	}

}