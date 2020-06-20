<?php

class Anggaran_model extends CI_Model {

    private $pref = '';
    var $table = 'purchase_order';
    var $column_order = array('po_code','c.d_name','e.d_name', 'po_date','po_type','po_note','po_status','adm_name','a_code');
    var $column_search = array('po_code','c.d_name','e.d_name', 'po_date','po_type','po_note','po_status','adm_name','a_code');
    var $order = array('po_code' => 'asc');

    function __construct()
        {
                parent::__construct();
                $this->load->database();
                $this->load->helper('security');
                $this->pref = $this->config->item('tb_pref');
                $this->table = $this->pref.$this->table;
        }

    private function load_admin(){        
        $this->db->select('po_id,po_code_a,c.d_name as fro,e.d_name as too, po_date,k_name as po_type,po_note,po_status,adm_name,a_code,a_name,po_anggaran,po_kode_anggaran', false);
        $this->db->from($this->table);
        $this->db->join($this->pref.'divisi c', $this->table.'.po_from = c.d_id');
        $this->db->join($this->pref.'divisi e', $this->table.'.po_to = e.d_id');        
        $this->db->join($this->pref.'admin d', $this->table.'.po_created_by = d.adm_id');
        $this->db->join($this->pref.'kategori k', $this->table.'.po_type = k.k_id');   
        $this->db->join($this->pref.'opening_account_bck oc', $this->table.'.po_kode_anggaran = oc.oa_id','left');        
        $this->db->join($this->pref.'account f', 'oc.oa_account_id = f.a_id','left');
        $this->db->where('year(po_date_created)',$this->session->userdata('tahun'));  
        $this->db->where_in('po_status',['Anggaran','Pinjaman','Pengembalian','Nota']);
      
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
    //var_dump($this->db->get_compiled_select());exit();
        $query = $this->db->get();
     //   var_dump($query->result());exit();
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
        $this->db->where('adm_id', $id);
        $this->db->select($this->table.'.*, b.grp_name');
        $this->db->join($this->pref.'role b', $this->table.'.grp_id = b.grp_id');
        $query = $this->db->get($this->table, 1);
        return $query->row();
    }



     

	 function get_item(){
        $barang=$this->db->select('i_id,a_code,a_name,concat(i_code," - ",i_name," / ",i_unit)as name,i_type,i_unit as pcs')->join('v_account','a_id=i_id_account')->where('i_type="barang"')->get($this->pref.'item')->result();

        $jasa=$this->db->select('i_id,a_code,a_name,concat(i_code," - ",i_name," / ",i_unit)as name,i_type,i_unit as pcs')->join('v_account','a_id=i_id_account')->where('i_type="jasa"')->get($this->pref.'item')->result();
          return array('barang' =>$barang,'jasa'=>$jasa );
       
	}
     function get_request_order(){
        $form=$this->db->select('po_id as id,concat(po_code_a," - ",po_note) as name')->where('po_status="Telaahan"')->get($this->pref.'purchase_order')->result();
        //var_dump($form);exit();
        return $form;
       
    }

    function search_po_telaahan($id){
       
        //var_dump($id);exit();
        $this->db->select('po_id,po_code,c.d_name as fro,e.d_name as too, po_date,k_name,po_note,po_status,adm_name,po_from,po_to,c.d_code,po_code_a,k_name as po_type,po_anggaran,oa_saldo,po_kode_anggaran,po_request_id', false);
        $this->db->from('v_purchase_order');
        $this->db->join($this->pref.'divisi c','v_purchase_order.po_from = c.d_id');
        $this->db->join($this->pref.'divisi e', 'v_purchase_order.po_to = e.d_id');        
        $this->db->join($this->pref.'admin d', 'v_purchase_order.po_created_by = d.adm_id');        
        $this->db->join($this->pref.'kategori k', 'v_purchase_order.po_type = k.k_id');  

         $this->db->join($this->pref.'opening_account_bck oc', $this->table.'.po_kode_anggaran = oc.oa_id','left');        
        $this->db->join($this->pref.'account f', 'oc.oa_account_id = f.a_id','left');

        $master=$this->db->where('po_id',$id)->get()->row();

        //var_dump($master);exit();


        $detail=$this->db->select('*')->where('pod_purchase_order',$id)->where('pod_status',"Setuju")->get($this->pref.'purchase_order_detail')->result();
        return array('master' =>$master,'detail'=>$detail);

    }

