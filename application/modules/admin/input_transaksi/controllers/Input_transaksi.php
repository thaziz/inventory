<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Input_transaksi extends MX_Controller {

	/**
	 * 
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'Transaksi');
		if(!isset($this->menu['rule']['panel/input_transaksi'])){
			show_404();
		}
		$this->load->model('input_transaksi/transaksi_model');
		
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		
	}

	public function index(){
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/input_transaksi']['v']);
		if($_POST && $auth){
			$list = $this->transaksi_model->get_load_result();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $admin) {
	            $no++;
	            $row = array();	            
	            $row[] = $admin->a_code;	
	            $row[] = $admin->a_name;
	            $row[] = $admin->t_year;
	            $row[] = number_format($admin->t_nominal,0,',','.');
	            $row[] = $admin->t_note;
	            $row[] = date('d-m-Y H:i:s',strtotime($admin->t_created));
	            $row[] = $admin->t_updated==NULL?'':date('d-m-Y H:i:s',strtotime($admin->t_updated));
	            $row[] = $admin->t_id;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->transaksi_model->count_all(),
	                        "recordsFiltered" => $this->transaksi_model->count_filtered(),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/input_transaksi'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS ADMINISTRATOR MENU');
			$this->template->view('view_transaksi', $data);
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
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/input_transaksi']['c']);
		if($_POST && $auth){
				

            $this->form_validation->set_rules('t_a_code', 'Nama Anggaran', 'required');
            $this->form_validation->set_rules('t_nominal', 'Saldo', 'required');
            $this->form_validation->set_rules('t_note', 'Keterangan', 'required');
           // $this->form_validation->set_rules('a_saldo', 'Kode Saldo', 'required');
            
            if ($this->form_validation->run() == false){
            	$data['status'] = false;
            	$data['e']['t_a_code'] = form_error('t_a_code', '<div class="has-error">', '</div>');
            	$data['e']['t_nominal'] = form_error('t_nominal', '<div class="has-error">', '</div>');
            	$data['e']['t_note'] = form_error('t_note', '<div class="has-error">', '</div>');
            	
            	
            	echo json_encode($data);
            }else{
            	if($this->transaksi_model->insert()){
            		$this->userlog->add_log($this->session->userdata['name'], 
            		'INSERT v_transaksi with ID = '.$this->db->insert_id()
            		.' NAME = '.$_POST['t_a_code']);
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			$data['account'] = $this->transaksi_model->get_account();
			//$data['jabatan'] = $this->transaksi_model->get_jabatan();			
			$data['menu'] = $this->menu;
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS INPUT ANGGARAN MENU');
			$this->template->view('view_admin_insert', $data);
		}
	}

	public function admin_detail($id){
		$data['menu'] = $this->menu;
		if($this->template->set_auth($this->menu['rule']['panel/input_transaksi']['v'])){
			$data['data'] = $this->transaksi_model->find_by_id($id);
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW TRANSAKSI MENU ID: '.$id.' NAME: '.$data['data']->adm_name);
		}
		$this->template->view('view_admin_detail', $data);
	}

	public function edit($id){
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/input_transaksi']['e']);
		if($_POST && $auth){
		
            $this->form_validation->set_rules('t_a_code', 'Nama Anggaran', 'required');
            $this->form_validation->set_rules('t_tahun', 'Tahun', 'required');
            $this->form_validation->set_rules('t_nominal', 'Nominal', 'required');
            $this->form_validation->set_rules('t_note', 'Keterangan', 'required');


            if ($this->form_validation->run() == false)
            {
            	$data['status'] = false;
            	$data['e']['oa_account_id'] = form_error('oa_account_id', '<div class="has-error">', '</div>');
            	$data['e']['oa_saldo'] = form_error('oa_saldo', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else{
            	if($this->transaksi_model->update($id)){
            		$this->userlog->add_log($this->session->userdata['name'],
            		'EDIT Transaksi ID: '.$id.'  WITH NEW VALUE '
            		.http_build_query($_POST,'',', '));
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			$data['data'] = $this->transaksi_model->find_by_id($id);
			$data['account'] = $this->transaksi_model->get_account();
			$data['menu'] = $this->menu;
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS EDIT TRANSAKSI ID: '.$id.' NAME: '.$data['data']->a_name);
			$this->template->view('view_account_edit', $data);
		}
	}

	public function delete(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/input_transaksi']['d']);
		if($auth){
			$info = $this->transaksi_model->get_name($_POST['d_id']);
			$info = str_replace('[', '', str_replace(']', '', json_encode($info)));
			if($this->transaksi_model->delete()){
				$this->userlog->add_log($this->session->userdata['name'], 'DELETE TRANSAKSI '.$info);
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
