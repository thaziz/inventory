<?php

class Report_wallboard_model extends CI_Model {

   private $pref = '';
   var $table = 'v_ticket';
   
   public function __construct(){
       parent::__construct();
       $this->table = $this->pref.$this->table;
   }

   function calls($type,$date){
        if ($type=='kanmo') {
            $did = '02129181155';
            $queue='900';
        }else if($type='nespresso'){
            $did = '02129181157';
            $queue='901';
        }

        $sql="SELECT daytime_init, daytime_end FROM call_center.campaign_entry where name='".$type."'";
        $operasional=$this->db->query($sql)->row();

        $time_init=$operasional->daytime_init;
        $time_end=$operasional->daytime_end;


        $sql="SELECT COUNT(*) as total FROM call_center.call_entry AS ce
                  JOIN call_center.queue_call_entry AS qce ON (qce.id=ce.id_queue_call_entry)
                  WHERE ce.datetime_entry_queue >='".$date." ".$time_init."'  and ce.datetime_entry_queue <='".$date." ".$time_end."'
                  AND ce.`status`='terminada'
                  AND qce.queue='".$queue."'";
        $data['answer']=$this->db->query($sql)->row();

        



        $sql="SELECT COUNT(*) as total FROM call_center.call_entry AS ce
                  JOIN call_center.queue_call_entry AS qce ON (qce.id=ce.id_queue_call_entry)
                  WHERE date(ce.datetime_entry_queue)='".$date."' AND ce.`status`='abandonada'
                  AND qce.queue='".$queue."'";
        $data['abandon']=$this->db->query($sql)->row();





        $sql = "SELECT count(calldate) as abnivr FROM asteriskcdrdb.cdr WHERE dcontext LIKE 'app-announcement%' AND (dcontext <>'app-announcement-4' AND dcontext <>'app-announcement-5' AND dcontext <>'app-announcement-9') AND disposition = 'ANSWERED' AND (calldate >= '".$date." ".$time_init."' AND calldate <= '".$date." ".$time_end."') AND did = '".$did."' GROUP BY did";
        $data['abnivr']=$this->db->query($sql)->row();


      

        $sql ="SELECT count(calldate) as total FROM asteriskcdrdb.`cdr` WHERE (dst='hangup' OR dst='s') AND disposition='ANSWERED' AND ((calldate >= '".$date." 00:00:00' AND calldate < '".$date." ".$time_init."') OR (calldate > '".$date." ".$time_end."' AND calldate <= '".$date." 23:59:59')) AND did = '".$did."'";
        $data['earlyabn']=$this->db->query($sql)->row();



        $sql ='SELECT DISTINCT callerid AS `caller_attempt`
                            FROM call_center.call_entry
                            INNER JOIN call_center.queue_call_entry
                            ON `queue_call_entry`.`id` = `call_entry`.`id_queue_call_entry`
                            WHERE datetime_entry_queue >= "'.$date.' 00:00:00" AND datetime_entry_queue <= "'.$date.' 23:59:59"
                            AND status = "abandonada"
                            AND `queue_call_entry`.`queue` = "'.$queue.'"';

        $data['abd_call_unique']=$this->db->query($sql)->result();
        $abd_call_unique=[];
        foreach($data['abd_call_unique'] as $val)
        {
		    $abd_call_unique[] = $val->caller_attempt;
		}
		if(count($abd_call_unique)>0){

			   $sql = 'SELECT DISTINCT callerid AS `phone`
                            FROM call_center.call_entry
                            INNER JOIN call_center.queue_call_entry
                            ON `queue_call_entry`.`id` = `call_entry`.`id_queue_call_entry`
                            WHERE datetime_entry_queue >= "'.$date.' 00:00:00" AND datetime_entry_queue <= "'.$date.' 23:59:59"
                            AND status = "terminada" AND callerid IN ("'.implode('","',$abd_call_unique).'")
                            AND `queue_call_entry`.`queue` = "'.$queue.'"';

        $data['sql_unique_answered']=$this->db->query($sql)->result();          
        $sql_unique_answered=array();
        if (count($data['sql_unique_answered']) > 0) {
	        foreach($data['sql_unique_answered'] as $val)
	        {
			    $sql_unique_answered[] = $val->phone;
			}
			$data['unique_abn_notanswered'] = array_diff($abd_call_unique, $sql_unique_answered);
		}else{
			$data['unique_abn_notanswered']=[];
		}
        	if(count($sql_unique_answered)>0){
        $sql = 
        "SELECT DISTINCT dst as phone FROM `asteriskcdrdb`.`cdr` WHERE `calldate` LIKE '".$date."%' AND duration >= 5 AND dcontext = 'from-internal' AND dst IN ('".implode("','",$data['unique_abn_notanswered'] )."')";                        
		        $data['abd_call_reachout']=$this->db->query($sql)->result();                         
		      	}else{
                $data['abd_call_reachout']= array();
          	}

		}else{
            $data['unique_abn_notanswered'] = $abd_call_unique;
            $data['abd_call_reachout'] = $abd_call_unique;

        }
	


  $sql="SELECT SUM(IF(ce.status='terminada', ce.duration, 0))/count(*) as total, count(*) as total_calls FROM call_center.call_entry AS    ce JOIN call_center.queue_call_entry AS qce ON (qce.id=ce.id_queue_call_entry)
                  WHERE date(ce.datetime_entry_queue)='".$date."' AND qce.queue='".$queue."'";
  $data['aht']=$this->db->query($sql)->row();





        


        $data_arr=[];

                  
                  
        if($data['answer']!=NULL){
            $data_arr['a']=$data['answer']->total;
        }else{
            $data_arr['a']=0;
        }

        if($data['abandon']!=NULL){
            $data_arr['b']=$data['abandon']->total;
        }else{
            $data_arr['b']=0;
        }



                  
        //offered call
        $data_arr['c']=$data_arr['a']+$data_arr['b'];


        //sla
        if($data_arr['c']!=0){
          $data_arr['d']=number_format($data_arr['a']/$data_arr['c'],2,'.',',');
        }else{
          $data_arr['d']=0;
        }
                  
                  

        if($data['earlyabn']!=NULL){
            $data_arr['e']=$data['earlyabn']->total;
        }else{
            $data_arr['e']=0;
        }

        if($data['abnivr']!=NULL){
            $data_arr['f']=$data['abnivr']->abnivr;
        }else{
            $data_arr['f']=0;
        }

        if($data['abd_call_unique']!=NULL){
            $data_arr['g']=count($data['abd_call_unique']);
        }else{
            $data_arr['g']=0;
        }


        if($data['unique_abn_notanswered']!=NULL){
            $data_arr['h']=count($data['unique_abn_notanswered']);
        }else{
            $data_arr['h']=0;
        }


        if($data['abd_call_reachout']!=NULL){
          /*var_dump($data['abd_call_reachout']);
          exit();*/
            $data_arr['i']=count($data['abd_call_reachout']);
        }else{
            $data_arr['i']=0;
        }
        if($data['aht']!=NULL){
            $data_arr['j']=$this->second_to_elapsed($data['aht']->total);
        }else{
            $data_arr['j']=0;
        }

//call uniq=h
//reach out=q=i
        

        if($data_arr['c']>0){
            $slaPersen=(($data_arr['c']-($data_arr['h']-$data_arr['i']))/$data_arr['c'])*100;
            $data_arr['k']=round($slaPersen,2) .'%';
        }else{
            $data_arr['k']=0 .'%';
        }


        $data_arr['l']=$data['aht']->total_calls;


//inbound
/*total call answered / ( total call answered+ total call abandoned)*/
      if($data_arr['c']>0){
        $data_arr['m']=round(($data_arr['a']/$data_arr['c'])*100,2) .'%';
      }else{
        $data_arr['m']=0 .'%';
      }  

        


        
        

        return $data_arr;

   }

