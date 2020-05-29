<?php
/**
* 
*/
class Chart_model extends CI_Model
{
	var $table = 'v_cdr';
	
	function __construct(){
		parent::__construct();
        $this->load->database();
    }

    public function get_callperday_chart(){
    	$data = array();
    	$this->db->select("COUNT(data_campaign_".$_POST['id'].".data_id) AS campaign_total,data_campaign_".$_POST['id'].".status");
        $this->db->from('data_campaign_'.$_POST['id']);
        $this->db->join('call_attemp_'.$_POST['id'], 'data_campaign_'.$_POST['id'].'.data_id = call_attemp_'.$_POST['id'].'.data_id');
        $this->db->where('call_attemp_'.$_POST['id'].'.attemp_date'. '>=',$_POST['start_date']);
	    $this->db->where('call_attemp_'.$_POST['id'].'.attemp_date'. '<=',$_POST['end_date']);
        $query=$this->db->get();
        //$query=$this->db->get_compiled_select();

        if ($query->num_rows() > 0) {
            $final = $query->result();
            /*echo '<pre>';
            print_r($query->result());
            echo '</pre>';*/
            //return $query->result();
            for ($i=0; $i < count($final); $i++) { 
                $data['labels'][] = $final[$i]->status;
			    $data['datasets'][] = isset($final[$i]->campaign_total)?$final[$i]->campaign_total:'';
            }
            return $data;
        }
        /*
	    $this->db->where('cdr_starttime >=',date('Y-m-d', strtotime('-6 days')));
	    $this->db->where('cdr_starttime <=',date('Y-m-d', strtotime('+1 days')));
        $this->db->group_by('day');
	    $query=$this->db->get();
	    //reformat data result with day name as key and total as value
	    $result = array();
	    foreach ($query->result() as $key) {
	    	$result[$key->day] = $key->total;
	    }
	    //get days name in 7 days as array
	    $day_name = array();
		$start    = new DateTime(date('Y-m-d', strtotime('-6 days')));
		$end      = new DateTime(date('Y-m-d', strtotime('+1 days')));
		$interval = DateInterval::createFromDateString('1 day');
		$period   = new DatePeriod($start, $interval, $end);
		foreach ($period as $dt){
		    $day_name[] = $dt->format("d-M");
		}
		//reformat data if day is not set in database then set 0
		$data = array();
		foreach ($day_name as $value) {
			$data['labels'][] = $value;
			$data['datasets'][] = isset($result[$value])?intval($result[$value]):0;
		}
	    return $data;*/
    }

    public function number_of_calls(){
    	$this->db->select("COUNT(*) as counter");
    	$this->db->from($this->table);
    	$query=$this->db->get();
    	$res 		=	$query->result();
    	$compare	=	$this->average_call_perhour();
    	$array = array(
    					'for_precentage'	=>	($compare[0]->avg_perhour / 100) * $res[0]->counter,
    					'for_number'		=>	$compare[0]->avg_perhour
    					);
    	return $array;
    }

    public function average_call_perhour(){
    	$this->db->select("COUNT(*) as avg_perhour");
    	$this->db->where('cdr_starttime BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()');
    	$this->db->from($this->table);
    	$query=$this->db->get();
    	return $query->result();
    }

    public function total_call_duration(){
    	$this->db->select("count(cus_cdr_duration) count_cdr_duration,SUM(cus_cdr_duration) as total_call");
    	$this->db->from($this->table);
    	//$this->db->where('cdr_starttime BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()');
    	$this->db->where('cdr_starttime BETWEEN "2014-01-09" - INTERVAL 30 DAY AND "2014-01-09"');
    	$query=$this->db->get();
    	$all_res		=	$query->result_array();
    	$for_precentage	=	($all_res[0]['count_cdr_duration'] / 100) * $all_res[0]['total_call'];
    	return array('duration'	=>	$all_res[0]['count_cdr_duration'],'precentage'	=>	$for_precentage);
    }

