<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discussion_model extends CI_Model {

    public function get_discussions($course_id) {
        $this->db->select('discussions.*, users.name as user_name, users.avatar,
            (SELECT COUNT(*) FROM discussion_replies WHERE discussion_id = discussions.id) as reply_count');
        $this->db->from('discussions');
        $this->db->join('users', 'users.id = discussions.user_id');
        $this->db->where('discussions.course_id', $course_id);
        $this->db->order_by('discussions.is_pinned', 'DESC');
        $this->db->order_by('discussions.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_discussion_by_id($id) {
        $this->db->select('discussions.*, users.name as user_name, users.avatar');
        $this->db->from('discussions');
        $this->db->join('users', 'users.id = discussions.user_id');
        $this->db->where('discussions.id', $id);
        return $this->db->get()->row();
    }

    public function create_discussion($data) {
        $this->db->insert('discussions', $data);
        return $this->db->insert_id();
    }

    public function get_replies($discussion_id) {
        $this->db->select('discussion_replies.*, users.name as user_name, users.avatar');
        $this->db->from('discussion_replies');
        $this->db->join('users', 'users.id = discussion_replies.user_id');
        $this->db->where('discussion_replies.discussion_id', $discussion_id);
        $this->db->order_by('discussion_replies.is_best_answer', 'DESC');
        $this->db->order_by('discussion_replies.created_at', 'ASC');
        return $this->db->get()->result();
    }

    public function create_reply($data) {
        return $this->db->insert('discussion_replies', $data);
    }

    public function mark_best_answer($reply_id, $discussion_id) {
        $this->db->where('discussion_id', $discussion_id)->set('is_best_answer', 0)->update('discussion_replies');
        $this->db->where('id', $reply_id)->set('is_best_answer', 1)->update('discussion_replies');
    }
}
