<?php

function assign_email($assign_id){
	$ci =& get_instance();
	$ci->load->database();

	$ci->db->select('c.username, b.assign_by, c.avatar, b.user_id, b.group_id, b.assign_time, a.irt_time, a.due_time, a.subject, a.ticket_id, d.topic_name, e.cat_name, a.severety, b.note, a.ticket_desc, f.lat, f.lng, f.address, g.customer_name');
	$ci->db->join('ttm_assignment b', 'b.asg_id=a.curr_assign');
	$ci->db->join('ttm_user c', 'c.user_id=b.assign_by');
	$ci->db->join('ttm_ticket_topic d', 'd.top_id=a.topic_id');
	$ci->db->join('ttm_ticket_category e', 'e.cat_id=d.cat_id');
	$ci->db->join('ttm_service_customer f', 'f.sc_id=a.sc_id');
	$ci->db->join('ttm_customer g', 'g.cus_id=f.cus_id');
	$ci->db->where('b.asg_id', $assign_id);
	$detail = $ci->db->get('ttm_ticket a', 1)->row();
	$data = array();
	foreach ($detail as $key => $value) {
		$data[$key] = $value;
	}

	switch (strtolower($detail->severety)) {
		case 'high':
			$data['label'] = 'label-danger';
			break;
		case 'normal':
			$data['label'] = 'label-warning';
			break;
		case 'low':
			$data['label'] = 'label-info';
			break;
		default:
			$data['label'] = 'label-default';
			break;
	}

	$users = array();

	if($detail->user_id!=0){
		$data['msg'] = 'you';
		$data['to_url'] = 'user/detail/'.$detail->user_id;
		$users = $ci->db->select('username, email')->where('user_id', $detail->user_id)->get('ttm_user')->result();
		$data['assignee'] = $users[0]->username;
	}else if($detail->user_id==0 && $detail->group_id!=0){
		$data['msg'] = 'your group';
		$data['to_url'] = 'group/detail/'.$detail->user_id;
		$users = $ci->db->select('username, email')->where('group_id', $detail->group_id)->get('ttm_user')->result();
		$group = $ci->db->select('group_name')->where('group_id', $detail->group_id)->get('ttm_user_group',1)->row();
		$data['assignee'] = $group->group_name;
	}

	$ci->load->model('config_model');
	$cmail = $ci->config_model->get_config_in_group(2);
	$config = array('useragent'=>'PHPMailer', 'protocol'=>'smtp', 'mailpath'=>'/usr/sbin/sendmail', 'mailtype' => 'html');
	$d = array();
	foreach ($cmail as $key => $value) {
		if($value->conf_string!='use_smtp_server' && $value->conf_string!='mail_from' && $value->conf_string!='mail_name'){
			$config[$value->conf_string] = $value->conf_value;
		}else{
			$d[$value->conf_string] = $value->conf_value;
		}
	}

	$ci->load->library('email');
    $ci->email->initialize($config);

    $useremail = array();
	foreach($users as $user){
		$useremail[] = $user->email;
	}

	if(count($useremail)>0){
		$ci->email->from($d['mail_from'], $d['mail_name']);
        $ci->email->to($useremail);
        // $ci->email->cc('another@another-example.com');
        // $ci->email->bcc('them@their-example.com');
        $ci->email->subject('[IOS INFOKOM] ('.$detail->ticket_id.') '.$detail->subject);

        $html_content = $ci->load->view('email_format', $data, true);

        $ci->email->message($html_content);
        $ci->email->send();
	}
}

function response_email($data){
	$ci =& get_instance();
	$ci->load->model('config_model');
	$cmail = $ci->config_model->get_config_in_group(2);
	$config = array('useragent'=>'PHPMailer', 'protocol'=>'smtp', 'mailpath'=>'/usr/sbin/sendmail', 'mailtype' => 'html');
	$d = array();
	foreach ($cmail as $key => $value) {
		if($value->conf_string!='use_smtp_server' && $value->conf_string!='mail_from' && $value->conf_string!='mail_name'){
			$config[$value->conf_string] = $value->conf_value;
		}else{
			$d[$value->conf_string] = $value->conf_value;
		}
	}
	//echo json_encode($config).'<br>';
	//echo json_encode($d);
	$ci->load->library('email');
    $ci->email->initialize($config);

    $subject = $data['subject'];
	$message = $data['message'];

	// Get full html:
	$html_content = $ci->load->view('email_response', array('message'=>$message), true);
	// Also, for getting full html you may use the following internal method:
	//$body = $this->email->full_html($subject, $message);

	$result = $ci->email
	    ->from($d['mail_from'], $d['mail_name'])
	    ->to($data['mail_to'])
	    ->subject($subject)
	    ->message($html_content)
	    ->send();

	//var_dump($result);
	//echo '<br />';
	//echo $ci->email->print_debugger();

	//exit;
	    return $result;
}