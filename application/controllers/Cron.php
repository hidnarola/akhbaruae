<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('News_model');
        $this->load->library('webhose');
        Webhose::config("cb2e92ec-e932-4e97-a0c9-01f659fb8b85");
    }

    public function index() {
        $params = array(
            "size" => "100",
            "sort" => "relevancy",
            "language" => "arabic",
            "thread.country" => "AE"
        );
        $result = Webhose::query("filterWebData", $params);
        $this->manage_news($result);
        
    }
    
    public function test() {
        $this->template->load('default', 'Home/test');
    }
    
    public function manage_news($api_response) {
        if ($api_response == null) {
            echo "<p>Response is null, no action taken.</p>";
            return;
        }
        if (isset($api_response->posts)){
            foreach ($api_response->posts as $post) {
                $news_obj = array(
                    'title' => $post->title,
                    'section_title' => $post->thread->section_title,
                    'text' => $post->text,
                    'image' => $post->thread->main_image,
                    'uuid' => $post->uuid,
                    'url' => $post->url,
                    'author' => $post->author,
                    'site_address' => $post->thread->site_full,
                    'site_categories' => implode('|', $post->thread->site_categories),
                    'external_links' => implode('|', $post->external_links),
                    'published' => date('Y-m-d H:i:s', strtotime($post->published)),
                    'crawled' => date('Y-m-d H:i:s', strtotime($post->crawled))
                );
                $social_obj = array(
                    'facebook_likes' => $post->thread->social->facebook->likes,
                    'facebook_comments' => $post->thread->social->facebook->comments,
                    'facebook_shares' => $post->thread->social->facebook->shares,
                    'gplus_shares' => $post->thread->social->gplus->shares,
                    'pinterest_shares' => $post->thread->social->pinterest->shares,
                    'linkedin_shares' => $post->thread->social->linkedin->shares,
                    'stumbledupon_shares' => $post->thread->social->stumbledupon->shares,
                    'vk_shares' => $post->thread->social->vk->shares,
                );
                $news_exist = $this->News_model->check_news_exist('uuid', $post->uuid);
                if(count($news_exist) == 0){
                    $news_id = $this->News_model->manage_news($news_obj, $social_obj);
                } else {
                    $news_updated = $this->News_model->manage_news($news_obj, $social_obj, $news_exist[0]['id']);
                }
            }
        }
        $result = Webhose::get_next();
        $this->manage_news($result);
    }

}
