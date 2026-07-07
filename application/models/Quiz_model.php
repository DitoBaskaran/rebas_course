<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz_model extends CI_Model {

    public function get_quizzes($course_id) {
        $this->db->where('course_id', $course_id);
        $this->db->order_by('sort_order', 'ASC');
        return $this->db->get('quizzes')->result();
    }

    public function get_quiz_by_lesson($lesson_id) {
        return $this->db->get_where('quizzes', array('lesson_id' => $lesson_id))->row();
    }

    public function get_quiz_by_id($id) {
        $this->db->select('quizzes.*, courses.slug as course_slug');
        $this->db->from('quizzes');
        $this->db->join('courses', 'courses.id = quizzes.course_id');
        $this->db->where('quizzes.id', $id);
        return $this->db->get()->row();
    }

    public function create_quiz($data) {
        $this->db->insert('quizzes', $data);
        return $this->db->insert_id();
    }

    public function update_quiz($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('quizzes', $data);
    }

    public function delete_quiz($id) {
        $this->db->where('id', $id)->delete('quizzes');
    }

    public function get_questions($quiz_id) {
        $this->db->where('quiz_id', $quiz_id);
        $this->db->order_by('sort_order', 'ASC');
        return $this->db->get('quiz_questions')->result();
    }

    public function count_questions($quiz_id) {
        return $this->db->where('quiz_id', $quiz_id)->count_all_results('quiz_questions');
    }

    public function get_question_by_id($id) {
        return $this->db->get_where('quiz_questions', array('id' => $id))->row();
    }

    public function create_question($data) {
        return $this->db->insert('quiz_questions', $data);
    }

    public function update_question($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('quiz_questions', $data);
    }

    public function delete_question($id) {
        $this->db->where('id', $id)->delete('quiz_questions');
    }

    public function get_total_points($quiz_id) {
        $this->db->select_sum('points');
        $result = $this->db->get_where('quiz_questions', array('quiz_id' => $quiz_id))->row();
        return $result->points ?? 0;
    }

    public function create_attempt($data) {
        $this->db->insert('quiz_attempts', $data);
        return $this->db->insert_id();
    }

    public function get_attempt_by_id($id) {
        return $this->db->get_where('quiz_attempts', array('id' => $id))->row();
    }

    public function update_attempt($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('quiz_attempts', $data);
    }

    public function get_user_attempts($quiz_id, $user_id) {
        $this->db->where('quiz_id', $quiz_id);
        $this->db->where('user_id', $user_id);
        $this->db->order_by('started_at', 'DESC');
        return $this->db->get('quiz_attempts')->result();
    }

    public function get_best_score($quiz_id, $user_id) {
        $this->db->select_max('score');
        $result = $this->db->get_where('quiz_attempts', array('quiz_id' => $quiz_id, 'user_id' => $user_id))->row();
        return $result->score ?? 0;
    }

    public function get_attempt_count($quiz_id, $user_id) {
        return $this->db->where('quiz_id', $quiz_id)->where('user_id', $user_id)->from('quiz_attempts')->count_all_results();
    }

    public function has_passed($quiz_id, $user_id) {
        $best = $this->get_best_score($quiz_id, $user_id);
        $quiz = $this->get_quiz_by_id($quiz_id);
        if (!$quiz) return false;
        $total = $this->get_total_points($quiz_id);
        if ($total == 0) return false;
        $pct = round(($best / $total) * 100);
        return $pct >= $quiz->passing_score;
    }
}
