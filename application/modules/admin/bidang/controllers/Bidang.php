<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bidang extends MX_Controller {

	/**
	 * 
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'Master');
		if(!isset($this->menu['rule']['panel/bidang'])){
			show_404();
		}
		$this->load->model('bidang/bidang_model');
		
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		
	}

	public function index(){
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/bidang']['v']);
		if($_POST && $auth){
			$list = $this->bidang_model->get_load_result();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $admin) {
	            $no++;
	            $row = array();
	            $row[] = $admin->d_name;
	            $row[] = $admin->d_code;	            
	            $row[] = $admin->d_id;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->bidang_model->count_all(),
	                        "recordsFiltered" => $this->bidang_model->count_filtered(),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/bidang'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS BIDANG MENU');
			$this->template->view('view_admin', $data);
		}
	}

	public function insert(){
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/bidang']['c']);
		if($_POST && $auth){
            $this->form_validation->set_rules('d_name', 'Nama Bidang', 'required');
            $this->form_validation->set_rules('d_code', 'Kode Purchase', 'required');
            if ($this->form_validation->run() == false){
            	$data['status'] = false;
            	$data['e']['d_name'] = form_error('d_name', '<div class="has-error">', '</div>');
            	$data['e']['d_code'] = form_error('d_code', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else{
            	if($this->bidang_model->insert()){
            		$this->userlog->add_log($this->session->userdata['name'], 
            		'INSERT Bidang with ID = '.$this->db->insert_id()
            		.' NAME = '.$_POST['d_name']);
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			$data['divisi'] = $this->bidang_model->get_divisi();
			$data['jabatan'] = $this->bidang_model->get_jabatan();			
			$data['menu'] = $this->menu;
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS INSERT BIDANG MENU');
			$this->template->view('view_admin_insert', $data);
		}
	}

	public function admin_detail($id){
		$data['menu'] = $this->menu;
		if($this->template->set_auth($this->menu['rule']['panel/bidang']['v'])){
			$data['data'] = $this->bidang_model->find_by_id($id);
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW ADMIN MENU ID: '.$id.' NAME: '.$data['data']->adm_name);
		}
		$this->template->view('view_admin_detail', $data);
	}

	public function edit($id){
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/bidang']['e']);
		if($_POST && $auth){

			/* if name has changed from old, then check is_unique otherwise not*/
			$check_unique = ($_POST['d_name_old'] != $_POST['d_name_old'])?'|is_unique[v_divisi.d_name]':'';
            $this->form_validation->set_rules('d_name', 'Name', 'required|min_length[2]'.$check_unique);

            /* if email has changed from old, then check is_unique otherwise not*/
           
            $this->form_validation->set_rules('d_code', 'Kode Purchase', 'required'.$check_unique);
           
            $old_name = $_POST['d_name_old'];
            /* unset adm_name_old and adm_email_old from $_POST to preventing from database insert*/
            unset($_POST['d_name_old']);
            unset($_POST['d_code_old']);
            

            if ($this->form_validation->run() == false)
            {
            	$data['status'] = false;
            	$data['e']['d_name'] = form_error('d_name', '<div class="has-error">', '</div>');
            	$data['e']['d_code'] = form_error('d_code', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else{
            	if($this->bidang_model->update($id)){
            		$this->userlog->add_log($this->session->userdata['name'],
            		'EDIT ADMIN ID: '.$id.' NAME: '.$old_name.' WITH NEW VALUE '
            		.http_build_query($_POST,'',', '));
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			$data['data'] = $this->bidang_model->find_by_id($id);
			$data['menu'] = $this->menu;
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS EDIT ADMIN ID: '.$id.' NAME: '.$data['data']->d_name);
			$this->template->view('view_admin_edit', $data);
		}
	}

	public function delete(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/bidang']['d']);
		if($auth){
			$info = $this->bidang_model->get_name($_POST['d_id']);
			$info = str_replace('[', '', str_replace(']', '', json_encode($info)));
			if($this->bidang_model->delete()){
				$this->userlog->add_log($this->session->userdata['name'], 'DELETE BIDANG '.$info);
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
