<?php

class Home extends CI_Controller
{
	public function index()
	{
		$data = array();

        $this->load->model('content/post_model');

        $data['logged'] = $this->user->isLogged();
        $data['username'] = $this->user->getUsername();

        $data['login'] = base_url('account/login');
        $data['logout'] = base_url('account/logout');
        $data['register'] = base_url('account/register');
        $data['add_posts'] = base_url('content/post/add');

        $data['posts'] = $this->post_model->getPosts();
        $data['back'] = '';

		$this->load->view('layout/header', $data);
		$this->load->view('home', $data);
		$this->load->view('layout/footer', $data);
	}
}
