<?php

class User_model extends CI_Model
{
    public function addUser($data)
    {
        $this->db->query("INSERT INTO `user` SET `username` = " . $this->db->escape($data['username']) . ", `email` = " . $this->db->escape($data['email']) . ", password = " . $this->db->escape(password_hash($data['password'], PASSWORD_DEFAULT)) . ", `date_added` = NOW()");

        return $this->db->insert_id();
    }

    public function getUserByEmail($email)
    {
        $query = $this->db->query("SELECT * FROM `user` WHERE LOWER(email) = " . $this->db->escape(strtolower($email)));

        if ($query->num_rows()) {
            return $query->row();
        }

        return null;
    }

}
