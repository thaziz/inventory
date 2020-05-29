<?php

class Page {

	public function change_page(){
		$ci =& get_instance();

		$ci->load->model('config_model');
		$timezone = $ci->config_model->get_config('base_timezone');
		$ci->gmapapikey = $ci->config_model->get_config('googlemap_api_key');

		date_default_timezone_set($timezone);

		$fs = 0;
		//if segment 1 in url is panel then set +1
		if($ci->uri->segment(1)=='panel'){
			$fs=1;
		}

		$islogin = null!==$ci->session->userdata('loggedin')?true:false;
		if($ci->uri->segment($fs+1) == 'logout' || $ci->uri->segment($fs+1) == 'media' || $ci->uri->segment($fs+1) == 'notif' || $ci->uri->segment($fs+2) == 'test' || $ci->uri->segment($fs+2) == 'changepass'){
			return;
		}else{
			if($islogin && $ci->uri->segment($fs+1) != 'login'){
				$controller = $ci->uri->segment($fs+1);
				if(empty($controller)){
					$controller = 'dashboard';
				}
				/*if($controller!='ticket' && null !=$ci->session->userdata('ticket')){
					$t = $ci->session->userdata('ticket');
					if(!isset($t['tick_id'])){
						$ci->session->unset_userdata('ticket');
					}
				}else{
					$flag = null!=$ci->uri->segment(2)?$ci->uri->segment(2)!='add':true;
					if($flag && !isset($t['tick_id'])){
						$ci->session->unset_userdata('ticket');
					}
				}*/
				$function = '';
				if(null!=$ci->uri->segment($fs+2)){
					$function = '/'.$ci->uri->segment($fs+2);
				}
				$name = str_replace('-', ' ', str_replace('-', ' ', $controller));
				$ci->menu = $ci->menu_model->load_menu('admin', $name);
				if($ci->uri->segment($fs+2) != 'profile' && $ci->uri->segment($fs+2) != 'profile-edit' && $ci->uri->segment($fs+1) != 'api'){
					if(!isset($ci->menu['rule'][$controller]) && !isset($ci->menu['rule'][$controller.$function])){
						show_404();
					}
				}
				return;
			}else if(!$islogin && $ci->uri->segment($fs+1) != 'login'){
				redirect(base_url('login'));
			}else if(!$islogin && $ci->uri->segment($fs+1) == 'login'){
				return;
			}else if($islogin && $ci->uri->segment($fs+1) == 'login'){
				redirect(base_url());
			}
		}
		/*if($ci->uri->segment(1) == 'login') {
			exit;
		    //return;
		}else{

		}*/
	}

}
