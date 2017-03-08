<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Header_footer_control extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/admin_header_footer_model');
    }

    /**
     * @method : index function
     * @uses : Load view of pages list
     * @author : KAP
     **/
    public function index() {
        $data['title'] = 'AkhbarUAE - Admin control';
        $this->template->load('admin','admin/control/index', $data);
    }

    /**
     * @method : get_header_footer function
     * @uses : Load header and footer links based on page load
     * @author : KAP
     **/
    public function get_header_footer() {
        if($this->input->post('type') == 'header'){
            $result = $this->admin_header_footer_model->get_result_header_footer(TBL_PAGES,'show_in_header = 1 AND parent_id = 0 AND active = 1','id, navigation_name','header_position');
        } else {
            $result = $this->admin_header_footer_model->get_result_header_footer(TBL_PAGES.' p','show_in_footer = 1 AND active = 1','id, navigation_name, (SELECT count(*) FROM '.TBL_PAGES.' WHERE parent_id = p.id) AS is_parent','footer_position');
        }
        echo json_encode($result);
    }

    /**
     * @method : list_pages function
     * @uses : this function is used to get result based on datatable in page list page
     * @author : KAP
     **/
    public function list_pages() {
        $start = $this->input->get('start');
        $final['recordsTotal'] = $this->admin_header_footer_model->rows_of_table(TBL_PAGES);
        $keyword = $this->input->get('search');
        $select = 'p.id, @a:=@a+1 AS test_id, p.navigation_name, p.title, p.active, p.created AS created_date, p.show_in_footer, p.show_in_header, p1.navigation_name AS parent_name, (SELECT count(*) FROM '.TBL_PAGES.' WHERE parent_id = p.id) AS is_parent';
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->admin_header_footer_model->get_pages_result(TBL_PAGES.' p,'.'(SELECT @a:= '.$start.') AS a',$select,'result');
        echo json_encode($final);
    }

    /**
     * @method : change_data_status function
     * @uses : this function is used to changes status based on show in header and footer
     * @author : KAP
     **/
    public function change_data_status() {
        $condition = ' id = '.$this->input->post('id');
        $user_array = array($this->input->post('type') => $this->input->post('value'));
        $this->admin_header_footer_model->update_record(TBL_PAGES, $condition, $user_array);
        echo 'success';
        exit;
    }

    /**
     * @method : save_arrangement function
     * @uses : this function is used to store arrangement of header and footer
     * @author : KAP
     **/
    public function save_arrangement() {
        $data = array();
        if($this->input->post('type') == 'header'){
            $column = 'header_position';
        } else {
            $column = 'footer_position';
        }   
        foreach ($this->input->post('data') as $key => $value) {
            $data[$key][$column] = $key + 1;
            $data[$key]['id'] = $value; 
        }
        $this->admin_header_footer_model->update_multiple(TBL_PAGES,$data,'id');
        echo 'success';
        exit;
    }
}
