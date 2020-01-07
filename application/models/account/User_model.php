<?php

class User_model extends CI_Model
{
    public function addUser($data)
    {
//        $this->db->query("INSERT INTO `user` SET `username` = " . $this->db->escape($data['username']) . ", `email` = " . $this->db->escape($data['email']) . ", password = " . $this->db->escape(password_hash($data['password'], PASSWORD_DEFAULT)) . ", `date_added` = NOW()");
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        unset($data['confirm']);
        $this->db->insert('user', $data);
        return $this->db->insert_id();
    }

    public function getUserByEmail($email)
    {
//        $query = $this->db->query("SELECT * FROM `user` WHERE LOWER(email) = " . $this->db->escape(strtolower($email)));
        $query = $this->db
            ->where('LOWER(email)', strtolower($email))
            ->get('user');

        if ($query->num_rows()) {
            return $query->row();
        }

        return null;
    }

}
