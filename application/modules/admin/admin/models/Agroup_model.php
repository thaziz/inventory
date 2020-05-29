<?php

class Agroup_model extends CI_Model {

    var $table = 'a_group';
    private $pref = '';

    var $col_order = array('group_id','group_name', 'description');
    var $col_search = array('group_id','group_name', 'description');
    var $order = array('group_id' => 'desc');
    var $col_order2 = array('adm_id','adm_name', 'adm_ext');
    var $col_search2 = array('adm_id','adm_name', 'adm_ext');
    var $order2 = array('adm_id' => 'desc');

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
        foreach ($this->col_search as $item) {
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
 
                if(count($this->col_search) - 1 == $i)
                $this->db->group_end();
            }
            $i++;
        }

        if(isset($_POST['order']))
        {
            $this->db->order_by($this->col_order[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function load_data()
    {
        $this->load_group();
        if($_POST['length'] != -1){
            $this->db->limit($_POST['length'], $_POST['start']);
        }
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
        $this->db->where('group_id', $id);
        $query = $this->db->get($this->table, 1);
        return $query->row();
    }

    public function detail($id){
        $this->db->select('group_name, description')->where('group_id', $id);
        $query = $this->db->get($this->table, 1);
        return $query->row();
    }

    public function insert(){
        return $this->db->insert($this->table, $_POST);
    }

    public function update($id){
        $this->db->where('group_id', $id);
        return $this->db->update($this->table, $_POST);
    }

    public function delete(){
        $this->db->where('group_id', implode(',', $_POST['group_id']));
        $this->db->delete($this->pref.'agent_group');
        $this->db->where_in('group_id', implode(',', $_POST['group_id']));
        return $this->db->delete($this->table);
    }


    private function load_agent($id){
        $this->db->select('a.adm_id, a.adm_name, a.adm_ext');
        $this->db->join($this->pref.'agent_group b','a.adm_id=b.agent_id');
        $this->db->where('b.group_id',$id);
        $this->db->from($this->pref.'admin a');
        $i = 0;
        foreach ($this->col_search2 as $item) {
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
 
                if(count($this->col_search) - 1 == $i)
                $this->db->group_end();
            }
            $i++;
        }

        if(isset($_POST['order']))
        {
            $this->db->order_by($this->col_order2[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order2))
        {
            $order = $this->order2;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function load_data_agent($id)
    {
        $this->load_agent($id);
        if($_POST['length'] != -1){
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_agent($id)
    {
        $this->load_agent($id);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_agent($id)
    {
        $this->db->join($this->pref.'agent_group b','a.adm_id=b.agent_id');
        $this->db->where('b.group_id',$id);
        $this->db->from($this->pref.'admin a');
        return $this->db->count_all_results();
    }

    public function insert_agents($id, $data){
        if($this->db->where('group_id', $id)->delete($this->pref.'agent_group')){
            return $this->db->insert_batch($this->pref.'agent_group', $data);
        }else{
            return false;
        }
    }

    public function delete_agents($id){
        return $this->db->where('group_id', $id)->where_in('agent_id', $_POST['id'])->delete($this->pref.'agent_group');
    }

    public function agents_in($id){
        $ids=$this->db->select('agent_id')->where('group_id',$id)
                        ->get($this->pref.'agent_group')->result();
        $data = array();
        foreach ($ids as $key => $value) {
            $data[] = $value->agent_id;
        }
        if(count($data)>0){
            $this->db->select('adm_id, adm_name');
            $this->db->where('grp_id',2);
            $this->db->where_in('adm_id',$data);
            return $this->db->get($this->pref.'admin')->result();
        }else{
            return array();
        }
    }
    public function agents_not_in($id){
         $ids=$this->db->select('agent_id')->where('group_id',$id)
                        ->get($this->pref.'agent_group')->result();
        $data = array();
        foreach ($ids as $key => $value) {
            $data[] = $value->agent_id;
        }
        $this->db->select('adm_id, adm_name');
        $this->db->where('grp_id',2);
        if(count($data)>0){
            $this->db->where_not_in('adm_id',$data);
        }
        return $this->db->get($this->pref.'admin')->result();
    }
}