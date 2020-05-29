<?php

class Report_summary_campaign_model extends CI_Model
{
    private $pref = '';
    var $table = 'call_center.agent';
    var $column_order = array('a.name as name', 'DATE(b.datetime_init) as date', ' TIMEDIFF(MAX(DATE_FORMAT(b.datetime_end,"%H:%i:%s")),MIN(DATE_FORMAT(b.datetime_init,"%H:%i:%s"))) AS AUX', '(SELECT TIMEDIFF(MAX(DATE_FORMAT(b.datetime_end,"%H:%i:%s")),MIN(DATE_FORMAT(b.datetime_init,"%H:%i:%s"))) from audit as b WHERE b.id_break is null and DATE_FORMAT(b.datetime_init, "%Y-%m-%d")=DATE_FORMAT(NOW(), "%Y-%m-%d")) AS total_login_time');
    var $column_search = array('a.name', 'DATE(b.datetime_init) as date', ' TIMEDIFF(MAX(DATE_FORMAT(b.datetime_end,"%H:%i:%s")),MIN(DATE_FORMAT(b.datetime_init,"%H:%i:%s"))) AS AUX', '(SELECT TIMEDIFF(MAX(DATE_FORMAT(b.datetime_end,"%H:%i:%s")),MIN(DATE_FORMAT(b.datetime_init,"%H:%i:%s"))) from audit as b WHERE b.id_break is null and DATE_FORMAT(b.datetime_init, "%Y-%m-%d")=DATE_FORMAT(NOW(), "%Y-%m-%d")) AS total_login_time');
    var $order = array('a.id' => 'asc');

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function load_report($id)
    {
        $date = date('Y-m-d H:i:s');
        $this->db->select(implode(",", $this->column_order), false);
        $this->db->join('audit as a', 'a.id=b.id_agent');
        $this->db->where('b.id_break IS NOT NULL');
        $this->db->where('b.datetime_init', $date);
        $this->db->from('call_center.agent');
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column'] - 1], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }


    public function get_load_result($id)
    {
        $this->load_report($id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered($id)
    {
        $this->load_report($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from('outbound.' . $this->table);
        return $this->db->count_all_results();
    }
}
