<?php

class User extends CI_Model
{
    protected $id = 0;
    protected $username = 'Guest';
    protected $role = 'user';

	public function __construct()
	{
        if (isset($this->session->user_id)) {
            $this->id = $this->session->user_id;
            $this->username = $this->session->user_username;
            $this->role = $this->session->user_role;
        }
	}

    public function getUserByEmail($email)
    {
        $query = $this->db->query("SELECT * FROM `user` WHERE LOWER(email) = " . $this->db->escape(strtolower($email)));

        if ($query->num_rows()) {
            return $query->result();
        }

        return null;
    }

    public function addUser($data)
    {
        $this->db->query("INSERT INTO `user` SET `username` = " . $this->db->escape($data['username']) . ", `email` = " . $this->db->escape($data['email']) . ", password = " . $this->db->escape(password_hash($data['password'], PASSWORD_DEFAULT)) . ", `date_added` = NOW()");

        return $this->db->insert_id();
    }

    public function login($email, $password)
    {
        $query = $this->db->query("SELECT * FROM `user` WHERE LOWER(email) = " . $this->db->escape(strtolower($email)));

        if ($query->num_rows()) {

            $row = $query->row();

            if (password_verify($password, $row->password)) {
                if (password_needs_rehash($row->password, PASSWORD_DEFAULT)) {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                }
            } else {
                $this->logout();
                return false;
            }

            $this->id = $this->session->user_id = $row->id;
            $this->username = $this->session->user_username = $row->username;
            $this->role = $this->session->user_role = $row->role;

            if (isset($hash)) {
                $this->db->query("UPDATE `user` SET  password = " . $this->db->escape($hash) . " WHERE `id` = '" . (int)$this->id . "'");
            }

            return true;
        }

        $this->logout();
        return false;
    }

    public function logout()
    {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_username');
        $this->session->unset_userdata('user_role');

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
