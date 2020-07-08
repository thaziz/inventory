<?php

class Laporan_kegiatan_model extends CI_Model {

    private $pref = '';
	var $table = 'purchase_order';

	var $column_order = array('po_tgl_voucer_pinjaman','po_no_voucer_pinjaman','po_date','po_code_a','pod_item_name','pod_qty_approve','pod_harga','d_name','k_name','po_status','po_status');
	var $column_search = array('po_tgl_voucer_pinjaman','po_no_voucer_pinjaman','po_date','po_code_a','pod_item_name','pod_qty_approve','pod_harga','d_name','k_name','po_status','po_status');
	var $order = array('po_id' => 'asc');

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
        $this->db->join('v_purchase_order_detail op','pod_purchase_order=po_id');         
        $this->db->join($this->pref.'divisi c', 'b.po_from = c.d_id');
        $this->db->join($this->pref.'kategori k', 'b.po_type = k.k_id');         
        $this->db->from($this->table.' b');		
        //var_dump(isset($_POST["adv_search"]['j_a_code']));exit();
        if(isset($_POST["adv_search"]['j_a_code'])){
            $this->db->where('oa_id',$_POST["adv_search"]['j_a_code']);    
        }
        if(isset($_POST["adv_search"]['call_date'])){
            $tgl=$_POST["adv_search"]['call_date'];
             $value = explode('-', $tgl);
             $sdate = date('Y-m-d H:i:s', strtotime(trim($value[0])));
             $edate = date('Y-m-d H:i:s', strtotime(trim($value[1])));
             $this->db->where(array('po_date>='=>$sdate, 'po_date<='=>$edate));
        }
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
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
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
    //$query = $this->db->get_compiled_select();
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
        unset($_POST['t_tahun']);
        $_POST['t_year'] = date('Y');
        return $this->db->insert('v_transaksi', $_POST);
         
    }

    public function update($id){
        $_POST['t_created_by'] = $this->session->userdata['name'];
        $_POST['t_created'] = date('Y-m-d h:i:sa');
        $_POST['t_nominal'] = str_replace(".", '', $_POST['t_nominal']);        
        unset($_POST['t_tahun']);

        $_POST['t_updated_by'] = $this->session->userdata['name'];
        $_POST['t_updated'] = date('Y-m-d h:i:sa');
        
        $this->db->where('t_id', $id);
        return $this->db->update('v_transaksi', $_POST);

    }

    public function delete(){
        $this->db->where_in('t_id', $_POST['d_id']);
        return $this->db->delete($this->table);
    }

    public function get_name($id){
        $this->db->select('t_id as id, t_a_code as name', false);
        $this->db->where_in('t_id', $id);
        return $this->db->get($this->table)->result();
    }

  function get_account(){
        $th=date('Y');
        $form=$this->db->select('oa_id as id,a_code as code,a_name as name, oa_saldo')->
        join($this->pref.'opening_account_bck oc', 'ac.a_id = oc.oa_account_id','left')->
        where('oc.oa_year',$th)->
        get($this->pref.'account ac')->result();
        foreach ($form as $k => $v) {
            $form[$k]->oa_saldo=number_format($v->oa_saldo,0,',','.');
        }
        //var_dump($form);exit();
        return $form;   
    }
   
}