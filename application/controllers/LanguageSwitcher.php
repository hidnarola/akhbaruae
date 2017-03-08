<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class LanguageSwitcher extends CI_Controller
{
    function switchLang($language = "") {
        $language = ($language != "") ? $language : "arabic";
        if($this->input->server('REQUEST_METHOD') == 'POST') {
            $lang = $this->input->post('lang');
            $language = ($lang != "") ? $lang : "english";
        }
        $this->session->set_userdata('site_lang', $language);
        $return_array = array(
            'success' => 1
        );
        echo json_encode($return_array);
    }
}