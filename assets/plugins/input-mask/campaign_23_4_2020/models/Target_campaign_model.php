<?php

class Target_campaign_model extends CI_Model {

    private $pref = '';
    var $table = 'campaign_target';
    var $column_search = array('id','month', 'target_amount');
    var $column_order = array('id','month', 'target_amount');
    var $order = array('campaign_id' => 'asc');

    function __construct()
        {
                parent::__construct();
                $this->load->database();
                $this->pref = $this->config->item('tb_pref');
                $this->table = $this->pref.$this->table;
        }

    private function load_target($id){

        $this->db->where('campaign_id', $id)->from($this->table);
        $i=0;
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

    public function get_load_result($id)
    {
        $this->load_target($id);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered($id)
    {
        $this->load_target($id);
        return $this->db->count_all_results();
    }

    public function count_all($id)
    {
        $this->db->where('campaign_id', $id)->from($this->table);
        return $this->db->count_all_results();
    }

    public function check_exist($id, $month, $idt=0){
        if($idt!=0)
            $this->db->where('id<>', $idt);
        $count = $this->db->where('campaign_id', $id)->where('month')->from($this->table)->count_all_results();
        return $count > 0;
    }

    public function insert($id, $month, $target){
        return $this->db->insert($this->table, array('campaign_id'=>$id, 'month'=>$month, 'target_amount'=>preg_replace('/[^0-9]/', '', $target)));
    }

    public function find_target($id){
        return $this->db->where('id',$id)->get($this->table,1)->row();
    }

    public function delete($id){
        $this->db->where_in('id', $_POST['id'])->where('campaign_id', $id);
        return $this->db->delete($this->table);
    }

}
