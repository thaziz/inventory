<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wa extends CI_Controller {


   public function __construct(){   
    parent::__construct();      
    
       $this->load->model('wa_model');
       
       $this->load->model('wa_data_model');
       $this->load->model('wachat_model');

       $this->load->model('kanmo_model');
   }

	public function index(){
		$data['message'] = '';		
		$data['number'] =$_GET['issabel_user'] ;
		$data['type'] =isset($_GET['type'])?strtoupper($_GET['type']):'NESPRESSO' ;
		$data['dashboard']=$this->wa_data_model->dashboardu($data['type'],$data['number']);    		
		$data['dashboardall']=$this->wa_data_model->dashboarduall($data['type'],$data['number']);  
		$data['login']=$this->wachat_model->check_agent_is_login($data['number']);
		$data['province'] = $this->kanmo_model->get_province();		
	    $data['subsidiary'] = $this->kanmo_model->get_subsidiary();
	    $data['status_chat']=$this->wachat_model->check_status_chat($data['number']);
	    $data['agent']=$this->wa_data_model->agent($data['type'],$data['number']);    		
		
		//var_dump($data['status_chat']);exit();
        if($data['login']){
        	if ($data['status_chat']==false){
        		$this->wachat_model->refresh_assign($data['number'], $data['type']);
        	}
     		$this->load->view('view_wa',$data);

     	}
	
	}

	public function test(){
		$data['number'] =$_GET['issabel_user'] ;
		$data['type'] =isset($_GET['type'])?strtoupper($_GET['type']):'NESPRESSO' ;
		$this->wachat_model->refresh_assign($data['number'], $data['type']);
	}

	private function get_token(){
		$date = date('Y-m-d H:i:s');
		if($this->session->has_userdata('token')){
			
			if(strtotime($date)>$this->session->userdata('token_expired')){
				$this->session->unset_userdata('token');
				$this->session->unset_userdata('token_expired');
				$this->get_token();
			}else{
				//echo 'get token';
				return true;
			}
		}else{
			//echo 'access url token';
			$this->load->helper('apicurl');
			$result = get_token('https://119.2.42.174/boostapi/token', array('username'=>'callcenter', 'password'=>'zv5gDRmbi&Kal@WU', 'grant_type'=>'password'));
			var_dump($result);exit();
			if($result!=false){
				$this->session->set_userdata('token', $result['token_type'].' '.$result['access_token']);
				$this->session->set_userdata('token_expired', strtotime($date.' + '.$result['expires_in'].' seconds'));
				return true;
			}else{
				return false;
			}
		}
	}


	private function get_data($phone){
		$this->load->helper('apicurl');
		$this->get_token();
		$result = $this->session->userdata('token');
		if($result){
			$data = get_data_api('https://119.2.42.174/boostapi/api/CRMCap/V1/GetCallCenterCustomerDataByMobile','GET', array('custMobile'=>$phone,'formatData'=>'json'), array('Authorization:'.$result, 'Content-Type:application/json'));
			
			$data = json_decode($data, true);

			$customer = array();
			if(isset($data['response'])){
				if($data['response']['status']['success']=='true' && $data['response']['status']['code']=='200'){
					$customer = $data['response']['customers']['customer'][0];
				}
				//echo json_encode($customer);exit;
				return $customer;
			}else{
				$this->session->unset_userdata('token');
				$this->session->unset_userdata('token_expired');
				return $this->get_data($phone);
			}
		}else{
			return false;
		}
	}



	public function search_add($auth){
		if($auth == '3ec8112b9e277cf4d24c85136fc9ee95'){

			if($_POST){
				$phone = preg_replace('/^0/', '62', $_POST['phone']);
				$customer = $this->get_data($phone);
					var_dump($customer);exit();
				
				$customer_field = array(
					'address_one_home_one'=>'',
					'address_one_home_two'=>'',
					'anniversary_date'=>'',
					'birthday'=>'',
					'city_one'=>'',
					'country_origin'=>'',
					'dob_mom'=>'',
					'first_sale_date'=>'',
					'gender'=>'',
					'last_modified_date'=>'',
					'last_sale_amount'=>'',
					'last_sale_date'=>'',
					'last_twelve_mon_sale'=>'',
					'membership'=>'',
					'membership_expiry'=>'',
					'mobile_two'=>'',
					'points_balance'=>'',
					'province_one'=>'',
					'district_one'=>'',
					'store_name'=>'',
					'subsidiary'=>'',
					'company'=>'',
					'title'=>'',
					'zip_code'=>''
				);
				$extend_field = array(
					'gender'=>''
				);

				if(isset($customer['custom_fields'])){
					foreach ($customer['custom_fields']['field'] as $value) {
						$customer_field[$value['name']] = $value['value'];
					}
					foreach ($customer['extended_fields']['field'] as $value) {
						$extend_field[$value['name']] = $value['value'];
					}
					$cus = $this->ticketing_model->check_caller($phone, $customer, $customer_field, $extend_field);
					if($cus!=false){
						$data['cus_id'] = $cus;
					}
				}

				$data['cus_phone'] = $phone;
				$data['cus_fname'] = isset($customer['firstname'])?$customer['firstname']:'';
				$data['cus_lname'] = isset($customer['lastname'])?$customer['lastname']:'';
				$data['external_id'] = isset($customer['external_id'])?$customer['external_id']:'';
				$data['registered_on'] = isset($customer['registered_on'])?$customer['registered_on']:'';
				$data['tregistered_on'] = isset($customer['registered_on'])?date('F d, Y', strtotime($customer['registered_on'])):'';
				$data['registered_store'] = isset($customer['registered_store'])?$customer['registered_store']['name']:'';
				$data['email'] = isset($customer['email'])?$customer['email']:'';
				$data['subsidiary'] = $customer_field['subsidiary'];
				$data['dob_mom'] = $customer_field['dob_mom'];
				$data['tdob_mom'] = !empty($customer_field['dob_mom'])?date('F d, Y', strtotime($customer_field['dob_mom'])):'';
				$data['anniversary_date'] = $customer_field['anniversary_date'];
				$data['tanniversary_date'] = !empty($customer_field['anniversary_date'])?date('F d, Y', strtotime($customer_field['anniversary_date'])):'';
				$data['gender'] = $customer_field['gender'];
				$data['first_sale_date'] = $customer_field['first_sale_date'];
				$data['tfirst_sale_date'] = !empty($customer_field['first_sale_date'])?date('F d, Y', strtotime($customer_field['first_sale_date'])):'';
				$data['last_modified_date'] = $customer_field['last_modified_date'];
				$data['tlast_modified_date'] = !empty($customer_field['last_modified_date'])?date('F d, Y', strtotime($customer_field['last_modified_date'])):'';
				$data['last_sale_amount'] = $customer_field['last_sale_amount'];
				$data['last_sale_date'] = $customer_field['last_sale_date'];
				$data['tlast_sale_date'] = !empty($customer_field['last_sale_date'])?date('F d, Y', strtotime($customer_field['last_sale_date'])):'';
				$data['last_twelve_mon_sale'] = $customer_field['last_twelve_mon_sale'];
				$data['address_one_home_one'] = $customer_field['address_one_home_one'];
				$data['zip_code'] = $customer_field['zip_code'];
				$data['city_one'] = $customer_field['city_one'];
				$data['province_one'] = $customer_field['province_one'];
				$data['country_origin'] = $customer_field['country_origin'];
				if(!empty($customer_field['last_sale_date']))
					$data['fperiode'] = date('F d, Y', strtotime($customer_field['last_sale_date'].' -3 months')).' - '.date('F d, Y', strtotime($customer_field['last_sale_date'].' +1 day'));

				$data['nphone'] = $phone;
				$data['nfname'] = isset($customer['firstname'])?$customer['firstname']:'';
				$data['nlname'] = isset($customer['lastname'])?$customer['lastname']:'';
				$data['nbarcode'] = isset($customer['external_id'])?$customer['external_id']:'';
				//$data['address'] = $customer_field['address_one_home_one'].' '.$customer_field['city_one'].' '.$customer_field['zip_code'].' '.$customer_field['province_one'].' '.$customer_field['country_origin'];
				//$data['registered_store'] = isset($customer['registered_store'])?$customer['registered_store']['name']:'';
				$data['nemail'] = isset($customer['email'])?$customer['email']:'';
				$data['nsubsidiary'] = $customer_field['subsidiary'];
				//$data['nsubsidiary'] = 'Kate Spade';
				$data['ndob_mom'] = $customer_field['dob_mom'];
				$data['ngender'] = $customer_field['gender'];
				$data['nadd1'] = $customer_field['address_one_home_one'];
				$data['nadd2'] = $customer_field['address_one_home_two'];
				$data['nzip_code'] = $customer_field['zip_code'];
				$data['ncity_one'] = $customer_field['city_one'];
				$data['nprovince_one'] = $customer_field['province_one'];
				$data['ndistrict_one'] = $customer_field['district_one'];
				$data['ncountry_origin'] = $customer_field['country_origin'];
				$data['ncompany'] = $customer_field['company'];
				//$data['nbrand_interest'] = explode("`,`",trim(trim("[`Mothercare`,`Kate Spade`,`Karen Millen`]", "`]"),"[`"));
				$data['nbrand_interest'] = isset($customer_field['brand_interest'])?explode("`,`",trim(trim($customer_field['brand_interest'], "`"),"`")):array();

				if(isset($customer_field['province_one'])){
					if(!empty($customer_field['province_one'])){
						$data['scity'] = $this->ticketing_model->get_city($customer_field['province_one'], true);
					}else{
						$data['scity'] = array();
					}
				}
				if(isset($customer_field['city_one'])){
					if(!empty($customer_field['city_one'])){
						$data['sdistrict'] = $this->ticketing_model->get_district($customer_field['city_one'], true);
					}else{
						$data['sdistrict'] = array();
					}
				}

				if(isset($customer['firstname'])){
					echo json_encode(array('status'=>true, 'data'=>$data));
				}else{
					echo json_encode(array('status'=>false, 'data'=>$data));
				}
			}
		}else{
			echo 'Authentication failed';
		}
	}



  public function lastchat($type){

      $chats = array();
      $chats = $this->wa_data_model->get_lastchat($type,$_GET['agent'] );
      echo json_encode($chats);    
  }

  public function chek_ticket($type){

      $ticket = $this->wachat_model->find_ticket($_POST['phone']);
  	
     
      echo json_encode($ticket);    
  }


  public function save_closed(){
			if($this->wachat_model->save_closed()){
				echo json_encode(array('status'=>true));
			}
	
	}

	public function detail(){

		$detail = $this->db->select('*')->from('message')->where('id',$this->input->post('id'))->get()->row();

		if($detail){

			$this->db->where('id',$this->input->post('id'))->update('message',array('read_status'=>1));

			$arr['name'] = $detail->name;
			$arr['email'] = $detail->email;
			$arr['subject'] = $detail->subject;
			$arr['message'] = $detail->message;
			$arr['created_at'] = $detail->created_at;
			$arr['update_count_message'] = $this->db->where('read_status',0)->count_all_results('message');
			$arr['success'] = true;

		} else {

			$arr['success'] = false;
		}

		
		
		echo json_encode($arr);

	}



  public function webhook($type){

        $content = file_get_contents("php://input");

        $_data = json_decode($content, true);

        $oldagent = 0;
        $agent_id = 0;
        $agent_number = 0;
        $agent_name = '';

        //$chat = new Chat();

       // $agent_id=1;

        
/*
        if(isset($_data['ack'])){
        
        }else*/ 
        if(isset($_data['messages']) && substr($_data['messages'][0]['id'], 0, 4) != 'true'){
          
          $_dt=$_data['messages'];
         foreach ($_dt as $key => $_data) {
          preg_match('/^[0-9]+/',$_data['author'], $match);
          $_data['phone'] = $match[0];
          $cust_id = $this->wachat_model->find_customer($_data['phone']);
        write_file(FCPATH.'logs/wa_webhook.log', date('Y-m-d H:i:s').':  '.json_encode($_data).PHP_EOL);

        
          
          //check ticket related to chat
          $ticket = $this->wachat_model->find_ticket($_data['phone']);
          if ($ticket['id']!==0) { // if exist then set agent id with previous agent
            $agent_id = $ticket['agent_id'];
            $agent_number = $this->wachat_model->get_agent_number($agent_id);
            $oldagent = $agent_number;
            // check the session time in chat
            $agent_id = $this->wachat_model->check_chat_session($_data['phone'], date('Y-m-d H:i:s', $_data['time']));
            if ($agent_id!=0 && $this->wachat_model->check_agent_is_in_chat($agent_id)) {
              $agent_number = $this->wachat_model->get_agent_number($agent_id);
            } else {
              // get random available agent that not max handle chat
              $agents = $this->wachat_model->get_avail_agent($type);
              if(is_array($agents) && count($agents)>0){
                $idx = count($agents)>1?rand(0,count($agents)-1):0;
                $agent_number = $agents[$idx]->number;
                $agent_id = $agents[$idx]->id;
              } else {
                $agent_id = 0;
                $agent_number = 0;
              }
            }
          } else {
            // check the session time in chat
            $agent_id = $this->wachat_model->check_chat_session($_data['phone'], date('Y-m-d H:i:s', $_data['time']));
            if ($agent_id!=0){
	            $agent_number = $this->wachat_model->get_agent_number($agent_id);
	            $oldagent = $agent_number;
	        }
            if ($agent_id!=0 && $this->wachat_model->check_agent_is_in_chat($agent_id)) {
              $agent_number = $this->wachat_model->get_agent_number($agent_id);
            } else {
              // get random available agent that not max handle chat
              $agents = $this->wachat_model->get_avail_agent($type);
              if(is_array($agents) && count($agents)>0){
                $idx = count($agents)>1?rand(0,count($agents)-1):0;
                $agent_number = $agents[$idx]->number;
                $agent_id = $agents[$idx]->id;
              } else {
                $agent_id = 0;
                $agent_number = 0;
              }
            }
          }

          $agent_name = $this->wachat_model->get_agent_name($agent_id);

          //write_file(FCPATH.'logs/wa_sql.log', date('Y-m-d H:i:s').':  '.$oldagent.' => '.$agent_number.PHP_EOL);

          
        $wa = $this->wa_data_model->find_data_id($_data['phone']);


          $data = array('id'=>$_data['id'], 'parent_number'=>$_data['phone'],'wa_number'=>$_data['phone'], 'status'=>'unread', 'chat_time'=>date('Y-m-d H:i:s', $_data['time']), 'is_reply'=>1, 'cust_id'=>$cust_id, 'agent_id'=>($agent_id==null)?0:$agent_id, 'ticket_id'=>$ticket['id'], 'type'=>strtoupper($type), 'agent_name'=>$agent_name);
          $data['parent_id']=isset($wa['parent_id'])?$wa['parent_id']:0;
          $quote = null;
          if($_data['quotedMsgBody']!==null){
          	$quoteImg = md5($_data['id']).'.png';
          	$quote = $this->convert_base64_to_image($_data['quotedMsgBody'], '/var/www/html/kanmo/assets/wa_images/'.$quoteImg);

          	if($quote!==false){
          		$data['quoteImage'] = $quoteImg;
          	} else {
          		$data['quoteText'] = $_data['quotedMsgBody'];
          	}
          }
          
          if($_data['type']=='chat'){
            $data['wa_text']=$_data['body'];
          }

          if($_data['type']=='image'){
            preg_match('/(.jpeg)|(.png)|(.jpg)|(.gif)/', $_data['body'], $ext);
            $data['wa_text']=!empty($_data['caption'])?$_data['caption']:'';
            $data['wa_images'] = strtoupper(md5($_data['body'])).$ext[0];
            $file = fopen ($_data['body'], 'rb');
            if ($file) {
                $newf = fopen ("/var/www/html/kanmo/assets/wa_images/".$data['wa_images'], 'wb');
                if ($newf) {
                    while(!feof($file)) {
                        fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
                    }
                }
              fclose($newf);
            }
            fclose($file);
          }

          if($_data['type']=='document'){
            preg_match('/(.pdf)|(.xls)|(.xlsx)|(.doc)|(.docx)/', $_data['body'], $ext);
            $data['wa_text']=!empty($_data['caption'])?$_data['caption']:'';
            $data['wa_files'] = strtoupper(md5($_data['body'])).$ext[0];
            $file = fopen ($_data['body'], 'rb');
            if ($file) {
                $newf = fopen ("/var/www/html/kanmo/assets/wa_files/".$data['wa_files'], 'wb');
                if ($newf) {
                    while(!feof($file)) {
                        fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
                    }
                }
              fclose($newf);
            }
            fclose($file);
          }

          if($_data['type']=='ptt'||$_data['type']=='audio'){
            preg_match('/(.wav)|(.oga)|(.mp3)|(.m4a)/', $_data['body'], $ext);
            $data['wa_text']=!empty($_data['caption'])?$_data['caption']:'';
            $data['wa_audio'] = strtoupper(md5($_data['body'])).$ext[0];
            $file = fopen ($_data['body'], 'rb');
            if ($file) {
                $newf = fopen ("/var/www/html/kanmo/assets/wa_audio/".$data['wa_audio'], 'wb');
                if ($newf) {
                    while(!feof($file)) {
                        fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
                    }
                }
              fclose($newf);
            }
            fclose($file);
          }

          if($_data['type']=='video'){
            preg_match('/(.avi)|(.mp4)/', $_data['body'], $ext);
            $data['wa_text']=!empty($_data['caption'])?$_data['caption']:'';
            $data['wa_video'] = strtoupper(md5($_data['body'])).$ext[0];
            $file = fopen ($_data['body'], 'rb');
            if ($file) {
                $newf = fopen ("/var/www/html/kanmo/assets/wa_video/".$data['wa_video'], 'wb');
                if ($newf) {
                    while(!feof($file)) {
                        fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
                    }
                }
              fclose($newf);
            }
            fclose($file);
          }
          
          /*write_file(FCPATH.'logs/wa_webhook.log', date('Y-m-d H:i:s').': receive from '.$_data['phone'].($wan!=false?' to '.$wan:'').' at '.date('Y-m-d H:i:s', $_data['time']).' '.(isset($data['wa_text'])?'text '.$data['wa_text']:($_data['type']=='image'?'images '.$data['wa_images']:'')).' with id '.$_data['id'].PHP_EOL);*/

          //write_file(FCPATH.'logs/wa_sql.log', date('Y-m-d H:i:s').':  '.json_encode($data).PHP_EOL);

          $oldagent = $this->wa_data_model->get_old_number($_data['phone']);
          write_file(FCPATH.'logs/wa_sql.log', date('Y-m-d H:i:s').':  '.$this->db->last_query().PHP_EOL);

          if($this->wa_data_model->save_reply($data)){
            //echo 'hello'.$agent_number;
            //$to = $this->wachat_model->get_res_id($agent_id);
            //echo $to;

        /*$_data['phone'] = preg_replace('/^\+62/', '0', $_data['phone']);
        $_data['phone'] = preg_replace('/^62/', '0', $_data['phone']);*/
            $a=$this->wa_data_model->get_customer_name($_data['phone']);
            $data['wa_customer']=$a==' '?$_data['phone']:$a;
          $data['time']=date('H:i:s', $_data['time']);
          $data['date']=date('Y-m-d', $_data['time']);
          $data['flag']=1;
            if($agent_number !== 0) {
              //$chat->sendData($to, $msg);
              $dashboard=$this->wa_data_model->dashboard($type,$agent_id);              
              $history_chat=$this->wa_data_model->history_chat($type,$agent_id,$_data['phone']);

              $dataPush = array(
                  'ext' => "wa$agent_number",
                  'data'    => $data,
                  'time'     => time(),
                  'dashboard'		=>$dashboard,
                  'history_chat' =>$history_chat,
              );
              
              // This is our new stuff
              $context = new ZMQContext();
              $socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'pusher');
              $socket->connect("tcp://localhost:5555");

              $socket->send(json_encode($dataPush));
            }
            $queue=$this->wa_data_model->dashboard_queue($type);  
            $history_chat=$this->wa_data_model->history_chat($type,$agent_id,$_data['phone']);

			$dataPush = array(
			  'ext' => "wa-all",
			  'data'    => $data,
			  'time'     => time(),
			  'dashboard'		=>$queue,
			  'history_chat' =>$history_chat,
			);

			// This is our new stuff
			$context = new ZMQContext();
			$socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'pusher');
			$socket->connect("tcp://localhost:5555");

			$socket->send(json_encode($dataPush));

			

			if($oldagent!=$agent_number){
				$dataPush = array(
				  'ext' => "wa-rm".$oldagent,
				  'data'    => $data,
				  'time'     => time()
				);

				// This is our new stuff
				$context = new ZMQContext();
				$socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'pusher');
				$socket->connect("tcp://localhost:5555");

				$socket->send(json_encode($dataPush));
			}

			echo json_encode(array('status'=>true, 'response'=>'success', 'time'=>time(), 'data'=>$data));
		
            /*write_file(FCPATH.'logs/wa_webhook.log', date('Y-m-d H:i:s').': data save success in wa campaign '.$wa['campaign_id'].' and data id '.$wa['data_id'].PHP_EOL);*/
          }else{
            /*write_file(FCPATH.'logs/wa_webhook.log', date('Y-m-d H:i:s').': data save failed '.PHP_EOL);*/
            echo json_encode(array('status'=>false, 'response'=>'fail', 'time'=>time(), 'data'=>$data));
          }      
          } 
        } else if (isset($_data['ack'])){
          $_data=$_data['ack'][0];

          write_file(FCPATH.'logs/wa_webhook.log', date('Y-m-d H:i:s').': ack '.$_data['id'].' '.$_data['status'].PHP_EOL);
          $a=$this->wachat_model->update_status_chat($_data['id'], $_data['status']);
          $_data['id']=$a;
          $dataPush = array(
			  'ext' => "wa-all",
			  'data'    => $_data,
			  'time'     => '',
			  'dashboard'		=>'',
			  'history_chat' =>'ack',
			);

			// This is our new stuff
			$context = new ZMQContext();
			$socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'pusher');
			$socket->connect("tcp://localhost:5555");

			$socket->send(json_encode($dataPush));
			var_dump($dataPush);exit();
        }
        //echo "string";
  }