     public function detail($id){
         $this->db->select('po_id,po_code,c.d_name as fro,e.d_name as too, po_date,k_name as po_type,po_note,po_status,adm_name,po_from,po_to,c.d_code,po_code_a,po_anggaran,oa_saldo,po_kode_anggaran,f.a_name,f.a_code,po_request_id', false);
        $this->db->from('v_purchase_order');
        $this->db->join($this->pref.'divisi c','v_purchase_order.po_from = c.d_id');
        $this->db->join($this->pref.'divisi e', 'v_purchase_order.po_to = e.d_id');        
        $this->db->join($this->pref.'admin d', 'v_purchase_order.po_created_by = d.adm_id');        
        $this->db->join($this->pref.'kategori k', 'v_purchase_order.po_type = k.k_id');  

         $this->db->join($this->pref.'opening_account_bck oc', $this->table.'.po_kode_anggaran = oc.oa_id','left');        
        $this->db->join($this->pref.'account f', 'oc.oa_account_id = f.a_id','left');

        $master=$this->db->where('po_id',$id)->get()->row();

        //var_dump($master);exit();


        $detail=$this->db->select('*')->where('pod_purchase_order',$id)->where('pod_status','Setuju')->get($this->pref.'purchase_order_detail')->result();
        return array('master' =>$master,'detail'=>$detail);

      /* $th=date('Y');
        
        
        $this->db->select('po_id,po_code,c.d_name as fro,e.d_name as too, po_date,po_type,po_note,po_status,adm_name,po_from,po_to,po_anggaran', false);
        $this->db->from('v_purchase_order');
        $this->db->join($this->pref.'divisi c','v_purchase_order.po_from = c.d_id');
        $this->db->join($this->pref.'divisi e', 'v_purchase_order.po_to = e.d_id');        
        $this->db->join($this->pref.'admin d', 'v_purchase_order.po_created_by = d.adm_id');        
       
        
        $this->db->where('po_id',$id);
        
        $master=$this->db->get()->row();

        $detail=$this->db->select('*')->where('pod_purchase_order',$id)->where('pod_status','Setuju')->get($this->pref.'purchase_order_detail')->result();

         return array('master' =>$master,'detail'=>$detail);*/

    }


    function get_po_all($id){
       $th=$this->session->userdata('tahun');
        
        
        $this->db->select('po_id,po_code,po_code_a,c.d_name as fro,e.d_name as too, po_date,po_type,po_note,po_status,adm_name,po_from,po_to,po_anggaran,a_name,oa_saldo,a_id', false);
        $this->db->from('v_purchase_order');
        $this->db->join($this->pref.'divisi c','v_purchase_order.po_from = c.d_id');
        $this->db->join($this->pref.'divisi e', 'v_purchase_order.po_to = e.d_id');        
        $this->db->join($this->pref.'admin d', 'v_purchase_order.po_created_anggaran_by = d.adm_id');        
        $this->db->join($this->pref.'account ac', 'v_purchase_order.po_kode_anggaran = ac.a_id','left');
         $this->db->join($this->pref.'opening_account oc', 'ac.a_id = oc.oa_account_id and oc.oa_year='.$th.'','left');
        $this->db->where('po_id',$id);
        
        /*$a=$this->db->get_compiled_select();
        var_dump($a);exit();*/
        $master=$this->db->get()->row();

        $detail=$this->db->select('*')->where('pod_purchase_order',$id)->where('pod_status','Setuju')->get($this->pref.'purchase_order_detail')->result();

         return array('master' =>$master,'detail'=>$detail);

    }



    function insert(){


       $this->db->trans_start();

      $this->db->select('id');
      $this->db->where('status','Y');
      $q=$this->db->get('v_ttd');
      if($q->num_rows()<=0){
        return 'tidak ada ttd';
        exit();
      }
    //  var_dump($_POST);exit();

       $this->db->where('ro_id',$_POST['ro_id']);
        $this->db->update('v_request_order',array('ro_status' =>'Anggaran' , ));

        $saldo= (int)str_replace(".", '', $_POST['jml_anggaran'])-(int)str_replace(".", '', $_POST['anggaran']);

      
        $data_account=[
                'oa_saldo'=>$saldo
                ];

        $this->db->where('oa_id',$_POST['kode_a']);
        $this->db->update('v_opening_account_bck', $data_account);

        $data_jurnal=[
                    'j_type'=>'Anggaran',
                    'j_year'=>date('Y'),
                    'j_jenis'=>'K',      
                    'j_date'=>date('Y-m-d H:i:s'),
                    'j_a_code'=>$_POST['kode_a'], 
                    'j_nominal'=>-(int)str_replace(".", '', $_POST['anggaran']),
                    'j_note'=>'Pengeluaran',        
                    'j_status'=>'proses',  
                    'j_fitur'=>'purchase',
                    'j_fitur_id'=>$_POST['po_id'],                   
                    ];
           $this->db->insert('v_jurnal',$data_jurnal);
           $id_jurnal = $this->db->insert_id();

       $data = array(
                'po_pinjaman'=>$id_jurnal,
                'po_kode_anggaran'=>$_POST['kode_a'],
                'po_created_anggaran'=>date('Y-m-d H:i:s'), 
                'po_status'=>'Anggaran',    
                'po_created_anggaran_by'=>$this->session->userdata('id'), 
                'po_ttd_telaahan'=>$q->row()->id,
                'sisa_anggaran_acc'=>$saldo,
        );


       
       $this->db->where('po_id',$_POST['po_id']);
       $this->db->update('v_purchase_order',$data);
       
       $this->db->trans_complete();
       return $_POST['po_id'];


    }

     function get_kode(){
        $form=$this->db->select('max(po_code) as id')->get($this->pref.'purchase_order')->row();
        
        return $form;   
    }

    function get_account(){
        
        $th=$this->session->userdata('tahun');
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

     function get_saldo(){
        $th=$this->session->userdata('tahun');
        
        $form=$this->db->select('oa_saldo')->where('oa_id',$_POST['code'])->
          join($this->pref.'opening_account_bck oc', 'ac.a_id = oc.oa_account_id','left')->
          where('oc.oa_year',$th)->
        get($this->pref.'account ac')->row();

        return number_format($form->oa_saldo,0,',','.');   
    }



}
