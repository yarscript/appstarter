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

        $data['action'] = base_url('content/post/insertAjax') . '?id=' . $this->input->get('id');
        $data['show_comments'] = base_url('content/post/showComments') . '?id=' . $this->input->get('id');
        $data['back'] = base_url();

        if ($this->error) {
            $data['error'] = $this->error;
        } else {
            $data['error'] = '';
        }

        $this->load->view('layout/header', $data);
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
        $data['back'] = base_url();

        $this->load->view('layout/header', $data);
        $this->load->view('content/post_form', $data);
        $this->load->view('layout/footer');
    }

    public function insertAjax()
    {
        $this->load->model('content/post_model');
        $this->load->model('content/comment_model');

        $comment = array();

        if ($this->input->method() == 'post' && $this->validateComment()) {

            $comment['parent_id'] = 0;

            if (isset(($this->input->get())['parent_id'])) {
                $comment['parent_id'] = $this->input->get('parent_id');
            }

            $comment['text'] = $this->input->post('text');
            $comment['post_id'] = $this->input->get('id');
            $comment['user_id'] = $this->user->getId();
            $comment['author'] = $this->user->getUsername();

            $res = $this->comment_model->addComment($comment);

            $json = $comment;
            $json['comment_id'] = $res;
            $json['date_added'] = date('Y-m-d H:i:s');
            echo json_encode($json);
        }

    }

    public function showComments()
    {
        $this->load->model('content/post_model');
        $this->load->model('content/comment_model');

        $comments = (array)$this->comment_model->getCommentsByPostId($this->input->get('id'));

        $data = $this->commentSort($comments);
        echo json_encode($data);
    }

    protected function commentSort($comments, $parent_id = 0)
    {
        $answers = array();
        foreach ($comments as $comment1) {
            if ($comment1['parent_id'] == $parent_id) {
                if ($comment1['answers'] = $this->commentSort($comments, $comment1['id'])) {
                    $answers[] = $comment1;
                } else {
                    array_push($answers, $comment1);
                }
            }
        }
        return $answers;
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

    protected function setCommentValidation()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validate->set_rules('text', 'Comment',
            'required|min_length[3]',
            array(
                'required' => 'You have not provided %s',
                'min_length' => '%s must be more 3 characters!'
            )
        );
    }

}