/*
  public function test($type) {
  	$id = $this->wachat_model->get_avail_agent($type);
  	echo json_encode($id);
  	echo $this->db->last_query();
  }*/


    public function chat_assign(){    
    	
      $chat = $this->wachat_model->chat_assign($type,$agent_id,$_POST['phone']);
              $dataPush = array(
                  'ext' => "wa$agent_number",
                  'data'    => $data,
                  'time'     => time(),
                  'dashboard'		=>$dashboard,
                  'history_chat' =>$history_chat,
              );
              
              $context = new ZMQContext();
              $socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'pusher');
              $socket->connect("tcp://localhost:5555");
			  $socket->send(json_encode($dataPush));

      	if($oldagent!=$agent_number){
					$dataPush = array(
					  'ext' => "wa-rm".$oldagent,
					  'data'    => $data,
					  'time'     => time()
					);

					// This is our new stuff
					$context = new ZMQContext();
					$socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'pusher');
					$socket->connect("tcp://localhost:5555");
					$socket->send(json_encode($dataPush));
		}
      

		$dataPush = array(
				'ext' => "wa-all",
				'data'    => $data,
				'time'     => time(),
				'dashboard'		=>$queue,
				'history_chat' =>$history_chat,
				);

				// This is our new stuff
				$context = new ZMQContext();
				$socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'pusher');
				$socket->connect("tcp://localhost:5555");

				$socket->send(json_encode($dataPush));


      echo json_encode(array('status'=>true, 'chats'=>$chat));
    }


    public function chat($type,$agent_id){    
      $chat = $this->wa_model->get_chat($type,$agent_id,$_POST['phone']);
      $dataPush = array(
			  'ext' => "wa-all",
			  'data'    => $_POST['phone'],
			  'time'     => 'xx',
			  'history_chat' =>'open',
			);
      $context = new ZMQContext();
				$socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'pusher');
				$socket->connect("tcp://localhost:5555");

				$socket->send(json_encode($dataPush));
      echo json_encode(array('status'=>true, 'chats'=>$chat));
    }


	public function testsend($type){
   		$curl = curl_init();
   		$data_api = $this->wa_model->get_api_account($ik=null, $type);
   		$url = $data_api->api_url.'forwardMessage?token='.$data_api->auth_key;

        curl_setopt($curl, CURLOPT_URL,$url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array('phone'=>$_GET['phone'], 'messageId'=>$_GET['chatid'], 'body'=>$_GET['message'])));
     

        

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
        //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: '.$data_api->auth_key));
          curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        //curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($curl);
        curl_close($curl);
        echo $data;
   }

   private function is_base64_encoded($data, $path)
	{	try {
		    $img = imagecreatefromstring(base64_decode($data));
		    if (!$img) {
		        return false;
		    }

		    imagepng($img, $path);
		    $info = getimagesize($path);

		    unlink($path);

		    if ($info[0] > 0 && $info[1] > 0 && $info['mime']) {
		        return true;
		    }

		    return false;
		} catch (Exception $e) {
			return false;
		}
	}

	private function convert_base64_to_image($base64, $image_path) {
	    $image_raw_data = $base64;
	    // get decodable part of image
	    if ($this->is_base64_encoded($base64, $image_path)) {
	    	$file = fopen($image_path, "wb");
	    	fwrite($file, base64_decode($image_raw_data));
	    	fclose($file); 
	    	return $image_path;
	    } 
	    return false;
	}

	


   public function send(){
    $sendimage = false;
    $sendfile = false;
    $filename = '';
    $fname = '';
    if(empty($_POST['number'])){

        echo json_encode(array('status'=>false,'msg'=>'Unknown data phone'));
        exit();
    }
    if(isset($_POST['img']) && $_POST['img']!=''){
      if (preg_match('/^data:image\/(\w+);base64,/', $_POST['img'], $type)) {
          $dimg = substr($_POST['img'], strpos($_POST['img'], ',') + 1);
          $type = strtolower($type[1]); // jpg, png, gif

          if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
              $sendimage = false;
          }

          $dimg = base64_decode($dimg);

          if ($dimg === false) {
              $sendimage = false;
          }else{
            $sendimage=true;
            /*$filename = strtoupper(md5($_POST['dataid'].date('Y-m-d H:i:s'))).".{$type}";
            $fname = strtoupper(md5($_POST['dataid'].date('Y-m-d H:i:s'))).".jpg";*/
            $filename = strtoupper(md5(date('Y-m-d H:i:s'))).".{$type}";
            $fname = strtoupper(md5(date('Y-m-d H:i:s'))).".jpg";

            file_put_contents("/var/www/html/kanmo/assets/wa_images/".$filename, $dimg);
            //echo $filename;exit;
          }
      } else {
          $sendfile=true;
          $dimg = substr($_POST['img'], strpos($_POST['img'], ',') + 1);
          $type = explode('.',$_POST['filename'])[1];

          $dimg = base64_decode($dimg);
          if ($dimg === false) {
              $sendfile = false;
          }else{
            $sendfile=true;
            /*$filename = strtoupper(md5($_POST['dataid'].date('Y-m-d H:i:s'))).".{$type}";
            $fname = strtoupper(md5($_POST['dataid'].date('Y-m-d H:i:s'))).".jpg";*/
            $filename = strtoupper(md5(date('Y-m-d H:i:s'))).".{$type}";
            $fname = strtoupper(md5(date('Y-m-d H:i:s'))).".{$type}";

            file_put_contents("/var/www/html/kanmo/assets/wa_files/".$filename, $dimg);
            //echo $filename;exit;
          }
          //$dimg = substr($_POST['img'], strpos($_POST['img'], ',') + 1);
      }
    }
    if(((isset($_POST['message']) && !empty($_POST['message']))) || 
		((isset($_POST['img']) && !empty($_POST['img'])))){
      $date_time = date('Y-m-d H:i:s');
      $date = date('Y-m-d', strtotime($date_time));
      $time = date('H:i', strtotime($date_time));
      if($_POST){
        $curl = curl_init();
        $phon = preg_replace('/^\+62/', '0', $_POST['number']);
        $phone = preg_replace('/^62/', '0', $phon);
        $body = array('phone'=>$phone, 'message'=>$_POST['message']);
        $data_api = array();

        $data_api = $this->wa_model->get_api_account($ik=null,$_POST['type']);

          $cust_id = $this->wachat_model->find_customer($_POST['number']);



          if($sendimage || $sendfile){
            $url = $data_api->api_url.'sendFile?token='.$data_api->auth_key;
          }else{
            $url = $data_api->api_url.'sendMessage?token='.$data_api->auth_key;
          }

          curl_setopt($curl, CURLOPT_URL,$url);
          curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
          if($sendimage || $sendfile){
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array('phone'=>preg_replace('/^0/', '62', $phone), 'body'=>$_POST['img'],'caption'=>$_POST['message'], 'filename'=>$fname)));
          }else{
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array('phone'=>preg_replace('/^0/', '62', $phone), 'body'=>$_POST['message'])));
          }

        

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
        //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: '.$data_api->auth_key));
          curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        //curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($curl);
        curl_close($curl);
        write_file(FCPATH.'logs/log_send.log', date('Y-m-d H:i:s').':  '.$data.PHP_EOL);
        if(!empty($data)){
          $data_wa = json_decode($data, true);
          if($data_api->api_type=='api-chat'){
            $data_wa['status']=$data_wa['sent']?'Pending':'Failed';
            $data_wa['phone']=preg_replace('/^0/', '62', $phone);
            $data_wa['text']=$_POST['message'];
          }
          if($data_wa['status']){
            $uid = 1;
            if($data_api->api_type=='wablas'){
              $data_wa = $data_wa['data']['message'][0];
            }

            $agent = $this->wa_data_model->get_agent_name($_POST['agent']);
            $data = array('id'=>$data_wa['id'],'parent_number'=>$data_wa['phone'],'wa_number'=>$data_wa['phone'], 'wa_text'=>$data_wa['text'], 'status'=>$data_wa['status'], 'agent_id'=>$agent['id'], 'agent_name'=>$agent['name'], 'chat_time'=>$date_time,'cust_id'=>$cust_id,'type'=>$_POST['type']);
          
            if($sendimage){
              $data['wa_images'] = $filename;
            }
            if($sendfile){
            	$data['wa_files']=$filename;
            }

            $oldagent = $this->wa_data_model->get_old_number($data_wa['phone']);
            
            //var_dump($data);exit();
            if($this->wa_data_model->save_chat($data)){            	
            	$data['ack_id']= $this->db->insert_id();
            	$type = $_POST['type'];
                $_data['phone'] = $data_wa['phone'];
                $agent_id = $agent['id'];
                $agent_number = $agent['number'];

          $data['wa_customer']=$this->wa_data_model->get_customer_name($data_wa['phone']);
          $data['time']=$time;
          $data['date']=$date;
          $data['flag']=0;
          $data['agent']=$agent['name'];
                $dashboard=$this->wa_data_model->dashboard($type,$agent_id);              
				$history_chat=$this->wa_data_model->history_chat($type,$agent_id,$_data['phone']);

				$dataPush = array(
				  'ext' => "wa$agent_number",
				  'data'    => $data,
				  'time'     => time(),
				  'dashboard'		=>$dashboard,
				  'history_chat' =>$history_chat,
				);

				// This is our new stuff
				$context = new ZMQContext();
				$socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'pusher');
				$socket->connect("tcp://localhost:5555");

				$socket->send(json_encode($dataPush));

				$history_chat=$this->wa_data_model->history_chat($type,$agent_id,$_data['phone']);
				$queue=$this->wa_data_model->dashboard_queue($type); 

				$dataPush = array(
				'ext' => "wa-all",
				'data'    => $data,
				'time'     => time(),
				'dashboard'		=>$queue,
				'history_chat' =>$history_chat,
				);

				// This is our new stuff
				$context = new ZMQContext();
				$socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'pusher');
				$socket->connect("tcp://localhost:5555");

				$socket->send(json_encode($dataPush));

				if($oldagent!=$agent_number){
					$dataPush = array(
					  'ext' => "wa-rm".$oldagent,
					  'data'    => $data,
					  'time'     => time()
					);

					// This is our new stuff
					$context = new ZMQContext();
					$socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'pusher');
					$socket->connect("tcp://localhost:5555");

					$socket->send(json_encode($dataPush));
				}
              if($sendimage ){
                echo json_encode(array('status'=>true,'status_chat'=>'update_agent', 'text'=>nl2br($data_wa['text']), 'jenis'=>1, 'image'=>$filename, 'time'=>$time, 'date'=>$date,'agent'=>$agent['name']));
              }else if($sendfile){
                echo json_encode(array('status'=>true,'status_chat'=>'update_agent', 'text'=>nl2br($data_wa['text']), 'jenis'=>2, 'file'=>$filename, 'time'=>$time, 'date'=>$date,'agent'=>$agent['name']));
              }else{
                echo json_encode(array('status'=>true,'status_chat'=>'update_agent', 'text'=>nl2br($data_wa['text']), 'time'=>$time, 'date'=>$date,'agent'=>$agent['name']));
              }
            }else{
              echo json_encode(array('status'=>true,'status_chat'=>'update_agent', 'text'=>nl2br($data_wa['text']), 'time'=>$time, 'date'=>$date,'agent'=>$agent['name']));
            }
          }else{
            echo json_encode(array('status'=>false,'msg'=>$data_wa['message']));
          }
        }else{
          echo json_encode(array('status'=>false, 'msg'=>'Connection lost'));
        }
      }else{
        echo json_encode(array('status'=>false,'msg'=>'Unknown data request'));
      }
    }else{
      echo json_encode(array('status'=>200));
    }
  }

  public function avail_agent($type){
  	$data = $this->wachat_model->get_avail_agent($type);
  	echo json_encode($data);
  }

  public function total_agent($type){
  	$data = $this->wachat_model->get_online_agent($type);
  	echo $data;
  }

 


     public function agent_online($type)
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        $data = $this->wachat_model->get_online_agent($type);

  		       
        echo "data: {\n";
        echo "data: \"data\":\"" . $data . "\"\n";
        echo "data: }\n\n";
    }


  public function get_ticket($type){
		if($_POST){
			$list = $this->wachat_model->get_load_ticket($type);
			//echo $this->db->last_query();exit;
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $ticket) {
	            $no++;
	            $row = array();
	            $row[] = $ticket->id;
	            $row[] = $ticket->ticket_id;
	            $row[] = $ticket->category;
	            $row[] = $ticket->subject;
	            $row[] = $ticket->source;
	            //$row[] = $ticket->store_name;
	            $row[] = $ticket->status;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->wachat_model->count_ticket_all($type),
	                        "recordsFiltered" => $this->wachat_model->count_ticket_filtered($type),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			echo 'invalid request';
		}
	}

	function replay(){
		$data['message'] = '';		
		
		$this->load->view('replay',$data);
	}

	function t(){
		var_dump($this->wachat_model->get_avail_agent_l('Kanmo'));exit();
	}
	function refresh_assign_test(){
		var_dump($this->wa_data_model->agent('kanmo',123123));exit();
	}
	
	function status_chat(){
		//var_dump($_POST);exit();
		$this->wachat_model->status_chat();
		echo json_encode(array('status'=>true));
	}

}