<?php

class Data_campaign_model extends CI_Model {

    private $pref = '';
	var $table = 'data_campaign';
	var $column_order = array('data_id');
	var $column_search = array('data_id');
	var $order = array('data_id' => 'asc');

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
        foreach ($form as $key => $value) {
            $this->column_search[] = 'form_'.$value->name;
            $this->column_order[] = 'form_'.$value->name;
        }

        $this->db->join($this->pref.'assign_campaign b', 'a.assign_id=b.assign_id', 'left');
        $this->db->join($this->pref.'admin c', 'b.adm_id=c.adm_id', 'left');
		$this->db->from($this->table.'_'.$id.' a');
        if(isset($_POST['adv_search'])){
            $this->adv_search_builder($_POST['adv_search'], $_POST['opt']);
            //$sess_s['cdr_search'] = array('adv_search'=> $_POST['adv_search'],'opt'=> $_POST['opt']);
            //$this->session->set_userdata('asearch',$sess_s);
        }
		$i = 0;
		foreach ($this->column_search as $item) {
			if(isset($_POST['search']['value']))
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
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
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
        //var_dump($this->db->get_compiled_select());exit();
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
        $this->db->from($this->table.'_'.$id);
        if(isset($_POST['adv_search'])){
            $this->adv_search_builder($_POST['adv_search'], $_POST['opt']);
            //$sess_s['cdr_search'] = array('adv_search'=> $_POST['adv_search'],'opt'=> $_POST['opt']);
            //$this->session->set_userdata('asearch',$sess_s);
        }
        return $this->db->count_all_results();
    }

    public function find_by_id($id, $data_id){
        $this->db->where('data_id', $data_id);
        $query = $this->db->get($this->table.'_'.$id, 1);
        return $query->row();
    }

    public function detail_id($id){
        $this->db->select('a.campaign_id, a.campaign_name, concat(DATE_FORMAT(a.start_date,"%d %M %Y")," - ",DATE_FORMAT(a.end_date,"%d %M %Y")) as date_range, concat(TIME_FORMAT(a.stime_perday, "%h:%i %p")," - ", TIME_FORMAT(a.etime_perday, "%h:%i %p")) as schedule_per_day, retries, b.adm_name as created_by, a.date_create as created_at, a.script, a.form', false);
        $this->db->join($this->pref.'admin b', 'b.adm_id=a.creator_id');
        $this->db->where('a.campaign_id', $id);
        $query = $this->db->get($this->table.' a', 1);
        return $query->row();
    }

    public function set_status($id){
        $this->db->where('data_id', $_POST['data_id']);
        return $this->db->update($this->table.'_'.$id, array('data_status'=>$_POST['status'], 'status'=>''));
    }

    public function insert($id, $data){
        return $this->db->insert($this->table.'_'.$id, $data);
    }

    public function update($id, $data_id, $data){
        $data['status']=$data['form_estatus'];unset($data['form_estatus']);
        return $this->db->where('data_id',$data_id)->update($this->table.'_'.$id, $data);
    }
    /*public function insert_batch($id, $_data){

        $form=$this->db->select('form')->where('campaign_id', $id)->get($this->pref.'campaign')->row();
        $form = json_decode($form->form);
        $field = array();
        foreach ($form as $key => $value) {
            $field[] = 'form_'.$value->name;
        }
        if(count($field)>=count($_data[0])){
            $data = array();
            for($i=0; $i<count($_data); $i++){
                $item = array();
                for ($j=0; $j<count($field); $j++) {
                    if(isset($_data[$i][$j])){
                        $item[$field[$j]] = $_data[$i][$j];
                    }else{
                        $item[$field[$j]] = "";
                    }
                }
                $data[] = $item;
            }

            //echo json_encode($data);
            //exit;

            //echo json_encode($data);exit;
            if($this->db->insert_batch($this->table.'_'.$id, $data)){
                return array('status' => true);
            }else{
                return array('status' => false, 'msg'=>'Import data failed, data cannot insert to database');
            }
        }else{
            return array('status' => false, 'msg'=>'Column count in excel doesn\'t match with data form');
        }
    }*/

    //UPDATE `calls` a, calls_contact b set a.phone = b.phone WHERE a.`id_campaign` = 24 AND a.`dnc` = 0 AND status = 'Failure' AND a.id=b.id_call_outgoing AND b.field_name = 'form_spouse_number' AND b.phone <> '0' 

