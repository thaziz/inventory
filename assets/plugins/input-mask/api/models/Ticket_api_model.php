<?php

class Ticket_api_model extends CI_Model {

   private $pref = '';
   var $table = 'v_ticket';

   public function __construct(){
       parent::__construct();
       $this->load->database();
       $this->table = $this->pref.$this->table;
   }

   public function load_tickets($menu_role=array()){
        /*$this->menu_role = $menu_role;*/
        $this->db->select('e.username as assign_user, e.user_id, e.group_id, e.groupname as assign_group, e.assign_time, e.is_read as c_read, a.open_by_name, a.*');
        //$this->db->join('v_customer b', 'b.cus_id=a.cus_id');
        $this->query_join();
        $this->query_where();

        if(isset($_POST['curr_assign']) && ($_POST['curr_assign']!='' || $_POST['curr_assign']!=0)){
            $this->db->where('e.user_id', $_POST['curr_assign']);
        }
        //$this->db->or_where('e.open_by', $userid);
        $res = $this->db->get('v_ticket a');

        
        if(isset($_POST['start'])){
            $page = $_POST['start'];
        }
        $q = $this->db->query($this->db->last_query().' LIMIT '.(isset($page)?$page:'0').',10');

        $_res = $q->result();
        $data = array('data'=>array(), 'open'=>0, 'closed'=>0, /*'solved'=>0*/);
        foreach ($_res as $key => $value) {
            //if($value->user_id==0){
                //$value->assign_user = $value->assign_group;
            //}
            $data['data'][] = $value;
        }
        $sql_count ="COUNT(case when (a.status='OPEN') then a.id end) as open, ";
        $sql_count .="COUNT(case when a.status='CLOSED' then a.id end) as closed, ";
        $sql_count .="COUNT(case when (a.status<>'CLOSED' AND a.need_callback=1) then a.id end) as callback, ";
        //$sql_count .="COUNT(case when a.status='SOLVED' then a.tick_id end) as solved, ";
        $this->db->select($sql_count, false);
        $this->query_join();
        $this->query_where();
        if(isset($_POST['curr_assign']) && ($_POST['curr_assign']!='' || $_POST['curr_assign']!=0)){
            $this->db->where('e.user_id', $_POST['curr_assign']);
        }
        $count = $this->db->get('v_ticket a', 1)->row();
        //$data['query_count'] = $this->db->last_query();
        $data['open'] = $count->open;
        $data['closed'] = $count->closed;
        $data['callback'] = $count->callback;
        //$data['solved'] = $count->solved;
        //$data['total_page'] = $q->num_rows();
        $data['total_rows'] = $res->num_rows();
        return $data;
    }

    private function query_join(){        
        $this->db->join('v_ticket_assignment e', 'e.assign_id=a.curr_assign', 'left');
        $this->db->join("(SELECT ticket_id, max(time) time, is_read FROM `v_ticket_history` WHERE `activity` NOT LIKE 'Create%' AND `activity` NOT LIKE 'Assign%' AND `activity` NOT LIKE 'Close%' AND `activity` NOT LIKE 'Reply%' AND `activity` NOT LIKE 'Reopen%' GROUP BY ticket_id) com", 'a.id=com.ticket_id', 'left');
        
    }

    private function query_where(){
        $this->db->where('a.type',$_POST['type']);
        /*if(!$this->menu_role['v'] && !$this->menu_role['a'])
            $this->db->where('e.group_id', $groupid);
*/
        if(isset($_POST['adv_search'])){
            $this->search_advance($_POST['adv_search']);
        }

        if(isset($_POST['filter'])){
            $this->filter($_POST['filter']);
        }

        if(isset($_POST['order'])){
            $this->order($_POST['order']);
        }
    }

    private function search_advance($search){   
        if(!empty($search['ti'])){ 
            switch ($search['opt_ti']) {
                case 'exact':
                    $this->db->where('a.ticket_id', $search['ti']); 
                    break;
                case 'begins with':
                    $this->db->like('a.ticket_id', $search['ti'], 'after'); 
                    break;
                
                case 'ends with':
                    $this->db->like('a.ticket_id', $search['ti'], 'before'); 
                    break;
                
                case 'contain':
                    $this->db->like('a.ticket_id', $search['ti'], 'both'); 
                    break;
                
                default:
                    $this->db->where('a.ticket_id', $search['ti']);
                    break;
            }
            
        }
        if(!empty($search['cn'])){ 
            switch ($search['opt_cn']) {
                case 'exact':
                    $this->db->where('a.cus_fname', $search['cn']); 
                    break;
                case 'begins with':
                    $this->db->like('a.cus_fname', $search['cn'], 'after'); 
                    break;
                
                case 'ends with':
                    $this->db->like('a.cus_fname', $search['cn'], 'before'); 
                    break;
                
                case 'contain':
                    $this->db->like('a.cus_fname', $search['cn'], 'both'); 
                    break;
                
                default:
                    $this->db->where('a.cus_fname', $search['cn']);
                    break;
            }
        }
        if(!empty($search['eml'])){ 
            switch ($search['opt_eml']) {
                case 'exact':
                    $this->db->where('a.email', $search['eml']); 
                    break;
                case 'begins with':
                    $this->db->like('a.email', $search['eml'], 'after'); 
                    break;
                
                case 'ends with':
                    $this->db->like('a.email', $search['eml'], 'before'); 
                    break;
                
                case 'contain':
                    $this->db->like('a.email', $search['eml'], 'both'); 
                    break;
                
                default:
                    $this->db->where('a.email', $search['eml']);
                    break;
            }
        }
        if(!empty($search['openby'])){ 
            $this->db->where('a.open_by', $search['openby']); 
        }
        /*if(!empty($search['topid'])){ 
            $this->db->where('a.topic_id', $search['topid']); 
        }*/
        if(!empty($search['sub'])){ 
            switch ($search['opt_sub']) {
                case 'exact':
                    $this->db->where('a.subject', $search['sub']); 
                    break;
                case 'begins with':
                    $this->db->like('a.subject', $search['sub'], 'after'); 
                    break;
                
                case 'ends with':
                    $this->db->like('a.subject', $search['sub'], 'before'); 
                    break;
                
                case 'contain':
                    $this->db->like('a.subject', $search['sub'], 'both'); 
                    break;
                
                default:
                    $this->db->where('a.subject', $search['sub']);
                    break;
            }
            
        }
        if(!empty($search['maincat'])){
            $this->db->where('a.main_category', $search['maincat']);
        }
        if(!empty($search['cat'])){
            $this->db->where('a.category', $search['cat']);
        }
        if(!empty($search['s_date'])){
            $date = explode(' - ', $search['s_date']);
            $this->db->where('a.open_date >=', date('Y-m-d 00:00:00', strtotime($date[0])));
            $this->db->where('a.open_date <=', date('Y-m-d 23:59:59', strtotime($date[1])));
        }
        if(!empty($search['phone'])){
            $this->db->where('a.cus_phone', $search['phone']);
        }
    }

