<?php

class Config_model extends CI_Model {

    private $pref = '';
    var $table = 'config';


    function __construct()
        {
                parent::__construct();
                $this->load->database();
                $this->pref = $this->config->item('tb_pref');
                $this->table = $this->pref.$this->table;
        }

    public function get_config($value){
        return $this->db->where('conf_string', $value)->get($this->table, 1)->row()->conf_value;
    }
    public function set_value($config, $value){
        return $this->db->where('conf_string', $config)->update($this->table, array('conf_value'=>$value));
    }
    public function get_config_in_group($group_id){
        return $this->db->where('conf_group', $group_id)->get($this->table)->result();
        /*print_r($this->db->where('conf_group', $group_id)->get($this->table)->result());
        exit;*/
    }

}