<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends CI_Controller {

	function __construct(){
		parent::__construct();
        $this->load->model('file_model'); 
        $this->load->helper('file');
	}

	function upload(){
		$this->load->library('upload');
      	$path = '/uploads/attachments/'.date('Y-m-d').'/';
		if (!is_dir($dir = 'assets'.$path)) {
 			mkdir($dir);
		}
      	$config['allowed_types'] = '*';
      	$config['upload_path']   = $dir;

      	$this->upload->initialize($config);
      	if(!$this->upload->do_upload('file')){
        	echo json_encode(array('status'=>'ERROR', 'errors'=>$this->upload->display_errors()));
      	}else{
        	$dataFile  = $this->upload->data();
        	$data['file_name'] = $dataFile['file_name'];
        	$data['user_id'] = $this->session->userdata('user_id');
        	$data['file_path'] = 'assets'.$path.$dataFile['file_name'];
        	$data['mime_type'] = get_mime_by_extension($dataFile['file_name']);
        	$id = $this->file_model->save_db($data);
        	echo json_encode(array('status'=>'OK','id'=>$id));
      	}
		
	}

	function attach(){
		$this->load->library('upload');
      	$path = '/uploads/attachments/'.date('Y-m-d').'/';
		if (!is_dir($dir = 'assets'.$path)) {
 			mkdir($dir);
		}
      	$config['allowed_types'] = '*';
      	$config['upload_path']   = $dir;

      	$this->upload->initialize($config);
      	if(!$this->upload->do_upload('file')){
        	echo json_encode(array('status'=>'ERROR', 'errors'=>$this->upload->display_errors()));
      	}else{
        	$dataFile  = $this->upload->data();
        	$data['file_name'] = $dataFile['file_name'];
        	$data['user_id'] = $this->session->userdata('user_id');
        	$data['file_path'] = 'assets'.$path.$dataFile['file_name'];
        	$data['mime_type'] = get_mime_by_extension($dataFile['file_name']);
        	$id = $this->file_model->save_db($data);
        	$this->file_model->add_attach(array('file_id'=>$id, 'ticket_id'=>$_POST['ticket_id'], 'user_id'=>$data['user_id'], 'file_name'=>$data['file_name']));
        	echo json_encode(array('status'=>'OK','id'=>$id));
      	}
		
	}

	function delete(){
		$id = $_POST['id'];
		$file = $this->file_model->get_file($id);
		if($this->file_model->delete_file($id)){
			unlink($file->file_path);
			echo json_encode(array('status'=>true));
		}else{
			echo json_encode(array('status'=>false, 'msg'=>'Delete file failed'));
		}
	}

  public function test(){
    $this->load->helper('mail');
    response_email(array('mail_to'=>'annas.elh@hotmail.com', 'subject'=>'Test Email', 'message'=>'Email pesan'));
  }

}