    public function change_to_predictive($id) {
        $cmp=$this->db->select('form, outbound_type, call_center_campaign, retries')->where('campaign_id', $id)->get($this->pref.'campaign')->row();
        $form = json_decode($cmp->form);
        $field = array();
        $phone_field = array();

        foreach ($form as $key => $value) {
            if(isset($value->call)){
                $phone_field[] = 'form_'.$value->name;
                // /echo 'form_'.$value->name;
            }
        }

        if (!isset($_GET['filter']))
            $data = $this->db->select('data_id, assign_id, '.implode(',', $phone_field))->where(array('id_call_outgoing'=> null, 'call_status<>'=>'Contacted', 'retries<'=>$cmp->retries))->get('data_campaign_'.$id)->result();
        else
            $data = $this->db->select('data_id, assign_id, '.implode(',', $phone_field))->where(array('id_call_outgoing'=> null, $_GET['filter']=>$_GET['value'], 'retries<'=>$cmp->retries))->get('data_campaign_'.$id)->result();
        foreach ($data as $key => $value) {
            $agent = null;
            if ($value->assign_id !== null) {
                $q = $this->db->select('b.adm_ext')->join('v_admin b', 'a.adm_id=b.adm_id')->where(array('a.assign_id'=>$value->assign_id, 'a.campaign_id'=>$id))->get('v_assign_campaign a',1);
                if ($q->num_rows()>0) {
                    //$agent = 'SIP/'.$q->row()->adm_ext;
                }
            }
            for ($i=0; $i<count($phone_field); $i++) {
                if($i==0){
                    $this->db->insert('call_center.calls', array('id_campaign'=>$cmp->call_center_campaign, 'phone'=>$value->$phone_field[$i], 'agent'=>$agent));
                    $item['id_call_outgoing'] = $this->db->insert_id();
                    $this->db->where('data_id', $value->data_id)->update('data_campaign_'.$id, $item);
                }
                $this->db->insert('call_center.calls_contact', array('outbound_camp'=>$id, 'phone'=>$value->$phone_field[$i], 'id_call_outgoing'=>$item['id_call_outgoing'], 'field_name'=>$phone_field[$i]));
            }
        }
        $this->db->where('id', $cmp->call_center_campaign)->update('call_center.campaign', array('estatus'=>'A'));
    }

    public function insert_batch($id, $_data){

        $cmp=$this->db->select('form, outbound_type, call_center_campaign')->where('campaign_id', $id)->get($this->pref.'campaign')->row();
        $form = json_decode($cmp->form);
        $field = array();
        $phone_field = array();

        foreach ($form as $key => $value) {
            if(isset($value->call)){
                $phone_field[] = 'form_'.$value->name;
            }
        }
        foreach ($form as $key => $value) {
            $field[] = 'form_'.$value->name;
        }
        if(count($field)>=count($_data[0])){
            $data = array();
            for($i=0; $i<count($_data); $i++){
                $item = array();
                for ($j=0; $j<count($field); $j++) {
                    if(isset($_data[$i][$j])){
                        if($cmp->outbound_type == 'predictive'){
                            if($field[$j]==$phone_field[0]){
                                $this->db->insert('call_center.calls', array('id_campaign'=>$cmp->call_center_campaign, 'phone'=>$_data[$i][$j]));
                                $item['id_call_outgoing'] = $this->db->insert_id();
                            }
                            if(in_array($field[$j], $phone_field)){
                                $this->db->insert('call_center.calls_contact', array('outbound_camp'=>$id, 'phone'=>$_data[$i][$j], 'id_call_outgoing'=>$item['id_call_outgoing'], 'field_name'=>$field[$j]));
                            }
                        }
                        $item[$field[$j]] = $_data[$i][$j];
                    }else{
                        $item[$field[$j]] = "";
                    }
                }
                $data[] = $item;
            }

            if($cmp->outbound_type == 'predictive'){
                $this->db->where('id', $cmp->call_center_campaign)->update('call_center.campaign', array('estatus'=>'A'));
            }

            //echo json_encode($data);
            //exit;
            if($this->db->insert_batch($this->table.'_'.$id, $data)){
                return array('status' => true);
            }else{
                return array('status' => false, 'msg'=>'Import data failed, data cannot insert to database');
            }

            //echo json_encode($data);exit;
            /*if($this->db->insert_batch($this->table.'_'.$id, $data)){
                return array('status' => true);
            }else{
                return array('status' => false, 'msg'=>'Import data failed, data cannot insert to database');
            }*/
        }else{
            return array('status' => false, 'msg'=>'Column count in excel doesn\'t match with data form');
        }
    }

    public function delete($id){
        $this->db->where_in('data_id', $_POST['data_id']);
        return $this->db->delete($this->table.'_'.$id);
    }

    private function adv_search_builder($adv_search, $opt){
        foreach ($adv_search as $key => $value) {
            if(!empty($value)){
                if(isset($opt[$key])){
                    switch ($opt[$key]) {
                        case 'begins with':
                            $this->db->like($key, $value, 'after');
                            break;
                        case 'contains':
                            $this->db->like($key, $value);
                            break;
                        case 'ends with':
                            $this->db->like($key, $value, 'before');
                            break;
                        default:
                            $this->db->where($key,$value);
                            break;
                    }
                }else{
                    $this->db->where($key,$value);
                }
            }
        }
    }

}
