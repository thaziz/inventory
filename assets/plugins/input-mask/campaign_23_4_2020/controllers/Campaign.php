<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/third_party/Box/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\Style;
use Box\Spout\Writer\Style\Border;
use Box\Spout\Writer\Style\BorderBuilder;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\WriterFactory;

class Campaign extends MX_Controller
{

	/**
	 *
	 */

	public function __construct()
	{
		//check if the user has logged in, otherwise redirect to login page
		if (!isset($this->session->userdata['logged_in'])) {
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'campaign');
		if (!isset($this->menu['rule']['panel/campaign'])) {
			show_404();
		}
		$this->load->model('campaign_model');
		$this->load->model('data_campaign_model', 'data_campaign');
		$this->load->model('agent_campaign_model', 'agent_campaign');
		$this->load->model('assign_campaign_model', 'assign_campaign');
		$this->load->model('report_campaign_model', 'report_campaign');
		$this->load->model('Dashboard_campaign_model', 'dashboard_campaign');
		$this->load->model('Target_campaign_model', 'campaign_target');
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
	}

	public function index()
	{
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['v']);
		if ($_POST && $auth) {
			$list = $this->campaign_model->get_load_result($this->menu['rule']['panel/campaign']);
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
		} else {
			$data['menu'] = $this->menu;
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/campaign'];
			$data['created_by'] = $this->campaign_model->get_campaign_creator();
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS CAMPAIGN MENU');
			$this->template->view('view_campaign', $data);
		}
	}

	public function campaign_insert()
	{
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['c']);
		if ($_POST && $auth) {
			$flag = true;
			$this->form_validation->set_rules('campaign_name', 'Name', 'required');
			$this->form_validation->set_rules('retries', 'retries', 'required');

			if ($this->menu['rule']['panel/campaign']['a']) {
				$this->form_validation->set_rules('spv_id', 'Supervisi', 'required');
			}

			if (isset($_POST['sms_enabled'])) {
				$this->form_validation->set_rules('sms_script', 'SMS Script', 'required');
			}
			/*$this->form_validation->set_rules('queue', 'queue', 'required');*/
			//$this->form_validation->set_rules('out_type', 'outbond type', 'required');
			$this->form_validation->set_rules('script', 'Script', 'required');
			//$this->form_validation->set_rules('ivr_template', 'IVR Template', 'required');
			$this->form_validation->set_rules('date_range', 'Date Range', 'required');
			if (empty($_POST['stime_perday'])) {
				$flag = false;
				$data['e']['stime_perday'] = '<div class="has-error">Schedule per day is required</div>';
			}
			if (empty($_POST['etime_perday'])) {
				$flag = false;
				$data['e']['etime_perday'] = '<div class="has-error">Schedule per day is required</div>';
			}
			if (!isset($_POST['el'])) {
				$flag = false;
				$data['e']['form'] = '<div class="has-error">Form is required</div>';
			}
			if ($this->form_validation->run() == false || !$flag) {
				$data['status'] = false;
				$data['e']['campaign_name'] = form_error('campaign_name', '<div class="has-error">', '</div>');
				$data['e']['retries'] = form_error('retries', '<div class="has-error">', '</div>');
				if ($this->menu['rule']['panel/campaign']['a']) {
					$data['e']['spv_id'] = form_error('spv_id', '<div class="has-error">', '</div>');
				}
				if (isset($_POST['sms_enabled'])) {
					$data['e']['sms_script'] = form_error('sms_script', '<div class="has-error">', '</div>');
				}
				/*$data['e']['queue'] = form_error('queue', '<div class="has-error">', '</div>');*/
				//$data['e']['out_type'] = form_error('out_type', '<div class="has-error">', '</div>');
				$data['e']['script'] = form_error('script', '<div class="has-error">', '</div>');
				//$data['e']['ivr_template'] = form_error('ivr_template', '<div class="has-error">', '</div>');
				$data['e']['date_range'] = form_error('date_range', '<div class="has-error">', '</div>');
				echo json_encode($data);
			} else {
				$el = array();
				foreach ($_POST['el'] as $key => $value) {
					$value['label'] = $value['name'];
					$value['name'] = strtolower(preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', $value['label'])));
					if (strlen($value['name']) > 25) {
						$value['name'] = substr(md5($value['name'] . date('is')), 0, 25);
					}
					$el[] = $value;
				}
				$_POST['form'] = json_encode($el);
				$_POST['el'] = $el;
				//secho json_encode($el);
				if ($id = $this->campaign_model->insert()) {
					//write_log($this->session->userdata['name'], 'INSERT CAMPAIGN ID: '.$this->db->insert_id().' NAME: '.$_POST['campaign_name']);
					echo json_encode(array('status' => true, 'id' => $id));
				} else {
					echo json_encode(array('status' => false, 'msg' => 'FAILED INSERTING DATA'));
				}
			}
		} else {
			$data['menu'] = $this->menu;
			//$data['ivr_template'] = $this->campaign_model->ivr_template();
			//$this->userlog->add_log($this->session->userdata['name'], 'ACCESS INSERT CAMPAIGN MENU');
			$data['rules'] = $this->menu['rule']['panel/campaign'];
			$data['spv'] = $this->campaign_model->get_spv();
			$this->template->view('view_campaign_insert', $data);
		}
	}

	public function campaign_detail($id)
	{
		$data['menu'] = $this->menu;
		if ($this->template->set_auth($this->menu['rule']['panel/campaign']['v'])) {
			$data['data'] = $this->campaign_model->detail_id($id);
			//$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW CAMPAIGN ID: '.$id.' NAME: '.$data['data']->cus_name);
		}
		$data['rules'] = $this->menu['rule']['panel/campaign'];
		$data['arr_outbound']     =   array('preview' => 'Preview Mode', 'predictive' => 'Predictive Mode');
		$this->template->view('view_campaign_detail', $data);
	}

	public function campaign_edit($id)
	{
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['e']);
		if ($_POST && $auth) {
			$flag = true;
			$this->form_validation->set_rules('campaign_name', 'Name', 'required');
			$this->form_validation->set_rules('retries', 'retries', 'required');
			/*$this->form_validation->set_rules('queue', 'queue', 'required');*/
			//$this->form_validation->set_rules('out_type', 'outbond type', 'required');
			if ($this->menu['rule']['panel/campaign']['a']) {
				$this->form_validation->set_rules('spv_id', 'Supervisi', 'required');
			}
			$this->form_validation->set_rules('script', 'Script', 'required');
			//$this->form_validation->set_rules('ivr_template', 'IVR Template', 'required');
			$this->form_validation->set_rules('date_range', 'Date Range', 'required');
			if (empty($_POST['stime_perday'])) {
				$flag = false;
				$data['e']['stime_perday'] = '<div class="has-error">Schedule per day is required</div>';
			}
			if (empty($_POST['etime_perday'])) {
				$flag = false;
				$data['e']['etime_perday'] = '<div class="has-error">Schedule per day is required</div>';
			}
			if ($this->form_validation->run() == false || !$flag) {
				$data['status'] = false;
				$data['e']['campaign_name'] = form_error('campaign_name', '<div class="has-error">', '</div>');
				$data['e']['retries'] = form_error('retries', '<div class="has-error">', '</div>');
				if ($this->menu['rule']['panel/campaign']['a']) {
					$data['e']['spv_id'] = form_error('spv_id', '<div class="has-error">', '</div>');
				}
				/*$data['e']['queue'] = form_error('queue', '<div class="has-error">', '</div>');*/
				//$data['e']['out_type'] = form_error('out_type', '<div class="has-error">', '</div>');
				$data['e']['script'] = form_error('script', '<div class="has-error">', '</div>');
				//$data['e']['ivr_template'] = form_error('ivr_template', '<div class="has-error">', '</div>');
				$data['e']['date_range'] = form_error('date_range', '<div class="has-error">', '</div>');
				echo json_encode($data);
			} else {
				//secho json_encode($el);
				if ($this->campaign_model->is_table_exist($id)) {
					unset($_POST['el']);
					unset($_POST['form']);
					if ($this->campaign_model->update($id)) {
						//write_log($this->session->userdata['name'], 'INSERT CAMPAIGN ID: '.$this->db->insert_id().' NAME: '.$_POST['campaign_name']);
						if($_POST['outbound_type']=='predictive'){
							//$this->data_campaign->change_to_predictive($id);
						}
						echo json_encode(array('status' => true, 'id' => $id));
					} else {
						echo json_encode(array('status' => false, 'msg' => 'FAILED EDIT DATA'));
					}
				} else {
					$el = array();
					foreach ($_POST['el'] as $key => $value) {
						$value['label'] = $value['name'];
						$value['name'] = strtolower(preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', $value['label'])));
						if (strlen($value['name']) > 25) {
							$value['name'] = substr(md5($value['name'] . date('is')), 0, 25);
						}
						$el[] = $value;
					}
					$_POST['form'] = json_encode($el);
					$_POST['el'] = $el;
					//secho json_encode($el);
					if ($id = $this->campaign_model->insert()) {
						//write_log($this->session->userdata['name'], 'INSERT CAMPAIGN ID: '.$this->db->insert_id().' NAME: '.$_POST['campaign_name']);
						echo json_encode(array('status' => true, 'id' => $id));
					} else {
						echo json_encode(array('status' => false, 'msg' => 'FAILED INSERTING DATA'));
					}
				}
			}
		} else {
			//$data['arr_outbond']     =   array(1 => 'Preview Mode','Progressive Mode','Predictive Mode');
			$data['menu']            =   $this->menu;
			$data['data']            =   $this->campaign_model->find_by_id($id);
			$data['rules'] = $this->menu['rule']['panel/campaign'];
			$data['spv'] = $this->campaign_model->get_spv();
			$data['tbl_exist'] = $this->campaign_model->is_table_exist($id);
			$data['arr_outbound']     =   array('preview' => 'Preview Mode', 'predictive' => 'Predictive Mode');
			//$data['ivr_template']    =   $this->campaign_model->ivr_template();
			//$this->userlog->add_log($this->session->userdata['name'], 'ACCESS INSERT CAMPAIGN MENU');
			$this->template->view('view_campaign_edit', $data);
		}
	}

	public function change_to_predictive($id)
	{
		$this->data_campaign->change_to_predictive($id);
	}

	public function campaign_delete()
	{
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['d']);
		if ($auth) {
			$info = json_encode($this->campaign_model->find_name($_POST['c_id']));
			$info = json_decode($info);
			//$info = str_replace('cus_','',str_replace('[', '', str_replace(']', '', $info)));
			if ($this->campaign_model->delete()) {
				$this->userlog->add_log($this->session->userdata['name'], ' DELETE CAMPAIGN ID ' . $info[0]->campaign_id . ' DELETE CAMPAIGN NAME ' . $info[0]->campaign_name);
				$data['status'] = true;
			} else {
				$data['status'] = false;
			}
			print_r(json_encode($data));
		} else {
			$this->template->view('');
		}
	}

	public function export_detail_campaign($id)
	{
		$arr = array();
		$header = array();
		$name = array();
		$values = array();
		$no = 1;
		$list = json_decode(json_encode($this->data_campaign->get_load_data($id)), true);
		$form = $this->campaign_model->get_form($id);
		$form = json_decode($form);
		/*echo '<pre>';
		print_r($list);
		echo '</pre>';
		exit;*/
		$border = (new BorderBuilder())
			->setBorderBottom(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
			->setBorderTop(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
			->setBorderLeft(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
			->setBorderRight(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
			->build();

		$tstyle = (new StyleBuilder())
			//->setShouldWrapText()
			//->setShouldShrinkToFit()
			//->setHorizontalAlignment(Style::H_ALIGN_CENTER)
			->build();

		$headstyle = (new StyleBuilder())
			->setBorder($border)
			->setFontBold()
			//->setShouldWrapText()
			//->setShouldShrinkToFit()
			//->setHorizontalAlignment(Style::H_ALIGN_CENTER)
			->build();
		$style = (new StyleBuilder())
			->setBorder($border)
			//->setShouldWrapText()
			//->setShouldShrinkToFit()
			//->setHorizontalAlignment(Style::H_ALIGN_CENTER)
			->build();
		/*$alpha = 'A';*/
		/*

			for ($n=0; $n < count($list); $n++) {
				unset($list[$n]['data_id']);
				unset($list[$n]['assign_id']);
				unset($list[$n]['status']);
				unset($list[$n]['note']);
				unset($list[$n]['callback']);
				$values[] = $list[$n][$name[$i]];

			}
		}*/
		for ($i = 0; $i < count($form); $i++) {
			$header[] = $form[$i]->label;
			$name[] 	= 'form_' . $form[$i]->name;
		}

		for ($n = 0; $n < count($list); $n++) {
			unset($list[$n]['data_id']);
			unset($list[$n]['assign_id']);
			unset($list[$n]['status']);
			unset($list[$n]['note']);
			unset($list[$n]['callback']);
			$values[] = $list[$n];
		}

		/*echo '<pre>';
		print_r($values);
		echo '</pre>';
		exit;*/

		$writer = WriterFactory::create(Type::XLSX);
		/*$writer->setShouldCreateNewSheetsAutomatically(true);*/
		/*$filename='campaign '.strtolower($campaign->campaign_name).' report.xlsx';*/
		$filename = 'campaign test report.xlsx';
		//header('Content-type: application/vnd.ms-excel');
		//header('Content-Disposition: attachment; filename="'.$filename.'"');
		//$writer->openToFile('php://output');
		//$writer->addMergeCell('A1',$alpha.'1');
		$writer->openToBrowser($filename);
		//$writer->addRow(['Data Report Campaign '.$campaign->campaign_name]);
		/*$writer->addRowWithStyle(['Data Report Campaign '.$campaign->campaign_name], $tstyle);*/
		//echo json_encode($list);
		//exit;
		$writer->addRowWithStyle($header, $headstyle);
		$writer->addRowsWithStyle($values, $style);
		/*echo '<pre>';
		print_r($header);
		echo '</pre>';*/
		/*$writer->addRowsWithStyle($data, $style);*/
		$writer->close();
	}

	public function data($id)
	{
		$form = $this->campaign_model->get_form($id);
		$form = json_decode($form);
		$list = $this->data_campaign->get_load_data($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $campaign) {
			$no++;
			$row = array();
			$row[] = $campaign->data_id;
			$row[] = $no;			
			$row[] = $campaign->adm_name;	
			foreach ($form as $value) {
				$row[] = $campaign->{'form_' . $value->name};
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->data_campaign->count_all($id),
			"recordsFiltered" => $this->data_campaign->count_filtered($id),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function insert_data($id)
	{
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['e']);
		$data['campaign'] = $this->campaign_model->find_by_id($id);
		if ($_POST && $auth) {
			$form = json_decode($data['campaign']->form, true);
			$idx = 0;
			$amount_fields = array();
			foreach ($form as $val) {
				$label = $val['label'];
				$name = $val['name'];
				$names[] = $name;
				if (isset($val['required']) && !isset($val['editable'])) {
					$min = '';
					$max = '';
					if ($val['type'] == 'text' || $val['type'] == 'password' || $val['type'] == 'email') {
						if (isset($val['min']) && $val['min'] > 0) {
							$min = '|min_length[' . $val['min'] . ']';
						}
						if (isset($val['max']) && $val['max'] > 0) {
							$max = '|max_length[' . $val['max'] . ']';
						}
					}
					$email = '';
					if ($val['type'] == 'email') {
						$email = '|valid_email';
					}
					$rule = 'required' . $email . $min . $max;
					if ($val['type'] == 'file') {
						if (empty($_FILES[$name]['name'])) {
							$this->form_validation->set_rules($name, $label, $rule);
						}
					} else {
						$this->form_validation->set_rules($name, $label, $rule);
					}
					$idx++;
				}
			}
			if ($val['type'] == 'amount') {
				$amount_fields[] = $val['name'];
			}
			if ($this->form_validation->run() == false && $idx > 0) {
				$data = array();
				$data['status'] = false;
				foreach ($names as $key => $value) {
					$data['e'][$value] = form_error($value, '<div class="has-error">', '</div>');
				}
				echo json_encode($data);
			} else {
				$data = array();
				if (count($_FILES) > 0) {
					$this->load->library('upload');
					foreach ($_FILES as $key => $value) {
						$path = '/uploads/project_files/' . date('Y-m-d') . '/';
						if (!is_dir($dir = 'assets' . $path)) {
							mkdir($dir);
						}
						$config['allowed_types'] = '*';
						$config['upload_path']   = $dir;

						$this->upload->initialize($config);
						if (!$this->upload->do_upload($key)) {
							//echo json_encode(array('status'=>'ERROR', 'errors'=>$this->upload->display_errors()));
						} else {
							$dataFile  = $this->upload->data();
							$data['form_' . $key] = 'assets' . $path . $dataFile['file_name'];
						}
					}
				}
				foreach ($_POST as $key => $vp) {
					if (in_array($key, $amount_fields)) {
						$vp = preg_replace('/[^0-9]/', '', $vp);
					}
					$data['form_' . $key] = $vp;
				}
				if ($this->data_campaign->insert($id, $data)) {
					echo json_encode(array('status' => true));
				} else {
					echo json_encode(array('status' => false));
				}
			}
		} else {
			$data['menu'] = $this->menu;
			$this->template->view('view_data_form', $data);
		}
	}
	public function edit_data($id, $data_id)
	{
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['e']);
		$data['campaign'] = $this->campaign_model->find_by_id($id);
		if ($_POST && $auth) {
			$form = json_decode($data['campaign']->form, true);
			$idx = 0;
			$amount_fields = array();
			foreach ($form as $val) {
				$label = $val['label'];
				$name = $val['name'];
				$names[] = $name;
				if (isset($val['required']) && !isset($val['editable'])) {
					$min = '';
					$max = '';
					if ($val['type'] == 'text' || $val['type'] == 'password' || $val['type'] == 'email') {
						if ($val['min'] > 0) {
							$min = '|min_length[' . $val['min'] . ']';
						}
						if ($val['max'] > 0) {
							$max = '|max_length[' . $val['max'] . ']';
						}
					}
					$email = '';
					if ($val['type'] == 'email') {
						$email = '|valid_email';
					}
					if ($val['type'] == 'file') {
						if (empty($_FILES[$name]['name'])) {
							$this->form_validation->set_rules($name, $label, 'required' . $email . $min . $max);
						}
					} else {
						$this->form_validation->set_rules($name, $label, 'required' . $email . $min . $max);
					}
					$idx++;
				}
			}
			if ($val['type'] == 'amount') {
				$amount_fields[] = $val['name'];
			}
			if ($this->form_validation->run() == false && $idx > 0) {
				$data = array();
				$data['status'] = false;
				foreach ($names as $key => $value) {
					$data['e'][$value] = form_error($value, '<div class="has-error">', '</div>');
				}
				echo json_encode($data);
			} else {
				$data = array();
				if (count($_FILES) > 0) {
					$this->load->library('upload');
					foreach ($_FILES as $key => $value) {
						$path = '/uploads/project_files/' . date('Y-m-d') . '/';
						if (!is_dir($dir = 'assets' . $path)) {
							mkdir($dir);
						}
						$config['allowed_types'] = '*';
						$config['upload_path']   = $dir;

						$this->upload->initialize($config);
						if (!$this->upload->do_upload($key)) {
							//echo json_encode(array('status'=>'ERROR', 'errors'=>$this->upload->display_errors()));
						} else {
							$dataFile  = $this->upload->data();
							$data['form_' . $key] = 'assets' . $path . $dataFile['file_name'];
						}
					}
				}
				foreach ($_POST as $key => $vp) {
					if (in_array($key, $amount_fields)) {
						$vp = preg_replace('/[^0-9]/', '', $vp);
					}
					$data['form_' . $key] = $vp;
				}
				if ($this->data_campaign->update($id, $data_id, $data)) {
					echo json_encode(array('status' => true));
				} else {
					echo json_encode(array('status' => false));
				}
			}
		} else {
			$data['menu'] = $this->menu;
			$data['data'] = $this->data_campaign->find_by_id($id, $data_id);
			$this->template->view('view_data_form', $data);
		}
	}

	public function delete_data($id)
	{
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['e']);
		if ($_POST && $auth) {
			if ($this->data_campaign->delete($id)) {
				echo json_encode(array('status' => true));
			} else {
				echo json_encode(array('status' => false));
			}
		}
	}



	public function target($id)
	{
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['e']);
		if ($_POST && $auth) {
			$list = $this->campaign_target->get_load_result($id);
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $t) {
				$no++;
				$row = array();
				$row[] = $t->id;
				$row[] = $no;
				$row[] = $t->month;
				$row[] = $t->target_amount;
				$data[] = $row;
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->campaign_target->count_all($id),
				"recordsFiltered" => $this->campaign_target->count_filtered($id),
				"data" => $data,
			);
			echo json_encode($output);
		} else {
			$data['menu'] = $this->menu;
			$data['rules'] = $this->menu['rule']['panel/campaign'];
			$data['data'] =   $this->campaign_model->find_by_id($id);
			$this->template->view('view_campaign_target', $data);
		}
	}

	public function find_target()
	{
		$data = $this->campaign_target->find_target($_POST['id']);
		echo json_encode($data);
	}

	public function insert_target($id)
	{
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['e']);
		if ($_POST && $auth) {
			$this->form_validation->set_rules('month', 'Month', 'required');
			$this->form_validation->set_rules('target', 'Target', 'required');
			$exist = $this->campaign_target->check_exist($id, $_POST['month']);
			if ($this->form_validation->run() == false && !$exist) {
				if ($exist) {
					$data['e']['month'] = form_error('month', '<div class="has-error">This month target is exist', '</div>');
				}
				$data['e']['month'] = form_error('month', '<div class="has-error">', '</div>');
				$data['e']['target'] = form_error('target', '<div class="has-error">', '</div>');
				$data['status'] = false;
				echo json_encode($data);
			} else {
				if ($this->campaign_target->insert($id, $_POST['month'], $_POST['target'])) {
					echo json_encode(array('status' => true));
				} else {
					echo json_encode(array('status' => false, 'msg' => 'Save to database error'));
				}
			}
		}
	}
	public function edit_target($id, $data_id)
	{
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['e']);
		$data['campaign'] = $this->campaign_model->find_by_id($id);
		if ($_POST && $auth) {
			$this->form_validation->set_rules('month', 'Month', 'required');
			$this->form_validation->set_rules('target', 'Target', 'required');
			$exist = $this->campaign_target->check_exist($id, $_POST['month'], $_POST['id']);
			if ($this->form_validation->run() == false && !$exist) {
				if ($exist) {
					$data['e']['month'] = form_error('month', '<div class="has-error">This month target is exist', '</div>');
				}
				$data['e']['month'] = form_error('month', '<div class="has-error">', '</div>');
				$data['e']['target'] = form_error('target', '<div class="has-error">', '</div>');
				$data['status'] = false;
				echo json_encode($data);
			} else {
				if ($this->campaign_target->insert($id, $_POST['month'], $_POST['target'])) {
					echo json_encode(array('status' => true));
				} else {
					echo json_encode(array('status' => false, 'msg' => 'Save to database error'));
				}
			}
		}
	}

	public function delete_target($id)
	{
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['e']);
		if ($_POST && $auth) {
			if ($this->campaign_target->delete($id)) {
				echo json_encode(array('status' => true));
			} else {
				echo json_encode(array('status' => false));
			}
		}
	}

	public function import_data($id)
	{
		set_time_limit(900);
		$form = $this->campaign_model->get_form($id);
		$form = json_decode($form);
		$call = array();
		for ($i = 0; $i < count($form); $i++) {
			$call[] = isset($form[$i]->call);
		}

		$this->load->library('upload');
		$path = '/uploads/' . date('Y-m-d-H_i_s') . '/';
		if (!is_dir($dir = 'assets' . $path)) {
			mkdir($dir);
		}
		$config['allowed_types'] = 'xlsx';
		$config['upload_path']   = $dir;

		$this->upload->initialize($config);
		if (!$this->upload->do_upload('file')) {
			echo json_encode(array('status' => 'ERROR', 'errors' => $this->upload->display_errors()));
		} else {
			$dataFile  = $this->upload->data();
			$file = 'assets' . $path . $dataFile['file_name'];
			$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
			$reader->open(FCPATH . '/' . $file);
			$data = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$index = 0;
				if ($sheet->getIndex() === 0) {
					//$rows = $sheet->getRowIterator();
					//print_r($rows);
					foreach ($sheet->getRowIterator() as $row) {
						$index++;
						$skip = false;
						if ($index == 1 && isset($_POST['header'])) {
							continue;
						} else {
							$data_row = array();
							for ($i = 0; $i < count($form); $i++) {
								$cell = '';
								if (isset($row[$i])) {
									if (is_object($row[$i])) {
										$cell = $row[$i]->format('Y-m-d H:i:s');
									} else {
										$cell = $row[$i];
									}
									if ($call[$i]) {
										$cell = str_replace(')', '', $cell);
										$cell = str_replace('(', '', $cell);
										$cell = str_replace('-', '', $cell);
										$cell = str_replace(' ', '', $cell);
										preg_match('/[0-9]+/', $cell, $match);
										if (count($match) > 0) {
											$number = $match[0];
											if (substr($number, 0, 2) == '62') {
												$data_row[] = '0' . substr($number, 2);
											} elseif (substr($number, 0, 1) != '0') {
												$data_row[] = '0' . $number;
											} else {
												$data_row[] = $number;
											}
										} else {
											$data_row[] = '-';
											$skip = true;
										}
									} else {
										$data_row[] = $cell;
									}
								}
							}
							if (!$skip) {
								$data[] = $data_row;
							}
						}
					}
				}
			}
			$reader->close();
			if (unlink($file)) {
				rmdir('assets' . $path);
			}
			$result = $this->data_campaign->insert_batch($id, $data);
			set_time_limit(30);
			echo json_encode($result);
		}
	}

	public function dashboard($id)
	{
		$data['menu'] = $this->menu;
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['v']);
		if ($_POST && $auth) {
		} else {
			$data['data'] = $this->campaign_model->detail_id($id);
			$data['rules'] = $this->menu['rule']['panel/campaign'];
			$data['id']		=	$id;
			$this->template->view('view_campaign_dashboard', $data);
		}
	}

	public function agents($id)
	{
		$data['menu'] = $this->menu;
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['e']);
		if ($_POST && $auth) {
			$list = $this->agent_campaign->get_load_agents($id);
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $agent) {
				$no++;
				$row = array();
				$row[] = $agent->assign_id;
				$row[] = $no;
				$row[] = $agent->adm_name;
				$row[] = $agent->adm_ext;
				$data[] = $row;
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->agent_campaign->count_all($id),
				"recordsFiltered" => $this->agent_campaign->count_filtered($id),
				"data" => $data,
			);
			echo json_encode($output);
		} else {
			$data['data'] = $this->campaign_model->detail_id($id);
			$data['agent_count'] = $this->agent_campaign->count_all($id);
			$data['in'] = $this->agent_campaign->agents_in($id);
			$data['rules'] = $this->menu['rule']['panel/campaign'];
			$data['not_in'] = $this->agent_campaign->agents_not_in($id);
			$this->template->view('view_campaign_agents', $data);
		}
	}

	public function submit_agents($id)
	{
		if (isset($_POST['to'])) {
			$data = array();
			foreach ($_POST['to'] as $value) {
				$data[] = array('adm_id' => $value, 'campaign_id' => $id);
			}
			if ($this->agent_campaign->insert($id, $data)) {
				echo json_encode(array('status' => true));
			} else {
				echo json_encode(array('status' => false, 'msg' => 'Add agent(s) failed, cannot insert to database.'));
			}
		} else {
			echo json_encode(array('status' => false, 'msg' => 'Add agent(s) failed, you don\'t select any data.'));
		}
	}

	public function delete_agents($id)
	{
		if ($_POST) {
			if ($this->agent_campaign->delete($id)) {
				echo json_encode(array('status' => true));
			} else {
				echo json_encode(array('status' => false));
			}
		}
	}

	public function assignment($id)
	{
		$data['menu'] = $this->menu;
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['e']);
		if ($_POST && $auth) {
			$form = $this->campaign_model->get_form($id);
			$form = json_decode($form);
			$list = $this->assign_campaign->get_load_data($id);
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $campaign) {
				$no++;
				$row = array();
				$row[] = $campaign->data_id;
				$row[] = $no;
				foreach ($form as $value) {
					if (!isset($value->editable)) {
						$row[] = $campaign->{'form_' . $value->name};
					}
				}
				$row[] = $campaign->adm_name;
				$data[] = $row;
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->assign_campaign->count_all($id),
				"recordsFiltered" => $this->assign_campaign->count_filtered($id),
				"data" => $data,
			);
			echo json_encode($output);
		} else {
			$data['data'] = $this->campaign_model->detail_id($id);
			$data['agent_count'] = $this->agent_campaign->count_all($id);
			$data['in'] = $this->assign_campaign->agents($id);
			$data['rules'] = $this->menu['rule']['panel/campaign'];
			//$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW CAMPAIGN ID: '.$id.' NAME: '.$data['data']->cus_name);
			$this->template->view('view_campaign_assign', $data);
		}
	}

	public function assign_to($id)
	{
		$data = array();
		$ids = explode(',', $_POST['data_id']);
		if (is_array($ids)) {
			for ($i = 0; $i < count($ids); $i++) {
				$data[] = array('data_id' => $ids[$i], 'assign_id' => $_POST['assign_id'], 'assign_date' => date('Y-m-d'), 'retries' => 0);
			}
		} else {
			$data[] = array('data_id' => $ids, 'assign_id' => $_POST['assign_id'], 'assign_date' => date('Y-m-d'), 'retries' => 0);
		}

		if ($this->assign_campaign->update_data($id, $data)) {
			echo json_encode(array('status' => true));
		} else {
			echo json_encode(array('status' => false));
		}
	}

	public function unassign_agents($id)
	{
		if ($_POST) {
			if ($this->assign_campaign->unassign_agents($id)) {
				echo json_encode(array('status' => true));
			} else {
				echo json_encode(array('status' => false));
			}
		}
	}

	public function auto_assign($id)
	{
		if ($this->assign_campaign->auto_assign($id)) {
			echo json_encode(array('status' => true));
		} else {
			echo json_encode(array('status' => false));
		}
	}


	public function report($id)
	{
		$data['menu'] = $this->menu;
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['v']);
		if ($_POST && $auth) {
			$form = $this->campaign_model->get_form($id);

			$sms_enabled = $this->campaign_model->is_sms_enabled($id);
			$wa_enabled = $this->campaign_model->is_wa_enabled($id);
			$form = json_decode($form);
			$this->report_campaign->normalize($id);
			$list = $this->report_campaign->get_load_data($id);
			/*echo '<pre>';
            print_r($list);
            echo '</pre>';*/
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $report) {
				$no++;
				$row = array();
				$row[] = $report->data_id;
				$row[] = $no;
				foreach ($form as $value) {
					$row[] = $report->{'form_' . $value->name};
				}
				if ($sms_enabled == 1) {
					$row[] = $report->sms_phone;
					$row[] = $report->sms_text;
					$row[] = !empty($report->sms_send_status) ? (substr($report->sms_send_status, -3) == '200' ? 'Send' : 'Failed') : '';
				}
				$row[] = !empty($report->called_phone) ? $report->called_phone : '';
				$row[] = !empty($report->adm_name) ? $report->adm_name : '';
				$row[] = !empty($report->caller) ? $report->caller : '';
				$row[] = !empty($report->retries) ? $report->retries : '';
				$row[] = !empty($report->call_date) ? $report->call_date : '';
				$row[] = !empty($report->api_status) ? $report->api_status : '';
				$row[] = !empty($report->call_status) ? $report->call_status : '';
				$row[] = !empty($report->status) ? $report->status : '';
				$row[] = !empty($report->ptp_date) ? $report->ptp_date : '';
				$row[] = !empty($report->ptp_amount) ? $report->ptp_amount : '';
				$row[] = !empty($report->duration) ? $report->duration : '';
				//$row[] = !empty($report->merchant_status)?$report->merchant_status:'&nbsp;';
				$row[] = !empty($report->note) ? $report->note : '';
				$row[] = '';
				$row[] = !empty($report->campaign_name) ? $report->campaign_name : '';
				if ($wa_enabled == 1) {
					$row[] = $report->status_wa;
				}
				$row[] = !empty($report->recordingfile) ? explode('/', $report->recordingfile)[count(explode('/', $report->recordingfile)) - 1] : '';
				$data[] = $row;
			}

			//echo $this->db->last_query();exit;
			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->report_campaign->count_all($id),
				"recordsFiltered" => $this->report_campaign->count_filtered($id),
				"data" => $data,
			);
			//echo $this->db->last_query();exit;
			echo json_encode($output);
		} else {
			$data['data'] = $this->campaign_model->detail_id($id);
			$data['assigns'] = $this->assign_campaign->agents($id);
			$data['agents'] = $this->agent_campaign->agents_in($id);
			$data['sms_enabled'] = $this->campaign_model->is_sms_enabled($id);
			$data['wa_enabled'] = $this->campaign_model->is_wa_enabled($id);
			$data['canchange'] = $this->menu['rule']['panel/campaign']['e'];
			$data['rules'] = $this->menu['rule']['panel/campaign'];

			//$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW CAMPAIGN ID: '.$id.' NAME: '.$data['data']->cus_name);
			$this->template->view('view_campaign_report', $data);
		}
	}

	public function change_status($id)
	{
		$auth = $this->template->set_auth($this->menu['rule']['panel/campaign']['e']);
		if ($_POST && $auth) {
			if ($this->data_campaign->set_status($id)) {
				echo json_encode(array('status' => true));
			} else {
				echo json_encode(array('status' => false));
			}
		} else {
			echo json_encode(array('status' => false));
		}
	}

	public function export($id)
	{
		$campaign = $this->campaign_model->detail_id($id);
		$form = json_decode($campaign->form);
		$list = $this->report_campaign->get_data_report($id);


		$border = (new BorderBuilder())
			->setBorderBottom(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
			->setBorderTop(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
			->setBorderLeft(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
			->setBorderRight(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
			->build();

		$tstyle = (new StyleBuilder())
			//->setShouldWrapText()
			//->setShouldShrinkToFit()
			//->setHorizontalAlignment(Style::H_ALIGN_CENTER)
			->build();

		$headstyle = (new StyleBuilder())
			->setBorder($border)
			->setFontBold()
			//->setShouldWrapText()
			//->setShouldShrinkToFit()
			//->setHorizontalAlignment(Style::H_ALIGN_CENTER)
			->build();
		$style = (new StyleBuilder())
			->setBorder($border)
			//->setShouldWrapText()
			//->setShouldShrinkToFit()
			//->setHorizontalAlignment(Style::H_ALIGN_CENTER)
			->build();

		$header = array();
		$header[] = 'No';
		$alpha = 'B';
		foreach ($_POST['col_name'] as $value) {
			if ($value != '0') {
				if ($value == 'Call Date') {
					$header[] = 'Call Date';
					$alpha++;
					$header[] = 'Cal Time';
					$alpha++;
				} else {
					$header[] = $value;
					$alpha++;
				}
			}
		}

		$writer = WriterFactory::create(Type::XLSX);
		$filename = 'campaign ' . strtolower($campaign->campaign_name) . ' report.xlsx';
		//header('Content-type: application/vnd.ms-excel');
		//header('Content-Disposition: attachment; filename="'.$filename.'"');
		//$writer->openToFile('php://output');
		//$writer->addMergeCell('A1',$alpha.'1');
		$writer->openToBrowser($filename);
		//$writer->addRow(['Data Report Campaign '.$campaign->campaign_name]);
		$writer->addRowWithStyle(['Data Report Campaign ' . $campaign->campaign_name], $tstyle);
		//echo json_encode($list);
		//exit;
		$writer->addRowWithStyle($header, $headstyle);


		$no = 0;
		$data = array();
		foreach ($list as $report) {
			$no++;
			$row = array();
			$row[] = $no;
			foreach ($_POST['col'] as $value) {
				if ($value == 'call_date') {
					$row[] = date('Y-m-d', strtotime($report->$value));
					$row[] = date('H:i:s', strtotime($report->$value));
				} else {
					if ($value == 'note') {
						$row[] = !empty($report->$value) ? str_replace('&nbsp', '', strip_tags($report->$value)) : '';
					} else if ($value == 'sms_send_status') {
						$row[] = !empty($report->$value) ? (substr($report->$value, -3) == '200' ? 'Send' : 'Failed') : '';
					} else if ($value != '0') {
						$row[] = !empty($report->$value) ? $report->$value : '';
					}
				}
			}
			//$row[] = !empty($report->merchant_status)?$report->merchant_status:'';

			$data[] = $row;
		}
		$writer->addRowsWithStyle($data, $style);
		$writer->close();
		exit;
	}

	public function export_data($id)
	{
		$campaign = $this->campaign_model->detail_id($id);
		$form = json_decode($campaign->form);
		$list = $this->report_campaign->get_data_report($id);


		$border = (new BorderBuilder())
			->setBorderBottom(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
			->setBorderTop(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
			->setBorderLeft(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
			->setBorderRight(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
			->build();

		$tstyle = (new StyleBuilder())
			//->setShouldWrapText()
			//->setShouldShrinkToFit()
			//->setHorizontalAlignment(Style::H_ALIGN_CENTER)
			->build();

		$headstyle = (new StyleBuilder())
			->setBorder($border)
			->setFontBold()
			//->setShouldWrapText()
			//->setShouldShrinkToFit()
			//->setHorizontalAlignment(Style::H_ALIGN_CENTER)
			->build();
		$style = (new StyleBuilder())
			->setBorder($border)
			//->setShouldWrapText()
			//->setShouldShrinkToFit()
			//->setHorizontalAlignment(Style::H_ALIGN_CENTER)
			->build();

		$header = array();
		$header[] = 'No';
		$alpha = 'B';
		foreach ($_POST['col_name'] as $value) {
			if ($value != '0') {
				$header[] = $value;
				$alpha++;
			}
		}

		$no = 0;
		$data = array();
		foreach ($list as $report) {
			$no++;
			$row = array();
			$row[] = $no;
			foreach ($_POST['col'] as $value) {
				if ($value != '0') {
					$row[] = !empty($report->$value) ? $report->$value : '';
				}
			}
			//$row[] = !empty($report->merchant_status)?$report->merchant_status:'';

			$data[] = $row;
		}

		$writer = WriterFactory::create(Type::XLSX);
		$filename = 'data campaign ' . strtolower($campaign->campaign_name) . '.xlsx';
		/*header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$filename.'"');*/
		//$writer->openToFile('php://output');
		//$writer->addMergeCell('A1',$alpha.'1');
		$writer->openToBrowser($filename);
		//$writer->addRow(['Data Report Campaign '.$campaign->campaign_name]);
		$writer->addRowWithStyle(['Data Report Campaign ' . $campaign->campaign_name], $tstyle);
		//echo json_encode($list);
		//exit;
		$writer->addRowWithStyle($header, $headstyle);
		$writer->addRowsWithStyle($data, $style);
		$writer->close();
		exit;
	}

	public function import()
	{
		echo '<pre>';
		print_r($_POST);
		echo '</pre>';
	}

	public function status_call()
	{
		$data['labels']     =   array();
		$data['datasets']   =   array();
		$datasets           =   '';
		$status_call    =   $this->dashboard_campaign->status_call($_GET);
		/*echo '<pre>';
        print_r($status_call);
        echo '</pre>';
        exit;*/
		for ($i = 0; $i < count($status_call); $i++) {
			if ($status_call[$i]->call_status == '') {
				$status_call[$i]->call_status = 'status empty';
			}

			$datasets = array(
				'fillColor'     =>  'rgba(220,220,220,0.5)',
				'strokeColor'   =>  'rgba(220,220,220,1)',
				'data'          =>  array($status_call[$i]->call_status_count)
			);
			array_push($data['labels'], $status_call[$i]->call_status);
			array_push($data['datasets'], $datasets);
		}
		/*echo '<pre>';
        print_r($data);
        echo '</pre>';*/
		echo json_encode(array('result' =>  $data));
	}

	public function status_data()
	{
		/*$data['labels']       =   array();
        $data['datasets']   =   array();*/
		$datasets           =   '';
		$status_call    =   $this->dashboard_campaign->status_data($_GET);
		for ($i = 0; $i < count($status_call); $i++) {
			if (trim($status_call[$i]->status) == '') {
				$status_call[$i]->status = 'status empty';
			}
			$datasets[$i] = array(
				'status'        =>  $status_call[$i]->status,
				'status_count'  =>  $status_call[$i]->status_count
			);
		}
		/*for ($i=0; $i < count($status_call); $i++) {
            if($status_call[$i]->status == ''){
                $status_call[$i]->status = 'status empty';
            }

            $datasets = array(
                'fillColor'     =>  'rgba(220,220,220,0.5)',
                'strokeColor'   =>  'rgba(220,220,220,1)',
                'data'          =>  array($status_call[$i]->status_count)
            );
            array_push($data['labels'],$status_call[$i]->status);
            array_push($data['datasets'],$datasets);
        }*/
		echo json_encode(array('result' =>  $datasets));
	}

	public function get_line_chart()
	{
		if ($_POST) {
			if ($_POST['type']   ==  'callperday') {
				$start_date_time    =   $_POST['start_date'] . ' ' . $_POST['start_time'];
				$end_date_time      =   $_POST['end_date'] . ' ' . $_POST['end_time'];
				$line_chart =    $this->dashboard_campaign->call_status_date($_POST['id'], $start_date_time, $end_date_time);
				echo json_encode(array('graph' => $line_chart));
			} else if ($_POST['type']  ==  'merchant_status') {
				$data = '';
				$datasets = '';
				$start_date_time    =   $_POST['start_date'] . ' ' . $_POST['start_time'];
				$end_date_time      =   $_POST['end_date'] . ' ' . $_POST['end_time'];
				$pie_chart  =   $this->dashboard_campaign->merchant_status($_POST['id'], $start_date_time, $end_date_time);

				/*echo '<pre>';
                print_r($pie_chart);
                echo '</pre>';
                exit;*/
				echo json_encode(array('graph'  =>  $pie_chart));
			}
		}
	}

	public function get_queue()
	{
		require_once APPPATH . 'libraries/phpagi/phpagi-asmanager.php';
		$asm = new AGI_AsteriskManager();
		if ($asm->connect()) {
			$result    =   $asm->Command("queue show");
			preg_match_all('/[0-9]+\s+has/', $result['data'], $match);
			$get_q_number   =    $match[0];
			$data = array();
			for ($i = 0; $i < count($get_q_number); $i++) {
				array_push($data, substr($get_q_number[$i], 0, -4));
			}
			echo json_encode(array('queue_id'   =>  $data));
			$asm->disconnect();
		}

		/*$queue_list =   $this->campaign_model->get_queue();
        return $queue_list;*/
	}

	public function wallboard($value)
	{
		$this->load->view('view_wallboard');
	}

	public function play($filename)
	{
		$url = str_replace('telmark/', '', base_url()) . 'api/recording/?key=jkHAK23kjhsd223klja677skajskkjsh&filename=' . $filename;
		$this->load->view('play', array('url' => $url));
	}

	public function test_data($id)
	{
		$data = $this->dashboard_campaign->get_agent_perform($id, 5, 'DESC');
		echo json_encode($data);
		echo $this->db->last_query();
	}
	public function remaining_data($id){


		$data['menu'] = $this->menu;
		if ($this->template->set_auth($this->menu['rule']['panel/campaign']['v'])) {
			$data['data'] = $this->campaign_model->detail_id($id);			
       		$data['form']  = $this->dashboard_campaign->form($id);
        /*   echo json_encode($performa); */
			//$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW CAMPAIGN ID: '.$id.' NAME: '.$data['data']->cus_name);
		}
		$data['id']=$id;
		$data['rules'] = $this->menu['rule']['panel/campaign'];
		$data['arr_outbound']     =   array('preview' => 'Preview Mode', 'predictive' => 'Predictive Mode');
		if($data['data']->outbound_type=='predictive')		
		$this->template->view('view_remain', $data);

	}

	   public function data_remaining($id)
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        $table = $this->dashboard_campaign->data_remaining($id);
        /*   echo json_encode($performa); */
        echo "data: {\n";
        echo "data: \"data\":" . json_encode($table) . "\n";
        echo "data: }\n\n";
    }



	   public function reply_data()
    {
    	$table = $this->dashboard_campaign->reply_data();  
    	echo json_decode($table);      
    }
}
