<?php

class Login extends CI_Controller
{
    protected $error = '';

    public function index()
    {

        $data['action'] = base_url('account/login/insertAjax');
        $data['back'] = base_url();
        $data['header_register'] = base_url('account/register');
        $data['header_login'] = '';

        $this->load->view('layout/header', $data);
        $this->load->view('account/login', $data);
        $this->load->view('layout/footer');
    }

    public function insertAjax()
    {
        $data['error'] = '';

        $this->setFormValidation();

        if ($this->form_validation->run() === true) {
            if ($this->user->login($this->input->post('email'), $this->input->post('password'))) {
                $data['location'] = base_url();
            } else {
                $data['error'] = 'No match for Email and/or Password!';
            }
        } else {
            $data['error'] = validation_errors();
        }

        echo json_encode($data);
    }

    protected function setFormValidation()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email',
            'trim|required|valid_email|max_length[96]',
            array(
                'required' => 'You have not provided %s.',
                'valid_email' => '%s does not appear to be valid.',
                'max_length' => '%s must be less than 96 characters.'
            )
        );
        $this->form_validation->set_rules('password', 'Password',
            'trim|required|min_length[4]|max_length[64]',
            array(
                'required' => 'You have not provided %s.',
                'min_length' => '%s must be more than 4 characters.',
                'max_length' => '%s must be less than 64 characters.'
            )
        );
    }

}