    function user($type,$date){
        
      $sql="SELECT `agent`.`number`,`agent`.`name` FROM call_center.`agent` INNER JOIN   
            call_center.`audit` ON (`agent`.`id` = `audit`.`id_agent`) 
            join kanmo.v_ext_cluster v ON (v.user_ext=agent.number) 
            where  date(audit.datetime_init)='".$date."' and estatus='A' and (v.cluster='".$type."' OR v.cluster='BOTH') group by number order by `agent`.`name` ";
          $data=$this->db->query($sql)->result();

          return $data;

    }

    function agent_activity($type,$date){
        

        if($type=='kanmo'){
            $setQueue=900;
        }
        else{
            $setQueue=901; 
        }


      $sql = "SELECT `agent`.`number`,`agent`.`name`,DATE_FORMAT(`audit`.`datetime_init`,'%Y-%m-%d') AS `dates`,
                    MIN(DATE_FORMAT(`audit`.`datetime_init`,'%H:%i:%s')) AS `login`,
                    MAX(DATE_FORMAT(`audit`.`datetime_end`,'%H:%i:%s')) AS `logout`,
                    TIMEDIFF(MAX(DATE_FORMAT(`audit`.`datetime_end`,'%H:%i:%s')),MIN(DATE_FORMAT(`audit`.`datetime_init`,'%H:%i:%s'))) AS `total_login_time`
                    FROM call_center.`agent`
                    INNER JOIN call_center.`audit`
                    ON call_center.`agent`.`id` = `audit`.`id_agent`
                    INNER JOIN `kanmo`.`v_ext_cluster` `d`
            ON `d`.`user_ext` = `agent`.`number`
                    WHERE date(`audit`.`datetime_init`) = '".$date."'
                    AND `audit`.`id_break` IS NULL
                    AND (`d`.`cluster` = '".$type."' OR `d`.`cluster` = 'both')
                    AND estatus='A'
                    GROUP BY `agent`.`name`,DATE_FORMAT(`audit`.`datetime_init`,'%Y-%m-%d') ASC";
      $agen=$this->db->query($sql)->result();






      $sql="SELECT ag.number as number,b.description, SEC_TO_TIME(COALESCE(sum(time_to_sec(au.duration)),0)) AS total_time
        FROM call_center.`break` b
        left JOIN call_center.`audit` AS au ON (b.id = au.id_break)
        left JOIN call_center.`agent` AS ag ON (ag.id=au.id_agent AND estatus='A') 
        left JOIN kanmo.v_ext_cluster AS ext ON (ext.user_ext = ag.number) 
        WHERE 
        (ext.cluster='".$type."'  AND 
         b.name LIKE '%Follow%')
         AND date(au.datetime_init) ='".$date."'
         OR
         (ext.cluster='BOTH'  AND 
         b.name LIKE '%Follow%')
        AND date(au.datetime_init) ='".$date."'
         GROUP BY ag.number";

      $follow=$this->db->query($sql)->result();




      $sql = "SELECT b.number,b.name,STR_TO_DATE(datetime_entry_queue,'%Y-%m-%d') as dates ,
          sum(a.duration) as total_time, count(a.id) as total,
          avg(a.duration) as time_avg
          FROM call_center.call_entry a
          INNER JOIN call_center.agent b
          ON a.id_agent=b.id
          INNER JOIN call_center.queue_call_entry c
          ON c.id = a.id_queue_call_entry
          WHERE date(a.datetime_entry_queue) = '".$date."'
          AND a.status = 'terminada'
          AND c.queue = ".$setQueue." 
          AND b.estatus='A'
          GROUP BY a.id_agent
          ORDER BY b.name";

      $inc_call=$this->db->query($sql)->result();

      


      $sql = "SELECT b.number,STR_TO_DATE(a.calldate,'%Y-%m-%d') as dates,b.name,a.src,count(*) as total,
      sum(a.billsec) as total_time,
      avg(a.billsec) as time_avg
      FROM asteriskcdrdb.cdr a
      LEFT JOIN call_center.agent b ON b.number=a.src
      WHERE a.dstchannel LIKE '%tr-firstroute%' AND a.disposition='ANSWERED'
      AND date(a.calldate) = '".$date."'
      AND b.estatus='A'
      GROUP BY a.src  order by a.calldate ";

      $out_call=$this->db->query($sql)->result();




      $sql = "SELECT b.number,b.name, count(a.created) as total
              FROM `asteriskcdrdb`.`agent_abn` a
              INNER JOIN call_center.agent b
              ON a.agent_name=b.name
              WHERE a.created LIKE '".$date."%'
              AND b.estatus='A'
              AND a.queuename = '".str_replace("'", " ", trim($setQueue))."'
              GROUP BY b.number 
              ORDER BY b.name";



      $abandoned_in_number=$this->db->query($sql)->result();      



      $sql = "SELECT `a`.`id`,`a`.`name`,`a`.`number`,CONCAT(`c`.`name`,'-',`c`.`description`) AS `break_name`,
      SEC_TO_TIME(SUM(TIME_TO_SEC(`b`.`duration`))) AS `total_time`,`d`.`cluster`
      FROM call_center.`agent` `a`
      INNER JOIN call_center.`audit` `b`
      ON `a`.`id` = `b`.`id_agent`
      INNER JOIN call_center.`break` `c`
      ON `c`.`id` = `b`.`id_break`
      INNER JOIN `kanmo`.`v_ext_cluster` `d`
      ON `d`.`user_ext` = `a`.`number`
      WHERE date(`b`.`datetime_init`) = '".$date."'
      AND `c`.`name` IN ('Lunch','Pray','Toilet')
      AND `c`.`status` = 'A'
      AND `b`.`id_break` IS NOT NULL
      AND (`d`.`cluster` = '".$type."' OR `d`.`cluster` = 'both')
      AND a.estatus='A'
      GROUP BY `a`.`id`
      ORDER BY `b`.`datetime_init` ASC";

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
      WHERE date(`b`.`datetime_init`) = '".$date."'
      AND `c`.`name` IN ('Training','Meeting','Coaching')
      AND `c`.`status` = 'A'
      AND `b`.`id_break` IS NOT NULL
      AND a.estatus='A'
      AND (`d`.`cluster` = '".$type."' OR `d`.`cluster` = 'both')
      GROUP BY `a`.`id`
      ORDER BY `b`.`datetime_init` ASC";

$data_arr=[];
  $other=$this->db->query($sql)->result();

      foreach ($agen as $key => $val) {
        $data_arr[$key]['name']=$val->name;
        $data_arr[$key]['login']=$val->login;
        $data_arr[$key]['incoming']=$this->chek($val->number,$inc_call);
        $data_arr[$key]['outgoing']=$this->chek($val->number,$out_call);
        $data_arr[$key]['abandoned_in_number']=$this->chek($val->number,$abandoned_in_number);
        $data_arr[$key]['total_minutes']=$this->second_to_elapsed($this->chek_time($val->number,$inc_call)+$this->chek_time($val->number,$out_call));
        $time=0;
        $bagi=0;
        $hasil=0;
        $time=$this->chek_time($val->number,$inc_call)+$this->chek_time($val->number,$out_call);
        $bagi=$this->chek($val->number,$inc_call)+$this->chek($val->number,$out_call);
        if($bagi!=0){
          $hasil=$time/$bagi;
        }
        $data_arr[$key]['avg']=$this->second_to_elapsed($hasil);
        $data_arr[$key]['follow']=$this->chek_time($val->number,$follow);
        $data_arr[$key]['break']=$this->chek_time($val->number,$break);
        $data_arr[$key]['other']=$this->chek_time($val->number,$other);
      }


return $data_arr;



/*$sql = "SELECT b.number,b.name,STR_TO_DATE(datetime_entry_queue,'%Y-%m-%d') as dates ,
              SEC_TO_TIME(sum(a.duration)) as tot_abandon_duration, count(a.id) as tot_abandoned_call,
              SEC_TO_TIME(avg(a.duration)) as avg_out_aht
              FROM call_center.call_entry a
              INNER JOIN call_center.agent b
              ON a.id_agent=b.id
              WHERE date(a.datetime_entry_queue) = '".$date."'
              AND a.status = 'abandonada'
              GROUP BY a.id_agent 
              ORDER BY b.name ";

$abandoned=$this->db->query($sql)->result();
*/
    }

