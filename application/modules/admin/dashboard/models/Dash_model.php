<?php

class Dash_model extends CI_Model {

    private $colors = array(
    	"#f56954","#00a65a",
    	"#f39c12","#00c0ef",
    	"#3c8dbc","#d2d6de", 
    	"#603E82","#AD4B69", 
    	"#76AC4A", "#3A8263");

	function __construct(){
		parent::__construct();
        $this->load->database();
    }

    public function stat_sip_group(){
        $sip_group = $this->db->select('id, name')->get('v_sip_group')->result();
        $data = array();
        foreach ($sip_group as $value) {
            $color = substr(md5($value->id), ($value->id<20?$value->id:5), 6);
            $row = $this->db->select('count(id) total_cus')->where('is_trunk',0)->get('v_sip_'.$value->id, 1)->row();
            $data['label'][] = array('name'=>$value->name, 'color'=>'#'.$color);
            $data['data'][] = array(
                'value'=>$row->total_cus,
                'label'=>$value->name, 
                'color'=>'#'.$color, 
                'highlight'=>'#'.$color
            );
        }
        return $data;
    }
    public function last_call(){
    	$data = $this->db->select('ext, callerid, pre_destination, cus_cal_name, lis_name, cdr_customersellprice, cdr_terminatecause')->order_by('cdr_id', 'desc')->get('v_cdr',20)->result();
    	return $data;
    }
    public function delete_log($table_log, $date_field, $time){
        $this->db->where($date_field.' < CURDATE() - INTERVAL '.strtoupper($time));
        return $this->db->delete($table_log);
    }
}