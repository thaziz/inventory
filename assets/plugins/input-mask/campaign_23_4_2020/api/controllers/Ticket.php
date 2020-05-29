<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Ticket extends MX_Controller {

	/**
	 *
	 */

	public function __construct(){
		$this->load->model('ticket_api_model');
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');

	}

	public function index(){
		return $this->load->view('test');
	}
	
	public function ticket_list($auth=''){
			
		if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){

			if(isset($_POST['type'])){
					/*$type($type=='nespresso') ? 'nespresso':'kanmo';*/
				$data = $this->ticket_api_model->load_tickets();
				//echo $this->db->last_query();
				//exit;
				
				$this->load->library('Ajax_pagination');

	            $config['num_links']      = 2;
	            $config['base_url']    = base_url().'posts/ajaxPaginationData';
	            $config['first_tag_open'] = '<li>';
	            $config['first_tag_close'] = '</li>';
	            $config['last_tag_open'] = '<li>';
	            $config['last_tag_close'] = '</li>';
	            $config['prev_tag_open'] = '<li>';
	           $config['prev_tag_close'] = '</li>';
	            $config['next_tag_open'] = '<li>';
	            $config['next_tag_close'] = '</li>';
	            $config['cur_tag_open'] = '<li class="active"><a style="z-index:0;">';
	            $config['cur_tag_close'] = '</a></li>';
	            $config['num_tag_open'] = '<li>';
	            $config['num_tag_close'] = '</li>';
	            $config['prev_link'] = '&lsaquo;';
	            $config['next_link'] = '&rsaquo;';
	            $config['first_link'] = '«';
	            $config['last_link'] = '»';
	            $config['total_rows'] = $data['total_rows'];
	            $config['per_page'] = 10;

	            $this->ajax_pagination->initialize($config);

	            $data['paging'] = $this->ajax_pagination->create_links();
	            
				echo json_encode($data);
			}else{
/*
				$data['main_category'] = $this->email_model->main_category();
				if($type=='kanmo'){
					$data['brand'] = $this->email_model->brand();
					$data['category'] = $this->email_model->category();
				}else{
					$data['category'] = $this->email_model->category('n');
				}
	*/
				$param['cat'] = $this->ticket_api_model->category();
				$param['subcat'] = $this->ticket_api_model->subcategory();

				$param['assignment'] = $this->ticket_api_model->assignment_list();
				$param['userlist'] = $this->ticket_api_model->get_user_list();
				$param['user'] = $_GET['issabel_user'];
				echo $this->load->view('ticket_list', $param, true);
			}
		}else{
		echo 'Authentication failed';
		}
	}

	public function export_excel()
	{
		$data = $this->ticket_api_model->export_excel($_GET);
		//echo json_encode($data);
		$header 		=	array_keys($data['data_excel'][0]);
		$child_value	=	array();

		/*echo '<pre>';
		print_r($data['data_excel']);
		echo '</pre>';
		exit;*/

		for ($i=0; $i < count($data['data_excel']); $i++) { 
			$child_value []['id']= $data['data_excel'][$i]['id'];
		}

		/*echo '<pre>';
		print_r($child_value);
		echo '</pre>';
		exit;*/
		/*for ($i=0; $i < count($data['data_excel']); $i++) { 
			$child_value [$i]= array(
								$data['data_excel'][$i]['id'],
								$data['data_excel'][$i]['ticket_code'],
								$data['data_excel'][$i]['ticket_id'],
								$data['data_excel'][$i]['call_id'],
								$data['data_excel'][$i]['open_date'],
								$data['data_excel'][$i]['open_by'],
								$data['data_excel'][$i]['open_by_name'],
								$data['data_excel'][$i]['cus_id'],
								$data['data_excel'][$i]['subject'],
								$data['data_excel'][$i]['content'],
								$data['data_excel'][$i]['cus_fname'],
								$data['data_excel'][$i]['cus_lname'],
								$data['data_excel'][$i]['cus_phone'],
								$data['data_excel'][$i]['birthdate'],
								$data['data_excel'][$i]['anniversary_date'],
								$data['data_excel'][$i]['address_one_home_one'],
								$data['data_excel'][$i]['city_one'],
								$data['data_excel'][$i]['country_origin'],
								$data['data_excel'][$i]['dob_mom'],
								$data['data_excel'][$i]['first_sale_date'],
								$data['data_excel'][$i]['last_modified_date'],
								$data['data_excel'][$i]['last_sale_amount'],
								$data['data_excel'][$i]['last_sale_date'],
								$data['data_excel'][$i]['last_twelve_mon_sale'],
								$data['data_excel'][$i]['membership'],
								$data['data_excel'][$i]['membership_expiry'],
								$data['data_excel'][$i]['province_one'],
								$data['data_excel'][$i]['store_name'],
								$data['data_excel'][$i]['subsidiary'],
								$data['data_excel'][$i]['zip_code'],
								$data['data_excel'][$i]['gender'],
								$data['data_excel'][$i]['current_slab'],
								$data['data_excel'][$i]['loyalty_points'],
								$data['data_excel'][$i]['fraud_status'],
								$data['data_excel'][$i]['registered_on'],
								$data['data_excel'][$i]['registered_store'],
								$data['data_excel'][$i]['email'],
								$data['data_excel'][$i]['type'],
								$data['data_excel'][$i]['brand'],
								$data['data_excel'][$i]['main_category'],
								$data['data_excel'][$i]['category'],
								$data['data_excel'][$i]['sub_category'],
								$data['data_excel'][$i]['source'],
								$data['data_excel'][$i]['closed_by_name'],
								$data['data_excel'][$i]['closed_by'],
								$data['data_excel'][$i]['closed_date'],
								$data['data_excel'][$i]['status'],
								$data['data_excel'][$i]['curr_assign'],
								$data['data_excel'][$i]['need_callback'],
								$data['data_excel'][$i]['is_read'],
								$data['data_excel'][$i]['assign_id'],
								$data['data_excel'][$i]['group_id'],
								$data['data_excel'][$i]['groupname'],
								$data['data_excel'][$i]['user_id'],
								$data['data_excel'][$i]['user_ext'],
								$data['data_excel'][$i]['username'],
								$data['data_excel'][$i]['is_email'],
								$data['data_excel'][$i]['assign_time'],
								$data['data_excel'][$i]['end_time'],
								$data['data_excel'][$i]['assign_by'],
								$data['data_excel'][$i]['assign_by_name'],
								$data['data_excel'][$i]['note']
							);
		}

		$cc = $child_value;

		/*echo json_encode(
	 		$this->outputCSV(
	 			array(
	 				$header,
	 				$cc[0]
			    ),'download.csv'
	 		)
	    );*/

		/*echo '<pre>';
			print_r(
				array(
					array("Volvo 1", "BMW 1", "Toyota 1"),
					array("Volvo 2", "BMW 2", "Toyota 2"),
					array("Volvo 3", "BMW 3", "Toyota 3")
				)
			);
		echo '</pre>';
		exit;*/

		$this->outputCSV(
			array(
				$header
				/*array(
					"Volvo 1"	=>	"Volvo 1",
					"BMW 1"		=>	"BMW 1",
					"Toyota 1"	=>	"Toyota 1"
				)*/
			)
		);
		/*$file = "test.csv";
	 	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	 	header('Content-Disposition: attachment; filename='.$file);
	 	$content = "Col1,Col2,Col3\n";
	 	$content .= "test1,test1,test3\n";
	 	$content .= "testtest,ttesttest2,testtest3\n";*/

	}
