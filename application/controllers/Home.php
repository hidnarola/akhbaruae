<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('News_model');
    }

    public function index() {
        $this->load->library('webhose');
        Webhose::config("072da86e-2191-4843-b2c9-bd074f4824f0");
        $params = array(
            "size" => "10",
            "sort" => "relevancy",
            "language" => "arabic"
        );
        $result = $data['posts'] = Webhose::query("filterWebData", $params);
        //$this->print_filterwebdata_titles($result);
        $this->template->load('default', 'Home/index', $data);
    }
    
    public function print_filterwebdata_titles($api_response) {
        if ($api_response == null) {
            echo "<p>Response is null, no action taken.</p>";
            return;
        }
        echo '<pre>';
        print_r($api_response);
        exit;
        if (isset($api_response->posts)){
            foreach ($api_response->posts as $post) {
                echo "<p>" . $post->title . "</p>";
            }
        }
        exit;
    }

}
