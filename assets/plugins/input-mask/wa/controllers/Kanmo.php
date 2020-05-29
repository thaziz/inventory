<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kanmo extends MX_Controller {

	/**
	 * 
	 */

	public function __construct(){
		$this->load->model('kanmo_model');
	}

	public function index(){
		echo md5('annas');
	}

	public function testid(){
		$ext=20223;
		echo $this->kanmo_model->generate_ticket_id($ext);
	}

	public function form_ticket($auth){
		if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
			if($_GET){
				$data = array();
				if(isset($_GET['phone'])){
					$phone = preg_replace('/^0/', '62', $_GET['phone']);
				}else{
					$phone = '';
				}
				$data['agent'] = preg_replace('/[^0-9]/', '','SIP/'.$_GET['agent']);
				$data['ticket_id'] = $this->kanmo_model->generate_ticket_id($data['agent']);
				$data['call_id'] = isset($_GET['call_id'])?$_GET['call_id']:0;
				if(isset($_GET['phone'])){
					$customer = $this->get_data($phone);
				}
				$data['wa'] = isset($_GET['wa'])?$_GET['wa']:0;
				$customer_field = array(
					'address_one_home_one'=>'',
					'anniversary_date'=>'',
					'birthday'=>'',
					'city_one'=>'',
					'country_origin'=>'',
					'dob_mom'=>'',
					'first_sale_date'=>'',
					'gender'=>'',
					'last_modified_date'=>'',
					'last_sale_amount'=>'',
					'last_sale_date'=>'',
					'last_twelve_mon_sale'=>'',
					'membership'=>'',
					'membership_expiry'=>'',
					'mobile_two'=>'',
					'points_balance'=>'',
					'province_one'=>'',
					'store_name'=>'',
					'subsidiary'=>'',
					'title'=>'',
					'zip_code'=>''
				);
				$extend_field = array(
					'gender'=>''
				);

				if(isset($customer['custom_fields'])){
					foreach ($customer['custom_fields']['field'] as $value) {
						$customer_field[$value['name']] = $value['value'];
					}
					foreach ($customer['extended_fields']['field'] as $value) {
						$extend_field[$value['name']] = $value['value'];
					}
					if(isset($_GET['phone'])){
						$cus = $this->kanmo_model->check_caller($phone, $customer, $customer_field, $extend_field);
					}
					if($cus!=false){
						$data['data'] = $cus;
					}
				}

				$data['phone'] = $phone;
				$data['fname'] = isset($customer['firstname'])?$customer['firstname']:'';
				$data['lname'] = isset($customer['lastname'])?$customer['lastname']:'';
				$data['external_id'] = isset($customer['external_id'])?$customer['external_id']:'';
				$data['address'] = isset($_GET['phone'])?$customer_field['address_one_home_one'].' '.$customer_field['city_one'].' '.$customer_field['zip_code'].' '.$customer_field['province_one'].' '.$customer_field['country_origin']:'';
				$data['current_slab'] = isset($customer['current_slab'])?$customer['current_slab']:'';
				$data['loyalty_points'] = isset($customer['loyalty_points'])?$customer['loyalty_points']:'';
				$data['registered_on'] = isset($customer['registered_on'])?$customer['registered_on']:'';
				$data['registered_store'] = isset($customer['registered_store'])?$customer['registered_store']['name']:'';
				$data['fraud_status'] = isset($customer['fraud_details'])?$customer['fraud_details']['status']:'';
				$data['email'] = isset($customer['email'])?$customer['email']:'';
				$data['fields'] = $customer_field;
				$data['extend'] = $customer_field;
				$data['auth'] = $auth;
				$data['brand'] = $this->kanmo_model->brand();
				$data['assign_list'] = $this->kanmo_model->assignment_list();
				$data['main_category'] = $this->kanmo_model->main_category();
				$data['subsidiary'] = $this->kanmo_model->get_subsidiary();
				$data['province'] = $this->kanmo_model->get_province();
				//$data['category'] = $this->kanmo_model->category();
				//$data['departments'] = $this->kanmo_model->depart_list();
				$this->load->view(
					'forms/kanmo', $data);
			}else{
				echo 'Invalid URL';
			}
		}else{
			echo 'Authentication failed';
		}
	}
	public function get_category(){
		if($_POST){
			$cat = $this->kanmo_model->category($_POST['id']);
			echo json_encode($cat);
		}
	}
	public function get_meta_category(){
		if($_POST){
			$cat = $this->kanmo_model->meta_category($_POST['id']);
			echo json_encode($cat);
		}
	}
	public function get_subcategory(){
		if($_POST){
			$cat = $this->kanmo_model->subcategory($_POST['id']);
			echo json_encode($cat);
		}
	}
	public function show_subcat_info(){
		if($_POST){
			$html = array();
			if(!empty($_POST['subcat'])){
				$cat = $this->kanmo_model->subcategory_info($_POST['subcat']);
				foreach ($cat as $key => $value) {
					$html[] = '<tr><td>'.implode('</td><td>',array_values($value)).'</td></tr>';
				}
			}
			if(count($html)>0){
				echo implode("\n", $html);
			}else{
				echo '<tr><td colspan="4" align="center"><i>Sub Category not found</i></td></tr>';
			}
		}
	}
	public function save_ticket($auth){
		if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
			if($_POST){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('cus_fname', 'First Name', 'required');
	            $this->form_validation->set_rules('cus_phone', 'Phone', 'required');
	            $this->form_validation->set_rules('subject', 'Subject', 'required');
	            $this->form_validation->set_rules('content', 'Ticket Content', 'required');
	            $this->form_validation->set_rules('status', 'Status', 'required');
	            $this->form_validation->set_rules('source', 'Source', 'required');
	            $this->form_validation->set_rules('brand', 'Brand', 'required');
	            $this->form_validation->set_rules('main_category', 'Call Type', 'required');
	            $this->form_validation->set_rules('meta_category', 'Meta Category', 'required');
	            $this->form_validation->set_rules('category', 'Category', 'required');
	            $this->form_validation->set_rules('sub_category', 'Sub Category', 'required');
	            if($_POST['status']=='OPEN'){
	            	$this->form_validation->set_rules('email_assign', 'Assign to', 'required');
	            }
            	if ($this->form_validation->run() == false){
            		$data['status'] = false;
            		$data['code'] = 200;
            		$data['e']['cus_fname'] = form_error('cus_fname', '<div class="has-error">', '</div>');
            		$data['e']['cus_phone'] = form_error('cus_phone', '<div class="has-error">', '</div>');
            		$data['e']['subject'] = form_error('subject', '<div class="has-error">', '</div>');
            		$data['e']['content'] = form_error('content', '<div class="has-error">', '</div>');
            		$data['e']['status'] = form_error('status', '<div class="has-error">', '</div>');
            		$data['e']['source'] = form_error('source', '<div class="has-error">', '</div>');
            		$data['e']['brand'] = form_error('brand', '<div class="has-error">', '</div>');
            		$data['e']['main_category'] = form_error('main_category', '<div class="has-error">', '</div>');
            		$data['e']['meta_category'] = form_error('meta_category', '<div class="has-error">', '</div>');
            		$data['e']['category'] = form_error('category', '<div class="has-error">', '</div>');
            		$data['e']['sub_category'] = form_error('sub_category', '<div class="has-error">', '</div>');
            		if($_POST['status']=='OPEN'){
            			$data['e']['email_assign'] = form_error('email_assign', '<div class="has-error">', '</div>');
            		}
            		echo json_encode($data);
            	}else{
            		if($this->kanmo_model->save_ticket()){
            			echo json_encode(array('status'=>true));
            		}else{
            			echo json_encode(array('status'=>false, 'code'=>500));
            		}
            	}
			}else{
				echo 'Invalid Action';
			}
		}else{
			echo 'Authentication failed';
		}
	}

	private function get_token(){
		$date = date('Y-m-d H:i:s');
		if($this->session->has_userdata('token')){
			if(strtotime($date)>$this->session->userdata('token_expired')){
				$this->session->unset_userdata('token');
				$this->session->unset_userdata('token_expired');
				$this->get_token();
			}else{
				//echo 'get token';
				return true;
			}
		}else{
			//echo 'access url token';
			$this->load->helper('apicurl');
			$result = get_token('https://119.2.42.174/boostapi/token', array('username'=>'callcenter', 'password'=>'zv5gDRmbi&Kal@WU', 'grant_type'=>'password'));
			if($result!=false){
				$this->session->set_userdata('token', $result['token_type'].' '.$result['access_token']);
				$this->session->set_userdata('token_expired', strtotime($date.' + '.$result['expires_in'].' seconds'));
				return true;
			}else{
				return false;
			}
		}
	}

	private function get_data($phone){
		$this->load->helper('apicurl');
		$this->get_token();
		$result = $this->session->userdata('token');
		if($result){
			$data = get_data_api('https://119.2.42.174/boostapi/api/CRMCap/V1/GetCallCenterCustomerDataByMobile','GET', array('custMobile'=>$phone,'formatData'=>'json'), array('Authorization:'.$result, 'Content-Type:application/json'));
			
			$data = json_decode($data, true);

			$customer = array();
			if(isset($data['response'])){
				if($data['response']['status']['success']=='true' && $data['response']['status']['code']=='200'){
					$customer = $data['response']['customers']['customer'][0];
				}
				//echo json_encode($customer);exit;
				return $customer;
			}else{
				$this->session->unset_userdata('token');
				$this->session->unset_userdata('token_expired');
				return $this->get_data($phone);
			}
		}else{
			return false;
		}
	}

	private function get_cust_from_email($email){
		$this->load->helper('apicurl');
		$this->get_token();
		$result = $this->session->userdata('token');
		if($result){
			$data = get_data_api('https://119.2.42.174/boostapi/api/CRMCap/V1/GetCallCenterCustomerDataByEmail','GET', array('custEmail'=>$email,'formatData'=>'json'), array('Authorization:'.$result, 'Content-Type:application/json'));
			
			$data = json_decode($data, true);

			$customer = array();
			if(isset($data['response'])){
				if($data['response']['status']['success']=='true' && $data['response']['status']['code']=='200'){
					$customer = $data['response']['customers']['customer'][0];
				}
				//echo json_encode($customer);exit;
				return $customer;
			}else{
				$this->session->unset_userdata('token');
				$this->session->unset_userdata('token_expired');
				return $this->get_data($phone);
			}
		}else{
			return false;
		}
	}

	private function get_transaction($phone, $startdate, $enddate){
		$this->load->helper('apicurl');
		$this->get_token();
		$result = $this->session->userdata('token');
		if($result){
			$data = get_data_api('https://119.2.42.174/boostapi/api/CRMCap/V1/GetCallCenterCustomerDataTransactions','GET', array('custMobile'=>$phone,'startDate'=>$startdate,'endDate'=>$enddate,'formatData'=>'json'), array('Authorization:'.$result, 'Content-Type:application/json'));
			
			$data = json_decode($data, true);

			$transaction = array();
			if(isset($data['response'])){
				if($data['response']['status']['success']=='true' && $data['response']['status']['code']=='200'){
					$transaction = $data['response']['customer']['transactions'];
				}
				//echo json_encode($customer);exit;
				return $transaction;
			}else{
				$this->session->unset_userdata('token');
				$this->session->unset_userdata('token_expired');
				return $this->get_data($phone);
			}
		}else{
			return false;
		}
	}

	public function check_data($phone){
		$this->load->helper('apicurl');
		$this->get_token();
		$result = $this->session->userdata('token');
		if($result){
			$data = get_data_api('https://119.2.42.174/boostapi/api/CRMCap/V1/GetCallCenterCustomerDataByMobile','GET', array('custMobile'=>$phone,'formatData'=>'json'), array('Authorization:'.$result, 'Content-Type:application/json'));
			echo $data;
		}
	}

	public function get_trans($auth, $startdate = '2018-01-01+00:00:00', $enddate = '2019-01-05+23:59:59'){
		if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
			if($_POST){
				$this->load->helper('apicurl');
				$this->get_token();
				$result = $this->session->userdata('token');
				if($result){
					if(!empty($_POST['periode'])){
						$date = explode(' - ', $_POST['periode']);
						$startdate = date('Y-m-d+00:00:00', strtotime($date[0]));
						$enddate = date('Y-m-d+23:59:59', strtotime($date[1]));
					}/*else{
						$startdate = date('Y-m-d+00:00:00', strtotime(date('Y-m-d'). ' -1 months'));
						$enddate = date('Y-m-d+23:59:59');
						$_POST['periode'] = date('Y-m-d', strtotime(date('Y-m-d'). ' -1 months')).' - '.date('Y-m-d');
					}*/
					//$data = get_data_api('https://119.2.42.174/boostapi/api/CRMCap/V1/GetCallCenterCustomerDataByMobile','GET', array('custMobile'=>$phone,'formatData'=>'json'), array('Authorization:'.$result, 'Content-Type:application/json'));
					$_data = $this->get_transaction($_POST['phone'], $startdate, $enddate);
					$datadb = array();
					if(isset($_data['transaction'])){
						foreach ($_data['transaction'] as $key => $v) {
							$items = array();
							if(isset($v['line_items']['line_item'])){
								foreach ($v['line_items']['line_item'] as $item) {
									$items[] = array('item_code'=>$item['item_code'],'type'=>$item['type'],'return_type'=>$item['return_type'],'outlier_status'=>$item['outlier_status'], 'serial'=>$item['serial'],'description'=>$item['description'],'qty'=>$item['qty'],'rate'=>$item['rate'],'value'=>$item['value'],'discount'=>$item['discount'],'amount'=>$item['amount']);
								}
							}
							$datadb[$v['id']] = array('transaction_id'=>$v['id'], 'trans_number'=>$v['number'], 'type'=>$v['type'], 'amount'=>$v['amount'], 'gross_amount'=>$v['gross_amount'], 'discount'=>$v['discount'], 'delivery_status'=>$v['delivery_status'], 'billing_time'=>$v['billing_time'], 'store'=>$v['store'], 'store_code'=>$v['store_code'], 'items'=>$items);
						}
						$this->kanmo_model->save_transaction($_POST['phone'], $datadb);
					}
					/*$data = array();
					$i = 1;
					foreach ($_data['transaction'] as $key => $v) {
						$data['data'][] = array($i, $v['id'], $v['type'], $v['amount'], $v['delivery_status'], $v['billing_time'], $v['store']);
						$i++;
					}*/
					$list = $this->kanmo_model->get_load_trans();
			        $data = array();
			        $no = $_POST['start'];
			        foreach ($list as $trans) {
			            $no++;
			            $row = array();
			            $row[] = $no;
			            $row[] = $trans->transaction_id;
			            $row[] = $trans->type;
			            $row[] = $trans->amount;
			            $row[] = $trans->delivery_status;
			            $row[] = date('d F Y H:i:s', strtotime($trans->billing_time));
			            $row[] = $trans->store;
			            $data[] = $row;
			        }
			 
			        $output = array(
			                        "draw" => $_POST['draw'],
			                        "recordsTotal" => $this->kanmo_model->count_trans_all(),
			                        "recordsFiltered" => $this->kanmo_model->count_trans_filtered(),
			                        "data" => $data,
			                );
			        echo json_encode($output);
				}else{
					echo 'error';
				}
			}else{
				echo 'invalid request';
			}
		}else{
			echo 'Invalid auth';
		}
	}

	public function get_ticket($auth){
		if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
			if($_POST){
				$list = $this->kanmo_model->get_load_ticket();
		        $data = array();
		        $no = $_POST['start'];
		        foreach ($list as $ticket) {
		            $no++;
		            $row = array();
		            $row[] = $ticket->id;
		            $row[] = $no;
		            $row[] = $ticket->ticket_id;
		            $row[] = $ticket->category;
		            $row[] = $ticket->subject;
		            $row[] = $ticket->open_date;
		            //$row[] = $ticket->store_name;
		            $row[] = $ticket->status;
		            $data[] = $row;
		        }
		 
		        $output = array(
		                        "draw" => $_POST['draw'],
		                        "recordsTotal" => $this->kanmo_model->count_ticket_all(),
		                        "recordsFiltered" => $this->kanmo_model->count_ticket_filtered(),
		                        "data" => $data,
		                );
		        echo json_encode($output);
			}else{
				echo 'invalid request';
			}
		}else{
			echo 'Invalid auth';
		}
	}

	public function ticket_detail($auth){
		if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
			$ticket = $this->kanmo_model->get_ticket_detail($_POST['id']);
			echo json_encode($ticket);
		}else{
			echo 'Invalid auth';
		}
	}

	public function get_trans_detail($auth){
		if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
			if($_POST){
				$list = $this->kanmo_model->get_load_items();
		        $data = array();
		        $no = $_POST['start'];
		        foreach ($list as $trans) {
		            $no++;
		            $row = array();
		            $row[] = $no;
		            $row[] = $trans->item_code;
		            $row[] = $trans->type;
		            $row[] = $trans->description;
		            $row[] = $trans->qty;
		            $row[] = $trans->rate;
		            $row[] = $trans->discount;
		            $row[] = $trans->amount;
		            $row[] = $trans->value;
		            $data[] = $row;
		        }
		 
		        $output = array(
		                        "draw" => $_POST['draw'],
		                        "recordsTotal" => $this->kanmo_model->count_items_all(),
		                        "recordsFiltered" => $this->kanmo_model->count_items_filtered(),
		                        "data" => $data,
		                );
		        echo json_encode($output);
			}
		}
	}


	private function search($phone){
		$phone = preg_replace('/^0/', '62', $phone);
		$customer = $this->get_data($phone);
		$customer_field = array(
			'address_one_home_one'=>'',
			'anniversary_date'=>'',
			'birthday'=>'',
			'city_one'=>'',
			'country_origin'=>'',
			'dob_mom'=>'',
			'first_sale_date'=>'',
			'gender'=>'',
			'last_modified_date'=>'',
			'last_sale_amount'=>'',
			'last_sale_date'=>'',
			'last_twelve_mon_sale'=>'',
			'membership'=>'',
			'membership_expiry'=>'',
			'mobile_two'=>'',
			'points_balance'=>'',
			'province_one'=>'',
			'store_name'=>'',
			'subsidiary'=>'',
			'title'=>'',
			'zip_code'=>''
		);
		$extend_field = array(
			'gender'=>''
		);

		if(isset($customer['custom_fields'])){
			foreach ($customer['custom_fields']['field'] as $value) {
				$customer_field[$value['name']] = $value['value'];
			}
			foreach ($customer['extended_fields']['field'] as $value) {
				$extend_field[$value['name']] = $value['value'];
			}
			$cus = $this->kanmo_model->check_caller($phone, $customer, $customer_field, $extend_field);
			if($cus!=false){
				$data['cus_id'] = $cus;
			}
		}

		$data['cphone'] = $phone;
		$data['cus_fname'] = isset($customer['firstname'])?$customer['firstname']:'';
		$data['cus_lname'] = isset($customer['lastname'])?$customer['lastname']:'';
		$data['external_id'] = isset($customer['external_id'])?$customer['external_id']:'';
		//$data['address'] = $customer_field['address_one_home_one'].' '.$customer_field['city_one'].' '.$customer_field['zip_code'].' '.$customer_field['province_one'].' '.$customer_field['country_origin'];
		$data['registered_on'] = isset($customer['registered_on'])?$customer['registered_on']:'';
		$data['tregistered_on'] = isset($customer['registered_on'])?date('F d, Y', strtotime($customer['registered_on'])):'';
		$data['registered_store'] = isset($customer['registered_store'])?$customer['registered_store']['name']:'';
		$data['email'] = isset($customer['email'])?$customer['email']:'';
		$data['subsidiary'] = $customer_field['subsidiary'];
		$data['dob_mom'] = $customer_field['dob_mom'];
		$data['tdob_mom'] = !empty($customer_field['dob_mom'])?date('F d, Y', strtotime($customer_field['dob_mom'])):'';
		$data['anniversary_date'] = $customer_field['anniversary_date'];
		$data['tanniversary_date'] = !empty($customer_field['anniversary_date'])?date('F d, Y', strtotime($customer_field['anniversary_date'])):'';
		$data['gender'] = $customer_field['gender'];
		$data['first_sale_date'] = $customer_field['first_sale_date'];
		$data['tfirst_sale_date'] = !empty($customer_field['first_sale_date'])?date('F d, Y', strtotime($customer_field['first_sale_date'])):'';
		$data['last_modified_date'] = $customer_field['last_modified_date'];
		$data['tlast_modified_date'] = !empty($customer_field['last_modified_date'])?date('F d, Y', strtotime($customer_field['last_modified_date'])):'';
		$data['last_sale_amount'] = $customer_field['last_sale_amount'];
		$data['last_sale_date'] = $customer_field['last_sale_date'];
		$data['tlast_sale_date'] = !empty($customer_field['last_sale_date'])?date('F d, Y', strtotime($customer_field['last_sale_date'])):'';
		$data['last_twelve_mon_sale'] = $customer_field['last_twelve_mon_sale'];
		$data['address_one_home_one'] = $customer_field['address_one_home_one'];
		$data['zip_code'] = $customer_field['zip_code'];
		$data['city_one'] = $customer_field['city_one'];
		$data['province_one'] = $customer_field['province_one'];
		$data['country_origin'] = $customer_field['country_origin'];
		if(!empty($customer_field['last_sale_date']))
			$data['fperiode'] = date('F d, Y', strtotime($customer_field['last_sale_date'].' -3 months')).' - '.date('F d, Y', strtotime($customer_field['last_sale_date'].' +1 day'));
		//$data['extend'] = $customer_field;
		if(isset($customer['firstname'])){
			echo json_encode(array('status'=>true, 'data'=>$data));
		}else{
			echo json_encode(array('status'=>false));
		}
	}

	public function search_add($auth){
		if($auth == '3ec8112b9e277cf4d24c85136fc9ee95'){
			if($_POST){
				$phone = preg_replace('/^0/', '62', $_POST['phone']);
				$customer = $this->get_data($phone);
				$customer_field = array(
					'address_one_home_one'=>'',
					'address_one_home_two'=>'',
					'anniversary_date'=>'',
					'birthday'=>'',
					'city_one'=>'',
					'country_origin'=>'',
					'dob_mom'=>'',
					'first_sale_date'=>'',
					'gender'=>'',
					'last_modified_date'=>'',
					'last_sale_amount'=>'',
					'last_sale_date'=>'',
					'last_twelve_mon_sale'=>'',
					'membership'=>'',
					'membership_expiry'=>'',
					'mobile_two'=>'',
					'points_balance'=>'',
					'province_one'=>'',
					'district_one'=>'',
					'store_name'=>'',
					'subsidiary'=>'',
					'title'=>'',
					'zip_code'=>''
				);
				$extend_field = array(
					'gender'=>''
				);

				if(isset($customer['custom_fields'])){
					foreach ($customer['custom_fields']['field'] as $value) {
						$customer_field[$value['name']] = $value['value'];
					}
					foreach ($customer['extended_fields']['field'] as $value) {
						$extend_field[$value['name']] = $value['value'];
					}
					$cus = $this->kanmo_model->check_caller($phone, $customer, $customer_field, $extend_field);
					if($cus!=false){
						$data['cus_id'] = $cus;
					}
				}

				$data['cphone'] = $phone;
				$data['cus_fname'] = isset($customer['firstname'])?$customer['firstname']:'';
				$data['cus_lname'] = isset($customer['lastname'])?$customer['lastname']:'';
				$data['external_id'] = isset($customer['external_id'])?$customer['external_id']:'';
				$data['registered_on'] = isset($customer['registered_on'])?$customer['registered_on']:'';
				$data['tregistered_on'] = isset($customer['registered_on'])?date('F d, Y', strtotime($customer['registered_on'])):'';
				$data['registered_store'] = isset($customer['registered_store'])?$customer['registered_store']['name']:'';
				$data['email'] = isset($customer['email'])?$customer['email']:'';
				$data['subsidiary'] = $customer_field['subsidiary'];
				$data['dob_mom'] = $customer_field['dob_mom'];
				$data['tdob_mom'] = !empty($customer_field['dob_mom'])?date('F d, Y', strtotime($customer_field['dob_mom'])):'';
				$data['anniversary_date'] = $customer_field['anniversary_date'];
				$data['tanniversary_date'] = !empty($customer_field['anniversary_date'])?date('F d, Y', strtotime($customer_field['anniversary_date'])):'';
				$data['gender'] = $customer_field['gender'];
				$data['first_sale_date'] = $customer_field['first_sale_date'];
				$data['tfirst_sale_date'] = !empty($customer_field['first_sale_date'])?date('F d, Y', strtotime($customer_field['first_sale_date'])):'';
				$data['last_modified_date'] = $customer_field['last_modified_date'];
				$data['tlast_modified_date'] = !empty($customer_field['last_modified_date'])?date('F d, Y', strtotime($customer_field['last_modified_date'])):'';
				$data['last_sale_amount'] = $customer_field['last_sale_amount'];
				$data['last_sale_date'] = $customer_field['last_sale_date'];
				$data['tlast_sale_date'] = !empty($customer_field['last_sale_date'])?date('F d, Y', strtotime($customer_field['last_sale_date'])):'';
				$data['last_twelve_mon_sale'] = $customer_field['last_twelve_mon_sale'];
				$data['address_one_home_one'] = $customer_field['address_one_home_one'];
				$data['fraud_status'] = isset($customer['fraud_details'])?$customer['fraud_details']['status']:'';
				$data['current_slab'] = isset($customer['current_slab'])?$customer['current_slab']:'';
				$data['loyalty_points'] = isset($customer['loyalty_points'])?$customer['loyalty_points']:'';
				$data['zip_code'] = $customer_field['zip_code'];
				$data['city_one'] = $customer_field['city_one'];
				$data['province_one'] = $customer_field['province_one'];
				$data['country_origin'] = $customer_field['country_origin'];
				if(!empty($customer_field['last_sale_date']))
					$data['fperiode'] = date('F d, Y', strtotime($customer_field['last_sale_date'].' -3 months')).' - '.date('F d, Y', strtotime($customer_field['last_sale_date'].' +1 day'));

				$data['nphone'] = $phone;
				$data['nfname'] = isset($customer['firstname'])?$customer['firstname']:'';
				$data['nlname'] = isset($customer['lastname'])?$customer['lastname']:'';
				$data['nbarcode'] = isset($customer['external_id'])?$customer['external_id']:'';
				//$data['address'] = $customer_field['address_one_home_one'].' '.$customer_field['city_one'].' '.$customer_field['zip_code'].' '.$customer_field['province_one'].' '.$customer_field['country_origin'];
				//$data['registered_store'] = isset($customer['registered_store'])?$customer['registered_store']['name']:'';
				$data['nemail'] = isset($customer['email'])?$customer['email']:'';
				$data['nsubsidiary'] = $customer_field['subsidiary'];
				//$data['nsubsidiary'] = 'Kate Spade';
				$data['ndob_mom'] = $customer_field['dob_mom'];
				$data['ngender'] = $customer_field['gender'];
				$data['nadd1'] = $customer_field['address_one_home_one'];
				$data['nadd2'] = $customer_field['address_one_home_two'];
				$data['nzip_code'] = $customer_field['zip_code'];
				$data['ncity_one'] = $customer_field['city_one'];
				$data['nprovince_one'] = $customer_field['province_one'];
				$data['ndistrict_one'] = $customer_field['district_one'];
				$data['ncountry_origin'] = $customer_field['country_origin'];
				//$data['nbrand_interest'] = explode("`,`",trim(trim("[`Mothercare`,`Kate Spade`,`Karen Millen`]", "`]"),"[`"));
				$data['nbrand_interest'] = isset($customer_field['brand_interest'])?explode("`,`",trim(trim($customer_field['brand_interest'], "`"),"`")):array();

				if(isset($customer_field['province_one'])){
					if(!empty($customer_field['province_one'])){
						$data['scity'] = $this->kanmo_model->get_city($customer_field['province_one'], true);
					}else{
						$data['scity'] = array();
					}
				}
				if(isset($customer_field['city_one'])){
					if(!empty($customer_field['city_one'])){
						$data['sdistrict'] = $this->kanmo_model->get_district($customer_field['city_one'], true);
					}else{
						$data['sdistrict'] = array();
					}
				}

				if(isset($customer['firstname'])){
					echo json_encode(array('status'=>true, 'data'=>$data));
				}else{
					echo json_encode(array('status'=>false, 'data'=>$data));
				}
			}
		}else{
			echo 'Authentication failed';
		}
	}

	public function save_customer(){
		//var_dump($_POST);exit();
		if($_POST){
			$action = 'new';
			$data = array(
                "mobile"=>"",
                "email"=>"",
                "external_id"=>"",
				"firstname"=>"",
                "lastname"=>"",
        		//"registered_till"=> "NorthEast",
        		//"associated_with"=>"two.till01",

                //"registered_till"=>"NorthEast",
        		//"associated_with"=>"two.till01",
                "custom_fields"=>array(),
            );

			foreach ($_POST as $key => $value) {
				if($key!='field'&&$key!='action'){
					$data[$key]=$value;
				}else if($key=='field'){
					foreach ($value as $k => $v) {
						$v=is_array($v)?"[`".implode("`,`", $v)."`]":$v;
						$data['custom_fields']['field'][]=array('name'=>$k, 'value'=>$v);
					}
				}else if($key=='action'){
					$action = $value;
				}
			}

			if($action == 'new'){
				$data["registered_on"]= date('Y-m-d H:i:s');
			}
			$data = array('root'=>array('customer'=>array($data)));
			$data = json_encode($data, JSON_PRETTY_PRINT);
			$this->load->helper('apicurl');
			$this->get_token();
			//echo $data.PHP_EOL;
			$result = $this->session->userdata('token');
			if($result){
				if($action=='update'){
				$data = get_data_api('https://119.2.42.174/boostapi/api/CRMCap/V1/UpdateCustomerToCRMCap','POST', array(), array('Authorization:'.$result, 'Content-Type:application/json'), $data, 'json');
				}else{
					$data = get_data_api('https://119.2.42.174/boostapi/api/CRMCap/V1/RegisterCustomerToCRMCap','POST', array(), array('Authorization:'.$result, 'Content-Type:application/json'), $data, 'json');
				}
				
				$data = json_decode($data, true);
				if(isset($data['response']['status'])){
					if($data['response']['status']['success']=='true'){
						$this->search($data['response']['customers']['customer'][0]['mobile']);
					}else{
						echo json_encode(array('status'=>false, 'msg'=>($action=='new'?'Register New ':'Update ').'Customer Failed'));
					}
				}else{
					echo json_encode(array('status'=>false, 'msg'=>($action=='new'?'Register New ':'Update ').'Customer Failed'));
				}
			}
		}
	}

	public function get_city(){
		if($_POST){
			$data = $this->kanmo_model->get_city($_POST['province'], true);
			echo json_encode(array('status'=>true, 'data'=>$data));
		}else{
			echo json_encode(array('status'=>false));
		}
	}

	public function get_district(){
		if($_POST){
			$data = $this->kanmo_model->get_district($_POST['city'], true);
			echo json_encode(array('status'=>true, 'data'=>$data));
		}else{
			echo json_encode(array('status'=>false));
		}
	}

	public function test_email(){
		$email = array(
			'ticket_id'=>'982193798213',
			'main_category'=>'enquiry',
			'subject'=>'Check email',
			'category'=>'Test',
			'assign_by'=>'Annas',
			'assignee'=>'Assign',
			'assign_time'=>date('d F Y H:i:s', strtotime(date('Y-m-d H:i:s'))),
			'due_time'=>date('d F Y H:i:s', strtotime('Y-m-d H:i:s +1 days')),
			'content'=>'Content',
		);

		$this->load->helper('mail');
		echo assign_email(array('email'=>'club.indonesia@nespresso.co.id', 'name'=>'Nespresso'), 'annas@dutamedia.com',$email, 'nespresso');
	}

	public function check_trans($phone){
		$this->load->helper('apicurl');
		$this->get_token();
		$result = $this->session->userdata('token');
echo $result;
		if($result){
			//$data = get_data_api('https://119.2.42.174/boostapi/api/CRMCap/V1/GetCallCenterCustomerDataByMobile','GET', array('custMobile'=>$phone,'formatData'=>'json'), array('Authorization:'.$result, 'Content-Type:application/json'));
			//$data = $this->get_transaction($phone, '2018-01-01+00:00:00', '2019-01-05+23:59:59');
			//echo json_encode($data);
		}
	}

	public function check_token(){
		$this->load->helper('apicurl');
		$result = get_token('https://119.2.42.174/boostapi/token', array('username'=>'callcenter', 'password'=>'zv5gDRmbi&Kal@WU', 'grant_type'=>'password'));
		//echo date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s').' + 3599 seconds'));
		echo json_encode($result);
		//echo date('Y-m-d H:i:s', $this->session->userdata('token_expired'));
	}
}
