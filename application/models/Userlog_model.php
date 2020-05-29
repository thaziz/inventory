<?php

class Userlog_model extends CI_Model {

    private $pref = '';
	var $table = 'userlog';
    var $column_order = array('log_id','user','logger_text','date');
	var $column_search = array('log_id','user','logger_text','date');
	var $order = array('date' => 'desc');

	function __construct(){
		parent::__construct();
        $this->load->database();	
        $this->pref = $this->config->item('tb_pref');
        $this->table = $this->pref.$this->table;	
	}

	public function add_log($user, $log_text){
		$this->db->where('conf_string', 'userlog');
		$log_conf = $this->db->get($this->pref.'config', 1)->row();
		$flag = true;

		if($log_conf->conf_value==1){
			$data_logger = array(
                            'user'=>$user, 
							'url'=>current_url().$_SERVER['QUERY_STRING'], 
							'logger_text'=>$log_text, 
							'date'=>date('Y-m-d H:i:s')
							);
			$flag = $this->db->insert($this->table, $data_logger);
		}
		return $flag;
	}

	private function load_config(){
		$this->db->from($this->table);
		$i = 0;
        if(isset($_POST['conf_group'])){
            $this->db->where('conf_group',$_POST['conf_group']);
        }
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
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']+1], $_POST['order']['0']['dir']);
        } 
        if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
	}

	public function get_load_result()
    {
        $this->load_config();
        if($_POST['length'] != -1){
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->load_config();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function delete(){
        $this->db->where_in('log_id', $_POST['log_id']);
        return $this->db->delete($this->table);
    }

    public function delete_more_time($time){
        $this->db->where('DATEDIFF( NOW( ) ,  `date` ) >=',$time);
        return $this->db->delete($this->table);
    }

}