    public function average_call_duration(){
    	$this->db->select("count(cus_cdr_duration) as count_all_cdr,AVG(cus_cdr_duration) as average_call");
    	$this->db->where('cdr_starttime BETWEEN "2014-01-09" - INTERVAL 30 DAY AND "2014-01-09"');
    	$this->db->from($this->table);
    	$query=$this->db->get();
    	$all_res		=	$query->result_array();
    	$for_precentage	=	($all_res[0]['count_all_cdr'] / 100) * $all_res[0]['average_call'];
    	return array('avg'	=>	$all_res[0]['count_all_cdr'],'precentage'	=>	$for_precentage);
    }

    public function total_sell_cost(){
    	$this->db->select("sum(cdr_customersellprice) as last_month_sale");
    	$this->db->where('cdr_starttime > CURDATE() - INTERVAL 2 MONTH');
    	$this->db->from($this->table);
    	$query=$this->db->get();
    	return $query->result();
    }

    /*public function get_last_month_sellprice(){
    	$this->db->select("sum(cdr_customersellprice) as last_month_sale");
    	$this->db->where('cdr_starttime < CURDATE() + INTERVAL 1 MONTH');
    	$this->db->from($this->table);
    	$query=$this->db->get();
    	return $query->result();
    }*/

    public function call_status_cancel(){
        $this->db->select("cdr_terminatecause");
        $this->db->from($this->table);
        $this->db->where('cdr_terminatecause','CANCEL');
        $this->db->where('cdr_starttime > CURDATE() - INTERVAL 1 MONTH');
        $query=$this->db->get();
        if($query->num_rows() > 0){
            $all_record = $this->all_call_records();
            $divided    =   (count($query->result()) / $all_record[0]->counter) * 100;
            /*echo count($query->result()).' '.$all_record[0]->counter;
            exit;*/
            return $divided;
        }else{
            return $query = 0;
        }
    }

    public function call_status_chaunavail(){
        $this->db->select("cdr_terminatecause");
        $this->db->from($this->table);
        $this->db->where('cdr_terminatecause','CHANUNAVAIL');
        $this->db->where('cdr_starttime > CURDATE() - INTERVAL 1 MONTH');
        $query=$this->db->get();
        if($query->num_rows() > 0){
            $all_record = $this->all_call_records();
            $divided    =   $all_record[0]->counter / count($query->result());
            return $divided;
        }else{
            return $query = 0;
        }
    }

    public function call_status_answer(){
        $this->db->select("cdr_terminatecause");
        $this->db->from($this->table);
        $this->db->where('cdr_terminatecause','ANSWER');
        $this->db->where('cdr_starttime > CURDATE() - INTERVAL 1 MONTH');
        $query=$this->db->get();
        if($query->num_rows() > 0){
            $all_record = $this->all_call_records();
            $divided    =   $all_record[0]->counter / count($query->result());
            return $divided;
        }else{
            return $query = 0;
        }
    }

    public function call_status_busy(){
        $this->db->select("cdr_terminatecause");
        $this->db->from($this->table);
        $this->db->where('cdr_terminatecause','BUSY');
        $this->db->where('cdr_starttime > CURDATE() - INTERVAL 1 MONTH');
        $query=$this->db->get();
        if($query->num_rows() > 0){
            $all_record = $this->all_call_records();
            $divided    =   $all_record[0]->counter / count($query->result());
            return $divided;
        }else{
            return $query = 0;
        }
    }

    public function all_call_records(){
        $this->db->select("count(*) as counter");
        $this->db->from($this->table);
        $this->db->where('cdr_starttime > CURDATE() - INTERVAL 1 MONTH');
        $query=$this->db->get();
        return $query->result();
    }

    
    public function failed_rating(){
        return $this->db->order_by('datecall','desc')->get('v_failedrating',7)->result();
    }
}
?>