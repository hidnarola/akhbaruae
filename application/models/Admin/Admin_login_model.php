<?php

class Admin_login_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    /**
     * get_user function
     * used check admin login credentials is correct or wrong
     * @return result of array if success else retrun false
     * @author KAP
     **/
    public function get_user($username, $password){
        $this->db->where('username', $username);
        $this->db->where('password', md5($password));
        $this->db->where('user_role', 'admin');
        $users = $this->db->get(TBL_USER);
        $user_detail = $users->result_array();
        if(count($user_detail) == 1 ){
            return $user_detail[0];
        } else {
            return array();
        }
    }
}