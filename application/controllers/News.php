<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

    public $commstr = '';

    public function __construct() {
        parent::__construct();
        $this->load->library('recaptcha');
        $this->load->model('News_model');
        $this->limit = 10;
    }

    public function index() {
        $filter_array = array();
        $posts['page'] = 1;
        $posts['limit'] = $this->limit;
        $posts['total_news'] = $this->News_model->filter_news($filter_array, 1);
        $posts['posts'] = $this->News_model->filter_news($filter_array, 0, 0, $this->limit);
        if(count($posts['posts']) > 0){
            $news_list_html = $this->load->view('News/list_block', $posts, true);
        } else {
            $news_list_html = $this->load->view('Templates/no_results', array(), true);
        }
        $data['main_post'] = ( count($posts['posts']) > 0) ? $posts['posts'][0] : array();
        $data['news_list_html'] = $news_list_html;
        $this->template->load('default', 'News/list', $data);
    }
    
    public function more_news($page = 0, $limit = '') {
        $filter_array = array();
        $page = (int)$page;
        $start = ($page == 0) ? 0 : (int)($page - 1);
        $limit = ($limit != '') ? (int)$limit : (int)$this->limit;
        if( is_int($start) && $start >= 0 && is_int($limit) && $limit > 0 ){
            $posts['page'] = $page;
            $posts['limit'] = $limit;
            $posts['total_news'] = $this->News_model->filter_news($filter_array, 1);
            $posts['posts'] = $this->News_model->filter_news($filter_array, 0, $start, $limit);
            if(count($posts['posts']) > 0){
                $news_list_html = $this->load->view('News/list_block', $posts, true);
            } else {
                $news_list_html = $this->load->view('Templates/no_results', array(), true);
            }
            $return_array = array(
                'success' => 1,
                'html' => $news_list_html
            );
        } else {
            $return_array = array(
                'success' => 0,
                'html' => 'Invalid argument. Only integer value allowed.'
            );
        }
        echo json_encode($return_array);
        
    }

    public function detail($id) {
        $posts = $this->News_model->get_news($id);
        if (count($posts) == 1) {
            $data['post'] = $posts[0];
            $data['title'] = $posts[0]['title'];
            $post_comments = $this->News_model->get_commnets($posts[0]['id']);
            $data['commArr'] = $this->get_replies(0, $post_comments);
            $data['script'] = $this->recaptcha->getScriptTag();
            $data['comment_widget'] = $this->recaptcha->getWidget(array('id'=>'comment_widget'));
            $data['reply_widget'] = $this->recaptcha->getWidget(array('id'=>'reply_widget'));
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
        $this->form_validation->set_rules('txt_author_comment', 'Comment', 'trim|required');
        $recaptcha = $this->input->post('g-recaptcha-response');
        if ($this->form_validation->run() == FALSE || empty($recaptcha)){
            $this->template->load('default', 'Home/detail', $data);
            redirect('news/'.$id);
        }else{
            $response = $this->recaptcha->verifyResponse($recaptcha);
            if (isset($response['success']) && $response['success'] === true) {
                if($this->input->post('hidden_post_id')!='')
                    $rootID = $this->input->post('hidden_post_id');
                else
                    $rootID = 0;
                $insertArr = array(
                    'news_id' => $id,
                    'author_name' => $this->input->post('txt_author_name'),
                    'author_email' => $this->input->post('txt_author_email'),
                    'author_website' => $this->input->post('txt_author_website'),
                    'author_comment' => $this->input->post('txt_author_comment'),
                    'rootID' => $rootID
                );
                common_insert_update('insert','comments',$insertArr);
                redirect('news/'.$id);
            } else {
                redirect('news/');
            }
        }
    }

}
