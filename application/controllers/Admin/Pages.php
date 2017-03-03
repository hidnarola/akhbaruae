<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        get_admin_data();
        $this->load->model('admin/admin_pages_model');
    }

    /**
     * @method : index function
     * @uses : Load view of pages list
     * @author : KAP
     **/
    public function index() {
        $data['title'] = 'Spotashoot - Admin pages';
        $this->template->load('admin','admin/pages/index', $data);
    }

     /**
     * @method : list_pages function
     * @uses : this function is used to get result based on datatable in page list page
     * @author : KAP
     **/
    public function list_pages() {
        $select = 'id, @a:=@a+1 AS test_id, navigation_name, title, active, created AS created_date';
        $final['recordsTotal'] = $this->admin_pages_model->get_pages_result('pages',$select,'count');
        $keyword = $this->input->get('search');
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->admin_pages_model->get_pages_result('pages'.','.'(SELECT @a:= 0) AS a',$select,'result');
        echo json_encode($final);
    }

    /**
     * @method : edit function
     * @uses : Load view of pages list
     * @author : KAP
     **/
    public function edit($id = '') {
        if($id != ''){
            $data['title'] = 'Spotashoot - Admin edit page';
            $data['heading'] = 'Edit page';
            $result = $this->admin_pages_model->get_result('pages',' id = '.$id);
            if(isset($result)){
                $data['page_data'] = $result[0];
            } else {
                show_404();
            }
        } else {
            $data['title'] = 'Spotashoot - Admin add page';
            $data['heading'] = 'Add page';
        }
        $data['pages'] = $this->admin_pages_model->get_result('pages','parent_id = 0');
        $this->form_validation->set_rules('navigation_name', 'navigation name', 'trim|required');
        $this->form_validation->set_rules('title', 'title', 'trim|required');
        $this->form_validation->set_rules('description', 'description', 'trim|required');
        $this->form_validation->set_rules('meta_title', 'SEO meta title', 'trim|required');
        $this->form_validation->set_rules('meta_keyword', 'SEO meta keyword', 'trim|required');
        $this->form_validation->set_rules('meta_description', 'SEO meta description', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->form_validation->set_error_delimiters('<div class="alert alert-error alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
        } else {
            $update_array = $this->input->post(null);
            if(!empty($_FILES['banner_image']['name'])){
                $image_name = upload_image('banner_image',PAGE_BANNER);
                $update_array['banner_image'] = $image_name;
            }
            if(!isset($data['error'])){
                if($id != ''){
                    if($data['page_data']['banner_image'] != '' && isset($update_array['banner_image'])){
                        unlink(PAGE_BANNER.'/'.$data['page_data']['banner_image']);
                    }
                    $update_array['url'] = slug_page($update_array['navigation_name'],'pages',$id);
                    $update_array['modified'] = date('Y-m-d H:i:s');
                    $update_array['description'] = $_POST['description'];
                    $this->session->set_flashdata('success', 'Page successfully updated!');
                    $this->admin_pages_model->update_record('pages', 'id = '.$id,$update_array);
                    $this->admin_pages_model->update_record('pages', 'id = '.$update_array['parent_id'],array('footer_position' => 0));
                } else {
                    $update_array['url'] = slug_page($update_array['navigation_name'],'pages');
                    $update_array['description'] = $_POST['description'];
                    $this->session->set_flashdata('success', 'Page successfully added!');
                    $this->admin_pages_model->insert('pages', $update_array);
                    $this->admin_pages_model->update_record('pages', 'id = '.$update_array['parent_id'],array('footer_position' => 0));
                }
                redirect(site_url('admin/pages'));
            }
        }
        $this->template->load('admin','admin/pages/manage', $data);
    }

    /**
     * @method : action function
     * @uses : this function is used to apply action of page
     * @author : KAP
     **/
    public function action($action, $user_id) {
        
        $where = 'id = '.$this->db->escape($user_id);
        $check_page = $this->admin_pages_model->get_result('pages',$where);
        if($check_page){
            if($action == 'delete'){
                $val = 0;
                $this->session->set_flashdata('success', 'Page successfully deleted!');
            }
            else {
                $val = 1;   
                $this->session->set_flashdata('success', 'Page successfully activated!');
            }
            $update_array = array(
                'active' => $val
            );
            $this->admin_pages_model->update_record('pages',$where,$update_array);
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect(site_url('admin/pages'));
    }
}