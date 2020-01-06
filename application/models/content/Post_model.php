<?php

class Post_model extends CI_Model
{
    public function addPost($data)
    {
        $this->db->query("INSERT INTO `post` SET `user_id` = '" . (int) $data['user_id']. "', `title` = " . $this->db->escape($data['title']) . ", content = " . $this->db->escape($data['content']) . ",  `date_added` = NOW()");

        return $this->db->insert_id();
    }

    public function getPost($id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM `post` WHERE id = '" . (int)$id . "'");

        return $query->row();
    }

    public function getPosts()
    {
        $sql = 'SELECT * FROM `post`';

        $query = $this->db->query($sql);

        return $query->result();
    }

    public function getTotalPosts()
    {
        $sql = "SELECT COUNT(*) AS total FROM `post`";

        $query = $this->db->query($sql);

        return $query->row('total');
    }

    public function getLimitedPosts ($options = array())
    {

        $sql = 'SELECT `post`.*, (SELECT DISTINCT `user`.`username` FROM `user` WHERE `user`.`id`=`post`.`user_id`) as author FROM `post` ORDER BY `post`.`date_added` DESC';

        if (isset($options['offset'], $options['limit'])) {
            $sql .= " LIMIT " . (int)$options['limit'] . " OFFSET " . (int)$options['offset'];
        }

        $query = $this->db->query($sql);

        return $query->result();
////        $sql = '';
////        $sql = "SELECT * FROM `post` WHERE id BETWEEN '" . (int)$from . "' AND '" . (int)$to . "'";
//        $sql = "SELECT * FROM `post` ORDER BY id DESC LIMIT '" . (int)$options['limit'] . "'";
//        if (isset($options['limit'], $options['offset']) && $options['offset']) {
////            $sql .= " LIMIT " . (int)$options['limit'] . " OFFSET " . (int)$options['offset'];
//            $sql = "SELECT * FROM `post` ORDER BY id DESC LIMIT '" . $options['limit'] . "' OFFSET '" . $options['offset'] . "'";
//
//        }


//        $query = $this->db->query($sql);
//
//        return $query->result();
    }
}
