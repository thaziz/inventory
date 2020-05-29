<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MX_Controller {

	/**
	 * 
	 */

	public function __construct(){
		$this->load->model('call_model');
	}

	public function index(){}

	public function status_call(){
		if($this->call_model->update_status()){
			echo json_encode(array('status'=>'OK'));
		}else{
			echo json_encode(array('status'=>'ERROR'));			
		}
	}

	public function status_dial(){
		if($this->call_model->update_dial()){
			echo json_encode(array('status'=>'OK'));
		}else{
			echo json_encode(array('status'=>'ERROR'));			
		}
	}
}