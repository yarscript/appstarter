<?php

class Post extends CI_Controller
{
    protected $error = '';

    public function index()
    {
        $this->load->model('content/post_model');
        $this->load->model('content/comment_model');

        $data = (array)$this->post_model->getPost($this->input->get('id'));

        $data['logged'] = $this->user->isLogged();

        if ($this->input->method() == 'post' && $this->validateComment()) {

            $comment = $this->input->post();

            if (!isset($comment['parent_id'])) {
                $comment['parent_id'] = 0;
            }

            $comment['post_id'] = $this->input->get('id');
            $comment['user_id'] = $this->user->getId();
            $comment['author'] = $this->user->getUsername();

            $this->comment_model->addComment($comment);;
        }

        $data['comments'] = $this->comment_model->getCommentsByPostId($this->input->get('id'));

        $data['action'] = base_url('content/post') . '?id=' . $this->input->get('id');

        if ($this->error) {
            $data['error'] = $this->error;
        } else {
            $data['error'] = '';
        }

        $this->load->view('layout/header');
        $this->load->view('content/post', $data);
        $this->load->view('layout/footer');
    }

    public function add()
    {
        if (!$this->user->isLogged()) {
            redirect(base_url('account/login'));
        }

        $this->load->model('content/post_model');

        if ($this->input->method() == 'post' && $this->validate()) {
            $post = $this->input->post();
            $post['user_id'] = $this->user->getId();
            $this->post_model->addPost($post);
            redirect(base_url('home'));
        }

        if ($this->error) {
            $data['error'] = $this->error;
        } else {
            $data['error'] = '';
        }

        $data['action'] = base_url('content/post/add');

        if ($this->input->post('title')) {
            $data['title'] = $this->input->post('title');
        } else {
            $data['title'] = '';
        }

        if ($this->input->post('content')) {
            $data['content'] = $this->input->post('content');
        } else {
            $data['content'] = '';
        }

        $this->load->view('layout/header');
        $this->load->view('content/post_form', $data);
        $this->load->view('layout/footer');
    }

    public function insertAjax()
    {
//        $json = array();

        if ($this->input->method() == 'post' && $this->validateComment()) {
            $comment = $this->input->post() + $this->input->get();

            if(!isset($comment['parent_id'])) {
                $comment['parent_id'] = 0;
            }

            $comment['post_id'] = $this->input->get('id');
            $comment['user_id'] = $this->user->getId();
            $comment['author'] = $this->user->getUsername();

            $this->comment_model->addComment($comment);
        }

        $json = json_encode($comment);
        echo $json;
    }

    protected function validate()
    {
        if (strlen($this->input->post('title')) < 1 || strlen(trim($this->input->post('title'))) > 255) {
            $this->error = 'Error: Title must be between 1 and 255 characters!';
        } elseif (strlen($this->input->post('content')) < 3) {
            $this->error = 'Error: Topic must be more than 3 characters!';
        }

        return !$this->error;
    }

    protected function validateComment()
    {
        $this->error = '';

        if (strlen($this->input->post('text')) < 3) {
            $this->error = 'Error: Comment must be more than 3 characters!';
        }

        return !$this->error;
    }


}
