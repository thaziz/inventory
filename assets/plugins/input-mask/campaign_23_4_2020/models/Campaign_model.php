<?php

class Campaign_model extends CI_Model
{

    private $pref = '';
    var $table = 'campaign';
    var $column_order = array('a.campaign_id', 'a.campaign_name', 'a.start_date', 'b.adm_name');
    var $column_search = array('a.campaign_id', 'a.campaign_name', 'concat(DATE_FORMAT(a.start_date,"%d %M %Y")," - ",DATE_FORMAT(a.end_date,"%d %M %Y"))', 'b.adm_name', 'a.stime_perday', 'a.etime_perday', 'a.retries', 'a.date_create', 'a.script', 'a.form');
    var $order = array('campaign_id' => 'asc');

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->pref = $this->config->item('tb_pref');
        $this->table = $this->pref . $this->table;
    }

    private function load_campaign($rule)
    {
        $this->db->select('a.campaign_id, a.campaign_name, concat(DATE_FORMAT(a.start_date,"%d %M %Y")," - ",DATE_FORMAT(a.end_date,"%d %M %Y")) as date_range, b.adm_name', false);
        $this->db->join($this->pref . 'admin b', 'b.adm_id=a.creator_id');
        if (!$rule['a']) {
            $this->db->where('spv_id', $this->session->userdata('id'));
        }
        $this->db->from($this->table . ' a');
        $i = 0;
        if (isset($_POST['adv_search'])) {
            $this->adv_search_builder($_POST['adv_search']);
        }
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

    public function get_load_result($rule)
    {
        $this->load_campaign($rule);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered($rule)
    {
        $this->load_campaign($rule);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($rule)
    {
        if (isset($_POST['adv_search'])) {
            $this->adv_search_builder($_POST['adv_search']);
        }
        $this->db->join($this->pref . 'admin b', 'b.adm_id=a.creator_id');
        if (!$rule['a']) {
            $this->db->where('spv_id', $this->session->userdata('id'));
        }
        $this->db->from($this->table . ' a');
        return $this->db->count_all_results();
    }

    private function adv_search_builder($adv_search)
    {
        foreach ($adv_search as $key => $value) {
            if (!empty($value)) {
                $this->db->where($key, $value);
            }
        }
    }

    public function find_by_id($id)
    {
        $this->db->where('campaign_id', $id);
        $query = $this->db->get($this->table, 1);
        return $query->row();
    }

    public function detail_id($id)
    {
        $this->db->select('a.outbound_type,a.campaign_id, a.campaign_name, concat(DATE_FORMAT(a.start_date,"%d %M %Y")," - ",DATE_FORMAT(a.end_date,"%d %M %Y")) as date_range, concat(TIME_FORMAT(a.stime_perday, "%h:%i %p")," - ", TIME_FORMAT(a.etime_perday, "%h:%i %p")) as schedule_per_day, retries, target_per_month, b.adm_name as created_by, c.adm_name as supervisi, a.date_create as created_at, a.script, a.sms_script, a.form,a.sms_enabled, a.wa_enabled,a.status', false);
        $this->db->join($this->pref . 'admin b', 'b.adm_id=a.creator_id');
        $this->db->join($this->pref . 'admin c', 'c.adm_id=a.spv_id', 'left');
        //$this->db->join('ivr_template c', 'c.id=a.ivr_template');
        $this->db->where('a.campaign_id', $id);
        $query = $this->db->get($this->table . ' a', 1);
        return $query->row();
    }

    public function is_sms_enabled($id)
    {
        $this->db->select('sms_enabled');
        $this->db->where('campaign_id', $id);
        $query = $this->db->get($this->table);
        return $query->row()->sms_enabled;
    }

    public function is_wa_enabled($id)
    {
        $this->db->select('wa_enabled');
        $this->db->where('campaign_id', $id);
        $query = $this->db->get($this->table);
        return $query->row()->wa_enabled;
    }

    public function get_form($id)
    {
        $this->db->select('form');
        $this->db->where('campaign_id', $id);
        $query = $this->db->get($this->table);
        return $query->row()->form;
    }

    public function ivr_template()
    {
        $this->db->select('id,ivr_name');
        $query = $this->db->get('ivr_template');
        return $query->result();
    }

    public function find_name($id)
    {
        $this->db->select('campaign_id,creator_id,campaign_name');
        $this->db->where_in($this->column_order[0], $id);
        $query = $this->db->get($this->table . ' a');
        return $query->result();
    }

    public function insert()
    {
        $date_range = explode('-', $_POST['date_range']);
        $sdate = date('Y-m-d', strtotime(trim($date_range[0])));
        $edate = date('Y-m-d', strtotime(trim($date_range[1])));
        $data = array(
            'campaign_name' => $_POST['campaign_name'],
            'start_date' => $sdate,
            'end_date' => $edate,
            'stime_perday' => date('H:i:s', strtotime($_POST['stime_perday'])),
            'etime_perday' => date('H:i:s', strtotime($_POST['etime_perday'])),
            'retries' => $_POST['retries'],
            'spv_id' => isset($_POST['spv_id']) ? $_POST['spv_id'] : $this->session->userdata('id'),
            'creator_id' => $this->session->userdata('id'),
            //'queue_id'  =>  $_POST['queue'],
            'outbound_type'  =>  $_POST['outbound_type'],
            'date_create' => date('Y-m-d H:i:s'),
            'script' => $_POST['script'],
            'target_per_month' => preg_replace('/[^0-9]/', '', empty($_POST['target_per_month']) ? 0 : $_POST['target_per_month']),
            //'ivr_template'  =>  $_POST['ivr_template'],
            'sms_enabled'    => (isset($_POST['sms_enabled'])) ? $_POST['sms_enabled'] : 0,
            'sms_script'    => (isset($_POST['sms_script'])) ? $_POST['sms_script'] : '',
            'wa_enabled'    => (isset($_POST['wa_enabled'])) ? $_POST['wa_enabled'] : 0,
            'status'    => (isset($_POST['status'])) ? $_POST['status'] : 0,
            'form' => $_POST['form'],
        );
        //echo json_encode($data);
        if ($this->db->insert($this->table, $data)) {
            $id = $this->db->insert_id();
            $tbl_camp = 'CREATE TABLE IF NOT EXISTS data_campaign_' . $id;
            $column = array();
            $index = array();
            $column[] = 'data_id INT(11) NOT NULL AUTO_INCREMENT';
            $column_call = array();
            $index[] = 'ADD KEY assign_id(assign_id)';
            $index[] = 'ADD KEY call_status(call_status)';
            $index[] = 'ADD KEY status(status)';
            //$index[] = 'ADD KEY data_status(data_status)';
            foreach ($_POST['el'] as $key => $v) {
                $type = '';
                switch ($v['type']) {
                    case 'text':
                        if (isset($v['call'])) {
                            $v['max'] = empty($v['max']) ? '50' : $v['max'];
                            $index[] = 'ADD KEY f' . $v['name'] . '(form_' . $v['name'] . ')';
                        }
                        $type = ' VARCHAR(' . (!empty($v['max']) ? $v['max'] : '255') . ')';
                        break;
                    case 'email':
                        if (isset($v['call'])) {
                            $v['max'] = empty($v['max']) ? '50' : $v['max'];
                        }
                        $type = ' VARCHAR(' . (!empty($v['max']) ? $v['max'] : '255') . ')';
                        break;
                    case 'number':
                        if (isset($v['call'])) {
                            $v['max'] = empty($v['max']) ? '50' : $v['max'];
                        }
                        $type = ' VARCHAR(' . (!empty($v['max']) ? $v['max'] : '255') . ')';
                        break;
                    case 'amount':
                        $type = ' DOUBLE';
                        break;
                    case 'password':
                        $type = ' VARCHAR(' . (!empty($v['max']) ? $v['max'] : '255') . ')';
                        break;
                    case 'textarea':
                        $type = ' TEXT';
                        break;
                    case 'date':
                        $type = ' DATE';
                        break;
                    case 'datetime':
                        $type = ' DATETIME';
                        break;
                    case 'time':
                        $type = ' TIME';
                        break;
                    case 'dropdown':
                        $type = ' ENUM(\'' . implode('\',\'', $v['option']) . '\')';
                        break;
                    case 'radio':
                        $type = ' ENUM(\'' . implode('\',\'', $v['option']) . '\')';
                        break;
                    case 'checkbox':
                        $type = ' TEXT';
                        break;

                    default:
                        # code...
                        break;
                }
                $column[] = 'form_' . $v['name'] . $type . (isset($v['required']) ? ' NOT NULL' : ' DEFAULT ' .
                    (!empty($v['default']) ? '\'' . $v['default'] . '\'' : 'NULL'));
                $column_call[] = 'form_' . $v['name'] . $type . (isset($v['required']) ? ' NOT NULL' : ' DEFAULT ' .
                    (!empty($v['default']) ? '\'' . $v['default'] . '\'' : 'NULL'));
            }
            if($_POST['outbound_type'] =='predictive'){
                $column[] = 'id_call_outgoing INT(10) NOT NULL';
                $index[] = 'ADD KEY id_call_outgoing(id_call_outgoing)';
                $column_call[] = 'id_call_outgoing INT(10) NOT NULL';
            }
            $column[] = 'assign_id int(11) NOT NULL';
            $column[] = 'assign_date date NULL';
            $column[] = 'retries int(11) NOT NULL';
            $column[] = 'call_status VARCHAR(50) NULL COMMENT \'status of call\'';
            $column[] = 'status VARCHAR(50) NULL COMMENT \'status of data\'';
            if (isset($_POST['wa_enabled']) && $_POST['wa_enabled'] == 1) {
                $column[] = 'status_wa VARCHAR(25) NULL COMMENT \'status of wa\'';
                $column[] = 'wa_api_id int(11) NULL COMMENT \'wa_api_id\'';
                $index[] = 'ADD KEY wa_api_id(wa_api_id)';
            }
            //$column[] = 'data_status VARCHAR(25) NULL COMMENT \'last status of merchant\'';
            $column[] = 'note text NOT NULL COMMENT \'last note of call from agent\'';
            $column_call[] = 'note text NOT NULL COMMENT \'last note of call from agent\'';
            //$sms_column = '';
            if (isset($_POST['sms_enabled'])) {
                if ($_POST['sms_enabled'] == 1) {
                    $column[] = 'sms_phone VARCHAR(20) NULL COMMENT \'sms receiver\'';
                    $column[] = 'sms_text text NULL COMMENT \'sms text\'';
                    $column[] = 'sms_send int(1) NOT NULL COMMENT \'sms flag\'';
                    $column[] = 'sms_send_status text NULL COMMENT \'sms status from api\'';
                }
            }

            //build sql for creating table data_campaign
            $tbl_camp .= '(' . implode(', ', $column) . ', `callback` datetime DEFAULT NULL,`ptp_date` datetime DEFAULT NULL,`ptp_amount` DOUBLE NOT NULL, PRIMARY KEY (data_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;';
            /*$tbl_camp .= '('.implode(', ',$column).', `follow_up` datetime DEFAULT NULL, PRIMARY KEY (data_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;';*/
            //add sql for altering table indexing
            $alt_camp = 'ALTER TABLE data_campaign_' . $id . ' ' . implode(', ', $index) . ', ADD KEY `callback` (`callback`), ADD KEY `ptp_date` (`ptp_date`),ADD KEY `ptp_amount` (`ptp_amount`), ADD KEY assign_date(`assign_date`), ADD KEY retries(`retries`);';

            //build sql for creating table call_attemp
            $tbl_attemp = "CREATE TABLE `call_attemp_$id` (`attemp_id` int(11) NOT NULL AUTO_INCREMENT,`data_id` int(11) NOT NULL,`call_id` VARCHAR(50) NOT NULL,`agent_id` int(11) NOT NULL COMMENT 'caller', assign_date date NULL, retries int(11) NOT NULL,`attemp_date` datetime NOT NULL,`api_status` varchar(50) NOT NULL COMMENT 'status from api',`call_status` varchar(50) NOT NULL COMMENT 'status of call',`status` varchar(50) NOT NULL COMMENT 'status of data',`duration` TIME NOT NULL,`reason` text NOT NULL," . implode(', ', $column_call) . ", `callback` datetime DEFAULT NULL,`ptp_date` datetime DEFAULT NULL,`ptp_amount` DOUBLE NOT NULL,`recordingfile` varchar(255) NOT NULL COMMENT 'recordingfile from call', PRIMARY KEY(`attemp_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
            /*$tbl_attemp = "CREATE TABLE `call_attemp_$id` (
                          `attemp_id` int(11) NOT NULL AUTO_INCREMENT,
                          `data_id` int(11) NOT NULL,
                          `call_id` VARCHAR(50) NOT NULL,
                          `agent_id` int(11) NOT NULL COMMENT 'caller',
                          `attemp_date` datetime NOT NULL,
                          `api_status` varchar(50) NOT NULL COMMENT 'status from api',
                          `call_status` varchar(50) NOT NULL COMMENT 'status of call',
                          `contact_status` varchar(50) NOT NULL COMMENT 'status of contact status',
                          `uncontact_status` varchar(50) NOT NULL COMMENT 'status of uncontact status',
                          `status` varchar(50) NOT NULL COMMENT 'status of data',
                          `duration` TIME NOT NULL,
                          `reason` text NOT NULL, ".implode(', ',$column_call).",
                          `callback` datetime DEFAULT NULL,
                          `follow_up` datetime DEFAULT NULL,
                          `recordingfile` varchar(255) NOT NULL COMMENT 'recordingfile from call',
                          PRIMARY KEY(`attemp_id`)
                        ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;";*/
            //add sql for altering table indexing
            $alt_attemp = "ALTER TABLE `call_attemp_$id` ADD KEY `data_id` (`data_id`),ADD KEY `call_id` (`call_id`),ADD KEY `api_status`(`api_status`), ADD KEY `call_status`(`call_status`), ADD KEY `status`(`status`), ADD KEY `retries` (`retries`), ADD KEY `agent_id` (`agent_id`), ADD KEY `callback` (`callback`), ADD KEY `ptp_date` (`ptp_date`),ADD KEY `ptp_amount` (`ptp_amount`);";
            $tbl_error = array();
            try {
                if ($this->db->query($tbl_camp)) {
                    if ($this->db->query($alt_camp)) {
                        if ($this->db->query($tbl_attemp)) {
                            if (!$this->db->query($alt_attemp)) {
                                $tbl_error = array('data_campaign_' . $id, 'call_attemp_' . $id);
                                throw new Exception("Failed altering table call attemp");
                            } else {

                                if ($_POST['outbound_type'] === 'predictive') {
                                    $this->db->insert("call_center.campaign_external_url",array('urltemplate'=>'telmark/console/external_url/'.$id.'?phone={__PHONE__}&callid={__CALL_ID__}&campid={__CAMPAIGN_ID__}&calltype={__CALL_TYPE__}&agentnum={__AGENT_NUMBER__}', 'description'=>'External url for '.$_POST['campaign_name'].' campaign', 'active' => 1, 'opentype'=>'iframe'));

                                    $url_id = $this->db->insert_id();
                                    $the_queue = '';
                                    //$my_session = $this->session->userdata('id');
                                    //if ($my_session == 14) {
                                    //    $the_queue = 906;
                                    //} else {
                                        $the_queue = 905;
                                    //}
                                    
                                    $this->db->insert("call_center.campaign",array('name'=>$_POST['campaign_name'], 'datetime_init'=>$sdate, 'datetime_end'=>$edate, 'daytime_init'=>date('H:i:s', strtotime($_POST['stime_perday'])), 'daytime_end'=>date('H:i:s', strtotime($_POST['etime_perday'])), 'retries'=>$_POST['retries'], 'trunk'=>'SIP/tr-quiros2', 'context'=>'from-internal', 'queue'=>$the_queue, 'script'=>$_POST['script'], 'estatus'=>(isset($_POST['status'])?'A':'I'), 'id_url'=>$url_id));
                                    $cc_id = $this->db->insert_id();

                                    $this->db->query("UPDATE `telmark`.`v_campaign` SET call_center_campaign = $cc_id WHERE campaign_id = $id");
                                }

                                if (isset($_POST['wa_enabled']) && $_POST['wa_enabled'] == 1) {
                                    $wa_query = "CREATE TABLE `whatsapp_chat_$id` (`wa_id` int(11) NOT NULL AUTO_INCREMENT, `id` VARCHAR(150) NOT NULL, `parent_id` int(11) NOT NULL, `data_id` int(11) NOT NULL, `wa_number` VARCHAR(18) NOT NULL, `wa_name` VARCHAR(150) NOT NULL, `agent_id` int(11) NOT NULL, `wa_text` TEXT NOT NULL, `wa_images` TEXT NULL, `chat_time` DATETIME, `status` VARCHAR(50) NOT NULL, `is_reply` int(1) DEFAULT '0', PRIMARY KEY (`wa_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;";
                                    if ($this->db->query($wa_query)) {
                                        $this->db->query("ALTER TABLE `whatsapp_chat_$id` ADD KEY `id`(`id`),ADD KEY `parent_id`(`parent_id`), ADD KEY `data_id`(`data_id`), ADD KEY `wa_number`(`wa_number`), ADD KEY `agent_id`(`agent_id`), ADD KEY `status`(`status`), ADD KEY `is_reply`(`is_reply`);");
                                    }
                                }
                            }
                        } else {
                            $tbl_error = array('data_campaign_' . $id);
                            throw new Exception("Failed create table call attemp");
                        }
                    } else {
                        $tbl_error = array('data_campaign_' . $id);
                        throw new Exception("Failed altering table data campaign");
                    }
                } else {
                    throw new Exception("Failed create table data campaign");
                }
                return $id;
            } catch (Exception $e) {
                foreach ($tbl_error as $tbl) {
                    $this->db->query('DROP TABLE IF EXISTS ' . $tbl);
                }
                $this->db->where('campaign_id', $id)->delete($this->table);
                return false;
            }
        } else {
            return false;
        }
        //return $this->db->insert($this->table, $_POST);
    }

    public function update($id)
    {
        $date_range = explode('-', $_POST['date_range']);
        $sdate = date('Y-m-d', strtotime(trim($date_range[0])));
        $edate = date('Y-m-d', strtotime(trim($date_range[1])));
        $data = array(
            'campaign_name' => $_POST['campaign_name'],
            'start_date' => $sdate,
            'end_date' => $edate,
            'stime_perday' => date('H:i:s', strtotime($_POST['stime_perday'])),
            'etime_perday' => date('H:i:s', strtotime($_POST['etime_perday'])),
            'retries' => $_POST['retries'],
            'creator_id' => $this->session->userdata('id'),
            //'queue_id'  =>  $_POST['queue'],
            'outbound_type'  =>  $_POST['outbound_type'],
            'date_create' => date('Y-m-d H:i:s'),
            'script' => $_POST['script'],
            'target_per_month' => preg_replace('/[^0-9]/', '', empty($_POST['target_per_month']) ? 0 : $_POST['target_per_month']),
            'sms_enabled'    => (isset($_POST['sms_enabled'])) ? $_POST['sms_enabled'] : 0,
            'sms_script'    => (isset($_POST['sms_script'])) ? $_POST['sms_script'] : '',
            'wa_enabled'    => (isset($_POST['wa_enabled'])) ? $_POST['wa_enabled'] : 0,
            //'ivr_template'  =>  $_POST['ivr_template'],
            'status'    => (isset($_POST['status'])) ? $_POST['status'] : 0,
        );
        $sms_enabled = $this->is_sms_enabled($id);
        $wa_enabled = $this->is_wa_enabled($id);
        if (isset($_POST['sms_enabled']) && ($_POST['sms_enabled'] == 1 && $sms_enabled == 0)) {
            $alt_camp = 'ALTER TABLE data_campaign_' . $id . ' ADD COLUMN sms_phone VARCHAR(20);';
            $this->db->query($alt_camp);
            $alt_camp = 'ALTER TABLE data_campaign_' . $id . ' ADD COLUMN sms_text TEXT;';
            $this->db->query($alt_camp);
            $alt_camp = 'ALTER TABLE data_campaign_' . $id . ' ADD COLUMN sms_send INT(1);';
            $this->db->query($alt_camp);
            $alt_camp = 'ALTER TABLE data_campaign_' . $id . ' ADD COLUMN sms_send_status TEXT;';
        } else if (!isset($_POST['sms_enabled']) && $sms_enabled == 1) {
            $alt_camp = 'ALTER TABLE data_campaign_' . $id . ' DROP COLUMN sms_phone;';
            $this->db->query($alt_camp);
            $alt_camp = 'ALTER TABLE data_campaign_' . $id . ' DROP COLUMN sms_text;';
            $this->db->query($alt_camp);
            $alt_camp = 'ALTER TABLE data_campaign_' . $id . ' DROP COLUMN sms_send;';
            $this->db->query($alt_camp);
            $alt_camp = 'ALTER TABLE data_campaign_' . $id . ' DROP COLUMN sms_send_status;';
            $this->db->query($alt_camp);
        }
        if (isset($_POST['wa_enabled']) && ($_POST['wa_enabled'] == 1 && $wa_enabled == 0)) {
            $wa_query = "CREATE TABLE `whatsapp_chat_$id` (`wa_id` int(11) NOT NULL AUTO_INCREMENT, `id` VARCHAR(150) NOT NULL, `parent_id` int(11) NOT NULL, `data_id` int(11) NOT NULL, `wa_number` VARCHAR(18) NOT NULL, `wa_name` VARCHAR(150) NOT NULL, `agent_id` int(11) NOT NULL, `wa_text` TEXT NOT NULL, `wa_images` TEXT NULL, `chat_time` DATETIME, `status` VARCHAR(50) NOT NULL, `is_reply` int(1) DEFAULT '0', PRIMARY KEY (`wa_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;";
            if ($this->db->query($wa_query)) {
                $this->db->query("ALTER TABLE `whatsapp_chat_$id` ADD KEY `id`(`id`), ADD KEY `parent_id`(`parent_id`), ADD KEY `data_id`(`data_id`), ADD KEY `wa_number`(`wa_number`), ADD KEY `agent_id`(`agent_id`), ADD KEY `status`(`status`), ADD KEY `is_reply`(`is_reply`);");
            }
            $this->db->query('ALTER TABLE data_campaign_' . $id . ' ADD COLUMN status_wa VARCHAR(25) NULL');
            $this->db->query('ALTER TABLE data_campaign_' . $id . ' ADD COLUMN wa_api_id INT(11);');
            $this->db->query('ALTER TABLE data_campaign_' . $id . ' ADD KEY wa_api_id(wa_api_id);');
        } else if (!isset($_POST['wa_enabled']) && $wa_enabled == 1) {
            $this->db->query("DROP TABLE IF EXISTS `whatsapp_chat_$id`");
            $alt_camp = 'ALTER TABLE data_campaign_' . $id . ' DROP COLUMN status_wa;';
            $this->db->query($alt_camp);
            $this->db->query('ALTER TABLE data_campaign_' . $id . ' DROP COLUMN wa_api_id;');
        }

        $cmp = $this->db->where('campaign_id', $id)->get($this->table,1)->row();

        if($cmp->outbound_type != 'predictive' && $_POST['outbound_type']=='predictive') {
            $this->db->insert("call_center.campaign_external_url",array('urltemplate'=>'telmark/console/external_url/'.$id.'?phone={__PHONE__}&callid={__CALL_ID__}&campid={__CAMPAIGN_ID__}&calltype={__CALL_TYPE__}&agentnum={__AGENT_NUMBER__}', 'description'=>'External url for '.$_POST['campaign_name'].' campaign', 'active' => 1, 'opentype'=>'iframe'));

            $url_id = $this->db->insert_id();

            $the_queue = 905;
            if (!$this->db->field_exists('id_call_outgoing', 'data_campaign_'.$id)) {
                $this->db->query('ALTER TABLE data_campaign_' . $id . ' ADD COLUMN id_call_outgoing INT(11);');
                $this->db->query('ALTER TABLE data_campaign_' . $id . ' ADD KEY id_call_outgoing(id_call_outgoing);');
            }

            $this->db->insert("call_center.campaign",array('name'=>$_POST['campaign_name'], 'datetime_init'=>$sdate, 'datetime_end'=>$edate, 'daytime_init'=>date('H:i:s', strtotime($_POST['stime_perday'])), 'daytime_end'=>date('H:i:s', strtotime($_POST['etime_perday'])), 'retries'=>$_POST['retries'], 'trunk'=>'SIP/tr-quiros2', 'context'=>'from-internal', 'queue'=>$the_queue, 'script'=>$_POST['script'], 'estatus'=>(isset($_POST['status'])?'A':'I'), 'id_url'=>$url_id));
                
            $data['call_center_campaign'] = $this->db->insert_id();

        } else if($cmp->outbound_type == 'predictive' && $_POST['outbound_type']=='predictive') {
            $this->db->where('id', $cmp->call_center_campaign)->update('call_center.campaign', array('name'=>$_POST['campaign_name'], 'datetime_init'=>$sdate, 'datetime_end'=>$edate, 'daytime_init'=>date('H:i:s', strtotime($_POST['stime_perday'])), 'daytime_end'=>date('H:i:s', strtotime($_POST['etime_perday'])), 'retries'=>$_POST['retries'], 'script'=>$_POST['script'], 'estatus'=>(isset($_POST['status'])?'A':'I')));
        } else if($cmp->outbound_type == 'predictive' && $_POST['outbound_type']!='predictive') {

            $this->db->where('id', $cmp->call_center_campaign)->update('call_center.campaign', array('estatus'=>'I'));
        }

        //echo json_encode($data);
        $this->db->where('campaign_id', $id);
        return $this->db->update($this->table, $data);
    }

    public function is_table_exist($id)
    {
        if (!$this->db->table_exists('data_campaign_' . $id)) {
            $this->db->where('campaign_id', $id)->delete($this->table);
            return false;
        } else {
            return true;
        }
    }

    public function delete()
    {
        try {
            foreach ($_POST['c_id'] as $id) {
                $this->db->query('DROP TABLE IF EXISTS call_attemp_' . $id);
                $this->db->query('DROP TABLE IF EXISTS data_campaign_' . $id);
            }
        } catch (Exception $e) {
        }
        $this->db->where_in('campaign_id', $_POST['c_id']);
        return $this->db->delete($this->table);
    }

    public function get_spv()
    {
        $this->db->select('adm_id, adm_name');
        $this->db->where('grp_id', 3);
        return $this->db->get($this->pref . 'admin')->result();
    }

    public function get_timezone()
    {
        return $this->db->get($this->pref . 'timezone')->result();
    }
    public function get_currencies()
    {
        $this->db->select('cur_id, cur_name');
        return $this->db->get($this->pref . 'currencies')->result();
    }
    public function get_callplan()
    {
        $this->db->select('cal_id, cal_name');
        return $this->db->get($this->pref . 'callplan')->result();
    }
    public function get_campaign_creator()
    {
        $this->db->select('adm_id, adm_name');
        $this->db->where('grp_id', 3);
        $query = $this->db->get('v_admin');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
}