    private function filter($fil){
        $userid = $this->session->userdata('user_id');
        $groupid = $this->session->userdata('group_id');
        switch (strtolower($fil)) {
            case 'assign to group':
                //$this->db->where('e.group_id', $groupid);
                break;
            case 'callback tickets':
                $this->db->where(array('a.status<>'=> 'CLOSED'));                
                /*$this->db->group_start();
                $this->db->where('e.user_id', $userid);
                $this->db->or_where('e.group_id', $groupid);
                $this->db->group_end();*/
                break;
            case 'closed tickets':
                $this->db->where('a.status', 'CLOSED');                
                /*$this->db->group_start();
                $this->db->where('e.user_id', $userid);
                $this->db->or_where('e.group_id', $groupid);
                $this->db->group_end();*/
                break;
            case 'open tickets':
                $this->db->where(array('a.status'=> 'OPEN'));
                /*$this->db->group_start();
                $this->db->where('e.user_id', $userid);
                $this->db->or_where('e.group_id', $groupid);
                $this->db->group_end();*/
                break;
            case 'unread ticket':
                $this->db->where('a.is_read', 0);                
                /*$this->db->group_start();
                $this->db->where('e.user_id', $userid);
                $this->db->or_where('e.group_id', $groupid);
                $this->db->group_end();*/
                break;   
            case 'unread comment':
                $this->db->where('com.is_read', 0);                
                $this->db->where('com.is_read<>', NULL);                
                /*$this->db->group_start();
                $this->db->where('e.user_id', $userid);
                $this->db->or_where('e.group_id', $groupid);
                $this->db->group_end();*/
                break;     
            default:
                break;
        }
    }

    private function order($order){
        if(!isset($_POST['ortype'])){
            $_POST['ortype'] = 'ASC';
        }
        
        switch (strtolower($order)){
            case 'create date':
                $order = 'a.open_date';
                break;
            case 'status':
                $order = 'a.status';
                break;
            case 'country of origin':
                $order = 'a.country_origin';
                break;
            case 'city':
                $order = 'a.city_one';
                break;
            case 'customer name':
                $order = 'a.cus_fname';
                break; 
            case 'latest comment':
                $order = 'com.time';
                break;            
            default:
                $order = 'a.open_date';
                break;
        }
        $this->db->order_by($order.' '.strtoupper($_POST['ortype']));
    }

    public function get_detail($id){
        $this->db->select('a.id, a.ticket_id as ticket_code, a.*,b.*, IFNULL(a.cus_phone, c.cus_phone) as phone',false);
        $this->db->where('a.ticket_id', $id);
        $this->db->join('v_ticket_assignment b', 'a.curr_assign=b.assign_id', 'left');
        $this->db->join('v_customer c', 'c.cus_id=a.cus_id', 'left');
        $data['data'] = $this->db->get($this->table.' a', 1)->row();

        $assign = $this->db->select('user_id, username, is_email')->where(array('ticket_id'=>$data['data']->id, 'assign_id'=>$data['data']->curr_assign))
                    ->get('v_ticket_assignment',1);

        if($assign->num_rows()>0 && $assign->row()->is_email){
            $data['email_assign'] = $assign->row()->username;
        }else if($assign->num_rows()>0 && !$assign->row()->is_email){
            $agent = $this->db->where('id',$assign->row()->user_id)->get('v_assignment_list',1);
            if($assign->num_rows()>0)
                $data['email_assign'] = $agent->row()->email;
        }
        //$this->db->join($this->pref.'ticket_history c', 'c.ticket_id=a.tick_id');
        //$this->db->join($this->pref.'ticket_comment d', 'd.ticket_id=a.tick_id');

        if(isset($_GET['reply'])){
            $this->db->where(array('ticket_id'=>$data['data']->id, 'is_read'=>0))->update('v_email_customer', array('is_read'=>1));
        }

        //$this->db->where(array('id'=>$data['data']->id))->update('v_ticket', array('is_read'=>1));
        
        $data['history'] = $this->get_ticket_history($data['data']->id);
        $data['email_customer'] = $this->get_email_history($data['data']->id);

        $data['chat_history'] = $this->get_chat_history($data['data']->id);
        //$data['history'] = $this->get_ticket_history($id);
        //$this->set_ticket_read($data['data']->tick_id, $mygroupid, 1);
        remove_notif((isset($_GET['issabel_user'])?$_GET['issabel_user']:0),$id);
        return $data;
    }

