<?php

class Account_model extends CI_Model {

    private $pref = '';
	var $table = 'opening_account';
	var $column_order = array('a_id','a_name','a_code','b.oa_saldo','b.oa_year');
	var $column_search =array('a_id','a_name','a_code','b.oa_saldo','b.oa_year');
	var $order = array('a_id' => 'asc');

	function __construct()
        {
                parent::__construct();
                $this->load->database();
                $this->load->helper('security');
                $this->pref = $this->config->item('tb_pref');
                $this->table = $this->pref.$this->table;
        }

	private function load_admin(){

        $this->db->select('b.*,a.*,bck.oa_saldo as saldo_akhir');
        $this->db->join('v_account a','a.a_id=b.oa_account_id');
        $this->db->join('v_opening_account_bck bck','bck.oa_account_id=b.oa_account_id and bck.oa_year=b.oa_year');
        $this->db->from($this->table.' b');		
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
        $this->db->where('oa_id', $id);
        $this->db->select('*');
         $this->db->join('v_account a','a.a_id=b.oa_account_id');
        $query = $this->db->get($this->table. ' b', 1);
        //var_dump($query->result());exit();
        return $query->row();
    }

    public function insert(){


        $_POST['oa_created_by'] = $this->session->userdata['name'];
        $_POST['oa_created'] = date('Y-m-d h:i:sa');
        $_POST['oa_saldo'] = str_replace(".", '', $_POST['oa_saldo']);        
        $_POST['oa_year'] = date('Y');
        $this->db->insert($this->table.'_bck', $_POST);
         $_POST['oa_id'] = $this->db->insert_id();



        $data_jurnal=[
                    'j_type'=>'Opening',
                    'j_year'=>date('Y'),
                    'j_date'=>date('Y-m-d H:i:s'),
                    'j_a_code'=>$_POST['oa_id'],
                    'j_nominal'=>$_POST['oa_saldo'],
                    'j_note'=>'Opening',        
                    'j_jenis'=>'M',
                    'j_status'=>'Done',  
                    'j_fitur'=>'Input Opening Saldo',                                       
                    ];
        $this->db->insert('v_jurnal',$data_jurnal);
        $id_jurnal = $this->db->insert_id();

        /*$this->db->where('oa_id', $_POST['oa_id']);
        $this->db->update($this->table, ['oa_jurnal'=>$id_jurnal]);
*/
        $_POST['oa_jurnal'] = $id_jurnal;
        return $this->db->insert($this->table, $_POST);
    }

    public function update($id){
        $_POST['oa_updated_by'] = $this->session->userdata['name'];
        $_POST['oa_updated'] = date('Y-m-d h:i:sa');
        $_POST['oa_saldo'] = str_replace(".", '', $_POST['oa_saldo']);

        $this->db->where('oa_id', $id);
        $this->db->update($this->table.'_bck', $_POST);



        $this->db->where('oa_id', $id);
        $this->db->update($this->table, $_POST);


        $this->db->where('oa_id', $id);
        $a=$this->db->get($this->table)->row();
        var_dump($a);exit();


        $this->db->where('j_id',$jurnal);
        return $this->db->update('v_jurnal', ['j_nominal'=>$_POST['oa_saldo']]);


        /*$this->db->where('oa_id', $id);
        return $this->db->update($this->table, $_POST);*/
    }

    public function delete(){
        //var_dump($_POST);exit();
         $this->db->where_in('oa_id', $_POST['d_id']);
         $this->db->delete($this->table.'_bck');

        $this->db->where_in('oa_id', $_POST['d_id']);
        return $this->db->delete($this->table);
    }

    public function get_name($id){
        $this->db->select('oa_id as id, oa_account_id as name', false);
        $this->db->where_in('oa_id', $id);
        return $this->db->get($this->table)->result();
    }

    public function get_account(){
        $this->db->select('a_id as id, concat(a_code,"-",a_name) as name', false);       
        return $this->db->get('v_account')->result();
    }
   
}