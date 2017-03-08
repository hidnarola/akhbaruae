<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('News_model');
        $this->data = get_admin_data();
    }

    public function index() {
        $this->data['title'] = $this->data['page_header'] = 'AkhbarUAE - News';
        $this->data['news_list_html'] = $this->load->view('Admin/News/news_list_block', NULL, true);
        $this->template->load('admin', 'admin/News/news_list', $this->data);
    }

    public function filter_news() {
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $post_search = $this->input->post('search');
        $post_order = $this->input->post('order');
        $filter_array = array(
            'search' => $post_search['value'],
            'order' => $post_order,
            'is_admin' => 1
        );
        $list = $this->News_model->filter_news($filter_array, 0, $start / $length, $length);

        $data = array();
        $no = $start;
        foreach ($list as $news) {
            $no++;
            $row = array(
                'sr_no' => $no,
                'id' => $news['id'],
                'title' => $news['title'],
                'image' => $news['image'],
                'published' => $news['published'],
                'crawled' => $news['crawled'],
                'active' => $news['active'],
                'encode_id' => base64_encode($news['id'])
            );
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => count($this->News_model->get_all_news()),
            "recordsFiltered" => $this->News_model->filter_news($filter_array, 1),
            "data" => $data,
        );

        echo json_encode($output);
    }
    
    public function add($news_id) {
        $news_exist = $this->News_model->check_news_exist('id', $news_id);
        if(count($news_exist) > 0){
            $news_array = array(
                'active' => 1
            );
            if($this->News_model->update_news($news_array, $news_id)){
                $this->session->set_flashdata('success', 'News successfully added!');
            } else {
                $this->session->set_flashdata('error', 'There is some issue to add news. Please try again!');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect(site_url('admin/news'));
    }
    
    public function remove($news_id) {
        $news_exist = $this->News_model->check_news_exist('id', $news_id);
        if(count($news_exist) > 0){
            $news_array = array(
                'active' => 0
            );
            if($this->News_model->update_news($news_array, $news_id)){
                $this->session->set_flashdata('success', 'News successfully removed!');
            } else {
                $this->session->set_flashdata('error', 'There is some issue to remove news. Please try again!');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect(site_url('admin/news'));
    }
}
