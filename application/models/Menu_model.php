<?php

class Menu_model extends CI_Model {

	private $pref = '';
	private $table = 'v_menu';

	function __construct(){
		parent::__construct();
        $this->load->database();	
        $this->pref = $this->config->item('tb_pref');
        $this->table = $this->pref.$this->table;	
	}

	private function load($type){
		
		//join with it self
		$this->db->join('v_menu b', 'a.menu_id = b.parent_id', 'left');
		//query condition find enabled menu that doesn't have parent
		$this->db->where(['a.type_menu'=>$type, 'a.menu_enable'=>'1', 'a.parent_id'=>0]);
		//query condition find enabled submenu or null
		$this->db->where('(`b`.`menu_enable` = \'1\' OR `b`.`menu_enable` IS NULL)', null, false);
		$this->db->order_by('a.menu_id', 'asc');
		$this->db->order_by('b.menu_id', 'asc');
		return $this->db->get('v_menu a')->result();
	}

	public function load_menu($type, $active){

		$grp_id = $this->session->userdata('grp_id') != null ? $this->session->userdata('grp_id') : 0;

		$query = $this->db->query("SELECT b.id, b.menu_name, b.link_menu, b.sub_id, b.sub_menu, b.sub_menu_link, a.rule FROM v_admin_rule a JOIN (SELECT a.menu_id as id, a.menu_name, a.link_menu, IFNULL(b.menu_id, a.menu_id) as sub_id, b.menu_name as sub_menu, b.link_menu as sub_menu_link, a.menu_order, b.menu_order as sub_order FROM `v_menu` `a` LEFT JOIN `v_menu` b ON a.menu_id = b.parent_id WHERE `a`.`type_menu` = '$type' AND `a`.`menu_enable` = '1' AND `a`.`parent_id` =0 AND (`b`.`menu_enable` = '1' OR `b`.`menu_enable` IS NULL)) b ON a.menu_id = b.sub_id WHERE a.group_id = $grp_id ORDER BY b.menu_order ASC, b.sub_order ASC");

		$result = $query->result();
		//collecting data from query result and convert it to an array
		$data = array();
		$v_rule = array('v','e','d','c', 'a', 'ie', 'im', 'wa');
		foreach ($result as $key => $value) {
			$data['main'][$value->id]['menu_name'] = $value->menu_name;
			$data['main'][$value->id]['link_menu'] = $value->link_menu;
			$data['main'][$value->id]['active_menu'] = 
					strtolower(str_replace('_',' ',$active)) == strtolower($value->menu_name) ? 1:0;

			//creating main menu
			if($value->sub_menu != null){
				$data['main'][$value->id]['sub_menu'][] = array('menu_name'=>$value->sub_menu, 
														'link_menu'=>$value->sub_menu_link);

				//creating sidebar menu
				if($active && strtolower(str_replace('_',' ',$active)) == strtolower($value->menu_name)){
					$data['sidebar'][] = array('menu_name'=>$value->sub_menu, 
										'link_menu'=>$value->sub_menu_link);
				}

				//setting rule
				if($value->rule !=null){
					foreach ($v_rule as $rule) {
						$data['rule'][$value->sub_menu_link][$rule] = strpos($value->rule, $rule)!==false;
					}
				}
			}elseif($value->sub_menu == null && $value->rule !=null){
				foreach ($v_rule as $rule) {
					$data['rule'][$value->link_menu][$rule] = strpos($value->rule, $rule)!==false;
				}
			}

		}
		return $data;
	}

	public function get_rules($type){

		$grp_id = $this->session->userdata('grp_id') != null ? $this->session->userdata('grp_id') : 0;

		$query = $this->db->query("SELECT b.id, b.menu_name, b.link_menu, b.sub_id, b.sub_menu, b.sub_menu_link, a.rule FROM v_admin_rule a JOIN (SELECT a.menu_id as id, a.menu_name, a.link_menu, IFNULL(b.menu_id, a.menu_id) as sub_id, b.menu_name as sub_menu, b.link_menu as sub_menu_link FROM `v_menu` `a` LEFT JOIN `v_menu` b ON a.menu_id = b.parent_id WHERE `a`.`type_menu` = '$type' AND `a`.`menu_enable` = '1' AND `a`.`parent_id` =0 AND (`b`.`menu_enable` = '1' OR `b`.`menu_enable` IS NULL)) b ON a.menu_id = b.sub_id WHERE a.group_id = $grp_id ORDER BY `b`.`id` ASC, `b`.`sub_id` ASC");

		$result = $query->result();
		//collecting data from query result and convert it to an array
		$data = array();
		foreach ($result as $key => $value) {
			//creating main menu
			if($value->sub_menu != null && $value->rule !=null){
				$data[$value->sub_menu_link] = strpos($value->rule, 'v')!==false;
			}elseif($value->sub_menu == null && $value->rule !=null){
				$data[$value->link_menu] = strpos($value->rule, 'v')!==false;
			}
		}
		return $data;
	}

	public function get_menu_rule($type){

		//define select database field
		$this->db->select('a.menu_id as id, a.menu_name, a.link_menu, a.rule_menu, b.menu_id as sub_id,
			b.menu_name as sub_menu, b.link_menu as sub_menu_link, b.rule_menu as sub_rule');
		
		$result = $this->load($type);
		//collecting data from query result and convert it to an array
		$data = array();
		foreach ($result as $key => $value) {
			$data[$value->id]['menu_name'] = $value->menu_name;
			$data[$value->id]['rule_menu'] = $value->rule_menu;

			//creating main menu
			if($value->sub_menu != null){
				$data[$value->id]['sub_menu'][$value->sub_id] = array('menu_name'=>$value->sub_menu, 
														'link_menu'=>$value->sub_menu_link,
														'rule_menu'=>$value->sub_rule);
			}

		}
		return $data;
	}
}