<?php

class Wa_data_model extends CI_Model {

    private $pref = '';
    var $table = 'data_campaign';
    var $column_order = array('a.data_id');
    var $column_search = array('a.data_id');
    var $order = array('a.data_id' => 'asc');

    function __construct()
        {
                parent::__construct();
                $this->load->database();
                $this->pref = $this->config->item('tb_pref');
                //$this->table = $this->pref.$this->table;
        }

    private function load_data($id){
        $form=$this->db->select('form')->where('campaign_id', $id)->get($this->pref.'campaign')->row();

        $form = json_decode($form->form);
        $myid = $this->session->userdata('id');
        foreach ($form as $key => $value) {
            $this->column_search[] = 'a.form_'.$value->name;
            $this->column_order[] = 'a.form_'.$value->name;
        }
            $this->column_search[] = 'a.status_wa';
            $this->column_order[] = 'a.status_wa';
            //$this->column_order[] = 'a.merchant_status';
        $this->db->join('(SELECT x.data_id, x.attemp_date call_date, x.call_status FROM call_attemp_'.$id.' x JOIN (SELECT data_id, MAX(attemp_date) call_date FROM call_attemp_'.$id.' GROUP BY data_id) y ON x.data_id=y.data_id AND x.attemp_date=y.call_date GROUP BY x.data_id) d', 'd.data_id=a.data_id AND d.call_status = \'Contacted\'');
        
        //$this->db->group_start();
        $this->db->where('a.status','Complete');
        //$this->db->group_end();
        if(isset($_POST['adv_search'])){
            $this->adv_search_builder($_POST['adv_search'], $_POST['opt']);
            /*$sess_s['cdr_search'] = array('adv_search'=> $_POST['adv_search'],'opt'=> $_POST['opt']);
            $this->session->set_userdata('asearch',$sess_s);*/
        }
        $this->db->from($this->table.'_'.$id.' a');
        $i = 0;
        foreach ($this->column_search as $item) {
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
 
                if(count($this->column_search) - 1 == $i)
                $this->db->group_end();
            }
            $i++;
        }

