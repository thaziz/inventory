<?php

class Admin_model extends CI_Model {

    private $pref = '';
	var $table = 'admin';
	var $column_order = array('adm_id','adm_name','adm_ext', 'b.grp_name','adm_active','adm_lastlogin','adm_lastlogout');
	var $column_search = array('adm_id','adm_name','adm_ext', 'b.grp_name','adm_active','adm_lastlogin','adm_lastlogout');
	var $order = array('adm_id' => 'asc');

	function __construct()
        {
                parent::__construct();
                $this->load->database();
                $this->load->helper('security');
                $this->pref = $this->config->item('tb_pref');
                $this->table = $this->pref.$this->table;
        }

	private function load_admin(){
        $this->db->select($this->table.'.*, b.grp_name,c.d_name as adm_bidang,d.j_name as adm_jabatan');
        $this->db->from($this->table);
		$this->db->join($this->pref.'role b', $this->table.'.grp_id = b.grp_id');
        $this->db->join($this->pref.'divisi c', $this->table.'.adm_bidang = c.d_id');
        $this->db->join($this->pref.'jabatan d', $this->table.'.adm_jabatan = d.j_id');
        $this->db->group_by($this->table.'.adm_name');
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
        $this->db->join($this->pref.'role b', $this->table.'.grp_id = b.grp_id');
        return $this->db->count_all_results();
    }

    public function find_by_id($id){
        $this->db->where('adm_id', $id);
        $this->db->select($this->table.'.*, b.grp_name');
        $this->db->join($this->pref.'role b', $this->table.'.grp_id = b.grp_id');
        $query = $this->db->get($this->table, 1);
        return $query->row();
    }

    public function insert(){
        $_POST['adm_active'] = (isset($_POST['adm_active']) ? 1 : 0);
        $_POST['adm_password'] = hash('sha1', trim($_POST['adm_password']));
        $_POST['adm_creation'] = date('Y-m-d h:i:sa');
        return $this->db->insert($this->table, $_POST);
    }

    public function update($id){
        $_POST['adm_active'] = (isset($_POST['adm_active']) ? 1 : 0);
        if(!empty($_POST['adm_password'])){
            $_POST['adm_password'] = hash('sha1', trim($_POST['adm_password']));
        }else{
            unset($_POST['adm_password']);
        }
        $this->db->where('adm_id', $id);
        return $this->db->update($this->table, $_POST);
    }

    public function delete(){
        $this->db->where_in('adm_id', $_POST['adm_id']);
        return $this->db->delete($this->table);
    }

    public function get_name($id){
        $this->db->select('adm_id as id, adm_name as name', false);
        $this->db->where_in('adm_id', $id);
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