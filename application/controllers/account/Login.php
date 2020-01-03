<?php

class Login extends CI_Controller
{
	protected $err = '';
//	private $login_model;
//	private $input;
//	private $session;


	public function index()
	{
        $data['err'] = '';

        if ($this->input->method() == 'post') {

            if ($this->validate()) {
                $this->user->login($this->input->post('email'), $this->input->post('password'));
                redirect(base_url('home'));
            }

            $data = $this->input->post();
            $data['err'] = $this->err;
        }

        $this->load->view('layout/header');
        $this->load->view('account/login', $data);
        $this->load->view('layout/footer');
	}

//	public function apply()
//	{
//		$this->load->helper('url');
//		$this->load->library('form_validation');
//		$this->load->library('session');
//		$this->load->model('login_model');
//		$user = $this->validate();
////		$inp = $this->input;
//
//		if (($this->input->server('REQUEST_METHOD') == 'POST') && $user) {
//			if (password_verify($this->input->post('password'), $user['password'])) {
//				$this->session->username = $user['username'];
//				$this->session->id = $user['id'];
//				redirect(base_url('/home'));
//			}
//		} else {
//			$this->session->username = 'Guest';
//		}
//		$data['error'] = $this->error;
////		$this->load->view('pages/login');
////		$this->load->view('layout/header');
////		$this->load->view('pages/login', $data);
////		$this->load->view('layout/footer');
//		 redirect(base_url('/login'));
//	}

	public function validate()
	{
        $this->error = '';

        if (strlen($this->input->post('password')) < 4 || strlen($this->input->post('password')) > 40) {
            $this->err = 'Error: Password must be between 4 and 20 characters!';
        }

        elseif ((strlen($this->input->post('email')) > 96) || !filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
            $this->err = 'Error: E-Mail Address does not appear to be valid!';
        }

        elseif (!$this->user->login($this->input->post('email'), $this->input->post('password'))) {
            $this->err = 'Error: No match for Email and/or Password.';
        }

        return !$this->err;
	}


}
