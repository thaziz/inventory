<?php

class Agent_login_model extends CI_Model {

    private $pref = '';
	var $table = 'user_in_log';
    var $column_order = array('b.adm_name', 'b.adm_ext', 'a.login_time', 'a.logout_time', 'total');
	var $column_search = array('b.adm_name', 'b.adm_ext', 'a.login_time', 'a.logout_time');
	var $order = array('adm_id' => 'asc');

	function __construct()
        {
                parent::__construct();
                $this->load->database();
                $this->pref = $this->config->item('tb_pref');
                $this->table= $this->pref.$this->table;
        }

	private function load_cdr(){
        $this->db->select('b.adm_id, b.adm_name, b.adm_ext, MIN(a.login_time) as login_time, MAX(a.logout_time) as logout_time, IF(a.logout_time IS NOT NULL, SEC_TO_TIME(UNIX_TIMESTAMP(IFNULL(MAX(a.logout_time), NOW())) - UNIX_TIMESTAMP(MIN(a.login_time))), \'00:00:00\') as total, DATE_FORMAT(a.login_time, \'%Y-%m-%d\') as date_login', false);
        $this->db->join($this->pref.'admin b', 'a.adm_id=b.adm_id');
        /*$this->db->join('(SELECT x.logout_time, x.adm_id, x.login_time, DATE_FORMAT(x.login_time, \'%Y-%m-%d\') as login_date FROM v_user_in_log x JOIN (SELECT MAX(login_time) login_time, adm_id FROM v_user_in_log GROUP BY adm_id) y ON (x.adm_id=y.adm_id AND x.login_time=y.login_time)) c', 'a.adm_id=a.adm_id AND DATE_FORMAT(a.login_time, \'%Y-%m-%d\')=a.login_date');*/
        $this->db->from($this->table.' a');
        $this->db->group_by('date_login');
        $this->db->group_by('b.adm_id');
        $this->db->order_by('date_login', 'desc');
		$this->db->where('b.grp_id<>', 1);
        $this->db->where('b.grp_id<>', 3);
		$i = 0;
        /*if(isset($_POST['filter_field'])){
            $this->filter_builder($_POST['filter_field']);
            $sess_f['cdr_filter'] = $_POST['filter_field'];
            $this->session->set_userdata('afilter',$sess_f);
        }*/
        /*if(isset($_POST['adv_search'])){
            $this->adv_search_builder($_POST['adv_search'], isset($_POST['opt'])?$_POST['opt']:array());
            $sess_s['login_search'] = array('adv_search'=> $_POST['adv_search'],'opt'=> isset($_POST['opt'])?$_POST['opt']:array());
            $this->session->set_userdata('asearch',$sess_s);
        }*/
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
        $this->load_cdr();
        if($_POST['length'] != -1){
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->load_cdr();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->select('b.adm_id, b.adm_name, b.adm_ext, MIN(a.login_time) login_time, MAX(IFNULL(a.logout_time, NOW())) logout_time, SEC_TO_TIME(UNIX_TIMESTAMP(MAX(IFNULL(a.logout_time, NOW()))) - UNIX_TIMESTAMP(MIN(a.login_time))) as total, DATE_FORMAT(a.login_time, \'%Y-%m-%d\') as date_login', false);
        /*if(isset($_POST['adv_search'])){
            $this->adv_search_builder($_POST['adv_search'], isset($_POST['opt'])?$_POST['opt']:array());
        }*/
        $this->db->join($this->pref.'admin b', 'a.adm_id=b.adm_id');
        $this->db->from($this->table.' a');
        $this->db->group_by('date_login');
        $this->db->group_by('b.adm_id');
        $this->db->where('b.grp_id', 2);
        return $this->db->count_all_results();
    }

    private function adv_search_builder($adv_search, $opt){
        $field = '';
        foreach ($adv_search as $key => $value) {
            if($key=='adm_name' || $key=='adm_ext'){
                $field = 'b.'.$key;
            }else if($key=='login_time'){
                $value = explode('-', $value);
                $this->db->where('a.login_time >=', date('Y-m-d H:i:s',strtotime($value[0])));
                $this->db->where('a.login_time <=', date('Y-m-d H:i:s',strtotime($value[1])));
                continue;
            }else{
                $field = 'a.'.$key;
            }
            if(!empty($value)){
                if(isset($opt[$key])){
                    switch ($opt[$key]) {
                        case 'begins with':
                            $this->db->like($field, $value, 'after');
                            break;
                        case 'contains':
                            $this->db->like($field, $value); 
                            break;
                        case 'ends with':
                            $this->db->like($field, $value, 'before');
                            break;
                        default:
                            $this->db->where($field,$value);
                            break;
                    }
                }else{
                    $this->db->where($field,$value);
                }
            }
        }
    }

    public function delete(){
        $this->db->where_in('prc_id', $_POST['prc_id']);
        return $this->db->delete($this->table);
    }

    public function get_agent_list(){
        $data = array();
        $this->db->select('adm_id, adm_name');
        $this->db->where('grp_id',2);
        $result = $this->db->get($this->pref.'admin')->result();
        foreach ($result as $value) {
            $data[$value->adm_id] = $value->adm_name;
        }
        return $data;
    }

}