    public function get_ticket_comments($ticket_id, $id = false){
        $this->db->select('a.comment_id, a.user_id, a.username, b.avatar, a.create_time, a.comment_text, i.comment_id child_id, i.username child_name, i.user_id cuser_id, j.avatar cavatar, i.create_time child_time, i.comment_text child_text', false);
        $this->db->join('v_user b', 'b.user_id=a.user_id','left');
        $this->db->join('v_ticket c', 'c.id=a.ticket_id');
        $this->db->join('v_ticket_comment i', 'i.parent_id=a.comment_id','left');
        $this->db->join('v_user j', 'j.user_id=i.user_id','left');
        $this->db->where('a.parent_id', 0);            
        
        if($id){
            $this->db->where('c.tick_id', $ticket_id);            
        }else{
            $this->db->where('c.ticket_id', $ticket_id);
        }
        $_res = $this->db->get('v_ticket_comment a')->result();
        $_data = array();
        foreach ($_res as $val) {
            $val->create_time = to_elapsed($val->create_time);
            $_data[$val->comment_id]['comment_id'] = $val->comment_id;
            $_data[$val->comment_id]['avatar'] = $val->avatar;
            $_data[$val->comment_id]['user_id'] = $val->user_id;
            $_data[$val->comment_id]['username'] = $val->username;
            $_data[$val->comment_id]['create_time'] = $val->create_time;
            $_data[$val->comment_id]['comment_text'] = $val->comment_text;
            if($val->file_path!=null){
                if(strpos($val->mime_type, 'image')!==false){
                    $_data[$val->comment_id]['images'][] = array('file_id'=>$val->file_id,'file_path'=>$val->file_path, 'file_name'=>$val->file_name);
                }else{
                    $_data[$val->comment_id]['file'][] = array('file_id'=>$val->file_id, 'file_path'=>$val->file_path,
                                                'file_name'=>$val->file_name);
                }
            }
            if($val->child_id!=null){
                $_data[$val->comment_id]['child'][$val->child_id]['cuser_id'] = $val->cuser_id;
                $_data[$val->comment_id]['child'][$val->child_id]['child_name'] = $val->child_name;
                $_data[$val->comment_id]['child'][$val->child_id]['cavatar'] = $val->cavatar;
                $_data[$val->comment_id]['child'][$val->child_id]['child_time'] = to_elapsed($val->child_time);
                $_data[$val->comment_id]['child'][$val->child_id]['child_text'] = $val->child_text;
                
            }else{
                $_data[$val->comment_id]['child'] = array();
            }
        }
        $data = array();
        foreach ($_data as $key => $value) {
            $child = array();
            foreach ($value['child'] as $key => $val) {
                $child[] = $val;
            }
            $value['child'] = $child;
            $data[] = $value;
        }
        return $data;
    }

    public function get_ticket_history($ticket_id){
        $this->db->where(array('ticket_id'=>$ticket_id, 'is_read'=>0))->update('v_ticket_history', array('is_read'=>1));
        $this->db->select('a.history_id,a.user_id, a.username,b.avatar, a.activity, a.time');
        $this->db->join('v_user b', 'b.user_id=a.user_id','left');
        $this->db->where('a.ticket_id',$ticket_id);
        $this->db->order_by('a.time','desc');
        $_res = $this->db->get('v_ticket_history a')->result();
        return $_res;
    }


    public function get_chat_history($ticket_id){
        $this->db->where('ticket_id',$ticket_id);        
        $this->db->order_by('wa_id','asc');
        return $this->db->get('whatsapp_chat')->result();

        
    }

    public function get_email_history($ticket_id){
        $this->db->select('a.id,IF(a.username=\'\', a.email, a.username) as name, a.time, a.content, a.attachment, a.is_read');
        $this->db->where('a.ticket_id',$ticket_id);
        $this->db->order_by('a.time','desc');
        $_res = $this->db->get('v_email_customer a')->result();
        $data = array();
        foreach ($_res as $key => $v) {
            if(!empty($v->attachment)){
                $attach = explode(',', $v->attachment);
                $v->content .= '<br><br>';
                foreach ($attach as $key => $value) {
                    $file = $this->db->select('filepath, filename')->where('id',trim($value))->get('v_attachment',1);
                    $filename = '';
                    $filepath = '';
                    if($file->num_rows()>0){
                        $file =$file->row();
                        $filepath = $file->filepath;
                        $filename = $file->filename;
                        $v->content.='<a class="attachment_file" href="'.base_url($filepath).'" target="_blank">'.$filename.'</a>';
                    }/*else{
                        $filepath = $value;
                        $filename = explode('/',$value)[count(explode('/',$value))-1];
                    }*/
                }
            }
            $data[] = $v;
        }
        return $data;
    }

    public function get_ticket_by_id($ticket_id){
        $query = $this->db->select('id')->where('ticket_id',$ticket_id)->get('v_ticket',1);
        if($query->num_rows()>0){
            return $query->row();
        }else{
            return false;
        }
    }

