<?php

class Register extends CI_Controller
{
    protected $err;

	public function index()
	{
        $data = array();
        $data['err'] = '';
        $data['back'] = base_url();

        if ($this->input->method() == 'post') {

            if ($this->validate()) {
                $this->load->model('account/user_model');
                $this->user_model->addUser($this->input->post());
                $this->user->login($this->input->post('email'), $this->input->post('password'));
                redirect(base_url('home'));
            }

            $data = $this->input->post();
            $data['err'] = $this->err;
        }


        $this->load->view('layout/header', $data);
        $this->load->view('account/register', $data);
        $this->load->view('layout/footer');
	}

	public function validate()
	{
	    $this->load->model('account/user_model');


		if ((strlen($this->input->post('password')) < 4) || strlen($this->input->post('email')) > 96) {
            $this->err = 'Error: Email must be between 4 and 96 characters!';
		} elseif ($this->user_model->getUserByEmail($this->input->post('email'))) {
            $this->err = 'Error: E-Mail Address is already registered!';
		} elseif (strlen(trim($this->input->post('username'))) < 1 || strlen(trim($this->input->post('username'))) > 255) {
            $this->err = 'Error: Username must be between 1 and 255 characters!';
        } elseif ((strlen($this->input->post('password')) < 4) || strlen($this->input->post('password')) > 40) {
            $this->err = 'Error: Password must be between 4 and 20 characters!';
		} elseif ($this->input->post('password') !== $this->input->post('confirm')) {
            $this->err = 'Error: Your password do not matches!';
		}

		return !$this->err;
	}
}
