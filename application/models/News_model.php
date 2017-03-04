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
        //$this->db->join('social', 'social.news_id = news.id', 'LEFT');
        $this->db->join('news_share', 'news_share.news_id = news.id', 'LEFT');
        $this->db->limit(10, 0);
        $news = $this->db->get('news');
        return $news->result_array();
    }
    
    public function filter_news($filter_array, $is_count = 0, $start = 0, $limit = 10) {
        $this->db->join('social', 'social.news_id = news.id', 'LEFT');
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

    public function get_commnets($news_id) {
        $this->db->where('news_id', $news_id);
        $comments = $this->db->get('comments');
        return $comments->result_array();
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
