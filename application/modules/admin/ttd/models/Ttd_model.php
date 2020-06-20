<?php

class Ttd_model extends CI_Model {

    private $pref = '';
	var $table = 'ttd';
	var $column_order = array('id','telaahan1','nik1','telaahan2','nik2','telaahan3','nik3','telaahan4','nik4','peminjaman1','nikp1','peminjaman2','nikp2','status');
	var $column_search =  array('id','telaahan1','nik1','telaahan2','nik2','telaahan3','nik3','telaahan4','nik4','peminjaman1','nikp1','peminjaman2','nikp2','status');
	var $order = array('id' => 'asc');

	function __construct()
        {
                parent::__construct();
                $this->load->database();
                $this->load->helper('security');
                $this->pref = $this->config->item('tb_pref');
                $this->table = $this->pref.$this->table;
        }

	private function load_admin(){
        $this->db->select('*');
        $this->db->from($this->table);
      //  $this->db->where('status','Y');
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
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function find_by_id($id){
        $this->db->where('id', $id);
        $this->db->select($this->table.'.*');
        $query = $this->db->get($this->table, 1);
        return $query->row();
    }

    public function insert(){
        $_POST['status'] = (isset($_POST['status']) ? 'Y' : 'N');
        if($_POST['status']=="Y"){
            $this->db->update($this->table,['status'=>'N']);
        }
        return $this->db->insert($this->table, $_POST);
    }

    public function update($id){
        $_POST['status'] = (isset($_POST['status']) ? 'Y' : 'N');
        if($_POST['status']=="Y"){
            $this->db->update($this->table,['status'=>'N']);
        }
        
        $this->db->where('id', $id);
        return $this->db->update($this->table, $_POST);
    }

    public function delete(){
        $this->db->where_in('id', $_POST['adm_id']);
        return $this->db->delete($this->table);
    }

    public function get_name($id){
        $this->db->select('id as id, id as name', false);
        $this->db->where_in('id', $id);
        return $this->db->get($this->table)->result();
    }

    public function get_divisi(){
        $this->db->select('d_id as id, d_name as name', false);       
        return $this->db->get('v_divisi')->result();
    }
    public function get_jabatan(){
        $this->db->select('j_id as id, j_name as name', false);       
        return $this->db->get('v_jabatan')->result();
    }
}