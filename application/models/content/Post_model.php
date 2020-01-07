<?php

class Post_model extends CI_Model
{
    public function addPost($data)
    {
        $data['date_added'] = date('Y-m-d H:i:s');
        $this->db->insert('post', $data);
        return $this->db->insert_id();
    }

    public function getPost($id)
    {
        $query = $this->db->distinct('*')->where('id', (int)$id)->get('post');
        return $query->row();
    }

    public function getPosts()
    {
        $query = $this->db->get('post');
        return $query->result();
    }

    public function getTotalPosts()
    {
        $query = $this->db->select('COUNT(*) AS total')->get('post');
        return $query->row('total');
    }

    public function getLimitedPosts($options = array())
    {
        $this->db->select("post.*, user.username as author")->join('user', 'user.id=post.user_id')->order_by('post.date_added desc');
        if (isset($options['offset'], $options['limit'])) {
            $this->db->limit((int)$options['limit'], (int)$options['offset']);
        }

        $result = $this->db->get('post')->result();

        return $result;
    }
}
