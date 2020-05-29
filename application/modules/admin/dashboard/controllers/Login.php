<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller {

	/**
	 * 
	 */

	public function __construct(){
		$this->load->model('dashboard/login_model');
	}

	public function index()
	{
		if(isset($this->session->userdata['logged_in'])){
			$this->load->library('user_agent');
			$r = $this->menu_model->get_rules('admin');
			//echo json_encode($r['panel/my_campaign']);exit;
			if($r['panel']){
				redirect(base_url('panel/'));
			}elseif($r['panel/customer']){
				redirect(base_url('panel/customer'));
			}else{
				foreach ($r as $key => $value) {
					if($value){
						redirect(base_url($key));
					}
				}
			}
		}else{
			$data = array();
			if($_POST){
				if(trim($_POST['adm_login'])=='' || trim($_POST['password'])==''){
					$data['error'] = 'Fields must be filled';
				}else{
					$this->load->model('login_model');
					$data = $this->login_model->validate();
					//var_dump($data['data']);exit();
					if($data['valid']){
						$this->session->set_userdata('logged_in', true);
						$this->session->set_userdata($data['data']);
						//$this->userlog->add_log($this->session->userdata['name'], 'LOGIN');
					}
				}
				$data['adm_login'] = $_POST['adm_login'];
				//var_dump($data['valid']);exit();
				if(isset($data['valid']) && $data['valid']){
					redirect(base_url('panel'));
				}else{
					$this->load->view('view_login', $data);
				}
			}else{
				$this->load->view('view_login', $data);
			}
		}
	}

	public function captcha(){
		$this->load->helper('captcha');
		$vals = array(
					'img_width'     => '120',
        			'img_height'    => 30,
        			'word_length'   => 6,
        			'font_path'		=> 'assets/fonts/Caliban.ttf',
			        'img_path'      => './assets/captcha/',
			        'img_url'       => base_url('assets/captcha/'),
			        'pool' 			=> "ABCDEFGHJKLMNPRSTUVWXYZ2345689",
			        'colors'        => array(
			                'background' => array(0, 0, 0),
			                'border' => array(0, 0, 0),
			                'text' => array(255, 255, 255),
			                'grid' => array(50, 50, 50)
			        )
				);
		$this->session->unset_userdata('captcha');
		$cap = create_captcha($vals);
		$data = array(
			        'captcha_time'  => $cap['time'],
			        'ip'    => $this->input->ip_address(),
			        'word'          => $cap['word']
				);

		$this->session->set_userdata('captcha', $data);
		echo $cap['image'];
	}

	private function validate_captcha(){

		// First, delete old captchas
		$c = $this->session->userdata('captcha');
		$this->session->unset_userdata('captcha');
		return (strtoupper($_POST['captcha'])==$c['word'] && $this->input->ip_address()==$c['ip']);
	}

	public function logout(){
		$this->login_model->logout($this->session->userdata('id'));
		$this->session->sess_destroy();
		redirect(base_url('panel/'));
	}
}
