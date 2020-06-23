<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends MX_Controller {

	/**
	 * 
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'Kode Anggaran');
		if(!isset($this->menu['rule']['panel/account'])){
			show_404();
		}
		$this->load->model('account/account_model');
		
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		
	}

	public function index(){
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/account']['v']);
		if($_POST && $auth){
			$list = $this->account_model->get_load_result();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $admin) {
	            $no++;
	            $row = array();	            
	            $row[] = $admin->a_code;	
	            $row[] = $admin->a_name;
	            $row[] = $admin->a_id;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->account_model->count_all(),
	                        "recordsFiltered" => $this->account_model->count_filtered(),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/admin'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS ADMINISTRATOR MENU');
			$this->template->view('view_account', $data);
		}
	}

	public function insert(){
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/admin']['c']);
		if($_POST && $auth){
            $this->form_validation->set_rules('a_name', 'Nama Anggaran', 'required');
            $this->form_validation->set_rules('a_code', 'Kode Anggaran', 'required');
           // $this->form_validation->set_rules('a_saldo', 'Kode Saldo', 'required');

            if ($this->form_validation->run() == false){
            	$data['status'] = false;
            	$data['e']['a_name'] = form_error('a_name', '<div class="has-error">', '</div>');
            	$data['e']['a_code'] = form_error('a_code', '<div class="has-error">', '</div>');
            	//$data['e']['a_saldo'] = form_error('a_saldo', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else{
            	if($this->account_model->insert()){
            		$this->userlog->add_log($this->session->userdata['name'], 
            		'INSERT Account with ID = '.$this->db->insert_id()
            		.' NAME = '.$_POST['a_name']);
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			//$data['divisi'] = $this->account_model->get_divisi();
			//$data['jabatan'] = $this->account_model->get_jabatan();			
			$data['menu'] = $this->menu;
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS INSERT USER MENU');
			$this->template->view('view_admin_insert', $data);
		}
	}

	public function admin_detail($id){
		$data['menu'] = $this->menu;
		if($this->template->set_auth($this->menu['rule']['panel/admin']['v'])){
			$data['data'] = $this->account_model->find_by_id($id);
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW ADMIN MENU ID: '.$id.' NAME: '.$data['data']->adm_name);
		}
		$this->template->view('view_admin_detail', $data);
	}

	public function edit($id){
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/admin']['e']);
		if($_POST && $auth){

			/* if name has changed from old, then check is_unique otherwise not*/
			$check_unique = ($_POST['a_name_old'] != $_POST['a_name'])?'|is_unique[v_account.a_name]':'';

			$check_unique2 = ($_POST['a_code_old'] != $_POST['a_code'])?'|is_unique[v_account.a_code]':'';
            $this->form_validation->set_rules('a_name', 'Nama', 'required|min_length[2]'.$check_unique);

            $this->form_validation->set_rules('a_code', 'Kode', 'required|min_length[2]'.$check_unique2);

            /* if email has changed from old, then check is_unique otherwise not*/
           
            $old_name = $_POST['a_name_old'];
            /* unset adm_name_old and adm_email_old from $_POST to preventing from database insert*/
            unset($_POST['a_name_old']);
            unset($_POST['a_code_old']);
            

            if ($this->form_validation->run() == false)
            {
            	$data['status'] = false;
            	$data['e']['a_name'] = form_error('a_name', '<div class="has-error">', '</div>');
            	$data['e']['a_code'] = form_error('a_code', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else{
            	if($this->account_model->update($id)){
            		$this->userlog->add_log($this->session->userdata['name'],
            		'EDIT ADMIN ID: '.$id.' NAME: '.$old_name.' WITH NEW VALUE '
            		.http_build_query($_POST,'',', '));
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			$data['data'] = $this->account_model->find_by_id($id);
			$data['menu'] = $this->menu;
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS EDIT ADMIN ID: '.$id.' NAME: '.$data['data']->a_name);
			$this->template->view('view_account_edit', $data);
		}
	}

	public function delete(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/account']['d']);
		if($auth){
			$info = $this->account_model->get_name($_POST['d_id']);
			$info = str_replace('[', '', str_replace(']', '', json_encode($info)));
			if($this->account_model->delete()){
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
