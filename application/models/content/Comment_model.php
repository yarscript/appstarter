<?php

class Comment_model extends CI_Model
{
    public function addComment($data)
    {
        $data['date_added'] = date('Y-m-d H:i:s');
        $this->db->insert('comment', $data);
        return $this->db->insert_id();
    }

    public function getComment($id)
    {
        $query = $this->db->where('id', $id)->get('comment');
        return $query->row();
    }

    public function getCommentsByPostId($post_id)
    {
        $query = $this->db->where('post_id', $post_id)->get('comment');

        return $query->result_array();
    }

    public function getTotalComments()
    {
        $query = $this->select('COUNT(*)')->get('comment');
        return $query->row('total');
    }
}
