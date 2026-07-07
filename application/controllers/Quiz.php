<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', t('Silakan login terlebih dahulu.', 'Please login first.'));
            redirect('auth/login');
        }
        $this->load->model('Quiz_model');
        $this->load->model('Course_model');
        $this->load->model('Assignment_model');
    }

    public function start($quiz_id) {
        $quiz = $this->Quiz_model->get_quiz_by_id($quiz_id);
        if (!$quiz) show_404();

        $user_id = $this->session->userdata('user_id');

        // BUG FIX: Check enrollment
        if (!$this->Course_model->check_enrollment($user_id, $quiz->course_id)) {
            $this->session->set_flashdata('error', t('Anda harus terdaftar di kelas ini.', 'You must be enrolled in this course.'));
            redirect('courses/detail/' . $quiz->course_id);
        }

        $attempt_count = $this->Quiz_model->get_attempt_count($quiz_id, $user_id);
        if ($quiz->max_attempts > 0 && $attempt_count >= $quiz->max_attempts) {
            $this->session->set_flashdata('error', t('Batas percobaan sudah habis.', 'Maximum attempts reached.'));
            redirect('courses/detail/' . $quiz->course_id);
        }

        $attempt = array(
            'quiz_id' => $quiz_id,
            'user_id' => $user_id,
            'started_at' => date('Y-m-d H:i:s')
        );
        $attempt_id = $this->Quiz_model->create_attempt($attempt);

        redirect('quiz/take/' . $attempt_id);
    }

    public function take($attempt_id) {
        $attempt = $this->Quiz_model->get_attempt_by_id($attempt_id);
        if (!$attempt || $attempt->user_id != $this->session->userdata('user_id')) show_404();

        $quiz = $this->Quiz_model->get_quiz_by_id($attempt->quiz_id);
        $questions = $this->Quiz_model->get_questions($quiz->id);

        if ($attempt->finished_at) {
            redirect('quiz/result/' . $attempt_id);
        }

        $data['title'] = t('Quiz: ', 'Quiz: ') . $quiz->title;
        $data['quiz'] = $quiz;
        $data['questions'] = $questions;
        $data['attempt'] = $attempt;

        $this->load->view('templates/header', $data);
        $this->load->view('quiz/take', $data);
        $this->load->view('templates/footer');
    }

    public function submit($attempt_id) {
        $this->load->helper('gamification');

        $attempt = $this->Quiz_model->get_attempt_by_id($attempt_id);
        if (!$attempt || $attempt->user_id != $this->session->userdata('user_id')) show_404();
        if ($attempt->finished_at) {
            redirect('quiz/result/' . $attempt_id);
        }

        $quiz = $this->Quiz_model->get_quiz_by_id($attempt->quiz_id);
        $questions = $this->Quiz_model->get_questions($quiz->id);

        // BUG FIX: Backend timer validation
        if ($quiz->time_limit > 0 && $attempt->started_at) {
            $start = strtotime($attempt->started_at);
            $max_end = $start + ($quiz->time_limit * 60);
            $now = time();
            if ($now > $max_end) {
                $this->session->set_flashdata('error', t('Waktu pengerjaan sudah habis.', 'Time is up.'));
                // Still save what they had
            }
        }

        $score = 0;
        $total_points = 0;
        $answers = array();

        foreach ($questions as $q) {
            $answer = $this->input->post('q_' . $q->id);
            $answers['q_' . $q->id] = $answer;
            $total_points += $q->points;

            if ($q->question_type === 'multiple_choice' || $q->question_type === 'true_false') {
                if ($answer == $q->correct_answer) {
                    $score += $q->points;
                }
            } elseif ($q->question_type === 'short_answer') {
                if (strtolower(trim($answer)) === strtolower(trim($q->correct_answer))) {
                    $score += $q->points;
                }
            }
            // Essay questions: saved but require manual grading (score 0 for now)
        }

        $pct = $total_points > 0 ? round(($score / $total_points) * 100) : 0;
        $passed = $pct >= $quiz->passing_score;

        $this->Quiz_model->update_attempt($attempt_id, array(
            'score' => $score,
            'total_points' => $total_points,
            'answers' => json_encode($answers),
            'finished_at' => date('Y-m-d H:i:s'),
            'is_passed' => $passed ? 1 : 0
        ));

        // BUG FIX: Auto-mark lesson complete
        if ($quiz->lesson_id) {
            $this->Course_model->mark_lesson_completed($this->session->userdata('user_id'), $quiz->lesson_id);
        }

        if ($passed) {
            award_points($this->session->userdata('user_id'), 25, 'quiz_passed', $quiz->id);
        }

        redirect('quiz/result/' . $attempt_id);
    }

    public function result($attempt_id) {
        $attempt = $this->Quiz_model->get_attempt_by_id($attempt_id);
        if (!$attempt || $attempt->user_id != $this->session->userdata('user_id')) show_404();

        $quiz = $this->Quiz_model->get_quiz_by_id($attempt->quiz_id);
        $questions = $this->Quiz_model->get_questions($quiz->id);
        $answers = json_decode($attempt->answers, true) ?: array();
        $pct = $attempt->total_points > 0 ? round(($attempt->score / $attempt->total_points) * 100) : 0;
        $passed = $pct >= $quiz->passing_score;

        $data['title'] = t('Hasil Quiz', 'Quiz Result');
        $data['quiz'] = $quiz;
        $data['questions'] = $questions;
        $data['attempt'] = $attempt;
        $data['answers'] = $answers;
        $data['pct'] = $pct;
        $data['passed'] = $passed;

        $this->load->view('templates/header', $data);
        $this->load->view('quiz/result', $data);
        $this->load->view('templates/footer');
    }

    // --- Admin Quiz Management ---
    public function admin_quizzes($course_id) {
        $data['title'] = t('Kelola Quiz', 'Manage Quizzes');
        $data['course'] = $this->Course_model->get_course_by_id($course_id);
        $data['quizzes'] = $this->Quiz_model->get_quizzes($course_id);

        $qcounts = array();
        foreach ($data['quizzes'] as $qz) {
            $qcounts[$qz->id] = $this->Quiz_model->count_questions($qz->id);
        }
        $data['question_counts'] = $qcounts;

        $data['active_page'] = 'courses';
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/quizzes/list', $data);
        $this->load->view('templates/admin_footer');
    }

    public function admin_create_quiz($course_id) {
        $this->form_validation->set_rules('title', t('Judul Quiz', 'Quiz Title'), 'required');
        $this->form_validation->set_rules('passing_score', t('Nilai Lulus', 'Passing Score'), 'required|numeric|greater_than[0]|less_than[101]');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = t('Buat Quiz', 'Create Quiz');
            $data['course'] = $this->Course_model->get_course_by_id($course_id);
            $data['active_page'] = 'courses';
            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/quizzes/create', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $this->Quiz_model->create_quiz(array(
                'course_id' => $course_id,
                'lesson_id' => $this->input->post('lesson_id') ?: null,
                'title' => $this->input->post('title'),
                'passing_score' => $this->input->post('passing_score'),
                'time_limit' => $this->input->post('time_limit') ?: 0,
                'max_attempts' => $this->input->post('max_attempts') ?: 3
            ));
            $this->session->set_flashdata('success', t('Quiz berhasil dibuat.', 'Quiz created successfully.'));
            redirect('quiz/admin_quizzes/' . $course_id);
        }
    }

    public function admin_delete_quiz($id) {
        $quiz = $this->Quiz_model->get_quiz_by_id($id);
        if (!$quiz) show_404();
        $course_id = $quiz->course_id;
        $this->Quiz_model->delete_quiz($id);
        $this->session->set_flashdata('success', t('Quiz berhasil dihapus.', 'Quiz deleted.'));
        redirect('quiz/admin_quizzes/' . $course_id);
    }

    public function admin_questions($quiz_id) {
        $quiz = $this->Quiz_model->get_quiz_by_id($quiz_id);
        if (!$quiz) show_404();
        $data['title'] = t('Soal Quiz', 'Quiz Questions');
        $data['quiz'] = $quiz;
        $data['course'] = $this->Course_model->get_course_by_id($quiz->course_id);
        $data['questions'] = $this->Quiz_model->get_questions($quiz_id);

        $data['active_page'] = 'courses';
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/quizzes/questions', $data);
        $this->load->view('templates/admin_footer');
    }

    public function admin_create_question($quiz_id) {
        $this->form_validation->set_rules('question', t('Soal', 'Question'), 'required');
        $this->form_validation->set_rules('type', t('Tipe', 'Type'), 'required');

        if ($this->form_validation->run() === FALSE) {
            $quiz = $this->Quiz_model->get_quiz_by_id($quiz_id);
            $data['title'] = t('Tambah Soal', 'Add Question');
            $data['quiz'] = $quiz;
            $data['active_page'] = 'courses';
            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/quizzes/create_question', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $options = null;
            if ($this->input->post('type') === 'multiple_choice') {
                // BUG FIX: Parse options from textarea (one per line)
                $opt_text = $this->input->post('options_text');
                $opts = array();
                if ($opt_text) {
                    $lines = explode("\n", $opt_text);
                    foreach ($lines as $line) {
                        $line = trim($line);
                        if ($line) $opts[] = $line;
                    }
                }
                $options = json_encode($opts);
            }
            $this->Quiz_model->create_question(array(
                'quiz_id' => $quiz_id,
                'question' => $this->input->post('question'),
                'question_en' => $this->input->post('question_en') ?: '',
                'type' => $this->input->post('type'),
                'options' => $options,
                'correct_answer' => $this->input->post('correct_answer'),
                'points' => $this->input->post('points') ?: 1,
                'sort_order' => $this->input->post('sort_order') ?: 0
            ));
            $this->session->set_flashdata('success', t('Soal berhasil ditambahkan.', 'Question added.'));
            redirect('quiz/admin_questions/' . $quiz_id);
        }
    }

    public function admin_delete_question($question_id) {
        $q = $this->Quiz_model->get_question_by_id($question_id);
        if (!$q) show_404();
        $quiz_id = $q->quiz_id;
        $this->Quiz_model->delete_question($question_id);
        redirect('quiz/admin_questions/' . $quiz_id);
    }

    // BUG FIX: Remove private method - now uses model instead
}