/*array("Volvo", "BMW", "Toyota"),
array("Volvo 1", "BMW 1", "Toyota 1"),
array("Volvo 2", "BMW 2", "Toyota 2"),
array("Volvo 3", "BMW 3", "Toyota 3"),*/

	function outputCSV($data,$file_name = 'file.csv') {
       # output headers so that the file is downloaded rather than displayed
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=$file_name");
        # Disable caching - HTTP 1.1
        header("Cache-Control: no-cache, no-store, must-revalidate");
        # Disable caching - HTTP 1.0
        header("Pragma: no-cache");
        # Disable caching - Proxies
        header("Expires: 0");
    
        # Start the ouput
        $output = fopen("php://output", "w");
        echo '<pre>';
    	print_r($data);
    	echo '</pre>';
    	exit;
         # Then loop through the rows
        foreach ($data as $row) {
        	echo '<pre>';
        	print_r($row);
        	echo '</pre>';
            # Add the rows to the body
            /*fputcsv($output, $row); // here you can change delimiter/enclosure*/
        }
        # Close the stream off
        /*fclose($output);*/
    }

	public function detail($auth){
		if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
			$data = $this->ticket_api_model->get_detail($_GET['ticket_id']);
			$data['assignment'] = $this->ticket_api_model->assignment_list();
			$data['user'] = isset($_GET['issabel_user'])?$_GET['issabel_user']:'';
			$data['editable']=isset($_GET['editable'])?$_GET['editable']:1;
				
					//$data['cat'] = $this->ticket_api_model->category();
					//$data['subcat'] = $this->ticket_api_model->sub_category();

			if(isset($_GET['reply'])){
				$data['reply']=true;
			}
			//print_r($data);exit;
			
			echo $this->load->view('ticket_detail', $data, true);
		}else{
		echo 'Authentication failed';
		}
	}

	public function save_assign(){
		if($this->ticket_api_model->save_assign()){
			$this->ticket_api_model->set_read_ticket(explode(',',$_POST['tick_ids']));
			echo json_encode(array('status'=>true));
		}else{
			echo json_encode(array('status' => false, ));
		}
	}

	public function save_comment(){
		if($this->ticket_api_model->save_comment()){
			$this->ticket_api_model->set_read_ticket(explode(',',$_POST['tick_ids']));
			echo json_encode(array('status'=>true));
		}else{
			echo json_encode(array('status' => false, ));
		}
	}

	public function reply_email(){
		if($_POST){
			$ticket = $this->ticket_api_model->get_ticket_by_id(preg_replace('/[^0-9]/', '', $_POST['subject']));

			if($ticket!=false && !$this->ticket_api_model->check_email_exist($_POST['mid'], 'v_ticket_history')){
				$data['ticket_id'] = $ticket->id;
				$data['email_id'] = $_POST['mid'];
				$data['username'] = $_POST['from'];
				$data['activity'] = $_POST['body'];
				$data['time'] = date('Y-m-d H:i:s', strtotime($_POST['time']));
				if($this->ticket_api_model->save_answer($data)){
					$this->ticket_api_model->set_read_ticket($ticket->id);
					echo json_encode(array('status'=>true));
				}else{
					echo json_encode(array('status'=>false));
				}
			}else{
				echo json_encode(array('status'=>false, 'msg'=>'['.$_POST['subject'].'] Subject not found'));
			}
		}
	}

	public function save_email(){
		if($_POST){
			$data['email_id'] = $_POST['mid'];
			$data['subject'] = $_POST['subject'];
			$data['email_from'] = $_POST['from'];
			$data['body'] = $_POST['body'];
			$data['time'] = date('Y-m-d H:i:s', strtotime($_POST['time']));
			echo json_encode($data);exit;
			if($this->ticket_api_model->save_email($data)){
				echo json_encode(array('status'=>true));
			}else{
				echo json_encode(array('status'=>false));
			}
		}
	}

	public function save_reply(){
		if($this->ticket_api_model->save_reply()){
			$this->ticket_api_model->set_read_ticket($_POST['tick_ids']);
			echo json_encode(array('status'=>true));
		}else{
			echo json_encode(array('status' => false, ));
		}
	}

	public function save_reply_customer(){
		if($this->ticket_api_model->save_reply_customer()){
			$this->ticket_api_model->set_read_ticket($_POST['tick_ids']);
			echo json_encode(array('status'=>true));
		}else{
			echo json_encode(array('status' => false, ));
		}
	}

	public function save_closed(){
		if(isset($_POST['status_chat']) && $_POST['status_chat']==0){
			if($this->ticket_api_model->save_closed()){
				echo json_encode(array('status'=>true));
			}
		}else{
			if($this->ticket_api_model->save_closed()){
				$this->ticket_api_model->set_read_ticket(explode(',',$_POST['tick_ids']));
				echo json_encode(array('status'=>true));
			}else{
				echo json_encode(array('status' => false, ));
			}
		}
	}

	public function save_reopen(){
		if($this->ticket_api_model->save_reopen()){
			//$this->ticket_api_model->set_read_ticket(explode(',',$_POST['tick_ids']));
			echo json_encode(array('status'=>true));
		}else{
			echo json_encode(array('status' => false, ));
		}
	}

	public function ticket_act_history(){

	}

	public function callback($auth){
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

		if ($auth=='3ec8112b9e277cf4d24c85136fc9ee95') {
		    
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
		            $originateRequest .= "Variable: CALLBACK=".base_url('api/ticket/return_callback/3ec8112b9e277cf4d24c85136fc9ee95')."\r\n";
			    $originateRequest .= "Variable: _SIPADDHEADER51=X-AUTOANSWER: TRUE\r\n";
		            $originateRequest .= "Async: yes\r\n\r\n";
		            $return = array('callid'=>$idCall,
		                    'agent_ext'=>$_POST['ext'],
		                    'ticket_id'=>$_POST['ticket_id'],
		                    'calldate'=>date('Y-m-d H:i:s'),
		                    'phone'=>$dn);
		            if ($res = $this->astman->Query($originateRequest)) {
		                //echo($originateRequest);
		                $this->ticket_api_model->save_callback($return);
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
		} else {
		    $return['status']=false;
		    $return['msg']="Invalid Key";
		}

		echo json_encode($return);
	}

	public function return_callback($auth){
		if ($auth=='3ec8112b9e277cf4d24c85136fc9ee95') {
			$data['call_status'] = $_GET['dialstatus'];
			$data['callid'] = $_GET['callid'];
			$data['duration'] = $_GET['billsec'];
			$data['recordingfile'] = $_GET['recordingfile'];
			if($this->ticket_api_model->save_return_callback($data)){
				echo 'success';
			}else{
				echo 'failed';
			}
		}else{
			echo 'Invalid Authentication';
		}
	}

	public function test(){
		$data = $this->ticket_api_model->load_tickets();
		print_r($data);
	}

	public function edit_ticket(){
		$data = $this->ticket_api_model->data_detail($_POST['ticket_id'],$_POST['type']);
		echo json_encode($data);
	}

	public function get_meta_category($type){
		$id=isset($_POST['id'])?$_POST['id']:'';
		$data= $this->ticket_api_model->get_meta_category($id,$type);
		echo json_encode($data);
	}
	public function get_category($type){
		$id=isset($_POST['id'])?$_POST['id']:'';
		$data= $this->ticket_api_model->get_category($id,$type);
		echo json_encode($data);

	}
	public function get_sub_category($type){
		$id=isset($_POST['id'])?$_POST['id']:'';
		$data= $this->ticket_api_model->get_sub_category($id,$type);
		echo json_encode($data);
	}
	public function get_source($type){
		$data= $this->ticket_api_model->get_source($type);
		echo json_encode($data);
	}

	public function update_ticket($type){
		
		if($_POST){
			$this->form_validation->set_rules('ticket_id', 'Ticket ID', 'required');
            /*$this->form_validation->set_rules('main_category', 'Main Category', 'required');
            $this->form_validation->set_rules('meta_category', 'Meta Category', 'required');
            $this->form_validation->set_rules('category', 'Category', 'required');
            $this->form_validation->set_rules('sub_category', 'sub Category', 'required');*/
            $this->form_validation->set_rules('source', 'Source', 'required');
            $this->form_validation->set_rules('content', 'Content', 'required');

            if($type=='kanmo')
            $this->form_validation->set_rules('brand', 'Brand', 'required');
            
        	if ($this->form_validation->run() == false){
        		$data['status'] = false;
        		$data['code'] = 200;
        		$data['e']['main_category'] = form_error('main_category', '<div class="has-error">', '</div>');
        		$data['e']['meta_category'] = form_error('meta_category', '<div class="has-error">', '</div>');
        		$data['e']['category'] = form_error('category', '<div class="has-error">', '</div>');
        		$data['e']['sub_category'] = form_error('sub_category', '<div class="has-error">', '</div>');
        		$data['e']['content'] = form_error('content', '<div class="has-error">', '</div>');
        		$data['e']['brand'] = form_error('brand', '<div class="has-error">', '</div>');
        		$data['e']['source'] = form_error('source', '<div class="has-error">', '</div>');
        		echo json_encode($data);
        		/*var_dump(1);exit();*/
        	}else{
        		if($this->ticket_api_model->update_ticket()){
        			echo json_encode(array('status'=>true, 'code'=>200));
        		}else{
        			echo json_encode(array('status'=>false, 'code'=>500));
        		}
        	}
		}
	}


}
