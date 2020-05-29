<?php

class Ticket_model extends CI_Model {

   private $pref = '';
   var $table = 'v_ticket';
   var $column_order = array('ticket_id', 'open_date', 'open_by', 'open_by_name', 'subject', 'content', 'status', 'closed_date', 'closed_by', 'closed_by_name', 'is_read');
   var $column_search = array('ticket_id', 'open_date', 'open_by', 'open_by_name', 'subject', 'content', 'status', 'closed_date', 'closed_by', 'closed_by_name', 'is_read');
   var $order = array('ticket_id' => 'asc');

   public function __construct(){
       parent::__construct();
       $this->load->database();
       $this->table = $this->pref.$this->table;
   }
   
   private function load(){
       $this->db->select('ticket_id, open_date, open_by, open_by_name, subject, content, status, closed_date, closed_by, closed_by_name, is_read');
       $this->db->from($this->table);
       $i = 0;
       foreach ($this->column_search as $item) {
           if($_POST['search']['value']){
               if($i===0){
                   $this->db->group_start();
                   $this->db->like($item, $_POST['search']['value']);
               }else{
                   $this->db->or_like($item, $_POST['search']['value']);
               }
               
               if(count($this->column_search) - 1 == $i)
                   $this->db->group_end();
               
           }
           $i++;
       }
       
       if(isset($_POST['order'])){
           $this->db->order_by($this->column_order[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
       }else if(isset($this->order)){
           $order = $this->order;
           $this->db->order_by(key($order), $order[key($order)]);
       }
   }
   
   public function get_load(){
       $this->load();
       if($_POST['length'] != -1)
           $this->db->limit($_POST['length'], $_POST['start']);
       $query = $this->db->get();
       return $query->result();
   }

   public function count_filtered(){
       $this->load();
       $query = $this->db->get();
       return $query->num_rows();
   }
   
   public function count_all(){
       $this->db->from($this->table);
       return $this->db->count_all_results();
   }
   
   public function find_id($id){
       $this->db->where('ticket_id', $id);
       $query = $this->db->get($this->table, 1);
       return $query->row();
   }
   
   public function detail($id){
       $this->db->where('ticket_id', $id);
       $query = $this->db->get($this->table, 1);
       return $query->row();
   }
   
   public function insert(){
       return $this->db->insert($this->table, $_POST);
   }
   
   public function update($id){
       $this->db->where('ticket_id', $id);
       return $this->db->update($this->table, $_POST);
   }
   
   public function delete(){
       $this->db->where('ticket_id', $_POST['id']);
       return $this->db->delete($this->table);
   }
}