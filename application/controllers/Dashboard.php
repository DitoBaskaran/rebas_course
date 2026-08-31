<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', t('Silakan login terlebih dahulu.', 'Please login first.'));
            redirect('auth/login');
        }
        $this->load->model('Course_model');
        $this->load->model('Seminar_model');
        $this->load->model('Transaction_model');
        $this->load->model('Certificate_model');
        $this->load->model('Learning_path_model');
        $this->load->model('Mentoring_model');
    }

    public function index() {
        $role = $this->session->userdata('role');
        if ($this->session->userdata('is_mentor')) {
            redirect('mentor');
        } elseif ($role === 'admin') {
            redirect('admin/dashboard');
        } elseif ($this->session->userdata('is_teacher')) {
            redirect('teacher/dashboard');
        }
        $user_id = $this->session->userdata('user_id');
        $data['title'] = t('Dashboard - BISATUNTAS', 'Dashboard - BISATUNTAS');
        $data['enrolled_courses'] = $this->Course_model->get_user_enrolled_courses($user_id);
        $data['registered_seminars'] = $this->Seminar_model->get_user_registered_seminars($user_id);
        $data['transactions'] = $this->Transaction_model->get_user_transactions($user_id);
        $data['certificates'] = $this->Certificate_model->get_user_certificates($user_id);
        $data['learning_paths'] = $this->Learning_path_model->get_user_paths($user_id);
        $data['mentoring_sessions'] = $this->Mentoring_model->get_student_sessions($user_id);

        // Add progress for each course
        $course_ids = array_column($data['enrolled_courses'], 'id');
        if (!empty($course_ids)) {
            $progress_data = $this->db
                ->select('l.course_id, COUNT(p.id) as completed')
                ->from('progress p')
                ->join('lessons l', 'l.id = p.lesson_id')
                ->where('p.user_id', $user_id)
                ->where_in('l.course_id', $course_ids)
                ->where('p.status', 'completed')
                ->group_by('l.course_id')
                ->get()
                ->result();
            $progress_map = array();
            foreach ($progress_data as $pd) {
                $progress_map[$pd->course_id] = $pd->completed;
            }
            foreach ($data['enrolled_courses'] as &$course) {
                $total = $this->db->where('course_id', $course->id)->count_all_results('lessons');
                $completed = isset($progress_map[$course->id]) ? $progress_map[$course->id] : 0;
                $course->progress_pct = $total > 0 ? round(($completed / $total) * 100) : 0;
            }
        }

        $data['active_page'] = 'dashboard';
        $this->load->view('templates/student_header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/student_footer');
    }
}
