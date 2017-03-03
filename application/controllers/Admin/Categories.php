<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/admin_categories_model');
    }

    /**
     * @method : index function
     * @uses : Load view of users list
     * @author : KAP
     **/
    public function index() {
        $data['title'] = 'Spotashoot - Admin Categories';
        $this->template->load('admin','admin/categories/index', $data);
    }

    /**
     * @method : list_user function
     * @uses : this function is used to get result based on datatable in user list page
     * @author : KAP
     **/
    public function list_categpries() {
        $start = $this->input->get('start');
        $select = 'id, @a:=@a+1 AS test_id, name, is_delete, \'status\' AS status';
        $final['recordsTotal'] = $this->admin_categories_model->get_categories_result(TBL_CATEGORIES,$select,'count');
        $keyword = $this->input->get('search');
        $final['redraw'] = 1;
        // $final['recordsFiltered'] = $this->admin_amenities_model->get_amenities_result(TBL_AMENITIES,$select,'count');
        $final['recordsFiltered'] =  $final['recordsTotal'];
        $final['data'] = $this->admin_categories_model->get_categories_result(TBL_CATEGORIES.','.'(SELECT @a:= '.$start.') AS a',$select,'result');
        echo json_encode($final);
    }

    /**
     * @method : block function
     * @uses : this function is used to block user
     * @author : KAP
     **/
    public function action($action, $user_id) {        
        $where = 'id = '.$this->db->escape($user_id);
        $category_data = $this->admin_categories_model->get_result(TBL_CATEGORIES,$where);
        if($category_data){
            if($action == 'delete'){
                $val = 1;
                $this->session->set_flashdata('success', 'Category successfully deleted!');
            } else {
                $val = 0;   
                $this->session->set_flashdata('success', 'Category successfully activated!');
            }
            $update_array = array(
                'is_delete' => $val
            );
            $this->admin_categories_model->update_record(TBL_CATEGORIES,$where,$update_array);
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect(site_url('admin/categories'));
    }

    /**
     * @method : index function
     * @uses : Load view of users list
     * @author : KAP
     **/
    public function edit() {
        $category_id = $this->uri->segment(4);
        if(is_numeric($category_id)){
            $where = 'id = '.$this->db->escape($category_id);
            $category_data = $this->admin_categories_model->get_result(TBL_CATEGORIES,$where);
            if($category_data){
                $data['category_data'] = $category_data[0];
                $data['title'] = 'Spotashoot - Admin edit category';
                $data['heading'] = 'Edit category';
                if(trim($this->input->post('name')) != $category_data[0]['name']){
                    $this->form_validation->set_rules('name', 'name', 'trim|required|is_unique['.TBL_CATEGORIES.'.name]',array('is_unique' => 'Category already exist! Please try with another.'));
                } else {
                    $this->form_validation->set_rules('name', 'name', 'trim|required');
                }
            } else {
                show_404();
            }
        } else {
            $data['heading'] = 'Add category';
            $data['title'] = 'Spotashoot - Admin add category';
            $this->form_validation->set_rules('name', 'name', 'trim|required|is_unique['.TBL_CATEGORIES.'.name]',array('is_unique' => 'Category already exist! Please try with another.'));
        }
        if ($this->form_validation->run() == FALSE) {
            $this->form_validation->set_error_delimiters('<div class="alert alert-error alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
        } else {
            if(is_numeric($category_id)){
                $update_array = $this->input->post(null);
                $update_array['slug'] = slug($update_array['name'],TBL_CATEGORIES,$category_id,'category-1');
                $update_array['modified_date'] = date('Y-m-d H:i:s');
                $this->admin_categories_model->update_record(TBL_CATEGORIES,$where,$update_array,null,'category-1');
                $this->session->set_flashdata('success', 'Category successfully updated!');
            } else {
                $insert_array = $this->input->post(null);
                $insert_array['slug'] = slug($insert_array['name'],TBL_CATEGORIES);
                $this->admin_categories_model->insert(TBL_CATEGORIES,$insert_array);
                $this->session->set_flashdata('success', 'Category successfully added!');
            }
            redirect('admin/categories');
        }
        $this->template->load('admin','admin/categories/manage', $data);
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
}
	