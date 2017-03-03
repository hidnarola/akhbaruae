<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/Admin_login_model','admin_login_model');
    }

    public function index() {
        $data = array();
        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_user_validation');
        $this->form_validation->set_rules('password', 'Password', 'trim');
        if ($this->form_validation->run() == FALSE) {
             $data['error'] = validation_errors();   
        } 
        else{
            redirect('admin');                
        }
        $this->load->view('admin/user/login',$data);
    }

    public function user_validation(){    
        $result = $this->admin_login_model->get_user($this->input->post('username'),$this->input->post('password'));
        if($result){
            $this->session->set_userdata('admin',$result);
            return TRUE;
        } else {
            $this->form_validation->set_message('user_validation','Invalid Username / Password.');
            return FALSE;
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        setcookie('admin_user_id', '', -1);
        redirect('admin/login');
    }
}