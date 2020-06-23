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

class Master extends MX_Controller {

	/**
	 *
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'Master');
		if(!isset($this->menu['rule']['panel/master'])){
			show_404();
		}
		$this->load->model('item_model');
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		//var_dump(1);exit();

	}

	public function index(){
	//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/master']['v']);
		if($_POST && $auth){
			//var_dump(1);exit();
			$list = $this->item_model->get_load_result();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $admin) {
	            $no++;
	            $row = array();
	            $row[] = $admin->i_code;
	            $row[] = $admin->i_name;
	            $row[] = $admin->i_unit;	            
	            $row[] = $admin->i_id;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->item_model->count_all(),
	                        "recordsFiltered" => $this->item_model->count_filtered(),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/master'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS ADMINISTRATOR MENU');
			$this->template->view('view_item', $data);
		}
	}



	public function insert(){

		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/master']['c']);
		if($_POST && $auth){			
            $this->form_validation->set_rules('i_name', 'Kode','required');
            $this->form_validation->set_rules('i_code', 'Kode', 
            				'required|min_length[3]|is_unique[v_item.i_code]');
            $this->form_validation->set_rules('i_unit', 'Satuan', 'required');
            if ($this->form_validation->run() == false){
            	$data['status'] = false;            	
            	$data['e']['i_name'] = form_error('i_name', '<div class="has-error">', '</div>');
            	$data['e']['i_code'] = form_error('i_code', '<div class="has-error">', '</div>');
            	$data['e']['i_unit'] = form_error('i_unit', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else{
            	if($this->item_model->insert()){
            		$this->userlog->add_log($this->session->userdata['name'], 
            		'INSERT v_item with i_id = '.$this->db->insert_id()
            		.' i_code = '.$_POST['i_code']);
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{

			$data['account'] = $this->item_model->get_account();	
			$data['satuan'] = $this->item_model->get_satuan();			
			//var_dump($data['account']);exit();
			$data['menu'] = $this->menu;
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS INSERT USER MENU');
			$this->template->view('view_item_insert', $data);
		}
	}


	

	public function delete(){
	//	var_dump($_POST);exit();
		$auth = $this->template->set_auth($this->menu['rule']['panel/master']['d']);
		if($auth){
			$info = $this->item_model->get_name($_POST['adm_id']);
			$info = str_replace('[', '', str_replace(']', '', json_encode($info)));
			if($this->item_model->delete()){
				$this->userlog->add_log($this->session->userdata['name'], 'DELETE ITEM '.$info);
				$data['status'] = true;
			}else{
				$data['status'] = false;
			}
			echo json_encode($data);
		}else{
			$this->template->view('');
		}
	}

	public function edit($id){
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/master']['e']);
		if($_POST && $auth){

			/* if name has changed from old, then check is_unique otherwise not*/
			$check_unique = ($_POST['i_code_old'] != $_POST['i_code'])?'|is_unique[v_item.i_code]':'';
			$check_unique2 = ($_POST['i_name_old'] != $_POST['i_name'])?'|is_unique[v_item.i_name]':'';
            $this->form_validation->set_rules('i_code', 'Name', 'required|min_length[2]'.$check_unique);

            $this->form_validation->set_rules('i_name', 'Name', 'required|min_length[2]'.$check_unique2);

            /* if email has changed from old, then check is_unique otherwise not*/
           
           
            $old_name = $_POST['i_name_old'];
            /* unset adm_name_old and adm_email_old from $_POST to preventing from database insert*/
            unset($_POST['i_name_old']);
            unset($_POST['i_code_old']);
            

            if ($this->form_validation->run() == false)
            {
            	$data['status'] = false;
            	$data['e']['i_name'] = form_error('i_name', '<div class="has-error">', '</div>');
            	$data['e']['i_code'] = form_error('i_code', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else{
            	if($this->item_model->update($id)){
            		$this->userlog->add_log($this->session->userdata['name'],
            		'EDIT ADMIN ID: '.$id.' NAME: '.$old_name.' WITH NEW VALUE '
            		.http_build_query($_POST,'',', '));
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			$data['data'] = $this->item_model->find_by_id($id);
			$data['satuan'] = $this->item_model->get_satuan();	
			$data['menu'] = $this->menu;
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS EDIT ADMIN ID: '.$id.' NAME: '.$data['data']->i_name);
			$this->template->view('view_item_edit', $data);
		}
	}


}
