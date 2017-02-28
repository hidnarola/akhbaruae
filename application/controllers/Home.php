<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->library('webhose');
        
        Webhose::config("cb2e92ec-e932-4e97-a0c9-01f659fb8b85");
        $params = array(
            "q" => "United States",
            "size" => "10",
            "sort" => "relevancy",
            "language" => "arabic"
        );
        $result = $data['posts'] = Webhose::query("filterWebData", $params);
//        $this->print_filterwebdata_titles($result);
         
        
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
