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

class Nota extends MX_Controller {

	/**
	 *
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'Input Nota');
		if(!isset($this->menu['rule']['panel/nota'])){
			show_404();
		}
		$this->load->library('form_validation');

		$this->load->model('nota_model');
		
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		//var_dump(1);exit();

	}

	

	public function index(){
	//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/nota']['v']);
		if($_POST && $auth){
			//var_dump(1);exit();
			$list = $this->nota_model->get_load_result();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $admin) {
	            $no++;
	            $row = array();
	            $row[] = $admin->po_code_a;
	            $row[] = $admin->fro;
	            $row[] = date('d-m-Y',strtotime($admin->po_date));
	            $row[] = $admin->po_type;
	            $row[] = $admin->po_note;            
	            $row[] = number_format($admin->po_anggaran,0,',','.');  
	            $row[] = number_format($admin->total_nota,0,',','.');   
	            $row[] = $admin->po_status;
	            $row[] = $admin->po_id;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->nota_model->count_all(),
	                        "recordsFiltered" => $this->nota_model->count_filtered(),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/bendahara'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS BENDAHARA MENU INDEX');
			$this->template->view('view_index.php', $data);
		}
	}
	public function print(){
		$this->load->view('cetak');
	}



	public function insert(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/nota']['v']);
		if($_POST && $auth){
			
            if(!isset($_POST['id'])){
            	$data['status'] = false;
            	$data['gagal'] = 'Detail belum di isi';

		    	echo json_encode($data);
            }else{

		    	if($a=$this->nota_model->insert()){
            		
            		$this->userlog->add_log($this->session->userdata['name'], 
            		'INSERT purchase_order with ID = '.$a.' ro_code = '.$_POST['no']);
            		$r=$a!=''?$a:'';
					echo json_encode(array('status'=>true,'r'=>$r));
            	}
            }

		}else{
			$data['menu'] = $this->menu;
			$data['po']=$this->nota_model->get_request_nota();
			//write user activity to logger
            $data['rules'] = $this->menu['rule']['panel/nota'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS CAMPAIGN MENU');
			$this->template->view('view_insert', $data);
		}
	}



	public function insert_detail($id=null){
		


		$data['po']=$this->nota_model->search_po_telaahan($id);
		if($data['po']["master"]== NULL ){
			echo "<span></span>";
			exit();
		}
		$this->load->view('view_insert_detail', $data);
	
	}


	public function detail($id){
		$data['menu'] = $this->menu;
		if($this->template->set_auth($this->menu['rule']['panel/bendahara']['v'])){
			$data['po'] = $this->nota_model->detail($id);
			//var_dump($data['po']);exit();

			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW Detail Nota MENU ID: '.$id);
		}
		$this->template->view('view_detail', $data);
	}


	public function edit($id){
		$data['menu'] = $this->menu;
		if($this->template->set_auth($this->menu['rule']['panel/bendahara']['v'])){
			$data['po'] = $this->nota_model->detail($id);
			//var_dump($data['po']);exit();

			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW Detail Nota MENU ID: '.$id);
		}
		$this->template->view('view_nota_edit', $data);
	}





	public function update($id){
		//var_dump($_POST);exit();
		$auth = $this->template->set_auth($this->menu['rule']['panel/nota']['v']);
		if($_POST && $auth){
			
            if(!isset($_POST['id'])){
            	$data['status'] = false;
            	$data['gagal'] = 'Detail belum di isi';
            	echo json_encode($data);
            }else{
            	if($a=$this->nota_model->insert()){
            		
            		$this->userlog->add_log($this->session->userdata['name'], 
            		'INSERT nota update with ID = '.$a.' ro_code = '.$_POST['no']);
            		$r=$a!=''?$a:'';
					echo json_encode(array('status'=>true,'r'=>$r));
            	}
            }

		}
	}



}
