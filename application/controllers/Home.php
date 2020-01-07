<?php

class Home extends CI_Controller
{
    public function index()
    {
        $data = array();

        $this->load->model('content/post_model');
        $this->load->library('pagination');

        $data['logged'] = $this->user->isLogged();
        $data['username'] = $this->user->getUsername();

        $data['login'] = base_url('account/login');
        $data['logout'] = base_url('account/logout');
        $data['register'] = base_url('account/register');
        $data['add_posts'] = base_url('content/post/add');

        $data['posts'] = $this->post_model->getPosts();
        $data['back'] = '';

        /** Pagination config */
        $config['base_url'] = base_url();
        $config['total_rows'] = $this->post_model->getTotalPosts();
        $config['per_page'] = 5;
        $config['query_string_segment'] = 'page';
        $config['page_query_string'] = true;
        $config['use_page_numbers'] = true;

        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();

        $options = array(
            'limit' => (int)$this->pagination->per_page,
            'offset' => (int)$this->input->get('page') ? $this->pagination->per_page * $this->input->get('page') - $this->pagination->per_page : 0
        );

        $data['posts'] = $this->post_model->getLimitedPosts($options);

         $this->load->view('layout/header', $data);
        $this->load->view('home', $data);
        $this->load->view('layout/footer', $data);
    }
}
