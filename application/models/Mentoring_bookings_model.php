<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mentoring_bookings_model extends CI_Model {

    public function get_by_user($user_id, $limit = 20) {
        $this->db->select('mentoring_bookings.*, mentors.title, users.name as mentor_name, users.avatar as mentor_avatar');
        $this->db->from('mentoring_bookings');
        $this->db->join('mentors', 'mentors.id = mentoring_bookings.mentor_id');
        $this->db->join('users', 'users.id = mentors.user_id');
        $this->db->where('mentoring_bookings.user_id', $user_id);
        $this->db->order_by('mentoring_bookings.scheduled_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    public function get_by_mentor($mentor_id, $limit = 20) {
        $this->db->select('mentoring_bookings.*, users.name as user_name, users.avatar as user_avatar');
        $this->db->from('mentoring_bookings');
        $this->db->join('users', 'users.id = mentoring_bookings.user_id');
        $this->db->where('mentoring_bookings.mentor_id', $mentor_id);
        $this->db->order_by('mentoring_bookings.scheduled_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        $this->db->select('mentoring_bookings.*, mentors.title, mentors.price_per_session, users.name as mentor_name, users.avatar as mentor_avatar, users.email as mentor_email');
        $this->db->from('mentoring_bookings');
        $this->db->join('mentors', 'mentors.id = mentoring_bookings.mentor_id');
        $this->db->join('users', 'users.id = mentors.user_id');
        $this->db->where('mentoring_bookings.id', $id);
        return $this->db->get()->row();
    }

    public function get_upcoming_by_user($user_id) {
        $this->db->select('mentoring_bookings.*, mentors.title, users.name as mentor_name, users.avatar as mentor_avatar');
        $this->db->from('mentoring_bookings');
        $this->db->join('mentors', 'mentors.id = mentoring_bookings.mentor_id');
        $this->db->join('users', 'users.id = mentors.user_id');
        $this->db->where('mentoring_bookings.user_id', $user_id);
        $this->db->where('mentoring_bookings.scheduled_at >', date('Y-m-d H:i:s'));
        $this->db->where_in('mentoring_bookings.status', array('pending', 'confirmed'));
        $this->db->order_by('mentoring_bookings.scheduled_at', 'ASC');
        return $this->db->get()->result();
    }

    public function get_upcoming_by_mentor($mentor_id) {
        $this->db->select('mentoring_bookings.*, users.name as user_name, users.avatar as user_avatar');
        $this->db->from('mentoring_bookings');
        $this->db->join('users', 'users.id = mentoring_bookings.user_id');
        $this->db->where('mentoring_bookings.mentor_id', $mentor_id);
        $this->db->where('mentoring_bookings.scheduled_at >', date('Y-m-d H:i:s'));
        $this->db->where_in('mentoring_bookings.status', array('pending', 'confirmed'));
        $this->db->order_by('mentoring_bookings.scheduled_at', 'ASC');
        return $this->db->get()->result();
    }

    public function create($data) {
        $this->db->insert('mentoring_bookings', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('mentoring_bookings', $data);
    }

    public function count_by_user($user_id, $status = null) {
        $this->db->where('user_id', $user_id);
        if ($status) $this->db->where('status', $status);
        return $this->db->count_all_results('mentoring_bookings');
    }

    public function count_by_mentor($mentor_id, $status = null) {
        $this->db->where('mentor_id', $mentor_id);
        if ($status) $this->db->where('status', $status);
        return $this->db->count_all_results('mentoring_bookings');
    }
}
