<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
        /*$this->load->model('Wallboard_model');*/
        $this->load->library('form_validation');

        $this->menu = $this->menu_model->load_menu('admin', 'wallboard');
        if(!isset($this->menu['rule']['panel/wallboard'])){
            show_404();
        }
	}
	/**
	 * Index Page for this controller.
	 *
	 */
	public function index($id)
	{
		echo $id;
		exit;
		$auth = $this->template->set_auth($this->menu['rule']['panel/wallboard']['v']);
        if($_POST && $auth){
            /*$list = $this->Wallboard_model->load_data();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $ivr) {
                $no++;
                $row = array();
                $row[] = $ivr->id;
                $row[] = $no;
                $row[] = $ivr->ivr_name;
                $row[] = $ivr->ivr_template;
                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->Wallboard_model->count_all(),
                            "recordsFiltered" => $this->Wallboard_model->count_filtered(),
                            "data" => $data,
                    );
            echo json_encode($output);*/
        }else{
            /*$data['menu'] = $this->menu;
            $data['rules'] = $this->menu['rule']['panel/wallboard'];
    				$data['title'] = 'IVR';*/
            /*write_userlog(current_url(), 'ACCESS MENU IVR');*/
    		$this->template->view('wallboard');
        }
	}

    public function add(){
        $auth = $this->template->set_auth($this->menu['rule']['panel/wallboard']['c']);
        if($_POST && $auth){
            $this->form_validation->set_rules('ivr_name', 'IVR Name', 'required');
            $this->form_validation->set_rules('ivr_template', 'IVR Template', 'required');
            if ($this->form_validation->run() == false){
                $data['status'] = false;
                $data['e']['ivr_name'] = form_error('ivr_name', '<div class="has-error">', '</div>');
                $data['e']['ivr_template'] = form_error('ivr_template', '<div class="has-error">', '</div>');
                echo json_encode($data);
            }else{
                /*unset($_POST['password_retype']);*/
                if($this->Wallboard_model->insert()){
                    /*write_userlog(current_url(), 'ADD NEW IVR DATA: '.json_encode($_POST));*/
                    echo json_encode(array('status'=>true));
                }else{
                    echo json_encode(array('status'=>false));
                }
            }
        }else{
            $data['menu']   =   $this->menu;
            $data['decision']   =   'add';
            /*write_userlog(current_url(), 'ACCESS MENU ADD IVR');*/
            $this->template->view('ivr_form', $data);
        }
    }

    public function edit($id){
        $auth = $this->template->set_auth($this->menu['rule']['panel/wallboard']['e']);
        if($_POST && $auth)
        {
            /*if($this->Wallboard_model->validate_code($_POST['ivr_code'],$id) > 0){
                $this->form_validation->set_rules('ivr_code', 'ivregory Code', 'required|is_unique[ttm_ticket_ivregory.ivr_code]');
            }*/
            $this->form_validation->set_rules('ivr_name', 'IVR Name', 'required');
            $this->form_validation->set_rules('ivr_template', 'IVR Template', 'required');
            if($this->form_validation->run() == false)
            {
                $data['status'] = false;
                /*if($this->Wallboard_model->validate_code($_POST['ivr_code'],$id) > 0){
                $data['e']['ivr_code'] = form_error('ivr_code', '<div class="has-error">', '</div>');
                }*/
                $data['e']['ivr_name'] = form_error('ivr_name', '<div class="has-error">', '</div>');
                $data['e']['ivr_template'] = form_error('ivr_template', '<div class="has-error">', '</div>');
                echo json_encode($data);
            }
            else
            {
                /*$old   =   $this->Wallboard_model->find_by_id($id);*/
                if($this->Wallboard_model->update($id))
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
            $data['data']   =   $this->Wallboard_model->find_by_id($id);
            $data['decision']   =   'edit';
            /*write_userlog(current_url(), 'ACCESS MENU EDIT IVR CODE: <b>'.$data['data']->ivr_code.'</b>');*/
            $this->template->view('ivr_form', $data);
        }
    }

    public function detail($id){
        $auth = $this->template->set_auth($this->menu['rule']['panel/wallboard']['v']);
        if($auth){
            $data = array(
                'title' => 'ivr',
                'sub_title' => 'Detail ivr',
            );
            $data['menu'] = $this->menu;
            $data['data'] = $this->Wallboard_model->find_by_id($id);
            $data['rules'] = $this->menu['rule']['panel/wallboard'];
            /*write_userlog(current_url(), 'ACCESS DETAIL IVR CODE: <b>'.$data['data']->ivr_code.'</b>');*/
            $this->template->view('ivr_detail', $data);
        }

    }

    public function delete(){
        $auth = $this->template->set_auth($this->menu['rule']['panel/wallboard']['d']);
        if($_POST && $auth){
            /*$codes = $this->Wallboard_model->get_codes();*/
            if($this->Wallboard_model->delete()){
                /*write_userlog(current_url(), 'DELETE IVR '.implod(', ', $codes));*/
                echo json_encode(array('status'=>true));
            }else{
                echo json_encode(array('status'=>false));
            }
        }
    }


}
