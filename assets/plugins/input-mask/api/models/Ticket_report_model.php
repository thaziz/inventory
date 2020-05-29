<?php

class Ticket_report_model extends CI_Model {

   private $pref = '';
   var $table = 'v_ticket';
   
   public function __construct(){
       parent::__construct();
       $this->load->database();
       $this->table = $this->pref.$this->table;
   }

   public function agent_list($type){
    $agent = $this->db->select('number, name')->join('kanmo.v_ext_cluster b', 'a.number=b.user_ext')
    ->where('cluster',$type)->or_where('cluster','both')->group_by('number')->order_by('number', 'asc')->get('call_center.agent a')->result();
    return $agent;
   }

   public function filer_data(){
      $this->db->select('brand');
      $this->db->group_by('brand');
      $this->db->where("brand is  NOT NULL");
      $brands=$this->db->get($this->table)->result();
      $this->db->select('source');
      $this->db->group_by('source');      
      $this->db->where("source is  NOT NULL");
      $sources=$this->db->get($this->table)->result();
      $this->db->select('main_category');
      $this->db->group_by('main_category');
      $this->db->where("main_category is  NOT NULL");
      $main_categorys=$this->db->get($this->table)->result();
      $data=['brands'=>$brands,'sources'=>$sources,'main_categorys'=>$main_categorys];
      return $data;
   }

   public function where_by_date(
    $type=null,
    $periode_awal=null,
    $periode_akhir=null,
    $periode_thn=null,
    $default
  ){

      $this->db->where('IF(status="OPEN",open_date, closed_date) BETWEEN "'. date('Y-m-d', strtotime($periode_awal)). '" and "'. date('Y-m-d', strtotime($periode_akhir)).'"');
          
      
         
     if(isset($_POST['brand']) && $_POST['brand']!='-'){
        $this->db->where('brand',$_POST['brand']);
      }
    if($_POST['source']!='-'){
        $this->db->where('source',$_POST['source']);
      }
    if($_POST['main_category']!='-'){
        $this->db->where('main_category',$_POST['main_category']);
      }
}

   public function load(
    $type=null,
    $periode_awal=null,
    $periode_akhir=null,
    $periode_thn=null,
    $default=null
  ){
    if($_POST['jenis']=='Quarterly' ||$_POST['jenis']=='Yearly'){
        $this->db->select("
        (SELECT COUNT(*) FROM v_ticket 
        WHERE Year(open_date)='".$periode_thn."')  as total_create,
                          COALESCE(SUM(IF(status='OPEN',1,0)),0) as total_open,
                          COALESCE(SUM(IF(status='CLOSED',1,0)),0) as total_closed,
        SUM(IF(status='CLOSED',TIMESTAMPDIFF(SECOND, open_date, closed_date),0)) as co"
                        );   
      }
    else{
       $this->db->select("
        (SELECT COUNT(*) FROM v_ticket WHERE date(open_date)>='".$periode_awal."' AND date(open_date)<='".$periode_akhir."')  as total_create,
                          COALESCE(SUM(IF(status='OPEN',1,0)),0) as total_open,
                          COALESCE(SUM(IF(status='CLOSED',1,0)),0) as total_closed,
                          SUM(IF(status='CLOSED',TIMESTAMPDIFF(SECOND, open_date, closed_date),0)) as co"
                        );   
    }

      $this->where_by_date(
          $type,
          $periode_awal,
          $periode_akhir,
          $periode_thn,
          $default
      );
    $this->db->where('type',$type);
    return  $this->db->get($this->table)->result();
   }

   public function sec_to_time($sec){
    return $this->db->query("SELECT SEC_TO_TIME($sec) as time")->row()->time;
   }
   public function jenis(){
      if(isset($_POST['jenis'])){
          if($_POST['jenis']=='Daily'){
            $this->db->
                 select(
                  "DATE_FORMAT(IF(status='OPEN',open_date, closed_date),'%d-%M-%Y') as date, IFNULL(brand, 'Nespresso') as brand, source, main_category, category, sub_category, SUM(IF(status='OPEN',1,0)) as total_open, SUM(IF(status='CLOSED',1,0)) as total_closed"
                  );
          }
          else if($_POST['jenis']=='Monthly'){
            $this->db->
                 select(
                  "DATE_FORMAT(IF(status='OPEN',open_date, closed_date),'%M-%Y') as date, IFNULL(brand, 'Nespresso') as brand, source, main_category, category, sub_category, SUM(IF(status='OPEN',1,0)) as total_open, SUM(IF(status='CLOSED',1,0)) as total_closed"
                  );
          }
           else if($_POST['jenis']=='Yearly'){
            $this->db->
                 select(
                  "DATE_FORMAT(IF(status='OPEN',open_date, closed_date),'%Y') as date, IFNULL(brand, 'Nespresso') as brand, source, main_category, category, sub_category, SUM(IF(status='OPEN',1,0)) as total_open, SUM(IF(status='CLOSED',1,0)) as total_closed"
                  );
          }
          else if($_POST['jenis']=='Weekly'){
            $this->db->
                 select(
                  "WEEK(IF(status='OPEN',open_date, closed_date))+1 as date, IFNULL(brand, 'Nespresso') as brand, source, main_category, category, sub_category, SUM(IF(status='OPEN',1,0)) as total_open, SUM(IF(status='CLOSED',1,0)) as total_closed"
                  );
          }
           else if($_POST['jenis']=='Quarterly'){
            $this->db->
                 select(
                  "QUARTER(IF(status='OPEN',open_date, closed_date)) as date, IFNULL(brand, 'Nespresso') as brand, source, main_category, category, sub_category, SUM(IF(status='OPEN',1,0)) as total_open, SUM(IF(status='CLOSED',1,0)) as total_closed"
                  );
          }

      }
   }