        if(isset($_POST['order']))
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_load_data($id)
    {
        $this->load_data($id);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered($id)
    {
        $this->load_data($id);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($id)
    {   
        $myid = $this->session->userdata('id');
        //$this->db->join('(SELECT x.data_id, COUNT(x.data_id) retries, x.attemp_date call_date, x.call_status FROM call_attemp_'.$id.' x JOIN (SELECT data_id, MAX(attemp_date) call_date FROM call_attemp_'.$id.' GROUP BY data_id) y ON x.data_id=y.data_id AND x.attemp_date=y.call_date GROUP BY x.data_id) d', 'd.data_id=a.data_id', 'left');
        //$this->db->group_start();
        $this->db->join('(SELECT x.data_id, x.attemp_date call_date, x.call_status FROM call_attemp_'.$id.' x JOIN (SELECT data_id, MAX(attemp_date) call_date FROM call_attemp_'.$id.' GROUP BY data_id) y ON x.data_id=y.data_id AND x.attemp_date=y.call_date GROUP BY x.data_id) d', 'd.data_id=a.data_id AND d.call_status = \'Contacted\'');
        $this->db->where('a.status','Complete');
        //$this->db->group_end();
        if(isset($_POST['adv_search'])){
            $this->adv_search_builder($_POST['adv_search'], $_POST['opt']);
            /*$sess_s['cdr_search'] = array('adv_search'=> $_POST['adv_search'],'opt'=> $_POST['opt']);
            $this->session->set_userdata('asearch',$sess_s);*/
        }
        $this->db->from($this->table.'_'.$id.' a');
        return $this->db->count_all_results();
    }

    public function save_chat($data){

        //var_dump($data);exit();
        $this->db->where(array('wa_number'=>$data['wa_number'],'is_reply'=>1,'status_chat<>'=>'closed'))->update('whatsapp_chat', array('agent_name'=>$data['agent_name'],'agent_id'=>$data['agent_id']));
/*          $this->db->where(array('wa_number'=>$data['wa_number'],'status_chat<>'=>'closed','is_reply'=>1))->update('whatsapp_chat', array('agent_name'=>$data['agent_name'],'agent_id'=>$data['agent_id']));
*/

        /*
 $this->db->where(array('wa_number'=>$data['wa_number'],'status_chat<>'=>'closed', 'agent_id'=>0))->update('whatsapp_chat', array('agent_name'=>$data['agent_name'],'agent_id'=>$data['agent_id']));
        */
         
        return $this->db->insert('whatsapp_chat', $data);
      
    }

    public function get_agent_name($id) {
        $q = $this->db->select('id, name, number')->where(array('number'=> $id, 'estatus'=>'A'))->get('call_center.agent',1);
        if($q->num_rows()>0){
            return $q->row_array();
        }
        return array('id'=>0, 'name'=>'', 'number'=>'');
    }

    public function get_old_number($wa_number) {
        $q = $this->db->select('IFNULL(a.number,0) as number',false)->join('call_center.agent a', 'a.id=b.agent_id', 'left')->where(array('wa_number'=>$wa_number, 'status_chat<>'=>'closed'))->order_by('b.wa_id','desc')->get('kanmo.whatsapp_chat b',1);
        if($q->num_rows()>0){
            return $q->row()->number;
        }
        return 0;
    }

   public function save_reply($data){
        $q = $this->db->where('id',$data['id'])->get('whatsapp_chat',1);
        if($q->num_rows==0){
            $this->db->where(array('wa_number'=>$data['wa_number'], 'agent_id'=>0, 'status_chat<>'=>'closed'))->update('kanmo.whatsapp_chat', array('agent_id'=>$data['agent_id'], 'agent_name'=>$data['agent_name']));
            return $this->db->insert('whatsapp_chat', $data);
        }
        return false;
    }

public function find_data_id($phone, $sender=false){
        $check = $this->db->select('parent_id,wa_id')->where(array('wa_number'=>$phone, 'parent_id'=>0))->get('whatsapp_chat');
        if($check->num_rows()<1){
            return array('parent'=>0);
        }else{
            $row = $check->row();
            return array('parent'=>$row->wa_id);
        }
    }


    public function save_status($id, $data_id, $status){
        if($this->db->where(array('data_id'=>$data_id))->update('data_campaign_'.$id, array('status_wa'=>$status))){
            return $this->db->where(array('data_id'=>$data_id, 'campaign_id'=>$id))->update('v_whatsapp', array('status'=>$status));
        }else{
            return false;
        }
    }

    public function get_notif_new($agent,$phone){
        //$act[] = $active;
        //$ids = array_diff($ids, $act);
        $this->db->select(' sum(if(status=\'unread\',1,0)) as total', false);
        //if(count($ids)>0)
        $this->db->where(array('agent_id'=>$agent,'is_reply'=>1));        
        return $this->db->get('whatsapp_chat')->result();
    }

    public function get_chat($agent,$phone){
        $q = $this->db->select('id')->where(array('number'=>$agent, 'estatus'=>'A'))->get('call_center.agent',1);
        if($q->num_rows()>0){
            $agent = $q->row()->id;
        }

        $this->db->where(array('parent_number'=> $phone,'agent_id'=> $agent, 'status'=>'unread', 'is_reply'=>1));

         $this->db->from('whatsapp_chat');
         var_dump($this->db->get_compiled_select());
        exit();
        $result = $this->db->get('whatsapp_chat')->result();
        $this->db->where(array('parent_number'=> $phone,'agent_id'=> $agent, 'status'=>'unread', 'is_reply'=>1))->update('whatsapp_chat', array('status'=>'read'));
        $data = array();
        foreach ($result as $key => $value) {
            if(!empty($value->wa_images))
                $this->download_file($value->wa_images);
            $data[] = array('text'=>nl2br($value->wa_text), 'image'=>$value->wa_images, 'date'=>date('Y-m-d', strtotime($value->chat_time)), 'time'=>date('H:i', strtotime($value->chat_time)), 'type'=>'rchat');
        }
        return $data;
    }


    public function get_endchat($agent){


        $sql="SELECT t1.*,if(whatsapp_cust.cus_fname is null,t1.wa_number,whatsapp_cust.cus_fname) as fname FROM whatsapp_chat t1 JOIN (SELECT parent_number, MAX(chat_time) timestamp FROM whatsapp_chat GROUP BY parent_number) t2 ON t1.parent_number = t2.parent_number AND t1.chat_time = t2.timestamp left join whatsapp_cust on whatsapp_cust.cus_id=t1.cust_id where agent_id=$agent and wa_number!='6289516588166'";
        $result=$this->db->query($sql)->result();

        
        $data = array();
        foreach ($result as $key => $value) {
            if(!empty($value->wa_images))
                $this->download_file($value->wa_images);
            $data[] = array('text'=>nl2br($value->wa_text), 'name'=>$value->fname,'wa_number'=>$value->wa_number, 'date'=>date('Y-m-d', strtotime($value->chat_time)), 'time'=>date('H:i', strtotime($value->chat_time)));
        }
        return $data;
    }




    private function download_file($img){
        if(!is_file("/var/www/html/kanmo/assets/wa_images/".$img) && (strpos($img, 'https://') === false)){
            if($this->process("http://wablas.com/image/".$img, $img)){
                
            }
        }
    }



    



    private function process($url, $img){
        $ch = curl_init($url);    
        $file = fopen ("/var/www/html/kanmo/assets/wa_images/".$img, 'wb');
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
        //  CURLOPT_BINARYTRANSFER => 1, --- No effect from PHP 5.1.3
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FILE           => $file,
            CURLOPT_TIMEOUT        => 50,
            CURLOPT_USERAGENT      => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'
        ]);
        $file = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($code == 200){
            echo ' file exist.... downloading...<br>';
           
        }else{
          $status = false;
        }
        curl_close($ch);
       return $status;
    }

