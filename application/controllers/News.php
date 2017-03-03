<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

    public $commstr = '';

    public function __construct() {
        parent::__construct();
        $this->load->model('News_model');
    }

    public function index() {
        $data['posts'] = $posts = $this->News_model->get_news();
        $this->template->load('default', 'Home/test', $data);
    }

    public function detail($id) {
        $posts = $this->News_model->get_news($id);
        if (count($posts) == 1) {
            $data['post'] = $posts[0];
            $post_comments = get_all_details('comments',array('news_id'=>$posts[0]['id']))->result_array();
            $data['commArr'] = $this->get_replies(0, $post_comments);
            // pr($data['commArr'],1);
            // echo $this->commstr; die;
            $this->template->load('default', 'Home/detail', $data);
        } else {
            redirect('/');
        }
    }

    public function get_replies($rootID, $comments){
        $reply_arr = array();
        foreach ($comments as $comment) {
            if($comment['rootID'] == $rootID){
                $comment['replies'] = $this->get_replies($comment['id'], $comments);
                $reply_arr[] = $comment;
            }
        }
        return $reply_arr;
    }
    /**
     * This function is used to add new comments for particular news
     * @params : $id -> integer
     * @return
     * @author : pav
    */
    public function add_comment($id){
        $posts = $this->News_model->get_news($id);
        $data['post'] = $posts[0];
        $this->form_validation->set_error_delimiters('<span class="custom_error_msg_style">', '</span>');
        $this->form_validation->set_rules('txt_author_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('txt_author_email', 'Email', 'trim|required|valid_email');
        if ($this->form_validation->run() == FALSE){
            $this->template->load('default', 'Home/detail', $data);
        }else{
            $insertArr = array(
                'news_id' => $id,
                'author_name' => $this->input->post('txt_author_name'),
                'author_email' => $this->input->post('txt_author_email'),
                'author_website' => $this->input->post('txt_author_website'),
                'author_comment' => $this->input->post('txt_author_comment'),
                'rootID' => '1'
            );
            common_insert_update('insert','comments',$insertArr);
        }
        redirect('news/'.$id);
    }

}