    public function save_assign(){
        if(!empty($_POST['assign_to'])){
            $assignment = $this->db->where('id',$_POST['assign_to'])->get('v_assignment_list',1)->row_array();
            $email_assign = $assignment['email'];
            $assignment['is_email'] = 0;
        }else{
            $email_assign = $_POST['email_assign'];
            $assignment['is_email'] = 1;
            $assignment['user_ext'] = 0;
            $assignment['name'] = $_POST['email_assign'];
        }
        $cc = isset($_POST['cc'])?$_POST['cc']:'';
        $bcc = isset($_POST['bcc'])?$_POST['bcc']:'';
        $agent = $this->db->where('number', $_POST['user_id'])->get('call_center.agent',1)->row();
        $time = date('Y-m-d H:i:s');
        $assign_to = $_POST['assign_to'];
        foreach (explode(',',$_POST['tick_ids']) as $key => $value) {
            $assign = array(
                'ticket_id'=>$value,
                'assign_by'=>$agent->number,
                'assign_by_name'=>isset($agent->name)?$agent->name:$agent->number,
                'user_id'=>$assign_to,
                'username'=>$assignment['name'],
                'user_ext'=>$assignment['user_ext'],
                'is_email'=>$assignment['is_email'],
                'assign_time'=>$time,
            );
            $ticket = $this->db->select('ticket_id, main_category, subject, content, brand, category, sub_category, type')->where('id', $value)->get('v_ticket', 1)->row();

            $email = array(
                'ticket_id'=>$ticket->ticket_id,
                'main_category'=>!empty($ticket->main_category)?$ticket->main_category:'enquiry',
                'subject'=>$ticket->subject,
                'category'=>$ticket->category,
                'assign_by'=>isset($agent->name)?$agent->name:$agent->number,
                'assignee'=>$assignment['name'],
                'assign_time'=>date('d F Y H:i:s', strtotime($time)),
                'due_time'=>date('d F Y H:i:s', strtotime($time. ' +1 days')),
                'content'=>$ticket->content,
            );
            if($ticket->type=='KANMO'){
                $email['brand'] = $ticket->brand;
                $email['sub_category'] = $ticket->sub_category;
            }

            $file = '';
            $attach = array();
            if(isset($_POST['attachments']) && !empty($_POST['attachments'])){
                $files = $this->get_files($_POST['attachments']);
                $file = '';
                foreach ($files as $key => $value) {
                    $attach[] = FCPATH.$value;
                    $f = explode('/', $value);
                    $file.='<a href="'.base_url($value).'" class="file-attachment" target="_blank">'.$f[count($f)-1].'</a><br>';
                }
            }
            
            if($this->db->insert('v_ticket_assignment',$assign)){
                $assign_id = $this->db->insert_id();
                $this->db->where('id',$value)->update('v_ticket',array('curr_assign'=>$assign_id));
                $note = strip_tags($_POST['assign_note']);
                $history = array(
                    'ticket_id'=>$value,
                    'assign_id'=>$assign_id,
                    'user_id'=>$agent->number,
                    'username'=>isset($agent->name)?$agent->name:$agent->number,
                    'time'=>$time,
                    'cc'=>$cc,
                    'bcc'=>$bcc,
                    'activity'=>'Assign ticket to '.$assignment['name'].'.'.(!empty($note)?'<br><b>Note:</b><br>'.$_POST['assign_note']:'').(!empty($file)?'<br><b>Attachmet:</b><br>'.$file:''),
                );
                $flag = $this->db->insert('v_ticket_history', $history);

                if($assignment['user_ext']!=0){
                    write_notif($assignment['user_ext'], 'menu='.strtolower($ticket->type).'_ticket&action=detail&id='.$ticket->ticket_id, $ticket->ticket_id, 'Ticket <strong>'.$ticket->ticket_id.'</strong> is assigned to you', $time);
                }
                $this->load->helper('mail');
                $from = array('email'=>'club.indonesia@nespresso.co.id', 'name'=>'Nespresso');
                if(strtolower($ticket->type)=='kanmo'){
                    $from = array('email'=>'support@kanmogroup.com', 'name'=>'Kanmo Retail');
                }
                $email['note'] = $note;
                assign_email($from, $email_assign,$email, strtolower($ticket->type), false, $cc, $bcc, $attach);
            }
        }
        return true;
    }

    public function save_reply(){
        $agent = $this->db->where('number', $_POST['user_id'])->get('call_center.agent',1)->row();
        $time = date('Y-m-d H:i:s');

        $ticket = $this->db->select('ticket_id, main_category, subject, content, category, sub_category, type, curr_assign')->where('id', $_POST['tick_ids'])->get('v_ticket', 1)->row();
        $email = $_POST['reply_note'];

        $user_ext = $this->db->select('user_id, username, is_email')->where(array('ticket_id'=>$_POST['tick_ids'], 'assign_id'=>$ticket->curr_assign))
                    ->get('v_ticket_assignment',1)->row();
        if($user_ext->is_email==0){
            $assign = $this->db->select('email')->where(array('id'=>$user_ext->user_id))->get('v_assignment_list',1)->row();
            $email_assign = $assign->email;
        }else{
            $email_assign = $user_ext->username;
        }        

        $file = '';
        $attach = array();
        if(isset($_POST['attachments']) && !empty($_POST['attachments'])){
            $files = $this->get_files($_POST['attachments']);
            $file = '';
            foreach ($files as $key => $value) {
                $attach[] = FCPATH.$value;
                $f = explode('/', $value);
                $file.='<a href="'.base_url($value).'" class="file-attachment" target="_blank">'.$f[count($f)-1].'</a><br>';
            }
        }

        $thistory = '';

        if(isset($_POST['send_history'])){
            $ticket_history = $this->db->select('username, time, activity')->where('ticket_id', $_POST['tick_ids'])->get('v_ticket_history')->result();

            foreach ($ticket_history as $key => $h) {
                $thistory = '<hr><div class="history" style="border-left:1px solid #ccc;padding-left:5px;">On '.date('D, d F Y H:i A', strtotime($h->time)).' '.$h->username.':<br>'.$h->activity.$thistory.'</div>';
            }
        }
        
        $history = array(
            'ticket_id'=>$_POST['tick_ids'],
            'assign_id'=>0,
            'user_id'=>$agent->number,
            'username'=>isset($agent->name)?$agent->name:$agent->number,
            'is_reply'=>1,
            'cc'=>$_POST['cc'],
            'bcc'=>$_POST['bcc'],
            'time'=>$time,
            'activity'=>'Reply email to :'.$_POST['to'].'<br>Message:<br>'.$email.$file,
        );


        $flag = $this->db->insert('v_ticket_history', $history);

        
        $this->load->helper('mail');
        $from = array('email'=>'club.indonesia@nespresso.co.id', 'name'=>'Nespresso');
        if(strtolower($ticket->type)=='kanmo'){
            $from = array('email'=>'support@kanmogroup.com', 'name'=>'Kanmo Retail');
        }
        
        //reply_email($from, $email, $ticket_id, $subject, $cc, $bcc, $data, $type='kanmo')
        reply_email($from, $_POST['to'],$ticket->ticket_id, $_POST['subject'], $_POST['cc'], $_POST['bcc'], $email.'<br><div>'.$thistory.'</div>', strtolower($ticket->type), $attach);
        
        return true;
    }

