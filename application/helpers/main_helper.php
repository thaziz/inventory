<?php

function time_conversion($data){
	$hours = floor($data / 3600);
	if ($hours<=9) { $hours='0'.$hours; }
	$minutes = floor(($data / 60) % 60);
	if ($minutes<=9) { $minutes='0'.$minutes; }
	$seconds = $data % 60;
	if ($seconds<=9) { $seconds='0'.$seconds; }							
	$result = "$hours:$minutes:$seconds";
	return $result;
}

function assets(){
	return base_url('assets/');
}

function bootstrap(){
	return base_url('assets/bootstrap/');
}

function dist(){
	return base_url('assets/dist/');
}

function plugins(){
	return base_url('assets/plugins/');
}

function fonts(){
	return base_url('assets/fonts/');
}

function bower(){
	return base_url('assets/bower_components/');
}

function images($file_name){
	return base_url('assets/images/'.$file_name);
}

function succ_msg($msg)
{
    return '<div class="alert alert-success alert-dismissible auto-dismissed-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong><i class="icon fa fa-check"></i> Success!</strong>' . $msg . '.</div>';
}

function warn_msg($msg)
{
      return '<div class="alert alert-warning alert-dismissible auto-dismissed-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong><i class="icon fa fa-warning"></i> Warning!</strong>' . $msg . '.</div>';
}

function err_msg($msg)
{
    return '<div class="alert alert-danger alert-dismissible auto-dismissed-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong><i class="icon fa fa-ban"></i> Error!</strong>' . $msg . '.</div>';
}

function write_userlog($url,$text){
	$ci =& get_instance();

	$username = $ci->session->userdata('username');

	$conf = $ci->db->select('conf_value')->where('conf_string', 'write_user_log')->get('ttm_config', 1)->row();

	if($conf->conf_value==1){
		$ci->db->insert('ttm_userlog', 
						array('user'=>$username, 
							  'url'=>$url, 
							  'logger_text'=>$text, 
							  'date'=>date('Y-m-d H:i:s')
							)
					);
	}
}

function numbtotime($numb){
	if(!empty($numb)){
		$now = date_create(date('Y-m-d H:i:s'));
	    $ago = date_create(date('Y-m-d H:i:s',strtotime('+'.$numb.' seconds')));
	    $diff=date_diff($ago,$now);
	    //$diff = $now->diff($ago);
	    $string = array(
	        'h' => 'h', //used if you want to show hour
	        'i' => 'm',
	        's' => 's',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->format('%'.$k)) {
	            $v = ($diff->format('%'.$k)>9)?$diff->format('%'.$k):'0'.$diff->format('%'.$k);
	        } else {
	            $string[$k]='00';
	        }
	    }

	  return implode(':', $string);
	}else{
		return '';
	}
}

function write_file($file, $str){
	$fp = fopen($file, 'a')  or die("Can't create file");
	fwrite($fp, $str);
	fclose($fp);
}