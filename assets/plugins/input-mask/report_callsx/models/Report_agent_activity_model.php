<?php

class Report_agent_activity_model extends CI_Model {

   private $pref = '';
   var $table = 'v_ticket';
   
   public function __construct(){
       parent::__construct();
       $this->table = $this->pref.$this->table;
   }



    function agent_activity($type,$date,$date2){
        

        if($type=='KANMO'){
            $setQueue=900;
        }
        else if($type=='NESPRESSO'){
            $setQueue=901; 
        }

      $date.=' 00:00:00';
      $date2.=' 23:59:59';

      $sql = "SELECT `agent`.`number`,`agent`.`name`,DATE_FORMAT(`audit`.`datetime_init`,'%Y-%m-%d') AS `dates`,
                    MIN(DATE_FORMAT(`audit`.`datetime_init`,'%H:%i:%s')) AS `login`,
                    MAX(DATE_FORMAT(`audit`.`datetime_end`,'%H:%i:%s')) AS `logout`,
                    TIMEDIFF(MAX(DATE_FORMAT(`audit`.`datetime_end`,'%H:%i:%s')),MIN(DATE_FORMAT(`audit`.`datetime_init`,'%H:%i:%s'))) AS `total_login_time`
                    FROM call_center.`agent`
                    INNER JOIN call_center.`audit`
                    ON call_center.`agent`.`id` = `audit`.`id_agent`
                    INNER JOIN `kanmo`.`v_ext_cluster` `d`
            ON `d`.`user_ext` = `agent`.`number`
                    WHERE `audit`.`datetime_init` >= '".$date."' and `audit`.`datetime_init` <= '".$date2."'
                    AND `audit`.`id_break` IS NULL and estatus='A'";
      if($type!='ALL'){
      $sql .=" AND (`d`.`cluster` = '".$type."' OR `d`.`cluster` = 'both')";
      }
      $sql .=" GROUP BY `agent`.`number` order by `agent`.`name` ASC";

      $agen=$this->db->query($sql)->result();




      $sql="SELECT ag.number as number,b.description, SEC_TO_TIME(COALESCE(sum(time_to_sec(au.duration)),0)) AS total_time
        FROM call_center.`break` b
        left JOIN call_center.`audit` AS au ON (b.id = au.id_break)
        left JOIN call_center.`agent` AS ag ON (ag.id=au.id_agent And estatus='A') 
        left JOIN kanmo.v_ext_cluster AS ext ON (ext.user_ext = ag.number) 
        WHERE ("; 
      if($type!='ALL'){
          $sql.= "ext.cluster='".$type."'  AND"; 
      }
        $sql.= " b.name LIKE '%Follow%')
           AND au.datetime_init >='".$date."'
           AND au.datetime_init <='".$date2."'";
      if($type!='ALL'){
        $sql.="OR (ext.cluster='BOTH'  AND 
           b.name LIKE '%Follow%')
          AND au.datetime_init >='".$date."'
          AND au.datetime_init <='".$date2."'";
      }
      $sql.=" GROUP BY ag.number";

      $follow=$this->db->query($sql)->result();




      $sql = "SELECT b.number,b.name,STR_TO_DATE(datetime_entry_queue,'%Y-%m-%d') as dates ,
          sum(a.duration) as total_time, count(a.id) as total,
          avg(a.duration) as time_avg
          FROM call_center.call_entry a
          INNER JOIN call_center.agent b
          ON a.id_agent=b.id
          INNER JOIN call_center.queue_call_entry c
          ON c.id = a.id_queue_call_entry
          WHERE a.datetime_entry_queue >= '".$date."'
          and a.datetime_entry_queue <= '".$date2."'
          And b.estatus='A'
          AND a.status = 'terminada'";
          if($type!='ALL'){
            $sql.= " AND c.queue = ".$setQueue."";
          }
            $sql.=" GROUP BY a.id_agent ORDER BY b.name";
            

      $inc_call=$this->db->query($sql)->result();

      


      $sql = "SELECT b.number,STR_TO_DATE(a.calldate,'%Y-%m-%d') as dates,b.name,a.src,count(*) as total,
      sum(a.billsec) as total_time,
      avg(a.billsec) as time_avg
      FROM asteriskcdrdb.cdr a
      LEFT JOIN call_center.agent b ON b.number=a.src
      WHERE a.dstchannel LIKE '%tr-firstroute%' AND a.disposition='ANSWERED'
      AND a.calldate >= '".$date."'
      AND a.calldate <= '".$date2."'
      And b.estatus='A'
      GROUP BY a.src  order by a.calldate ";

      $out_call=$this->db->query($sql)->result();


      /*(v.open_date >= '2019-08-19 00:00:00' and v.open_date <='2019-08-26 23:59:59') and date(v.open_date) <> date(v.closed_date)*/
      //ganti raised
      $sql = "SELECT v.open_by as number,COUNT(*) as total FROM kanmo.v_ticket AS v
               WHERE (date(v.open_date) >= '".$date."' And date(v.open_date) <= '".$date2."') AND date(v.open_date) <> date(v.closed_date) ";
      if($type!='ALL'){
          $sql.= " AND type='".$type."'";
      }   
      $sql.= " GROUP BY v.open_by";
      $raised=$this->db->query($sql)->result();


 $sql = "SELECT b.number,b.name, count(a.created) as total
              FROM `asteriskcdrdb`.`agent_abn` a
              INNER JOIN call_center.agent b
              ON a.agent_name=b.name
              WHERE (date(a.created) >= '".$date."' And date(a.created) <= '".$date2."') And b.estatus='A'";
              if($type!='ALL'){
            $sql.= " AND a.queuename = ".$setQueue."";
              }
               
       $sql.=" GROUP BY b.number 
              ORDER BY b.name";
              
      $abandoned_in_number=$this->db->query($sql)->result();



      $sql = "SELECT v.closed_by as number,COUNT(*) total FROM kanmo.v_ticket AS v
           WHERE date(v.closed_date) >= '".$date."' And date(v.closed_date) <= '".$date2."' AND v.status='closed'";
      if($type!='ALL'){
          $sql.= " AND type='".$type."'";
      }
          $sql.= " GROUP BY v.closed_by";

      $closed=$this->db->query($sql)->result();
      



      $sql = "SELECT `a`.`id`,`a`.`name`,`a`.`number`,CONCAT(`c`.`name`,'-',`c`.`description`) AS `break_name`,
      SEC_TO_TIME(SUM(TIME_TO_SEC(`b`.`duration`))) AS `total_time`,`d`.`cluster`
      FROM call_center.`agent` `a`
      INNER JOIN call_center.`audit` `b`
      ON `a`.`id` = `b`.`id_agent`
      INNER JOIN call_center.`break` `c`
      ON `c`.`id` = `b`.`id_break`
      INNER JOIN `kanmo`.`v_ext_cluster` `d`
      ON `d`.`user_ext` = `a`.`number`
      WHERE `b`.`datetime_init` >= '".$date."'
      and `b`.`datetime_init` <= '".$date2."'
      AND `c`.`name` IN ('Lunch','Pray','Toilet')
      AND `c`.`status` = 'A'
      And a.estatus='A'
      AND `b`.`id_break` IS NOT NULL ";
      if($type!='ALL'){
          $sql.=" AND (`d`.`cluster` = '".$type."' OR `d`.`cluster` = 'both')";
      }
      $sql.=" GROUP BY `a`.`id` ORDER BY `b`.`datetime_init` ASC";

    $break=$this->db->query($sql)->result();



$sql = "SELECT `a`.`id`,`a`.`name`,`a`.`number`,CONCAT(`c`.`name`,'-',`c`.`description`) AS `break_name`,
      SEC_TO_TIME(SUM(TIME_TO_SEC(`b`.`duration`))) AS `total_time`,`d`.`cluster`
      FROM call_center.`agent` `a`
      INNER JOIN call_center.`audit` `b`
      ON `a`.`id` = `b`.`id_agent`
      INNER JOIN call_center.`break` `c`
      ON `c`.`id` = `b`.`id_break`
      INNER JOIN `kanmo`.`v_ext_cluster` `d`
      ON `d`.`user_ext` = `a`.`number`
      WHERE 
      `b`.`datetime_init` >= '".$date."'
      and `b`.`datetime_init` <= '".$date2."'
      AND `c`.`name` IN ('Training','Meeting','Coaching')
      AND `c`.`status` = 'A'
      And a.estatus='A'
      AND `b`.`id_break` IS NOT NULL";
      if($type!='ALL'){
        $sql.=" AND (`d`.`cluster` = '".$type."' OR `d`.`cluster` = 'both')";
      }
        $sql.=" GROUP BY `a`.`id` ORDER BY `b`.`datetime_init` ASC";

$data_arr=[];
  $other=$this->db->query($sql)->result();

$sql="select `agent`.`number`, j.time, DATE_FORMAT(a2.waktu,'%H:%i:%s') as login,
 sum(if(DATE_FORMAT(a1.`datetime_init`,'%H:%i:%s')<=if(j.time is null,'10:00:00',j.time),15,-15)) as total from 
call_center.audit a1 
JOIN (select MIN(a.`datetime_init`) as waktu,a.id_agent as id_agent2 from call_center.audit a group by date(a.datetime_init),a.id_agent) as a2 
on (a1.id_agent = a2.id_agent2 and a2.waktu=a1.datetime_init) 
JOIN  call_center.`agent` ON call_center.`agent`.`id` = a1.`id_agent`  
JOIN `kanmo`.`v_ext_cluster` `d` ON `d`.`user_ext` = `agent`.`number` 
left JOIN kanmo.agent_schedule as j on (agent.id=j.id_agent and date(a1.datetime_init)=j.date)
where a1.`datetime_init` >= '$date' AND a1.`datetime_init` <= '$date2' AND a1.`id_break` IS NULL And estatus='A'";
if($type!='ALL'){
      $sql.=" AND (`d`.`cluster` = '".$type."' OR `d`.`cluster` = 'both') ";
    }

 $sql.="group BY a1.id_agent order by a1.id_agent";

/*var_dump($sql);
exit();*/

/*
$sql = "SELECT `agent`.`number`,MIN(DATE_FORMAT(`audit`.`datetime_init`,'%H:%i:%s')) AS `login`, sum(if(DATE_FORMAT(`audit`.`datetime_init`,'%H:%i:%s')<='09:00:00',15,-15)) as total FROM call_center.`agent` INNER JOIN call_center.`audit` ON call_center.`agent`.`id` = `audit`.`id_agent` INNER JOIN `kanmo`.`v_ext_cluster` `d` ON `d`.`user_ext` = `agent`.`number` WHERE `audit`.`datetime_init` >= '".$date."' and `audit`.`datetime_init` <= '".$date2."' AND `audit`.`id_break` IS NULL ";
    if($type!='ALL'){
      $sql.=" AND (`d`.`cluster` = '".$type."' OR `d`.`cluster` = 'both')";
    }
        $sql.=" GROUP BY `agent`.`name` ASC";*/
        
//waktu masih manual

      

$bonus=$this->db->query($sql)->result();


  
$rank=[];
      foreach ($agen as $key => $val) {
        $data_arr[$key]['number']=$val->number;
        $data_arr[$key]['name']=$val->name;
        $data_arr[$key]['login']=$val->login;
        $data_arr[$key]['incoming']=$this->chek($val->number,$inc_call);
        $data_arr[$key]['outgoing']=$this->chek($val->number,$out_call);
        $data_arr[$key]['abandoned_in_number']=$this->chek($val->number,$abandoned_in_number);

        
        $data_arr[$key]['raised']=$this->chek($val->number,$raised);
        $data_arr[$key]['closed']=$this->chek($val->number,$closed);
        $data_arr[$key]['call_total']=$data_arr[$key]['incoming']+$data_arr[$key]['outgoing'];
        $data_arr[$key]['ticket_total']=$data_arr[$key]['raised']+$data_arr[$key]['closed'];

        $data_arr[$key]['bonus']=$this->chek($val->number,$bonus);

        $data_arr[$key]['weigh']=$data_arr[$key]['ticket_total']+($data_arr[$key]['call_total']*1.5)+$data_arr[$key]['bonus']-($data_arr[$key]['abandoned_in_number']*5);
        $rank['weigh'][$key]=$data_arr[$key]['weigh'];
        $rank['number'][$key]=$data_arr[$key]['number'];
        $data_arr[$key]['rank']=1;
      }

$array=[];
if(isset($rank['weigh'])){

$values = $rank['weigh'];


$array = $data_arr;

function compareTabAndOrder($a, $b) {
    // compare the tab option value
    $diff = $a['weigh'] - $b['weigh'];
    // and return it. Unless it's zero, then compare order, instead.
    return ($diff !== 0) ? $diff : $a->order - $b->order;
}

usort($array, "compareTabAndOrder");

}

return $array;

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
