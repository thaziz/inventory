<?php

class Report_calls_model extends CI_Model {

   private $pref = '';
   var $table = 'v_ticket';
   
   public function __construct(){
       parent::__construct();
       $this->table = $this->pref.$this->table;
   }



    function agent_activity($date,$date2){
        


      $date.=' 00:00:00';
      $date2.=' 23:59:59';

      $sql = "SELECT `agent`.`number`,`agent`.`name`,DATE_FORMAT(`audit`.`datetime_init`,'%Y-%m-%d') AS `dates`,
                    MIN(DATE_FORMAT(`audit`.`datetime_init`,'%H:%i:%s')) AS `login`,
                    MAX(DATE_FORMAT(`audit`.`datetime_end`,'%H:%i:%s')) AS `logout`,
                    TIMEDIFF(MAX(DATE_FORMAT(`audit`.`datetime_end`,'%H:%i:%s')),MIN(DATE_FORMAT(`audit`.`datetime_init`,'%H:%i:%s'))) AS `total_login_time`,d.cluster
                    FROM call_center.`agent`
                    INNER JOIN call_center.`audit`
                    ON call_center.`agent`.`id` = `audit`.`id_agent`
                    INNER JOIN `kanmo`.`v_ext_cluster` `d`
            ON `d`.`user_ext` = `agent`.`number`
                    WHERE `audit`.`datetime_init` >= '".$date."' and `audit`.`datetime_init` <= '".$date2."'
                    AND `audit`.`id_break` IS NULL and estatus='A'";
      
      $sql .=" GROUP BY `agent`.`number` order by `agent`.`name` ASC";

      $agen=$this->db->query($sql)->result();



      $sql = "SELECT b.number,b.name,STR_TO_DATE(datetime_entry_queue,'%Y-%m-%d') as dates ,
          sum(a.duration) as total_time, count(a.id) as total
          FROM call_center.call_entry a
          INNER JOIN call_center.agent b
          ON a.id_agent=b.id
          INNER JOIN call_center.queue_call_entry c
          ON c.id = a.id_queue_call_entry
          WHERE a.datetime_entry_queue >= '".$date."'
          and a.datetime_entry_queue <= '".$date2."'
          And b.estatus='A'
          AND a.status = 'terminada'";
          $sql.=" GROUP BY a.id_agent ORDER BY b.name";
            

      $inc_call=$this->db->query($sql)->result();

      


      $sql = "SELECT b.number,STR_TO_DATE(a.calldate,'%Y-%m-%d') as dates,b.name,a.src,count(*) as total
      FROM asteriskcdrdb.cdr a
      LEFT JOIN call_center.agent b ON b.number=a.src
      WHERE a.dstchannel LIKE '%tr-firstroute%' AND a.disposition='ANSWERED'
      AND a.calldate >= '".$date."'
      AND a.calldate <= '".$date2."'
      And b.estatus='A'
      GROUP BY a.src  order by a.calldate ";

      $out_call=$this->db->query($sql)->result();



$data_arr=[];

      foreach ($agen as $key => $val) {
        $data_arr[$key]['number']=$val->number;
        $data_arr[$key]['name']=$val->name;
        $data_arr[$key]['login']=$val->login;
        $data_arr[$key]['incoming']=$this->chek($val->number,$inc_call);
        $data_arr[$key]['outgoing']=$this->chek($val->number,$out_call);
        $data_arr[$key]['type']=$val->cluster;
        
        $data_arr[$key]['total_calls']=$data_arr[$key]['incoming']+$data_arr[$key]['outgoing'];

   
      }

return $data_arr;

    }



function find($number,$name,$time_arr){
    foreach ($time_arr as $key => $val) {
        if($val->description==$name && $val->number==$number){
            return $val->description=$val->time;
        }
                    
    }
}



function chek($number,$data){
  $hasil='';
      foreach ($data as $key => $value) {
         if($number==$value->number) {
            $hasil=$value->total;
         }
      }
      if($hasil==''){
        $hasil=0;
      }
      return $hasil;
}





}
