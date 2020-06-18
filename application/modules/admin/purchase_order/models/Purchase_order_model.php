<?php

class Purchase_order_model extends CI_Model {

    private $pref = '';
    var $table = 'purchase_order';
    var $column_order = array('po_code','c.d_name','e.d_name', 'po_date','po_type','po_note','po_status','adm_name');
    var $column_search = array('po_code','c.d_name','e.d_name', 'po_date','po_type','po_note','po_status','adm_name');
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
        $this->db->select('po_id,po_code,po_code_a,c.d_name as fro,e.d_name as too, po_date,k_name as po_type,po_note,po_status,adm_name,po_anggaran', false);
        $this->db->from($this->table);
        $this->db->join($this->pref.'divisi c', $this->table.'.po_from = c.d_id');
        $this->db->join($this->pref.'divisi e', $this->table.'.po_to = e.d_id');        
        $this->db->join($this->pref.'admin d', $this->table.'.po_created_by = d.adm_id');
        $this->db->join($this->pref.'kategori k', $this->table.'.po_type = k.k_id');   
        $this->db->where('year(po_date_created)',$this->session->userdata('tahun'));  
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
         $this->db->get();
        return $this->db->count_all_results();
    }
 
    public function count_all()
    {
        $this->load_admin();
        $query = $this->db->get();
        return $this->db->count_all_results();
    }

    public function find_by_id_edit($id){
       $th=$this->session->userdata('tahun');
        
        
        $this->db->select('po_id,po_code_a,po_code,c.d_name as fro,e.d_name as too, po_date,k_name as po_type,po_note,po_status,adm_name,po_from,po_to,po_anggaran', false);
        $this->db->from('v_purchase_order');
        $this->db->join($this->pref.'divisi c','v_purchase_order.po_from = c.d_id');
        $this->db->join($this->pref.'divisi e', 'v_purchase_order.po_to = e.d_id');        
        $this->db->join($this->pref.'admin d', 'v_purchase_order.po_created_by = d.adm_id');        
        $this->db->join($this->pref.'kategori k', 'v_purchase_order.po_type = k.k_id');     
       
        
        $this->db->where('po_id',$id);
        
        $master=$this->db->get()->row();
        $detail=$this->db->select('*')->where('pod_purchase_order',$id)->get($this->pref.'purchase_order_detail')->result();

         return array('master' =>$master,'detail'=>$detail);

    }

      public function find_by_id($id){
       $th=$this->session->userdata('tahun');
        
        $this->db->select('po_id,po_code,c.d_name as fro,e.d_name as too, po_date,k_name as po_type,po_note,po_status,adm_name,po_from,po_to,po_anggaran,po_kode_anggaran', false);
        $this->db->from('v_purchase_order');
        $this->db->join($this->pref.'divisi c','v_purchase_order.po_from = c.d_id');
        $this->db->join($this->pref.'divisi e', 'v_purchase_order.po_to = e.d_id');        
        $this->db->join($this->pref.'admin d', 'v_purchase_order.po_created_by = d.adm_id');     
        $this->db->join($this->pref.'kategori k', 'v_purchase_order.po_type = k.k_id');     
       
        
        $this->db->where('po_id',$id);
        
        /*$a=$this->db->get_compiled_select();
        var_dump($a);exit();*/
        $master=$this->db->get()->row();

        $detail=$this->db->select('*')->where('pod_purchase_order',$id)->where('pod_status','Setuju')->get($this->pref.'purchase_order_detail')->result();

         return array('master' =>$master,'detail'=>$detail);

    }


 


     public function cetak($id){
       $th=$this->session->userdata('tahun');
        
        $this->db->select('script as po_script,k_sk,po_code_a,po_id,po_code,c.d_name as fro,e.d_name as too, po_date,k_name as po_type,po_note,po_status,adm_name,po_from,po_to,po_anggaran,po_kode_anggaran,f.a_code,f.a_name,po_ttd_telaahan,k_sk_bupati', false);
        $this->db->from('v_purchase_order');
        $this->db->join($this->pref.'divisi c','v_purchase_order.po_from = c.d_id');
        $this->db->join($this->pref.'divisi e', 'v_purchase_order.po_to = e.d_id');        
        $this->db->join($this->pref.'admin d', 'v_purchase_order.po_created_by = d.adm_id');     
        $this->db->join($this->pref.'kategori k', 'v_purchase_order.po_type = k.k_id');
        $this->db->join($this->pref.'opening_account_bck oc', 'v_purchase_order.po_kode_anggaran = oc.oa_id','left');        
        $this->db->join($this->pref.'account f', 'oc.oa_account_id = f.a_id','left');     
       
        
        $this->db->where('po_id',$id);
        
        /*$a=$this->db->get_compiled_select();
        var_dump($a);exit();*/
        $master=$this->db->get()->row();
        $master->terbilang=$this->penyebut($master->po_anggaran);
        
        $detail=$this->db->select('*')->where('pod_purchase_order',$id)->where('pod_status','Setuju')->get($this->pref.'purchase_order_detail')->result();

         return array('master' =>$master,'detail'=>$detail);

    }




    function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
            $temp = $this->penyebut($nilai - 10). " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
        }     
        return $temp;
    }
 




     

	 function get_item(){
        $barang=$this->db->select('i_id,a_code,a_name,concat(i_code," - ",i_name," / ",i_unit)as name,i_type,i_unit as pcs')->join('v_account','a_id=i_id_account')->where('i_type="barang"')->get($this->pref.'item')->result();

        $jasa=$this->db->select('i_id,a_code,a_name,concat(i_code," - ",i_name," / ",i_unit)as name,i_type,i_unit as pcs')->join('v_account','a_id=i_id_account')->where('i_type="jasa"')->get($this->pref.'item')->result();
          return array('barang' =>$barang,'jasa'=>$jasa );
       
	}
     function get_request_order(){
        $form=$this->db->select('ro_id as id,concat(ro_code," - ",ro_note) as name')->where('ro_status="Permintaan"')->get($this->pref.'request_order')->result();
        return $form;
       
    }
    function get_ro_all($id){
       
        
        $this->db->select('ro_id,ro_code,c.d_name as fro,e.d_name as too, ro_date,k_name,ro_note,ro_status,adm_name,ro_from,ro_to,c.d_code,k_id', false);
        $this->db->from('v_request_order');
        $this->db->join($this->pref.'divisi c','v_request_order.ro_from = c.d_id');
        $this->db->join($this->pref.'divisi e', 'v_request_order.ro_to = e.d_id');        
        $this->db->join($this->pref.'admin d', 'v_request_order.ro_created_by = d.adm_id');        
        $this->db->join($this->pref.'kategori k', 'v_request_order.ro_type = k.k_id');  
        $master=$this->db->where('ro_id',$id)->get()->row();

        //var_dump($master);exit();


        $detail=$this->db->select('*')->where('rod_request_order',$id)->get($this->pref.'request_order_detail')->result();
        return array('master' =>$master,'detail'=>$detail);

    }



    function insert(){
        $this->db->trans_start();
        $this->db->where('ro_id',$_POST['ro_id']);
        $this->db->update('v_request_order',array('ro_status' =>'Telaahan' , ));
         $_POST['anggaran'] = str_replace(".", '', $_POST['anggaran']);
       
        $data = array(
                'po_request_id'=>$_POST['ro_id'],
                'po_code_a'=>$_POST['no'],
                'po_code'=>$_POST['asli'],
                'po_from'=>$_POST['from'],
                'po_to'=>$_POST['to'],
                'po_date'=>date('Y-m-d'),
                'po_note'=>$_POST['perihal'],
                'po_type'=>$_POST['type'],
                'po_anggaran'=>$_POST['anggaran'],
                'po_status'=>'Telaahan',                
                'po_created_by'=>$this->session->userdata('id'),     
                'po_date_created'=>date('Y-m-d H:i:s'),    
                'script'=>htmlspecialchars_decode($_POST['script']),    
                      
        );


        $this->db->insert('v_purchase_order',$data);    
        $id = $this->db->insert_id();
       
//   var_dump($_POST);exit();


         $result = array();
         $index=1;
                foreach($_POST['id'] AS $key => $val){
                     $result[] = array(
                      'pod_purchase_order'   => $id,
                      'pod_detailid'   =>$_POST['detail'][$key],
                      'pod_item'   => $_POST['barang_id'][$key],
                      'pod_item_name'   => $_POST['barang'][$key],
                      'pod_qty'   => $_POST['jumlah'][$key],
                      'pod_qty_approve'=> $_POST['jumlah_apr'][$key],
                      //'pod_unit'   => $_POST['pcs'][$key],
                      'pod_note'   => $_POST['node_etail'][$key],
                      'pod_status'   => $_POST['status_dt'][$key],
                     );
                     $index++;
                }      
            //MULTIPLE INSERT TO DETAIL TABLE
            $this->db->insert_batch('v_purchase_order_detail', $result);
        $this->db->trans_complete();
        return $id;


    }


    function update(){
       // var_dump($_POST);exit();
        $this->db->trans_start();
       

        $this->db->where('pod_purchase_order',$_POST['po_id']);
        $this->db->delete('v_purchase_order_detail');    

        $_POST['anggaran'] = str_replace(".", '', $_POST['anggaran']);
   
        $this->db->where('po_id',$_POST['po_id']);
        $this->db->update('v_purchase_order',array('po_anggaran' =>$_POST['anggaran'], ));    
   
        
        /*
             $data = array(
                'po_request_id'=>$_POST['ro_id'],
                'po_code_a'=>$_POST['no'],
                'po_code'=>$_POST['asli'],
                'po_from'=>$_POST['from'],
                'po_to'=>$_POST['to'],
                'po_date'=>date('Y-m-d'),
                'po_note'=>$_POST['perihal'],
                'po_type'=>$_POST['type'],
                'po_anggaran'=>$_POST['anggaran'],
                'po_status'=>'Telaahan',                
                'po_created_by'=>$this->session->userdata('id'),     
                'po_date_created'=>date('Y-m-d H:i:s'),    
                'script'=>htmlspecialchars_decode($_POST['script']),    
                      
        );


*/
         $result = array();
         $index=1;
                foreach($_POST['id'] AS $key => $val){
                     $result[] = array(
                      'pod_purchase_order'   => $_POST['po_id'],
                      'pod_detailid'   =>$_POST['detail'][$key],
                      'pod_item'   => $_POST['barang_id'][$key],
                      'pod_item_name'   => $_POST['barang'][$key],
                      'pod_qty'   => $_POST['jumlah'][$key],
                      'pod_qty_approve'=> $_POST['jumlah_apr'][$key],
                      //'pod_unit'   => $_POST['pcs'][$key],
                      'pod_note'   => $_POST['node_etail'][$key],
                      'pod_status'   => $_POST['status_dt'][$key],
                     );
                     $index++;
                }      
            //MULTIPLE INSERT TO DETAIL TABLE
            $this->db->insert_batch('v_purchase_order_detail', $result);
         
        $this->db->trans_complete();
         return $_POST['po_id'];



    }

     function get_kode(){
        $th=$this->session->userdata('tahun');
        $form=$this->db->select('max(po_code) as id')->where('YEAR(po_date)',$th)->get($this->pref.'purchase_order')->row();
       
        return $form;   
    }

    function get_po_all($id){
       $th=$this->session->userdata('tahun');
        
        
        $this->db->select('po_id,po_code,c.d_name as fro,e.d_name as too, po_date,po_type,po_note,po_status,adm_name,po_from,po_to,po_anggaran,a_name,oa_saldo,a_id', false);
        $this->db->from('v_purchase_order');
        $this->db->join($this->pref.'divisi c','v_purchase_order.po_from = c.d_id');
        $this->db->join($this->pref.'divisi e', 'v_purchase_order.po_to = e.d_id');        
        $this->db->join($this->pref.'admin d', 'v_purchase_order.po_created_by = d.adm_id');        
        $this->db->join($this->pref.'account ac', 'v_purchase_order.po_kode_anggaran = ac.a_id','left');
         $this->db->join($this->pref.'opening_account oc', 'ac.a_id = oc.oa_account_id and oc.oa_year='.$th.'','left');
        $this->db->where('po_id',$id);
        
        /*$a=$this->db->get_compiled_select();
        var_dump($a);exit();*/
        $master=$this->db->get()->row();

        $detail=$this->db->select('*')->where('pod_purchase_order',$id)->where('pod_status','Setuju')->get($this->pref.'purchase_order_detail')->result();

         return array('master' =>$master,'detail'=>$detail);

    }

    public function get_name($id){

        //var_dump($_POST);exit();
        $this->db->select('po_id as id, po_code as name', false);
        $this->db->where_in('po_id', $id);
        return $this->db->get($this->table)->result();
    }

     public function delete(){
        //var_dump($_POST);exit();
      //   $this->db->trans_start();
        $this->db->select('po_request_id');
        $this->db->where_in('po_id', $_POST['adm_id']);
        $ro_id=$this->db->get($this->table)->row();

        $this->db->where('ro_id',  $ro_id->po_request_id);
        $this->db->update($this->pref.'request_order',array('ro_status'=>'Permintaan'));
        


        $this->db->where_in('pod_purchase_order', $_POST['adm_id']);
        $this->db->delete($this->pref.'purchase_order_detail');

        $this->db->where_in('po_id', $_POST['adm_id']);
        return $this->db->delete($this->table);
       // $this->db->trans_complete();
    }

    public function ttd($id){
        $this->db->select('*');
        $this->db->where('id',$id);

    return $this->db->get('v_ttd')->row();
   
    }

}
