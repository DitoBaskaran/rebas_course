<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assignment_model extends CI_Model {

    public function get_assignments($course_id) {
        $this->db->where('course_id', $course_id);
        $this->db->order_by('sort_order', 'ASC');
        return $this->db->get('assignments')->result();
    }

    public function get_assignment_by_lesson($lesson_id) {
        return $this->db->get_where('assignments', array('lesson_id' => $lesson_id))->row();
    }

    public function get_assignment_by_id($id) {
        return $this->db->get_where('assignments', array('id' => $id))->row();
    }

    public function create_assignment($data) {
        $this->db->insert('assignments', $data);
        return $this->db->insert_id();
    }

    public function update_assignment($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('assignments', $data);
    }

    public function delete_assignment($id) {
        $this->db->where('id', $id)->delete('assignments');
    }

    public function get_submission($assignment_id, $user_id) {
        return $this->db->get_where('submissions', array('assignment_id' => $assignment_id, 'user_id' => $user_id))->row();
    }

    public function create_submission($data) {
        return $this->db->insert('submissions', $data);
    }

    public function update_submission($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('submissions', $data);
    }

    public function get_submissions_by_assignment($assignment_id) {
        $this->db->select('submissions.*, users.name as user_name, users.email, users.avatar');
        $this->db->from('submissions');
        $this->db->join('users', 'users.id = submissions.user_id');
        $this->db->where('submissions.assignment_id', $assignment_id);
        $this->db->order_by('submissions.submitted_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_submissions_by_user($user_id) {
        $this->db->select('submissions.*, assignments.title, assignments.course_id');
        $this->db->from('submissions');
        $this->db->join('assignments', 'assignments.id = submissions.assignment_id');
        $this->db->where('submissions.user_id', $user_id);
        $this->db->order_by('submissions.submitted_at', 'DESC');
        return $this->db->get()->result();
    }

    public function count_submissions($assignment_id) {
        return $this->db->where('assignment_id', $assignment_id)->from('submissions')->count_all_results();
    }

    public function grade_submission($id, $grade, $feedback) {
        $data = array(
            'grade' => $grade,
            'feedback' => $feedback,
            'status' => 'graded',
            'graded_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $id);
        return $this->db->update('submissions', $data);
    }

    public function return_submission($id, $feedback = '') {
        $data = array(
            'feedback' => $feedback,
            'status' => 'returned'
        );
        $this->db->where('id', $id);
        return $this->db->update('submissions', $data);
    }

    public function get_all_submissions_with_details() {
        $this->db->select('submissions.*, users.name as user_name, users.email, users.avatar, assignments.title as assignment_title, assignments.course_id, courses.title as course_title');
        $this->db->from('submissions');
        $this->db->join('users', 'users.id = submissions.user_id');
        $this->db->join('assignments', 'assignments.id = submissions.assignment_id');
        $this->db->join('courses', 'courses.id = assignments.course_id');
        $this->db->order_by('submissions.submitted_at', 'DESC');
        return $this->db->get()->result();
    }
}
