<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletters extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/admin_newsletters_model');
    }

    /**
     * @method : index function
     * @uses : Load view of newsletters list
     * @author : KAP
     **/
    public function index() {
        $data['title'] = 'Spotashoot - Admin newsletters';
        $this->template->load('admin','admin/newsletters/index', $data);
    }

    /**
     * @method : list_user function
     * @uses : this function is used to get result based on datatable in newsletters list page
     * @author : KAP
     **/
    public function list_newsletters() {
        $start = $this->input->get('start');
        $select = 'n.id, n.title, n.created_date, @a:=@a+1 AS test_id, ns.is_auto, ns.id AS setting_id, ns.content, IF(tn.email_ids IS NULL,0,1) AS allow_testing';
        $final['recordsTotal'] = $this->admin_newsletters_model->get_users_result(TBL_NEWSLETTERS.' n',$select,'count');
        $keyword = $this->input->get('search');
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->admin_newsletters_model->get_users_result(TBL_NEWSLETTERS.' n,'.'(SELECT @a:= '.$start.') AS a',$select,'result');
        echo json_encode($final);
    }

    /**
     * @method : action function
     * @uses : this function is used to performing action on newsletter
     * @author : KAP
     **/
    public function action($action, $newsletter_id) {
        $where = 'id = '.$this->db->escape($newsletter_id);
        $check_newsletter = $this->admin_newsletters_model->get_result(TBL_NEWSLETTERS,$where);
        if($check_newsletter){
            if($action == 'delete'){
                $val = 1;
                $this->session->set_flashdata('success', 'Newsletter successfully deleted!');
            }
            $update_array = array(
                'is_delete' => $val
            );
            $this->admin_newsletters_model->update_record(TBL_NEWSLETTERS,$where,$update_array);
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect(site_url('admin/newsletters'));
    }

    /**
     * @method : edit function
     * @uses : Load view of add/edit user
     * @author : KAP
     **/
    public function edit() {
        $newsletter_id = $this->uri->segment(4);
        if(is_numeric($newsletter_id)){
            $where = 'id = '.$this->db->escape($newsletter_id);
            $check_newsletter = $this->admin_newsletters_model->get_result(TBL_NEWSLETTERS,$where);
            if($check_newsletter){
                $data['newsletter_data'] = $check_newsletter[0];
                $data['title'] = 'Spotashoot - Admin edit newsletter';
                $data['heading'] = 'Edit newsletter';
            } else {
                show_404();
            }
        } else {
            $data['heading'] = 'Add newsletter';
            $data['title'] = 'Spotashoot - Admin add newsletter';
        }
        $this->form_validation->set_rules('title', 'title', 'trim|required|callback_checktitle');
        if ($this->form_validation->run() == FALSE) {
            $this->form_validation->set_error_delimiters('<div class="alert alert-error alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
        } else {
            if(is_numeric($newsletter_id)){
                $update_array = $this->input->post(null);
                $this->admin_newsletters_model->update_record(TBL_NEWSLETTERS,$where,$update_array);
                $this->session->set_flashdata('success', 'Newsletter successfully updated!');
            } else {
                $insert_array = $this->input->post(null);
                $this->admin_newsletters_model->insert(TBL_NEWSLETTERS,$insert_array);
                $this->session->set_flashdata('success', 'Newsletter successfully added!');
            }
            redirect('admin/newsletters');
        }
        $this->template->load('admin','admin/newsletters/manage', $data);
    }

    /**
     * checktitle function
     * check newsletter is already exist or not
     * @return void
     * @author KAP
     **/
    public function checktitle($str){
        $newsletter_id = $this->uri->segment(4);
        if(is_numeric($newsletter_id)){
            $where = 'title = '.$this->db->escape($str).' AND id !='.$newsletter_id.' AND is_delete = 0';
        } else {
            $where = 'title = '.$this->db->escape($str).' AND is_delete = 0';
        }
        $check_newsletter = $this->admin_newsletters_model->get_result(TBL_NEWSLETTERS,$where);
        if($check_newsletter){
            if ($check_newsletter){
                $this->form_validation->set_message('checktitle', 'Newsletter already exist!');
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    /**
     * @method : change_data_status function
     * @uses : this function is used to changes status based on add to auto and remove from auto
     * @author : KAP
     **/
    public function change_data_status() {
        $condition = ' id = '.$this->input->post('id');
        $user_array = array('is_auto' => $this->input->post('value'));
        $this->admin_newsletters_model->update_record(TBL_NEWSLETTERS, $condition, $user_array);
        echo 'success';
        exit;
    }

    /**
     * settings function
     * load setting page of newsletter
     * @author : KAP
     **/
    public function settings($newsletter_id){
        if($newsletter_id == ''){
            $newsletter_id = $this->input->post('newsletter_id_post');
        }
        $where = 'id = '.$this->db->escape($newsletter_id);
        $check_newsletter = $this->admin_newsletters_model->get_result(TBL_NEWSLETTERS,$where);
        if($check_newsletter){
            $data['heading'] = 'Newsletter settings';

            $data['title'] = 'Spotashoot - Admin newsletter Settings';
            $data['newsletter_id'] = $newsletter_id;
            $check_newsletter_setting = $this->admin_newsletters_model->get_result(TBL_NEWSLETTER_SETTINGS,'newsletter_id ='.$newsletter_id);
            if($check_newsletter_setting){
                $data['newsletter_settings'] = $check_newsletter_setting[0];
            }
            $this->form_validation->set_rules('newsletter_content', 'newsletter content', 'trim|required|min_length[100]|callback_checktitle',array('min_length' => 'Newsletter content is to short or empty.'));
            if($this->input->post('is_auto')){
                $this->form_validation->set_rules('number_of_spots', 'Number of spots', 'integer|trim|required|greater_than[0]',array('integer' => 'Invalid number of spots.'));
            }
            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters('<div class="alert alert-error alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            } else {

                $country_id = $this->input->post('country_id');
                $number_of_spots = $this->input->post('number_of_spots');
                $array = array(
                    'content' => $_POST['newsletter_content'],
                    'country_id' => $country_id,
                    'no_of_latest_spots' => $number_of_spots
                );
                if($this->input->post('duration')){
                    $array['duration'] = $this->input->post('duration');
                }
                if($this->input->post('is_auto')){
                    $array['is_auto'] = 1;
                } else {
                    $array['is_auto'] = 0;
                }

                if($check_newsletter_setting){
                    $condition = ' newsletter_id = '.$newsletter_id;
                    $this->admin_newsletters_model->update_record(TBL_NEWSLETTER_SETTINGS, $condition, $array);
                } else {
                    $array['newsletter_id'] = $newsletter_id;
                    $this->admin_newsletters_model->insert(TBL_NEWSLETTER_SETTINGS,$array);
                }

                $check_testing_emails =  $this->admin_newsletters_model->get_result(TBL_NEWSLETTERS_TEST_EMAILS,'newsletter_id ='.$newsletter_id);
                $testing_emails_array = array(
                    'email_ids' => $this->input->post('testing_emails')
                );
                if($check_testing_emails){
                    $condition = ' newsletter_id = '.$newsletter_id;
                    $testing_emails_array['modified_date'] = 'NOW()';
                    $this->admin_newsletters_model->update_record(TBL_NEWSLETTERS_TEST_EMAILS, $condition, $testing_emails_array);
                } else {
                    $testing_emails_array['newsletter_id'] = $newsletter_id;
                    $this->admin_newsletters_model->insert(TBL_NEWSLETTERS_TEST_EMAILS,$testing_emails_array);
                }

                $this->session->set_flashdata('success', 'Newsletter settings successfully added!');
                redirect('admin/newsletters');
            }

            $data['countries'] = $this->admin_newsletters_model->get_rgistered_users_countries();
            $data['testing_emails'] = $this->admin_newsletters_model->get_newsletter_testing_emails($newsletter_id);
            $this->template->load('admin','admin/newsletters/manage_settings', $data);
        }
    }

    /**
     * send function
     * load view for send newsletter to users.
     * @return void
     * @author 
     **/
    public function send($type, $newsletter_id){
        $where = 'id = '.$this->db->escape($newsletter_id);
        $check_newsletter = $this->admin_newsletters_model->get_result(TBL_NEWSLETTERS,$where);
        if($check_newsletter){
            $data['newsletter_id'] = $newsletter_id;
            $data['type'] = $type;
            $this->load->view('admin/newsletters/send_newsletter',$data);
        }
    }

    /**
     * send_newsletter function
     * send newsletter to users, this function will call during page load.
     * @return boolean TRUE if success else FALSE.
     * @author KAP
     **/
    public function send_newsletter(){
        $newsletter_id = $this->input->post('newsletter_id');
        $type = $this->input->post('type');
        $newsletter_data = $this->admin_newsletters_model->get_result(TBL_NEWSLETTER_SETTINGS,'newsletter_id ='.$newsletter_id);

        $users = array();
        if($type == 'testing'){
            $testing_emails = $this->admin_newsletters_model->get_result(TBL_NEWSLETTERS_TEST_EMAILS,'newsletter_id ='.$newsletter_id);
            $testing_emails = explode(',',$testing_emails[0]['email_ids']);
            foreach ($testing_emails as $key => $value) {
                $users[] = array(
                    'email_id' => $value
                );
            }           
        } else {
            $users = $this->admin_newsletters_model->get_users_for_newsletter($newsletter_id, $newsletter_data[0]['country_id']);
            // $users[] = array(
            //     'email_id' => 'kap@narola.email'
            // );
            // $users[] = array(
            //     'email_id' => 'kap@narola.email'
            // );
        }
        $from = 'info@spotashoot.com';
        $subject = 'Spotashoot - Newsletter';
        $body = $newsletter_data[0]['content'];
        @send_newsletter($users, $from, $subject, $body);
        echo 'success';
        exit;
    }
}