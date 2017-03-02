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
        $this->db->join('social', 'social.news_id = news.id', 'LEFT');
        $this->db->limit(10, 0);
        $news = $this->db->get('news');
        return $news->result_array();
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
    
    public function get_user($email, $password) {
        $this->db->where('email', $email);
        $users = $this->db->get('admin');
        $user_detail = $users->result_array();
        if (count($user_detail) == 1) {
            $db_password = $this->encrypt->decode($user_detail[0]['password']);
            if ($db_password == $password) {
                return $user_detail;
            } else {
                return array();
            }
        }
        return array();
    }

    public function get_user_data($user_id) {
        $this->db->where('admin.id', $user_id);
        $users = $this->db->get('admin');
        return $users->row_array();
    }

    public function get_total_users($user_type = 0) {
        $this->db->where('account_type', $user_type);
        $users = $this->db->get('users');
        return count($users->result_array());
    }

    public function get_records($table_name, $id = '') {
        if ($id != '') {
            $this->db->where('id', $id);
        }
        $this->db->where('is_active', 1);
        $records = $this->db->get($table_name);
        return $records->result_array();
    }

    public function get_emirates($id = '') {
        if ($id != '') {
            $this->db->where('id', $id);
        }
        $emirates = $this->db->get('emirates');
        return $emirates->result_array();
    }

    public function get_job_fields($id = '') {
        if ($id != '') {
            $this->db->where('id', $id);
        }
        $this->db->where('is_active', 1);
        $skills = $this->db->get('job_fields');
        return $skills->result_array();
    }

    public function get_guestbook() {
        $this->db->select('guest_book.*,emirates.english_name');
        $this->db->where('guest_book.is_active', '1');
        $this->db->join('emirates', 'emirates.id = guest_book.city_id','LEFT');
        $skills = $this->db->get('guest_book');
        return $skills->result_array();
    }

    public function record_exist($table_name, $conditions) {
        if (is_array($conditions) && count($conditions) > 0) {
            foreach ($conditions as $column_name => $value) {
                $this->db->where($column_name, $value);
            }
        }
        $records = $this->db->get($table_name);
        return count($records->result_array());
    }

    public function manage_emirate($emirate_array, $emirate_id = '') {
        if ($emirate_id != '') {
            $this->db->where('id', $emirate_id);
            if ($this->db->update('emirates', $emirate_array)) {
                return 1;
            } else {
                return 0;
            }
        } else {
            if ($this->db->insert('emirates', $emirate_array)) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function manage_record($table_name, $record_array, $primary_id = '') {
        if ($primary_id != '') {
            $this->db->where('id', $primary_id);
            if ($this->db->update($table_name, $record_array)) {
                return 1;
            } else {
                return 0;
            }
        } else {
            if ($this->db->insert($table_name, $record_array)) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function batch_update($table_name, $update_array, $primary_column) {
        if ($this->db->update_batch($table_name, $update_array, $primary_column)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function get_resume_detail($id) {
        $this->db->select(
                'resume.*,
            GROUP_CONCAT(DISTINCT resume_skills.english_name) as skill_names,
            GROUP_CONCAT(DISTINCT resume_skills.arabic_name) as arabic_skill_names,
        ');
        $this->db->from('resume');
        $this->db->join('resume_skills', "FIND_IN_SET(resume_skills.id,resume.skills) != 0", 'left');
        $this->db->where('resume.id', $id);
        $this->db->group_by('resume.id');
        $resumes = $this->db->get();
        return $resumes->row_array();
    }

    public function get_users_resume_skills($user_id) {
        $this->db->select('resume_skills.*');
        $this->db->from('resume');
        $this->db->join('resume_skills', "FIND_IN_SET(resume_skills.id,resume.skills) != 0", 'left');
        $this->db->where('resume.id', $user_id);
        $resumes = $this->db->get();
        return $resumes->result_array();
    }

    public function filter_users($filter_array, $is_count = 0, $start = 0, $limit = 10) {
        $this->db->select('users.*, emirates.english_name as emirate_name');
        $this->db->join('emirates', 'users.emirate = emirates.id', 'left');
        $this->db->where('users.account_type', 0);
        if ($is_count == 1) {
            $users = $this->db->get('users');
            return count($users->result_array());
        } else {
            $start_record = $start * $limit;
            $this->db->limit($limit, $start_record);
            $users = $this->db->get('users');
            return $users->result_array();
        }
    }

    public function filter_company($filter_array, $is_count = 0, $start = 0, $limit = 10) {
        $this->db->select('
            users.*,
            emirates.english_name as emirate_name,
            count(DISTINCT company_position.id) as open_positions,
            GROUP_CONCAT(DISTINCT company_job_fields.' . lang('column_name') . ') as field_names
        ');
        $this->db->join('emirates', 'users.emirate = emirates.id', 'left');
        $this->db->join('position as company_position', 'company_position.user_id = users.id', 'left');
        $this->db->join('job_fields as company_job_fields', 'FIND_IN_SET(company_job_fields.id,users.job_field) != 0', 'left');
        $this->db->where('users.account_type', 1);
        $this->db->group_by('users.id');
        if ($is_count == 1) {
            $users = $this->db->get('users');
            return count($users->result_array());
        } else {
            $start_record = $start * $limit;
            $this->db->limit($limit, $start_record);
            $users = $this->db->get('users');
            return $users->result_array();
        }
    }

    public function delete_record($table_name, $id) {
        $this->db->where('id', $id);
        if ($this->db->delete($table_name)) {
            return 1;
        } else {
            return 0;
        }
    }

}
