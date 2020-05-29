<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'/third_party/Box/Spout/Autoloader/autoload.php';
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\Style;
use Box\Spout\Writer\Style\Border;
use Box\Spout\Writer\Style\BorderBuilder;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\WriterFactory;

class request_order extends MX_Controller {

	/**
	 *
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'Permintaan');
		if(!isset($this->menu['rule']['panel/request_order'])){
			show_404();
		}
		$this->load->library('form_validation');

		$this->load->model('request_order_model');
		
		$this->form_validation->set_message('is_unique', '%s telah digunakan.');
		//var_dump(1);exit();

	}


	public function index(){
	//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/request_order']['v']);
		if($_POST && $auth){
			//var_dump(1);exit();
			$list = $this->request_order_model->get_load_result();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $admin) {
	            $no++;
	            $row = array();
	            $row[] = $admin->ro_code;
	            $row[] = $admin->fro;
	            $row[] = $admin->too;	            
	            $row[] = date('d-m-Y',strtotime($admin->ro_date));
	            $row[] = $admin->k_name;
	            $row[] = $admin->ro_note;
	            $row[] = $admin->ro_status;	            
	            $row[] = $admin->ro_id;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->request_order_model->count_all(),
	                        "recordsFiltered" => $this->request_order_model->count_filtered(),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/request_order'];
			//var_dump($data['rules']);exit();
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS ADMINISTRATOR MENU');
			$this->template->view('view_ro', $data);
		}
	}

	public function insert(){

		$auth = $this->template->set_auth($this->menu['rule']['panel/request_order']['v']);
		if($_POST && $auth){
			if(isset($_POST['id'])==false){
				$this->form_validation->set_rules('detail', 'Data Detail', 'required');            	
			}
			if($this->session->userdata('tahun')!=date('Y',strtotime($_POST['tanggal']))){
					$this->form_validation->set_rules('t', 'Tahun', 'required');            	
				}
			$this->form_validation->set_rules('to', 'Tujuan', 'required');
            $this->form_validation->set_rules('no', 'Kode','required|is_unique[v_request_order.ro_code]');
            $this->form_validation->set_rules('tanggal', 'Tanggal Digunakan', 'required');
            $this->form_validation->set_rules('type', 'Kategori', 'required');
            $this->form_validation->set_rules('perihal', 'Perihal', 'required');
            if ($this->form_validation->run() == false){
            	$data['status'] = false;
            	$data['e']['to'] = form_error('to', '<div class="has-error">', '</div>');
            	$data['e']['no'] = form_error('no', '<div class="has-error">', '</div>');
            	$data['e']['tanggal'] = form_error('tanggal', '<div class="has-error">', '</div>');
            	$data['e']['type'] = form_error('type', '<div class="has-error">', '</div>');
            	$data['e']['perihal'] = form_error('perihal', '<div class="has-error">', '</div>');
            	if(isset($_POST['id'])==false){
					$data['e']['detail'] = form_error('detail', '<div class="has-error">', '</div>');            	
				}
				if($this->session->userdata('tahun')!=date('Y',strtotime($_POST['tanggal']))){
						$data['e']['t'] = '<div class=\"has-error\">Tahun tidak sesuai.</div>';
				}
            	echo json_encode($data);
            }else{
            	if($a=$this->request_order_model->insert()){
            		//var_dump($a);exit();
            		$this->userlog->add_log($this->session->userdata['name'], 
            		'INSERT request_order with ID = '.$a.' ro_code = '.$_POST['no']);
            		$r=$a!=''?$a:'';
					echo json_encode(array('status'=>true,'r'=>$r));
            	}
            }


			
			
		}else{
			$data['menu'] = $this->menu;
			$data['item']=$this->request_order_model->get_item();
			$data['divisi']=$this->request_order_model->get_divisi();
			$kode=$this->request_order_model->get_kode();
			$data['kategori']=$this->request_order_model->get_kategori();
			/*
			RO/2020/001
			*/

