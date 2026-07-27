<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $t_role = $this->session->userdata('role');
        $t_is_teacher = $this->session->userdata('is_teacher');
        if (!$this->session->userdata('logged_in') || !($t_role === 'admin' || $t_is_teacher)) {
            $this->session->set_flashdata('error', t('Akses ditolak.', 'Access denied.'));
            redirect('home');
        }
        $this->load->model('Course_model');
        $this->load->model('Seminar_model');
        $this->load->model('Quiz_model');
        $this->load->model('Assignment_model');
        $this->load->model('Review_model');
        $this->load->model('Discussion_model');
        $this->load->model('User_model');
        $this->load->model('Transaction_model');
        $this->load->model('Tag_model');
    }

    // ================ DASHBOARD ================
    public function dashboard() {
        $data['title'] = t('Panel Guru - BISATUNTAS', 'Teacher Panel - BISATUNTAS');
        $data['load_chartjs'] = true;
        $data['active_page'] = 'dashboard';
        $user_id = $this->session->userdata('user_id');
        $is_teacher = $this->session->userdata('is_teacher');
        $data['is_teacher'] = $is_teacher;
        $data['current_role'] = $this->session->userdata('role');

        // Enrollment chart: only teacher's own courses
        $chart_labels = '[]';
        $chart_data = '[]';
        $teacher_courses = $this->db->select('id')->where('teacher_id', $user_id)->get('courses')->result();
        if (!empty($teacher_courses)) {
            $course_ids = array_column($teacher_courses, 'id');
            $enrollments_by_month = $this->db
                ->select("DATE_FORMAT(enrolled_at, '%Y-%m') as month, COUNT(*) as total")
                ->from('enrollments')
                ->where_in('course_id', $course_ids)
                ->where('enrolled_at >=', date('Y-m-d', strtotime('-6 months')))
                ->group_by('month')
                ->order_by('month', 'ASC')
                ->get()->result();
            if (!empty($enrollments_by_month)) {
                $labels = array();
                $chart_data_arr = array();
                foreach ($enrollments_by_month as $row) {
                    $labels[] = $row->month;
                    $chart_data_arr[] = (int)$row->total;
                }
                $chart_labels = json_encode($labels);
                $chart_data = json_encode($chart_data_arr);
            }
        }

        $data['total_courses'] = $this->db->where('teacher_id', $user_id)->count_all_results('courses');
        $data['total_seminars'] = $this->db->where('speaker_id', $user_id)->count_all_results('seminars');
        $data['total_students'] = $this->db->where('role', 'student')->count_all_results('users');
        $data['total_revenue'] = 0;
        $data['transactions'] = array();
        $data['chart_labels'] = $chart_labels;
        $data['chart_data'] = $chart_data;

        $this->load->view('templates/teacher_header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/teacher_footer');
    }

    // ================ COURSE MANAGEMENT ================
    public function courses() {
        $data['active_page'] = 'courses';
        $data['title'] = t('Kelola Konten', 'Manage Content');
        $user_id = $this->session->userdata('user_id');
        $data['courses'] = $this->Course_model->get_courses(array('teacher_id' => $user_id, 'status' => 'all'));
        $this->load->view('templates/teacher_header', $data);
        $this->load->view('admin/courses/list', $data);
        $this->load->view('templates/teacher_footer');
    }

    public function create_course() {
        $this->form_validation->set_rules('title', t('Judul', 'Title'), 'required|trim');
        $this->form_validation->set_rules('content_type', t('Tipe', 'Type'), 'required');
        $this->form_validation->set_rules('category_id', t('Kategori', 'Category'), 'required');
        $this->form_validation->set_rules('skill_level', t('Level', 'Level'), 'required');
        $this->form_validation->set_rules('price', t('Harga', 'Price'), 'required|numeric');
        $this->form_validation->set_rules('description', t('Deskripsi', 'Description'), 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['active_page'] = 'courses';
            $data['title'] = t('Buat Konten Baru', 'Create Content');
            $data['categories'] = $this->Course_model->get_categories();
            $data['tags'] = $this->Tag_model->get_all();
            $this->load->view('templates/teacher_header', $data);
            $this->load->view('admin/courses/create', $data);
            $this->load->view('templates/teacher_footer');
        } else {
            $thumbnail = 'default_course.png';
            $upload_path = './uploads/courses';
            if (!is_dir($upload_path)) mkdir($upload_path, 0777, TRUE);
            if (!empty($_FILES['thumbnail']['name'])) {
                $config = array(
                    'upload_path' => $upload_path, 'allowed_types' => 'jpg|jpeg|png|gif',
                    'max_size' => 2048, 'file_name' => 'course_' . time()
                );
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('thumbnail')) $thumbnail = $this->upload->data('file_name');
            }
            $course_id = $this->Course_model->create_course(array(
                'title' => $this->input->post('title'), 'title_en' => $this->input->post('title_en') ?: '',
                'content_type' => $this->input->post('content_type'), 'category_id' => $this->input->post('category_id'),
                'teacher_id' => $this->session->userdata('user_id'),
                'skill_level' => $this->input->post('skill_level'), 'price' => $this->input->post('price'),
                'description' => $this->input->post('description'), 'description_en' => $this->input->post('description_en') ?: '',
                'thumbnail' => $thumbnail, 'duration_total' => $this->input->post('duration_total') ?: 0,
                'language' => $this->input->post('language') ?: 'id', 'featured' => $this->input->post('featured') ? 1 : 0
            ));
            $this->Course_model->set_content_tags($course_id, $this->input->post('tags') ?: array());
            $this->session->set_flashdata('success', t('Konten berhasil dibuat!', 'Content created!'));
            redirect('teacher/courses');
        }
    }

    public function edit_course($id) {
        $course = $this->Course_model->get_course_by_id($id);
        if (!$course) show_404();
        if ($this->session->userdata('is_teacher') && $course->teacher_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', t('Akses ditolak. Bukan konten Anda.', 'Access denied. Not your content.'));
            redirect('teacher/courses');
        }
        $this->form_validation->set_rules('title', t('Judul', 'Title'), 'required|trim');
        if ($this->form_validation->run() === FALSE) {
            $data['active_page'] = 'courses';
            $data['title'] = t('Edit Konten', 'Edit Content');
            $data['course'] = $course;
            $data['categories'] = $this->Course_model->get_categories();
            $data['tags'] = $this->Tag_model->get_all();
            $data['content_tags'] = $this->Course_model->get_content_tags($id);
            $this->load->view('templates/teacher_header', $data);
            $this->load->view('admin/courses/edit', $data);
            $this->load->view('templates/teacher_footer');
        } else {
            $course_data = array(
                'title' => $this->input->post('title'), 'title_en' => $this->input->post('title_en') ?: '',
                'content_type' => $this->input->post('content_type'), 'category_id' => $this->input->post('category_id'),
                'skill_level' => $this->input->post('skill_level'), 'price' => $this->input->post('price'),
                'description' => $this->input->post('description'), 'description_en' => $this->input->post('description_en') ?: '',
                'duration_total' => $this->input->post('duration_total') ?: 0,
                'language' => $this->input->post('language') ?: 'id', 'featured' => $this->input->post('featured') ? 1 : 0,
                'status' => $this->input->post('status') ?: 'published'
            );
            if (!empty($_FILES['thumbnail']['name'])) {
                $upload_path = './uploads/courses';
                if (!is_dir($upload_path)) mkdir($upload_path, 0777, TRUE);
                $config = array('upload_path' => $upload_path, 'allowed_types' => 'jpg|jpeg|png|gif', 'max_size' => 2048, 'file_name' => 'course_' . time());
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('thumbnail')) $course_data['thumbnail'] = $this->upload->data('file_name');
            }
            $this->Course_model->update_course($id, $course_data);
            $this->Course_model->set_content_tags($id, $this->input->post('tags') ?: array());
            $this->session->set_flashdata('success', t('Konten berhasil diperbarui!', 'Content updated!'));
            redirect('teacher/courses');
        }
    }

    public function delete_course($id) {
        $course = $this->Course_model->get_course_by_id($id);
        if (!$course) show_404();
        if ($this->session->userdata('is_teacher') && $course->teacher_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', t('Akses ditolak. Bukan konten Anda.', 'Access denied. Not your content.'));
            redirect('teacher/courses');
        }
        $this->Course_model->delete_course($id);
        $this->session->set_flashdata('success', t('Konten berhasil dihapus.', 'Content deleted.'));
        redirect('teacher/courses');
    }

    // ================ LESSON MANAGEMENT ================
    public function lessons($course_id) {
        $course = $this->Course_model->get_course_by_id($course_id);
        if (!$course) show_404();
        if ($this->session->userdata('is_teacher') && $course->teacher_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', t('Akses ditolak.', 'Access denied.'));
            redirect('teacher/courses');
        }
        $data['active_page'] = 'courses';
        $data['title'] = t('Materi: ', 'Lessons: ') . $course->title;
        $data['course'] = $course;
        $data['lessons'] = $this->Course_model->get_lessons_by_course($course_id);
        $this->load->view('templates/teacher_header', $data);
        $this->load->view('admin/lessons/list', $data);
        $this->load->view('templates/teacher_footer');
    }

    public function create_lesson($course_id) {
        $course = $this->Course_model->get_course_by_id($course_id);
        if (!$course) show_404();
        if ($this->session->userdata('is_teacher') && $course->teacher_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', t('Akses ditolak.', 'Access denied.'));
            redirect('teacher/courses');
        }
        $this->form_validation->set_rules('title', t('Judul', 'Title'), 'required|trim');
        if ($this->form_validation->run() === FALSE) {
            $data['active_page'] = 'courses';
            $data['title'] = t('Tambah Materi', 'Add Lesson');
            $data['course'] = $course;
            $this->load->view('templates/teacher_header', $data);
            $this->load->view('admin/lessons/create', $data);
            $this->load->view('templates/teacher_footer');
        } else {
            $this->Course_model->create_lesson(array(
                'course_id' => $course_id, 'title' => $this->input->post('title'),
                'title_en' => $this->input->post('title_en') ?: '', 'lesson_type' => $this->input->post('lesson_type') ?: 'video',
                'description' => $this->input->post('description'), 'description_en' => $this->input->post('description_en') ?: '',
                'content' => $this->input->post('content'), 'content_en' => $this->input->post('content_en') ?: '',
                'video_url' => $this->input->post('video_url'), 'live_url' => $this->input->post('live_url'),
                'duration' => $this->input->post('duration') ?: 0, 'sort_order' => $this->input->post('sort_order') ?: 0,
                'is_free' => $this->input->post('is_free') ? 1 : 0
            ));
            $this->session->set_flashdata('success', t('Materi berhasil ditambahkan!', 'Lesson added!'));
            redirect('teacher/lessons/' . $course_id);
        }
    }

    public function edit_lesson($id) {
        $lesson = $this->Course_model->get_lesson_by_id($id);
        if (!$lesson) show_404();
        $course = $this->Course_model->get_course_by_id($lesson->course_id);
        if ($this->session->userdata('is_teacher') && $course->teacher_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', t('Akses ditolak.', 'Access denied.'));
            redirect('teacher/courses');
        }
        $this->form_validation->set_rules('title', t('Judul', 'Title'), 'required|trim');
        if ($this->form_validation->run() === FALSE) {
            $data['active_page'] = 'courses';
            $data['title'] = t('Edit Materi', 'Edit Lesson');
            $data['lesson'] = $lesson;
            $data['course'] = $course;
            $this->load->view('templates/teacher_header', $data);
            $this->load->view('admin/lessons/edit', $data);
            $this->load->view('templates/teacher_footer');
        } else {
            $this->Course_model->update_lesson($id, array(
                'title' => $this->input->post('title'), 'title_en' => $this->input->post('title_en') ?: '',
                'lesson_type' => $this->input->post('lesson_type') ?: 'video',
                'description' => $this->input->post('description'), 'description_en' => $this->input->post('description_en') ?: '',
                'content' => $this->input->post('content'), 'content_en' => $this->input->post('content_en') ?: '',
                'video_url' => $this->input->post('video_url'), 'live_url' => $this->input->post('live_url'),
                'duration' => $this->input->post('duration') ?: 0, 'sort_order' => $this->input->post('sort_order') ?: 0,
                'is_free' => $this->input->post('is_free') ? 1 : 0
            ));
            $this->session->set_flashdata('success', t('Materi diperbarui!', 'Lesson updated!'));
            redirect('teacher/lessons/' . $course->id);
        }
    }

    public function delete_lesson($id) {
        $lesson = $this->Course_model->get_lesson_by_id($id);
        if (!$lesson) show_404();
        $course = $this->Course_model->get_course_by_id($lesson->course_id);
        if ($this->session->userdata('is_teacher') && $course->teacher_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', t('Akses ditolak.', 'Access denied.'));
            redirect('teacher/courses');
        }
        $course_id = $lesson->course_id;
        $this->Course_model->delete_lesson($id);
        $this->session->set_flashdata('success', t('Materi dihapus.', 'Lesson deleted.'));
        redirect('teacher/lessons/' . $course_id);
    }

    // ================ SEMINAR MANAGEMENT ================
    public function seminars() {
        $data['active_page'] = 'seminars';
        $data['title'] = t('Kelola Seminar', 'Manage Seminars');
        $user_id = $this->session->userdata('user_id');
        $data['seminars'] = $this->Seminar_model->get_seminars(array('speaker_id' => $user_id));
        $this->load->view('templates/teacher_header', $data);
        $this->load->view('admin/seminars/list', $data);
        $this->load->view('templates/teacher_footer');
    }

    public function create_seminar() {
        $this->form_validation->set_rules('title', t('Judul', 'Title'), 'required|trim');
        $this->form_validation->set_rules('date_time', t('Tanggal', 'Date'), 'required');
        $this->form_validation->set_rules('price', t('Harga', 'Price'), 'required|numeric');
        $this->form_validation->set_rules('quota', t('Kuota', 'Quota'), 'required|numeric');
        $this->form_validation->set_rules('description', t('Deskripsi', 'Description'), 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['active_page'] = 'seminars';
            $data['title'] = t('Buat Seminar', 'Create Seminar');
            $this->load->view('templates/teacher_header', $data);
            $this->load->view('admin/seminars/create', $data);
            $this->load->view('templates/teacher_footer');
        } else {
            $thumbnail = 'default_seminar.png';
            $upload_path = './uploads/seminars';
            if (!is_dir($upload_path)) mkdir($upload_path, 0777, TRUE);
            if (!empty($_FILES['thumbnail']['name'])) {
                $config = array('upload_path' => $upload_path, 'allowed_types' => 'jpg|jpeg|png|gif', 'max_size' => 2048, 'file_name' => 'seminar_' . time());
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('thumbnail')) $thumbnail = $this->upload->data('file_name');
            }
            $this->Seminar_model->create_seminar(array(
                'speaker_id' => $this->session->userdata('user_id'),
                'title' => $this->input->post('title'), 'title_en' => $this->input->post('title_en') ?: '',
                'date_time' => $this->input->post('date_time'), 'price' => $this->input->post('price'),
                'quota' => $this->input->post('quota'), 'location_link' => $this->input->post('location_link') ?: '',
                'description' => $this->input->post('description'), 'description_en' => $this->input->post('description_en') ?: '',
                'thumbnail' => $thumbnail, 'language' => $this->input->post('language') ?: 'id'
            ));
            $this->session->set_flashdata('success', t('Seminar berhasil dibuat!', 'Seminar created!'));
            redirect('teacher/seminars');
        }
    }

    public function edit_seminar($id) {
        $seminar = $this->Seminar_model->get_seminar_by_id($id);
        if (!$seminar) show_404();
        if ($this->session->userdata('is_teacher') && $seminar->speaker_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', t('Akses ditolak. Bukan seminar Anda.', 'Access denied. Not your seminar.'));
            redirect('teacher/seminars');
        }
        $this->form_validation->set_rules('title', t('Judul', 'Title'), 'required|trim');
        if ($this->form_validation->run() === FALSE) {
            $data['active_page'] = 'seminars';
            $data['title'] = t('Edit Seminar', 'Edit Seminar');
            $data['seminar'] = $seminar;
            $this->load->view('templates/teacher_header', $data);
            $this->load->view('admin/seminars/edit', $data);
            $this->load->view('templates/teacher_footer');
        } else {
            $seminar_data = array(
                'title' => $this->input->post('title'), 'title_en' => $this->input->post('title_en') ?: '',
                'date_time' => $this->input->post('date_time'), 'price' => $this->input->post('price'),
                'quota' => $this->input->post('quota'), 'location_link' => $this->input->post('location_link') ?: '',
                'description' => $this->input->post('description'), 'description_en' => $this->input->post('description_en') ?: '',
                'language' => $this->input->post('language') ?: 'id'
            );
            if (!empty($_FILES['thumbnail']['name'])) {
                $upload_path = './uploads/seminars';
                if (!is_dir($upload_path)) mkdir($upload_path, 0777, TRUE);
                $config = array('upload_path' => $upload_path, 'allowed_types' => 'jpg|jpeg|png|gif', 'max_size' => 2048, 'file_name' => 'seminar_' . time());
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('thumbnail')) $seminar_data['thumbnail'] = $this->upload->data('file_name');
            }
            $this->Seminar_model->update_seminar($id, $seminar_data);
            $this->session->set_flashdata('success', t('Seminar diperbarui!', 'Seminar updated!'));
            redirect('teacher/seminars');
        }
    }

    public function delete_seminar($id) {
        $seminar = $this->Seminar_model->get_seminar_by_id($id);
        if (!$seminar) show_404();
        if ($this->session->userdata('is_teacher') && $seminar->speaker_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', t('Akses ditolak. Bukan seminar Anda.', 'Access denied. Not your seminar.'));
            redirect('teacher/seminars');
        }
        $this->Seminar_model->delete_seminar($id);
        $this->session->set_flashdata('success', t('Seminar dihapus.', 'Seminar deleted.'));
        redirect('teacher/seminars');
    }

    // ================ SUBMISSIONS / GRADING ================
    public function submissions() {
        $data['title'] = t('Tugas Siswa', 'Student Submissions');
        $user_id = $this->session->userdata('user_id');
        $courses = $this->Course_model->get_courses(array('teacher_id' => $user_id));
        $all_submissions = array();
        foreach ($courses as $c) {
            $assignments = $this->Assignment_model->get_assignments($c->id);
            foreach ($assignments as $a) {
                $subs = $this->Assignment_model->get_submissions_by_assignment($a->id);
                foreach ($subs as $s) {
                    $s->course_title = $c->title;
                    $s->assignment_title = $a->title;
                    $all_submissions[] = $s;
                }
            }
        }
        $data['active_page'] = 'submissions';
        $data['submissions'] = $all_submissions;
        $this->load->view('templates/teacher_header', $data);
        $this->load->view('admin/submissions/list', $data);
        $this->load->view('templates/teacher_footer');
    }

    public function grade_submission($id) {
        $this->form_validation->set_rules('grade', t('Nilai', 'Grade'), 'required|numeric|greater_than[-1]|less_than[101]');
        if ($this->form_validation->run()) {
            $this->Assignment_model->grade_submission($id, $this->input->post('grade'), $this->input->post('feedback') ?: '');
            $this->session->set_flashdata('success', t('Nilai berhasil diberikan.', 'Grade submitted.'));
        }
        redirect('teacher/submissions');
    }

    public function return_submission($id) {
        $this->Assignment_model->return_submission($id, $this->input->post('feedback') ?: '');
        $this->session->set_flashdata('success', t('Tugas dikembalikan untuk revisi.', 'Submission returned for revision.'));
        redirect('teacher/submissions');
    }

    // ================ ASSIGNMENT MANAGEMENT ================
    public function assignments($course_id) {
        $course = $this->Course_model->get_course_by_id($course_id);
        if (!$course) show_404();
        if ($this->session->userdata('is_teacher') && $course->teacher_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', t('Akses ditolak.', 'Access denied.'));
            redirect('teacher/courses');
        }
        $data['active_page'] = 'courses';
        $data['title'] = t('Tugas', 'Assignments') . ' - ' . $course->title;
        $data['course'] = $course;
        $data['assignments'] = $this->Assignment_model->get_assignments($course_id);
        $this->load->view('templates/teacher_header', $data);
        $this->load->view('admin/assignments/list', $data);
        $this->load->view('templates/teacher_footer');
    }

    public function create_assignment($course_id) {
        $course = $this->Course_model->get_course_by_id($course_id);
        if (!$course) show_404();
        if ($this->session->userdata('is_teacher') && $course->teacher_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', t('Akses ditolak.', 'Access denied.'));
            redirect('teacher/courses');
        }
        $this->form_validation->set_rules('title', t('Judul', 'Title'), 'required|trim');
        if ($this->form_validation->run() === FALSE) {
            $data['active_page'] = 'courses';
            $data['title'] = t('Buat Tugas', 'Create Assignment');
            $data['course'] = $course;
            $data['lessons'] = $this->Course_model->get_lessons_by_course($course_id);
            $this->load->view('templates/teacher_header', $data);
            $this->load->view('admin/assignments/create', $data);
            $this->load->view('templates/teacher_footer');
        } else {
            $this->Assignment_model->create_assignment(array(
                'course_id' => $course_id, 'lesson_id' => $this->input->post('lesson_id') ?: null,
                'title' => $this->input->post('title'), 'title_en' => $this->input->post('title_en') ?: '',
                'description' => $this->input->post('description'), 'description_en' => $this->input->post('description_en') ?: '',
                'instructions' => $this->input->post('instructions'), 'instructions_en' => $this->input->post('instructions_en') ?: '',
                'max_score' => $this->input->post('max_score') ?: 100, 'due_days' => $this->input->post('due_days') ?: 7,
                'max_file_size' => $this->input->post('max_file_size') ?: 10240,
                'allowed_file_types' => $this->input->post('allowed_file_types') ?: 'pdf,zip,doc,docx,jpg,png',
                'sort_order' => $this->input->post('sort_order') ?: 0
            ));
            $this->session->set_flashdata('success', t('Tugas berhasil dibuat!', 'Assignment created!'));
            redirect('teacher/assignments/' . $course_id);
        }
    }

    public function delete_assignment($id) {
        $a = $this->Assignment_model->get_assignment_by_id($id);
        if (!$a) show_404();
        $course = $this->Course_model->get_course_by_id($a->course_id);
        if ($this->session->userdata('is_teacher') && $course->teacher_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', t('Akses ditolak.', 'Access denied.'));
            redirect('teacher/courses');
        }
        $course_id = $a->course_id;
        $this->Assignment_model->delete_assignment($id);
        $this->session->set_flashdata('success', t('Tugas dihapus.', 'Assignment deleted.'));
        redirect('teacher/assignments/' . $course_id);
    }

    // ================ QUIZ / ESSAY GRADING ================
    public function grade_essays($quiz_id) {
        $this->load->model('Quiz_model');
        $data['quiz'] = $this->Quiz_model->get_quiz_by_id($quiz_id);
        if (!$data['quiz']) show_404();
        $data['attempts'] = $this->db
            ->select('quiz_attempts.*, users.name as user_name')
            ->from('quiz_attempts')->join('users', 'users.id = quiz_attempts.user_id')
            ->where('quiz_attempts.quiz_id', $quiz_id)
            ->where('quiz_attempts.answers IS NOT NULL')
            ->order_by('quiz_attempts.finished_at', 'DESC')->get()->result();
        $data['active_page'] = 'courses';
        $this->load->view('templates/teacher_header', $data);
        $this->load->view('admin/quizzes/grade_essays', $data);
        $this->load->view('templates/teacher_footer');
    }

    public function save_essay_grade($attempt_id, $question_idx) {
        $score = $this->input->post('score');
        $attempt = $this->db->where('id', $attempt_id)->get('quiz_attempts')->row();
        if (!$attempt) show_404();
        $answers = json_decode($attempt->answers, true);
        if (isset($answers[$question_idx])) $answers[$question_idx]['essay_score'] = (int)$score;
        $total = 0;
        foreach ($answers as $a) $total += isset($a['essay_score']) ? $a['essay_score'] : ($a['score'] ?? 0);
        $this->db->where('id', $attempt_id)->update('quiz_attempts', array('answers' => json_encode($answers), 'score' => $total));
        $this->session->set_flashdata('success', t('Nilai essay disimpan.', 'Essay grade saved.'));
        redirect('teacher/grade_essays/' . $attempt->quiz_id);
    }
}