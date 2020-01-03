<?php

class Home extends CI_Controller
{
	public function index()
	{
		$data = [];

        $data['logged'] = $this->user->isLogged();
        $data['username'] = $this->user->getUsername();

		$this->load->view('layout/header', $data);
		$this->load->view('home', $data);
		$this->load->view('layout/footer', $data);
	}
}
