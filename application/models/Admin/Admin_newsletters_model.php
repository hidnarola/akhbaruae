<?php

class Admin_newsletters_model extends CI_Model {
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
        $columns = ['id', 'title', 'created_date'];
        $this->db->select($select,FALSE);
        $keyword = $this->input->get('search');
        if (!empty($keyword['value'])) {
            $this->db->having('title LIKE "%'.$this->db->escape_like_str($keyword['value']).'%"',NULL);
        }
        $this->db->join(TBL_NEWSLETTER_SETTINGS.' ns','ns.newsletter_id = n.id','LEFT');
        $this->db->join(TBL_NEWSLETTERS_TEST_EMAILS.' tn','tn.newsletter_id = n.id','LEFT');
        $this->db->order_by($columns[$this->input->get('order')[0]['column']],$this->input->get('order')[0]['dir']);
        $this->db->where_in('is_delete','0');
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
     * get_rgistered_users_countries function
     * get countries list of registered users only
     * @return array
     * @author KAP
     **/
    public function get_rgistered_users_countries(){
        $this->db->query('SET GLOBAL sql_mode = \'\'');
        $this->db->select('c.*, u.id AS user_id');
        $this->db->join(TBL_USER.' u','u.country_id = c.id','LEFT');
        $this->db->group_by('c.id');
        $this->db->having('user_id IS NOT NULL');
        $query = $this->db->get(TBL_COUNTRIES.' c');
        return $query->result_array();
    }

    /**
     * get_newsletter_testing_emails function
     * get testing emails
     * @return array
     * @author KAP
     **/
    public function get_newsletter_testing_emails($newseletter_id){
        $this->db->select('email_ids');
        $this->db->where('newsletter_id',$newseletter_id);
        $query = $this->db->get(TBL_NEWSLETTERS_TEST_EMAILS);
        return $query->result_array();
    }

    /**
     * get_users_for_newsletter function
     * get users for newseletter, get users from newsletter settings.
     * @return array
     * @author KAP
     **/
    public function get_users_for_newsletter($newsletter_id, $country_id){
        $this->db->select('u.email_id, u.country_id');
        if($country_id != 0){
            $this->db->join(TBL_NEWSLETTER_SETTINGS.' ns','ns.country_id = u.country_id','LEFT');
            $this->db->where('ns.newsletter_id',$newsletter_id);
        }
        $query = $this->db->get(TBL_USER.' u');
        return $query->result_array();
    }
}