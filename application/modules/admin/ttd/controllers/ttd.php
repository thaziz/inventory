<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ttd extends MX_Controller {

	/**
	 * 
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'Master');
		if(!isset($this->menu['rule']['panel/ttd'])){
			show_404();
		}
		$this->load->model('ttd/ttd_model');
		
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		
	}

	public function index(){
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/ttd']['v']);
		if($_POST && $auth){
			$list = $this->ttd_model->get_load_result();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $admin) {
	            $no++;
	            $row = array();
	            $row[] = $admin->telaahan1;
	            $row[] = $admin->nik1;
	            $row[] = $admin->telaahan2;
	            $row[] = $admin->nik2;
	            $row[] = $admin->telaahan3;
	            $row[] = $admin->nik3;
	            $row[] = $admin->telaahan4;
	            $row[] = $admin->nik4;	
	            $row[] = $admin->peminjaman1;
	            $row[] = $admin->nikp1;	
	            $row[] = $admin->peminjaman2;
	            $row[] = $admin->nikp2;
	            $row[] = $admin->status;	            
	            $row[] = $admin->id;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->ttd_model->count_all(),
	                        "recordsFiltered" => $this->ttd_model->count_filtered(),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/ttd'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS ADMINISTRATOR MENU');
			$this->template->view('view_ttd', $data);
		}
	}

	public function insert(){
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/ttd']['c']);
		if($_POST && $auth){
            $this->form_validation->set_rules('telaahan1', 'Telaahan 1', 'required');
            $this->form_validation->set_rules('telaahan2', 'telaahan 2','required');
            $this->form_validation->set_rules('telaahan3', 'telaahan 3', 'required');
            $this->form_validation->set_rules('telaahan4', 'telaahan 4', 'required');
            $this->form_validation->set_rules('nik1', 'nik 1','required');
            /*$this->form_validation->set_rules('nik2 ', 'nik 2','required');
            $this->form_validation->set_rules('nik3', 'nik 3','required');
            $this->form_validation->set_rules('nik4 ', 'nik 4','required');*/
           // var_dump($this->form_validation->run());exit();

            if ($this->form_validation->run() == false){
            	$data['status'] = false;
            	$data['e']['telaahan1'] = form_error('telaahan1', '<div class="has-error">', '</div>');
            	$data['e']['telaahan2'] = form_error('telaahan2', '<div class="has-error">', '</div>');
            	$data['e']['telaahan3'] = form_error('telaahan3', '<div class="has-error">', '</div>');
            	$data['e']['telaahan4'] = form_error('telaahan4', '<div class="has-error">', '</div>');
            	$data['e']['nik1'] = form_error('nik1', '<div class="has-error">', '</div>');
            	$data['e']['nik2'] = form_error('nik2', '<div class="has-error">', '</div>');
            	$data['e']['nik3'] = form_error('nik3', '<div class="has-error">', '</div>');
            	$data['e']['nik4'] = form_error('nik4', '<div class="has-error">', '</div>');

            	echo json_encode($data);
            }else{
            	if($this->ttd_model->insert()){
            		$this->userlog->add_log($this->session->userdata['name'], 
            		'INSERT TTD with ID = '.$this->db->insert_id()
            		);
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			$data['menu'] = $this->menu;
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS INSERT USER MENU');
			$this->template->view('view_insert', $data);
		}
	}

	public function detail($id){
		$data['menu'] = $this->menu;
		if($this->template->set_auth($this->menu['rule']['panel/ttd']['v'])){
			$data['data'] = $this->ttd_model->find_by_id($id);
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW TTD MENU ID: '.$id);
		}
		$this->template->view('view_admin_detail', $data);
	}

	public function edit($id){
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/ttd']['e']);
		if($_POST && $auth){
			 $this->form_validation->set_rules('telaahan1', 'Telaahan 1', 'required');
            $this->form_validation->set_rules('telaahan2', 'telaahan 2','required');
            $this->form_validation->set_rules('telaahan3', 'telaahan 3', 'required');
            $this->form_validation->set_rules('telaahan4', 'telaahan 4', 'required');
            $this->form_validation->set_rules('nik1', 'nik 1','required');
            /*$this->form_validation->set_rules('nik2 ', 'nik 2','required');
            $this->form_validation->set_rules('nik3', 'nik 3','required');
            $this->form_validation->set_rules('nik4 ', 'nik 4','required');*/
           // var_dump($this->form_validation->run());exit();

            if ($this->form_validation->run() == false){
            	$data['status'] = false;
            	$data['e']['telaahan1'] = form_error('telaahan1', '<div class="has-error">', '</div>');
            	$data['e']['telaahan2'] = form_error('telaahan2', '<div class="has-error">', '</div>');
            	$data['e']['telaahan3'] = form_error('telaahan3', '<div class="has-error">', '</div>');
            	$data['e']['telaahan4'] = form_error('telaahan4', '<div class="has-error">', '</div>');
            	$data['e']['nik1'] = form_error('nik1', '<div class="has-error">', '</div>');
            	$data['e']['nik2'] = form_error('nik2', '<div class="has-error">', '</div>');
            	$data['e']['nik3'] = form_error('nik3', '<div class="has-error">', '</div>');
            	$data['e']['nik4'] = form_error('nik4', '<div class="has-error">', '</div>');

            	echo json_encode($data);		
        
            }else{
            	if($this->ttd_model->update($id)){
            		$this->userlog->add_log($this->session->userdata['name'],
            		'EDIT TTD ID: '.$id. 'WITH NEW VALUE '
            		.http_build_query($_POST,'',', '));
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			$data['data'] = $this->ttd_model->find_by_id($id);
			
			$data['menu'] = $this->menu;
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS EDIT TTD ID: '.$id);
			$this->template->view('view_edit', $data);
		}
	}

	public function admin_delete(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/ttd']['d']);
		if($auth){
			$info = $this->ttd_model->get_name($_POST['adm_id']);
			$info = str_replace('[', '', str_replace(']', '', json_encode($info)));
			if($this->ttd_model->delete()){
				$this->userlog->add_log($this->session->userdata['name'], 'DELETE ADMIN '.$info);
				$data['status'] = true;
			}else{
				$data['status'] = false;
			}
			echo json_encode($data);
		}else{
			$this->template->view('');
		}
	}

}
