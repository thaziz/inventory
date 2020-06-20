<?php

class Bendahara_model extends CI_Model {

    private $pref = '';
    var $table = 'purchase_order';
    var $column_order = array('po_code_a','c.d_name','e.d_name', 'po_date','po_type','po_note','po_status','adm_name','a_code');
    var $column_search = array('po_code_a','c.d_name','e.d_name', 'po_date','po_type','po_note','po_status','adm_name','a_code');
    var $order = array('po_code_a' => 'asc');

    function __construct()
        {
                parent::__construct();
                $this->load->database();
                $this->load->helper('security');
                $this->pref = $this->config->item('tb_pref');
                $this->table = $this->pref.$this->table;
        }

    private function load_admin(){        
        $this->db->select('po_id,po_code_a,c.d_name as fro,e.d_name as too, po_date,k_name as po_type,po_note,po_status,adm_name,a_code,a_name,po_anggaran', false);
        $this->db->from($this->table);
        $this->db->join($this->pref.'divisi c', $this->table.'.po_from = c.d_id');
        $this->db->join($this->pref.'divisi e', $this->table.'.po_to = e.d_id');        
        $this->db->join($this->pref.'admin d', $this->table.'.po_created_by = d.adm_id'); 
        $this->db->join($this->pref.'kategori k', $this->table.'.po_type = k.k_id');          

         $this->db->join($this->pref.'opening_account_bck oc', $this->table.'.po_kode_anggaran = oc.oa_id','left');        
        $this->db->join($this->pref.'account f', 'oc.oa_account_id = f.a_id','left');
        $this->db->where('year(po_date_created)',$this->session->userdata('tahun'));  
        $this->db->where_in('po_status',['Pinjaman','Pengembalian','Nota','Done']);
      
       // var_dump($this->db->get_compiled_select());exit();
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
     function search_po_anggaran($id){
       
        //var_dump($id);exit();
        $this->db->select('po_id,po_code,c.d_name as fro,e.d_name as too, po_date,k_name,po_note,po_status,adm_name,po_from,po_to,c.d_code,po_code_a,po_type,po_anggaran,oa_saldo,po_kode_anggaran,f.a_name,f.a_code,po_request_id', false);
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

    }
   /*  function get_request_order(){
        $form=$this->db->select('ro_id as id,ro_code as name')->where('ro_status="Open"')->get($this->pref.'request_order')->result();
        return $form;
       
    }*/
     function get_po_all($id){
       $th=$this->session->userdata('tahun');
        
        
        $this->db->select('po_id,po_code,po_code_a,c.d_name as fro,e.d_name as too, po_date,k_name as po_type,po_note,po_status,adm_name,po_from,po_to,po_anggaran,a_name,a_code,oa_saldo,a_id,total_nota', false);
        $this->db->from('v_purchase_order');
        $this->db->join($this->pref.'divisi c','v_purchase_order.po_from = c.d_id');
        $this->db->join($this->pref.'divisi e', 'v_purchase_order.po_to = e.d_id');        
        $this->db->join($this->pref.'admin d', 'v_purchase_order.po_created_by = d.adm_id');        
        $this->db->join($this->pref.'kategori k', $this->table.'.po_type = k.k_id');          
        //$this->db->join($this->pref.'account ac', 'v_purchase_order.po_kode_anggaran = ac.a_id','left');
        /* $this->db->join($this->pref.'opening_account oc', 'ac.a_id = oc.oa_account_id and oc.oa_year='.$th.'','left');*/
          $this->db->join($this->pref.'opening_account_bck oc', $this->table.'.po_kode_anggaran = oc.oa_id','left');        
        $this->db->join($this->pref.'account f', 'oc.oa_account_id = f.a_id','left');

        $this->db->where('po_id',$id);
        
        /*$a=$this->db->get_compiled_select();
        var_dump($a);exit();*/
        $master=$this->db->get()->row();
  //var_dump($master);exit();
        $detail=$this->db->select('*')->where('pod_purchase_order',$id)->where('pod_status','Setuju')->get($this->pref.'purchase_order_detail')->result();

         return array('master' =>$master,'detail'=>$detail);

    }


    function get_request_order(){
        $form=$this->db->select('po_id as id,concat(po_code_a," - ",po_note) as name')->where('po_status="Anggaran"')->get($this->pref.'purchase_order')->result();
        //var_dump($form);exit();
        return $form;
       
    }

    function insert_voucer(){
       $this->db->trans_start();

      $this->db->select('id');
      $this->db->where('status','Y');
      $q=$this->db->get('v_ttd');
      if($q->num_rows()<=0){
        return 'tidak ada ttd';
        exit();
      }

      $kode=$this->get_kode();
        if($kode->id==NULL){
            $asli='00001';
        }else{
            $asli=$this->autonumber($kode->id);
        }

        $this->db->where('ro_id',$_POST['ro_id']);
        $this->db->update('v_request_order',array('ro_status' =>'Pinjaman' , ));

       $this->db->select('po_pinjaman');     
       $this->db->where('po_id',$_POST['po_id']);
       $id_pinjaman=$this->db->from('v_purchase_order')->get()->row()->po_pinjaman;

        $data_jurnal = array(
                'j_status'=>'F',
                'j_created'=>date('Y-m-d H:i:s'), 
                'j_created_by'=>$this->session->userdata('id'),
                'j_type'=>'Bendahara',    
                           
        );


       $this->db->where('j_id',$id_pinjaman);
       $this->db->update('v_jurnal',$data_jurnal);
       //var_dump($this->db->get('v_jurnal')->result());exit();

       $data = array(
                'po_ket_voucer_pinjaman'=>$_POST['Keterangan'],
                'po_created_voucer_pinjaman'=>date('Y-m-d H:i:s'), 
                'po_created_voucer_pinjaman_by'=>$this->session->userdata('id'),
                'po_status'=>'Pinjaman',          
                'po_ttd_bendahara'=>$q->row()->id,
                'po_no_voucer_pinjaman'=>$asli,
                'po_tgl_voucer_pinjaman'=>date('Y-m-d H:i:s'),     
        );


       
       $this->db->where('po_id',$_POST['po_id']);
       $this->db->update('v_purchase_order',$data);
       
       $this->db->trans_complete();
       return $_POST['po_id'];

   
    }

    function get_kode(){
        $th=$this->session->userdata('tahun');
        $form=$this->db->select('max(po_no_voucer_pinjaman) as id')->where('YEAR(po_tgl_voucer_pinjaman)',$th)->get($this->pref.'purchase_order')->row();       
        return $form;   
    }


    function autonumber($angka) {
     
        // mengambil nilai kode ex: KNS0015 hasil KNS
       // $kode = substr($id_terakhir, 0, $panjang_kode);
        /*$angka=2;*/
        
        // mengambil nilai angka
        // ex: KNS0015 hasilnya 0015
       // $angka = '00001';
        $panjang_angka=5;
        
        // menambahkan nilai angka dengan 1
        // kemudian memberikan string 0 agar panjang string angka menjadi 4
        // ex: angka baru = 6 maka ditambahkan strig 0 tiga kali
        // sehingga menjadi 0006
        $angka_baru = str_repeat("0", $panjang_angka - strlen($angka+1)).($angka+1);
     
        // menggabungkan kode dengan nilang angka baru

        $id_baru = $angka_baru;
     
        return $id_baru;
    }



  //pengembalian  
    function insert_pengembalian(){
       $this->db->trans_start();

        $po_anggaran_revisi= (int)str_replace(".", '', $_POST['jumlah_anggaran']);
        $po_sisa_anggaran=(int)str_replace(".", '', $_POST['sisa_anggaran']);



       $this->db->select('po_kode_anggaran');     
       $this->db->where('po_id',$_POST['po_id']);
       $id_acount_opening=$this->db->from('v_purchase_order')->get()->row()->po_kode_anggaran;




       $this->db->select('oa_saldo');     
       $this->db->where('oa_id',$id_acount_opening);
       $jml_saldo=$this->db->from('v_opening_account_bck')->get()->row()->oa_saldo;

       $oa_saldo=$po_sisa_anggaran+$jml_saldo;



        $this->db->where('oa_id',$id_acount_opening);
        $this->db->update('v_opening_account_bck', array('oa_saldo' =>$oa_saldo));


        $data_jurnal=[
                    'j_type'=>'Anggaran',
                    'j_year'=>date('Y'),
                    'j_date'=>date('Y-m-d H:i:s'),
                    'j_a_code'=>$id_acount_opening, 
                    'j_nominal'=>$po_sisa_anggaran,
                    'j_note'=>'pengembalian sisa Pembelian',        
                    'j_status'=>'F',  
                    'j_jenis'=>'M',  
                    'j_fitur'=>'Bendahara',
                    'j_fitur_id'=>$_POST['po_id'],                   
                    ];

           $this->db->insert('v_jurnal',$data_jurnal);
           $id_jurnal = $this->db->insert_id();



       $data = array(
                'po_keterangan_revisi'=>$_POST['Keterangan'],
                'po_anggaran_revisi'=>$po_anggaran_revisi, 
                'po_sisa_anggaran'=>$po_sisa_anggaran, 
                'po_a_revisi_created'=>date('Y-m-d H:i:s'), 
                'po_a_revisi_created_by'=>$this->session->userdata('id'),
                'po_status'=>'Done', 
                'po_kembalian'=>$id_jurnal,               
        );


       
       $this->db->where('po_id',$_POST['po_id']);
       $this->db->update('v_purchase_order',$data);
       
       $this->db->trans_complete();
       return $_POST['po_id'];


   
    }

    function insert(){
       $this->db->trans_start();
       $data = array(
                'po_kode_anggaran'=>$_POST['kode_a'],
                'po_created_anggaran'=>date('Y-m-d H:i:s'), 
                'po_status'=>'Anggaran',               
        );


       
       $this->db->where('po_id',$_POST['po_id']);
       $this->db->update('v_purchase_order',$data);
       
       $this->db->trans_complete();


    }

   /*  function get_kode(){
        $form=$this->db->select('max(po_code) as id')->get($this->pref.'purchase_order')->row();
        
        return $form;   
    }
*/
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
        $form=$this->db->select('a_saldo')->where('a_id',$_POST['code'])->get($this->pref.'account')->row();
        
        return $form;   
    }

function print_pengeluaran($id){
        $this->db->select('po_ket_voucer_pinjaman,po_anggaran,po_no_voucer_pinjaman as no,po_tgl_voucer_pinjaman as tgl,a_code,a_name,po_ttd_bendahara,po_code_a,po_note', false);
        $this->db->join($this->pref.'opening_account_bck oc', $this->table.'.po_kode_anggaran = oc.oa_id','left');        
        $this->db->join($this->pref.'account f', 'oc.oa_account_id = f.a_id','left');        
        $this->db->from('v_purchase_order');
        $master=$this->db->where('po_id',$id)->get()->row();
        return $master;

}
 public function ttd($id){
        $this->db->select('*');
        $this->db->where('id',$id);

    return $this->db->get('v_ttd')->row();
   
    }

    function print($id){
       
        //var_dump($id);exit();
        $this->db->select('po_ket_voucer_pinjaman,po_anggaran', false);
        $this->db->from('v_purchase_order');
        $master=$this->db->where('po_id',$id)->get()->row();

        //var_dump($master);exit();


      
        return $master;

    }

    public function detail($id){
        
         $this->db->select('po_id,po_code,c.d_name as fro,e.d_name as too, po_date,k_name as po_type,po_note,po_status,adm_name,po_from,po_to,c.d_code,po_code_a,po_anggaran,oa_saldo,po_kode_anggaran,f.a_name,f.a_code,po_request_id,po_ttd_bendahara,po_pinjaman,po_kembalian', false);
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
}

}
