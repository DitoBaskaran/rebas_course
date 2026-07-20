<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificate_model extends CI_Model {

    public function generate_code() {
        return 'CERT-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 12));
    }

    public function issue_certificate($user_id, $course_id) {
        $existing = $this->db->get_where('certificates', array('user_id' => $user_id, 'course_id' => $course_id))->row();
        if ($existing) {
            return $existing;
        }
        $data = array(
            'user_id' => $user_id,
            'course_id' => $course_id,
            'certificate_code' => $this->generate_code()
        );
        $this->db->insert('certificates', $data);
        $data['id'] = $this->db->insert_id();
        return (object)$data;
    }

    public function get_user_certificates($user_id) {
        $this->db->select('certificates.*, courses.title, courses.title_en, courses.thumbnail');
        $this->db->from('certificates');
        $this->db->join('courses', 'courses.id = certificates.course_id');
        $this->db->where('certificates.user_id', $user_id);
        $this->db->order_by('certificates.issued_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_certificate_by_code($code) {
        $this->db->select('certificates.*, users.name as user_name, courses.title, courses.title_en');
        $this->db->from('certificates');
        $this->db->join('users', 'users.id = certificates.user_id');
        $this->db->join('courses', 'courses.id = certificates.course_id');
        $this->db->where('certificates.certificate_code', $code);
        return $this->db->get()->row();
    }

    public function get_certificate_by_id($id) {
        $this->db->select('certificates.*, users.name as user_name, users.email as user_email, courses.title, courses.title_en');
        $this->db->from('certificates');
        $this->db->join('users', 'users.id = certificates.user_id');
        $this->db->join('courses', 'courses.id = certificates.course_id');
        $this->db->where('certificates.id', $id);
        return $this->db->get()->row();
    }

    public function has_certificate($user_id, $course_id) {
        return $this->db->get_where('certificates', array('user_id' => $user_id, 'course_id' => $course_id))->num_rows() > 0;
    }
}
