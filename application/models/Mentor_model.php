<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mentor_model extends CI_Model {

    public function get_all($category_id = null, $search = '') {
        $this->db->select('mentors.*, users.name, users.email, users.avatar, users.phone');
        $this->db->from('mentors');
        $this->db->join('users', 'users.id = mentors.user_id');
        $this->db->where('mentors.is_active', 1);
        $this->db->where('users.status', 'active');
        if ($category_id) {
            $this->db->join('mentor_category_pivot', 'mentor_category_pivot.mentor_id = mentors.id');
            $this->db->where('mentor_category_pivot.category_id', $category_id);
        }
        if ($search) {
            $this->db->group_start();
            $this->db->like('users.name', $search);
            $this->db->or_like('mentors.title', $search);
            $this->db->or_like('mentors.title_en', $search);
            $this->db->or_like('mentors.bio', $search);
            $this->db->group_end();
        }
        $this->db->order_by('mentors.total_reviews', 'DESC');
        $this->db->order_by('mentors.avg_rating', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Mentor unggulan utk landing page — top N berdasarkan rating & jumlah review.
     * Sudah termasuk kategori (dipakai utk badge di kartu).
     */
    public function get_top_mentors($limit = 4) {
        $this->db->select('mentors.*, users.name, users.email, users.avatar, users.phone');
        $this->db->from('mentors');
        $this->db->join('users', 'users.id = mentors.user_id');
        $this->db->where('mentors.is_active', 1);
        $this->db->where('users.status', 'active');
        $this->db->order_by('mentors.avg_rating', 'DESC');
        $this->db->order_by('mentors.total_reviews', 'DESC');
        $this->db->limit($limit);
        $mentors = $this->db->get()->result();

        foreach ($mentors as $m) {
            $m->categories = $this->get_categories($m->id);
        }
        return $mentors;
    }

    public function get_by_id($id) {
        $this->db->select('mentors.*, users.name, users.email, users.avatar, users.phone');
        $this->db->from('mentors');
        $this->db->join('users', 'users.id = mentors.user_id');
        $this->db->where('mentors.id', $id);
        return $this->db->get()->row();
    }

    public function get_by_user_id($user_id) {
        return $this->db->get_where('mentors', array('user_id' => $user_id))->row();
    }

    public function get_categories($mentor_id) {
        $this->db->select('mentor_categories.*');
        $this->db->from('mentor_category_pivot');
        $this->db->join('mentor_categories', 'mentor_categories.id = mentor_category_pivot.category_id');
        $this->db->where('mentor_category_pivot.mentor_id', $mentor_id);
        return $this->db->get()->result();
    }

    public function create($data) {
        $this->db->insert('mentors', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('mentors', $data);
    }

    public function set_categories($mentor_id, $category_ids) {
        $this->db->where('mentor_id', $mentor_id)->delete('mentor_category_pivot');
        foreach ($category_ids as $cat_id) {
            $this->db->insert('mentor_category_pivot', array('mentor_id' => $mentor_id, 'category_id' => $cat_id));
        }
    }

    public function update_rating($mentor_id) {
        $rating = $this->db
            ->select('AVG(rating) as avg_rating, COUNT(*) as total_reviews')
            ->from('mentor_reviews')
            ->where('mentor_id', $mentor_id)
            ->get()->row();
        $sessions = $this->db
            ->where('mentor_id', $mentor_id)
            ->where('status', 'completed')
            ->count_all_results('mentoring_bookings');
        $this->db->where('id', $mentor_id)->update('mentors', array(
            'avg_rating' => round($rating->avg_rating ?? 0, 1),
            'total_reviews' => $rating->total_reviews ?? 0,
            'total_sessions' => $sessions,
        ));
    }

    public function is_favorited($user_id, $mentor_id) {
        return $this->db->where('user_id', $user_id)->where('mentor_id', $mentor_id)->count_all_results('mentor_favorites') > 0;
    }

    public function toggle_favorite($user_id, $mentor_id) {
        if ($this->is_favorited($user_id, $mentor_id)) {
            $this->db->where('user_id', $user_id)->where('mentor_id', $mentor_id)->delete('mentor_favorites');
            return false;
        } else {
            $this->db->insert('mentor_favorites', array('user_id' => $user_id, 'mentor_id' => $mentor_id));
            return true;
        }
    }
}
