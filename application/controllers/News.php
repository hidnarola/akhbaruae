<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('News_model');
    }

    public function index() {
        $data['posts'] = $posts = $this->News_model->get_news();
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

}
