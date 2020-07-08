<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_kegiatan extends MX_Controller {

	/**
	 * 
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'Laporan');
		if(!isset($this->menu['rule']['panel/laporan_kegiatan'])){
			show_404();
		}
		$this->load->model('laporan_kegiatan/laporan_kegiatan_model');
		
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		
	}

	public function index(){
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/laporan_kegiatan']['v']);
		if($_POST && $auth){

			
			$list = $this->laporan_kegiatan_model->get_load_result();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $admin) {
	            $no++;
	            $row = array();	  
	            $row[]=$no;          
	            $row[] = $admin->po_tgl_voucer_pinjaman;
	            $row[] = $admin->po_no_voucer_pinjaman;
	            $row[] = $admin->po_date;
	            $row[] = $admin->po_code_a;
	            $row[] = $admin->pod_item_name;
	            $row[] = $admin->pod_qty_approve;
	            $row[] =number_format($admin->pod_harga,0,',','.');
	            $row[] = $admin->d_name;
	            $row[] = number_format(($admin->pod_qty_approve*$admin->pod_harga),0,',','.');
	            
	            $row[] = $admin->k_name;
	            $row[] = $admin->po_status;	
	            $row[] = $admin->po_status;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->laporan_kegiatan_model->count_all(),
	                        "recordsFiltered" => $this->laporan_kegiatan_model->count_filtered(),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			$data['account'] = $this->laporan_kegiatan_model->get_account();
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/laporan_kegiatan'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS ADMINISTRATOR MENU');
			$this->template->view('view_laporan_kegiatan', $data);
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
		$auth = $this->template->set_auth($this->menu['rule']['panel/laporan_kegiatan']['c']);
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
            	if($this->laporan_kegiatan_model->insert()){
            		$this->userlog->add_log($this->session->userdata['name'], 
            		'INSERT v_transaksi with ID = '.$this->db->insert_id()
            		.' NAME = '.$_POST['t_a_code']);
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			$data['account'] = $this->laporan_kegiatan_model->get_account();
			//$data['jabatan'] = $this->laporan_kegiatan_model->get_jabatan();			
			$data['menu'] = $this->menu;
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS INPUT ANGGARAN MENU');
			$this->template->view('view_admin_insert', $data);
		}
	}

	public function admin_detail($id){
		$data['menu'] = $this->menu;
		if($this->template->set_auth($this->menu['rule']['panel/laporan_kegiatan']['v'])){
			$data['data'] = $this->laporan_kegiatan_model->find_by_id($id);
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW TRANSAKSI MENU ID: '.$id.' NAME: '.$data['data']->adm_name);
		}
		$this->template->view('view_admin_detail', $data);
	}

	public function edit($id){
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/laporan_kegiatan']['e']);
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
            	if($this->laporan_kegiatan_model->update($id)){
            		$this->userlog->add_log($this->session->userdata['name'],
            		'EDIT Transaksi ID: '.$id.'  WITH NEW VALUE '
            		.http_build_query($_POST,'',', '));
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			$data['data'] = $this->laporan_kegiatan_model->find_by_id($id);
			$data['account'] = $this->laporan_kegiatan_model->get_account();
			$data['menu'] = $this->menu;
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS EDIT TRANSAKSI ID: '.$id.' NAME: '.$data['data']->a_name);
			$this->template->view('view_account_edit', $data);
		}
	}

	public function delete(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/laporan_kegiatan']['d']);
		if($auth){
			$info = $this->laporan_kegiatan_model->get_name($_POST['d_id']);
			$info = str_replace('[', '', str_replace(']', '', json_encode($info)));
			if($this->laporan_kegiatan_model->delete()){
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
