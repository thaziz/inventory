<?php

class Group_model extends CI_Model {

    private $pref = '';
	var $table = 'role';
	var $column_order = array('grp_id','grp_name','grp_description');
	var $column_search = array('grp_id','grp_name','grp_description');
	var $order = array('grp_id' => 'asc');

	function __construct()
        {
                parent::__construct();
                $this->load->database();
                $this->pref = $this->config->item('tb_pref');
                $this->table = $this->pref.$this->table;
        }

	private function load_group(){
		$this->db->from($this->table);
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

	public function get_load_result()
    {
        $this->load_group();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->load_group();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function find_by_id($id){
        $this->db->where('grp_id', $id);
        $query = $this->db->get($this->table, 1);
        return $query->row();
    }

    public function get_rule($id){
        $this->db->where('group_id', $id);
        $query = $this->db->get($this->pref.'admin_rule')->result();
        $rule = array();
        foreach ($query as $key => $value) {
            $data_r = explode('-', $value->rule);
            $r = array();
            foreach ($data_r as $v) {
                $r[$v] = $v;
            }
            $rule[$value->menu_id] = $r;
        }
        return $rule;
    }

    public function insert(){
        return $this->db->insert($this->table, $_POST);
    }

    public function insert_rule($data){
        if(count($data)>0){
                return $this->db->insert_batch($this->pref.'admin_rule', $data);
        }else{
            return true;
        }
    }

    public function update_rule($id, $data){
        $this->db->where('group_id', $id);
        if($this->db->delete($this->pref.'admin_rule')){
            if(count($data)>0){
                return $this->db->insert_batch($this->pref.'admin_rule', $data);
            }else{
                return true;
            }
        }
        return false;
    }

    public function update($id){
        $this->db->where('grp_id', $id);
        return $this->db->update($this->table, $_POST);
    }

    public function delete(){
        $this->db->where_in('group_id', $_POST['grp_id']);
        if($this->db->delete($this->pref.'admin_rule')){
            $this->db->where_in('grp_id', $_POST['grp_id']);
            return $this->db->delete($this->table);
        }
        return false;
    }

    public function get_list(){
        $this->db->select('grp_id, grp_name');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function get_name($id){
        $this->db->select('grp_id as id, grp_name as name', false);
        $this->db->where_in('grp_id', $id);
        return $this->db->get($this->table)->result();
    }
}