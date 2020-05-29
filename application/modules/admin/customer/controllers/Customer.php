<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MX_Controller {

	/**
	 * 
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'customer');
		if(!isset($this->menu['rule']['panel/customer'])){
			show_404();
		}
		$this->load->model('customer_model');
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		
	}

	public function index(){
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/customer']['v']);
		if($_POST && $auth){
			$list = $this->customer_model->get_load_result();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $customer) {
	            $no++;
	            $row = array();
	            $row[] = $customer->cus_id;
	            $row[] = $customer->cus_company;
	            $row[] = $customer->cus_name;
	            $row[] = $customer->cus_balance;
	            $row[] = $customer->cus_enabled;
	            $row[] = $customer->cus_accounttype;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->customer_model->count_all(),
	                        "recordsFiltered" => $this->customer_model->count_filtered(),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/customer'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS CUSTOMER MENU');
			$this->template->view('view_customer', $data);
		}
	}

	public function customer_insert(){
		$this->load->helper(array('form', 'url', 'countries', 'string'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/customer']['c']);
		if($_POST && $auth){
            $this->form_validation->set_rules('cus_name', 'Name', 
            				'required|min_length[3]|is_unique[v_customer.cus_name]');
            $this->form_validation->set_rules('cus_email', 'Email', 
            				'required|is_unique[v_customer.cus_email]|valid_email');
            $this->form_validation->set_rules('cus_webpassword', 'Web Password', 'required');
            if ($this->form_validation->run() == false){
            	$data['status'] = false;
            	$data['e']['cus_name'] = form_error('cus_name', '<div class="has-error">', '</div>');
            	$data['e']['cus_email'] = form_error('cus_email', '<div class="has-error">', '</div>');
            	$data['e']['cus_webpassword'] = form_error('cus_password', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else{
            	if($this->customer_model->insert()){
            		$this->userlog->add_log($this->session->userdata['name'], 
            		'INSERT CUSTOMER ID: '.$this->db->insert_id().' NAME: '.$_POST['cus_name']);
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			$data['menu'] = $this->menu;
			$data['currencies'] = $this->customer_model->get_currencies();
			$data['timezone'] = $this->customer_model->get_timezone();
			$data['callplan'] = $this->customer_model->get_callplan();
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS INSERT CUSTOMER MENU');
			$this->template->view('view_customer_insert', $data);
		}
	}

	public function customer_detail($id){
		$data['menu'] = $this->menu;
		if($this->template->set_auth($this->menu['rule']['panel/customer']['v'])){
			$data['data'] = $this->customer_model->find_by_id($id);
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW CUSTOMER ID: '.$id
				.' NAME: '.$data['data']->cus_name);
		}
		$this->template->view('view_customer_detail', $data);
	}

	public function customer_edit($id){
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/customer']['e']);
		if($_POST && $auth){

			/* if name has changed from old, then check is_unique otherwise not*/
			$check_unique = ($_POST['cus_name'] != $_POST['cus_name_old'])?'|is_unique[v_customer.cus_name]':'';
            $this->form_validation->set_rules('cus_name', 'Name', 'required|min_length[3]'.$check_unique);

            /* if email has changed from old, then check is_unique otherwise not*/
            $check_unique = ($_POST['cus_email'] != $_POST['cus_email_old'])?'|is_unique[v_customer.cus_email]':'';
            $this->form_validation->set_rules('cus_email', 'Email', 'required|valid_email'.$check_unique);

            /* unset cus_name_old and cus_email_old from $_POST to preventing from database insert*/
            $old = $_POST['cus_name_old'];
            unset($_POST['cus_name_old']);
            unset($_POST['cus_email_old']);

            if ($this->form_validation->run() == false)
            {
            	$data['status'] = false;
            	$data['e']['cus_name'] = form_error('cus_name', '<div class="has-error">', '</div>');
            	$data['e']['cus_email'] = form_error('cus_email', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else{
            	if($this->customer_model->update($id)){
            		$this->userlog->add_log($this->session->userdata['name'],
            		'EDIT CUSTOMER ID: '.$id.' NAME: '.$old.' TO '.$_POST['cus_name']);
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			$data['data'] = $this->customer_model->find_by_id($id);
			$data['currencies'] = $this->customer_model->get_currencies();
			$data['timezone'] = $this->customer_model->get_timezone();
			$data['callplan'] = $this->customer_model->get_callplan();
			$data['menu'] = $this->menu;
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS EDIT CUSTOMER ID: '.$id
				.' NAME: '.$data['data']->cus_name);
			$this->template->view('view_customer_edit', $data);
		}
	}

	public function customer_delete(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/customer']['d']);
		if($auth){
			$info = json_encode($this->customer_model->find_name($_POST['cus_id']));
			$info = str_replace('cus_','',str_replace('[', '', str_replace(']', '', $info)));
			if($this->customer_model->delete()){
				$this->userlog->add_log($this->session->userdata['name'], 
					'DELETE CUSTOMER ID '.$info);
				$data['status'] = true;
			}else{
				$data['status'] = false;
			}
			print_r(json_encode($data));
		}else{
			$this->template->view('');
		}
	}

}
