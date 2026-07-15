<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courses extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Course_model');
        $this->load->model('Transaction_model');
        $this->load->model('Review_model');
        $this->load->model('Quiz_model');
        $this->load->model('Assignment_model');
        $this->load->model('Discussion_model');
        $this->load->model('Certificate_model');
    }

    public function index() {
        $filters = array(
            'skill_level' => $this->input->get('skill_level'),
            'content_type' => $this->input->get('type'),
            'category_id' => $this->input->get('category_id'),
            'search' => $this->input->get('search'),
            'language' => $this->input->get('lang') ?: current_lang()
        );

        $data['title'] = t('Jelajahi Semua Konten', 'Browse All Content');
        $data['courses'] = $this->Course_model->get_courses($filters);
        $data['categories'] = $this->Course_model->get_root_categories();
        $data['selected_level'] = $filters['skill_level'];
        $data['selected_category'] = $filters['category_id'];
        $data['selected_type'] = $filters['content_type'];
        $data['search_query'] = $filters['search'];
        $data['content_types'] = array('course','workshop','bootcamp','ebook','project','article','video','podcast','template');

        $this->load->view('templates/header', $data);
        $this->load->view('courses/index', $data);
        $this->load->view('templates/footer');
    }

    public function mine() {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        $data['title'] = t('Kelas Saya', 'My Courses');
        $data['active_page'] = 'my_courses';
        $data['enrolled_courses'] = $this->Course_model->get_user_enrolled_courses($this->session->userdata('user_id'));
        $this->load->view('templates/student_header', $data);
        $this->load->view('courses/mine', $data);
        $this->load->view('templates/student_footer');
    }

    public function detail($id) {
        $course = $this->Course_model->get_course_by_id($id);
        if (!$course) show_404();

        $data['title'] = $course->title;
        $data['course'] = $course;
        $data['lessons'] = $this->Course_model->get_lessons_by_course($id);
        $data['tags'] = $this->Course_model->get_content_tags($id);
        $data['reviews'] = $this->Review_model->get_reviews($id);
        $data['avg_rating'] = $this->Review_model->get_average_rating($id);
        $data['rating_counts'] = $this->Review_model->get_rating_counts($id);
        $data['review_count'] = $this->Review_model->get_review_count($id);
        $data['quizzes'] = $this->Quiz_model->get_quizzes($id);
        $data['quiz_question_counts'] = array();
        foreach ($data['quizzes'] as $qz) {
            $data['quiz_question_counts'][$qz->id] = $this->Quiz_model->count_questions($qz->id);
        }
        $data['assignments'] = $this->Assignment_model->get_assignments($id);
        $data['discussions'] = $this->Discussion_model->get_discussions($id);
        $data['enrolled_count'] = count($this->Course_model->get_enrolled_students($id));

        $data['is_enrolled'] = FALSE;
        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $data['is_enrolled'] = $this->Course_model->check_enrollment($user_id, $id);
            $data['user_review'] = $this->Review_model->get_user_review($user_id, $id);
        } else {
            $data['user_review'] = null;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('courses/detail', $data);
        $this->load->view('templates/footer');
    }

    public function detail_slug($slug) {
        $course = $this->Course_model->get_course_by_slug($slug);
        if (!$course) show_404();

        $data['title'] = $course->title;
        $data['course'] = $course;
        $data['lessons'] = $this->Course_model->get_lessons_by_course($course->id);
        $data['tags'] = $this->Course_model->get_content_tags($course->id);
        $data['reviews'] = $this->Review_model->get_reviews($course->id);
        $data['avg_rating'] = $this->Review_model->get_average_rating($course->id);
        $data['rating_counts'] = $this->Review_model->get_rating_counts($course->id);
        $data['review_count'] = $this->Review_model->get_review_count($course->id);
        $data['quizzes'] = $this->Quiz_model->get_quizzes($course->id);
        $data['quiz_question_counts'] = array();
        foreach ($data['quizzes'] as $qz) {
            $data['quiz_question_counts'][$qz->id] = $this->Quiz_model->count_questions($qz->id);
        }
        $data['assignments'] = $this->Assignment_model->get_assignments($course->id);
        $data['discussions'] = $this->Discussion_model->get_discussions($course->id);
        $data['enrolled_count'] = count($this->Course_model->get_enrolled_students($course->id));

        $data['is_enrolled'] = FALSE;
        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $data['is_enrolled'] = $this->Course_model->check_enrollment($user_id, $course->id);
            $data['user_review'] = $this->Review_model->get_user_review($user_id, $course->id);
        } else {
            $data['user_review'] = null;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('courses/detail', $data);
        $this->load->view('templates/footer');
    }

    public function buy($id_or_slug) {
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', t('Silakan login terlebih dahulu.', 'Please login first.'));
            redirect('auth/login');
        }

        $course = is_numeric($id_or_slug) ? $this->Course_model->get_course_by_id($id_or_slug) : $this->Course_model->get_course_by_slug($id_or_slug);
        if (!$course) show_404();

        $user_id = $this->session->userdata('user_id');

        // Check if user has active subscription for this course
        if ($this->access_library->has_subscription_access($user_id, $course->id)) {
            $this->session->set_flashdata('success', t('Anda memiliki akses via langganan aktif.', 'You have access via active subscription.'));
            redirect('courses/learn/' . $course->slug);
        }

        if ($this->Course_model->check_enrollment($user_id, $course->id)) {
            $this->session->set_flashdata('error', t('Anda sudah terdaftar.', 'Already enrolled.'));
            redirect('courses/learn/' . $course->slug);
        }

        if ($course->price <= 0) {
            $this->Course_model->enroll_user($user_id, $course->id);
            $this->session->set_flashdata('success', t('Berhasil mendaftar!', 'Enrolled successfully!'));
            redirect('courses/learn/' . $course->slug);
        }

        redirect('checkout/initiate/' . $course->content_type . '/' . $course->id);
    }

    public function learn($course_slug_or_id, $lesson_id = NULL) {
        $user_id = $this->session->userdata('user_id');
        $course_id = is_numeric($course_slug_or_id) ? $course_slug_or_id : null;
        $course = is_numeric($course_slug_or_id) ? $this->Course_model->get_course_by_id($course_slug_or_id) : $this->Course_model->get_course_by_slug($course_slug_or_id);
        if (!$course) show_404();
        $course_id = $course->id;

        // Get all lessons first to find first one if no lesson_id
        $lessons = $this->Course_model->get_lessons_by_course($course_id);

        if (empty($lessons)) {
            $this->session->set_flashdata('error', t('Belum ada materi.', 'No lessons yet.'));
            redirect('courses/detail/' . $course->slug);
        }

        // If no lesson_id specified, use first lesson
        if (!$lesson_id) {
            redirect('courses/learn/' . $course->slug . '/' . $lessons[0]->id);
        }

        $lesson = $this->Course_model->get_lesson_by_id($lesson_id);
        if (!$lesson) show_404();

        // Check access using Access_library (supports enrollment and subscription)
        $access_info = $this->access_library->check_course_access($user_id, $course_id);

        if ($lesson->is_free) {
            $access_info = ['has_access' => true, 'reason' => t('Materi gratis.', 'Free lesson.'), 'access_type' => 'free'];
        }

        if (!$access_info['has_access']) {
            if (!$this->session->userdata('logged_in')) {
                $this->session->set_flashdata('error', t('Silakan login untuk mengakses materi ini.', 'Please login to access this lesson.'));
                redirect('auth/login');
            }
            $redirect_url = $course->price > 0 ? 'courses/detail/' . $course->slug : 'subscription';
            $this->session->set_flashdata('error', t('Anda belum memiliki akses ke materi ini.', 'You do not have access to this content.'));
            redirect($redirect_url);
        }

        $active_lesson = $this->Course_model->get_lesson_by_id($lesson_id);

        $completed_lessons = $this->Course_model->get_completed_lessons($user_id, $course_id);

        // Load quiz & assignment data for lesson
        $this->load->model('Quiz_model');
        $this->load->model('Assignment_model');
        $data['course_quiz'] = $this->Quiz_model->get_quiz_by_lesson($active_lesson->id);
        $data['course_assignment'] = $this->Assignment_model->get_assignment_by_lesson($active_lesson->id);

        $data['title'] = t('Belajar: ', 'Learn: ') . $course->title;
        $data['course'] = $course;
        $data['lessons'] = $lessons;
        $data['active_lesson'] = $active_lesson;
        $data['completed_lessons'] = $completed_lessons;
        $data['progress_pct'] = $this->Course_model->get_course_progress_percentage($user_id, $course->id);
        $data['access_type'] = $access_info['access_type'];

        $this->load->view('templates/header', $data);
        $this->load->view('courses/learn', $data);
        $this->load->view('templates/footer');
    }

    public function complete_lesson($course_slug_or_id, $lesson_id) {
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', t('Silakan login.', 'Please login.'));
            redirect('auth/login');
        }

        $this->load->helper('gamification');

        $user_id = $this->session->userdata('user_id');
        $course = is_numeric($course_slug_or_id) ? $this->Course_model->get_course_by_id($course_slug_or_id) : $this->Course_model->get_course_by_slug($course_slug_or_id);
        if (!$course) show_404();
        $course_id = $course->id;

        if (!$this->Course_model->check_enrollment($user_id, $course_id)) {
            $this->session->set_flashdata('error', t('Anda harus terdaftar dulu.', 'Please enroll first.'));
            redirect('courses/detail/' . $course->slug);
        }

        $this->Course_model->mark_lesson_completed($user_id, $lesson_id);
        award_points($user_id, 10, 'lesson_complete', $lesson_id);

        $lessons = $this->Course_model->get_lessons_by_course($course_id);
        $next_lesson_id = NULL;
        $found = FALSE;
        foreach ($lessons as $lesson) {
            if ($found) {
                $next_lesson_id = $lesson->id;
                break;
            }
            if ($lesson->id == $lesson_id) {
                $found = TRUE;
            }
        }

        if ($next_lesson_id) {
            $this->session->set_flashdata('success', t('Materi selesai!', 'Lesson completed!'));
            redirect('courses/learn/' . $course->slug . '/' . $next_lesson_id);
        } else {
            // Check if certificate should be issued
            $pct = $this->Course_model->get_course_progress_percentage($user_id, $course_id);
            if ($pct >= 100) {
                $cert = $this->Certificate_model->issue_certificate($user_id, $course_id);
                award_points($user_id, 100, 'course_completed', $course_id);
                $this->session->set_flashdata('success', t('Selamat! Anda lulus! Sertifikat telah diterbitkan.', 'Congratulations! Certificate issued.'));
            } else {
                $this->session->set_flashdata('success', t('Materi terakhir selesai!', 'Final lesson completed!'));
            }
            redirect('courses/learn/' . $course->slug . '/' . $lesson_id);
        }
    }

    public function review($course_slug_or_id) {
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', t('Silakan login.', 'Please login.'));
            redirect('auth/login');
        }

        $this->load->helper('gamification');

        $user_id = $this->session->userdata('user_id');
        $course = is_numeric($course_slug_or_id) ? $this->Course_model->get_course_by_id($course_slug_or_id) : $this->Course_model->get_course_by_slug($course_slug_or_id);
        if (!$course) show_404();
        $course_id = $course->id;

        if (!$this->Course_model->check_enrollment($user_id, $course_id)) {
            $this->session->set_flashdata('error', t('Anda harus terdaftar.', 'You must be enrolled.'));
            redirect('courses/detail/' . $course->slug);
        }

        $this->form_validation->set_rules('rating', t('Rating', 'Rating'), 'required|numeric|greater_than[0]|less_than[6]');
        $this->form_validation->set_rules('review', t('Review', 'Review'), 'trim');

        $existing = $this->Review_model->get_user_review($user_id, $course_id);

        if ($this->form_validation->run()) {
            $data = array(
                'user_id' => $user_id,
                'course_id' => $course_id,
                'rating' => $this->input->post('rating'),
                'review' => $this->input->post('review')
            );
            if ($existing) {
                $this->Review_model->update_review($existing->id, $data);
            } else {
                $this->Review_model->create_review($data);
            }
            award_points($user_id, 5, 'review_written', $course_id);
            $this->session->set_flashdata('success', t('Review berhasil dikirim.', 'Review submitted.'));
        }
        redirect('courses/detail/' . $course->slug);
    }
}
