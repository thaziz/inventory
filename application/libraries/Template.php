<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class Template{
    
    var $ci;

    var $auth;
         
    function __construct(){
        $this->ci =& get_instance();
    }

    function set_auth($value){
        $this->auth = $value;
        return $this->auth;
    }

    function view($template=NULL, $data = NULL) {
        if($template!=NULL)

        //$user_login = $this->ci->session->userdata('user_login');

        /*if($user_login->tipe != 2){
           $data['menu'] = $this->generate_menu($user_login);
        }*/
        if(!$this->auth){
            $data['heading'] = 'Forbidden Access';
            $data['message'] = 'You don\'t have permission to access this page';
            $data['_content'] = $this->ci->load->view('template/error_404', $data, TRUE);
        }else{
            $data['_content'] = $this->ci->load->view($template, $data, TRUE);
        }
        $data['_header'] = $this->ci->load->view('template/header', $data, TRUE);
        $data['_footer'] = $this->ci->load->view('template/footer', $data, TRUE);
        $data['_sidebar'] = $this->ci->load->view('template/sidebar', $data, TRUE);
        $this->ci->load->view('template/template', $data);
    }
}