    public function load_data($type=null,
      $periode_awal=null,
        $periode_akhir=null,
        $periode_thn=null,
        $default=null)
    {
        $this->jenis();
        $this->where_by_date($type,$periode_awal,
        $periode_akhir,$periode_thn,
        $default);
        $this->db->where('type',$type);
        $this->db->group_by(array(
        "date","brand","source","main_category",
        "category","sub_category"));        
         $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result();
    }

   /*public function count_filtered($type)
    {
        $this->data_table($type);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
       $this->db->from($this->table);
        return $this->db->count_all_results();
    }*/


    public function call_count($date1, $date2, $type, $agent = null){
      if($type=='kanmo'){
        $type = 2;
      }else{
        $type = 1;
      }
      $offercall = $this->db->select('COUNT(*) total')->where(array('datetime_entry_queue>='=>$date1.' 00:00:00', 'datetime_entry_queue<='=>$date2.' 23:59:59', 'id_queue_call_entry'=>$type))->get('call_center.call_entry',1)->row()->total;

      $abn = $this->db->select('COUNT(*) total')->where(array('datetime_entry_queue>='=>$date1.' 00:00:00', 'datetime_entry_queue<='=>$date2.' 23:59:59', 'id_queue_call_entry'=>$type, 'status<>'=>'terminada'))->get('call_center.call_entry',1)->row()->total;

      $this->db->select('COUNT(*) total');
      if($agent!=null){
        $this->db->join('call_center.agent a', 'a.id=c.id_agent');
        $this->db->where('a.number',$agent);
      }
      $this->db->where(array('c.datetime_entry_queue>='=>$date1.' 00:00:00', 'c.datetime_entry_queue<='=>$date2.' 23:59:59', 'c.id_queue_call_entry'=>$type, 'c.status'=>'terminada'));
      $answer = $this->db->get('call_center.call_entry c',1)->row()->total;

      $this->db->select('SEC_TO_TIME(SUM(duration)/COUNT(*)) aht', false);
      if($agent!=null){
        $this->db->join('call_center.agent a', 'a.id=c.id_agent');
        $this->db->where('a.number',$agent);
      }
      $this->db->where(array('c.datetime_entry_queue>='=>$date1.' 00:00:00', 'c.datetime_entry_queue<='=>$date2.' 23:59:59', 'c.id_queue_call_entry'=>$type, 'c.status'=>'terminada'));
      $aht = $this->db->get('call_center.call_entry c',1)->row()->aht;

      $ivr = $this->db->select('COUNT(*) total')
                    ->group_start()
                    ->like('dcontext', 'app-announcement', 'after')->or_like('dcontext', 'ivr-1', 'after')
                    ->group_end()
                    ->where(array('calldate>='=>$date1.' 00:00:00', 'calldate<='=>$date2.' 23:59:59'))
                    ->get('asteriskcdrdb.cdr',1)->row()->total;

      return array('offer'=>$offercall, 'answer'=>$answer, 'abandoned'=>$abn, 'aht'=>explode('.',$aht)[0], 'abn_ivr'=>$ivr);
    }
   
   
   public function email_count($date1, $date2, $type){
    $total = $this->db->select('COUNT(*) total')
              ->where(array('open_date>='=> $date1.' 00:00:00','open_date<='=> $date2.' 23:59:59', 'type'=>$type, 'is_read <='=> 3))
              ->get('v_email',1)->row()->total;
    $email = 'support@kanmogroup.com';
    if($type=='nespresso'){
      $email = 'club.indonesia@nespresso.co.id';
    }
    $total += $this->db->select('COUNT(a.id) total')
    		  ->join('v_ticket b', 'a.ticket_id=b.id')
              ->where(array('a.time>='=> $date1.' 00:00:00','a.time<='=> $date2.' 23:59:59', 'a.email<>'=>$email, 'b.type'=>strtoupper($type)))
              ->get('v_email_customer a',1)->row()->total;

    $total += $this->db->select('COUNT(*) total')
              ->where(array('time>='=> $date1.' 00:00:00','time<='=> $date2.' 23:59:59', 'email_from<>'=>$email, 'type'=>$type))
              ->get('v_email_reply',1)->row()->total;
              //echo $this->db->last_query();exit;

    /*$reply = $this->db->select('COUNT(*) total')
              ->where(array('open_date>='=> $date1.' 00:00:00','open_date<='=> $date2.' 23:59:59', 'type'=>$type, 'is_read<='=>3, 'is_read>='=>2))
              ->get('v_email',1)->row()->total;*/

    $reply = $this->db->select('COUNT(*) total')
              ->join('v_ticket b', 'a.id=b.mail_id')
              ->where(array('a.open_date>='=> $date1.' 00:00:00','a.open_date<='=> $date2.' 23:59:59', 'a.type'=>$type, 'a.is_read'=>3))
              ->get('v_email a',1)->row()->total;

    $reply += $this->db->select('COUNT(r.parent_id) total')
              ->join('v_email_reply r', 'a.id=r.parent_id and email_from=\''.$email.'\'')
              ->where(array('a.open_date>='=> $date1.' 00:00:00','a.open_date<='=> $date2.' 23:59:59', 'a.type'=>$type, 'a.is_read'=>2))
              ->get('v_email a',1)->row()->total;

    $reply += $this->db->query("SELECT count(DISTINCT a.id) as total FROM `v_email_customer` a JOIN (SELECT * FROM v_email_customer WHERE email = '$email') b ON (a.ticket_id=b.ticket_id) AND a.time < b.time JOIN v_ticket c ON (a.ticket_id=c.id) WHERE a.email <> '$email' and (a.time >= '$date1 00:00:00' and a.time <= '$date2 23:59:59') AND c.type = '".strtoupper($type)."'")->row()->total;

    $reply += $this->db->select('COUNT(*) total')
              ->where(array('time>='=> $date1.' 00:00:00','time<='=> $date2.' 23:59:59', 'email_from<>'=>$email, 'type'=>$type, 'is_read'=>2))
              ->get('v_email_reply',1)->row()->total;

    /*$reply += $this->db->select('COUNT(DISTINCT(ticket_id)) total')
              ->where(array('time>='=> $date1.' 00:00:00','time<='=> $date2.' 23:59:59', 'email'=>$email))
              ->get('v_email_customer',1)->row()->total;*/

    $_reply = $this->db->select('COUNT(DISTINCT(r.parent_id)) total, TIMESTAMPDIFF(HOUR, a.open_date, r.time)/24 as totalhour')
              ->join('v_email_reply r', 'a.id=r.parent_id and email_from=\''.$email.'\'')
              ->where(array('a.open_date>='=> $date1.' 00:00:00','a.open_date<='=> $date2.' 23:59:59', 'a.type'=>$type, 'a.is_read'=>2))
              ->group_by('totalhour')
              ->get('v_email a')->result();
    $reply24 = 0;
    $reply224 = 0;
    $reply024 = 0;
    foreach ($_reply as $key => $value) {
      if($value->totalhour<=1){
        $reply24 += $value->total;
      }else if($value->totalhour>1 && $value->totalhour<=2){
        $reply224 += $value->total;
      }else{
        $reply024 += $value->total;
      }
    }

    $result = $this->db->select('COUNT(*) total, TIMESTAMPDIFF(HOUR, a.open_date, b.open_date)/24 as totalhour')
              ->join('v_ticket b', 'a.id=b.mail_id')
              ->where(array('a.open_date>='=> $date1.' 00:00:00','a.open_date<='=> $date2.' 23:59:59', 'a.type'=>$type, 'a.is_read'=>3))
              ->group_by('totalhour')
              ->get('v_email a')->result();

    foreach ($result as $key => $value) {
      if($value->totalhour<=1){
        $reply24 += $value->total;
      }else if($value->totalhour>1 && $value->totalhour<=2){
        $reply224 += $value->total;
      }else{
        $reply024 += $value->total;
      }
    }

    $result =  $this->db->query("SELECT COUNT(x.id) as total, TIMESTAMPDIFF(HOUR, x.time, x.reply_time)/24 as totalhour FROM (SELECT a.id, a.time, b.time as reply_time FROM `v_email_customer` a JOIN (SELECT * FROM v_email_customer WHERE email = 'support@kanmogroup.com') b ON (a.ticket_id=b.ticket_id) AND a.time < b.time JOIN v_ticket c ON (a.ticket_id=c.id) WHERE a.email <> 'support@kanmogroup.com' and a.time >= '$date1 00:00:00' and a.time<= '$date2 23:59:59' and c.type = '".strtoupper($type)."' GROUP BY a.id) x GROUP BY totalhour")->result();

    foreach ($result as $key => $value) {
      if($value->totalhour<=1){
        $reply24 += $value->total;
      }else if($value->totalhour>1 && $value->totalhour<=2){
        $reply224 += $value->total;
      }else{
        $reply024 += $value->total;
      }
    }

    return array('total'=>$total, 'reply'=>$reply, 'reply24'=>$reply24, 'reply224'=>$reply224, 'replymore'=>$reply024);
   }
   
   
   
}