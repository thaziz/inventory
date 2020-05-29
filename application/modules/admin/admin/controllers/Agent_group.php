<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agent_group extends CI_Controller {

	public function __construct(){
		parent::__construct();
        $this->load->model('agroup_model');
        $this->load->library('form_validation');

        $this->menu = $this->menu_model->load_menu('admin', 'administrator');
        if(!isset($this->menu['rule']['panel/admin/agent_group'])){
            show_404();
        }
	}
	/**
	 * Index Page for this controller.
	 *
	 */
	public function index()
	{
		$auth = $this->template->set_auth($this->menu['rule']['panel/admin/agent_group']['v']);
        if($_POST && $auth){
            $list = $this->agroup_model->load_data();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $grp) {
                $no++;
                $row = array();
                $row[] = $grp->group_id;
                $row[] = $no;
                $row[] = $grp->group_name;
                $row[] = $grp->description;
                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->agroup_model->count_all(),
                            "recordsFiltered" => $this->agroup_model->count_filtered(),
                            "data" => $data,
                    );
            echo json_encode($output);
        }else{
            $data['menu'] = $this->menu;
            $data['rules'] = $this->menu['rule']['panel/admin/agent_group'];
    		$data['title'] = 'Agent Group';
            /*write_userlog(current_url(), 'ACCESS MENU IVR');*/
    		$this->template->view('view_agroup', $data);
        }
	}

    public function insert(){
        $auth = $this->template->set_auth($this->menu['rule']['panel/admin/agent_group']['c']);
        if($_POST && $auth){
            $this->form_validation->set_rules('group_name', 'Group Name', 'required');
            if ($this->form_validation->run() == false){
                $data['status'] = false;
                $data['e']['group_name'] = form_error('group_name', '<div class="has-error">', '</div>');
                echo json_encode($data);
            }else{
                /*unset($_POST['password_retype']);*/
                if($this->agroup_model->insert()){
                    /*write_userlog(current_url(), 'ADD NEW IVR DATA: '.json_encode($_POST));*/
                    echo json_encode(array('status'=>true));
                }else{
                    echo json_encode(array('status'=>false));
                }
            }
        }else{
            $data['menu']   =   $this->menu;
            $data['decision']   =   'insert';
            /*write_userlog(current_url(), 'ACCESS MENU ADD IVR');*/
            $this->template->view('view_agroup_form', $data);
        }
    }

    public function edit($id){
        $auth = $this->template->set_auth($this->menu['rule']['panel/admin/agent_group']['e']);
        if($_POST && $auth)
        {
            /*if($this->agroup_model->validate_code($_POST['ivr_code'],$id) > 0){
                $this->form_validation->set_rules('ivr_code', 'ivregory Code', 'required|is_unique[ttm_ticket_ivregory.ivr_code]');
            }*/
            $this->form_validation->set_rules('group_name', 'Group Name', 'required');
            if($this->form_validation->run() == false)
            {
                $data['status'] = false;
                /*if($this->agroup_model->validate_code($_POST['ivr_code'],$id) > 0){
                $data['e']['ivr_code'] = form_error('ivr_code', '<div class="has-error">', '</div>');
                }*/
                $data['e']['group_name'] = form_error('group_name', '<div class="has-error">', '</div>');
                echo json_encode($data);
            }
            else
            {
                /*$old   =   $this->agroup_model->find_by_id($id);*/
                if($this->agroup_model->update($id))
                {
                    /*write_userlog(current_url(), 'EDIT IVR FROM '.json_encode($old).' TO: '.json_encode($_POST));*/
                    echo json_encode(array('status'=>true));
                }
                else
                {
                    echo json_encode(array('status'=>false));
                }
            }
        }
        else
        {
            $data['menu']   =   $this->menu;
            $data['data']   =   $this->agroup_model->find_by_id($id);
            $data['decision']   =   'edit';
            /*write_userlog(current_url(), 'ACCESS MENU EDIT IVR CODE: <b>'.$data['data']->ivr_code.'</b>');*/
            $this->template->view('view_agroup_form', $data);
        }
    }

    public function detail($id){
        $auth = $this->template->set_auth($this->menu['rule']['panel/admin/agent_group']['v']);
        if($auth && $_POST){
            $list = $this->agroup_model->load_data_agent($id);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $agent) {
                $no++;
                $row = array();
                $row[] = $agent->adm_id;
                $row[] = $no;
                $row[] = $agent->adm_name;
                $row[] = $agent->adm_ext;
                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->agroup_model->count_all_agent($id),
                            "recordsFiltered" => $this->agroup_model->count_filtered_agent($id),
                            "data" => $data,
                    );
            echo json_encode($output);
        }else{
            $data = array(
                'title' => 'Agent Group',
                'sub_title' => 'Detail Agent Group',
            );
            $data['menu'] = $this->menu;
            $data['group_id'] = $id;
            $data['data'] = $this->agroup_model->detail($id);
            $data['rules'] = $this->menu['rule']['panel/admin/agent_group'];
            $data['in'] = $this->agroup_model->agents_in($id);
            $data['not_in'] = $this->agroup_model->agents_not_in($id);
            /*write_userlog(current_url(), 'ACCESS DETAIL IVR CODE: <b>'.$data['data']->ivr_code.'</b>');*/
            $this->template->view('view_agroup_detail', $data);
        }
        
    }

    public function delete(){
        $auth = $this->template->set_auth($this->menu['rule']['panel/admin/agent_group']['d']);
        if($_POST && $auth){
            /*$codes = $this->agroup_model->get_codes();*/
            if($this->agroup_model->delete()){
                /*write_userlog(current_url(), 'DELETE IVR '.implod(', ', $codes));*/
                echo json_encode(array('status'=>true));
            }else{
                echo json_encode(array('status'=>false));
            }
        }
    }

    public function add_agent($id){
        if(isset($_POST['to'])){
            $data = array();
            foreach ($_POST['to'] as $value) {
                $data[] = array('agent_id'=>$value, 'group_id'=>$id);
            }
            if($this->agroup_model->insert_agents($id, $data)){
                echo json_encode(array('status'=>true));
            }else{
                echo json_encode(array('status' => false, 'msg'=>'Add agent(s) failed, cannot insert to database.'));
            }
        }else{
            echo json_encode(array('status' => false, 'msg'=>'Add agent(s) failed, you don\'t select any data.'));
        }
    }

    public function delete_agent($id){
        if($_POST){
            if($this->agroup_model->delete_agents($id)){
                echo json_encode(array('status'=>true));
            }else{
                echo json_encode(array('status'=>false));
            }
        }
    }


}