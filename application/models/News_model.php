<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class News_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function check_news_exist($column_name, $value) {
        $this->db->where($column_name, $value);
        $news = $this->db->get('news');
        return $news->result_array();
    }

    public function get_news($id = '') {
        if ($id != '') {
            $this->db->where('news.id', $id);
        }
        $this->db->where('active', 1);
        $this->db->join('social', 'social.news_id = news.id', 'LEFT');
        $this->db->limit(10, 0);
        $news = $this->db->get('news');
        return $news->result_array();
    }
    
    public function get_all_news($limit = '') {
        if($limit != ''){
            $this->db->limit($limit, 0);
        }
        $this->db->where('active', 1);
        $this->db->order_by('crawled', 'desc');
        $news = $this->db->get('news');
        return $news->result_array();
    }
    
    public function get_last_crawled_date() {
        $this->db->select("max(crawled) as last_crawled");
        $news = $this->db->get('news');
        return $news->row_array();
    }
    
    public function filter_news($filter_array, $is_count = 0, $start = 0, $limit = 10) {
        $this->db->join('social', 'social.news_id = news.id', 'LEFT');
        $is_admin = 0;
        if(count($filter_array) > 0){
            if(isset($filter_array['search']) && $filter_array['search'] != ''){
                $this->db->or_like('news.title', $filter_array['search']);
            }
            if(isset($filter_array['is_admin']) && $filter_array['is_admin'] != ''){
                $is_admin = 1;
            }
        }
        $this->db->order_by('crawled', 'desc');
        if($is_admin == 0){
            $this->db->where('active', 1);
        }
        if( $is_count == 1 ){
            $news = $this->db->get('news');
            return count($news->result_array());
        } else {
            $start_record = $start * $limit;
            $this->db->limit($limit, $start_record);
            $news = $this->db->get('news');
            return $news->result_array();
        }
    }
    
    public function update_news($news_obj, $news_id) {
        $this->db->where('id', $news_id);
        if ($this->db->update('news', $news_obj)) {
            return 1;
        } else {
            return 0;
        }
    }
    
    public function manage_news($news_obj, $social_obj, $news_id = '') {
        if ($news_id != '') {
            $this->db->where('id', $news_id);
            if ($this->db->update('news', $news_obj)) {
                $social_obj['news_id'] = $news_id;
                $this->db->where('news_id', $news_id);
                if ($this->db->update('social', $social_obj)) {
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        } else {
            if ($this->db->insert('news', $news_obj)) {
                $social_obj['news_id'] = $this->db->insert_id();
                if ($this->db->insert('social', $social_obj)) {
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        }
    }

    public function get_all_comments($news_id) {
        $this->db->where('news_id', $news_id);
        $comments = $this->db->get('comments');
        return $comments->result_array();
    }

    public function get_commnets($news_id) {
        $this->db->where('news_id', $news_id);
        $this->db->where('active', 1);
        $comments = $this->db->get('comments');
        return $comments->result_array();
    }
    
    public function add_comments($insertArr) {
        if($this->db->insert('comments', $insertArr)){
            return 1;
        }else{
            return 0;
        }
    }
    
    public function update_comments($comments_obj, $comments_id) {
        $this->db->where('id', $comments_id);
        if ($this->db->update('comments', $comments_obj)) {
            return 1;
        } else {
            return 0;
        }
    }
    
    public function check_comments_exist($column_name, $value) {
        $this->db->where($column_name, $value);
        $news = $this->db->get('comments');
        return $news->result_array();
    }
    
    public function filter_comments($filter_array, $is_count = 0, $start = 0, $limit = 10) {
        $this->db->select('comments.*, news.title');
        $this->db->join('news', 'comments.news_id = news.id', 'LEFT');
        $is_admin = 0;
        if(count($filter_array) > 0){
            if(isset($filter_array['search']) && $filter_array['search'] != ''){
                $this->db->or_like('comments.author_name', $filter_array['search']);
                $this->db->or_like('comments.author_email', $filter_array['search']);
                $this->db->or_like('comments.author_comment', $filter_array['search']);
            }
            if(isset($filter_array['is_admin']) && $filter_array['is_admin'] != ''){
                $is_admin = 1;
            }
            if(isset($filter_array['news_id']) && $filter_array['news_id'] != ''){
                $this->db->where('news_id', $filter_array['news_id']);
            }
        }
        if($is_admin == 0){
            $this->db->where('comments.active', 1);
        }
        if( $is_count == 1 ){
            $news = $this->db->get('comments');
            return count($news->result_array());
        } else {
            $start_record = $start * $limit;
            $this->db->limit($limit, $start_record);
            $news = $this->db->get('comments');
            return $news->result_array();
        }
    }
    
    public function get_result($table, $condition = null) {
        $this->db->select('*');
        if (!is_null($condition)) {
            $this->db->where($condition);
        }
        $query = $this->db->get($table);
        return $query->result_array();
    }

}