			if($kode->id==NULL){
				$data['kode']='RO/'.$this->session->userdata('tahun').'/001';
			}else{
				$data['kode']=$this->autonumber($kode->id,8,3);
			}

			
//var_dump($data);exit();
			//write user activity to logger
            $data['rules'] = $this->menu['rule']['panel/request_order'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS CAMPAIGN MENU');
			$this->template->view('view_insert_ro', $data);
		}
	}


	function refresh_kode(){
		$kode=$this->request_order_model->get_kode();
			
		if($kode->id==NULL){
				$kode='RO/'.$this->session->userdata('tahun').'/001';
			}else{
				$kode=$this->autonumber($kode->id,8,3);
			}
			echo json_encode($kode);
	}

	function autonumber($id_terakhir, $panjang_kode, $panjang_angka) {
	 
	    // mengambil nilai kode ex: KNS0015 hasil KNS
	   // $kode = substr($id_terakhir, 0, $panjang_kode);
		$kode='RO/'.$this->session->userdata('tahun').'/';
	 	
	    // mengambil nilai angka
	    // ex: KNS0015 hasilnya 0015
	    $angka = substr($id_terakhir, $panjang_kode, $panjang_angka);
	 
	    // menambahkan nilai angka dengan 1
	    // kemudian memberikan string 0 agar panjang string angka menjadi 4
	    // ex: angka baru = 6 maka ditambahkan strig 0 tiga kali
	    // sehingga menjadi 0006
	    $angka_baru = str_repeat("0", $panjang_angka - strlen($angka+1)).($angka+1);
	 
	    // menggabungkan kode dengan nilang angka baru

	    $id_baru = $kode.$angka_baru;
	 
	    return $id_baru;
	}

	public function cetak($id){
		$data['data']=$this->request_order_model->get_print($id);
		//var_dump($data['data']);exit();
		$this->load->view('cetak',$data);
	}

	function edit($id){
		$auth = $this->template->set_auth($this->menu['rule']['panel/request_order']['v']);
		if($_POST && $auth){

			$this->form_validation->set_rules('to', 'Tujuan', 'required');
            $this->form_validation->set_rules('no', 'Kode','required');
            $this->form_validation->set_rules('tanggal', 'Tanggal Digunakan', 'required');
            $this->form_validation->set_rules('type', 'Kategori', 'required');
            $this->form_validation->set_rules('perihal', 'Perihal', 'required');
            if ($this->form_validation->run() == false){
            	$data['status'] = false;
            	$data['e']['to'] = form_error('to', '<div class="has-error">', '</div>');
            	$data['e']['no'] = form_error('no', '<div class="has-error">', '</div>');
            	$data['e']['tanggal'] = form_error('tanggal', '<div class="has-error">', '</div>');
            	$data['e']['type'] = form_error('type', '<div class="has-error">', '</div>');
            	$data['e']['perihal'] = form_error('perihal', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else{
            		
            	if($a=$this->request_order_model->update()){
            		//var_dump($a);exit();
            		$this->userlog->add_log($this->session->userdata['name'], 
            		'INSERT request_order with ID = '.$a.' ro_code = '.$_POST['no']);
            		$r=$a!=''?$a:'';
					echo json_encode(array('status'=>true,'r'=>$r));
            	}
            }


			
			
		}else{
			$data['menu'] = $this->menu;
			$data['item']=$this->request_order_model->get_item();
			$data['divisi']=$this->request_order_model->get_divisi();
			$kode=$this->request_order_model->get_kode();
			$data['kategori']=$this->request_order_model->get_kategori();
			$data['ro'] = $this->request_order_model->find_by_id($id);
			/*
			RO/2020/001
			*/

			if($kode->id==NULL){
				$data['kode']='RO/'.date('Y').'/001';
			}else{
				$data['kode']=$this->autonumber($kode->id,8,3);
			}
            $data['rules'] = $this->menu['rule']['panel/request_order'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS CAMPAIGN MENU');
			$this->template->view('view_edit_ro', $data);
		}

	}

	public function detail($id){
		$data['menu'] = $this->menu;
		if($this->template->set_auth($this->menu['rule']['panel/request_order']['v'])){
			$data['ro'] = $this->request_order_model->find_by_id($id);

			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW REQUEST ORDER MENU ID: '.$id);
		}
		$this->template->view('view_detail_ro', $data);
	}

	public function delete(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/request_order']['d']);
		if($auth){
			$info = $this->request_order_model->get_name($_POST['adm_id']);
			$info = str_replace('[', '', str_replace(']', '', json_encode($info)));
			if($this->request_order_model->delete()){
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
