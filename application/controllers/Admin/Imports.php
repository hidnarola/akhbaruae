<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Imports extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/admin_users_model');
    }

    /**
     * spots function
     * @uses display view for upload spots file
     * @author KAP
     **/
    public function spots() {
        $data['title'] = 'Spotashoot - Admin users';
        $data['heading'] = 'Import Spots';
        $this->template->load('admin','admin/imports/manage', $data);
    }

    /**
     * upload_spots function
     * @uses upload spots CSV to database
     * @author KAP
     **/
    public function upload_spots() {
        $config['upload_path'] = IMPORT_SPOTS;
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '10000000';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            $this->upload->display_errors();
            $this->session->set_flashdata('error', $this->upload->display_errors());
        } else {
            $this->load->library('Csvimport');
            $filename = $this->upload->file_name;
            if ($this->csvimport->get_array(IMPORT_SPOTS . "/" . $filename)) {
                $csv_array = $this->csvimport->get_array(IMPORT_SPOTS . "/" . $filename);
            }
            $key = array("email", "first_name", "last_name", "address", "contact", "zipcode", "city_id", "state_id");
            $header = array("Email", "FirstName", "LastName", "Address", "PhoneNumber", "Zipcode", "City", "State");
            if ($csv_array) {
                p($csv_array,1);
                foreach ($csv_array as $row) {
                    // $data = array();
                    // for ($i = 0; $i < 8; $i++) {
                    //     $data[$key[$i]] = $row[$header[$i]];
                    // }
                    // $state = $this->common_model->getRowByCondition("state_name ='" . ($data['state_id']) . "'", "states");
                    // if ($state) {
                    //     $data['state_id'] = $state['id'];
                    // } else {
                    //     $state_data = array(
                    //       'state_name' => $data['state_id'],
                    //       'date_created' => date('Y-m-d H:i:s')
                    //     );
                    //     $this->common_model->add($state_data, 'states');
                    //     $state_id = $this->common_model->getLastInsertId("states");
                    //     $data['state_id'] = $state_id;
                    // }
                    // $city = $this->common_model->getRowByCondition("city_name ='" . ($data['city_id']) . "'", "cities");
                    // if ($city) {
                    //     $data['city_id'] = $city['id'];
                    // } else {
                    //     $city_data = array(
                    //       'city_name' => $data['city_id'],
                    //       'state_id' => $data['state_id'],
                    //       'date_created' => date('Y-m-d H:i:s')
                    //     );
                    //     $this->common_model->add($city_data, 'cities');
                    //     $city_id = $this->common_model->getLastInsertId("cities");
                    //     $data['city_id'] = $city_id;
                    // }
                    // $data['active'] = 1;
                    // $data['created'] = date('Y-m-d H:i:s');
                    // $data['user_group_id'] = default_group_id;
                    // $check_unique_email = $this->common_model->isUnique('email', $data['email'], 'users', "");
                    // if (!$check_unique_email) {
                    //     $this->common_model->add($data, 'users');
                    // }
                }
            }
            $this->session->set_flashdata('success', "Customers imported sucessfully.");
        }
    }
}
	