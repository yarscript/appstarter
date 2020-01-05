<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User
{
    protected $id = 0;
    protected $username = 'Guest';
    protected $role = 'user';

    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();

        if (isset($this->CI->session->user_id)) {
            $this->id = $this->CI->session->user_id;
            $this->username = $this->CI->session->user_username;
            $this->role = $this->CI->session->user_role;
        }
    }

    public function login($email, $password)
    {
        $this->CI->load->model('account/user_model');

        if($row = $this->CI->user_model->getUserByEmail($email)){
            if (password_verify($password, $row->password)) {
                if (password_needs_rehash($row->password, PASSWORD_DEFAULT)) {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                }
            } else {
                $this->logout();
                return false;
            }

            $this->id = $this->CI->session->user_id = $row->id;
            $this->username = $this->CI->session->user_username = $row->username;
            $this->role = $this->CI->session->user_role = $row->role;

            if (isset($hash)) {
                $this->CI->user_model->editPassword($row->id, $hash);
            }

            return true;
        }

        $this->logout();
        return false;
    }

    public function logout()
    {
        $this->CI->session->unset_userdata('user_id');
        $this->CI->session->unset_userdata('user_username');
        $this->CI->session->unset_userdata('user_role');

        $this->id = 0;
        $this->username = 'Guest';
        $this->role = 'user';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function isLogged()
    {
        return (bool)$this->id;
    }
}
