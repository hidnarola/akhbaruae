<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('News_model');
    }

    public function index() {
        $data['posts'] = $posts = $this->News_model->get_news();
        $data['main_post'] = $posts[0];
        $this->template->load('default', 'Home/test', $data);
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
