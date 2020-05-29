<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_log extends MX_Controller {

	/**
	 * 
	 */

	public function __construct(){
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'logs');
		if(!isset($this->menu['rule']['panel/user_log'])){
			show_404();
		}
	}

	public function index(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/user_log']['v']);
		if($_POST && $auth){
			$list = $this->userlog->get_load_result();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $userlog) {
	            $no++;
	            $row = array();
	            $row[] = $userlog->log_id;
	            $row[] = $userlog->user;
	            $row[] = $this->pretify_text($userlog->logger_text);
	            $row[] = $userlog->date;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->userlog->count_all(),
	                        "recordsFiltered" => $this->userlog->count_filtered(),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			$this->userlog->add_log($this->session->userdata['name'], 
				'ACCESS SETTING USER LOG');
			$this->template->view('view_userlog', $data);
		}
	}

	private function pretify_text($text){
		$text = preg_replace('/^DELETE/i', '<span class="text-danger"><strong>DELETE</strong></span>', $text);
		$text = preg_replace('/^INSERT/i', '<span class="text-success"><strong>INSERT</strong></span>', $text);
		$text = preg_replace('/^EDIT/i', '<span class="text-primary"><strong>EDIT</strong></span>', $text);
		$text = preg_replace('/VIEW/i', '<span class="text-warning"><strong>VIEW</strong></span>', $text);
		return $text;
	}

	public function user_log_delete(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/user_log']['d']);
		if($auth){
			if($this->userlog->delete()){
				$data['status'] = true;
			}else{
				$data['status'] = false;
			}
			print_r(json_encode($data));
		}
	}

}