    public function save_reply_customer(){
        $agent = $this->db->where('number', $_POST['user_id'])->get('call_center.agent',1)->row();
        $time = date('Y-m-d H:i:s');

        $ticket = $this->db->select('ticket_id, main_category, subject, content, category, sub_category, type, curr_assign')->where('id', $_POST['tick_ids'])->get('v_ticket', 1)->row();

        //$email_trail = $this->db->select('email, cc, time, content_as_is')->where('ticket_id', $_POST['tick_ids'])->order_by('time', 'desc')->get('v_email_customer', 1);

        /*if($email_trail->num_rows()>0){
            $email_trail = $email_trail->row()->content_as_is;
            $email_trail = preg_replace('/\nOn(.*?)> wrote:(.*?)$/si', "<div class=\"blockquote\">$0</div>", $email_trail);
            $email_trail = preg_replace('/\nPada(.*?)> menulis:(.*?)$/si', "<div class=\"blockquote\">$0</div>", $email_trail);
        }else{
            $email_trail = '';
        }*/

        $file = '';
        $attach = array();
        if(isset($_POST['attachments']) && !empty($_POST['attachments'])){
            $files = $this->get_files($_POST['attachments']);
            $file = '';
            foreach ($files as $key => $value) {
                $attach[] = FCPATH.$value;
                $f = explode('/', $value);
                $file.='<a href="'.base_url($value).'" class="file-attachment" target="_blank">'.$f[count($f)-1].'</a><br>';
            }
        }

        $email = $_POST['reply_customer_note'];

        $from = array('email'=>'club.indonesia@nespresso.co.id', 'name'=>'Nespresso');

        if(strtolower($ticket->type)=='kanmo'){
            $from = array('email'=>'support@kanmogroup.com', 'name'=>'Kanmo Retail');
        }

        $email_history = $this->db->select('email, time, content')->where(array('ticket_id'=> $_POST['tick_ids']))->get('v_email_customer')->result();
        
        $data = array(
            'ticket_id'=>$_POST['tick_ids'],
            'user_id'=>$agent->number,
            'username'=>isset($agent->name)?$agent->name:$agent->number,
            'email_to'=>$_POST['to'],
            'email'=>$from['email'],
            'subject'=>$_POST['subject'],
            'cc'=>$_POST['cc'],
            'bcc'=>$_POST['bcc'],
            'time'=>$time,
            'content'=>$email.$file,
            //'attachment'=>$email,
            'is_read'=>1,
        );
        if($this->db->insert('v_email_customer', $data)){
            $this->db->where(array('ticket_id'=>$_POST['tick_ids'], 'user_id'=>0, 'is_read<'=>2))->update('v_email_customer', array('is_read'=>2, 'reply_time'=>$time));
        }

        //$email_history = $this->db->select('email, time, content')->where(array('ticket_id'=> $_POST['tick_ids']))->get('v_email_customer')->result();
        $thistory = '';
        foreach ($email_history as $key => $h) {

            $thistory = '<hr><div class="history" style="border-left:1px solid #ccc;padding-left:5px;">On '.date('D, d F Y H:i A', strtotime($h->time)).' '.$h->email.':<br>'.$h->content.$thistory.'</div>';
        }

        
        $this->load->helper('mail');
        reply_email_customer($from, $_POST['to'],$_POST['cc'],$_POST['bcc'], $_POST['subject'], $email.'<br><div>'.$thistory.'</div>', strtolower($ticket->type), $attach);
        
        return true;
    }

    public function save_closed(){
        if(isset($_POST['status_chat']) && $_POST['status_chat']==0){

               $flag = $this->db->where('wa_number', $_POST['phone'])->update('whatsapp_chat', array('status_chat'=>'CLOSED'));

               return true;
        }
        $agent = $this->db->where('number', $_POST['user_id'])->get('call_center.agent',1)->row();
        
        $time = date('Y-m-d H:i:s');
        foreach (explode(',',$_POST['tick_ids']) as $key => $value) {
            $data = array(
                'closed_by'=>$agent->number,
                'closed_by_name'=>isset($agent->name)?$agent->name:$agent->number,
                'closed_date'=>$time,
                'closed_note'=>$_POST['status_note'],
                'status'=>'CLOSED',
                'is_read'=>1,
            );
            if($this->db->where('id',$value)->update('v_ticket',$data)){
                $note = strip_tags($_POST['status_note']);
                $history = array(
                    'ticket_id'=>$value,
                    'user_id'=>$agent->number,
                    'username'=>isset($agent->name)?$agent->name:$agent->number,
                    'time'=>$time,
                    'activity'=>'Close ticket.'.(!empty($note)?'<br><b>Note:</b><br>'.$_POST['status_note']:''),
                );
                $flag = $this->db->insert('v_ticket_history', $history);
                $flag = $this->db->where('ticket_id', $value)->update('whatsapp_chat', array('status_chat'=>'CLOSED'));
            }
        }
        return true;
    }

