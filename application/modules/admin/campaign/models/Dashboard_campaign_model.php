<?php
    class Dashboard_campaign_model extends CI_Model
    {
        var $table = 'data_campaign_';

        function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        public function status_data($_data)
        {
            $this->db->select('a.status,COUNT(a.status) AS status_count', false);
            $this->db->join('call_attemp_'.$_data['id'].' b', 'a.data_id=b.data_id','left');
            $this->db->from($this->table.$_data['id'].' a');
            $this->db->group_by('a.status');
            $query = $this->db->get();
            /*$query = $this->db->get_compiled_select();
            echo $query;
            exit;*/
            if($query->num_rows() > 0){
                return $query->result();
            }
        }

        public function total_data($id)
        {
            $this->db->select('COUNT(a.status) AS total_data', false);
            $this->db->join('call_attemp_'.$id.' b', 'a.data_id=b.data_id','left');
            $this->db->from($this->table.$id.' a');
            $query = $this->db->get();
            /*$query = $this->db->get_compiled_select();
            echo $query;
            exit;*/
            if($query->num_rows() > 0){
                return $query->result();
            }
        }

        public function call_status($id)
        {
            //$cmp = $this->db->where('campaign_id', $id)->get('v_campaign', 1)->row();
            $this->db->select('COUNT(b.data_id) AS total, SUM(IF(a.call_status="Contact",1,0)) AS contact, SUM(IF(a.call_status="UnContact",1,0)) AS uncontact, SUM(IF(a.call_status="Not Active",1,0)) AS no_active, SUM(IF(a.call_status="Reject",1,0)) AS reject, SUM(IF(a.call_status="Wrong Number",1,0)) AS wrong_numb, SUM(IF(a.call_status="Busy",1,0)) AS busy,IFNULL(SUM(IF(a.call_status="Callback",1,0)),0) AS callback', false);
            $this->db->join('call_attemp_'.$id.' a', 'a.data_id=b.data_id', 'left');
            //$this->db->where('a.attemp_date  >="'.$cmp->start_date.'%"');
            //$this->db->where('a.attemp_date  <="'.$cmp->end_date.'%"');
            $this->db->from($this->table.$id.' b');
            $query = $this->db->get();
            /*$query = $this->db->get_compiled_select();
            echo $query;
            exit;*/
            if($query->num_rows() > 0){
              /*echo '<pre>';
              print_r($query->row());
              echo '</pre>';
              exit;*/
                return $query->row();
            }
        }

        public function call_status_date($id, $start, $end)
        {
            $this->db->select('DATE_FORMAT(attemp_date,"%d %b %y") AS call_date, SUM(IF(a.call_status="Contacted",1,0)) AS contacted, SUM(IF(a.call_status="UnContact",1,0)) AS uncontact, SUM(IF(a.call_status="Not Active",1,0)) AS no_active, SUM(IF(a.call_status="Reject",1,0)) AS reject, SUM(IF(a.call_status="Wrong Number",1,0)) AS wrong_numb, SUM(IF(a.call_status="Busy",1,0)) AS busy', false);
            $this->db->where(array('attemp_date>='=>$start, 'attemp_date<='=> $end));
            $this->db->group_by('call_date');
            $this->db->from('call_attemp_'.$id.' a');
            $query = $this->db->get();
            /*echo $query;
            exit;*/
            $result = array('labels'=>array(), 'contacted'=>array(), 'uncontact'=>array(),
                        'no_active'=>array(), 'reject'=>array(), 'wrong_numb'=>array(), 'busy'=>array(),'callback'=>array());
            if($query->num_rows() > 0){
                $_data = $query->result();
                $d1 = new DateTime($start);
                $d2 = new DateTime($end);
                //$d2->add(new DateInterval('P1D'));
                $period = new DatePeriod(
                     $d1,
                     new DateInterval('P1D')
                );
                $data = array();
                foreach ($_data as $key => $value) {
                    $data['contacted'][$value->call_date] = $value->contacted;
                    $data['uncontact'][$value->call_date] = $value->uncontact;
                    $data['no_active'][$value->call_date] = $value->no_active;
                    $data['reject'][$value->call_date] = $value->reject;
                    $data['wrong_numb'][$value->call_date] = $value->wrong_numb;
                    $data['busy'][$value->call_date] = $value->busy;
                }
                foreach ($period as $key => $pval) {
                    $d = $pval->format('d M y');
                    $result['labels'][] = $d;
                    $result['contacted'][] = isset($data['contacted'][$d])?$data['contacted'][$d]:0;
                    $result['uncontact'][] = isset($data['uncontact'][$d])?$data['uncontact'][$d]:0;
                    $result['no_active'][] = isset($data['no_active'][$d])?$data['no_active'][$d]:0;
                    $result['reject'][] = isset($data['reject'][$d])?$data['reject'][$d]:0;
                    $result['wrong_numb'][] = isset($data['wrong_numb'][$d])?$data['wrong_numb'][$d]:0;
                    $result['busy'][] = isset($data['busy'][$d])?$data['busy'][$d]:0;
                }
            }
            return $result;
            /*$query = $this->db->get_compiled_select();
            echo $query;
            exit;*/
        }

        public function status_call($_data)
        {
            $this->db->select('a.call_status,COUNT(a.call_status) AS call_status_count', false);
            $this->db->join('call_attemp_'.$_data['id'].' a', 'a.data_id=b.data_id');
            $this->db->from($this->table.$_data['id'].' b');
            $this->db->group_by('a.call_status');
            $query = $this->db->get();
            /*$query = $this->db->get_compiled_select();
            echo $query;
            exit;*/
            if($query->num_rows() > 0){
                return $query->result();
            }
        }

        public function merchant_status($id,$start, $end)
        {
            $this->db->select('COUNT(a.attemp_id) AS total, IFNULL(SUM(IF(a.call_status="Not Active",1,0)),0) as not_active, IFNULL(SUM(IF(a.call_status="Busy",1,0)),0) AS busy, IFNULL(SUM(IF(a.call_status="Contacted",1,0)),0) AS contacted, IFNULL(SUM(IF(a.call_status="reject",1,0)),0) AS reject, IFNULL(SUM(IF(a.call_status="wrong number",1,0)),0) AS wrong_number, IFNULL(SUM(IF(a.call_status="Callback",1,0)),0) AS call_back', false);
            $this->db->join('call_attemp_'.$id.' a', 'a.data_id=b.data_id');
            $this->db->where('a.call_status', 'Contacted');
            $this->db->where(array('a.attemp_date>='=>$start, 'a.attemp_date<='=> $end));
            $this->db->from($this->table.$id.' b');
            /*$query = $this->db->get();*/
            $query = $this->db->get();
            /*$query = $this->db->get_compiled_select();
            echo $query;
            exit;*/
            if($query->num_rows() > 0){
                return $query->row_array();
            }
        }

        public function total_data_campaign($id)
        {
            $this->db->select('COUNT(data_id) AS total', false);
            $this->db->from($this->table.$id);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->row()->total;
            }else{
                return 0;
            }
        }

        public function total_data_success($id)
        {
            $this->db->select('COUNT(*) AS `total_success`');
            /*$this->db->join(`call_attemp_`.$id,'`call_attemp_`'.$id = $this->table.$id,'left');*/
            $this->db->join('(SELECT * FROM call_attemp_'.$id.' WHERE status = \'Complete\' AND call_status = \'contact\' GROUP BY data_id) x','x.data_id = '.$this->table.$id.'.data_id');
            /*$this->db->where(array('x.status'=> 'Complete','x.call_status'=> 'Contacted'));*/
            $query  =   $this->db->get($this->table.$id,1);

            if ($query->num_rows() > 0) {
                return $query->row()->total_success;
            }else{
                return 0;
            }
        }

        /*public function total_data_remain($id)
        {
            $this->db->select('COUNT(*) AS `remain_call`');
            $this->db->where('status IS NULL');
            $query  =   $this->db->get($this->table.$id,1);

            if ($query->num_rows() > 0) {
                return $query->row()->remain_call;
            }else{
                return 0;
            }
        }*/

        public function average_handling_time($id)
        {
            $this->db->select('SEC_TO_TIME(ROUND(AVG(TIME_TO_SEC(duration)),0)) as aht');
            $this->db->where('api_status','ANSWER');
            $query  =   $this->db->get('call_attemp_'.$id,1);

            if ($query->num_rows() > 0) {
                return $query->row()->aht;
            }else{
                return 0;
            }
        }

        public function get_agent_perform($id, $limit, $order){

            $query = $this->db->query("SELECT x.*, ROUND((x.total_contacted/x.total_completed)*100,2) as rate FROM (SELECT c.adm_name, SUM(if(a.status='Complete',1,0)) as total_completed, sum(IF(d.call_status='contact', 1, 0)) as total_contacted FROM `data_campaign_$id` `a` JOIN `v_assign_campaign` `b` ON `a`.`assign_id`=`b`.`assign_id` JOIN `v_admin` `c` ON `c`.`adm_id`=`b`.`adm_id` LEFT JOIN (SELECT * FROM call_attemp_$id WHERE call_status = 'contact' AND status = 'Complete' GROUP BY data_id) `d` ON `d`.`data_id`=`a`.`data_id` GROUP BY `c`.`adm_id`) x ORDER BY `total_completed` $order, `total_contacted` $order, `rate` $order LIMIT $limit");
            //$query  =   $this->db->get('data_campaign_'.$id.' a',$limit);
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                $data = array();
                $total = $this->db->where('campaign_id',$id)->get('v_assign_campaign')->num_rows();
                $idx = 1;
                foreach ($result as $key => $value) {
                    if(strtolower($order)=='desc'){
                        $value['rank'] = $idx;
                        $data[] = $value;
                        $idx++;
                    }else{
                        $value['rank'] = $total;
                        $data[] = $value;
                        $total--;
                    }
                }
                return $data;
            }else{
                return array();
            }
        }

        public function call_status_data($id)
        {
            /*$result = array('contact'=>0, 'not_answer'=>0,
                        'not_active'=>0, 'reject'=>0, 'wrong_numb'=>0, 'busy'=>0, 'callback'=>0);*/
            $result = array(
                'contact'=>0,
                'uncontact'=>0,
                'callback'=>0
                /*'not_active'=>0,
                'reject'=>0,
                'wrong_numb'=>0,
                'busy'=>0,
                */
            );

            $this->db->select('LOWER(call_status) call_status,COUNT(call_status) AS total', false);
            $this->db->where(array('call_status <>'=>''));
            $this->db->from('call_attemp_'.$id);
            $this->db->group_by('call_status');
            $query = $this->db->get();
            /*$query = $this->db->get_compiled_select();
            echo $query;
            exit;*/
            $total = 0;
            if($query->num_rows() > 0){
                $data = $query->result();
                foreach ($data as $key => $value) {
                    $result[str_replace(' ', '_', $value->call_status)] = $value->total;
                    $total = $total+$value->total;
                }
            }
            return array('total'=>$total, 'data'=>$result);
        }

        public function line_chart_data($id)
        {
            $query = $this->db->select('start_date, stime_perday, end_date, etime_perday')->where('campaign_id', $id)->get('v_campaign',1);
            if($query->num_rows()>0){
                $cmp = $query->row();

                $d1 = new DateTime($cmp->start_date.' '.$cmp->stime_perday);
                $d2 = new DateTime($cmp->end_date.' '.$cmp->etime_perday);
                //$d2->add(new DateInterval('P1D'));
                $period = new DatePeriod(
                     $d1,
                     new DateInterval('P1D'),
                     $d2
                );

                /*$date1=date_create($cmp->start_date);
                $date2=date_create($cmp->end_date);
                $diff=date_diff($date1,$date2);
                $diff = intval($diff->format("%a"));*/

                $diff = 0;
                foreach ($period as $key => $value) {
                    $diff++;
                }

                $sql_format = '%d %b';
                $php_format = 'd M';
                $time = false;
                if($diff<3){
                    $sql_format = '%d %H:00';
                    $php_format = 'd H:00';
                    $d2->add(new DateInterval('PT1H'));
                    $period = new DatePeriod(
                         $d1,
                         new DateInterval('PT1H'),
                         $d2
                    );
                    $time = true;
                }

                $this->db->select('DATE_FORMAT(attemp_date,"'.$sql_format.'") AS call_date, SUM(IF(a.call_status="Contact",1,0)) AS contact, SUM(IF(a.call_status="UnContact",1,0)) AS uncontact, SUM(IF(a.call_status="Not Active",1,0)) AS no_active, SUM(IF(a.call_status="Reject",1,0)) AS reject, SUM(IF(a.call_status="Wrong Number",1,0)) AS wrong_numb, SUM(IF(a.call_status="Busy",1,0)) AS busy, SUM(IF(a.call_status="Callback",1,0)) AS callback', false);
                $this->db->order_by('attemp_date', 'asc');
                $this->db->group_by('call_date');
                $this->db->from('call_attemp_'.$id.' a');
                $query = $this->db->get();
                /*echo $query;
                exit;*/
                $result = array(
                  'labels'=>array(),
                  'contact'=>array(),
                  'uncontact'=>array(),
                  'callback'=>array()
                /*
              'no_active'=>array(), 'reject'=>array(), 'wrong_numb'=>array(), 'busy'=>array(), */);
                if($query->num_rows() > 0){
                    $_data = $query->result();

                    $data = array();
                    foreach ($_data as $key => $value) {
                        $data['contact'][$value->call_date] = $value->contact;
                        $data['uncontact'][$value->call_date] = $value->uncontact;
                        $data['callback'][$value->call_date] = $value->callback;
                        /*$data['no_active'][$value->call_date] = $value->no_active;
                        $data['reject'][$value->call_date] = $value->reject;
                        $data['wrong_numb'][$value->call_date] = $value->wrong_numb;
                        $data['busy'][$value->call_date] = $value->busy;
                        */
                    }
                    if(!$time){
                        $d2->add(new DateInterval('P1D'));
                        $period = new DatePeriod(
                             $d1,
                             new DateInterval('P1D'),
                             $d2
                        );
                        foreach ($period as $key => $pval) {
                            $d = $pval->format($php_format);
                            $result['labels'][] = $d;
                            $result['contact'][] = isset($data['contact'][$d])?$data['contact'][$d]:0;
                            $result['uncontact'][] = isset($data['uncontact'][$d])?$data['uncontact'][$d]:0;
                            $result['callback'][] = isset($data['callback'][$d])?$data['callback'][$d]:0;
                            /*$result['no_active'][] = isset($data['no_active'][$d])?$data['no_active'][$d]:0;
                            $result['reject'][] = isset($data['reject'][$d])?$data['reject'][$d]:0;
                            $result['wrong_numb'][] = isset($data['wrong_numb'][$d])?$data['wrong_numb'][$d]:0;
                            $result['busy'][] = isset($data['busy'][$d])?$data['busy'][$d]:0;
                            */
                        }
                    }else{
                        $_p = array();
                        foreach ($period as $key => $pval) {
                            $_d = $pval->format($php_format);
                            $_p[$_d] = $_d;
                        }

                        $period = new DatePeriod(
                             $d1,
                             new DateInterval('PT1H'),
                             $d2
                        );
                        foreach ($period as $key => $pval) {
                            $d = $pval->format($php_format);
                            if(strtotime($pval->format('H:i:s'))>=strtotime($cmp->stime_perday)&&strtotime($pval->format('H:i:s'))<=strtotime($cmp->etime_perday)){
                                if(isset($_p[$d])){
                                    $result['labels'][] = $d;
                                }else{
                                    $result['labels'][] = '';
                                }
                                $result['contact'][] = isset($data['contact'][$d])?$data['contact'][$d]:0;
                                $result['uncontact'][] = isset($data['uncontact'][$d])?$data['uncontact'][$d]:0;
                                $result['callback'][] = isset($data['callback'][$d])?$data['callback'][$d]:0;
                                /*$result['no_active'][] = isset($data['no_active'][$d])?$data['no_active'][$d]:0;
                                $result['reject'][] = isset($data['reject'][$d])?$data['reject'][$d]:0;
                                $result['wrong_numb'][] = isset($data['wrong_numb'][$d])?$data['wrong_numb'][$d]:0;
                                $result['busy'][] = isset($data['busy'][$d])?$data['busy'][$d]:0;
                                */
                            }
                        }
                    }
                }
                return $result;
            }else{
                return array();
            }
            /*$query = $this->db->get_compiled_select();
            echo $query;
            exit;*/
        }

        /*public function closing_number($id)
        {
            $this->db->select('COUNT(*) AS closing_number');
            $this->db->where_in('form_tele_result_status', array('Tertarik - Option 1','Tertarik - Option 2','Tertarik - Option 3'));
            $this->db->from($this->table.$id);
            $query = $this->db->get();
            $final = $query->result();
            return $final[0]->closing_number;
        }*/

        public function success_selling($id)
        {
            $query          =   $this->db->query('SHOW COLUMNS FROM `data_campaign_'.$id.'`');
            $final_query    =   $query->result();

            for ($i=0; $i < count($final_query); $i++) {
                if (isset($final_query[$i]->Field) AND $final_query[$i]->Field == 'form_follow_up_tele_result') {
                    $this->db->select('`a`.`adm_id`,`a`.`adm_name`,`a`.`adm_ext`,`b`.*,`c`.`campaign_id`,`c`.`campaign_name`,
                        `d`.`form_follow_up_tele_result`,COUNT(`d`.`form_tele_result_status`) AS `result_status_number`');
                }else if(isset($final_query[$i]->Field) AND $final_query[$i]->Field == 'form_campaign_status'){
                    $this->db->select('`a`.`adm_id`,`a`.`adm_name`,`a`.`adm_ext`,`b`.*,`c`.`campaign_id`,`c`.`campaign_name`,
                        `d`.`form_campaign_status`,COUNT(`d`.`form_campaign_status`) AS `result_status_number`');
                }else if(isset($final_query[$i]->Field) AND $final_query[$i]->Field == 'form_tele_result_status'){
                    $this->db->select('`a`.`adm_id`,`a`.`adm_name`,`a`.`adm_ext`,`b`.*,`c`.`campaign_id`,`c`.`campaign_name`,
                        `d`.`form_tele_result_status`,COUNT(`d`.`form_tele_result_status`) AS `result_status_number`');
                }else{
                    $this->db->select('`a`.`adm_id`,`a`.`adm_name`,`a`.`adm_ext`,`b`.*,`c`.`campaign_id`,`c`.`campaign_name`');
                }

            }
            $this->db->from('`v_admin` `a`');
            $this->db->join('`v_assign_campaign` `b`', '`a`.`adm_id` = `b`.`adm_id`');
            $this->db->join('`v_campaign` `c`', '`c`.`campaign_id` = `b`.`campaign_id`');
            $this->db->join('`data_campaign_'.$id.'` `d`', '`d`.`assign_id` = `b`.`assign_id`');
            $this->db->where('`c`.`campaign_id`', $id);

            for ($i=0; $i < count($final_query); $i++) {
                if (isset($final_query[$i]->Field) AND $final_query[$i]->Field == 'form_follow_up_tele_result') {
                    $this->db->like('`d`.`form_follow_up_tele_result`', 'Tertarik', 'after');
                }else if(isset($final_query[$i]->Field) AND $final_query[$i]->Field == 'form_campaign_status'){
                    $this->db->like('`d`.`form_campaign_status`', 'Tertarik', 'after');
                }else if(isset($final_query[$i]->Field) AND $final_query[$i]->Field == 'form_tele_result_status'){
                    $this->db->like('`d`.`form_tele_result_status`', 'Tertarik', 'after');
                }
            }

            $this->db->group_by('`a`.`adm_name`', 'ASC');

            for ($i=0; $i < count($final_query); $i++) {
                if ($final_query[$i]->Field == 'form_follow_up_tele_result') {
                    $this->db->order_by('`result_status_number`', 'DESC');
                }
                if ($final_query[$i]->Field == 'form_campaign_status') {
                    $this->db->order_by('`result_status_number`', 'DESC');
                }
                if ($final_query[$i]->Field == 'form_tele_result_status') {
                    $this->db->order_by('`result_status_number`', 'DESC');
                }
            }

            $this->db->limit(5,0);
            $query = $this->db->get();
            return $query->result();
        }

        public function call_p(){
            $id=27;
            $this->db->select('v_admin.adm_name,COUNT(*),sec_to_time(SUM(time_to_sec(duration)))');
            $this->db->from('call_attemp_'.$id);
            $this->db->join('v_admin','v_admin.adm_id=agent_id');
            $this->db->where('date(call_attemp_27.attemp_date)="2020-03-24"');
            $this->db->group_by('agent_id');
            return $this->db->get()->result();


        }

        /*public function success_selling($id)
        {
            $this->db->select('`v_admin`.`adm_name`,COUNT(`call_attemp_'.$id.'`.`form_tele_result_status`) AS "closing_number"');
            $this->db->from('`v_admin`');
            $this->db->join('`call_attemp_'.$id.'`', '`v_admin`.`adm_id` = `call_attemp_'.$id.'`.`agent_id`');
            $this->db->where('`call_attemp_'.$id.'`.`api_status`', 'ANSWER');
            $this->db->where('`call_attemp_'.$id.'`.`call_status`', 'Contacted');
            $this->db->where('`call_attemp_'.$id.'`.`status`', 'Complete');
            $this->db->like('`call_attemp_'.$id.'`.`form_tele_result_status`', 'Tertarik option', 'after');
            $this->db->group_by('`v_admin`.`adm_name`');
            $this->db->order_by('closing_number', 'DESC');
            $this->db->limit(5,0);
            $query = $this->db->get();
            return $query->result();
        }*/

        function tes(){

            $result=$this->db->query("SELECT status,u.adm_name, IFNULL(SUM(dc.form_balance),0) as os_balance, SUM(IF(dc.data_id IS NOT NULL, 1, 0)) as total_account FROM v_admin u JOIN `v_assign_campaign` ac ON (u.adm_id=ac.adm_id) LEFT JOIN call_attemp_27 
dc ON (ac.assign_id=dc.assign_id) WHERE ac.campaign_id = 27 group by u.adm_id,status")->result();
            $agent=$this->agent();
            $status=$this->status();

             $data = array();

            foreach ($status as $value) {
                foreach ($agent as $v) {
                    $data[$value->status][strtolower($v->name)]['a']=0;
                    $data[$value->status][strtolower($v->name)]['b']=0;
                }
            }



         foreach ($result as $key => $value) {
            $data[$value->status][strtolower($value->adm_name)]['a']=$value->total_account;
            $data[$value->status][strtolower($value->adm_name)]['b']=$value->os_balance;
        }

        
        foreach ($data as $key => $value) {
            $total = 0;
            foreach ($agent as $v) {
                $data[$key][strtolower($v->name)]['a']=isset($data[$key][strtolower($v->name)]['a'])?$data[$key][strtolower($v->name)]['a']:0;
                $data[$key][strtolower($v->name)]['b']=isset($data[$key][strtolower($v->name)]['b'])?$data[$key][strtolower($v->name)]['b']:0;
                /*$data['Total'][strtolower($v->source_name)]=isset($data['Total'][strtolower($v->source_name)])?$data['Total'][strtolower($v->source_name)]+$data[$key][strtolower($v->source_name)]:0+$data[$key][strtolower($v->source_name)];*/
             //   $total += $data[$key][strtolower($v->source_name)];
            }
           /* $data[$key]['total']=$total;
            $data['Total']['total']=isset($data['Total']['total'])?$data['Total']['total']+$total:0+$total;*/
        }



        return array('data'=>$data,'agent'=>$agent,'status'=>$status);




        }

        function status(){
             $a=$this->db->query("SELECT status from call_attemp_27 group by status")->result();
             return $a;
        }

        function agent(){
             $a=$this->db->query("SELECT u.adm_name as name from  v_admin u JOIN `v_assign_campaign` ac ON (u.adm_id=ac.adm_id) LEFT JOIN data_campaign_27 dc ON (ac.assign_id=dc.assign_id) group by u.adm_id")->result();
             return $a;
        }
    }
?>
