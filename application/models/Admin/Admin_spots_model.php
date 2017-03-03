<?php

class Admin_spots_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    /**
     * @method : get_spots_result
     * @uses : this function is used to get result based on datatable in user list page
     * @param : @table 
     * @author : KAP
     */ 
    public function get_spots_result($table, $select = null, $type) {
        $columns = [ 'id', 'title', 'description', 'location', 'created_date'];
        $this->db->select($select,FALSE);
        $keyword = $this->input->get('search');
        if (!empty($keyword['value'])) {
            $this->db->having('title LIKE "%'.$this->db->escape_like_str($keyword['value']).'%" OR description LIKE "%'.$this->db->escape_like_str($keyword['value']).'%" OR email_id LIKE "%'.$this->db->escape_like_str($keyword['value']).'%"',NULL);
        }

        $txt_location_search =  $this->input->get('txt_location_search');
        $txt_created_date =  $this->input->get('txt_created_date');
        if($txt_location_search != ''){
            $this->db->where('location LIKE "%'.$this->db->escape_like_str($txt_location_search).'%"',NULL);
        }
        if($txt_created_date != ''){
            $this->db->where('date(created_date)',$txt_created_date);
        }
        $this->db->order_by($columns[$this->input->get('order')[0]['column']],$this->input->get('order')[0]['dir']);
        $this->db->where('spot_status',1);
        $this->db->where('is_delete',0);
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
     * @method : get_new_spots_result
     * @uses : this function is used to get result based on datatable in user list page
     * @param : @table 
     * @author : KAP
     */ 
    public function get_new_spots_result($table, $select = null, $type) {
        $columns = [ 'id', 'title', 'description', 'location', 'created_date'];
        $this->db->select($select,FALSE);
        $keyword = $this->input->get('search');
        if (!empty($keyword['value'])) {
            $this->db->having('title LIKE "%'.$this->db->escape_like_str($keyword['value']).'%" OR description LIKE "%'.$this->db->escape_like_str($keyword['value']).'%"  OR location LIKE "%'.$this->db->escape_like_str($keyword['value']).'%"',NULL);
        }
        $this->db->order_by($columns[$this->input->get('order')[0]['column']],$this->input->get('order')[0]['dir']);
        $this->db->where('spot_status',0);
        $this->db->where('is_delete',0);
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
    public function get_spot_detail($id) {
        $this->db->select('s.*, c.name AS country_name, st.name AS state_name, ca.name AS category_name, ct.name AS city_name, simage.spot_image_name AS spot_image,u.email_id AS user_email, u.first_name, u.last_name');
        $this->db->join(TBL_COUNTRIES.' c','c.id = s.country_id','LEFT');
        $this->db->join(TBL_STATES.' st','st.id = s.state_id','LEFT');
        $this->db->join(TBL_CITIES.' ct','ct.id = s.city_id','LEFT');
        $this->db->join(TBL_CATEGORIES.' ca','ca.id = s.category_id','LEFT');
        $this->db->join(TBL_SPOT_IMAGES.' simage','simage.spot_id = s.id AND simage.type = 1','LEFT');
        $this->db->join(TBL_USER.' u','u.id = s.user_id','LEFT');
        $this->db->where('s.id',$id);
        $query = $this->db->get(TBL_SPOTS.' s');
        return $query->result_array();
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
     * @method : get_my_spot_gallery
     * @uses : get my spot gallery
     * @return : array of results
     * @author : KAP
     */
    public function get_my_spot_gallery($offset,$limit,$where){
        $this->db->select('*');
        $this->db->where($where);
        $this->db->limit($limit,$offset);
        $query = $this->db->get(TBL_SPOT_IMAGES);
        return $query->result_array();
    }

     /**
     * @method : delete
     * @uses : delete records
     * @return : array of results
     * @author : KAP
     */
    public function delete($table,$id){
        $this->db->where('id', $id);
        $this->db->delete($table); 
    }

    /**
     * count_new_requests function
     * @uses count new requests of spots
     * @return number of spots
     * @author KAP
     **/
    public function count_new_requests(){
        $this->db->select('*');
        $this->db->where('spot_status',0);
        $this->db->where('is_delete',0);
        $query = $this->db->get(TBL_SPOTS);
        return $query->num_rows();
    }
}