<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/admin_users_model');
    }

    /**
     * @method : index function
     * @uses : Load view of users list
     * @author : KAP
     **/
    public function index() {
        $data['title'] = 'Spotashoot - Admin users';
        $this->template->load('admin','admin/users/index', $data);
    }

    /**
     * @method : list_user function
     * @uses : this function is used to get result based on datatable in user list page
     * @author : KAP
     **/
    public function list_user() {
        $start = $this->input->get('start');
        $select = 'u.id, u.first_name, u.last_name, u.email_id, u.username,DATE_FORMAT(u.registered_date,"%d %b %Y <br> %l:%i %p") AS created_date, IF(u.facebook_id IS NULL,IF(u.instagram_id IS NULL,IF(u.user_role = \'admin\',\'Admin\',\'Normal\'),\'Instagram\'),\'Facebook\') AS type, u.status, u.is_delete, (SELECT count(*) FROM '.TBL_SPOTS.' WHERE user_id = u.id AND spot_status = 1) AS cnt_total, CONCAT_WS(\',\',c.name,s.name,cu.name) AS location, c.name, cu.name, s.name, u.is_feature, @a:=@a+1 AS test_id';
        $final['recordsTotal'] = $this->admin_users_model->get_users_result(TBL_USER.' u',$select,'count');
        $keyword = $this->input->get('search');
        $final['redraw'] = 1;
        // $final['recordsFiltered'] = $this->admin_users_model->get_users_result(TBL_USER,$select,'count');
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->admin_users_model->get_users_result(TBL_USER.' u,'.'(SELECT @a:= '.$start.') AS a',$select,'result');
        echo json_encode($final);
    }

    /**
     * @method : block function
     * @uses : this function is used to block user
     * @author : KAP
     **/
    public function action($action, $user_id) {
        
        $where = 'id = '.$this->db->escape($user_id);
        $check_user = $this->admin_users_model->get_result(TBL_USER,$where);
        if($check_user){
            if($action == 'delete'){
                $val = 1;
                $this->session->set_flashdata('success', 'User successfully deleted!');
            }
            elseif ($action == 'block') {
                $val = 2;   
                $this->session->set_flashdata('success', 'User successfully blocked!');
            }
            else {
                $val = 0;   
                $this->session->set_flashdata('success', 'User successfully activated!');
            }
            $update_array = array(
                'is_delete' => $val
            );
            $this->admin_users_model->update_record(TBL_USER,$where,$update_array);
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect(site_url('admin/users'));
    }

    /**
     * @method : index function
     * @uses : Load view of users list
     * @author : KAP
     **/
    public function edit() {
        $user_id = $this->uri->segment(4);
        if(is_numeric($user_id)){
            $where = 'id = '.$this->db->escape($user_id);
            $check_user = $this->admin_users_model->get_result(TBL_USER,$where);
            if($check_user){
                $data['user_data'] = $check_user[0];
                $data['states'] = $this->admin_users_model->get_result(TBL_STATES);
                $data['cities'] = $this->admin_users_model->get_result(TBL_CITIES);
                $data['title'] = 'Spotashoot - Admin edit user';
                $data['heading'] = 'Edit user';
            } else {
                show_404();
            }
        } else {
            $data['heading'] = 'Add user';
            $data['title'] = 'Spotashoot - Admin Add user';
            $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[5]|matches[confirm_password]');
            $this->form_validation->set_rules('confirm_password', 'confirm password', 'trim|required');
            $this->form_validation->set_rules('email_id', 'email id', 'trim|required|valid_email|is_unique['.TBL_USER.'.email_id]');
            $this->form_validation->set_rules('username', 'username', 'trim|required|min_length[5]|max_length[15]|is_unique['.TBL_USER.'.username]');
        }
        $data['countries'] = $this->admin_users_model->get_result(TBL_COUNTRIES);
        $this->form_validation->set_rules('first_name', 'first name', 'trim|required|regex_match[/[a-z]+$/i]',array('regex_match' => 'Invalid %s! Only alphabets allowed!'));
        $this->form_validation->set_rules('last_name', 'username', 'trim|required|regex_match[/[a-z]+$/i]',array('regex_match' => 'Invalid %s! Only alphabets allowed!',));
        $this->form_validation->set_rules('country_id', 'country', 'trim|required');
        // $this->form_validation->set_rules('state_id', 'state', 'trim|required');
        // $this->form_validation->set_rules('city_id', 'city', 'trim|required');
        $this->form_validation->set_rules('street', 'street', 'trim');
        $this->form_validation->set_rules('house_number', 'house number', 'trim');
        $this->form_validation->set_rules('zipcode', 'zipcode', 'trim');
        $this->form_validation->set_rules('date_of_birth', 'date of birth', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->form_validation->set_error_delimiters('<div class="alert alert-error alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
        } else {
            if(is_numeric($user_id)){
                $update_array = $this->input->post(null);
                $this->admin_users_model->update_record(TBL_USER,$where,$update_array);
                $this->session->set_flashdata('success', 'User successfully updated!');
            } else {
                $insert_array = $this->input->post(null);
                $insert_array['is_delete'] = 0;
                $insert_array['status'] = 'active';
                // $insert_array['user_role'] = 'user';
                $insert_array['password'] = md5($this->input->post('password'));
                unset($insert_array['confirm_password']);
                $this->admin_users_model->insert(TBL_USER,$insert_array);
                $user_id = $this->db->insert_id();

                // //--- call for add to mailchimp
                // if($this->add_to_mailchimp($this->input->post('email_id'), 'subscribed', $this->input->post('first_name'), $this->input->post('last_name')) == TRUE ){
                //     $insert_data = array(
                //             'email_id' => $this->input->post('email_id'),
                //             'first_name' => $this->input->post('first_name'),
                //             'last_name' => $this->input->post('last_name'),
                //             'user_id' => $this->db->insert_id()
                //         );
                //     $this->admin_users_model->insert(TBL_MAILCHIMP_SUBSCRIBERS, $insert_data);
                // }
                
                $where_country = 'id = '.$this->input->post('country_id');
                $country_result = $this->admin_users_model->get_result(TBL_COUNTRIES, $where_country);
                $country_name = $country_result[0]['name']; 
                if($country_name == ''){
                    $country_name = 'Other';
                }
                mailchimp($this->input->post('email_id'), 'subscribed', $this->input->post('first_name'), $this->input->post('last_name'), $country_name, $user_id);
                $this->session->set_flashdata('success', 'User successfully added!');

            }
            redirect('admin/users');
        }
        $this->template->load('admin','admin/users/manage', $data);
    }

    /**
     * get_states function
     * @uses this function in used to get states from the selected country
     * @return JSON data of states result
     * @author KAP
     **/
    public function get_states() {
        $country_id = $this->input->post('country_id');
        $where = 'country_id = '.$this->db->escape($country_id);
        echo json_encode($this->admin_users_model->get_result('states',$where));
    }

    /**
     * get_cities function
     * @uses this function in used to get cities from the selected state
     * @return JSON data of cities result
     * @author KAP
     **/
    public function get_cities() {
        $state_id = $this->input->post('state_id');
        $where = 'state_id = '.$this->db->escape($state_id);
        echo json_encode($this->admin_users_model->get_result('cities',$where));
    }

    /**
     * add_to_mailchimp function
     * used to add members in mail chimp account
     * @return void
     * @author KAP
     **/
    public function add_to_mailchimp($email, $status, $first_name, $last_name) {
        $data = [
            'email'     => $email,
            'status'    => $status,
            'firstname' => $first_name,
            'lastname'  => $last_name
        ];
        $apiKey = 'bd8d3cbd2d6cd7967f6f97bca0311585-us14';
        $listId = 'e7b59ad040';
        $memberId = md5(strtolower($data['email']));
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;
        $json = json_encode([
            'email_address' => $data['email'],
            'status'        => $data['status'], // "subscribed","unsubscribed","cleaned","pending"
            'merge_fields'  => [
                'FNAME'     => $data['firstname'],
                'LNAME'     => $data['lastname']
            ]
        ]);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $arr = json_decode($result, true);
        if(isset($arr['id'])){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @method : spots function
     * @uses : Load view of users spots
     * @author : KAP
     **/
    public function spots($user_id) {
        $where = 'id = '.$this->db->escape($user_id);
        $check_user = $this->admin_users_model->get_result(TBL_USER,$where);
        if($check_user){
            $data['title'] = 'Spotashoot - Admin active spots';
            $data['user_data'] = $check_user[0];
            $this->template->load('admin','admin/users/spots', $data);
        } else {
            show_404();
        }
    }

    /**
     * @method : list_spots function
     * @uses : this function is used to get result based on datatable in active spots list page
     * @author : KAP
     **/
    public function list_spots($user_id) {
        $final['recordsTotal'] = $this->admin_users_model->rows_of_table(TBL_SPOTS,'spot_status = 1 AND user_id ='.$user_id);
        $keyword = $this->input->get('search');
        $select = 'id, @a:=@a+1 AS test_id, title, CONCAT(SUBSTRING_INDEX(description, \' \', 6),\'...\') AS description, address, location, contact_number, email_id, price, spot_status, is_delete, created_date, slug';
        $final['redraw'] = 1;
        // $final['recordsFiltered'] = $this->admin_spots_model->get_spots_result(TBL_SPOTS,$select,'count');
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->admin_users_model->get_spots_result(TBL_SPOTS.','.'(SELECT @a:= 0) AS a',$select,'result',$user_id);
        echo json_encode($final);
    }

    /**
     * @method : change_data_status function
     * @uses : this function is used to changes status based on add to feature and remove from feature
     * @author : KAP
     **/
    public function change_data_status() {
        $condition = ' id = '.$this->input->post('id');
        $check_user = $this->admin_users_model->get_result(TBL_USER, $condition);
        if($check_user){
            $val = $this->input->post('value');
            $user_array = array('is_feature' => $val);
            $this->admin_users_model->update_record(TBL_USER, $condition, $user_array);
            if($val == 1){
                $mail_data = array(
                    'heading' => 'Congratulations ! Your profile has been featured',
                    'message' => 'Congratulations ! Your profile has been featured on spotashoot.com,<br> 
    Thank you for being active with sharing new explore opportunities with the community and as an appreciation your profile will be featured on the website for the next two weeks!<br>
    Keep spotting.'
                );
                $msg = $this->load->view('email_templates/only_content',$mail_data,true);
                send_mail_front($user_email,'info@spotashoot.com','Congratulations ! Your profile has been featured',$msg);
            }
            echo 'success';
        }
        exit;
    }

    /**
     * @method : change_password function
     * @uses : this function is used to change password of user
     * @author : KAP
     **/
    public function change_password() {
        $user_id = $this->uri->segment(4);
        $where = 'id = '.$this->db->escape($user_id);
        $check_user = $this->admin_users_model->get_result(TBL_USER,$where);
        if($check_user) {
            $data['heading'] = 'Add user';
            $data['title'] = 'Spotashoot - Admin Add user';
            $data['userdata'] = $check_user[0];

            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[15]|matches[confirm_password]', 
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
                $up_data = array('password' => md5($this->input->post('password')));
                $this->admin_users_model->update_record(TBL_USER, 'id = '.$user_id, $up_data);
                $this->session->set_flashdata('success', 'Password successfully updated!');
                redirect('admin/users');
            }
            $this->template->load('admin','admin/users/change_password', $data);
        }
    }
}
	