    public function save_reopen(){
        $agent = $this->db->where('number', $_POST['user_id'])->get('call_center.agent',1)->row();
        $time = date('Y-m-d H:i:s');
        foreach (explode(',',$_POST['tick_ids']) as $key => $value) {
            $data = array(
                'reopen_by'=>$agent->number,
                'reopen_by_name'=>isset($agent->name)?$agent->name:$agent->number,
                'reopen_date'=>$time,
                'status'=>'OPEN',
            );
            if($this->db->where('id',$value)->update('v_ticket',$data)){
                $note = strip_tags($_POST['reopen_note']);
                $history = array(
                    'ticket_id'=>$value,
                    'user_id'=>$agent->number,
                    'username'=>isset($agent->name)?$agent->name:$agent->number,
                    'time'=>$time,
                    'activity'=>'Reopen ticket.'.(!empty($note)?'<br><b>Note:</b><br>'.$_POST['reopen_note']:''),
                );
                $flag = $this->db->insert('v_ticket_history', $history);


                //set notif
                $ticket = $this->db->select('ticket_id, open_by, main_category, subject, content, category, sub_category, type, curr_assign')->where('id', $value)->get('v_ticket', 1)->row();
                $user_ext = $this->db->select('user_ext')->where(array('ticket_id'=>$value, 'assign_id'=>$ticket->curr_assign, 'user_ext<>'=>$_POST['user_id'], 'user_ext<>'=>0))
                        ->get('v_ticket_assignment')->result();
                $assignee = '';
                foreach ($user_ext as $key => $u) {
                    if($u->user_ext!=$_POST['user_id']){
                        $assignee = $u->user_ext;
                        write_notif($u->user_ext, 'menu='.strtolower($ticket->type).'_ticket&action=detail&id='.$ticket->ticket_id, $ticket->ticket_id, '<strong>'.(isset($agent->name)?$agent->name:$agent->number).'</strong> reopen ticket that you are assignee', $time, 'message');
                    }
                }

                if($ticket->open_by!=$_POST['user_id']){
                    write_notif($ticket->open_by, 'menu='.strtolower($ticket->type).'_ticket&action=detail&id='.$ticket->ticket_id, $ticket->ticket_id, '<strong>'.(isset($agent->name)?$agent->name:$agent->number).'</strong> reopen ticket '.$ticket->ticket_id, $time, 'message');
                }
            }
        }
        return true;
    }

    public function save_comment(){
        $agent = $this->db->where('number', $_POST['user_id'])->get('call_center.agent',1)->row();
        $time = date('Y-m-d H:i:s');
        foreach (explode(',',$_POST['tick_ids']) as $key => $value) {
            $ticket = $this->db->select('ticket_id, main_category, subject, content, category, sub_category, type, curr_assign')->where('id', $value)->get('v_ticket', 1)->row();
            $user_ext = $this->db->select('user_ext')->where(array('ticket_id'=>$value, 'user_ext<>'=>$_POST['user_id'], 'user_ext<>'=>0))
                    ->get('v_ticket_assignment')->result();
            $assignee = '';
            foreach ($user_ext as $key => $u) {
                if($u->user_ext!=$_POST['user_id']){
                    $assignee = $u->user_ext;
                    write_notif($u->user_ext, 'menu='.strtolower($ticket->type).'_ticket&action=detail&id='.$ticket->ticket_id, $ticket->ticket_id, '<strong>'.(isset($agent->name)?$agent->name:$agent->number).'</strong> comments on a ticket that you are assignee', $time, 'message');
                }
            }

            $user_ext = $this->db->select('user_id')->where(array('ticket_id'=>$value, 'user_id<>'=>$_POST['user_id'], 'user_id<>'=>0))->group_by('user_id')
                    ->get('v_ticket_history')->result();

            foreach ($user_ext as $key => $u) {
                if($u->user_id!=$_POST['user_id'] && $u->user_id != $assignee){
                    write_notif($u->user_id, 'menu='.strtolower($ticket->type).'_ticket&action=detail&id='.$ticket->ticket_id, $ticket->ticket_id, '<strong>'.(isset($agent->name)?$agent->name:$agent->number).'</strong> comments on a ticket '.$ticket->ticket_id, $time, 'message');
                }
            }

            /*$ticket = $this->db->select('ticket_id, open_by, main_category, subject, content, category, sub_category, type, curr_assign')->where('id', $value)->get('v_ticket', 1)->row();
            $user_ext = $this->db->select('user_ext')->where(array('ticket_id'=>$value, 'assign_id'=>$ticket->curr_assign, 'user_ext<>'=>$_POST['user_id'], 'user_ext<>'=>0))
                    ->get('v_ticket_assignment')->result();
            $assignee = '';
            foreach ($user_ext as $key => $u) {
                if($u->user_ext!=$_POST['user_id']){
                    $assignee = $u->user_ext;
                    write_notif($u->user_ext, 'menu='.strtolower($ticket->type).'_ticket&action=detail&id='.$ticket->ticket_id, $ticket->ticket_id, '<strong>'.(isset($agent->name)?$agent->name:$agent->number).'</strong> comments on a ticket that you are assignee', $time, 'message');
                }
            }

            if($ticket->open_by!=$_POST['user_id']){
                write_notif($ticket->open_by, 'menu='.strtolower($ticket->type).'_ticket&action=detail&id='.$ticket->ticket_id, $ticket->ticket_id, '<strong>'.(isset($agent->name)?$agent->name:$agent->number).'</strong> comments on a ticket '.$ticket->ticket_id, $time, 'message');
            }

            $user_ext = $this->db->select('user_id')->where(array('ticket_id'=>$value, 'user_id<>'=>$_POST['user_id'], 'user_id<>'=>0))->group_by('user_id')
                    ->get('v_ticket_history')->result();

            foreach ($user_ext as $key => $u) {
                if($u->user_id!=$_POST['user_id'] && $u->user_id != $assignee){
                    write_notif($u->user_id, 'menu='.strtolower($ticket->type).'_ticket&action=detail&id='.$ticket->ticket_id, $ticket->ticket_id, '<strong>'.(isset($agent->name)?$agent->name:$agent->number).'</strong> comments on a ticket '.$ticket->ticket_id, $time, 'message');
                }
            }*/

            $history = array(
                'ticket_id'=>$value,
                'user_id'=>$agent->number,
                'username'=>isset($agent->name)?$agent->name:$agent->number,
                'time'=>$time,
                'parent_id'=>$_POST['history_id'],
                'activity'=>$_POST['comment_note'],
            );
            $flag = $this->db->insert('v_ticket_history', $history);

        }
        return true;
    }

