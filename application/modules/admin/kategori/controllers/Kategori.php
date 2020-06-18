<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends MX_Controller {

	/**
	 * 
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'kategori');
		if(!isset($this->menu['rule']['panel/bidang'])){
			show_404();
		}
		$this->load->model('kategori/kategori_model');
		
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		
	}

	public function index(){
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/bidang']['v']);
		if($_POST && $auth){
			$list = $this->kategori_model->get_load_result();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $admin) {
	            $no++;
	            $row = array();	            	            	
	            $row[] = $admin->k_name;		                        
	            $row[] = $admin->k_note;
	            $row[] = $admin->k_sk_bupati;  
	            $row[] = $admin->k_sk;            
	            $row[] = $admin->k_status;  
	            $row[] = $admin->k_id;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->kategori_model->count_all(),
	                        "recordsFiltered" => $this->kategori_model->count_filtered(),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/admin'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS ADMINISTRATOR MENU');
			$this->template->view('view_kategori', $data);
		}
	}

	public function insert(){
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/admin']['c']);
		if($_POST && $auth){
            $this->form_validation->set_rules('k_name', 'Nama', 'required');
            $this->form_validation->set_rules('k_sk', 'SK', 'required|is_unique[v_kategori.k_sk]');
            $this->form_validation->set_rules('k_sk_bupati', 'SK Bupati', 'required|is_unique[v_kategori.k_sk_bupati]');
            $this->form_validation->set_rules('k_note', 'Keterangan', 'required');

            if ($this->form_validation->run() == false){
            	$data['status'] = false;
            	$data['e']['k_name'] = form_error('k_name', '<div class="has-error">', '</div>');
            	$data['e']['k_sk'] = form_error('k_sk', '<div class="has-error">', '</div>');
            	$data['e']['k_sk_bupati'] = form_error('k_sk_bupati', '<div class="has-error">', '</div>');
            	$data['e']['k_note'] = form_error('k_note', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else{
            	if($this->kategori_model->insert()){
            		$this->userlog->add_log($this->session->userdata['name'], 
            		'INSERT kategori with ID = '.$this->db->insert_id()
            		.' NAME = '.$_POST['k_name']);
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			$data['divisi'] = $this->kategori_model->get_divisi();
			$data['jabatan'] = $this->kategori_model->get_jabatan();			
			$data['menu'] = $this->menu;
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS INSERT USER MENU');
			$this->template->view('view_kategori_insert', $data);
		}
	}

	public function admin_detail($id){
		$data['menu'] = $this->menu;
		if($this->template->set_auth($this->menu['rule']['panel/admin']['v'])){
			$data['data'] = $this->kategori_model->find_by_id($id);
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW ADMIN MENU ID: '.$id.' NAME: '.$data['data']->adm_name);
		}
		$this->template->view('view_admin_detail', $data);
	}

	public function edit($id){
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/admin']['e']);
		if($_POST && $auth){

			/* if name has changed from old, then check is_unique otherwise not*/
		

			$check_unique2 = ($_POST['k_sk'] != $_POST['k_sk_old'])?'|is_unique[v_kategori.k_sk]':'';

            $this->form_validation->set_rules('k_name', 'Nama', 'required|min_length[2]');

            $this->form_validation->set_rules('k_sk', 'Kode', 'required|min_length[2]'.$check_unique2);

            /* if email has changed from old, then check is_unique otherwise not*/
           
            /* unset adm_name_old and adm_email_old from $_POST to preventing from database insert*/
           unset($_POST['k_sk_old']);
            

            if ($this->form_validation->run() == false)
            {
            	$data['status'] = false;
            	$data['e']['k_name'] = form_error('k_name', '<div class="has-error">', '</div>');
            	$data['e']['k_sk'] = form_error('k_sk', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else{
            	if($this->kategori_model->update($id)){
            		$this->userlog->add_log($this->session->userdata['name'],
            		'EDIT ADMIN ID: '.$id.' NAME: '.$_POST['k_name'].' WITH NEW VALUE '
            		.http_build_query($_POST,'',', '));
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			$data['data'] = $this->kategori_model->find_by_id($id);
			$data['menu'] = $this->menu;
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS EDIT ADMIN ID: '.$id.' NAME: '.$data['data']->k_name);
			$this->template->view('view_kategori_edit', $data);
		}
	}

	public function delete(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/bidang']['d']);
		//var_dump($_POST);exit();
		if($auth){
			$info = $this->kategori_model->get_name($_POST['d_id']);
			$info = str_replace('[', '', str_replace(']', '', json_encode($info)));
			if($this->kategori_model->delete()){
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
