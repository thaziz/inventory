<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MX_Controller {

	/**
	 * 
	 */

	public function __construct(){
		$this->load->model('call_model');
		$this->load->model('ticketing_model');
	}

	public function index(){
		echo md5('annas');
	}

	public function status_call(){
		if($this->call_model->update_status()){
			echo json_encode(array('status'=>'OK'));
		}else{
			echo json_encode(array('status'=>'ERROR'));			
		}
	}

	public function testid(){
		$ext=20223;
		echo $this->ticketing_model->generate_ticket_id($ext);
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
				$data['ticket_id'] = $this->ticketing_model->generate_ticket_id($data['agent']);
				$data['call_id'] = isset($_GET['call_id'])?$_GET['call_id']:0;
				if(isset($_GET['phone'])){
					$customer = $this->get_data($phone);
				}
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
					'company'=>'',
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
						$cus = $this->ticketing_model->check_caller($phone, $customer, $customer_field, $extend_field);
					}
					if($cus!=false){
						$data['data'] = $cus;
					}
					$data['wa'] = isset($_GET['wa'])?$_GET['wa']:0;

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
					$data['ncompany'] = $customer_field['company'];
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
							$data['scity'] = $this->ticketing_model->get_city($customer_field['province_one'], true);
						}else{
							$data['scity'] = array();
						}
					}
					if(isset($customer_field['city_one'])){
						if(!empty($customer_field['city_one'])){
							$data['sdistrict'] = $this->ticketing_model->get_district($customer_field['city_one'], true);
						}else{
							$data['sdistrict'] = array();
						}
					}


				}

				$data['wa'] = isset($_GET['wa'])?$_GET['wa']:0;
				$data['phone'] = $phone;
				$data['fname'] = isset($customer['firstname'])?$customer['firstname']:'';
				$data['lname'] = isset($customer['lastname'])?$customer['lastname']:'';
				$data['external_id'] = isset($customer['external_id'])?$customer['external_id']:'';
				$data['address'] = isset($_GET['phone'])?$customer_field['address_one_home_one'].' '.$customer_field['city_one'].' '.$customer_field['zip_code'].' '.$customer_field['province_one'].' '.$customer_field['country_origin']:'';
				$data['registered_on'] = isset($customer['registered_on'])?$customer['registered_on']:'';
				$data['registered_store'] = isset($customer['registered_store'])?$customer['registered_store']['name']:'';
				$data['email'] = isset($customer['email'])?$customer['email']:'';
				$data['fields'] = $customer_field;
				$data['extend'] = $customer_field;
				$data['auth'] = $auth;
				$data['assign_list'] = $this->ticketing_model->assignment_list();
				$data['main_category'] = $this->ticketing_model->main_category();
				/*$data['category'] = $this->ticketing_model->category();*/
				$data['subsidiary'] = $this->ticketing_model->get_subsidiary();
				$data['province'] = $this->ticketing_model->get_province();
				
				//$data['departments'] = $this->ticketing_model->depart_list();
				//var_dump($data);exit();
				$this->load->view('forms/ticketing', $data);
			}else{
				echo 'Invalid URL';
			}
		}else{
			echo 'Authentication failed';
		}
	}
	public function get_category(){
		if($_POST){
			$cat = $this->ticketing_model->category($_POST['id']);
			echo json_encode($cat);
		}
	}
	public function get_meta_category(){
		if($_POST){
			$cat = $this->ticketing_model->meta_category($_POST['id']);
			echo json_encode($cat);
		}
	}
	public function get_subcategory(){
		if($_POST){
			$cat = $this->ticketing_model->subcategory($_POST['id']);
			echo json_encode($cat);
		}
	}
	public function show_subcat_info(){
		if($_POST){
			$html = array();
			if(!empty($_POST['subcat'])){
				$cat = $this->ticketing_model->subcategory_info($_POST['subcat']);
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
	            $this->form_validation->set_rules('main_category', 'Main Category', 'required');
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
            		$data['e']['main_category'] = form_error('main_category', '<div class="has-error">', '</div>');
            		$data['e']['meta_category'] = form_error('meta_category', '<div class="has-error">', '</div>');
            		$data['e']['category'] = form_error('category', '<div class="has-error">', '</div>');
            		$data['e']['sub_category'] = form_error('sub_category', '<div class="has-error">', '</div>');
            		if($_POST['status']=='OPEN'){
            			$data['e']['email_assign'] = form_error('email_assign', '<div class="has-error">', '</div>');
            		}
            		echo json_encode($data);
            	}else{
            		if($this->ticketing_model->save_ticket()){
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
			echo '<pre>';
			echo print_r(json_decode($data));
			echo '</pre>';
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
					if(!empty($_POST['phone'])){
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
							$this->ticketing_model->save_transaction($_POST['phone'], $datadb);
						}
					}
					/*$data = array();
					$i = 1;
					foreach ($_data['transaction'] as $key => $v) {
						$data['data'][] = array($i, $v['id'], $v['type'], $v['amount'], $v['delivery_status'], $v['billing_time'], $v['store']);
						$i++;
					}*/
					$list = $this->ticketing_model->get_load_trans();
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
			                        "recordsTotal" => $this->ticketing_model->count_trans_all(),
			                        "recordsFiltered" => $this->ticketing_model->count_trans_filtered(),
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

	public function ticket_email($from, $subject, $time, $body, $type){
		if(strtolower(substr($subject, 0, 4))!='re: '){
			$customer = $this->get_cust_from_email($from);
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
						$cus = $this->ticketing_model->check_caller($phone, $customer, $customer_field, $extend_field);
					}
					if($cus!=false){
						$data['data'] = $cus;
					}
				}

				$data['phone'] = isset($customer['mobile'])?$customer['mobile']:'';
				$data['fname'] = isset($customer['firstname'])?$customer['firstname']:'';
				$data['lname'] = isset($customer['lastname'])?$customer['lastname']:'';
				$data['external_id'] = isset($customer['external_id'])?$customer['external_id']:'';
				$data['address'] = isset($_GET['phone'])?$customer_field['address_one_home_one'].' '.$customer_field['city_one'].' '.$customer_field['zip_code'].' '.$customer_field['province_one'].' '.$customer_field['country_origin']:'';
				$data['registered_on'] = isset($customer['registered_on'])?$customer['registered_on']:'';
				$data['registered_store'] = isset($customer['registered_store'])?$customer['registered_store']['name']:'';
				$data['email'] = isset($customer['email'])?$customer['email']:'';
				$data['fields'] = $customer_field;
				$data['extend'] = $customer_field;
		}
	}

	public function get_ticket($auth){
		if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
			if($_POST){
				$list = $this->ticketing_model->get_load_ticket();
				//echo $this->db->last_query();exit;
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
		                        "recordsTotal" => $this->ticketing_model->count_ticket_all(),
		                        "recordsFiltered" => $this->ticketing_model->count_ticket_filtered(),
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
			$ticket = $this->ticketing_model->get_ticket_detail($_POST['id']);
			echo json_encode($ticket);
		}else{
			echo 'Invalid auth';
		}
	}

	public function get_trans_detail($auth){
		if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
			if($_POST){
				$list = $this->ticketing_model->get_load_items();
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
		                        "recordsTotal" => $this->ticketing_model->count_items_all(),
		                        "recordsFiltered" => $this->ticketing_model->count_items_filtered(),
		                        "data" => $data,
		                );
		        echo json_encode($output);
			}
		}
	}

	private function search($phone, $msg=''){
		$phone = preg_replace('/^0/', '62', $phone);
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
			'store_name'=>'',
			'subsidiary'=>'',
			'company'=>'',
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
			$cus = $this->ticketing_model->check_caller($phone, $customer, $customer_field, $extend_field);
			if($cus!=false){
				$data['cus_id'] = $cus;
			}
		}

		$data['cus_phone'] = $phone;
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
		$data['zip_code'] = $customer_field['zip_code'];
		$data['company'] = $customer_field['company'];
		$data['city_one'] = $customer_field['city_one'];
		$data['province_one'] = $customer_field['province_one'];
		$data['country_origin'] = $customer_field['country_origin'];
		if(!empty($customer_field['last_sale_date']))
			$data['fperiode'] = date('F d, Y', strtotime($customer_field['last_sale_date'].' -3 months')).' - '.date('F d, Y', strtotime($customer_field['last_sale_date'].' +1 day'));
		//$data['extend'] = $customer_field;
		if(isset($customer['firstname'])){
			echo json_encode(array('status'=>true, 'data'=>$data, 'msg'=>$msg));
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
					'company'=>'',
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
					$cus = $this->ticketing_model->check_caller($phone, $customer, $customer_field, $extend_field);
					if($cus!=false){
						$data['cus_id'] = $cus;
					}
				}

				$data['cus_phone'] = $phone;
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
				$data['ncompany'] = $customer_field['company'];
				//$data['nbrand_interest'] = explode("`,`",trim(trim("[`Mothercare`,`Kate Spade`,`Karen Millen`]", "`]"),"[`"));
				$data['nbrand_interest'] = isset($customer_field['brand_interest'])?explode("`,`",trim(trim($customer_field['brand_interest'], "`"),"`")):array();

				if(isset($customer_field['province_one'])){
					if(!empty($customer_field['province_one'])){
						$data['scity'] = $this->ticketing_model->get_city($customer_field['province_one'], true);
					}else{
						$data['scity'] = array();
					}
				}
				if(isset($customer_field['city_one'])){
					if(!empty($customer_field['city_one'])){
						$data['sdistrict'] = $this->ticketing_model->get_district($customer_field['city_one'], true);
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
						$this->search($data['response']['customers']['customer'][0]['mobile'], ($action=='new'?'Register New ':'Update ').'Customer Success');
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
			$data = $this->ticketing_model->get_city($_POST['province'], true);
			echo json_encode(array('status'=>true, 'data'=>$data));
		}else{
			echo json_encode(array('status'=>false));
		}
	}

	public function get_district(){
		if($_POST){
			$data = $this->ticketing_model->get_district($_POST['city'], true);
			echo json_encode(array('status'=>true, 'data'=>$data));
		}else{
			echo json_encode(array('status'=>false));
		}
	}

	public function outgoing_call(){
		//require_once APPPATH.'third_party/php-ami.php';
		$this->load->library('astman');
		$this->astman = new AstMan;
		$this->astman->amiHost = 'localhost';
		$this->astman->amiPort = '5038';
		$this->astman->amiUsername = 'admin';
		$this->astman->amiPassword = 'dut4_MEDIA';
		//$this->astman -> Login();
		//$users = $this->astman->GetUser('514251');
		//print_r($users);
		//exit();
		    
	    $dn = preg_replace('/^62/', '0', $_POST['dn']);
	    $dn = substr($dn, 0,1)!='0'?'0'.$dn:$dn;

	    if (strlen($dn)<7) {
	        echo("DN Number too short ".$dn);
	        exit();
	    }
	    if (!isset($_POST['ext'])) {
	        echo json_encode(array('status'=>false, 'msg'=>'Number must be set'));
	        exit();
	    }
	    if ($this->astman->Login()) {
	        $userData = $this->astman->GetUser($_POST['ext']);
	        //print_r($userData);
	        if (strpos($userData, "Status: OK") !== false) {
	            $idCall = date('YmdHis').substr($_POST['ext'], -2).substr($dn, -4);
	            $originateRequest = "Action: Originate\r\n";
	            $originateRequest .= "Channel: SIP/".$_POST['ext']."\r\n";
	            $originateRequest .= "Callerid: ".$_POST['ext']."\r\n";
	            $originateRequest .= "Exten: ".$dn."\r\n";
	            $originateRequest .= "Context: from-internal\r\n";
	            $originateRequest .= "Priority: 1\r\n";
	            $originateRequest .= "Variable: CALLID=".$idCall."\r\n";
	            $originateRequest .= "Variable: CALLBACK=".base_url('api/return_outgoing/3ec8112b9e277cf4d24c85136fc9ee95')."\r\n";
		    $originateRequest .= "Variable: _SIPADDHEADER51=X-AUTOANSWER: TRUE\r\n";
	            $originateRequest .= "Async: yes\r\n\r\n";
	            $return = array('outgoing_id'=>$idCall,
	                    'ext'=>$_POST['ext'],
	                    'calldate'=>date('Y-m-d H:i:s'),
	                    'phone'=>$dn);
	            if ($res = $this->astman->Query($originateRequest)) {
	                //echo($originateRequest);
		            $return['outgoing_id'] = $this->ticketing_model->save_outgoing($return);
	                $return['status'] = true;
	                $return['result'] = $res;
	            }
	        } elseif (strpos($userData, "Status") !== false) {
	            $return['status']=false;
	            $return['msg']='User not Online';
	        } else {
	            $return['status']=false;
	            $return['msg']=$userData;
	        }
	    } else {
	        $return['status']=false;
	        $return['msg']="Could not authenticate";
	    }

		echo json_encode($return);
	}

	public function return_outgoing($auth){
		if ($auth=='3ec8112b9e277cf4d24c85136fc9ee95') {
			$data['call_status'] = $_GET['dialstatus'];
			$data['outgoing_id'] = $_GET['callid'];
			$data['duration'] = $_GET['billsec'];
			$data['recordingfile'] = $_GET['recordingfile'];
			if($this->ticketing_model->save_return_outgoing($data)){
				echo 'success';
			}else{
				echo 'failed';
			}
		}else{
			echo 'Invalid Authentication';
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
		if($result){
			$data = get_data_api('https://119.2.42.174/boostapi/api/CRMCap/V1/GetCallCenterCustomerDataByMobile','GET', array('custMobile'=>$phone,'formatData'=>'json'), array('Authorization:'.$result, 'Content-Type:application/json'));
			//$data = $this->get_transaction($phone, '2018-01-01+00:00:00', '2019-01-05+23:59:59');
			echo json_encode($data);
		}
	}

	public function get_cust_wa($phone){
		$this->load->helper('apicurl');
		$this->get_token();
		$result = $this->session->userdata('token');
		if($result){
			$data = get_data_api('https://119.2.42.174/boostapi/api/CRMCap/V1/GetCallCenterCustomerDataByMobile','GET', array('custMobile'=>$phone,'formatData'=>'json'), array('Authorization:'.$result, 'Content-Type:application/json'));
			//$data = $this->get_transaction($phone, '2018-01-01+00:00:00', '2019-01-05+23:59:59');
			$data = json_decode($data, true);
			$data = $data['response'];
			if($data['status']['success']=='true'){
				$customer = $data['customers']['customer'][0];

				$data = array();

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
					'company'=>'',
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
					if(!empty($phone)){
						$cus = $this->ticketing_model->check_chat($phone, $customer, $customer_field, $extend_field);
					}
					if($cus!=false){
						$data['data'] = $cus;
					}

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
					$data['ncompany'] = $customer_field['company'];
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
							$data['scity'] = $this->ticketing_model->get_city($customer_field['province_one'], true);
						}else{
							$data['scity'] = array();
						}
					}
					if(isset($customer_field['city_one'])){
						if(!empty($customer_field['city_one'])){
							$data['sdistrict'] = $this->ticketing_model->get_district($customer_field['city_one'], true);
						}else{
							$data['sdistrict'] = array();
						}
					}


				}

				$data['phone'] = $phone;
				$data['current_slab'] = isset($customer['current_slab'])?$customer['current_slab']:'';
				$data['fname'] = isset($customer['firstname'])?$customer['firstname']:'';
				$data['lname'] = isset($customer['lastname'])?$customer['lastname']:'';
				$data['external_id'] = isset($customer['external_id'])?$customer['external_id']:'';
				$data['address'] = $customer_field['address_one_home_one'].' '.$customer_field['city_one'].' '.$customer_field['zip_code'].' '.$customer_field['province_one'].' '.$customer_field['country_origin'];
				$data['registered_on'] = isset($customer['registered_on'])?$customer['registered_on']:'';
				$data['registered_store'] = isset($customer['registered_store'])?$customer['registered_store']['name']:'';
				$data['loyalty_points'] = isset($customer['loyalty_points'])?$customer['loyalty_points']:0;
				$data['anniversary_date'] = isset($customer_field['anniversary_date'])?$customer_field['anniversary_date']:0;
				$data['first_sale_date'] = isset($customer_field['first_sale_date'])?$customer_field['first_sale_date']:0;
				$data['last_modified_date'] = isset($customer_field['last_modified_date'])?$customer_field['last_modified_date']:0;
				$data['last_sale_amount'] = isset($customer_field['last_sale_amount'])?$customer_field['last_sale_amount']:0;
				$data['last_sale_date'] = isset($customer_field['last_sale_date'])?$customer_field['last_sale_date']:0;
				$data['last_twelve_mon_sale'] = isset($customer_field['last_twelve_mon_sale'])?$customer_field['last_twelve_mon_sale']:0;
				$data['fraud_status'] = isset($customer['fraud_details'])?$customer['fraud_details']['status']:0;
				$data['email'] = isset($customer['email'])?$customer['email']:'';
				//$data['fields'] = $customer_field;
				//$data['extend'] = $customer_field;
				//$data['auth'] = $auth;
				$data['assign_list'] = $this->ticketing_model->assignment_list();
				$data['main_category'] = $this->ticketing_model->main_category();
				/*$data['category'] = $this->ticketing_model->category();*/
				$data['subsidiary'] = $this->ticketing_model->get_subsidiary();
				$data['province'] = $this->ticketing_model->get_province();

				echo json_encode($data);
			}else {
				echo json_encode(array());
			}
		}
	}

	public function check_token(){
		//echo date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s').' + 3599 seconds'));
		echo date('Y-m-d H:i:s', $this->session->userdata('token_expired'));
	}
}