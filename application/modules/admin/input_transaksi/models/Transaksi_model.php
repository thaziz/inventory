<?php

class Transaksi_model extends CI_Model {

    private $pref = '';
	var $table = 'transaksi';
	var $column_order = array('t_id','a_name','a_code','t_nominal','t_year');
	var $column_search =array('t_id','a_name','a_code','t_nominal','t_year');
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

        $this->db->select('*');
        $this->db->join('v_opening_account op','op.oa_id=b.t_a_code');
        $this->db->join('v_account a','a.a_id=op.oa_account_id');
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
        /*$this->db->where('oa_id', $id);
        $this->db->select('*');
         $this->db->join('v_account a','a.a_id=b.oa_account_id');
        $query = $this->db->get($this->table. ' b', 1);
*/
        $this->db->select('*');
        $this->db->join('v_opening_account op','op.oa_id=b.t_a_code');
        $this->db->join('v_account a','a.a_id=op.oa_account_id');
        $this->db->where('t_id', $id);        
        $query=$this->db->get($this->table.' b');     
        //var_dump($query->row());exit();
        return $query->row();
    }

    public function insert(){

        $_POST['t_created_by'] = $this->session->userdata['name'];
        $_POST['t_created'] = date('Y-m-d h:i:sa');
        $_POST['t_nominal'] = str_replace(".", '', $_POST['t_nominal']); 

        $this->db->select('oa_saldo');
        $this->db->where('oa_id',$_POST['t_a_code']);
        $oa_saldo=$this->db->get('v_opening_account_bck')->row()->oa_saldo;
       

        $saldo=(int)$oa_saldo+$_POST['t_nominal'];

      
        $data_account=[
                'oa_saldo'=>$saldo
                ];

        $this->db->where('oa_id',$_POST['t_a_code']);
        $this->db->update('v_opening_account_bck', $data_account);

        


        if($_POST['t_nominal']>=0){
            $jenis='M';
        }else{
            $jenis='K';
        }
         $data_jurnal=[
                    'j_type'=>'Anggaran',
                    'j_year'=>date('Y'),
                    'j_jenis'=>$jenis,      
                    'j_date'=>date('Y-m-d H:i:s'), 
                    'j_nominal'=>$_POST['t_nominal'],
                    'j_note'=>$_POST['t_note'],        
                    'j_status'=>'D',  
                    'j_fitur'=>'Transaksi',
                    'j_a_code'=>$_POST['t_a_code'],                  
                    ];


           $this->db->insert('v_jurnal',$data_jurnal);
           $id_jurnal = $this->db->insert_id();
        $_POST['t_jurnal']=$id_jurnal;

        unset($_POST['t_tahun']);
        $_POST['t_year'] = date('Y');
        return $this->db->insert('v_transaksi', $_POST);
         
    }

    public function update($id){

        $_POST['t_created_by'] = $this->session->userdata['name'];
        $_POST['t_created'] = date('Y-m-d h:i:sa');
        $_POST['t_nominal'] = str_replace(".", '', $_POST['t_nominal']); 

        $this->db->select('t_nominal,t_jurnal');
        $this->db->where('t_id', $id);
        $t_nominal=$this->db->get('v_transaksi')->row()->t_nominal;
        $t_jurnal=$this->db->get('v_transaksi')->row()->t_jurnal;



        $this->db->select('oa_saldo');
        $this->db->where('oa_id',$_POST['t_a_code']);
        $oa_saldo=$this->db->get('v_opening_account_bck')->row()->oa_saldo;
       
        $t_nominal=$t_nominal*-1;

        $saldo=((int)$oa_saldo+(int)$t_nominal)+$_POST['t_nominal'];
      
        $data_account=[
                'oa_saldo'=>$saldo
                ];

        $this->db->where('oa_id',$_POST['t_a_code']);
        $this->db->update('v_opening_account_bck', $data_account);


  

        if($_POST['t_nominal']>=0){
            $jenis='M';
        }else{
            $jenis='K';
        }


         $data_jurnal=[
                    'j_jenis'=>$jenis,      
                    'j_nominal'=>$_POST['t_nominal'],
                    ];
        $this->db->where('j_id', $t_jurnal);
        $this->db->update('v_jurnal', $data_jurnal);
/*$this->session->userdata('tahun')*/
        unset($_POST['t_tahun']);

        $_POST['t_updated_by'] = $this->session->userdata['name'];
        $_POST['t_updated'] = date('Y-m-d h:i:sa');
        
        $this->db->where('t_id', $id);
        return $this->db->update('v_transaksi', $_POST);

    }

    public function delete(){
        foreach ($_POST['d_id'] as $key => $v) {
            $this->db->select('t_nominal,t_a_code,t_jurnal');
            $this->db->where('t_id', $v);
            $transaksi=$this->db->get('v_transaksi')->row();

            $this->db->select('oa_saldo');
            $this->db->where('oa_id',$transaksi->t_a_code);
            $oa_saldo=$this->db->get('v_opening_account_bck')->row()->oa_saldo;

            $t_nominal=$transaksi->t_nominal*-1;

            $saldo=((int)$oa_saldo+(int)$t_nominal);

            $data_account=[
                'oa_saldo'=>$saldo
                ];

            $this->db->where('oa_id',$transaksi->t_a_code);
            $this->db->update('v_opening_account_bck', $data_account);

            $this->db->where('j_id', $transaksi->t_jurnal);
            $this->db->delete('v_jurnal');
                

        }

        $this->db->where_in('t_id', $_POST['d_id']);
        return $this->db->delete($this->table);
    }

    public function get_name($id){
        $this->db->select('t_id as id, t_a_code as name', false);
        $this->db->where_in('t_id', $id);
        return $this->db->get($this->table)->result();
    }

    public function get_account(){
        $this->db->select('oa_id as id, concat(a_code,"-",a_name) as name', false);
        $this->db->join('v_opening_account','oa_account_id=a_id');
        return $this->db->get('v_account')->result();
    }
   
}