<?php

class Wachat_model extends CI_Model {
	function __construct()
    {
            parent::__construct();
            $this->load->database();
    }
    public function check_agent_is_login($number) {
        $this->db->where(array('au.datetime_end'=>null,'ag.estatus'=>'A'))->like('au.datetime_init',date('Y-m-d'), 'after');
        $this->db->where('ag.number', $number);
        $this->db->join('call_center.audit au','au.id_agent=ag.id');
        $q = $this->db->get('call_center.agent ag');
        
        if ($q->num_rows()>0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_online_agent($type){
        $data = $this->db->select('user_ext')->/*where('cluster', 'BOTH')->or_*/where('cluster', strtoupper($type))->get('kanmo.v_ext_cluster')->result();
        $ext = array();
        foreach ($data as $key => $value) {
            $ext[] = $value->user_ext;
        }
        $this->db->select('ag.id, ag.number');
        $this->db->group_start();
    	$this->db->where(array('au.id_break'=>16));
        $this->db->or_where(array('au.id_break'=>NULL));
        $this->db->group_end();
        $this->db->like('au.datetime_init',date('Y-m-d'), 'after');
        $this->db->where(array('au.datetime_end'=>null));
        $this->db->where_in('ag.number', $ext);
    	$this->db->join('call_center.audit au','au.id_agent=ag.id');
        $this->db->group_by('ag.number');
    	$q = $this->db->from('call_center.agent ag');
        return $q->count_all_results();
    }
    public function get_avail_agent_asli($type){
        $data = $this->db->select('user_ext')->/*where('cluster', 'BOTH')->or_*/where('cluster', strtoupper($type))->get('kanmo.v_ext_cluster')->result();
        $ext = array();
        foreach ($data as $key => $value) {
            $ext[] = $value->user_ext;
        }
        $this->db->select('ag.number');
        $this->db->join('call_center.audit au','au.id_agent=ag.id');
        $this->db->where(array('au.id_break <>'=>NULL));
        $this->db->where(array('au.id_break <>'=>16));
        $this->db->like('au.datetime_init',date('Y-m-d'), 'after');
        $this->db->where(array('au.datetime_end'=>null));
        $this->db->group_by('ag.number');
        $q = $this->db->get('call_center.agent ag');
        if ($q->num_rows()>0) {
            $result =  $q->result();
            foreach ($result as $key => $value) {
                if (($key = array_search($value->number, $ext)) !== false) {
                    unset($ext[$key]);
                }
            }
        }
        //print_r($ext);exit;

        //echo $this->db->last_query();exit;

    	$this->db->select('ag.id, ag.number');
        $this->db->group_start();
    	$this->db->where(array('au.id_break'=>16));
        $this->db->or_where(array('au.id_break'=>NULL));
        $this->db->group_end();
        $this->db->like('au.datetime_init',date('Y-m-d'), 'after');
        $this->db->where(array('au.datetime_end'=>null));
        $this->db->where_in('ag.number', $ext);
    	$this->db->join('call_center.audit au','au.id_agent=ag.id');
        $this->db->group_by('ag.number');
    	$q = $this->db->get('call_center.agent ag');
        $data = array();
        if ($q->num_rows()>0) {
            $result =  $q->result();
            foreach ($result as $key => $value) {
                if($this->check_count_handle_agent($value->id)<150) {
                    $data[] = $value;
                }
            }
            return $data;
        } else {
            return array();
        }
    }

    public function get_agent_name($id) {
        $q = $this->db->select('name')->where('id', $id)->get('call_center.agent',1);
        if($q->num_rows()>0){
            return $q->row()->name;
        }
        return '';
    }

    public function check_agent_is_in_chat($id_agent) {
        //$this->db->where(array('au.id_break'=>16, 'au.datetime_end'=>null));
        $this->db->group_start();
        $this->db->where(array('au.id_break'=>16));
        $this->db->or_where(array('au.id_break'=>NULL));
        $this->db->group_end();
        $this->db->like('au.datetime_init',date('Y-m-d'), 'after');
        $this->db->where(array('au.datetime_end'=>null));
        //$this->db->like('au.datetime_init',date('Y-m-d'), 'after');
        $this->db->where('ag.id', $id_agent);
        $this->db->join('call_center.audit au','au.id_agent=ag.id');
        $q = $this->db->get('call_center.agent ag');
        if ($q->num_rows()>0) {
            return true;
        } else {
            return false;
        }
    }

    public function find_ticket($phone){
        $q = $this->db->select('t.id, a.agent_id')->join('v_ticket t', 't.id=a.ticket_id')->where(array('a.wa_number'=>$phone, 't.status'=>'OPEN'))->order_by('a.id', 'desc')->get('whatsapp_chat a',1);
        if($q->num_rows()>0){
            return $q->row_array();
        }else{
            return array('id'=>0, 'agent_id'=>0);
        }
    }

     public function save_closed(){
    
               $flag = $this->db->where('wa_number', $_POST['phone'])->update('whatsapp_chat', array('status_chat'=>'CLOSED'));

               return true;
    
    }

    public function check_chat_session($wa_number, $time) {
        $q = $this->db->select('agent_id')->where(array('wa_number'=> $wa_number, 'is_reply'=>0, 'status_chat<>'=>'CLOSED'))->where('TIMESTAMPDIFF(SECOND, chat_time, \''.$time.'\')<(60*10)')->order_by('chat_time','desc')->get('kanmo.whatsapp_chat',1);
        if($q->num_rows()>0){
            return $q->row()->agent_id;
        }else{
            return 0;
        }
    }

    public function check_count_handle_agent($id_agent) {
        return $this->db->where(array('agent_id'=> $id_agent, 'status_chat<>'=>'CLOSED'))->join('(select max(wa_id) as max_id from kanmo.whatsapp_chat where status <> "closed" group by wa_number) b', 'a.wa_id=b.max_id')->from('kanmo.whatsapp_chat a')->count_all_results();
    }

    public function get_agent_number($id) {
        $q = $this->db->select('number')->where('id', $id)->get('call_center.agent', 1);
        if($q->num_rows()>0){
            return $q->row()->number;
        }else{
            return 0;
        }
    }

    public function get_res_id ($ext) {
        $q = $this->db->select('uniqueid')->where('user', $ext)->order_by('id', 'desc')->get('v_realtime_login',1);
        if($q->num_rows()>0){
            return $q->row()->uniqueid;
        }
        return false;
    }

    public function find_customer($phone){
    	$q = $this->db->select('cus_id')->where('cus_phone', $phone)->get('whatsapp_cust', 1);
    	if($q->num_rows()>0){
    		return $q->row()->cus_id;
    	} else{
    		$this->db->insert('whatsapp_cust', array('cus_phone'=>$phone));
    		return $this->db->insert_id();
    	}
    }

    public function update_status_chat($id, $status){
        $a=$this->db->select('wa_id')->where('id', $id)->get('whatsapp_chat')->row();

        $this->db->where('id', $id)->update('whatsapp_chat', array('status'=>$status));

        return $a->wa_id;
    }

    var $ticket_order = array('v_ticket.id','ticket_id','category','subject', 'source',/*'store_name',*/'status');
    var $ticket_search = array('v_ticket.id','ticket_id','category','subject', 'source',/*'store_name',*/'status');
    var $thorder = array('id' => 'desc');

    private function load_ticket_history($type){
        $this->db->select(implode(',',$this->ticket_order));
        $this->db->from('v_ticket');
        $this->db->join('v_customer', 'v_customer.cus_id=v_ticket.cus_id', 'left');
        if(isset($_POST['phone'])){
            $this->db->group_start();
                $this->db->where('v_customer.cus_phone', $_POST['phone']);
                $this->db->or_where('v_ticket.cus_phone', $_POST['phone']);
            $this->db->group_end();
        }
        $this->db->where('v_ticket.type', $type);
        /*if(!empty($_POST['store'])){
            $this->db->like('store', $_POST['store']);
        }*/
        if(!empty($_POST['periode'])){
            $date = explode(' - ',$_POST['periode']);
            $this->db->where(array('open_date>='=>date('Y-m-d 00:00:00',strtotime($date[0])), 'open_date<='=>date('Y-m-d 23:59:59',strtotime($date[1]))));
        }else{
            $startdate = date('Y-m-d 00:00:00', strtotime(date('Y-m-d'). ' -1 months'));
            $enddate = date('Y-m-d 23:59:59');
            $this->db->where(array('open_date>='=>$startdate, 'open_date<='=>$enddate));
        }
        $i = 0;
        foreach ($this->ticket_search as $item) {
            if($_POST['search']['value'])
            {
                 
                if($i===0)
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->ticket_search) - 1 == $i)
                $this->db->group_end();
            }
            $i++;
        }

        if(isset($_POST['order']))
        {
            $this->db->order_by($this->ticket_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->thorder))
        {
            $order = $this->thorder;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_load_ticket($type)
    {
        $this->load_ticket_history($type);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_ticket_filtered($type)
    {
        $this->load_ticket_history($type);
        return $this->db->count_all_results();
    }
 
    public function count_ticket_all($type)
    {
        $this->db->from('v_ticket');
        $this->db->join('v_customer', 'v_customer.cus_id=v_ticket.cus_id', 'left');
        if(isset($_POST['phone'])){
            $this->db->group_start();
                $this->db->where('v_customer.cus_phone', $_POST['phone']);
                $this->db->or_where('v_ticket.cus_phone', $_POST['phone']);
            $this->db->group_end();
        }
        $this->db->where('v_ticket.type', $type);
        /*if(!empty($_POST['store'])){
            $this->db->like('store', $_POST['store']);
        }*/
        if(!empty($_POST['periode'])){
            $date = explode(' - ',$_POST['periode']);
            $this->db->where(array('open_date>='=>date('Y-m-d',strtotime($date[0])), 'open_date<='=>date('Y-m-d',strtotime($date[1]))));
        }
        return $this->db->count_all_results();
    }

    public function get_ticket_detail($id){
        $query = $this->db->select('ticket_id, category, subject, open_date, open_by_name, status, curr_assign, content')->where('id', $id)->get('v_ticket', 1);
        if($query->num_rows()>0){
            $row = $query->row();
            if($row->status=='OPEN' && $row->curr_assign != 0){
                $assign = $this->db->select('groupname')->where('assign_id', $row->curr_assign)->get('v_ticket_assignment',1)->row();
                $row->status = $row->status.' and assign to '.$assign->groupname;
            }
            return $row;
        }else{
            return array();
        }
    }

    public function refresh_assign($number, $type) {
        if (!in_array($number, array('800','801','123123','123456','823'))) {            
            $q = $this->db->select('agent.id, agent.name')->where(array('number'=> $number, 'estatus'=>'A'))
                    ->where('cluster', strtoupper($type))
                    ->join('kanmo.v_ext_cluster','user_ext=number')->get('call_center.agent',1);
            $agent_id = 0;
            $agent_name = '';
            if($q->num_rows()>0){
                $agent_id = $q->row()->id;
                $agent_name = $q->row()->name;
            }
            $total = 150 - $this->check_count_handle_agent($agent_id);
            //echo $total;
            if($total>0){
                $q = $this->db->where('agent_id',0)->select('wa_number, chat_time', false)->group_by('wa_number')->order_by('chat_time')->get('kanmo.whatsapp_chat',$total);
                if($q->num_rows()>0){
                    $result = $q->result();
                    foreach ($result as $key => $value) {
                        //echo $value->wa_number;exit;
                        $this->db->where(array( 'wa_number'=>$value->wa_number, 'agent_id'=>0))->update('kanmo.whatsapp_chat', array('agent_id'=>$agent_id, 'agent_name'=>$agent_name));
                    }
                }
            }
        }
    }




     
    function status_chat(){
         $id_agent=$_POST['ext'];
        // var_dump($id_agent);exit();
        if($_POST['status']=='stop'){
            $data=array();
            $data['co_datetime_init']=date('Y-m-d H:i:s');
            $data['co_agent_id']=$id_agent;
            return $this->db->insert('chat_off',$data);
        }if($_POST['status']=='play'){
            $data=array()     ;
            $data['co_datetime_end']=date('Y-m-d H:i:s');
            $this->db->where('co_agent_id',$id_agent);
            return $this->db->update('chat_off',$data);
            
        }
    }

    function get_id_agent($ext){
        $this->db->select('id');
        $this->db->where('ag.estatus="A"');
        $this->db->where('ag.number', $ext);
        return $q = $this->db->get('call_center.agent ag')->row()->id;
        
    }

    function check_status_chat($ext){
        //$id_agent=$this->get_id_agent($ext);
        
        $this->db->where('co_agent_id', $ext);
        $this->db->where('co_datetime_end',null);
        $this->db->like('co_datetime_init',date('Y-m-d'), 'after');
        $q = $this->db->get('chat_off');
        
        if ($q->num_rows()>0) {
            return true;
        } else {
            return false;
        }

    }


    public function get_avail_agent_l($type){
        $data = $this->db->select('user_ext')->/*where('cluster', 'BOTH')->or_*/where('cluster', strtoupper($type))->get('kanmo.v_ext_cluster')->result();
        $ext = array();
        foreach ($data as $key => $value) {
            $ext[] = $value->user_ext;
        }
        $this->db->select('ag.number');
        $this->db->join('call_center.audit au','au.id_agent=ag.id');
        $this->db->where(array('au.id_break <>'=>NULL));
        $this->db->where(array('au.id_break <>'=>16));
        $this->db->like('au.datetime_init',date('Y-m-d'), 'after');
        $this->db->where(array('au.datetime_end'=>null));
        $this->db->group_by('ag.number');
        $q = $this->db->get('call_center.agent ag');
        if ($q->num_rows()>0) {
            $result =  $q->result();
            foreach ($result as $key => $value) {
                if (($key = array_search($value->number, $ext)) !== false) {
                    unset($ext[$key]);
                }
            }
        }
        //print_r($ext);exit;

        //echo $this->db->last_query();exit;

        $this->db->select('ag.id, ag.number');
        $this->db->group_start();
        $this->db->where(array('au.id_break'=>16));
        $this->db->or_where(array('au.id_break'=>NULL));
        $this->db->group_end();
        $this->db->like('au.datetime_init',date('Y-m-d'), 'after');
        $this->db->where(array('au.datetime_end'=>null));
        $this->db->where_in('ag.number', $ext);
        $this->db->join('call_center.audit au','au.id_agent=ag.id');
        $this->db->group_by('ag.number');
        $q = $this->db->get('call_center.agent ag');
        $data = array();
        if ($q->num_rows()>0) {
            $result =  $q->result();
            foreach ($result as $key => $value) {
                if($this->check_count_handle_agent($value->id)<150) {
                    $data[] = $value;
                }
            }


//chat off
        $this->db->select('co_agent_id as number');
        $this->db->like('co_datetime_init',date('Y-m-d'), 'after');
        $this->db->where(array('co_datetime_end'=>null));
        $this->db->group_by('co_agent_id');
        $b=$this->db->get('kanmo.chat_off');

        if ($b->num_rows()>0) {
            $chat_off =  $b->result();
            $ext_chat_off=array();
            foreach ($chat_off as $key => $value) {
                    $ext_chat_off[] = $value->number;
            }

            foreach ($data as $key => $value) {
                if (($key = array_search($value->number, $ext_chat_off)) !== false) {
//                    var_dump($key);exit();
                    unset($data[$key]);
                }
            }
        }
            return $data;
        } else {
            return array();
        }
    }


    function get_avail_agent($type){
         $data = $this->db->select('user_ext')->/*where('cluster', 'BOTH')->or_*/where('cluster', strtoupper($type))->get('kanmo.v_ext_cluster')->result();
        $ext = array();
        foreach ($data as $key => $value) {
            $ext[] = $value->user_ext;
        }
        $this->db->select('ag.number');
        $this->db->join('call_center.audit au','au.id_agent=ag.id');
        $this->db->where(array('au.id_break <>'=>NULL));
        $this->db->where(array('au.id_break <>'=>16));
        $this->db->like('au.datetime_init',date('Y-m-d'), 'after');
        $this->db->where(array('au.datetime_end'=>null));
        $this->db->group_by('ag.number');
        $q = $this->db->get('call_center.agent ag');
        if ($q->num_rows()>0) {
            $result =  $q->result();
            foreach ($result as $key => $value) {
                if (($key = array_search($value->number, $ext)) !== false) {
                    unset($ext[$key]);
                }
            }
        }

        $this->db->select('co_agent_id as number');
        $this->db->like('co_datetime_init',date('Y-m-d'), 'after');
        $this->db->where(array('co_datetime_end'=>null));
        $this->db->group_by('co_agent_id');
        $b=$this->db->get('kanmo.chat_off');

        if ($b->num_rows()>0) {
            $chat_off =  $b->result();
            $ext_chat_off=array();
            foreach ($chat_off as $key => $value) {

                if (($key = array_search($value->number,$ext)) !== false) {
                    unset($ext[$key]);
                }

             
            }
        }


        $this->db->select('ag.id, ag.number');
        $this->db->group_start();
        $this->db->where(array('au.id_break'=>16));
        $this->db->or_where(array('au.id_break'=>NULL));
        $this->db->group_end();
        $this->db->like('au.datetime_init',date('Y-m-d'), 'after');
        $this->db->where(array('au.datetime_end'=>null));
        $this->db->where_in('ag.number', $ext);
        $this->db->join('call_center.audit au','au.id_agent=ag.id');
        $this->db->group_by('ag.number');
        $q = $this->db->get('call_center.agent ag');
        $data = array();
        if ($q->num_rows()>0) {
            $result =  $q->result();
            foreach ($result as $key => $value) {
                if($this->check_count_handle_agent($value->id)<150) {
                    $data[] = $value;
                }
            }


//
            return $data;
        } else {
            return array();
        }
    }




    public function check_chat_session_store($wa_number, $time) {
        $q = $this->db->select('agent_id')->where(array('wa_number'=> $wa_number, 'is_reply'=>0, 'status_chat<>'=>'CLOSED'))->where('TIMESTAMPDIFF(SECOND, chat_time, \''.$time.'\')<(60*60)')->order_by('chat_time','desc')->get('kanmo.whatsapp_chat',1);
        if($q->num_rows()>0){
            return $q->row()->agent_id;
        }else{
            return 0;
        }
    }

}
