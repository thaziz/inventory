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

class Anggaran extends MX_Controller {

	/**
	 *
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'Keuangan');
		if(!isset($this->menu['rule']['panel/anggaran'])){
			show_404();
		}
		$this->load->library('form_validation');

		$this->load->model('anggaran_model');
		
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		//var_dump(1);exit();

	}

	public function index(){
	//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/anggaran']['v']);
		if($_POST && $auth){
			//var_dump(1);exit();
			$list = $this->anggaran_model->get_load_result();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $admin) {
	        	//var_dump($list);exit();
	            $no++;
	            $row = array();
	            $row[] = $admin->po_code_a;
	            $row[] = $admin->fro;
	            $row[] = date('d-m-Y',strtotime($admin->po_date));
	            $row[] = $admin->po_type;
	            $row[] = $admin->po_note;
	            $row[] = $admin->a_code==''?'':$admin->a_code.' - '.strtoupper($admin->a_name);	            
	            $row[] = number_format($admin->po_anggaran,0,',','.');   
	            $row[] = $admin->po_status;
	            $row[] = $admin->po_id;
	            $row[] = $admin->po_kode_anggaran;
	            
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->anggaran_model->count_all(),
	                        "recordsFiltered" => $this->anggaran_model->count_filtered(),
	                        "data" => $data,
	                );
	      //  var_dump($output);exit();
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/anggaran'];
		//	var_dump($data['rules']);exit();
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS ADMINISTRATOR MENU');
			$this->template->view('view_index_anggaran.php', $data);
		}
	}
	function insert_new(){
		
	//var_dump($_POST);exit();
		$auth = $this->template->set_auth($this->menu['rule']['panel/anggaran']['v']);
		if($_POST && $auth){
			$this->form_validation->set_rules('to', 'Tujuan', 'required');
            $this->form_validation->set_rules('no', 'Kode','required|is_unique[v_purchase_order.po_code_a]');
            $this->form_validation->set_rules('tanggal', 'Tanggal Digunakan', 'required');
            $this->form_validation->set_rules('type', 'Kategori', 'required');
           // $this->form_validation->set_rules('perihal', 'Perihal', 'required');
            $this->form_validation->set_rules('anggaran', 'Anggaran', 'required|min_length[2]');

            if ($this->form_validation->run() == false){
            	$data['status'] = false;
            	$data['e']['to'] = form_error('to', '<div class="has-error">', '</div>');
            	$data['e']['no'] = form_error('no', '<div class="has-error">', '</div>');
            	$data['e']['tanggal'] = form_error('tanggal', '<div class="has-error">', '</div>');
            	$data['e']['type'] = form_error('type', '<div class="has-error">', '</div>');
            	//$data['e']['perihal'] = form_error('perihal', '<div class="has-error">', '</div>');
            	$data['e']['anggaran'] = form_error('anggaran', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else if(!isset($_POST['id'])){
            	$data['status'] = false;
            	$data['gagal'] = 'Detail belum di isi';
            	echo json_encode($data);
            }else{
            //var_dump($_POST);exit();
            	
            	if($a=$this->purchase_order_model->insert()){
            		//var_dump($a);exit();
            		$this->userlog->add_log($this->session->userdata['name'], 
            		'INSERT purchase_order with ID = '.$a.' ro_code = '.$_POST['no']);
            		$r=$a!=''?$a:'';
					echo json_encode(array('status'=>true,'r'=>$r));
            	}
            }




		}else{
			$data['menu'] = $this->menu;
			$data['po']=$this->anggaran_model->get_request_order();

			//write user activity to logger
            $data['rules'] = $this->menu['rule']['panel/anggaran'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS CAMPAIGN MENU');
		    $this->template->view('view_new', $data);
		
		}

	}


	function insert($id){
		
		$auth = $this->template->set_auth($this->menu['rule']['panel/anggaran']['v']);
		if($_POST && $auth){

        $anggaran= (int)str_replace(".", '', $_POST['anggaran']);
        $jml_anggaran=(int)str_replace(".", '', $_POST['jml_anggaran']);

			if($anggaran>$jml_anggaran){
				$data['status'] = false;
            	$data['e'] = 'Jumlah anggaran tidak mencukupi';
            	echo json_encode($data);
            	exit();
            	
	
			}

				if($a=$this->anggaran_model->insert()){
            		if($a=="tidak ada ttd"){

					echo json_encode(array('status'=>false,'e'=>'Gagal, Master TTD belum aktif'));
					exit();
            		}
            		$this->userlog->add_log($this->session->userdata['name'], 
            		'INSERT purchase_order with ID = '.$a);
            		$r=$a!=''?$a:'';
					echo json_encode(array('status'=>true,'r'=>$r));
            	}
		}else{
			$data['menu'] = $this->menu;
			$data['po']=$this->anggaran_model->get_po_all($id);

	
			$data['account']=$this->anggaran_model->get_account();
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/anggaran'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS ADMINISTRATOR MENU');
			$this->template->view('view_anggaran_insert', $data);
		}


	}





	function get_po($id=null){
		$data['po']=$this->anggaran_model->search_po_telaahan($id);
		$tgl=date('Y',strtotime($data['po']['master']->po_date));
		$data['account']=$this->anggaran_model->get_account($tgl);
		
		
		if($data['po']["master"]== NULL ){
			echo "<span></span>";
			exit();
		}
		$this->load->view('view_po_insert', $data);
	}

	public function print(){
		$this->load->view('cetak');
	}



	function get_ro($id){
		$data['ro']=$this->anggaran_model->get_ro_all($id);

			$kode=$this->anggaran_model->get_kode();
		if($kode->id==NULL){
				$data['kode']='PO/'.date('Y').'/001';
			}else{
				$data['kode']=$this->autonumber($kode->id,8,3);
			}
		$this->load->view('view_ro_detail', $data);
	}


	function autonumber($id_terakhir, $panjang_kode, $panjang_angka) {
	 
	    // mengambil nilai kode ex: KNS0015 hasil KNS
	   // $kode = substr($id_terakhir, 0, $panjang_kode);
		$kode='PO/'.date('Y').'/';
	 	
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

	function edit($id){
		


		$auth = $this->template->set_auth($this->menu['rule']['panel/anggaran']['v']);
		if($_POST && $auth){
		}else{
			$data['menu'] = $this->menu;
			$data['po']=$this->anggaran_model->get_po_all($id);

		$kode=$this->anggaran_model->get_kode();
		if($kode->id==NULL){
				$data['kode']='PO/'.date('Y').'/001';
			}else{
				$data['kode']=$this->autonumber($kode->id,8,3);
			}
			$data['account']=$this->anggaran_model->get_account();
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/anggaran'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS ADMINISTRATOR MENU');
			$this->template->view('view_anggaran_insert', $data);
		}


	}

//ambil saldo
	public function get_saldo(){
		$saldo=$this->anggaran_model->get_saldo();
		echo json_encode($saldo);
	}

	public function detail($id){
		$data['menu'] = $this->menu;
		if($this->template->set_auth($this->menu['rule']['panel/anggaran']['v'])){
			$data['po'] = $this->anggaran_model->detail($id);
			//var_dump($data['po']);exit();

			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW REQUEST ORDER MENU ID: '.$id);
		}
		$this->template->view('view_detail', $data);
	}




}
