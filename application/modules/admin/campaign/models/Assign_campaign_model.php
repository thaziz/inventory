<?php

class Assign_campaign_model extends CI_Model {

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
        foreach ($form as $key => $value) {
            $this->column_search[] = 'a.form_'.$value->name;
            $this->column_order[] = 'a.form_'.$value->name;
        }
        $this->column_search[] = 'c.adm_name';
        $this->column_order[] = 'c.adm_name';
        $this->db->join($this->pref.'assign_campaign b', 'a.assign_id=b.assign_id', 'left');
        $this->db->join($this->pref.'admin c', 'b.adm_id=c.adm_id', 'left');
        if($_POST['agent_id']!='All'){
            if($_POST['agent_id']==0){
                $this->db->where('b.assign_id', NULL);
            }elseif(!empty($_POST['agent_id'])){
                $this->db->where('b.assign_id', $_POST['agent_id']);
            }
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
        $this->db->join($this->pref.'assign_campaign b', 'a.assign_id=b.assign_id', 'left');
        $this->db->join($this->pref.'admin c', 'b.adm_id=c.adm_id', 'left');
        if($_POST['agent_id']!='All'){
            if($_POST['agent_id']==0){
                $this->db->where('b.assign_id', NULL);
            }elseif(!empty($_POST['agent_id'])){
                $this->db->where('b.assign_id', $_POST['agent_id']);
            }
        }
        $this->db->from($this->table.'_'.$id.' a');
        return $this->db->count_all_results();
    }

    public function find_by_id($id){
        $this->db->where('campaign_id', $id);
        $query = $this->db->get($this->table, 1);
        return $query->row();
    }

    public function detail_id($id){
        $this->db->select('a.campaign_id, a.campaign_name, concat(DATE_FORMAT(a.start_date,"%d %M %Y")," - ",DATE_FORMAT(a.end_date,"%d %M %Y")) as date_range, concat(TIME_FORMAT(a.stime_perday, "%h:%i %p")," - ", TIME_FORMAT(a.etime_perday, "%h:%i %p")) as schedule_per_day, retries, b.adm_name as created_by, a.date_create as created_at, a.script, a.form', false);
        $this->db->join($this->pref.'admin b', 'b.adm_id=a.creator_id');
        $this->db->where('a.campaign_id', $id);
        $query = $this->db->get($this->table.' a', 1);
        return $query->row();
    }

    public function agents($id){
        return $this->db->select('a.assign_id, b.adm_name')
                ->join($this->pref.'admin b','a.adm_id=b.adm_id')
                ->where('a.campaign_id',$id)
                ->get($this->pref.'assign_campaign a')->result();
    }

    public function update_data($id, $data){
        return $this->db->update_batch($this->table.'_'.$id, $data, 'data_id');
    }
    public function insert_batch($id, $_data){
        $form=$this->db->select('form')->where('campaign_id', $id)->get($this->pref.'campaign')->row();
        $form = json_decode($form->form);
        $field = array();
        foreach ($form as $key => $value) {
            $field[] = 'form_'.$value->name;
        }
        if(count($field)==count($_data[0])){
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
            //echo json_encode($data);exit;
            if($this->db->insert_batch($this->table.'_'.$id, $data)){
                return array('status' => true);
            }else{
                return array('status' => false, 'msg'=>'Import data failed, data cannot insert to database');
            }
        }else{
            return array('status' => false, 'msg'=>'Column count in excel doesn\'t match with data form');
        }
    }

    public function unassign_agents($id){
        $this->db->where_in('data_id', $_POST['data_id']);
        return $this->db->update($this->table.'_'.$id, array('assign_id'=>0));
    }
    public function auto_assign($id){
        $c=$this->db->where('campaign_id', $id)->get($this->pref.'assign_campaign')->result();
        //$d=$this->db->select('a.data_id')->join('call_attemp_'.$id.' b','a.data_id=b.data_id','left')->where(array('b.api_status'=> NULL))->get($this->table.'_'.$id.' a')->result();
        $d=$this->db->select('a.data_id')->join($this->pref.'assign_campaign b', 'a.assign_id=b.assign_id', 'left')->where(array('b.assign_id'=> null))->get($this->table.'_'.$id.' a')->result();
        if(count($d)>count($c)){
            $div = (int)(count($d)/count($c));
            $mod = count($d)%count($c);
        }else{
            $div = 1;
            $mod = 0;
        }
        $data = array();
        $i=0;
        if(count($d)>0){
            $is_mod = false;
            $helper = 0;
            for ($idx=0; $idx<count($c);$idx++) {
                for ($i;$i<count($d);$i++) {
                    if(!$is_mod){
                        $data[]=array('data_id'=>$d[$i]->data_id, 'assign_id'=>$c[$idx]->assign_id);
                    }else{
                        $data[]=array('data_id'=>$d[$i]->data_id, 'assign_id'=>$c[($idx-($idx-$helper))]->assign_id);
                        $helper++;
                    }
                    $n = $div==1?0:1;
                    if(($i+1)==($div*($idx+1)) && ($i+1)<(count($d)-($mod))){
                        $i=$i+1;
                        break;
                    }else if(($i+1)==(count($d)-($mod))){
                        $is_mod=true;
                    }
                }
            }
            return $this->db->update_batch($this->table.'_'.$id, $data, 'data_id');
        }else{
            return false;
        }
    }

}