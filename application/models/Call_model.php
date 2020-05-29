<?php

class Call_model extends CI_Model{
	
	private $pref = '';
	private $table = 'call_attemp';

	function __construct(){
		parent::__construct();
        $this->load->database();	
        $this->pref = $this->config->item('tb_pref');
        //$this->table = $this->pref.$this->table;	
	}

	public function update_status(){
		$callid = $_GET['callid'];
		$duration = $_GET['billsec'];
		$status = $_GET['dialstatus'];
		$recfile = $_GET['recordingfile'];

		$query = $this->db->select('campaign_id')->where('call_id', $callid)->get($this->pref.'campaign_call', 1);
		if($query->num_rows()>0){
			$cid = $query->row()->campaign_id;
			$this->db->where('call_id', $callid)->update($this->pref.'campaign_call', array('api_status'=>$status, 'duration'=>numbtotime($duration), 'recordingfile'=>$recfile));

			return $this->db->where('call_id', $callid)->update($this->table.'_'.$cid, array('api_status'=>$status, 'duration'=>numbtotime($duration), 'recordingfile'=>$recfile));
		}else{
			return false;
		}
	}
	public function update_dial(){
		$callid = $_GET['callid'];
		$duration = $_GET['billsec'];
		$status = $_GET['dialstatus'];
		$recfile = $_GET['recordingfile'];
		return $this->db->where('call_id', $callid)->update('v_dial', array('api_status'=>$status, 'duration'=>numbtotime($duration), 'recordingfile'=>$recfile));
	}
}