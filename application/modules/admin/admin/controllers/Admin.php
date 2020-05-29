<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller {

	/**
	 * 
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'administrator');
		if(!isset($this->menu['rule']['panel/admin'])){
			show_404();
		}
		$this->load->model('admin/admin_model');
		$this->load->model('admin/group_model');
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		
	}

	public function index(){
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/admin']['v']);
		if($_POST && $auth){
			$list = $this->admin_model->get_load_result();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $admin) {
	            $no++;
	            $row = array();
	            $row[] = $admin->adm_id;
	            $row[] = $admin->adm_name;
	            $row[] = $admin->adm_nik;
	            $row[] = $admin->adm_bidang;
	            $row[] = $admin->adm_jabatan;
	            $row[] = $admin->grp_name;
	            $row[] = $admin->adm_active;
	            $row[] = $admin->adm_lastlogin;
	            $row[] = $admin->adm_lastlogout;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->admin_model->count_all(),
	                        "recordsFiltered" => $this->admin_model->count_filtered(),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/admin'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS ADMINISTRATOR MENU');
			$this->template->view('view_admin', $data);
		}
	}

	public function admin_insert(){
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/admin']['c']);
		if($_POST && $auth){
            $this->form_validation->set_rules('adm_name', 'Name', 'required');
            $this->form_validation->set_rules('adm_bidang', 'Bidang', 
            				'required');
            $this->form_validation->set_rules('adm_password', 'Password', 'required');
            $this->form_validation->set_rules('grp_id', 'Group', 'required|numeric');
            if ($this->form_validation->run() == false){
            	$data['status'] = false;
            	$data['e']['adm_name'] = form_error('adm_name', '<div class="has-error">', '</div>');
            	$data['e']['adm_bidang'] = form_error('adm_bidang', '<div class="has-error">', '</div>');
            	$data['e']['adm_password'] = form_error('adm_password', '<div class="has-error">', '</div>');
            	$data['e']['grp_id'] = form_error('grp_id', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else{
            	if($this->admin_model->insert()){
            		$this->userlog->add_log($this->session->userdata['name'], 
            		'INSERT USER with ID = '.$this->db->insert_id()
            		.' NAME = '.$_POST['adm_name']);
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			$data['group'] = $this->group_model->get_list();
			$data['divisi'] = $this->admin_model->get_divisi();
			$data['jabatan'] = $this->admin_model->get_jabatan();			
			$data['menu'] = $this->menu;
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS INSERT USER MENU');
			$this->template->view('view_admin_insert', $data);
		}
	}

	public function admin_detail($id){
		$data['menu'] = $this->menu;
		if($this->template->set_auth($this->menu['rule']['panel/admin']['v'])){
			$data['data'] = $this->admin_model->find_by_id($id);
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW ADMIN MENU ID: '.$id.' NAME: '.$data['data']->adm_name);
		}
		$this->template->view('view_admin_detail', $data);
	}

	public function admin_edit($id){
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/admin']['e']);
		if($_POST && $auth){

			/* if name has changed from old, then check is_unique otherwise not*/
			$check_unique = ($_POST['adm_name'] != $_POST['adm_name_old'])?'|is_unique[v_admin.adm_name]':'';
            $this->form_validation->set_rules('adm_name', 'Name', 'required|min_length[3]'.$check_unique);

            /* if email has changed from old, then check is_unique otherwise not*/
           
            $this->form_validation->set_rules('adm_bidang', 'Bidang', 'required');
            $this->form_validation->set_rules('grp_id', 'Group', 'required|numeric');

            $check_unique = ($_POST['adm_nik'] != $_POST['adm_nik_old'])?'|is_unique[v_admin.adm_nik]':'';
            $this->form_validation->set_rules('adm_nik', 'NIK', 'required'.$check_unique);

            $check_unique = ($_POST['adm_login_old'] != $_POST['adm_login'])?'|is_unique[v_admin.adm_login]':'';
            $this->form_validation->set_rules('adm_login', 'Login', 'required|min_length[3]'.$check_unique);
            

            $old_name = $_POST['adm_name_old'];
            /* unset adm_name_old and adm_email_old from $_POST to preventing from database insert*/
            unset($_POST['adm_name_old']);
             unset($_POST['adm_nik_old']);
             unset($_POST['adm_login_old']);

            if ($this->form_validation->run() == false)
            {
            	$data['status'] = false;
            	$data['e']['adm_name'] = form_error('adm_name', '<div class="has-error">', '</div>');
            	$data['e']['adm_bidang'] = form_error('adm_bidang', '<div class="has-error">', '</div>');
            	$data['e']['adm_nik'] = form_error('adm_nik', '<div class="has-error">', '</div>');
            	$data['e']['adm_login'] = form_error('adm_login', '<div class="has-error">', '</div>');
            	$data['e']['grp_id'] = form_error('grp_id', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else{
            	if($this->admin_model->update($id)){
            		$this->userlog->add_log($this->session->userdata['name'],
            		'EDIT ADMIN ID: '.$id.' NAME: '.$old_name.' WITH NEW VALUE '
            		.http_build_query($_POST,'',', '));
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			$data['data'] = $this->admin_model->find_by_id($id);
			$data['group'] = $this->group_model->get_list();			
			$data['divisi'] = $this->admin_model->get_divisi();
			$data['jabatan'] = $this->admin_model->get_jabatan();
			$data['menu'] = $this->menu;
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS EDIT ADMIN ID: '.$id.' NAME: '.$data['data']->adm_name);
			$this->template->view('view_admin_edit', $data);
		}
	}

	public function admin_delete(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/admin']['d']);
		if($auth){
			$info = $this->admin_model->get_name($_POST['adm_id']);
			$info = str_replace('[', '', str_replace(']', '', json_encode($info)));
			if($this->admin_model->delete()){
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
