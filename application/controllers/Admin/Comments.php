<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comments extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('News_model');
        $this->data = get_admin_data();
    }

    public function index($news_id) {
        $this->data['title'] = $this->data['page_header'] = 'AkhbarUAE - Comments';
        $this->data['news_id'] = $news_id;
        $this->data['comments_list_html'] = $this->load->view('Admin/Comments/comments_list_block', $this->data, true);
        $this->template->load('admin', 'admin/Comments/comments_list', $this->data);
    }

    public function filter_comments($news_id) {
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $post_search = $this->input->post('search');
        $post_order = $this->input->post('order');
        $filter_array = array(
            'search' => $post_search['value'],
            'order' => $post_order,
            'news_id' => $news_id,
            'is_admin' => 1
        );
        $comments = $this->News_model->filter_comments($filter_array, 0, $start / $length, $length);

        $data = array();
        $no = $start;
        foreach ($comments as $comment) {
            $no++;
            $row = array(
                'sr_no' => $no,
                'id' => $comment['id'],
                'news_id' => $comment['news_id'],
                'author_name' => $comment['author_name'],
                'author_email' => $comment['author_email'],
                'author_comment' => $comment['author_comment'],
                'active' => $comment['active']
            );
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => count($this->News_model->get_all_comments($news_id)),
            "recordsFiltered" => $this->News_model->filter_comments($filter_array, 1),
            "data" => $data,
        );

        echo json_encode($output);
    }
    
    public function add($comments_id) {
        $comments_exist = $this->News_model->check_comments_exist('id', $comments_id);
        if(count($comments_exist) > 0){
            $comments_array = array(
                'active' => 1
            );
            if($this->News_model->update_comments($comments_array, $comments_id)){
                $this->session->set_flashdata('success', 'Comments successfully added!');
            } else {
                $this->session->set_flashdata('error', 'There is some issue to add comments. Please try again!');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect(site_url('admin/comments/' . $comments_exist[0]['news_id']));
    }
    
    public function remove($comments_id) {
        $comments_exist = $this->News_model->check_comments_exist('id', $comments_id);
        if(count($comments_exist) > 0){
            $comments_array = array(
                'active' => 0
            );
            if($this->News_model->update_comments($comments_array, $comments_id)){
                $this->session->set_flashdata('success', 'Comments successfully removed!');
            } else {
                $this->session->set_flashdata('error', 'There is some issue to remove comments. Please try again!');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        redirect(site_url('admin/comments/' . $comments_exist[0]['news_id']));
    }
}
