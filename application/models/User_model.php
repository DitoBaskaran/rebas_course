<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function register($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return $this->db->insert('users', $data);
    }

    public function login($email, $password) {
        $user = $this->db->get_where('users', array('email' => $email))->row();
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return FALSE;
    }

    public function get_user_by_id($id) {
        return $this->db->get_where('users', array('id' => $id))->row();
    }

    public function get_teachers() {
        return $this->db->get_where('users', array('is_teacher' => 1))->result();
    }

    public function get_students() {
        return $this->db->get_where('users', array('role' => 'student'))->result();
    }

    public function update_profile($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function get_filtered($role = null, $status = null, $search = null, $limit = 50, $offset = 0, $is_teacher = null, $is_mentor = null) {
        if ($role) $this->db->where('role', $role);
        if ($status) $this->db->where('status', $status);
        if ($search) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
            $this->db->group_end();
        }
        if ($is_teacher !== null) $this->db->where('is_teacher', $is_teacher);
        if ($is_mentor !== null) $this->db->where('is_mentor', $is_mentor);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get('users')->result();
    }

    public function count_all($role = null, $status = null, $search = null, $is_teacher = null, $is_mentor = null) {
        if ($role) $this->db->where('role', $role);
        if ($status) $this->db->where('status', $status);
        if ($search) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
            $this->db->group_end();
        }
        if ($is_teacher !== null) $this->db->where('is_teacher', $is_teacher);
        if ($is_mentor !== null) $this->db->where('is_mentor', $is_mentor);
        return $this->db->count_all_results('users');
    }

    public function update_user($id, $data) {
        return $this->db->where('id', $id)->update('users', $data);
    }

    public function get_user_enrolled_count($user_id) {
        return $this->db->where('user_id', $user_id)->count_all_results('enrollments');
    }
}