    public function check_email_exist($mid, $table){
        $query = $this->db->where('email_id',$mid)->get($table);
        if($query->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }

    public function save_email($data){
        return $this->db->insert('v_email', $data);
    }

    public function save_answer($data){
        $ticket = $this->db->select('ticket_id, main_category, subject, content, category, sub_category, type, curr_assign')->where('id', $data['ticket_id'])->get('v_ticket', 1)->row();
            $user_ext = $this->db->select('user_id')->where(array('ticket_id'=>$data['ticket_id'], 'is_reply'=>1, 'user_id<>'=>0))->order_by('history_id','desc')
                    ->get('v_ticket_history',1)->result();

            foreach ($user_ext as $key => $u) {
                    write_notif($u->user_id, 'menu='.strtolower($ticket->type).'_ticket&action=detail&id='.$ticket->ticket_id, $ticket->ticket_id, '<strong>'.$data['username'].'</strong> reply your email on a ticket', $data['time'], 'message');
            }

            /*

            foreach ($user_ext as $key => $u) {
                if($u->user_id!=$_POST['user_id']){
                    write_notif($u->user_id, 'menu='.strtolower($ticket->type).'_ticket&action=detail&id='.$ticket->ticket_id, $ticket->ticket_id, 'Ticket <strong>'.$ticket->ticket_id.'</strong> is assigned to you', $time, 'message');
                }
            }*/
            $history = array(
                'ticket_id'=>$data['ticket_id'],
                'user_id'=>0,
                'username'=>$data['username'],
                'time'=>$data['time'],
                'parent_id'=>0,
                'activity'=>$data['activity'],
            );
            $flag = $this->db->insert('v_ticket_history', $history);
        return true;
    }

    public function set_read_ticket($id){
        $this->db->where_in('id', $id)->update('v_ticket', array('is_read'=>1));
    }


    public function assignment_list(){
        $result = $this->db->select('id, name, email')->get('v_assignment_list')->result();
        $data = array();
        foreach ($result as $key => $value) {
            $data[] = array('id'=>$value->id, 'text'=>$value->name, 'email'=>$value->email);
        }
        return $data;
    }
    public function brand(){
        $result = $this->db->select('id, brand_name')->get('v_brand')->result();
        $data = array();
        foreach ($result as $key => $value) {
            $data[] = array('id'=>$value->brand_name, 'text'=>$value->brand_name);
        }
        return $data;
    }
    public function category($t=null){
        if($t=='k'){
            $result = $this->db->select('id, category')->where('parent_id',0)->get('v_'.$t.'ticket_category')->result();
        }else{
            $result = $this->db->select('id, category')->where('parent_id',0)->get('v_'.$t.'ticket_category')->result();
        }
        $data = array();
        foreach ($result as $key => $value) {
            $data[] = array('id'=>$value->category, 'text'=>$value->category);
        }
        return $data;
    }

    public function sub_category($t){
        if($t=='k'){
            $result = $this->db->select('id, category')->where('parent_id !=',0)->get('v_'.$t.'ticket_category')->result();
        }else{
            $result = $this->db->select('id, category')->where('parent_id !=',0)->get('v_'.$t.'ticket_category')->result();
        }
        $data = array();
        foreach ($result as $key => $value) {
            $data[] = array('id'=>$value->category, 'text'=>$value->category);
        }
        return $data;
    }
    public function subcategory($id){
        $result = $this->db->select('id, category')->where('parent_id',$id)->get('v_kticket_category')->result();
        $data = array();
        foreach ($result as $key => $value) {
            $data[] = array('id'=>$value->category, 'text'=>$value->category);
        }
        return $data;
    }
    public function main_category(){
        $result = $this->db->select('id, name')->get('v_main_category')->result();
        $data = array();
        foreach ($result as $key => $value) {
            $data[] = array('id'=>$value->name, 'text'=>$value->name);
        }
        return $data;
    }

    public function get_files($ids){
        $query = $this->db->where_in('id', explode(',',$ids))->get('v_attachment')->result();
        $data = array();
        foreach ($query as $key => $value) {
            $data[] = $value->filepath;
        }
        return $data;
    }

    public function export_excel($data)
    {

        $index = '';

        $this->db->select('a.id, a.ticket_id as ticket_code, a.*,b.*',false);
        if(isset($data['datas'])){
            if (trim($data['datas']['ticket_id']) != '') {
                if ($data['datas']['ticket_position'] == 'exact') {
                    $index = 'none';
                } else if($data['datas']['ticket_position'] == 'begins with'){
                    $index = 'before';
                }else if($data['datas']['ticket_position'] == 'ends with'){
                    $index = 'after';
                }else if($data['datas']['ticket_position'] == 'contain'){
                    $index = 'both';
                }
                $this->db->like('a.ticket_id', $data['datas']['ticket_id'],$index);
                
            } else if(trim($data['datas']['subject']) != ''){
                if ($data['datas']['subject_position'] == 'exact') {
                    $index = 'none';
                } else if($data['datas']['subject_position'] == 'begins with'){
                    $index = 'before';
                }else if($data['datas']['subject_position'] == 'ends with'){
                    $index = 'after';
                }else if($data['datas']['subject_position'] == 'contain'){
                    $index = 'both';
                }
                $this->db->like('a.subject', $data['datas']['subject'],$index);

            } else if(trim($data['datas']['category']) != ''){
                /*if ($data['datas']['subject_position'] == 'exact') {
                    $index = 'none';
                } else if($data['datas']['subject_position'] == 'begins with'){
                    $index = 'before';
                }else if($data['datas']['subject_position'] == 'ends with'){
                    $index = 'after';
                }else if($data['datas']['subject_position'] == 'contain'){
                    $index = 'both';
                }*/
                $this->db->where('a.subject', $data['datas']['subject']);

            } else if(trim($data['datas']['customer_id']) != ''){
                if ($data['datas']['customer_position'] == 'exact') {
                    $index = 'none';
                } else if($data['datas']['customer_position'] == 'begins with'){
                    $index = 'before';
                }else if($data['datas']['customer_position'] == 'ends with'){
                    $index = 'after';
                }else if($data['datas']['customer_position'] == 'contain'){
                    $index = 'both';
                }
                $this->db->like('a.cus_fname', $data['datas']['customer_id'],$index);

            }
        }

        $this->db->join('v_ticket_assignment b', 'a.curr_assign=b.assign_id', 'left');
        $data['data_excel'] = $this->db->get($this->table.' a')->result_array();
        return $data;
        /*$this->db->select('a.id, a.ticket_id as ticket_code, a.*,b.*',false);
        $this->db->where('a.ticket_id', $id);
        $this->db->join('v_ticket_assignment b', 'a.curr_assign=b.assign_id', 'left');
        $data['data'] = $this->db->get($this->table.' a', 1)->row();*/
    }

    public function get_user_list($type){
        return $this->db->select('a.number, a.name')
                ->join('kanmo.v_ext_cluster b','a.number=b.user_ext')
                ->where('estatus','A')
                ->where('cluster','BOTH')
                ->or_where('cluster',$type)->group_by('a.number')->get('call_center.agent a')->result();
    }

    public function save_callback($data){
        $flag = false;
        $agent = $this->db->where('number', $data['agent_ext'])->get('call_center.agent',1)->row();
        if($this->db->insert('v_ticket_callback', $data)){
            $history = array(
                'ticket_id'=>$data['ticket_id'],
                'user_id'=>$data['agent_ext'],
                'username'=>isset($agent->name)?$agent->name:$data['agent_ext'],
                'time'=>$data['calldate'],
                'activity'=>'Callback customer',
            );
            $flag = $this->db->insert('v_ticket_history', $history);
        }
        return $flag;
    }
    public function save_return_callback($data){
        return $this->db->where('callid',$data['callid'])->update('v_ticket_callback', $data);
    }


    public function data_detail($id,$type){
            $this->db->select('main_category, v_ticket.meta_category, v_ticket.source, v_ticket.category, sub_category, content, ticket_id, brand,v_main_category.id as main_id,
            meta.id as meta_id,cat.id as cat_id,subcat.id as subcat_id')
            ->join('v_main_category', 'name=v_ticket.main_category', 'left');
            if($type=='kanmo'){
                $this->db->join('meta_category as meta', 'meta.meta_category=v_ticket.meta_category AND meta.calltype_id=v_main_category.id', 'left')
                ->join('v_kticket_category as cat', 'cat.category=v_ticket.category AND cat.meta_id=meta.id', 'left')
                ->join('v_kticket_category as subcat', 'subcat.category=v_ticket.sub_category AND subcat.parent_id=cat.id', 'left');
            }else{
                $this->db->join('nmeta_category as meta', 'meta.meta_category=v_ticket.meta_category AND meta.calltype_id=v_main_category.id', 'left')
                ->join('v_nticket_category as cat', 'cat.category=v_ticket.category AND cat.meta_id=meta.id', 'left')
                ->join('v_nticket_category as subcat', 'subcat.category=v_ticket.sub_category AND subcat.parent_id=cat.id', 'left');
            }
            return $this->db->where('v_ticket.id',$id)->get('v_ticket')
            ->row(); 
    }

    public function get_brand(){
        $result = $this->db->select('id, brand_name')->get('v_brand')->result();
        $data = array();
        foreach ($result as $key => $value) {
            $data[] = array('id'=>$value->id, 'text'=>$value->brand_name);
        }
        return $data;
    }

    public function get_main_category(){
        $result = $this->db->select('id, name')->get('v_main_category')->result();
        $data = array();
        foreach ($result as $key => $value) {
            $data[] = array('id'=>$value->id, 'text'=>$value->name);
        }
        return $data;
    }

    public function get_meta_category($id=null,$type=''){
           $this->db->select('id,meta_category');
           if($id!=''){
                $this->db->where('calltype_id',$id);
            }
           if($type=='kanmo'){
            $result= $this->db->get('meta_category')->result();   
           }
           else if($type=='nespresso'){
            $result= $this->db->get('nmeta_category')->result();   
           }

        $data = array();
        foreach ($result as $key => $value) {
            $data[] = array('id'=>$value->id, 'text'=>$value->meta_category);
        }
        return $data;

    }
    
    public function get_category($id=null,$type=''){
        if($type=='kanmo'){
            $result = $this->db->select('id, category')->where('parent_id',0)->where('meta_id',$id)->where('enabled',1)->get('v_kticket_category')->result();
        }else if($type=='nespresso'){

            $result = $this->db->select('id, category')->where('parent_id',0)->where('meta_id',$id)->where('enabled',1)->get('v_nticket_category')->result();
        }
        $data = array();

        foreach ($result as $key => $value) {
            $data[] = array('id'=>$value->id, 'text'=>$value->category);
        }
        return $data;
    }

    public function get_sub_category($id=null,$type=''){
        if($type=='kanmo'){
            $result = $this->db->select('id, category')->where('parent_id',$id)->where('enabled',1)->get('v_kticket_category')->result();
        }else if($type=='nespresso'){
            $result = $this->db->select('id, category')->where('parent_id',$id)->where('enabled',1)->get('v_nticket_category')->result();
        }
        $data = array();
        foreach ($result as $key => $value) {
            $data[] = array('id'=>$value->id, 'text'=>$value->category);
        }
        return $data;
    }

    public function get_source($type){
        if($type=='kanmo'){
            $result = $this->db->select('source_name, frontend_display')->where('type', 'k')->or_where('type', 'b')->get('v_source')->result();
        }else{
            $result = $this->db->select('source_name, frontend_display')->where('type', 'n')->or_where('type', 'b')->get('v_source')->result();
        }
        return $result;
    }

    public function update_ticket(){
        /*var_dump($_POST["dsub_category"]);exit();*/
         $data = array(
  "brand"=>$_POST["dbrand"],
  "main_category"=>$_POST["dmain_category"],
  "meta_category"=>$_POST["dmeta_category"],
  "category"=>$_POST["dcategory"],
  "sub_category"=>$_POST["dsub_category"],
  "content"=>$_POST["content"],
  "source"=>$_POST["source"],
                );

    return $this->db->where(array('ticket_id'=>$_POST['ticket_id']))->update('v_ticket', $data);

    }
}