    function breakdown_follow_up($type,$date){
      
      $sql = "SELECT `b`.`description` from call_center.`break` AS b where  b.name LIKE '%Follow%' and b.description!='Follow up'";
      $break=$this->db->query($sql)->result();


      $sql="SELECT ag.number as number,b.description, SEC_TO_TIME(COALESCE(sum(time_to_sec(au.duration)),0)) AS time
        FROM call_center.`break` b
        left JOIN call_center.`audit` AS au ON (b.id = au.id_break)
        left JOIN call_center.`agent` AS ag ON (ag.id=au.id_agent AND estatus='A') 
        left JOIN kanmo.v_ext_cluster AS ext ON (ext.user_ext = ag.number) 
        WHERE 
        (ext.cluster='".$type."'  AND 
         b.name LIKE '%Follow%')
         AND date(au.datetime_init) ='".$date."'
         OR
         (ext.cluster='BOTH'  AND 
         b.name LIKE '%Follow%')
        AND date(au.datetime_init) ='".$date."'
         GROUP BY b.description,ag.number";

      $time=$this->db->query($sql)->result();
    $data_arr=[];
    foreach ($this->user($type,$date) as $i => $val) {
      $data_arr[$i]["name"]=$val->name;
        foreach ($break  as $k => $v) {
            $data_arr[$i][$v->description]= $this->find($val->number,$v->description,$time);
        }
    }
    $data=['break'=>$break,'data'=>$data_arr];
    return $data;
}

function find($number,$name,$time_arr){
    foreach ($time_arr as $key => $val) {
        if($val->description==$name && $val->number==$number){
            return $val->description=$val->time;
        }
                    
    }
}


