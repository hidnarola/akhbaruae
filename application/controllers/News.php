<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('News_model');
        $this->limit = 10;
    }

    public function index() {
        $filter_array = array();
        $posts['page'] = 1;
        $posts['limit'] = $this->limit;
        $posts['total_news'] = $this->News_model->filter_news($filter_array, 1);
        $posts['posts'] = $this->News_model->filter_news($filter_array, 0, 0, $this->limit);
        if(count($posts['posts']) > 0){
            $news_list_html = $this->load->view('News/list_block', $posts, true);
        } else {
            $news_list_html = $this->load->view('Templates/no_results', array(), true);
        }
        $data['main_post'] = ( count($posts['posts']) > 0) ? $posts['posts'][0] : array();
        $data['news_list_html'] = $news_list_html;
        $this->template->load('default', 'News/list', $data);
    }
    
    public function more_news($page = 0, $limit = '') {
        $filter_array = array();
        $page = (int)$page;
        $start = ($page == 0) ? 0 : (int)($page - 1);
        $limit = ($limit != '') ? (int)$limit : (int)$this->limit;
        if( is_int($start) && $start >= 0 && is_int($limit) && $limit > 0 ){
            $posts['page'] = $page;
            $posts['limit'] = $limit;
            $posts['total_news'] = $this->News_model->filter_news($filter_array, 1);
            $posts['posts'] = $this->News_model->filter_news($filter_array, 0, $start, $limit);
            if(count($posts['posts']) > 0){
                $news_list_html = $this->load->view('News/list_block', $posts, true);
            } else {
                $news_list_html = $this->load->view('Templates/no_results', array(), true);
            }
            $return_array = array(
                'success' => 1,
                'html' => $news_list_html
            );
        } else {
            $return_array = array(
                'success' => 0,
                'html' => 'Invalid argument. Only integer value allowed.'
            );
        }
        echo json_encode($return_array);
        
    }

    public function detail($id) {
        $posts = $this->News_model->get_news($id);
        if (count($posts) == 1) {
            $data['post'] = $posts[0];
            $this->template->load('default', 'Home/detail', $data);
        } else {
            redirect('/');
        }
    }

    /**
     * This function is used to add new comments for particular news
     * @params : $id -> integer
     * @return
     * @author : pav
    */
    public function add_comment($id){
        $posts = $this->News_model->get_news($id);
        $this->form_validation->set_rules('txt_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('txt_email', 'Email', 'trim|required|valid_email');
        if ($this->form_validation->run() == FALSE){
             $this->template->load('default', 'Home/detail', $data);
        }else{

        }

    }

}
