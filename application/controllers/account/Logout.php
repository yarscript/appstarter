<?php

class Logout extends CI_Controller
{
	public function index()
	{
        $this->user->logout();
		redirect(base_url());
	}
}
