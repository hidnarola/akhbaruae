<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Spots extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/admin_spots_model');
    }

    /**
     * @method : active function
     * @uses : Load view of active spots
     * @author : KAP
     **/
    public function active() {
        $data['title'] = 'Spotashoot - Admin active spots';
        $this->template->load('admin','admin/spots/index', $data);
    }

    /**
     * @method : list_spots function
     * @uses : this function is used to get result based on datatable in active spots list page
     * @author : KAP
     **/
    public function list_spots() {
        $start = $this->input->get('start');
        $select = 'id, @a:=@a+1 AS test_id, title, CONCAT(SUBSTRING_INDEX(description, \' \', 6),\'...\') AS description, address, location, contact_number, email_id, price, spot_status, is_delete, created_date, slug';
        $final['recordsTotal'] = $this->admin_spots_model->get_spots_result(TBL_SPOTS,$select,'count');
        $keyword = $this->input->get('search');
        $final['redraw'] = 1;
        // $final['recordsFiltered'] = $this->admin_spots_model->get_spots_result(TBL_SPOTS,$select,'count');
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->admin_spots_model->get_spots_result(TBL_SPOTS.','.'(SELECT @a:= '.$start.') AS a',$select,'result');
        echo json_encode($final);
    }

    /**
     * @method : new_requests function
     * @uses : Load view of new requests page
     * @author : KAP
     **/
    public function new_requests() {
        $data['title'] = 'Spotashoot - Admin new request spots';
        $this->template->load('admin','admin/spots/new_request', $data);
    }

    /**
     * @method : list_new_request_spots function
     * @uses : get result of new request of spots
     * @author : KAP
     **/
    public function list_new_request_spots() {
        $start = $this->input->get('start');
        $select = 'id, @a:=@a+1 AS test_id, title, CONCAT(SUBSTRING_INDEX(description, \' \', 6),\'...\') AS description, location, spot_status, is_delete, created_date, slug';
        $final['recordsTotal'] = $this->admin_spots_model->get_new_spots_result(TBL_SPOTS,$select,'count');
        $keyword = $this->input->get('search');
        $final['redraw'] = 1;
        // $final['recordsFiltered'] = $this->admin_spots_model->get_spots_result(TBL_SPOTS,$select,'count');
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->admin_spots_model->get_new_spots_result(TBL_SPOTS.','.'(SELECT @a:= '.$start.') AS a',$select,'result');
        echo json_encode($final);
    }

    /**
     * @method : action function
     * @uses : this function is used to performing action with user
     * @param : @action, @user_id
     * @author : KAP
     **/
    public function action($action, $spot_id, $user_id = null) {
        $where = 'id = '.$this->db->escape($spot_id);
        $check_user = $this->admin_spots_model->get_spot_detail($spot_id);
        if($check_user){
            if($action == 'delete'){
                $update_array = array(
                    'is_delete' => 1
                ); 
                $this->session->set_flashdata('success', 'Spot successfully deleted!');
            } elseif ($action == 'approve'){
                $update_array = array(
                    'spot_status' => 1
                ); 
                $this->session->set_flashdata('success', 'Spot successfully approved!');

                $where_check_notify_me = ' user_id = '.$check_user[0]['user_id'];
                $check_notify_me = $this->admin_spots_model->get_result(TBL_USER_SETTINGS, $where_check_notify_me);
                $notify_me = FALSE;
                if($check_notify_me){
                   if($check_notify_me[0]['spot_approval'] == 0){
                        $notify_me = TRUE;
                   } 
                } else {
                    $notify_me = TRUE;
                }
                if($notify_me == TRUE){
                    $mail_data = array(
                        'heading' => $check_user[0]['title'].' - Spot approval report',
                        'message' => 'Your spot is approved by admin',
                        'spot_title' => 'Click to view '.$check_user[0]['title'],
                        'button_link' => 'spot/'.$check_user[0]['slug'],
                        'unsubscribe_link' => site_url().'unsubscribe_notification/spot_approval?code='.urlencode($this->encrypt->encode($check_user[0]['user_id']))
                    );
                    $msg = $this->load->view('email_templates/spot_approval',$mail_data,true);
                    if(send_mail_front($check_user[0]['user_email'],'info@spotashoot.com',$check_user[0]['title'].' - Spot report',$msg)){
                        $this->session->set_flashdata('success', 'Spot successfully approved!');
                    } else {
                        show_404();
                    }
                }
            } elseif ($action == 'unapprove'){

                $update_array = array(
                    'spot_status' => 2
                ); 
                $mail_data = array(
                    'heading' => $check_user[0]['title'].' - Spot rejection report',
                    'username' => 'Dear '.$check_user[0]['first_name'].' '.$check_user[0]['last_name'],
                    'spot_title' => 'Click to view '.$check_user[0]['title'],
                    'button_link' => 'spot/'.$check_user[0]['slug'].'?unapproved=true',
                );
                $msg = $this->load->view('email_templates/spot_unapprove',$mail_data,true);
                send_mail_front($check_user[0]['user_email'],'info@spotashoot.com',$check_user[0]['title'].' - Spot report',$msg);
                $this->session->set_flashdata('success', 'Spot successfully rejected!');
            } else {    
                $update_array = array(
                    'is_delete' => 0
                );   
                $this->session->set_flashdata('success', 'Spot successfully activated!');
            }
            $this->admin_spots_model->update_record(TBL_SPOTS,$where,$update_array);
        } else {
            $this->session->set_flashdata('error', 'Invalid request. Please try again!');
        }
        if($user_id != ''){
            redirect(site_url('admin/users/spots/'.$user_id));
        }
        if($this->input->get('redirect') != ''){
            redirect(site_url('admin/spots/new_requests'));
        } else {
            redirect(site_url('admin/spots/active'));
        }
    }

    /**
     * @method : edit function
     * @uses : Load view of add and edit spot
     * @author : KAP
     **/
    public function edit() {
        $data = array();
        $spot_id = $this->uri->segment(4);
        $user_id = '';
        if($this->uri->segment(5) != '') 
            $user_id = $this->uri->segment(5);
        else if($this->input->get('user_id') != '') 
            $user_id = $this->input->get('user_id');
        else 
            $user_id = null ;

        //--- check user id is valid or not
        if(is_numeric($user_id)){
            $where = 'id = '.$this->db->escape($user_id);
            $check_user = $this->admin_spots_model->get_result(TBL_USER,$where);
            if(empty($check_user)){
                show_404();
            } else {
                $data['user_id'] = $user_id;
            }
        }

        //--- check spot is valid or not
        if(is_numeric($spot_id)){
            $where = 'id = '.$this->db->escape($spot_id);
            $check_spot = $this->admin_spots_model->get_spot_detail($spot_id);
            if($check_spot){
                $data['spot_data'] = $check_spot[0];
                $data['title'] = 'Edit spot';
                $data['heading'] = 'Edit spot';
            } else {
                show_404();
            }
        } else {
            $data['title'] = 'Add spot';
            $data['heading'] = 'Add spot';
            if (empty($_FILES['cover_photo']['name'])){
                $this->form_validation->set_rules('cover_photo', 'Cover photo', 'required');
            }
        }
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        // $this->form_validation->set_rules('description', 'Listing Description', 'trim|required');
        // $this->form_validation->set_rules('country_id', 'Country', 'trim|required');
        // $this->form_validation->set_rules('state_id', 'State', 'trim|required');
        // $this->form_validation->set_rules('city_id', 'City', 'trim|required');
        $this->form_validation->set_rules('category_id', 'Category', 'trim|required');
        $this->form_validation->set_rules('latitude', 'Latitude', 'trim|required');
        $this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');
        $this->form_validation->set_rules('location', 'Location', 'trim|required');
        $data['countries'] = $this->admin_spots_model->get_result(TBL_COUNTRIES);
        $data['categories'] = $this->admin_spots_model->get_result(TBL_CATEGORIES,'is_delete = 0');
        $data['amenities'] = $this->admin_spots_model->get_result(TBL_AMENITIES,'is_delete = 0');
        if ($this->form_validation->run() == FALSE) {
            $this->form_validation->set_error_delimiters('<div class="alert alert-error alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');  
        } else {
            $image_name = '';
            if($spot_id != ''){
                if(!empty($_FILES['cover_photo']['name'])){
                    unlink(SPOT_GALLARY_ORIGINAL.'/'.$data['spot_data']['spot_image']);
                    unlink(SPOT_GALLARY_THUMB.'/'.$data['spot_data']['spot_image']);
                    unlink(SPOT_GALLARY_MEDIUM.'/'.$data['spot_data']['spot_image']);
                    unlink(SPOT_GALLARY_GALLERY_VIEW.'/'.$data['spot_data']['spot_image']);
                    unlink(SPOT_GALLARY_ZOOM_VIEW.'/'.$data['spot_data']['spot_image']);
                    $image_name = upload_image('cover_photo',SPOT_GALLARY_ORIGINAL);
                    if(!is_array($image_name)){
                        // resize_image(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_THUMB,110,110);
                        copy(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_THUMB.'/'.$image_name);
                        crop(SPOT_GALLARY_THUMB.'/'.$image_name,110,110);
                        // resize_image(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_MEDIUM,262,207);
                        copy(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_MEDIUM.'/'.$image_name);
                        crop(SPOT_GALLARY_MEDIUM.'/'.$image_name,262,207);

                        // resize_image(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_GALLERY_VIEW,750,500);
                        copy(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_GALLERY_VIEW.'/'.$image_name);
                        crop(SPOT_GALLARY_GALLERY_VIEW.'/'.$image_name,750,500);
                        
                        // resize_image(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_ZOOM_VIEW,1000,667);
                        copy(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_ZOOM_VIEW.'/'.$image_name);
                        crop(SPOT_GALLARY_ZOOM_VIEW.'/'.$image_name,1000,667);

                    } else {
                        $data['error'] = $image_name['errors'];
                    }
                }
            } else {
                $image_name = upload_image('cover_photo',SPOT_GALLARY_ORIGINAL);
                if(!is_array($image_name)){
                    // resize_image(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_THUMB,110,110);
                    // resize_image(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_MEDIUM,262,207);
                    // resize_image(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_GALLERY_VIEW,750,500);
                    // resize_image(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_ZOOM_VIEW,1000,667);
                    // resize_image(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_THUMB,110,110);
                    copy(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_THUMB.'/'.$image_name);
                    crop(SPOT_GALLARY_THUMB.'/'.$image_name,110,110);

                    // resize_image(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_MEDIUM,262,207);
                    copy(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_MEDIUM.'/'.$image_name);
                    crop(SPOT_GALLARY_MEDIUM.'/'.$image_name,262,207);

                    // resize_image(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_GALLERY_VIEW,750,500);
                    copy(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_GALLERY_VIEW.'/'.$image_name);
                    crop(SPOT_GALLARY_GALLERY_VIEW.'/'.$image_name,750,500);
                    
                    // resize_image(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_ZOOM_VIEW,1000,667);
                    copy(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_ZOOM_VIEW.'/'.$image_name);
                    crop(SPOT_GALLARY_ZOOM_VIEW.'/'.$image_name,1000,667);
                } else {
                    $data['error'] = $image_name['errors'];
                }
            } 

            if(!isset($data['error'])){
                $insert_data['amenities'] = '';
                $insert_data = $this->input->post(null);
                $amenities =$this->input->post('amenities');
                if(count($amenities) > 0){
                    $insert_data['amenities'] = implode(',', $amenities);
                }
                $insert_data['is_delete'] = 0;
                $temp_where_get_cat = $this->input->post('category_id');
                $get_cat_for_slug = $this->admin_spots_model->get_result(TBL_CATEGORIES, 'id = '.$temp_where_get_cat);
                if($get_cat_for_slug){
                    $category_based_slug = $get_cat_for_slug[0]['slug'].'-spot-1';
                } else {
                    $category_based_slug = 'spot-1';
                }
                if($spot_id != ''){
                    $insert_data['slug'] = slug($insert_data['title'],TBL_SPOTS,$spot_id,$category_based_slug);
                    $this->admin_spots_model->update_record(TBL_SPOTS,'id = '.$spot_id,$insert_data);
                    $updated_spot_id = $spot_id;
                    $this->session->set_flashdata('success','Spot updated successfully!'); 
                } else {
                    $insert_data['spot_status'] = 1;
                    $insert_data['user_id'] = ($user_id != '') ? $user_id : $this->session->userdata('admin')['id'];
                    $insert_data['slug'] = slug($insert_data['title'],TBL_SPOTS,null,$category_based_slug);
                    $this->admin_spots_model->insert(TBL_SPOTS,$insert_data);
                    $updated_spot_id = $this->db->insert_id();
                    $this->session->set_flashdata('success','Spot added successfully!'); 
                }
                if($image_name != ''){
                    if($spot_id != ''){
                        $check_spot_image = $this->admin_spots_model->get_result(TBL_SPOT_IMAGES,'spot_id = '.$spot_id.' AND type = 1');
                        if(!empty($check_spot_image)){
                            $insert_data_cover = array(
                                'spot_image_name' => $image_name,
                            );
                            $this->admin_spots_model->update_record(TBL_SPOT_IMAGES,'spot_id = '.$spot_id.' AND type = 1',$insert_data_cover);
                            
                        } else {
                            $insert_data_cover = array(
                                'spot_image_name' => $image_name,
                                'spot_id' => $updated_spot_id,
                                'type' => 1
                            );
                            $this->admin_spots_model->insert(TBL_SPOT_IMAGES,$insert_data_cover);
                        }
                    } else {
                        $insert_data_cover = array(
                            'spot_image_name' => $image_name,
                            'spot_id' => $updated_spot_id,
                            'type' => 1
                        );
                        $this->admin_spots_model->insert(TBL_SPOT_IMAGES,$insert_data_cover);
                    }
                }
                if($spot_id != ''){
                    if($user_id != ''){
                        redirect('admin/users/spots/'.$user_id);
                    } else {
                        if($this->input->get('redirect') == 'new_request'){
                            redirect('admin/spots/new_requests');
                        } else {
                            redirect('admin/spots/active');
                        }
                    }
                } else {
                    if($user_id != ''){
                        echo json_encode(array('insert_id' => $updated_spot_id,'slug' => $insert_data['slug']));
                        exit;
                        // redirect('admin/spots/add_spot_gallary/'.$insert_data['slug'].'/'.$user_id);
                    } else {
                        echo json_encode(array('insert_id' => $updated_spot_id,'slug' => $insert_data['slug']));
                        exit;
                        // redirect('admin/spots/add_spot_gallary/'.$insert_data['slug']);
                    }
                }
            }
        }
        $this->template->load('admin','admin/spots/manage', $data);
    }

    /**
     * add_spot_gallary function
     * @uses this function in used to add spot gallery
     * @author KAP
     **/
    public function add_spot_gallary($slug, $user_id = null) {
        $data = array();
        $data['title'] = 'My Spot Gallery';
        $data['heading'] = 'My Spot Gallery';

        //--- check user id is valid or not
        if(is_numeric($user_id)){
            $where = 'id = '.$this->db->escape($user_id);
            $check_user = $this->admin_spots_model->get_result(TBL_USER,$where);
            if(empty($check_user)){
                show_404();
            } else {
                $data['user_id'] = $user_id;
            }
        }

        $where = 'slug = '.$this->db->escape($slug);
        $result = $this->admin_spots_model->get_result(TBL_SPOTS,$where);
        if($result){
            $data['slug'] = $slug;
            $this->template->load('admin', 'spots/add_spot_gallery', $data);
        } else {
            show_404();
        }
    }

    /**
     * upload_gallary function
     * @uses this function in used to upload spot gallary into folders and table
     * @author KAP
     **/
    public function upload_gallary($slug) {
        $where = 'slug = '.$this->db->escape($slug);
        $result = $this->admin_spots_model->get_result(TBL_SPOTS,$where);
        if($result){
            $_FILES['images']['name']= $_FILES['files']['name'][0];
            $_FILES['images']['type']= $_FILES['files']['type'][0];
            $_FILES['images']['tmp_name']= $_FILES['files']['tmp_name'][0];
            $_FILES['images']['error']= $_FILES['files']['error'][0];
            $_FILES['images']['size']= $_FILES['files']['size'][0];
            $image_name = upload_image('images',SPOT_GALLARY_ORIGINAL);
            if($image_name){
                // resize_image(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_THUMB,110,110);
                // resize_image(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_MEDIUM,262,207);
                // resize_image(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_GALLERY_VIEW,750,500);
                // resize_image(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_ZOOM_VIEW,1000,667);
                // resize_image(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_THUMB,110,110);
                copy(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_THUMB.'/'.$image_name);
                crop(SPOT_GALLARY_THUMB.'/'.$image_name,110,110);
                
                // resize_image(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_MEDIUM,262,207);
                copy(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_MEDIUM.'/'.$image_name);
                crop(SPOT_GALLARY_MEDIUM.'/'.$image_name,262,207);

                // resize_image(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_GALLERY_VIEW,750,500);
                copy(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_GALLERY_VIEW.'/'.$image_name);
                crop(SPOT_GALLARY_GALLERY_VIEW.'/'.$image_name,750,500);
                
                // resize_image(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_ZOOM_VIEW,1000,667);
                copy(SPOT_GALLARY_ORIGINAL.'/'.$image_name,SPOT_GALLARY_ZOOM_VIEW.'/'.$image_name);
                crop(SPOT_GALLARY_ZOOM_VIEW.'/'.$image_name,1000,667);
                $insert_data = array(
                    'spot_image_name' => $image_name,
                    'spot_id' => $result[0]['id'],
                    'type' => 2
                );
                $this->admin_spots_model->insert(TBL_SPOT_IMAGES,$insert_data);
                $_FILES['files']['url'] = SPOT_GALLARY_MEDIUM.'/'.$image_name;

                $info = new StdClass;
                $info->name = $image_name;
                $info->size = $_FILES['files']['size'][0];
                $info->type = $_FILES['files']['type'][0];
                $info->url = site_url() . SPOT_GALLARY_ORIGINAL . '/' . $image_name;
                $info->preview = SPOT_GALLARY_ORIGINAL . '/' . $image_name;
                $info->thumbnailUrl = SPOT_GALLARY_THUMB . '/' . $image_name;
                $info->deleteUrl = site_url() . 'admin/spots/delete_spot_gallery_image/'.$this->db->insert_id();
                $info->deleteType = 'DELETE';
                $info->error = null;
                $files[] = $info;
                echo json_encode(array("files" => $files));
                exit;
            }
        } else {
            show_404();
        }
    }

    /**
     * delete_spot_gallery_image function
     * @uses delete spot gallery image
     * @author KAP
     **/
    function delete_spot_gallery_image($id){
        $this->admin_spots_model->delete(TBL_SPOT_IMAGES,$id);
        $where = 'id = '.$this->db->escape($id);
        $result = $this->admin_spots_model->get_result(TBL_SPOT_IMAGES,$where);
        if($result){
            $image_name = $result[0]['spot_image_name'];
            unlink(SPOT_GALLARY_ORIGINAL.'/'.$image_name);
            unlink(SPOT_GALLARY_THUMB.'/'.$image_name);
            unlink(SPOT_GALLARY_MEDIUM.'/'.$image_name);
            unlink(SPOT_GALLARY_GALLERY_VIEW.'/'.$image_name);
            unlink(SPOT_GALLARY_ZOOM_VIEW.'/'.$image_name);
        }
    }

    /**
     * add_spot_gallary function
     * @uses this function in used to add spot gallary
     * @author KAP
     **/
    public function view_gallery($slug, $user_id = null) {
        $data = array();
        $data['title'] = 'My Spot Gallery';
        $data['heading'] = 'My Spot Gallery';

        if(is_numeric($user_id)){
            $where = 'id = '.$this->db->escape($user_id);
            $result = $this->admin_spots_model->get_result(TBL_USER,$where);
            if(empty($result)){
                show_404();
            } else {
                $data['user_id'] = $user_id;
            }
        }

        $where = 'slug = '.$this->db->escape($slug);
        $result = $this->admin_spots_model->get_result(TBL_SPOTS,$where);
        if($result){
            $data['slug'] = $slug;
            $this->template->load('admin', 'spots/view_spot_gallery', $data);
        } else {
            show_404();
        }
    }

    /**
     * add_spot_gallary function
     * @uses this function in used to add spot gallary
     * @author KAP
     **/
    public function get_my_gallery($slug) {
        $where = 'slug = '.$this->db->escape($slug);
        $result = $this->admin_spots_model->get_result(TBL_SPOTS,$where);
        if($result){
            $config['base_url'] = 'user/get_my_spots/';
            $config['page_query_string'] = TRUE;
            $config['per_page'] = 16;
            $config = array_merge($config, front_pagination());
            $page = $this->input->get_post('per_page');
            $where = 'spot_id ='.$result[0]['id'];
            $config['total_rows'] = $this->admin_spots_model->rows_of_table(TBL_SPOT_IMAGES,$where);
            $result = $this->admin_spots_model->get_my_spot_gallery($page,$config['per_page'],$where);
            $this->pagination->initialize($config);
            $pagination = $this->pagination->create_links();
            echo json_encode(array('result' => $result,'pagination' => $pagination));
        }
    }

    /**
     * get_states function
     * @uses this function in used to get states from the selected country
     * @return JSON data of states result
     * @author KAP
     **/
    public function get_states() {
        $country_id = $this->input->post('country_id');
        $where = 'country_id = '.$this->db->escape($country_id);
        echo json_encode($this->admin_spots_model->get_result('states',$where));
    }

    /**
     * get_cities function
     * @uses this function in used to get cities from the selected state
     * @return JSON data of cities result
     * @author KAP
     **/
    public function get_cities() {
        $state_id = $this->input->post('state_id');
        $where = 'state_id = '.$this->db->escape($state_id);
        echo json_encode($this->admin_spots_model->get_result('cities',$where));
    }
}
	