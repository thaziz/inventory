<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends CI_Controller {

	/**
	 * 
	 */

	public function __construct(){
		parent::__construct();
		$this->load->helper('download');
	}

	public function download($file){
		if(is_file($path = 'tmp/'.$this->session->userdata['name'].'/'.$file)){
			$file_path = $path;
			if(strpos($file, 'n.xlsx')!==false){
				$file_path = str_replace('n.xlsx', '.xlsx', $path);
				rename($path, $file_path);
			}
			force_download($file_path, NULL);
		}
	}

	public function check($downloaded){
		$response['status'] = false;
		if(is_dir($path = 'tmp/'.$this->session->userdata['name'].'/')){
			$files = array_diff(scandir($path), array('.','..'));
			if(count($files)>0){
				$count = 0;
				foreach ($files as $value) {
					if(strpos($value, 'n.xlsx')!==false){
						$count++;
					}
				}
				$response['status'] = true;
				$response['bedge'] = ($count>0);
				$response['count'] = $count;
				$response['files'] = $files;
			}
		}
		echo json_encode($response);
	}

}
