<?php

class Request_order_model extends CI_Model {

    
    private $pref = '';
    var $table = 'request_order';
    var $column_order = array('ro_code','c.d_name','e.d_name', 'ro_date','ro_type','ro_note','ro_status','adm_name');
    var $column_search = array('ro_code','c.d_name','e.d_name', 'ro_date','ro_type','ro_note','ro_status','adm_name');
    var $order = array('ro_code' => 'asc');

    function __construct()
        {
                parent::__construct();
                $this->load->database();
                $this->load->helper('security');
                $this->pref = $this->config->item('tb_pref');
                $this->table = $this->pref.$this->table;
        }

    private function load_admin(){   
     
        $this->db->select('ro_id,ro_code,c.d_name as fro,e.d_name as too, ro_date,k_name,ro_note,ro_status,adm_name', false);
        $this->db->from($this->table);
        $this->db->join($this->pref.'divisi c', $this->table.'.ro_from = c.d_id');
        $this->db->join($this->pref.'divisi e', $this->table.'.ro_to = e.d_id');  
        $this->db->join($this->pref.'kategori k', $this->table.'.ro_type = k.k_id');        
        $this->db->join($this->pref.'admin d', $this->table.'.ro_created_by = d.adm_id');
        $this->db->where('year(ro_date)',$this->session->userdata('tahun'));     

        $this->db->where('ro_from',$this->session->userdata('bidang_id'));     
        
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
        //$query = $this->db->get();
        return $this->db->count_all_results();
    }

    public function find_by_id($id){
          $this->db->select('ro_id,ro_code,c.d_name as fro,e.d_name as too, ro_date,k_name,ro_note,ro_status,adm_name,ro_from,ro_to', false);
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


     

	 function get_item(){
        $barang=$this->db->select('i_id,concat(i_code," - ",i_name," / ",i_unit)as name,i_type,i_unit as pcs')->get($this->pref.'item')->result();

          return $barang;
       
	}
     function get_divisi(){
        $form=$this->db->select('d_id,concat(d_name) as name,d_desc as desc')->get($this->pref.'divisi')->result();
        return $form;       
    }
    function get_kategori(){
        $form=$this->db->where('k_status',1)->select('k_id as id,k_name as name')->get($this->pref.'kategori')->result();
        return $form;       
    }
    function get_kode(){
        /*
         $form=$this->db->select('MAX(CAST(SUBSTRING(ro_code, 9, 4) AS UNSIGNED)) as id')->like('ro_code','/'.date('Y',strtotime($_POST['tgl'])).'/')->from($this->pref.'request_order')->get()->row();
        */
        $form=$this->db->select('max(ro_code) as id')->like('ro_code','/'.date('Y',strtotime($_POST['tgl'])).'/')->get($this->pref.'request_order')->row();
        
        return $form;   
    }

    function insert(){
        //var_dump($_POST);exit();
        $this->db->trans_start();
        /*$this->db->where('ro_code',$_POST['no'])*/
        $data = array(
                'ro_code'=>$_POST['no'],
                'ro_from'=>$_POST['from'],
                'ro_to'=>$_POST['to'],
                'ro_date'=>date('Y-m-d',strtotime($_POST['tanggal'])),
                'ro_note'=>$_POST['perihal'],
                'ro_type'=>$_POST['type'],
                'ro_status'=>'Permintaan',                
                'ro_created_by'=>$this->session->userdata('id'),
                'ro_date_create'=>date('Y-m-d H:i:s'),
                
        );


        $this->db->insert('v_request_order',$data);    
        $id = $this->db->insert_id();
       
   

         $result = array();
         $index=1;
                foreach($_POST['id'] AS $key => $val){
                     $result[] = array(
                      'rod_request_order'   => $id,
                      'rod_detailid'   =>$index,
                      'rod_item'   => $_POST['id'][$key],
                      'rod_item_name'   => $_POST['barang'][$key],


                      'rod_qty'   => $_POST['jumlah'][$key],
                      //'rod_unit'   => $_POST['pcs'][$key],
                      'rod_note'   => $_POST['note'][$key],
                     );
                     $index++;
                }      
            //MULTIPLE INSERT TO DETAIL TABLE
            $this->db->insert_batch('v_request_order_detail', $result);
         
        $this->db->trans_complete();
         return $id;



    }

    function get_print($id){

        $this->db->select('ro_id,ro_code,c.d_name as fro,e.d_name as too, ro_date,k_name as ro_type,ro_note,ro_status,adm_name,adm_nik,ro_from,ro_to', false);
        $this->db->from('v_request_order');
        $this->db->join($this->pref.'divisi c','v_request_order.ro_from = c.d_id');
        $this->db->join($this->pref.'divisi e', 'v_request_order.ro_to = e.d_id');        
        $this->db->join($this->pref.'admin d', 'v_request_order.ro_created_by = d.adm_id');
        $this->db->join($this->pref.'kategori k', 'v_request_order.ro_type = k.k_id');
        $master=$this->db->where('ro_id',$id)->get()->row();


        $detail=$this->db->select('*')->where('rod_request_order',$id)->get($this->pref.'request_order_detail')->result();
      //  var_dump($detail);exit();
        return array('master' =>$master,'detail'=>$detail);

    }



      function update(){
        //var_dump($_POST);exit();
        $this->db->trans_start();
       

        $this->db->where('rod_request_order',$_POST['ro_id']);
        $this->db->delete('v_request_order_detail');    
        
       
        $this->db->where('ro_id',$_POST['ro_id']);
        $this->db->update('v_request_order',array('ro_note' =>$_POST['perihal'], ));    
   

         $result = array();
         $index=1;
                foreach($_POST['id'] AS $key => $val){
                     $result[] = array(
                      'rod_request_order'   => $_POST['ro_id'],
                      'rod_detailid'   =>$index,
                      'rod_item'   => $_POST['id'][$key],
                      'rod_item_name'   => $_POST['barang'][$key],


                      'rod_qty'   => $_POST['jumlah'][$key],
                      //'rod_unit'   => $_POST['pcs'][$key],
                      'rod_note'   => $_POST['note'][$key],
                     );
                     $index++;
                }      
            //MULTIPLE INSERT TO DETAIL TABLE
            $this->db->insert_batch('v_request_order_detail', $result);
         
        $this->db->trans_complete();
         return $_POST['ro_id'];



    }


    public function get_name($id){

        //var_dump($_POST);exit();
        $this->db->select('ro_id as id, ro_code as name', false);
        $this->db->where_in('ro_id', $id);
        return $this->db->get($this->table)->result();
    }

     public function delete(){
        $this->db->where_in('rod_request_order', $_POST['adm_id']);
        $this->db->delete($this->pref.'request_order_detail');
        //var_dump($_POST);exit();
        $this->db->where_in('ro_id', $_POST['adm_id']);
        return $this->db->delete($this->table);
    }





}
