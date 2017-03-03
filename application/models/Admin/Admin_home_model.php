<?php

class Admin_home_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    /**
     * get_dashboard_graph_data function
     * get users and spots result
     * @return Array
     * @param Type (spots, users);
     * @author KAP
     **/
    public function get_dashboard_graph_data($type){
        $date = $this->input->post('date');
        if($date == '')
            $date = date('m-Y');
        if($type == 'users'){
            $this->db->select('count(*) user_count, date(registered_date) created_date', FALSE);
            $this->db->group_by('date(registered_date)', FALSE);
            if($date != ''){
                $this->db->where('date_format(registered_date,\'%m-%Y\')',$this->db->escape($date),FALSE);
            } else {
                $this->db->where('date_format(registered_date,\'%m-%Y\')',$this->db->escape($date),FALSE);
            }
            $query = $this->db->get(TBL_USER);
        } else {
            $this->db->select('count(*) spot_count, date(created_date) created_date', FALSE);
            $this->db->group_by('date(created_date)', FALSE);
            if($date != ''){
                $this->db->where('date_format(created_date,\'%m-%Y\')',$this->db->escape($date),FALSE);
            }
            $query = $this->db->get(TBL_SPOTS);
        }
        return $query->result_array();
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
}