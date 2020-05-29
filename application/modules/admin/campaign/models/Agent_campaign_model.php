<?php

class Agent_campaign_model extends CI_Model {

    private $pref = '';
	var $table = 'assign_campaign';
	var $column_order = array('a.assign_id', 'b.adm_name', 'b.adm_ext');
	var $column_search = array('a.assign_id', 'b.adm_name', 'b.adm_ext');
	var $order = array('a.assign_id' => 'asc');

	function __construct()
        {
                parent::__construct();
                $this->load->database();
                $this->pref = $this->config->item('tb_pref');
                $this->table = $this->pref.$this->table;
        }

	private function load_agents($id){
        $this->db->select('a.assign_id, b.adm_name, b.adm_ext');
        $this->db->where('campaign_id', $id);
        $this->db->join($this->pref.'admin b', 'a.adm_id=b.adm_id');
		$this->db->from($this->table.' a');
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

	public function get_load_agents($id)
    {
        $this->load_agents($id);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered($id)
    {
        $this->load_agents($id);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($id)
    {
        $this->db->join($this->pref.'admin b', 'a.adm_id=b.adm_id');
        $this->db->where('campaign_id', $id);
        $this->db->from($this->table.' a');
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
    //SELECT b.group_id FROM `v_menu` a JOIN v_admin_rule b ON a.menu_id=b.menu_id WHERE a.link_menu = 'panel/my_campaign' and b.rule = 'v-e'
    private function group_outgoing(){
        $grp = $this->db->query("SELECT b.group_id FROM `v_menu` a JOIN v_admin_rule b ON a.menu_id=b.menu_id WHERE a.link_menu = 'panel/my_campaign' and b.rule = 'v-e'")->result();
        $ids = array();
        foreach ($grp as $key => $v) {
            $ids[] = $v->group_id;
        }
        return $ids;
    }

    public function agents_in($id){
        $grp_id = $this->group_outgoing();
        $ids=$this->db->select('adm_id')->where('campaign_id',$id)
                        ->get($this->table)->result();
        $data = array();
        foreach ($ids as $key => $value) {
            $data[] = $value->adm_id;
        }
        if(count($data)>0){
            $this->db->select('adm_id, adm_name, group_name');
            $this->db->join($this->pref.'agent_group b', 'a.adm_id=b.agent_id', 'left');
            $this->db->join($this->pref.'a_group c', 'c.group_id=b.group_id', 'left');
            $this->db->where_in('grp_id',$grp_id);
            $this->db->where_in('a.adm_id',$data);
            $_data = array();
            $res = $this->db->get($this->pref.'admin a')->result();
            foreach ($res as $key => $value) {
                if($value->group_name!=null){
                    $_data[$value->group_name]['group_name']=$value->group_name;
                    $_data[$value->group_name]['data'][]=array('adm_id'=>$value->adm_id, 'adm_name'=>$value->adm_name);
                }else{
                    $_data[] = array('adm_id'=>$value->adm_id, 'adm_name'=>$value->adm_name);
                }
            }
            return $_data;
        }else{
            return array();
        }
    }
    public function agents_not_in($id){
        $grp_id = $this->group_outgoing();
         $ids=$this->db->select('adm_id')->where('campaign_id',$id)
                        ->get($this->table)->result();
        $data = array();
        foreach ($ids as $key => $value) {
            $data[] = $value->adm_id;
        }
        $this->db->select('adm_id, adm_name, group_name');
        $this->db->join($this->pref.'agent_group b', 'a.adm_id=b.agent_id', 'left');
        $this->db->join($this->pref.'a_group c', 'c.group_id=b.group_id', 'left');
        $this->db->where_in('grp_id',$grp_id);
        if(count($data)>0){
            $this->db->where_not_in('a.adm_id',$data);
        }
        $_data = array();
        $res = $this->db->get($this->pref.'admin a')->result();
        foreach ($res as $key => $value) {
            if($value->group_name!=null){
                $_data[$value->group_name]['group_name']=$value->group_name;
                $_data[$value->group_name]['data'][]=array('adm_id'=>$value->adm_id, 'adm_name'=>$value->adm_name);
            }else{
                $_data[] = array('adm_id'=>$value->adm_id, 'adm_name'=>$value->adm_name);
            }
        }
        return $_data;
    }

    public function insert($id, $data){
        //$this->db->where('campaign_id', $id)->delete($this->table);
        $flag = false;
        foreach ($data as $key => $value) {
            $query = $this->db->where($value)->get($this->table);
            if($query->num_rows()==0){
                $flag = $this->db->insert($this->table, $value);
            }
        }
        return $flag;
    }

    public function delete($id){
        return $this->db->where('campaign_id', $id)
                    ->where_in('assign_id', $_POST['assign_id'])
                    ->delete($this->table);
    }    

}