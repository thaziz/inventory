<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends MX_Controller {

	/**
	 * 
	 */

	public function __construct(){
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'administrator');
		if(!isset($this->menu['rule']['panel/admin/group'])){
			show_404();
		}
		$this->load->model('admin/admin_model');
		$this->load->model('admin/group_model');
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
	}

	public function index(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/admin/group']['v']);
		if($_POST && $auth){
			$list = $this->group_model->get_load_result();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $group) {
	            $no++;
	            $row = array();
	            $row[] = $group->grp_id;
	            $row[] = $group->grp_name;
	            $row[] = $group->grp_description;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->group_model->count_all(),
	                        "recordsFiltered" => $this->group_model->count_filtered(),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			$data['rules'] = $this->menu['rule']['panel/admin/group'];
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS ADMIN GROUP MENU');
			$this->template->view('view_group', $data);
		}
	}

	public function group_insert(){
		$this->load->helper(array('form', 'url', 'countries'));

		$auth = $this->template->set_auth($this->menu['rule']['panel/admin/group']['c']);
		if($_POST && $auth){
            $this->form_validation->set_rules('grp_name', 'Group Name', 'required|min_length[3]|is_unique[v_role.grp_name]');
            if ($this->form_validation->run() == false)
            {
            	$data['status'] = false;
            	$data['e']['grp_name'] = form_error('grp_name', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else{
            	$menu = isset($_POST['menu'])?$_POST['menu']:array();
            	$smenu = isset($_POST['smenu'])?$_POST['smenu']:array();
            	unset($_POST['menu']);
            	unset($_POST['smenu']);
            	if($this->group_model->insert()){
            		$grp_id = $this->db->insert_id();
            		$rule = array();
            		foreach ($menu as $key => $value) {
            			if(isset($value['rules'])){
            				$r = implode('-', $value['rules']);
            			}
            			$rule[] = array('group_id'=>$grp_id,
            						'menu_id'=>$key,
            						'rule'=>$r);
            		}
            		foreach ($smenu as $key => $sub) {
            			$rule[] = array('group_id'=>$grp_id,'menu_id'=>$key, 'rule'=>'');
            			foreach ($sub as $key => $value) {
	            			if(isset($value['rules'])){
	            				$r = implode('-', $value['rules']);
	            			}
	            			$rule[] = array('group_id'=>$grp_id,
	            						'menu_id'=>$key,
	            						'rule'=>$r);
	            		}
            		}
            		if($this->group_model->insert_rule($rule)){
						$this->userlog->add_log($this->session->userdata['name'], 
						'INSERT  ADMIN GROUP WITH ID: '.$this->db->insert_id(). ' NAME: '.$_POST['grp_name']);
            			echo json_encode(array('status'=>true));
            		}
            	}
            	
            }
		}else{
			$data['menu_rule'] = $this->menu_model->get_menu_rule('admin');
			$data['menu'] = $this->menu;
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS INSERT ADMIN GROUP MENU');
			$this->template->view('view_group_insert', $data);
		}
	}

	public function group_detail($id){
		$data['menu'] = $this->menu;
		if($this->template->set_auth($this->menu['rule']['panel/admin/group']['v'])){
			$data['data'] = $this->admin_model->find_by_id($id);
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS VIEW ADMIN GROUP ID:'
				.$id.' NAME: '.$data['data']->grp_name);
		}
		$this->template->view('view_admin_detail', $data);
	}

	public function group_edit($id){
		$this->load->helper(array('form', 'url', 'countries'));

		$auth = $this->template->set_auth($this->menu['rule']['panel/admin/group']['e']);
		if($_POST && $auth){

			/* if name has changed from old, then check is_unique otherwise not*/
			$check_unique = ($_POST['grp_name'] != $_POST['grp_name_old'])?'|is_unique[v_role.grp_name]':'';
            $this->form_validation->set_rules('grp_name', 'Group Name', 'required|min_length[3]'.$check_unique);

            $old = $_POST['grp_name_old'];
            /* unset grp_name_old from $_POST to preventing from database insert*/
            unset($_POST['grp_name_old']);

            if ($this->form_validation->run() == false)
            {
            	$data['status'] = false;
            	$data['e']['grp_name'] = form_error('grp_name', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else{
            	$menu = isset($_POST['menu'])?$_POST['menu']:array();
            	$smenu = isset($_POST['smenu'])?$_POST['smenu']:array();
            	unset($_POST['menu']);
            	unset($_POST['smenu']);
            	$grp_id = $_POST['grp_id'];
            	if($this->group_model->update($grp_id)){
            		$rule = array();
            		foreach ($menu as $key => $value) {
            			if(isset($value['rules'])){
            				$r = implode('-', $value['rules']);
            			}
            			$rule[] = array('group_id'=>$grp_id,
            						'menu_id'=>$key,
            						'rule'=>$r);
            		}
            		foreach ($smenu as $key => $sub) {
            			$rule[] = array('group_id'=>$grp_id,'menu_id'=>$key, 'rule'=>'');
            			foreach ($sub as $key => $value) {
	            			if(isset($value['rules'])){
	            				$r = implode('-', $value['rules']);
	            			}
	            			$rule[] = array('group_id'=>$grp_id,
	            						'menu_id'=>$key,
	            						'rule'=>$r);
	            		}
            		}
            		if($this->group_model->update_rule($grp_id, $rule)){
						$this->userlog->add_log($this->session->userdata['name'], 
						'EDIT ADMIN GROUP ID: '.$id.' NAME: '.$old.' TO NAME: '.$_POST['grp_name']);
            			echo json_encode(array('status'=>true));
            		}else{
            			echo json_encode(array('status'=>false));
            		}
            	}
            }
		}else{
			$data['data'] = $this->group_model->find_by_id($id);
			$data['rule'] = $this->group_model->get_rule($id);
			$data['group'] = $this->group_model->get_list();
			$data['menu_rule'] = $this->menu_model->get_menu_rule('admin');
			$data['menu'] = $this->menu;
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS EDIT ADMIN GROUP ID: '.$id.' NAME: '.$data['data']->grp_name);
			$this->template->view('view_group_edit', $data);
		}
	}

	public function group_delete(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/admin/group']['d']);
		if($auth){
			$info = $this->group_model->get_name($_POST['grp_id']);
			$info = preg_replace('/\[|\]/i', '', json_encode($info));
			if($this->group_model->delete()){
				$this->userlog->add_log($this->session->userdata['name'], 'DELETE ADMIN GROUP '.$info);
				$data['status'] = true;
			}else{
				$data['status'] = false;
			}
			print_r(json_encode($data));
		}
	}

}
