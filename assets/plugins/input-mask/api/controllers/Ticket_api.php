<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Ticket_api extends MX_Controller {

	public function __construct(){
		$this->load->model('Ticket_api_new_model');
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');

	}
	public function index(){
			echo md5('coba');
		}
	public function create(){
			/*if($_POST){*/
				$this->load->library('form_validation');
				$this->form_validation->set_rules('cus_fname', 'First Name', 'required');
            	if ($this->form_validation->run() == false)
            	{
					echo "isian belum benar";
            	}
            	else{
if($this->Ticket_api_new_model->save_ticket()){
	echo json_encode(array('status'=>true));
}else{
	echo json_encode(array('status'=>false, 'code'=>500));
}
            	}
	}


}