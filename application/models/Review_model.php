<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review_model extends CI_Model {

    public function get_reviews($course_id) {
        $this->db->select('reviews.*, users.name as user_name, users.avatar');
        $this->db->from('reviews');
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->where('reviews.course_id', $course_id);
        $this->db->order_by('reviews.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_user_review($user_id, $course_id) {
        return $this->db->get_where('reviews', array('user_id' => $user_id, 'course_id' => $course_id))->row();
    }

    public function create_review($data) {
        return $this->db->insert('reviews', $data);
    }

    public function update_review($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('reviews', $data);
    }

    public function get_average_rating($course_id) {
        $this->db->select_avg('rating');
        $result = $this->db->get_where('reviews', array('course_id' => $course_id))->row();
        return round($result->rating ?? 0, 1);
    }

    public function get_rating_counts($course_id) {
        $result = array(1=>0, 2=>0, 3=>0, 4=>0, 5=>0);
        $rows = $this->db->select('rating, COUNT(*) as count')
                        ->where('course_id', $course_id)
                        ->group_by('rating')
                        ->get('reviews')->result();
        foreach ($rows as $row) {
            $result[(int)$row->rating] = (int)$row->count;
        }
        return $result;
    }

    public function get_review_count($course_id) {
        return $this->db->where('course_id', $course_id)->from('reviews')->count_all_results();
    }
}
