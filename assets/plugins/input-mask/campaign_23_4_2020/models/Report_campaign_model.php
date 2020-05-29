<?php

class Report_campaign_model extends CI_Model
{

    private $pref = '';
    var $table = 'data_campaign';
    var $tbl_attemp = 'call_attemp';
    var $column_order = array('a.data_id');
    var $column_search = array('a.data_id');
    var $order = array('a.data_id' => 'asc');

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->pref = $this->config->item('tb_pref');
        //$this->table = $this->pref.$this->table;
    }

    public function normalize($id) {
         $this->db->query("UPDATE telmark.v_campaign_call as a, asteriskcdrdb.cdr as c set a.recordingfile=c.recordingfile, a.duration=sec_to_time(c.duration) WHERE c.dst=a.phone AND date(a.call_date)=date(c.calldate) AND (a.recordingfile='' or a.recordingfile is null)");

        $this->db->query("UPDATE telmark.v_campaign_call as a, call_attemp_$id as c set c.recordingfile=a.recordingfile, c.duration=a.duration WHERE c.call_id=a.call_id AND (c.recordingfile='' or c.recordingfile is null)");
        
        $this->db->query("Update telmark.call_attemp_$id a, call_center.call_progress_log b set a.duration = sec_to_time(b.duration) where a.call_id=b.uniqueid AND b.new_status = 'Hangup' AND b.duration IS NOT NULL");
        $this->db->query("Update telmark.call_attemp_$id a, call_center.call_recording b set a.recordingfile = REPLACE(b.recordingfile, DATE_FORMAT(a.attemp_date,'%Y/%m/%d/'), '') where a.call_id=b.uniqueid and a.recordingfile = ' '");
    }

    private function load_data($id)
    {
        $cmp = $this->db->select('form, sms_enabled, wa_enabled, outbound_type, call_center_campaign')->where('campaign_id', $id)->get($this->pref . 'campaign')->row();
        $sms_enabled = $cmp->sms_enabled;
        $wa_enabled = $cmp->wa_enabled;
        $form = json_decode($cmp->form);
        $this->column_order = array('a.data_id');
        $this->column_search = array('a.data_id');
        foreach ($form as $key => $value) {
            if (!isset($value->editable)) {
                $this->column_search[] = 'a.form_' . $value->name;
                $this->column_order[] = 'a.form_' . $value->name;
            } else {
                $this->column_search[] = 'a.form_' . $value->name;
                $this->column_order[] = 'a.form_' . $value->name;
            }
        }
        if ($sms_enabled == 1) {
            $this->column_search[] = 'a.sms_phone';
            $this->column_search[] = 'a.sms_text';
            $this->column_search[] = 'a.sms_send_status';
            $this->column_order[] = 'a.sms_phone';
            $this->column_order[] = 'a.sms_text';
            $this->column_order[] = 'a.sms_send_status';
        }
        $this->column_search[] = 'c.adm_name';
        $this->column_search[] = 'd.caller';
        $this->column_search[] = 'a.retries';
        $this->column_search[] = 'd.call_date';
        $this->column_search[] = 'd.api_status';
        if ($_POST['report_type'] == 'data') {
            $this->column_search[] = 'a.call_status';
            $this->column_search[] = 'a.status';
            $this->column_search[] = 'a.callback';
            $this->column_search[] = 'a.ptp_date';
            $this->column_search[] = 'a.ptp_amount';
        } else {
            $this->column_search[] = 'd.call_status';
            $this->column_search[] = 'd.status';
            $this->column_search[] = 'd.callback';
            $this->column_search[] = 'd.ptp_date';
            $this->column_search[] = 'd.ptp_amount';
        }
        /*if($cmp->outbound_type=='predictive'){
            $this->column_search[] = 'IFNULL(clog.duration, d.duration) duration';
        }else{*/
            $this->column_search[] = 'd.duration';
        //}
        $this->column_search[] = 'cmp.campaign_name';
        //$this->column_search[] = 'a.status';
        if ($_POST['report_type'] == 'data') {
            $this->column_search[] = 'a.note';
        } else {
            $this->column_search[] = 'd.note';
        }
        /*if($cmp->outbound_type=='predictive'){
            $this->column_search[] = 'IFNULL(rec.recordingfile, d.recordingfile) recordingfile';
        }else{*/
            $this->column_search[] = 'd.recordingfile';
        //}
        $this->column_order[] = 'call.phone';
        $this->column_order[] = 'c.adm_name';
        $this->column_order[] = 'd.caller';
        $this->column_order[] = 'a.retries';
        $this->column_order[] = 'd.call_date';
        $this->column_order[] = 'd.api_status';
        $this->column_order[] = 'd.status';
        $this->column_order[] = 'd.call_status';
        $this->column_order[] = 'd.ptp_date';
        $this->column_order[] = 'd.ptp_amount';
        $this->column_order[] = 'd.duration';
        $this->column_order[] = 'cmp.campaign_name';
        if ($wa_enabled == 1) {
            $this->column_search[] = 'a.status_wa';
            $this->column_order[] = 'a.status_wa';
        }
        //$this->column_order[] = 'a.data_status';
        $this->column_order[] = 'a.note';
        $this->column_order[] = 'd.recordingfile';
        $this->db->select(implode(', ', $this->column_search) . ', call.phone as called_phone');
        $this->db->join($this->pref . 'assign_campaign b', 'a.assign_id=b.assign_id', 'left');
        $this->db->join('v_campaign as cmp', 'cmp.campaign_id=b.campaign_id');
        $this->db->join($this->pref . 'admin c', 'b.adm_id=c.adm_id', 'left');
        if ($_POST['report_type'] == 'data') {
            $this->db->join('(SELECT x.*, y.adm_name caller, x.attemp_date call_date FROM ' . $this->tbl_attemp . '_' . $id . ' x JOIN ' . $this->pref . 'admin y ON x.agent_id=y.adm_id JOIN (SELECT data_id, max(attemp_date) call_date FROM ' . $this->tbl_attemp . '_' . $id . ' GROUP BY data_id) z ON x.data_id=z.data_id AND x.attemp_date=z.call_date GROUP BY x.data_id) d', 'd.data_id=a.data_id', 'left');
            $this->db->group_by('a.data_id');
        } else {
            $this->db->join('(SELECT x.*, y.adm_name caller, x.attemp_date call_date FROM ' . $this->tbl_attemp . '_' . $id . ' x JOIN ' . $this->pref . 'admin y ON x.agent_id=y.adm_id) d', 'd.data_id=a.data_id');
        }
        $this->db->join($this->pref . 'campaign_call call', 'call.call_id=d.call_id', 'left');
        /*if($cmp->outbound_type=='predictive'){
            $this->db->join('call_center.call_progress_log clog', 'clog.uniqueid=d.call_id AND clog.id_campaign_outgoing='.$cmp->call_center_campaign.' AND clog.new_status=\'Hangup\'', 'left');
            $this->db->join('call_center.call_recording rec', 'rec.uniqueid=d.call_id', 'left');
        }*/
        $this->db->from($this->table . '_' . $id . ' a');
        $i = 0;
        if (isset($_POST['adv_search'])) {
            $this->adv_search_builder($_POST['adv_search'], $_POST['opt']);
            /*$sess_s['cdr_search'] = array('adv_search'=> $_POST['adv_search'],'opt'=> $_POST['opt']);
            $this->session->set_userdata('asearch',$sess_s);*/
        }
        /*foreach ($this->column_search as $item) {
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
		}*/

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column'] - 1], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_load_data($id)
    {
        $this->load_data($id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        /*  var_dump($this->db->get_compiled_select());
        exit();*/
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered($id)
    {
        $this->load_data($id);
        return $this->db->count_all_results();
    }

    public function count_all($id)
    {
        $form = $this->db->select('form, sms_enabled')->where('campaign_id', $id)->get($this->pref . 'campaign')->row();
        $form = json_decode($form->form);

        $this->column_order = array('a.data_id');
        $this->column_search = array('a.data_id');
        foreach ($form as $key => $value) {
            if (!isset($value->editable)) {
                $this->column_search[] = 'a.form_' . $value->name;
                $this->column_order[] = 'a.form_' . $value->name;
            } else {
                $this->column_search[] = 'd.form_' . $value->name;
                $this->column_order[] = 'd.form_' . $value->name;
            }
        }
        $this->db->select(implode(', ', $this->column_search) . ', c.adm_name, d.caller, a.retries, d.call_date, d.api_status, d.call_status, d.duration, a.note');
        $this->db->join($this->pref . 'assign_campaign b', 'a.assign_id=b.assign_id', 'left');
        $this->db->join($this->pref . 'admin c', 'b.adm_id=c.adm_id', 'left');
        if ($_POST['report_type'] == 'data') {
            $this->db->join('(SELECT x.*, y.adm_name caller, x.attemp_date call_date FROM ' . $this->tbl_attemp . '_' . $id . ' x JOIN ' . $this->pref . 'admin y ON x.agent_id=y.adm_id JOIN (SELECT data_id, max(attemp_date) call_date FROM ' . $this->tbl_attemp . '_' . $id . ' GROUP BY data_id) z ON x.data_id=z.data_id AND x.attemp_date=z.call_date GROUP BY x.data_id) d', 'd.data_id=a.data_id', 'left');
            $this->db->group_by('a.data_id');
        } else {
            $this->db->join('(SELECT x.*, y.adm_name caller, x.attemp_date call_date FROM ' . $this->tbl_attemp . '_' . $id . ' x JOIN ' . $this->pref . 'admin y ON x.agent_id=y.adm_id) d', 'd.data_id=a.data_id');

            //$this->db->where('d.api_status<>', '');
        }
        $this->db->join($this->pref . 'campaign_call call', 'call.call_id=d.call_id', 'left');
        $this->db->from($this->table . '_' . $id . ' a');
        $i = 0;
        if (isset($_POST['adv_search'])) {
            $this->adv_search_builder($_POST['adv_search'], $_POST['opt']);
            /*$sess_s['cdr_search'] = array('adv_search'=> $_POST['adv_search'],'opt'=> $_POST['opt']);
            $this->session->set_userdata('asearch',$sess_s);*/
        }
        return $this->db->count_all_results();
    }

    public function get_data_report($id)
    {
        $form = $this->db->select('form, sms_enabled, wa_enabled')->where('campaign_id', $id)->get($this->pref . 'campaign')->row();
        $sms_enabled = $form->sms_enabled;
        $wa_enabled = $form->wa_enabled;
        $form = json_decode($form->form);

        $this->column_order = array('a.data_id');
        $this->column_search = array('a.data_id');
        foreach ($form as $key => $value) {
            if (!isset($value->editable)) {
                $this->column_search[] = 'a.form_' . $value->name;
                $this->column_order[] = 'a.form_' . $value->name;
            } else {
                $this->column_search[] = 'a.form_' . $value->name;
                $this->column_order[] = 'a.form_' . $value->name;
            }
        }
        if ($sms_enabled == 1) {
            $this->column_search[] = 'a.sms_phone';
            $this->column_search[] = 'a.sms_text';
            $this->column_search[] = 'a.sms_send_status';
        }

        if ($wa_enabled == 1) {
            $this->column_search[] = 'a.status_wa';
            $this->column_order[] = 'a.status_wa';
        }

        if ($_POST['report_type'] == 'data') {
            $this->db->select(implode(', ', $this->column_search) . ', call.phone as called_phone, c.adm_name, d.caller, a.retries, d.call_date, d.api_status, a.call_status,a.status,a.callback,a.ptp_date,a.ptp_amount,d.duration, a.note,cmp.campaign_name');
        } else {
            $this->db->select(implode(', ', $this->column_search) . ', call.phone as called_phone, c.adm_name, d.caller, d.retries, d.call_date, d.api_status, d.call_status,d.status,d.callback,d.ptp_date,d.ptp_amount,d.duration, d.note,cmp.campaign_name');
        }
        $this->db->join($this->pref . 'assign_campaign b', 'a.assign_id=b.assign_id', 'left');
        $this->db->join('v_campaign as cmp', 'cmp.campaign_id=b.campaign_id');
        $this->db->join($this->pref . 'admin c', 'b.adm_id=c.adm_id', 'left');
        if ($_POST['report_type'] == 'data') {
            $this->db->join('(SELECT x.*, COUNT(x.data_id) retriess, y.adm_name caller, x.attemp_date call_date FROM ' . $this->tbl_attemp . '_' . $id . ' x JOIN ' . $this->pref . 'admin y ON x.agent_id=y.adm_id JOIN (SELECT data_id, max(attemp_date) call_date FROM ' . $this->tbl_attemp . '_' . $id . ' GROUP BY data_id) z ON x.data_id=z.data_id AND x.attemp_date=z.call_date GROUP BY x.data_id) d', 'd.data_id=a.data_id', 'left');
            $this->db->group_by('a.data_id');
        } else {
            $this->db->join('(SELECT x.*, y.adm_name caller, x.attemp_date call_date, \'1\' as retriess FROM ' . $this->tbl_attemp . '_' . $id . ' x JOIN ' . $this->pref . 'admin y ON x.agent_id=y.adm_id) d', 'd.data_id=a.data_id');
            //$this->db->where('d.api_status<>', '');
        }
        $this->db->join($this->pref . 'campaign_call call', 'call.call_id=d.call_id', 'left');
        $this->db->from($this->table . '_' . $id . ' a');
        $i = 0;
        if (isset($_POST['adv_search'])) {
            $this->adv_search_builder($_POST['adv_search'], $_POST['opt']);
            /*$sess_s['cdr_search'] = array('adv_search'=> $_POST['adv_search'],'opt'=> $_POST['opt']);
            $this->session->set_userdata('asearch',$sess_s);*/
        }
        return $this->db->get()->result();
    }

    private function adv_search_builder($adv_search, $opt)
    {
        foreach ($adv_search as $key => $value) {
            $field = $key;
            if (strpos($key, 'form_') !== false) {
                $field = 'a.' . $key;
            } elseif ($key == 'assign_id') {
                $field = 'a.' . $key;
            } elseif ($key == 'agent_id') {
                $field = 'd.' . $key;
            } elseif ($key == 'retries') {
                $field = 'd.' . $key;
                /*}elseif($key=='data_status'){
                $field = 'a.'.$key;*/
            } elseif ($key == 'call_status') {
                $field = 'd.' . $key;
                if ($value == 'ncy') {
                    $this->db->where($field, NULL);
                    continue;
                }
            } elseif ($key == 'api_status') {
                $field = 'd.' . $key;
            } elseif ($key == 'note') {
                $field = 'a.' . $key;
            } elseif ($key == 'wa_enabled') {
                $field = 'a.' . $key;
            } elseif ($key == 'status') {
                $field = 'd.' . $key;
            }

            if (!empty($value)) {
                if (isset($opt[$key]) && $key != 'call_date') {
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
                            $this->db->where($field, $value);
                            break;
                    }
                } elseif ($key == 'call_date') {
                    $value = explode('-', $value);
                    $sdate = date('Y-m-d H:i:s', strtotime(trim($value[0])));
                    $edate = date('Y-m-d H:i:s', strtotime(trim($value[1])));
                    $this->db->where(array('d.call_date>=' => $sdate, 'd.call_date<=' => $edate));
                } else {
                    $this->db->where($field, $value);
                }
            }
        }
    }
}
