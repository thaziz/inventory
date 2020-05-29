<?php

class Customer_model extends CI_Model {

    private $pref = '';
	var $table = 'customer';
	var $column_order = array('cus_id','cus_company','cus_name','cus_balance','cus_enabled',
								'cus_accounttype');
	var $column_search = array('cus_id','cus_company','cus_name','cus_balance','cus_enabled',
								'cus_accounttype');
	var $order = array('cus_id' => 'asc');

	function __construct()
        {
                parent::__construct();
                $this->load->database();
                $this->pref = $this->config->item('tb_pref');
                $this->table = $this->pref.$this->table;
        }

	private function load_customer(){
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
        $this->load_customer();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->load_customer();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function find_by_id($id){
        $this->db->select($this->table.'.*, v_callplan.cal_name, v_currencies.cur_name, v_timezone.tim_zone');
        $this->db->join($this->pref.'callplan', $this->table.'.cal_id = v_callplan.cal_id', 'left');
        $this->db->join($this->pref.'currencies', $this->table.'.cus_currency = v_currencies.cur_id', 'left');
        $this->db->join($this->pref.'timezone', $this->table.'.tim_id = v_timezone.tim_id', 'left');
        $this->db->where($this->column_order[0], $id);
        $query = $this->db->get($this->table, 1);
        return $query->row();
    }
    public function find_name($id){
        $this->db->select('cus_id, cus_name, cus_company');
        $this->db->where_in($this->column_order[0], $id);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function insert(){
        $_POST['cus_enabled'] = (isset($_POST['cus_enabled']) ? 1 : 0);
        $_POST['cus_sendinvoice'] = (isset($_POST['cus_sendinvoice']) ? 1 : 0);
        $_POST['cus_creation'] = date('Y-m-d h:i:sa');
        $_POST['cus_webpassword'] = hash('sha1', trim($_POST['cus_webpassword']));
        return $this->db->insert($this->table, $_POST);
    }

    public function update($id){
        $_POST['cus_enabled'] = (isset($_POST['cus_enabled']) ? 1 : 0);
        $_POST['cus_sendinvoice'] = (isset($_POST['cus_sendinvoice']) ? 1 : 0);
        if(isset($_POST['cus_webpassword']) && !empty($_POST['cus_webpassword'])){
            $_POST['cus_webpassword'] = hash('sha1', trim($_POST['cus_webpassword']));
        }else{
            unset($_POST['cus_webpassword']);
        }
        $this->db->where($this->column_order[0], $id);
        return $this->db->update($this->table, $_POST);
    }

    public function delete(){
        $this->db->where_in($this->column_order[0], $_POST['cus_id']);
        return $this->db->delete($this->table);
    }

    public function get_timezone(){
        return $this->db->get($this->pref.'timezone')->result();   
    }
    public function get_currencies(){
        $this->db->select('cur_id, cur_name');   
        return $this->db->get($this->pref.'currencies')->result();   
    }
    public function get_callplan(){
        $this->db->select('cal_id, cal_name');   
        return $this->db->get($this->pref.'callplan')->result();   
    }
}