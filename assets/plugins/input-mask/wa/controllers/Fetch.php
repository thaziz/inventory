<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fetch extends CI_Controller {


   public function __construct(){   
    parent::__construct();      
    
       $this->load->model('wa_model');
       
       $this->load->model('wa_data_model');
       $this->load->model('wachat_model');

       $this->load->model('kanmo_model');
   }

   public function index(){
   		$date_min = strtotime(date('Y-m-d 00:00:01'));
      $data_api = $this->wa_model->get_api_account($ik=null,$_GET['type']);
   		//echo $date_min;
      if(isset($data_api->api_url)) {
   		$limit = 1000;
   		$curl = curl_init();
      	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
      	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
      	curl_setopt($curl, CURLOPT_URL,$data_api->api_url.'messages?token='.$data_api->auth_key.'&min_time='.$date_min.'&limit='.$limit);
      	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
        //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: '.$data_api->auth_key));
          curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        //curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($data, true);

        foreach ($data['messages'] as $key => $value) {
        	//echo json_encode($value);
        	$this->curl(array('messages'=>array($value)), $_GET['type']);
        }
      }
   }

   private function curl($data, $type) {
   		//echo $data;exit;
   	//echo http_build_query($data);exit;
   		$ch = curl_init();
      	curl_setopt($ch, CURLOPT_URL,'http://localhost/kanmo/wa/webhook/'.strtolower($type).'?phone=622129181155');
      	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

// Return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the POST request
$result = curl_exec($ch);

// Close cURL resource
curl_close($ch);

        echo $result.' d<br>';
   }


   public function scan_qrcode($type){
      $curl = curl_init();
      $data_api = $this->wa_model->get_api_account($ik=null, $type);
      $url = $data_api->api_url.'status?token='.$data_api->auth_key;

        curl_setopt($curl, CURLOPT_URL,$url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        //curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array('phone'=>$_GET['phone'], 'messageId'=>$_GET['chatid'], 'body'=>$_GET['message'])));
     

        

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
        //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: '.$data_api->auth_key));
          curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        //curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($curl);
        curl_close($curl);
        if(!empty($data)) {
          $data = json_decode($data,true);
          if($data['accountStatus']=='got qr code'){
            echo '<html><head></head><body><div style="width:100%;height:100%;display:flex;justify-content:center;align-item:center;"><img src="'.$data['qrCode'].'" style="width:350px;height:400px;"></div></body></html>';
          } else {
            print_r($data);
          }
        }
        /*if(!empty($data))
          echo '<html><head></head><body><div style="width:100%;height:100%;display:flex;justify-content:center;align-item:center;"><img src="'.$data.'" style="width:250px;"></div></body></html>';*/

   }

}