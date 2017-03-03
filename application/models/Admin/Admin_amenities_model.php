<?php

class Admin_amenities_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    /**
     * @method : get_amenities_result
     * @uses : this function is used to get result based on datatable in user list page
     * @param : @table 
     * @author : KAP
     */ 
    public function get_amenities_result($table, $select = null, $type) {
        $columns = ['id', 'name'];
        $this->db->select($select,FALSE);
        $keyword = $this->input->get('search');
        if (!empty($keyword['value'])) {
            $this->db->having('name LIKE "%'.$this->db->escape_like_str($keyword['value']).'%"',NULL);
        }
        $this->db->where('is_delete',0);
        $this->db->order_by($columns[$this->input->get('order')[0]['column']],$this->input->get('order')[0]['dir']);
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
}