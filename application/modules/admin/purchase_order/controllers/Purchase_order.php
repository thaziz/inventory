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

class Purchase_order extends MX_Controller {

	/**
	 *
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'Telaahan');
		if(!isset($this->menu['rule']['panel/purchase_order'])){
			show_404();
		}
		$this->load->library('form_validation');

		$this->load->model('purchase_order_model');
		
		//$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		//$this->form_validation->set_message('min_length', 'The %s is exist, try another one.');
		//$this->form_validation->set_message('required', '%s harus di isi');
		//var_dump(1);exit();

	}

	public function index(){
	//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/purchase_order']['v']);
		if($_POST && $auth){
			//var_dump(1);exit();
			$list = $this->purchase_order_model->get_load_result();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $admin) {
	            $no++;
	            $row = array();
	            $row[] = $admin->po_code_a;
	            $row[] = $admin->fro;
	         /*   $row[] = $admin->too;	   */         
	            $row[] = date('d-m-Y',strtotime($admin->po_date));
	            $row[] = $admin->po_type;
	            $row[] = $admin->po_note;
	            $row[] = $admin->po_status;	 
	            $row[] = number_format($admin->po_anggaran,0,',','.');           
	            $row[] = $admin->po_id;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->purchase_order_model->count_all(),
	                        "recordsFiltered" => $this->purchase_order_model->count_filtered(),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/purchase_order'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS ADMINISTRATOR MENU');
			$this->template->view('view_index', $data);
		}
	}


	public function insert(){
		//var_dump($_POST);exit();
		$auth = $this->template->set_auth($this->menu['rule']['panel/purchase_order']['v']);
		if($_POST && $auth){
			$this->form_validation->set_rules('to', 'Tujuan', 'required');
            $this->form_validation->set_rules('no', 'Kode','required|is_unique[v_purchase_order.po_code_a]');
            $this->form_validation->set_rules('asli', 'Kode','required|is_unique[v_purchase_order.po_code]');
              $this->form_validation->set_rules('no', 'Kode','required|is_unique[v_purchase_order.po_code_a]');
            $this->form_validation->set_rules('tanggal', 'Tanggal Digunakan', 'required');
            $this->form_validation->set_rules('type', 'Kategori', 'required');
           // $this->form_validation->set_rules('perihal', 'Perihal', 'required');
            $this->form_validation->set_rules('anggaran', 'Anggaran', 'required|min_length[2]');

            if ($this->form_validation->run() == false){
            	$data['status'] = false;
            	$data['e']['to'] = form_error('to', '<div class="has-error">', '</div>');
            	$data['e']['no'] = form_error('no', '<div class="has-error">', '</div>');
            	$data['e']['no'] = form_error('asli', '<div class="has-error">', '</div>');
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
			$data['ro']=$this->purchase_order_model->get_request_order();
			/*$data['divisi']=$this->purchase_order_model->get_divisi();*/
			
//var_dump($data);exit();
			//write user activity to logger
            $data['rules'] = $this->menu['rule']['panel/purchase_order'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS CAMPAIGN MENU');
			$this->template->view('view_po', $data);
		}
	}

	public function print($id){
		$bulan = array(
                '01' => 'JANUARI',
                '02' => 'FEBRUARI',
                '03' => 'MARET',
                '04' => 'APRIL',
                '05' => 'MEI',
                '06' => 'JUNI',
                '07' => 'JULI',
                '08' => 'AGUSTUS',
                '09' => 'SEPTEMBER',
                '10' => 'OKTOBER',
                '11' => 'NOVEMBER',
                '12' => 'DESEMBER',
        );
		
		$data['po']=$this->purchase_order_model->cetak($id);
		$ttd=$data['po']['master']->po_ttd_telaahan;
		$data['ttd']=$this->purchase_order_model->ttd($ttd);
		if(empty($data['ttd'])){
			echo '<div align="center" style="color:red">Mohon untuk menyesuaikan master tanda tangan untuk menu telaahan</div>';
			exit();
		}

		$m=$bulan[date('m',strtotime($data['po']['master']->po_date))];
		$y=date('Y',strtotime($data['po']['master']->po_date));
		$d=date('d',strtotime($data['po']['master']->po_date));
		$data['po']['master']->po_date=$d.'-'.ucwords(strtolower($m)).'-'.$y;
		//var_dump($data);exit();
		$this->load->view('cetak',$data);
	}

	function refresh_kode($id=null){
		$data['ro']=$this->purchase_order_model->get_ro_all($id);
		$str=$data['ro']['master']->d_code;
		$ckode=explode("-",$str);
		$kode=$this->purchase_order_model->get_kode();
		if($kode->id==NULL){
				$data['kode']=$ckode[0].'-00001-'.$ckode[2];
				$data['asli']='00001';
			}else{
				$data['asli']=$this->autonumber($kode->id);
				$data['kode']=$ckode[0].'-'.$this->autonumber($kode->id).'-'.$ckode[2];
				//var_dump($this->autonumber($kode->id));exit();
			}
			echo json_encode($data);
		}

	function get_ro($id=null){
		$data['ro']=$this->purchase_order_model->get_ro_all($id);

		$str=$data['ro']['master']->d_code;
		$ckode=explode("-",$str);
		
		

			$kode=$this->purchase_order_model->get_kode();
		if($kode->id==NULL){
				$data['kode']=$ckode[0].'-00001-'.$ckode[2];
				$data['asli']='00001';
			}else{
				$data['asli']=$this->autonumber($kode->id);
				$data['kode']=$ckode[0].'-'.$this->autonumber($kode->id).'-'.$ckode[2];
				//var_dump($this->autonumber($kode->id));exit();
			}
		if($data['ro']["master"]== NULL ){
			echo "<span></span>";
			exit();
		}
		$this->load->view('view_ro_detail', $data);
	}


	function autonumber($angka) {
	 
	    // mengambil nilai kode ex: KNS0015 hasil KNS
	   // $kode = substr($id_terakhir, 0, $panjang_kode);
		/*$angka=2;*/
	 	
	    // mengambil nilai angka
	    // ex: KNS0015 hasilnya 0015
	   // $angka = '00001';
	    $panjang_angka=5;
	 	
	    // menambahkan nilai angka dengan 1
	    // kemudian memberikan string 0 agar panjang string angka menjadi 4
	    // ex: angka baru = 6 maka ditambahkan strig 0 tiga kali
	    // sehingga menjadi 0006
	    $angka_baru = str_repeat("0", $panjang_angka - strlen($angka+1)).($angka+1);
	 
	    // menggabungkan kode dengan nilang angka baru

	    $id_baru = $angka_baru;
	 
	    return $id_baru;
	}


	function edit($id){
		$auth = $this->template->set_auth($this->menu['rule']['panel/purchase_order']['v']);
		if($_POST && $auth){
			//$this->form_validation->set_rules('to', 'Tujuan', 'required');
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
            	echo json_encode($data);
            }else{
            	if($a=$this->purchase_order_model->update()){
            		//var_dump($a);exit();
            		$this->userlog->add_log($this->session->userdata['name'], 
            		'INSERT request_order with ID = '.$a.' ro_code = '.$_POST['no']);
            		$r=$a!=''?$a:'';
					echo json_encode(array('status'=>true,'r'=>$r));
            	}
            }


			
			
		}else{
			$data['menu'] = $this->menu;
			$kode=$this->purchase_order_model->get_kode();
			
			$data['po'] = $this->purchase_order_model->find_by_id_edit($id);
		

		  $data['rules'] = $this->menu['rule']['panel/purchase_order'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS CAMPAIGN MENU');
			$this->template->view('view_edit', $data);
		}

	}


	public function delete(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/purchase_order']['d']);
		if($auth){
			$info = $this->purchase_order_model->get_name($_POST['adm_id']);
			$info = str_replace('[', '', str_replace(']', '', json_encode($info)));
			if($this->purchase_order_model->delete()){
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






	public function purchase(){
		//var_dump(1);exit();
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/purchase_order']['v']);
		if($_POST && $auth){
			$list = $this->campaign_model->get_load_result($this->menu['rule']['panel/purchase_order']);
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $campaign) {
	            $no++;
	            $row = array();
	            $row[] = $campaign->campaign_id;
	            $row[] = $no;
	            $row[] = $campaign->campaign_name;
	            $row[] = $campaign->date_range;
	            $row[] = $campaign->adm_name;
	            $data[] = $row;
	        }

	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->campaign_model->count_all($this->menu['rule']['panel/campaign']),
	                        "recordsFiltered" => $this->campaign_model->count_filtered($this->menu['rule']['panel/campaign']),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			//write user activity to logger
            $data['rules'] = $this->menu['rule']['panel/purchase_order'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS CAMPAIGN MENU');
			$this->template->view('view_purchase_order', $data);
		}
	}



	public function purchase_next(){
		//var_dump(1);exit();
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/purchase_order']['v']);
		if($_POST && $auth){
			$list = $this->campaign_model->get_load_result($this->menu['rule']['panel/purchase_order']);
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $campaign) {
	            $no++;
	            $row = array();
	            $row[] = $campaign->campaign_id;
	            $row[] = $no;
	            $row[] = $campaign->campaign_name;
	            $row[] = $campaign->date_range;
	            $row[] = $campaign->adm_name;
	            $data[] = $row;
	        }

	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->campaign_model->count_all($this->menu['rule']['panel/campaign']),
	                        "recordsFiltered" => $this->campaign_model->count_filtered($this->menu['rule']['panel/campaign']),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			//write user activity to logger
            $data['rules'] = $this->menu['rule']['panel/purchase_order'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS CAMPAIGN MENU');
			$this->template->view('view_purchase_order_next', $data);
		}
	}

		public function detail($id){
		$data['menu'] = $this->menu;
		if($this->template->set_auth($this->menu['rule']['panel/request_order']['v'])){
			$data['po'] = $this->purchase_order_model->find_by_id($id);
			//var_dump($data['po']);exit();

			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW REQUEST ORDER MENU ID: '.$id);
		}
		$this->template->view('view_detail', $data);
	}


}
