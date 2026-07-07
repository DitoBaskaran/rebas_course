<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seminar_model extends CI_Model {

    public function get_seminars() {
        $this->db->select('seminars.*, users.name as speaker_name');
        $this->db->from('seminars');
        $this->db->join('users', 'users.id = seminars.speaker_id');
        $this->db->order_by('seminars.date_time', 'ASC');
        return $this->db->get()->result();
    }

    public function get_seminar_by_id($id) {
        $this->db->select('seminars.*, users.name as speaker_name');
        $this->db->from('seminars');
        $this->db->join('users', 'users.id = seminars.speaker_id');
        $this->db->where('seminars.id', $id);
        return $this->db->get()->row();
    }

    public function create_seminar($data) {
        $this->db->insert('seminars', $data);
        return $this->db->insert_id();
    }

    public function update_seminar($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('seminars', $data);
    }

    public function delete_seminar($id) {
        $this->db->where('id', $id);
        return $this->db->delete('seminars');
    }

    public function check_registration($user_id, $seminar_id) {
        $query = $this->db->get_where('seminar_registrations', array('user_id' => $user_id, 'seminar_id' => $seminar_id));
        return $query->num_rows() > 0;
    }

    public function register_user($user_id, $seminar_id) {
        $data = array(
            'user_id' => $user_id,
            'seminar_id' => $seminar_id
        );
        return $this->db->insert('seminar_registrations', $data);
    }

    public function get_user_registered_seminars($user_id) {
        $this->db->select('seminars.*, users.name as speaker_name');
        $this->db->from('seminar_registrations');
        $this->db->join('seminars', 'seminars.id = seminar_registrations.seminar_id');
        $this->db->join('users', 'users.id = seminars.speaker_id');
        $this->db->where('seminar_registrations.user_id', $user_id);
        return $this->db->get()->result();
    }

    public function get_registered_users($seminar_id) {
        $this->db->select('users.name, users.email, seminar_registrations.registered_at');
        $this->db->from('seminar_registrations');
        $this->db->join('users', 'users.id = seminar_registrations.user_id');
        $this->db->where('seminar_registrations.seminar_id', $seminar_id);
        return $this->db->get()->result();
    }

    public function get_attendee_count($seminar_id) {
        return $this->db->where('seminar_id', $seminar_id)->from('seminar_registrations')->count_all_results();
    }

    public function count_all() {
        return $this->db->count_all_results('seminars');
    }

    public function get_upcoming() {
        $this->db->where('date_time >=', date('Y-m-d H:i:s'));
        $this->db->order_by('date_time', 'ASC');
        return $this->db->get('seminars')->result();
    }
}
