<?php

class User_model extends CI_Model
{
    public function addUser($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        unset($data['confirm']);
        $this->db->insert('user', $data);
        return $this->db->insert_id();
    }

    public function getUserByEmail($email)
    {
        $query = $this->db
            ->where('email', $email)
            ->get('user');

        if ($query->num_rows()) {
            return $query->row();
        }

        return null;
    }

}
