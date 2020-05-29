<?php

class Ivr_model extends CI_Model {

    var $table = 'ivr_template';
    private $pref = '';

    var $col_order = array('ivr_name', 'ivr_template');
    var $col_search = array('ivr_name', 'ivr_template');
    var $order = array('id' => 'desc');

    function __construct()
        {
                parent::__construct();
                $this->load->database();
                /*$this->pref = $this->config->item('tb_pref');*/
                /*$this->table = $this->pref.$this->table;*/
        }

    private function load_categories(){
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
            $this->db->order_by($this->col_order[$_POST['order']['0']['column']-2], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function load_data()
    {
        $this->load_categories();
        if($_POST['length'] != -1){
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->load_categories();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function find_by_id($id){
        $this->db->where('id', $id);
        $query = $this->db->get($this->table, 1);
        return $query->row();
    }

    public function insert(){
        return $this->db->insert($this->table, $_POST);
    }

    public function update($id){
        $this->db->where('id', $id);
        return $this->db->update($this->table, $_POST);
    }

    public function delete(){
        $this->db->where_in('id', $_POST['id']);
        return $this->db->delete($this->table);
    }
    public function get_codes(){
        $this->db->select('cat_code');
        $this->db->where_in('id', $_POST['id']);
        $result = $this->db->get($this->table)->result_array();
        return array_values($result);
    }

    public function validate_code($cat_code,$id)
    {
        $this->db->where('cat_code', $cat_code);
        $this->db->where('id <>', $id);
        $query = $this->db->get($this->table, 1);
        return $query->num_rows();
    }
}