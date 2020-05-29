<?php
    class Dashboard_campaign_model extends CI_Model
    {
        var $table = 'data_campaign_';

        function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        public function status_data($_data)
        {
            $this->db->select('a.status,COUNT(a.status) AS status_count', false);
            $this->db->join('call_attemp_'.$_data['id'].' b', 'a.data_id=b.data_id','left');
            $this->db->from($this->table.$_data['id'].' a');
            $this->db->group_by('a.status');
            $query = $this->db->get();
            /*$query = $this->db->get_compiled_select();
            echo $query;
            exit;*/
            if($query->num_rows() > 0){
                return $query->result();
            }
        }

        public function total_data($id)
        {
            $this->db->select('COUNT(a.status) AS total_data', false);
            $this->db->join('call_attemp_'.$id.' b', 'a.data_id=b.data_id','left');
            $this->db->from($this->table.$id.' a');
            $query = $this->db->get();
            /*$query = $this->db->get_compiled_select();
            echo $query;
            exit;*/
            if($query->num_rows() > 0){
                return $query->result();
            }
        }

        public function call_status($id)
        {
            $cmp = $this->db->where('campaign_id', $id)->get('v_campaign', 1)->row();
            $this->db->select('COUNT(b.data_id) AS total, SUM(IF(a.call_status="Contacted",1,0)) AS contacted, SUM(IF(a.call_status="Not Answer",1,0)) AS no_answer, SUM(IF(a.call_status="Not Active",1,0)) AS no_active, SUM(IF(a.call_status="Reject",1,0)) AS reject, SUM(IF(a.call_status="Wrong Number",1,0)) AS wrong_numb, SUM(IF(a.call_status="Busy",1,0)) AS busy', false);
            $this->db->join('(SELECT x.data_id, x.call_status, x.attemp_date FROM call_attemp_'.$id.' x JOIN (SELECT data_id, MAX(attemp_date) as call_date FROM call_attemp_'.$id.' GROUP BY data_id) y ON x.data_id=y.data_id AND x.attemp_date=y.call_date) a', 'a.data_id=b.data_id', 'left');
            //$this->db->where('a.attemp_date  >="'.$cmp->start_date.'%"');
            //$this->db->where('a.attemp_date  <="'.$cmp->end_date.'%"');
            $this->db->from($this->table.$id.' b');
            $query = $this->db->get();
            /*$query = $this->db->get_compiled_select();
            echo $query;
            exit;*/
            if($query->num_rows() > 0){
                return $query->row();
            }
        }

        public function call_status_date($id, $start, $end)
        {
            $this->db->select('DATE_FORMAT(attemp_date,"%d %b %y") AS call_date, SUM(IF(a.call_status="Contacted",1,0)) AS contacted, SUM(IF(a.call_status="Not Answer",1,0)) AS no_answer, SUM(IF(a.call_status="Not Active",1,0)) AS no_active, SUM(IF(a.call_status="Reject",1,0)) AS reject, SUM(IF(a.call_status="Wrong Number",1,0)) AS wrong_numb, SUM(IF(a.call_status="Busy",1,0)) AS busy', false);
            $this->db->where(array('attemp_date>='=>$start, 'attemp_date<='=> $end));
            $this->db->group_by('call_date');
            $this->db->from('call_attemp_'.$id.' a');
            $query = $this->db->get();
            /*echo $query;
            exit;*/
            $result = array('labels'=>array(), 'contacted'=>array(), 'no_answer'=>array(),
                        'no_active'=>array(), 'reject'=>array(), 'wrong_numb'=>array(), 'busy'=>array());
            if($query->num_rows() > 0){
                $_data = $query->result();
                $d1 = new DateTime($start);
                $d2 = new DateTime($end);
                $d2->add(new DateInterval('P1D'));
                $period = new DatePeriod(
                     $d1,
                     new DateInterval('P1D'),
                     $d2
                );
                $data = array();
                foreach ($_data as $key => $value) {
                    $data['contacted'][$value->call_date] = $value->contacted;
                    $data['no_answer'][$value->call_date] = $value->no_answer;
                    $data['no_active'][$value->call_date] = $value->no_active;
                    $data['reject'][$value->call_date] = $value->reject;
                    $data['wrong_numb'][$value->call_date] = $value->wrong_numb;
                    $data['busy'][$value->call_date] = $value->busy;
                }
                foreach ($period as $key => $pval) {
                    $d = $pval->format('d M y');
                    $result['labels'][] = $d;
                    $result['contacted'][] = isset($data['contacted'][$d])?$data['contacted'][$d]:0;
                    $result['no_answer'][] = isset($data['no_answer'][$d])?$data['no_answer'][$d]:0;
                    $result['no_active'][] = isset($data['no_active'][$d])?$data['no_active'][$d]:0;
                    $result['reject'][] = isset($data['reject'][$d])?$data['reject'][$d]:0;
                    $result['wrong_numb'][] = isset($data['wrong_numb'][$d])?$data['wrong_numb'][$d]:0;
                    $result['busy'][] = isset($data['busy'][$d])?$data['busy'][$d]:0;
                }
            }
            return $result;
            /*$query = $this->db->get_compiled_select();
            echo $query;
            exit;*/
        }

        public function status_call($_data)
        {
            $this->db->select('a.call_status,COUNT(a.call_status) AS call_status_count', false);
            $this->db->join('call_attemp_'.$_data['id'].' a', 'a.data_id=b.data_id');
            $this->db->from($this->table.$_data['id'].' b');
            $this->db->group_by('a.call_status');
            $query = $this->db->get();
            /*$query = $this->db->get_compiled_select();
            echo $query;
            exit;*/
            if($query->num_rows() > 0){
                return $query->result();
            }
        }

        public function merchant_status($id,$start, $end)
        {
            $this->db->select('COUNT(a.attemp_id) AS total, IFNULL(SUM(IF(a.call_status="Not Active",1,0)),0) as not_active, IFNULL(SUM(IF(a.call_status="Busy",1,0)),0) AS busy, IFNULL(SUM(IF(a.call_status="Contacted",1,0)),0) AS contacted, IFNULL(SUM(IF(a.call_status="reject",1,0)),0) AS reject, IFNULL(SUM(IF(a.call_status="wrong number",1,0)),0) AS wrong_number, IFNULL(SUM(IF(a.call_status="Callback",1,0)),0) AS call_back', false);
            $this->db->join('call_attemp_'.$id.' a', 'a.data_id=b.data_id');
            $this->db->where('a.call_status', 'Contacted');
            $this->db->where(array('a.attemp_date>='=>$start, 'a.attemp_date<='=> $end));
            $this->db->from($this->table.$id.' b');
            /*$query = $this->db->get();*/
            $query = $this->db->get();
            /*$query = $this->db->get_compiled_select();
            echo $query;
            exit;*/
            if($query->num_rows() > 0){
                return $query->row_array();
            }
        }
    }
?>