    function agent_level_ticket($type,$date){
    	/*$sql = "SELECT v.open_by as number,COUNT(*) as total FROM kanmo.v_ticket AS v
               WHERE (date(v.open_date) >= '".$date."' And date(v.open_date) <= '".$date2."') AND date(v.open_date) <> date(v.closed_date) ";
      if($type!='ALL'){
          $sql.= " AND type='".$type."'";
      }   
      $sql.= " GROUP BY v.open_by";
      $raised=$this->db->query($sql)->result();*/

      $sql = "SELECT v.open_by as number,COUNT(*) as total FROM kanmo.v_ticket AS v
               WHERE date(v.open_date) = '".$date."' AND date(v.open_date) <> date(v.closed_date) AND type='".$type."' GROUP BY v.open_by";
      $raised=$this->db->query($sql)->result();



/*      $sql = "SELECT v.open_by as number,COUNT(*) as total FROM kanmo.v_ticket AS v
               WHERE date(v.open_date) = '".$date."' AND v.status='open' AND type='".$type."' GROUP BY v.open_by";
      $raised=$this->db->query($sql)->result();
*/


      $sql = "SELECT v.closed_by as number,COUNT(*) total FROM kanmo.v_ticket AS v
           WHERE date(v.closed_date) = '".$date."' AND v.status='closed' AND type='".$type."' GROUP BY v.closed_by";
           
      $closed=$this->db->query($sql)->result();
      


      $sql = "SELECT closed_by as number , sum(TIMESTAMPDIFF(second,open_date,  
            closed_date)) total FROM kanmo.v_ticket AS v
            WHERE date(v.closed_date) = '".$date."' AND STATUS='closed' AND type='".$type."' GROUP BY v.closed_by";

      $avg=$this->db->query($sql)->result();
               


      $sql = "SELECT t.closed_by as number ,COUNT(*) as total FROM kanmo.v_ticket AS  t JOIN
              kanmo.v_ticket_history th ON (t.id=th.ticket_id) WHERE 
              date(t.closed_date)='".$date."' 
               AND th.activity NOT Like 'Create%' AND th.activity NOT Like 'Assign%' AND th.activity 
                NOT Like 'Close%' AND t.`status`='closed' 
                AND type='".$type."'
                GROUP BY t.closed_by";

      $comment=$this->db->query($sql)->result();



      $sql= "SELECT closed_by as number ,COUNT(*) as total FROM kanmo.v_ticket WHERE 
                    DATE(closed_date)> '".$date."' - INTERVAL 5 DAY
                    AND DATE(closed_date)<= '".$date."'
                    AND STATUS='closed' 
                    AND type='".$type."'
                    GROUP BY closed_by";

      $closed_day5=$this->db->query($sql)->result();


      $sql= "SELECT closed_by as number ,COUNT(*) as total FROM kanmo.v_ticket WHERE 
                    DATE(closed_date)>'".$date."' - INTERVAL 10 DAY
                    AND
                    DATE(closed_date)<='".$date."' - INTERVAL 5 DAY 
                    AND STATUS='closed' 
                    AND type='".$type."'
                    GROUP BY closed_by";

      $closed_day10=$this->db->query($sql)->result();



      $sql= "SELECT open_by as number,COUNT(*) as total FROM kanmo.v_ticket WHERE 
                  DATEDIFF('".$date."', open_date) >5 &&  DATEDIFF('".$date."', open_date) <=10
                  AND STATUS='open' 
                  AND type='".$type."'
                  GROUP BY open_by";

      $open_day5=$this->db->query($sql)->result();




      $sql= "SELECT open_by as number,COUNT(*) as total FROM kanmo.v_ticket WHERE 
                  DATEDIFF('".$date."', open_date) >10
                  AND STATUS='open'
                  AND type='".$type."'
                   GROUP BY open_by";

      $open_day10=$this->db->query($sql)->result();


      $sql = "SELECT open_by as number, COUNT(*) as total FROM kanmo.v_ticket WHERE 
                  status='open' AND type='".$type."' GROUP BY open_by";

      $open_all=$this->db->query($sql)->result();
      $data_arr=[];
      foreach ($this->user($type,$date) as $key => $value) {
        $data_arr[$key]['agent']=$value->name;
        $data_arr[$key]['raised']=$this->chek($value->number,$raised);
        $data_arr[$key]['closed']=$this->chek($value->number,$closed);
        if($data_arr[$key]['closed']!=0){
        $data_arr[$key]['avg']=$this->second_to_elapsed(
                                $this->chek($value->number,$avg)
                               /$data_arr[$key]['closed']);
        }else{
          $data_arr[$key]['avg']=0;
        }
        $data_arr[$key]['comment']=$this->chek($value->number,$comment);
        $data_arr[$key]['closed_day5']=$this->chek($value->number,$closed_day5);
        $data_arr[$key]['closed_day10']=$this->chek($value->number,$closed_day10);
        $data_arr[$key]['open_day5']=$this->chek($value->number,$open_day5);
        $data_arr[$key]['open_day10']=$this->chek($value->number,$open_day10);
        $data_arr[$key]['open_all']=$this->chek($value->number,$open_all);
      }

      return $data_arr;
    }



    // call atas

    function calls_atas($type,$date1,$date2){
        if ($type=='kanmo') {
            $did = '02129181155';
            $queue='900';
        }else if($type='nespresso'){
            $did = '02129181157';
            $queue='901';
        }

        $sql="SELECT daytime_init, daytime_end FROM call_center.campaign_entry where name='".$type."'";
        $operasional=$this->db->query($sql)->row();

        $time_init=$operasional->daytime_init;
        $time_end=$operasional->daytime_end;


        $sql="SELECT COUNT(*) as total FROM call_center.call_entry AS ce
                  JOIN call_center.queue_call_entry AS qce ON (qce.id=ce.id_queue_call_entry)
                  WHERE ce.datetime_entry_queue >='".$date1." ".$time_init."'  and ce.datetime_entry_queue <='".$date2." ".$time_end."'
                  AND ce.`status`='terminada'
                  AND qce.queue='".$queue."'";
        $data['answer']=$this->db->query($sql)->row();

        



        $sql="SELECT COUNT(*) as total FROM call_center.call_entry AS ce
                  JOIN call_center.queue_call_entry AS qce ON (qce.id=ce.id_queue_call_entry)
                  WHERE date(ce.datetime_entry_queue)>='".$date1."' And date(ce.datetime_entry_queue)<='".$date2."' AND ce.`status`='abandonada'
                  AND qce.queue='".$queue."'";
        $data['abandon']=$this->db->query($sql)->row();





        $sql = "SELECT count(calldate) as abnivr FROM asteriskcdrdb.cdr WHERE dcontext LIKE 'app-announcement%' AND (dcontext <>'app-announcement-4' AND dcontext <>'app-announcement-5' AND dcontext <>'app-announcement-9') AND disposition = 'ANSWERED' AND (calldate >= '".$date1." ".$time_init."' AND calldate <= '".$date2." ".$time_end."') AND did = '".$did."' GROUP BY did";
        $data['abnivr']=$this->db->query($sql)->row();


      

        $sql ="SELECT count(calldate) as total FROM asteriskcdrdb.`cdr` WHERE (dst='hangup' OR dst='s') AND disposition='ANSWERED' AND ((calldate >= '".$date1." 00:00:00' AND calldate < '".$date2." ".$time_init."') OR (calldate > '".$date1." ".$time_end."' AND calldate <= '".$date2." 23:59:59')) AND did = '".$did."'";
        $data['earlyabn']=$this->db->query($sql)->row();



        $sql ='SELECT DISTINCT callerid AS `caller_attempt`
                            FROM call_center.call_entry
                            INNER JOIN call_center.queue_call_entry
                            ON `queue_call_entry`.`id` = `call_entry`.`id_queue_call_entry`
                            WHERE datetime_entry_queue >= "'.$date1.' 00:00:00" AND datetime_entry_queue <= "'.$date2.' 23:59:59"
                            AND status = "abandonada"
                            AND `queue_call_entry`.`queue` = "'.$queue.'"';

        $data['abd_call_unique']=$this->db->query($sql)->result();
        $abd_call_unique=[];
        foreach($data['abd_call_unique'] as $val)
        {
        $abd_call_unique[] = $val->caller_attempt;
    }
    if(count($abd_call_unique)>0){

         $sql = 'SELECT DISTINCT callerid AS `phone`
                            FROM call_center.call_entry
                            INNER JOIN call_center.queue_call_entry
                            ON `queue_call_entry`.`id` = `call_entry`.`id_queue_call_entry`
                            WHERE datetime_entry_queue >= "'.$date1.' 00:00:00" AND datetime_entry_queue <= "'.$date2.' 23:59:59"
                            AND status = "terminada" AND callerid IN ("'.implode('","',$abd_call_unique).'")
                            AND `queue_call_entry`.`queue` = "'.$queue.'"';

        $data['sql_unique_answered']=$this->db->query($sql)->result();          
        $sql_unique_answered=array();
        if (count($data['sql_unique_answered']) > 0) {
          foreach($data['sql_unique_answered'] as $val)
          {
          $sql_unique_answered[] = $val->phone;
      }
      $data['unique_abn_notanswered'] = array_diff($abd_call_unique, $sql_unique_answered);
    }else{
      $data['unique_abn_notanswered']=[];
    }
          if(count($sql_unique_answered)>0){
        $sql = 
        "SELECT DISTINCT dst as phone FROM `asteriskcdrdb`.`cdr` WHERE date(`calldate`) >= '".$date1."' AND date(`calldate`) <= '".$date2."' AND duration >= 5 AND dcontext = 'from-internal' AND dst IN ('".implode("','",$data['unique_abn_notanswered'] )."')";                        
            $data['abd_call_reachout']=$this->db->query($sql)->result();                         
            }else{
                $data['abd_call_reachout']= array();
            }

    }else{
            $data['unique_abn_notanswered'] = $abd_call_unique;
            $data['abd_call_reachout'] = $abd_call_unique;

        }
  


  $sql="SELECT SUM(IF(ce.status='terminada', ce.duration, 0))/count(*) as total, count(*) as total_calls FROM call_center.call_entry AS    ce JOIN call_center.queue_call_entry AS qce ON (qce.id=ce.id_queue_call_entry)
                  WHERE date(ce.datetime_entry_queue)>='".$date1."' and date(ce.datetime_entry_queue)<='".$date2 ."' AND qce.queue='".$queue."'";
  $data['aht']=$this->db->query($sql)->row();


        $data_arr=[];                  
        if($data['answer']!=NULL){
            $data_arr['a']=$data['answer']->total;
        }else{
            $data_arr['a']=0;
        }

        if($data['abandon']!=NULL){
            $data_arr['b']=$data['abandon']->total;
        }else{
            $data_arr['b']=0;
        }
                  
        //offered call
        $data_arr['c']=$data_arr['a']+$data_arr['b'];

        //sla
        if($data_arr['c']!=0){
          $data_arr['d']=number_format($data_arr['a']/$data_arr['c'],2,'.',',');
        }else{
          $data_arr['d']=0;
        }         

        if($data['earlyabn']!=NULL){
            $data_arr['e']=$data['earlyabn']->total;
        }else{
            $data_arr['e']=0;
        }

        if($data['abnivr']!=NULL){
            $data_arr['f']=$data['abnivr']->abnivr;
        }else{
            $data_arr['f']=0;
        }

        if($data['abd_call_unique']!=NULL){
            $data_arr['g']=count($data['abd_call_unique']);
        }else{
            $data_arr['g']=0;
        }

        if($data['unique_abn_notanswered']!=NULL){
            $data_arr['h']=count($data['unique_abn_notanswered']);
        }else{
            $data_arr['h']=0;
        }

        if($data['abd_call_reachout']!=NULL){
          /*var_dump($data['abd_call_reachout']);
          exit();*/
            $data_arr['i']=count($data['abd_call_reachout']);
        }else{
            $data_arr['i']=0;
        }
        if($data['aht']!=NULL){
            $data_arr['j']=$this->second_to_elapsed($data['aht']->total);
        }else{
            $data_arr['j']=0;
        }

        if($data_arr['c']>0){
            $slaPersen=(($data_arr['c']-($data_arr['h']-$data_arr['i']))/$data_arr['c'])*100;
            $data_arr['k']=round($slaPersen,2) .'%';
        }else{
            $data_arr['k']=0 .'%';
        }

        $data_arr['l']=$data['aht']->total_calls;

      if($data_arr['c']>0){
        $data_arr['m']=round(($data_arr['a']/$data_arr['c'])*100,2) .'%';
      }else{
        $data_arr['m']=0 .'%';
      }  
        return $data_arr;

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

function chek_time($number,$data){
  $hasil='';
      foreach ($data as $key => $value) {
         if($number==$value->number) {
            $hasil=$value->total_time;
         }
      }
      if($hasil==''){
        $hasil='00:00:00';
      }
      return $hasil;
}



function chek_time_avg($number,$data){
  $hasil='';
      foreach ($data as $key => $value) {
         if($number==$value->number) {
            $hasil=$value->time_avg;
         }
      }
      if($hasil==''){
        $hasil=0;
      }
      return $hasil;
}



function second_to_elapsed($second){
        $t = round($second);
        return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
}

    function report(){

    }


 function calls_atas_details($type,$date1,$date2){
        if ($type=='kanmo') {
            $did = '02129181155';
            $queue='900';
        }else if($type='nespresso'){
            $did = '02129181157';
            $queue='901';
        }



        $sql="SELECT daytime_init, daytime_end FROM call_center.campaign_entry where name='".$type."'";
        $operasional=$this->db->query($sql)->row();

        $time_init=$operasional->daytime_init;
        $time_end=$operasional->daytime_end;



$begin = new DateTime($date1);
$end = new DateTime(date('Y-m-d',strtotime($date2 . "+1 days")));


$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);
$data=[];
$_tgl=[];
$data_result=[];
foreach ($period as $dt) {
    $date1=$dt->format("Y-m-d");
    $date2=$dt->format("Y-m-d");

        $sql="SELECT COUNT(*) as total FROM call_center.call_entry AS ce
                  JOIN call_center.queue_call_entry AS qce ON (qce.id=ce.id_queue_call_entry)
                  WHERE ce.datetime_entry_queue >='".$date1." ".$time_init."'  and ce.datetime_entry_queue <='".$date2." ".$time_end."'
                  AND ce.`status`='terminada'
                  AND qce.queue='".$queue."'";
        $data['answer']=$this->db->query($sql)->row();

        



        $sql="SELECT COUNT(*) as total FROM call_center.call_entry AS ce
                  JOIN call_center.queue_call_entry AS qce ON (qce.id=ce.id_queue_call_entry)
                  WHERE date(ce.datetime_entry_queue)>='".$date1."' And date(ce.datetime_entry_queue)<='".$date2."' AND ce.`status`='abandonada'
                  AND qce.queue='".$queue."'";
        $data['abandon']=$this->db->query($sql)->row();





        $sql = "SELECT count(calldate) as abnivr FROM asteriskcdrdb.cdr WHERE dcontext LIKE 'app-announcement%' AND (dcontext <>'app-announcement-4' AND dcontext <>'app-announcement-5' AND dcontext <>'app-announcement-9') AND disposition = 'ANSWERED' AND (calldate >= '".$date1." ".$time_init."' AND calldate <= '".$date2." ".$time_end."') AND did = '".$did."' GROUP BY did";
        $data['abnivr']=$this->db->query($sql)->row();


      

        $sql ="SELECT count(calldate) as total FROM asteriskcdrdb.`cdr` WHERE (dst='hangup' OR dst='s') AND disposition='ANSWERED' AND ((calldate >= '".$date1." 00:00:00' AND calldate < '".$date2." ".$time_init."') OR (calldate > '".$date1." ".$time_end."' AND calldate <= '".$date2." 23:59:59')) AND did = '".$did."'";
        $data['earlyabn']=$this->db->query($sql)->row();



        $sql ='SELECT DISTINCT callerid AS `caller_attempt`
                            FROM call_center.call_entry
                            INNER JOIN call_center.queue_call_entry
                            ON `queue_call_entry`.`id` = `call_entry`.`id_queue_call_entry`
                            WHERE datetime_entry_queue >= "'.$date1.' 00:00:00" AND datetime_entry_queue <= "'.$date2.' 23:59:59"
                            AND status = "abandonada"
                            AND `queue_call_entry`.`queue` = "'.$queue.'"';

        $data['abd_call_unique']=$this->db->query($sql)->result();
        $abd_call_unique=[];
        foreach($data['abd_call_unique'] as $val)
        {
        $abd_call_unique[] = $val->caller_attempt;
    }
    if(count($abd_call_unique)>0){

         $sql = 'SELECT DISTINCT callerid AS `phone`
                            FROM call_center.call_entry
                            INNER JOIN call_center.queue_call_entry
                            ON `queue_call_entry`.`id` = `call_entry`.`id_queue_call_entry`
                            WHERE datetime_entry_queue >= "'.$date1.' 00:00:00" AND datetime_entry_queue <= "'.$date2.' 23:59:59"
                            AND status = "terminada" AND callerid IN ("'.implode('","',$abd_call_unique).'")
                            AND `queue_call_entry`.`queue` = "'.$queue.'"';

        $data['sql_unique_answered']=$this->db->query($sql)->result();          
        $sql_unique_answered=array();
        if (count($data['sql_unique_answered']) > 0) {
          foreach($data['sql_unique_answered'] as $val)
          {
          $sql_unique_answered[] = $val->phone;
      }
      $data['unique_abn_notanswered'] = array_diff($abd_call_unique, $sql_unique_answered);
    }else{
      $data['unique_abn_notanswered']=[];
    }
          if(count($sql_unique_answered)>0){
        $sql = 
        "SELECT DISTINCT dst as phone FROM `asteriskcdrdb`.`cdr` WHERE date(`calldate`) >= '".$date1."' AND date(`calldate`) <= '".$date2."' AND duration >= 5 AND dcontext = 'from-internal' AND dst IN ('".implode("','",$data['unique_abn_notanswered'] )."')";                        
            $data['abd_call_reachout']=$this->db->query($sql)->result();                         
            }else{
                $data['abd_call_reachout']= array();
            }

    }else{
            $data['unique_abn_notanswered'] = $abd_call_unique;
            $data['abd_call_reachout'] = $abd_call_unique;

        }
  


  $sql="SELECT SUM(IF(ce.status='terminada', ce.duration, 0))/count(*) as total, count(*) as total_calls FROM call_center.call_entry AS    ce JOIN call_center.queue_call_entry AS qce ON (qce.id=ce.id_queue_call_entry)
                  WHERE date(ce.datetime_entry_queue)>='".$date1."' and date(ce.datetime_entry_queue)<='".$date2 ."' AND qce.queue='".$queue."'";
  $data['aht']=$this->db->query($sql)->row();

        
        $data_arr=[];                  
        $data_arr['tgl']=$date1;
        if($data['answer']!=NULL){
            $data_arr['a']=$data['answer']->total;
        }else{
            $data_arr['a']=0;
        }

        if($data['abandon']!=NULL){
            $data_arr['b']=$data['abandon']->total;
        }else{
            $data_arr['b']=0;
        }
                  
        //offered call
        $data_arr['c']=$data_arr['a']+$data_arr['b'];

        //sla
        if($data_arr['c']!=0){
          $data_arr['d']=number_format($data_arr['a']/$data_arr['c'],2,'.',',');
        }else{
          $data_arr['d']=0;
        }         

        if($data['earlyabn']!=NULL){
            $data_arr['e']=$data['earlyabn']->total;
        }else{
            $data_arr['e']=0;
        }

        if($data['abnivr']!=NULL){
            $data_arr['f']=$data['abnivr']->abnivr;
        }else{
            $data_arr['f']=0;
        }

        if($data['abd_call_unique']!=NULL){
            $data_arr['g']=count($data['abd_call_unique']);
        }else{
            $data_arr['g']=0;
        }

        if($data['unique_abn_notanswered']!=NULL){
            $data_arr['h']=count($data['unique_abn_notanswered']);
        }else{
            $data_arr['h']=0;
        }

        if($data['abd_call_reachout']!=NULL){
          /*var_dump($data['abd_call_reachout']);
          exit();*/
            $data_arr['i']=count($data['abd_call_reachout']);
        }else{
            $data_arr['i']=0;
        }
        if($data['aht']!=NULL){
            $data_arr['j']=$this->second_to_elapsed($data['aht']->total);
        }else{
            $data_arr['j']=0;
        }

        if($data_arr['c']>0){
            $slaPersen=(($data_arr['c']-($data_arr['h']-$data_arr['i']))/$data_arr['c'])*100;
            $data_arr['k']=round($slaPersen,2) .'%';
        }else{
            $data_arr['k']=0 .'%';
        }

        $data_arr['l']=$data['aht']->total_calls;

      if($data_arr['c']>0){
        $data_arr['m']=round(($data_arr['a']/$data_arr['c'])*100,2) .'%';
      }else{
        $data_arr['m']=0 .'%';
      }  
        $data_result[]= $data_arr;
}

echo "<table>";
echo "<th >date</th>";
  echo "<th >Inbound (%)</th>";
  echo "<th >Serviced (%)</th> ";
  echo "<th >Answered Calls</th>";
  echo "<th >Abandoned Calls</th>";
  echo "<th >Offered Calls</th>";
                  echo "<th >SLA</th>"; 
                  echo "<th >early Abandoned</th>";
                  echo "<th >Abandoned IVR</th>";
                  echo "<th >Abn Call Reachout</th>";
                  echo "<th >Abn Call Unique</th>";


foreach ($data_result as $key => $v) {
echo "<tr>";
    echo "<th >".$v["tgl"]."</th>";
    echo "<th >".$v["m"]."</th> ";
  echo "<th >".$v["k"]."</th> ";
  echo "<th >".$v["a"]."</th> ";
  echo "<th >".$v["b"]."</th> ";
  echo "<th >".$v["c"]."</th> ";
  echo "<th >".$v["d"]."</th> ";
  echo "<th >".$v["e"]."</th> ";
  echo "<th >".$v["f"]."</th> ";
  echo "<th >".$v["i"]."</th> ";
  echo "<th >".$v["g"]."(".$v["h"].")</th> ";
  
  
echo "</tr>";
}

  echo "</table>";
echo json_encode($data_result);
exit();
        
   }





}
