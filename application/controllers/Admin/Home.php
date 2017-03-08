<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        get_admin_data();
        $this->load->model('admin/admin_home_model');
        $this->load->model('News_model');
    }

    public function index() {
        $data['title'] = 'Dashboard';
        $data['total_active_news'] = count($this->News_model->check_news_exist('active', 1));
        $data['total_blocked_news'] = count($this->News_model->check_news_exist('active', 0));
        $this->template->load('admin', 'admin/home/index', $data);
    }

    /**
     * change_password function
     * @uses change password
     * @author KAP
     **/
    public function change_password() {
        $this->load->model('admin/admin_users_model');
        $data = array();
        $data['title'] = 'Change Password';
        $data['heading'] = 'Change Password';
        $this->form_validation->set_rules('new_password', 'Password', 'trim|required|min_length[5]|max_length[15]|matches[confirm_password]', 
                array('required' => 'Please enter Password',
                  'min_length' => 'Password should be of minimum 5 chars',
                  'max_length'=>'Password should be of maximum 15 chars',
                  'matches' =>'Password should be match with Confirm Password'
                )
            );
        $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required',
                 array('required' => 'Please enter Confirm Password')
            );
         if ($this->form_validation->run() == TRUE) {
            if(isset($_POST['new_password'])) {
                $user = $this->session->userdata('admin');
                $up_data = array('password' => md5($_POST['new_password']));
                $this->admin_users_model->update_record('user','id ='.$user['id'], $up_data);
                $this->session->set_flashdata('success', 'Password successfully updated!');
            }
            else {
                $this->session->set_flashdata('warning', 'Password not changed!');
            }
         }
        $this->template->load('admin', 'admin/user/change_password', $data);   
    }

    /**
     * load_dashboard_graphs function
     * get graphs data
     * @return JSON
     * @author KAP
     **/
    function load_dashboard_graphs_users(){
        $users_records = $this->admin_home_model->get_dashboard_graph_data('users');
        echo json_encode($users_records);
    }

    /**
     * load_dashboard_graphs function
     * get graphs data
     * @return JSON
     * @author KAP
     **/
    function load_dashboard_graphs_spots(){
        $users_records = $this->admin_home_model->get_dashboard_graph_data('spots');
        echo json_encode($users_records);
    }
}
