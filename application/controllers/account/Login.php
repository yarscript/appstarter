<?php

class Login extends CI_Controller
{
    protected $error = '';

    public function index()
    {
        if ($this->input->method() == 'post' && $this->validate()) {
                redirect(base_url());
        }

        if ($this->error) {
            $data['error'] = $this->error;
        } else {
            $data['error'] = '';
        }

        if ($this->input->post('email')) {
            $data['email'] = $this->input->post('email');
        } else {
            $data['email'] = '';
        }

        if ($this->input->post('password')) {
            $data['password'] = $this->input->post('password');
        } else {
            $data['password'] = '';
        }

        $data['action'] = base_url('account/login');

        $this->load->view('layout/header');
        $this->load->view('account/login', $data);
        $this->load->view('layout/footer');
    }

    public function validate()
    {
        $this->error = '';
        if (strlen($this->input->post('password')) < 4 || strlen($this->input->post('password')) > 40) {
            $this->error = 'Error: Password must be between 4 and 20 characters!';
        }
        elseif ((strlen($this->input->post('email')) > 96) || !filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
            $this->error = 'Error: E-Mail Address does not appear to be valid!';
        }
        elseif (!$this->user->login($this->input->post('email'), $this->input->post('password'))) {
            $this->error = 'Error: No match for Email and/or Password.';
        }
        return !$this->error;
    }
}
