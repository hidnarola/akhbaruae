<?php

class Admin_users_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    /**
     * @method : get_users_result
     * @uses : this function is used to get result based on datatable in user list page
     * @param : @table 
     * @author : KAP
     */ 
    public function get_users_result($table, $select = null, $type) {
        $columns = ['id', 'first_name', 'last_name', 'username', 'email_id', 'cnt_total', 'type', 'location','registered_date','is_deleted'];
        $this->db->select($select,FALSE);
        $keyword = $this->input->get('search');
        if (!empty($keyword['value'])) {
            $this->db->having('first_name LIKE "%'.$this->db->escape_like_str($keyword['value']).'%" OR last_name LIKE "%'.$this->db->escape_like_str($keyword['value']).'%" OR email_id LIKE "%'.$this->db->escape_like_str($keyword['value']).'%" OR username LIKE "%'.$this->db->escape_like_str($keyword['value']).'%" OR type LIKE "%'.$this->db->escape_like_str($keyword['value']).'%" OR location LIKE "%'.$this->db->escape_like_str($keyword['value']).'%" OR c.name LIKE "%'.$this->db->escape_like_str($keyword['value']).'%" OR s.name LIKE "%'.$this->db->escape_like_str($keyword['value']).'%" OR cu.name LIKE "%'.$this->db->escape_like_str($keyword['value']).'%"',NULL);
        }
        $this->db->order_by($columns[$this->input->get('order')[0]['column']],$this->input->get('order')[0]['dir']);
        $this->db->join(TBL_COUNTRIES.' cu','cu.id = u.country_id','LEFT');
        $this->db->join(TBL_STATES.' s','s.id = u.state_id','LEFT');
        $this->db->join(TBL_CITIES.' c','c.id = u.city_id','LEFT');
        $this->db->where_in('is_delete',array(0,2));
        if($type == 'count'){
            $query = $this->db->get($table);
            return $query->num_rows();
        } else {
            $this->db->limit($this->input->get('length'),$this->input->get('start'));
            $query = $this->db->get($table);
            return $query->result_array();
        }
    }

    /**
     * @method : rows_of_table
     * @uses : count rows of table
     * @return : number of rows
     * @author : KAP
     */
    public function rows_of_table($table,$condition = null){
        $this->db->select('*');
        if($condition != null)
            $this->db->where($condition);
        $query = $this->db->get($table);
        return $query->num_rows();
    }

    /**
     * @method : get_result
     * @uses : This function is used get result from the table
     * @param : @table 
     * @author : KAP
     */ 
    public function get_result($table, $condition = null) {
        $this->db->select('*');
        if(!is_null($condition)){
            $this->db->where($condition);                
        }
        $query = $this->db->get($table);
        return $query->result_array();
    }

    /**
     * @method : update_user
     * @uses : This function is used to update record
     * @param : @table, @user_id, @user_array = array of update  
     * @author : KAP
     */ 
    public function update_record($table, $condition, $user_array) {
        $this->db->where($condition);
        if ($this->db->update($table, $user_array)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @method : insert
     * @uses : Insert user record into table
     * @param : @table = table name, @array = array of insert
     * @return : insert_id else 0
     * @author : KAP
     */
    public function insert($table,$array){
        if ($this->db->insert($table, $array)) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    /**
     * @method : get_spots_result
     * @uses : this function is used to get result based on datatable in user list page
     * @param : @table 
     * @author : KAP
     */ 
    public function get_spots_result($table, $select = null, $type, $user_id) {
        $columns = [ 'id', 'title', 'description', 'address', 'location', 'contact_number', 'email_id', 'price', 'spot_status', 'is_delete', 'created_date'];
        $this->db->select($select,FALSE);
        $keyword = $this->input->get('search');
        if (!empty($keyword['value'])) {
            $this->db->having('title LIKE "%'.$this->db->escape_like_str($keyword['value']).'%" OR description LIKE "%'.$this->db->escape_like_str($keyword['value']).'%" OR email_id LIKE "%'.$this->db->escape_like_str($keyword['value']).'%" OR location LIKE "%'.$this->db->escape_like_str($keyword['value']).'%"',NULL);
        }
        $this->db->order_by($columns[$this->input->get('order')[0]['column']],$this->input->get('order')[0]['dir']);
        $this->db->limit($this->input->get('length'),$this->input->get('start'));
        $this->db->where('spot_status',1);
        $this->db->where('user_id',$user_id);
        $query = $this->db->get($table);
        if($type == 'count'){
            return $query->num_rows();
        } else {
            return $query->result_array();
        }
    }
}