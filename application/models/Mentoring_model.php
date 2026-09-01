<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mentoring_model extends CI_Model {

    public function get_mentors() {
        return $this->db->get_where('users', array('is_mentor' => 1))->result();
    }

    public function get_mentor_sessions($mentor_id) {
        $this->db->select('mentoring_sessions.*, users.name as student_name, users.avatar as student_avatar');
        $this->db->from('mentoring_sessions');
        $this->db->join('users', 'users.id = mentoring_sessions.student_id');
        $this->db->where('mentoring_sessions.mentor_id', $mentor_id);
        $this->db->order_by('mentoring_sessions.scheduled_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_student_sessions($student_id) {
        $this->db->select('mentoring_sessions.*, users.name as mentor_name, users.avatar as mentor_avatar');
        $this->db->from('mentoring_sessions');
        $this->db->join('users', 'users.id = mentoring_sessions.mentor_id');
        $this->db->where('mentoring_sessions.student_id', $student_id);
        $this->db->order_by('mentoring_sessions.scheduled_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_session_by_id($id) {
        return $this->db->get_where('mentoring_sessions', array('id' => $id))->row();
    }

    public function create_session($data) {
        $this->db->insert('mentoring_sessions', $data);
        return $this->db->insert_id();
    }

    public function update_session($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('mentoring_sessions', $data);
    }

    public function get_all_sessions() {
        // Sistem mentoring AKTIF: tabel mentoring_bookings (join users + mentors)
        $this->db->select('mentoring_bookings.*, student.name as student_name, student.avatar as student_avatar, mentor_user.name as mentor_name, mentor_user.avatar as mentor_avatar, mentors.title as course_title');
        $this->db->from('mentoring_bookings');
        $this->db->join('users as student', 'student.id = mentoring_bookings.user_id');
        $this->db->join('mentors', 'mentors.id = mentoring_bookings.mentor_id');
        $this->db->join('users as mentor_user', 'mentor_user.id = mentors.user_id');
        $this->db->order_by('mentoring_bookings.scheduled_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_available_mentors($course_id = null) {
        $this->db->select('users.id, users.name, users.email, users.avatar, users.bio');
        $this->db->from('users');
        $this->db->where('users.is_mentor', 1);
        return $this->db->get()->result();
    }
}