    private function adv_search_builder($adv_search, $opt){
        foreach ($adv_search as $key => $value) {
            $field = $key;
            if(strpos($key, 'form_')!==false){
                $field = 'a.'.$key;
            }
            if($key=='status_wa' && $value=='ncy'){
                $this->db->group_start();
                $this->db->where($key.'<>','Complete');
                $this->db->or_where($key,NULL);
                $this->db->group_end();
                continue;
            }

            if(!empty($value)){
                if(isset($opt[$key])){
                    switch ($opt[$key]) {
                        case 'begins with':
                            $this->db->like($field, $value, 'after');
                            break;
                        case 'contains':
                            $this->db->like($field, $value); 
                            break;
                        case 'ends with':
                            $this->db->like($field, $value, 'before');
                            break;
                        default:
                            $this->db->where($field,$value);
                            break;
                    }
                }else{
                    $this->db->where($field,$value);
                }
            }
        }
    }

    public function get_images_wa($cid){
        return $this->db->select('wa_images')->where('wa_images IS NOT NULL', NULL)->get('whatsapp_chat_'.$cid)->result();
    }


     public function get_lastchat($type,$agent){

        $q = $this->db->select('id')->where(array('number'=>$agent, 'estatus'=>'A'))->get('call_center.agent',1);
        if($q->num_rows()>0){
            $agent = $q->row()->id;
        }

        //$sql="SELECT t1.*,if(whatsapp_cust.cus_fname is null,t1.wa_number, CONCAT(COALESCE(whatsapp_cust.cus_fname,''),' ',COALESCE(whatsapp_cust.cus_lname,''))) as fname,b.unread FROM whatsapp_chat t1 JOIN (SELECT MAX(wa_id) max_id FROM whatsapp_chat GROUP BY wa_number) t2 ON t1.wa_id = t2.max_id left join whatsapp_cust on whatsapp_cust.cus_id=t1.cust_id join call_center.agent ag on (ag.id=t1.agent_id) left join (SELECT wa_number,sum(if(status='unread',1,0)) as unread FROM `whatsapp_chat` where  is_reply=1 and whatsapp_chat.type='$type' GROUP by wa_number) as b ON (b.wa_number=t1.wa_number) where ag.estatus='A' and ag.number=$agent and t1.type='$type' and t1.status_chat<>'CLOSED' order by t1.chat_time desc";
        $sql="SELECT a.*, IFNULL(d.unread,0) as unread, IF(c.cus_fname IS NOT NULL, CONCAT(c.cus_fname,' ', c.cus_lname), a.wa_number) as fname FROM `whatsapp_chat` a JOIN whatsapp_cust c ON (a.cust_id=c.cus_id) LEFT JOIN whatsapp_chat b ON (a.cust_id=b.cust_id AND a.wa_id<b.wa_id) LEFT JOIN (SELECT COUNT(wa_id) as unread, cust_id FROM whatsapp_chat WHERE status = 'unread' AND type = '$type' AND agent_id = $agent GROUP BY cust_id) d ON (a.cust_id=d.cust_id) WHERE a.agent_id = $agent AND a.status_chat<>'CLOSED' AND b.wa_id IS NULL AND a.type = '$type' GROUP BY a.wa_number order by a.chat_time desc";
        $result=$this->db->query($sql)->result();
        //echo $this->db->last_query();
        $my_chat = array();        
        foreach ($result as $key => $value) {
            if(!empty($value->wa_images))
                $this->download_file($value->wa_images);
            $my_chat[] = array('wa_id'=>$value->wa_id,'text'=>nl2br($value->wa_text), 'unread'=>$value->unread, 'name'=>$value->fname,'wa_number'=>$value->wa_number, 'date'=>date('Y-m-d', strtotime($value->chat_time)), 'time'=>date('H:i', strtotime($value->chat_time)),'name'=>$value->fname);
        }

        //$sql="SELECT t1.*,if(whatsapp_cust.cus_fname is null,t1.wa_number, CONCAT(COALESCE(whatsapp_cust.cus_fname,''),' ',COALESCE(whatsapp_cust.cus_lname,''))) as fname,b.unread FROM whatsapp_chat t1 JOIN (SELECT MAX(wa_id) max_id FROM whatsapp_chat GROUP BY wa_number) t2 ON t1.wa_id = t2.max_id left join whatsapp_cust on whatsapp_cust.cus_id=t1.cust_id join call_center.agent ag on (ag.id=t1.agent_id) left join (SELECT wa_number,sum(if(status='unread',1,0)) as unread FROM `whatsapp_chat` where  is_reply=1 and whatsapp_chat.type='$type' GROUP by wa_number) as b ON (b.wa_number=t1.wa_number) where ag.estatus='A' and t1.type='$type' and t1.status_chat<>'CLOSED' order by t1.chat_time desc";
        $sql="SELECT a.*, IFNULL(d.unread,0) as unread, IF(a.agent_id = 0, 'In Queue', a.agent_name) as assign, IF(c.cus_fname IS NOT NULL, CONCAT(c.cus_fname,' ', c.cus_lname), a.wa_number) as fname FROM `whatsapp_chat` a JOIN whatsapp_cust c ON (a.cust_id=c.cus_id) LEFT JOIN whatsapp_chat b ON (a.cust_id=b.cust_id AND a.wa_id<b.wa_id) LEFT JOIN (SELECT COUNT(wa_id) as unread, cust_id FROM whatsapp_chat WHERE status = 'unread' AND type = '$type' GROUP BY cust_id) d ON (a.cust_id=d.cust_id) WHERE b.wa_id IS NULL AND a.type = '$type' GROUP BY a.wa_number order by a.chat_time desc";
        $result=$this->db->query($sql)->result();


        $all_chat = array();
        foreach ($result as $key => $value) {
            if(!empty($value->wa_images))
                $this->download_file($value->wa_images);
            $all_chat[] = array('wa_id'=>$value->wa_id,'text'=>nl2br($value->wa_text), 'unread'=>$value->unread, 'name'=>$value->fname,'wa_number'=>$value->wa_number, 'date'=>date('Y-m-d', strtotime($value->chat_time)), 'time'=>date('H:i', strtotime($value->chat_time)), 'assign'=>$value->assign);
        }
        $r= array('my_chat' =>$my_chat ,'all_chat'=>$all_chat);

        return $r;
    }
    function search_id_agent($number){
        $sql="SELECT count(*) as total,sum(if(is_reply=1,1,0)) as recieve,sum(if(is_reply=0,1,0)) as send FROM `whatsapp_chat` where agent_id=$agent_id and type='$type' group by agent_id";
        $result=$this->db->query($sql)->row();
        return $result;
    }
    function dashboard($type,$agent_id){
            $total="select count(*) as total from( select count(*) as total from whatsapp_chat where type='$type' and chat_time like '".date('Y-m-d')."%' group by cust_id ) as a";

            $total=$this->db->query($total)->row()->total;

            $recieve="select count(*) as recieve from( select count(*) as recieve from whatsapp_chat where agent_id=$agent_id and type='$type' and chat_time like '".date('Y-m-d')."%' and is_reply=1 group by cust_id ) as a";

            $recieve=$this->db->query($recieve)->row()->recieve;

            $send="select count(*) as send from( select count(*) as send from whatsapp_chat where agent_id=$agent_id and type='$type' and chat_time like '".date('Y-m-d')."%' and is_reply=0 group by cust_id ) as a";


            $send=$this->db->query($send)->row()->send;
            
            $sql="select count(*) as queue from (SELECT count(*) as queue FROM `whatsapp_chat` where type='$type' and is_reply=1 and chat_time like '".date('Y-m-d')."%' and agent_id=0 GROUP by cust_id) a";

            $hasil=$this->db->query($sql)->row()->queue;


          $result= array('total' =>$total ,'recieve'=>$recieve,'send'=>$send,'queue'=>$hasil);

        return array('result_my' =>$result ,'result_all'=>$result);
    }

