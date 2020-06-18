<?php

class Item_model extends CI_Model {

    private $pref = '';
	var $table = 'item';
	var $column_order = array('i_code','i_name','i_unit');
	var $column_search =array('i_code','i_name','i_unit');
	var $order = array('i_code' => 'asc');

	function __construct()
        {
                parent::__construct();
                $this->load->database();
                $this->load->helper('security');
                $this->pref = $this->config->item('tb_pref');
                $this->table = $this->pref.$this->table;
        }

	private function load_admin(){
        $this->db->select($this->table.'.*');
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
        $this->load_admin();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->load_admin();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {

        $this->load_admin();
        $query = $this->db->get();
        return $this->db->count_all_results();
    }

    public function find_by_id($id){
        $this->db->where('i_id', $id);
        $this->db->select($this->table.'.*');
        //$this->db->join($this->pref.'role b', $this->table.'.grp_id = b.grp_id');
        $query = $this->db->get($this->table, 1);
        return $query->row();
    }

    public function insert(){
        $_POST['i_date'] = date('Y-m-d h:i:sa');
        return $this->db->insert($this->table, $_POST);
    }

    public function update($id){
       
        $this->db->where('i_id', $id);
        return $this->db->update($this->table, $_POST);
    }

    public function delete(){
       //var_dump($_POST);
        $this->db->where_in('i_id', $_POST['adm_id']);
        return $this->db->delete($this->table);
    }

    public function get_name($id){
        $this->db->select('i_id as id, i_name as name', false);
        $this->db->where_in('i_id', $id);
        return $this->db->get($this->table)->result();
    }


    public function get_account(){
        $this->db->select('a_id as id, concat(a_code," - ",a_name) as name', false);        
        return $this->db->get('v_account')->result();
    }

    public function get_satuan(){
        $this->db->select('s_id as id, s_name as name', false);        
        return $this->db->get('v_satuan')->result();
    }
}