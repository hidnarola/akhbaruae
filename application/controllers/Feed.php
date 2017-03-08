<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Feed extends CI_Controller {

    public $commstr = '';

    public function __construct() {
        parent::__construct();
        $this->load->model('News_model');
        $this->limit = 10;
    }

    public function index(){
        $this->load->helper('xml');
        $this->load->helper('text');
        $data['feed_name'] = 'AkhbarUAE'; // your website
        $data['encoding'] = 'utf-8'; // the encoding
        $data['feed_url'] = 'http://clientapp.narola.online/HD/akhbaruae/feed'; // the url to your feed
        $data['page_description'] = 'List of latest News'; // some description
        $data['page_language'] = 'en-us'; // the language
        $data['creator_email'] = 'hda@narola.email'; // your email
        $data['posts'] = $this->News_model->get_all_news(25);  
//        die('here');
        header("Content-Type: application/rss+xml"); // important!
        $this->load->view('News/rss', $data);
    }

}