    function dashboard_queue($type){
        $total="select count(*) as total from( select count(*) as total from whatsapp_chat where type='$type' and chat_time like '".date('Y-m-d')."%' group by cust_id ) as a";

            $total=$this->db->query($total)->row()->total;

            
            $sql="select count(*) as queue from (SELECT count(*) as queue FROM `whatsapp_chat` where type='$type' and chat_time like '".date('Y-m-d')."%' and is_reply=1 and agent_id=0 GROUP by cust_id) a";

            $hasil=$this->db->query($sql)->row()->queue;


          $result= array('total' =>$total ,'queue'=>$hasil);

        return array('result_all'=>$result);
    } 

    function dashboardu($type,$number){
        $this->db->select('id');
        $this->db->where('number',$number);        
        $this->db->where('estatus="A"');
        $agent_id=$this->db->get('call_center.agent');

        if ($agent_id->num_rows()>0) {
            $agent_id=$agent_id->row()->id;
            /*$sql="SELECT sum(if(is_reply=1,1,0)) as recieve,sum(if(is_reply=0,1,0)) as send FROM `whatsapp_chat` where agent_id=$agent_id and type='$type' group by agent_id";*/

            $total="select count(*) as total from( select count(*) as total from whatsapp_chat where type='$type' and chat_time like '".date('Y-m-d')."%' group by cust_id ) as a";

            $total=$this->db->query($total)->row()->total;

            $recieve="select count(*) as recieve from( select count(*) as recieve from whatsapp_chat where agent_id=$agent_id and type='$type' and chat_time like '".date('Y-m-d')."%' and is_reply=1 group by cust_id ) as a";

            $recieve=$this->db->query($recieve)->row()->recieve;

            $send="select count(*) as send from( select count(*) as send from whatsapp_chat where agent_id=$agent_id and type='$type' and chat_time like '".date('Y-m-d')."%' and is_reply=0 group by cust_id ) as a";


            $send=$this->db->query($send)->row()->send;
            
            $sql="select count(*) as queue from (SELECT count(*) as queue FROM `whatsapp_chat` where type='$type' and is_reply=1 and chat_time like '".date('Y-m-d')."%' and agent_id=0 GROUP by cust_id) a";

            $hasil=$this->db->query($sql)->row()->queue;

            

            /*if($hasil->num_rows()>0){

            	$queue = $hasil->row()->queue;                
               

            } else {
            	$queue = 0;
            }*/

          $result= array('total' =>$total ,'recieve'=>$recieve,'send'=>$send,'queue'=>$hasil);

        } else {
            $result= array('total' =>0 ,'recieve'=>0,'send'=>0,'queue'=>0 );
            /*$return->total=0;
            $return->recieve=0;
            $return->send=0;
            $result->queue=0;*/
        }
        

        return $result;
    }
     function dashboarduall($type,$number){
        $this->db->select('id');
        $this->db->where('number',$number);        
        $this->db->where('estatus="A"');
        $agent_id=$this->db->get('call_center.agent');

         if ($agent_id->num_rows()>0) {
            $agent_id=$agent_id->row()->id;
            /*$sql="SELECT sum(if(is_reply=1,1,0)) as recieve,sum(if(is_reply=0,1,0)) as send FROM `whatsapp_chat` where agent_id=$agent_id and type='$type' group by agent_id";*/

            $total="select count(*) as total from( select count(*) as total from whatsapp_chat where chat_time like '".date('Y-m-d')."%' and type='$type' group by cust_id ) as a";

            $total=$this->db->query($total)->row()->total;

            $recieve="select count(*) as recieve from( select count(*) as recieve from whatsapp_chat where agent_id=$agent_id and chat_time like '".date('Y-m-d')."%' and type='$type' and is_reply=1 group by cust_id ) as a";

            $recieve=$this->db->query($recieve)->row()->recieve;

            $send="select count(*) as send from( select count(*) as send from whatsapp_chat where agent_id=$agent_id and chat_time like '".date('Y-m-d')."%' and type='$type' and is_reply=0 group by cust_id ) as a";


            $send=$this->db->query($send)->row()->send;
            
            $sql="select count(*) as queue from (SELECT count(*) as queue FROM `whatsapp_chat` where type='$type' and chat_time like '".date('Y-m-d')."%' and is_reply=1 and agent_id=0 GROUP by cust_id) a";

            $hasil=$this->db->query($sql)->row()->queue;

            

            /*if($hasil->num_rows()>0){

                $queue = $hasil->row()->queue;                
               

            } else {
                $queue = 0;
            }*/

          $result= array('total' =>$total ,'recieve'=>$recieve,'send'=>$send,'queue'=>$hasil);

        } else {
            $result= array('total' =>0 ,'recieve'=>0,'send'=>0,'queue'=>0 );
            /*$return->total=0;
            $return->recieve=0;
            $return->send=0;
            $result->queue=0;*/
        }
        

        return $result;
    }
    
    

    function history_chat($type,$agent_id,$phone){
        $sql="SELECT sum(if(status='unread',1,0)) as ttl FROM `whatsapp_chat` where agent_id=$agent_id and wa_number=$phone and is_reply=1 and type='$type'";
        //var_dump($sql);exit();
        $result=$this->db->query($sql)->row()->ttl;
        return $result;   
    }

    function get_customer_name($phone){

        $sql="SELECT CONCAT(COALESCE(cus_fname,''),' ',COALESCE(cus_lname,'')) as name FROM `whatsapp_cust` where cus_phone=$phone";
      // var_dump($this->db->query($sql)->row());exit();
        $result=$this->db->query($sql)->row()->name;

        $result=$result==' '?$phone:$result;
        
        return $result; 

    }


}




