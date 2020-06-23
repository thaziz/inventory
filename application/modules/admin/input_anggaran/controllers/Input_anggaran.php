<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Input_anggaran extends MX_Controller {

	/**
	 * 
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		//hilight header menu
		$this->menu = $this->menu_model->load_menu('admin', 'Transaksi');
		if(!isset($this->menu['rule']['panel/input_anggaran'])){
			show_404();
		}
		$this->load->model('input_anggaran/account_model');
		
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		
	}

	public function index(){
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/input_anggaran']['v']);
		if($_POST && $auth){
			$list = $this->account_model->get_load_result();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $admin) {
	            $no++;
	            $row = array();	            
	            $row[] = $admin->a_code;	
	            $row[] = $admin->a_name;
	            $row[] = $admin->oa_year;
	            $row[] = number_format($admin->oa_saldo,0,',','.');
	            $row[] =number_format($admin->saldo_akhir,0,',','.');
	            $row[] = $admin->oa_id;
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
			$data['rules'] = $this->menu['rule']['panel/input_anggaran'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS ADMINISTRATOR MENU');
			$this->template->view('view_account', $data);
		}
	}

function check_user() {

    $oa_account_id = $this->input->post('oa_account_id');// get fiest name
    $oa_year = $this->input->post('tahun');// get last name
    $this->db->select('oa_id');
    $this->db->from('v_opening_account');
    $this->db->where('oa_year', $oa_year);
    $this->db->where('oa_account_id', $oa_account_id);
    $query = $this->db->get();
    $num = $query->num_rows();
    //var_dump($query->result());exit();
    if ($num > 0) {
    	
        return false;
    } else {

    	return TRUE;
    }
}

	public function insert(){
		//var_dump($_POST);exit();
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/input_anggaran']['c']);
		if($_POST && $auth){
			$a=$this->check_user($_POST['oa_account_id'],$_POST['tahun']);
			if($a==false){
				$data['status'] = false;            	
				$data['e']['oa_account_id']='<div class="has-error">Anggaran sudah ada.</div>';
				echo json_encode($data);
				exit();
			}
            $this->form_validation->set_rules('oa_account_id', 'Nama Anggaran', 'required');
            $this->form_validation->set_rules('oa_saldo', 'Anggaran', 'required');
           // $this->form_validation->set_rules('a_saldo', 'Kode Saldo', 'required');
            unset($_POST['tahun']);
            if ($this->form_validation->run() == false){
            	$data['status'] = false;
            	$data['e']['oa_account_id'] = form_error('oa_account_id', '<div class="has-error">', '</div>');
            	$data['e']['oa_saldo'] = form_error('oa_saldo', '<div class="has-error">', '</div>');
            	
            	echo json_encode($data);
            }else{
            	if($this->account_model->insert()){
            		$this->userlog->add_log($this->session->userdata['name'], 
            		'INSERT Account with ID = '.$this->db->insert_id()
            		.' NAME = '.$_POST['oa_account_id']);
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			$data['account'] = $this->account_model->get_account();
			//$data['jabatan'] = $this->account_model->get_jabatan();			
			$data['menu'] = $this->menu;
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS INPUT ANGGARAN MENU');
			$this->template->view('view_admin_insert', $data);
		}
	}

	public function admin_detail($id){
		$data['menu'] = $this->menu;
		if($this->template->set_auth($this->menu['rule']['panel/input_anggaran']['v'])){
			$data['data'] = $this->account_model->find_by_id($id);
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW ADMIN MENU ID: '.$id.' NAME: '.$data['data']->adm_name);
		}
		$this->template->view('view_admin_detail', $data);
	}

	public function edit($id){
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/input_anggaran']['e']);
		if($_POST && $auth){
			if($_POST['oa_account_id'] != $_POST['oa_account_id_old']){
				$a=$this->check_user($_POST['oa_account_id'],$_POST['tahun']);
					if($a==false){
						$data['status'] = false;            	
						$data['e']['oa_account_id']='<div class="has-error">Anggaran sudah ada.</div>';
						echo json_encode($data);
						exit();
					}
			}


            $this->form_validation->set_rules('oa_account_id', 'Nama Anggaran', 'required');

            $this->form_validation->set_rules('oa_saldo', 'Saldo', 'required');

            /* if email has changed from old, then check is_unique otherwise not*/
           
          
			unset($_POST['tahun']);
			unset($_POST['oa_account_id_old']);            

            if ($this->form_validation->run() == false)
            {
            	$data['status'] = false;
            	$data['e']['oa_account_id'] = form_error('oa_account_id', '<div class="has-error">', '</div>');
            	$data['e']['oa_saldo'] = form_error('oa_saldo', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else{
            	if($this->account_model->update($id)){
            		$this->userlog->add_log($this->session->userdata['name'],
            		'EDIT ADMIN ID: '.$id.'  WITH NEW VALUE '
            		.http_build_query($_POST,'',', '));
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			$data['data'] = $this->account_model->find_by_id($id);
			$data['account'] = $this->account_model->get_account();
			$data['menu'] = $this->menu;
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS EDIT ADMIN ID: '.$id.' NAME: '.$data['data']->a_name);
			$this->template->view('view_account_edit', $data);
		}
	}

	public function delete(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/input_anggaran']['d']);
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
