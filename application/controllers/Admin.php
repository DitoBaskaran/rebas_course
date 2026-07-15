<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in') || !in_array($this->session->userdata('role'), ['admin', 'teacher'])) {
            $this->session->set_flashdata('error', t('Akses ditolak.', 'Access denied.'));
            redirect('home');
        }
        $this->load->model('Course_model');
        $this->load->model('Seminar_model');
        $this->load->model('Transaction_model');
        $this->load->model('User_model');
        $this->load->model('Quiz_model');
        $this->load->model('Assignment_model');
        $this->load->model('Review_model');
        $this->load->model('Discussion_model');
        $this->load->model('Mentoring_model');
        $this->load->model('Learning_path_model');
        $this->load->model('Tag_model');
        $this->load->model('Translation_model');
        $this->load->model('Setting_model');
        $this->load->model('Package_model');
   }

    // ================ DASHBOARD ================
    public function dashboard() {
        $data['title'] = t('Panel Admin - REBAS COURSE', 'Admin Panel - REBAS COURSE');
        $data['load_chartjs'] = true;
        $data['active_page'] = 'dashboard';
        // Real analytics: enrollment data for last 6 months
        $chart_labels = '[]';
        $chart_data = '[]';
        $enrollments_by_month = $this->db
            ->select("DATE_FORMAT(enrolled_at, '%Y-%m') as month, COUNT(*) as total")
            ->from('enrollments')
            ->where('enrolled_at >=', date('Y-m-d', strtotime('-6 months')))
            ->group_by('month')
            ->order_by('month', 'ASC')
            ->get()->result();

        if (!empty($enrollments_by_month)) {
            $labels = array();
            $data = array();
            foreach ($enrollments_by_month as $row) {
                $labels[] = $row->month;
                $data[] = (int)$row->total;
            }
            $chart_labels = json_encode($labels);
            $chart_data = json_encode($data);
        }

        // Real stats from database
        $data['total_courses'] = $this->Course_model->count_all(array());
        $data['total_seminars'] = $this->Seminar_model->count_all();
        $data['total_students'] = $this->db->where('role', 'student')->count_all_results('users');
        $data['total_revenue'] = $this->db->select('COALESCE(SUM(amount),0) as total')
            ->where('status', 'approved')
            ->get('transactions')->row()->total;
        $data['transactions'] = $this->Transaction_model->get_all_transactions();
        $data['chart_labels'] = $chart_labels;
        $data['chart_data'] = $chart_data;

        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/admin_footer');
    }

    // ===== ANALYTICS DASHBOARD =====
    public function analytics() {
        $this->load->model('Course_model');
        $this->load->model('Seminar_model');

        // Revenue by month
        $data['revenue_by_month'] = $this->db
            ->select("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(amount) as revenue")
            ->from('transactions')
            ->where('status', 'approved')
            ->where('created_at >=', date('Y-m-d', strtotime('-12 months')))
            ->group_by('month')
            ->order_by('month', 'ASC')
            ->get()->result();

        // Popular courses
        $data['popular_courses'] = $this->db
            ->select('courses.title, COUNT(enrollments.id) as students')
            ->from('courses')
            ->join('enrollments', 'enrollments.course_id = courses.id', 'left')
            ->group_by('courses.id')
            ->order_by('students', 'DESC')
            ->limit(10)
            ->get()->result();

        // Revenue by content type
        $data['revenue_by_type'] = $this->db
            ->select('courses.content_type, COALESCE(SUM(transactions.amount),0) as revenue')
            ->from('courses')
            ->join('transactions', 'transactions.item_id = courses.id AND transactions.status = \'approved\'', 'left')
            ->group_by('courses.content_type')
            ->get()->result();

        $data['active_page'] = 'analytics';
        $data['load_chartjs'] = true;
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/analytics/index', $data);
        $this->load->view('templates/admin_footer');
    }

    // ================ TRANSACTION ACTIONS ================
    public function transactions() {
        $data['transactions'] = $this->Transaction_model->get_all_transactions();
        $data['active_page'] = 'transactions';
        $data['title'] = t('Transaksi', 'Transactions');
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/transactions/list', $data);
        $this->load->view('templates/admin_footer');
    }

    public function approve_transaction($tx_id) {
        $tx = $this->Transaction_model->get_transaction_by_id($tx_id);
        if (!$tx) show_404();

        if ($tx->status === 'pending') {
            $this->Transaction_model->update_transaction_status($tx_id, 'approved');

            if ($tx->coupon_id) {
                $this->load->model('Coupon_model');
                $this->Coupon_model->increment_usage($tx->coupon_id);
            }

            if ($tx->item_type === 'course' || in_array($tx->item_type, ['workshop','bootcamp','ebook','project'])) {
                $this->Course_model->enroll_user($tx->user_id, $tx->item_id);
            } elseif ($tx->item_type === 'seminar') {
                $this->Seminar_model->register_user($tx->user_id, $tx->item_id);
            } elseif ($tx->item_type === 'package') {
                $this->load->model('Package_model');
                $this->load->model('User_subscription_model');
                $package = $this->Package_model->get_package_by_id($tx->item_id);
                if ($package) {
                    $this->User_subscription_model->activate_subscription($tx->user_id, $package->id, $package->duration_days, $tx->id);
                }
            } elseif ($tx->item_type === 'package_6mo') {
                $this->load->model('Package_model');
                $this->load->model('User_subscription_model');
                $package = $this->Package_model->get_package_by_id($tx->item_id);
                if ($package) {
                    $duration_days = $package->duration_days * 6;
                    if (!empty($tx->notes)) {
                        $note = json_decode($tx->notes, true);
                        if (isset($note['duration_days'])) $duration_days = (int)$note['duration_days'];
                    }
                    $this->User_subscription_model->activate_subscription($tx->user_id, $package->id, $duration_days, $tx->id);
                }
            } elseif ($tx->item_type === 'mentoring_package') {
                $this->load->model('Mentoring_package_model');
                $this->load->model('User_mentoring_balance_model');
                $package = $this->Mentoring_package_model->get_by_id($tx->item_id);
                if ($package) {
                    $this->User_mentoring_balance_model->create(array(
                        'user_id' => $tx->user_id,
                        'package_id' => $package->id,
                        'total_sessions' => $package->session_count,
                        'remaining_sessions' => $package->session_count,
                        'session_duration' => $package->session_duration,
                        'expired_at' => date('Y-m-d', strtotime('+1 year')),
                    ));
                }
            }
            $this->session->set_flashdata('success', t('Transaksi disetujui.', 'Transaction approved.'));
        } else {
            $this->session->set_flashdata('error', t('Transaksi sudah diproses.', 'Already processed.'));
        }
        redirect('admin/transactions');
    }

    public function reject_transaction($tx_id) {
        $tx = $this->Transaction_model->get_transaction_by_id($tx_id);
        if (!$tx) show_404();

        if ($tx->status === 'pending') {
            $this->Transaction_model->update_transaction_status($tx_id, 'rejected');
            $this->session->set_flashdata('success', t('Transaksi ditolak.', 'Transaction rejected.'));
        } else {
            $this->session->set_flashdata('error', t('Sudah diproses.', 'Already processed.'));
        }
        redirect('admin/transactions');
    }

    // ================ COURSE MANAGEMENT ================
    public function courses() {
        $data['active_page'] = 'courses';
        $data['title'] = t('Kelola Konten', 'Manage Content');
        $data['courses'] = $this->Course_model->get_courses(array('status' => 'all'));
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/courses/list', $data);
        $this->load->view('templates/admin_footer');
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
            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/courses/create', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $thumbnail = 'default_course.png';
            $upload_path = './uploads/courses';
            if (!is_dir($upload_path)) mkdir($upload_path, 0777, TRUE);

            if (!empty($_FILES['thumbnail']['name'])) {
                $config = array(
                    'upload_path' => $upload_path,
                    'allowed_types' => 'jpg|jpeg|png|gif',
                    'max_size' => 2048,
                    'file_name' => 'course_' . time()
                );
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('thumbnail')) {
                    $thumbnail = $this->upload->data('file_name');
                }
            }

            $course_data = array(
                'title' => $this->input->post('title'),
                'title_en' => $this->input->post('title_en') ?: '',
                'content_type' => $this->input->post('content_type'),
                'category_id' => $this->input->post('category_id'),
                'teacher_id' => $this->session->userdata('user_id'),
                'skill_level' => $this->input->post('skill_level'),
                'price' => $this->input->post('price'),
                'description' => $this->input->post('description'),
                'description_en' => $this->input->post('description_en') ?: '',
                'thumbnail' => $thumbnail,
                'duration_total' => $this->input->post('duration_total') ?: 0,
                'language' => $this->input->post('language') ?: 'id',
                'featured' => $this->input->post('featured') ? 1 : 0
            );
            $course_id = $this->Course_model->create_course($course_data);

            // Tags
            $tag_ids = $this->input->post('tags') ?: array();
            $this->Course_model->set_content_tags($course_id, $tag_ids);

            $this->session->set_flashdata('success', t('Konten berhasil dibuat!', 'Content created!'));
            redirect('admin/courses');
        }
    }

    public function edit_course($id) {
        $course = $this->Course_model->get_course_by_id($id);
        if (!$course) show_404();

        $this->form_validation->set_rules('title', t('Judul', 'Title'), 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $data['active_page'] = 'courses';
            $data['title'] = t('Edit Konten', 'Edit Content');
            $data['course'] = $course;
            $data['categories'] = $this->Course_model->get_categories();
            $data['tags'] = $this->Tag_model->get_all();
            $data['content_tags'] = $this->Course_model->get_content_tags($id);
            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/courses/edit', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $course_data = array(
                'title' => $this->input->post('title'),
                'title_en' => $this->input->post('title_en') ?: '',
                'content_type' => $this->input->post('content_type'),
                'category_id' => $this->input->post('category_id'),
                'skill_level' => $this->input->post('skill_level'),
                'price' => $this->input->post('price'),
                'description' => $this->input->post('description'),
                'description_en' => $this->input->post('description_en') ?: '',
                'duration_total' => $this->input->post('duration_total') ?: 0,
                'language' => $this->input->post('language') ?: 'id',
                'featured' => $this->input->post('featured') ? 1 : 0,
                'status' => $this->input->post('status') ?: 'published'
            );

            if (!empty($_FILES['thumbnail']['name'])) {
                $upload_path = './uploads/courses';
                if (!is_dir($upload_path)) mkdir($upload_path, 0777, TRUE);
                $config = array(
                    'upload_path' => $upload_path,
                    'allowed_types' => 'jpg|jpeg|png|gif',
                    'max_size' => 2048,
                    'file_name' => 'course_' . time()
                );
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('thumbnail')) {
                    $course_data['thumbnail'] = $this->upload->data('file_name');
                }
            }

            $this->Course_model->update_course($id, $course_data);
            $tag_ids = $this->input->post('tags') ?: array();
            $this->Course_model->set_content_tags($id, $tag_ids);

            $this->session->set_flashdata('success', t('Konten berhasil diperbarui!', 'Content updated!'));
            redirect('admin/courses');
        }
    }

    public function delete_course($id) {
        $this->Course_model->delete_course($id);
        $this->session->set_flashdata('success', t('Konten berhasil dihapus.', 'Content deleted.'));
        redirect('admin/courses');
    }

    // ================ LESSON MANAGEMENT ================
    public function lessons($course_id) {
        $course = $this->Course_model->get_course_by_id($course_id);
        if (!$course) show_404();

        $data['active_page'] = 'courses';
        $data['title'] = t('Materi: ', 'Lessons: ') . $course->title;
        $data['course'] = $course;
        $data['lessons'] = $this->Course_model->get_lessons_by_course($course_id);

        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/lessons/list', $data);
        $this->load->view('templates/admin_footer');
    }

    public function create_lesson($course_id) {
        $course = $this->Course_model->get_course_by_id($course_id);
        if (!$course) show_404();

        $this->form_validation->set_rules('title', t('Judul', 'Title'), 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $data['active_page'] = 'courses';
            $data['title'] = t('Tambah Materi', 'Add Lesson');
            $data['course'] = $course;
            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/lessons/create', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $lesson_data = array(
                'course_id' => $course_id,
                'title' => $this->input->post('title'),
                'title_en' => $this->input->post('title_en') ?: '',
                'lesson_type' => $this->input->post('lesson_type') ?: 'video',
                'description' => $this->input->post('description'),
                'description_en' => $this->input->post('description_en') ?: '',
                'content' => $this->input->post('content'),
                'content_en' => $this->input->post('content_en') ?: '',
                'video_url' => $this->input->post('video_url'),
                'live_url' => $this->input->post('live_url'),
                'duration' => $this->input->post('duration') ?: 0,
                'sort_order' => $this->input->post('sort_order') ?: 0,
                'is_free' => $this->input->post('is_free') ? 1 : 0
            );
            $this->Course_model->create_lesson($lesson_data);
            $this->session->set_flashdata('success', t('Materi berhasil ditambahkan!', 'Lesson added!'));
            redirect('admin/lessons/' . $course_id);
        }
    }

    public function edit_lesson($id) {
        $lesson = $this->Course_model->get_lesson_by_id($id);
        if (!$lesson) show_404();
        $course = $this->Course_model->get_course_by_id($lesson->course_id);

        $this->form_validation->set_rules('title', t('Judul', 'Title'), 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $data['active_page'] = 'courses';
            $data['title'] = t('Edit Materi', 'Edit Lesson');
            $data['lesson'] = $lesson;
            $data['course'] = $course;
            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/lessons/edit', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $lesson_data = array(
                'title' => $this->input->post('title'),
                'title_en' => $this->input->post('title_en') ?: '',
                'lesson_type' => $this->input->post('lesson_type') ?: 'video',
                'description' => $this->input->post('description'),
                'description_en' => $this->input->post('description_en') ?: '',
                'content' => $this->input->post('content'),
                'content_en' => $this->input->post('content_en') ?: '',
                'video_url' => $this->input->post('video_url'),
                'live_url' => $this->input->post('live_url'),
                'duration' => $this->input->post('duration') ?: 0,
                'sort_order' => $this->input->post('sort_order') ?: 0,
                'is_free' => $this->input->post('is_free') ? 1 : 0
            );
            $this->Course_model->update_lesson($id, $lesson_data);
            $this->session->set_flashdata('success', t('Materi diperbarui!', 'Lesson updated!'));
            redirect('admin/lessons/' . $course->id);
        }
    }

    public function delete_lesson($id) {
        $lesson = $this->Course_model->get_lesson_by_id($id);
        if (!$lesson) show_404();
        $course_id = $lesson->course_id;
        $this->Course_model->delete_lesson($id);
        $this->session->set_flashdata('success', t('Materi dihapus.', 'Lesson deleted.'));
        redirect('admin/lessons/' . $course_id);
    }

    // ================ SEMINAR MANAGEMENT ================
    public function seminars() {
        $data['active_page'] = 'seminars';
        $data['title'] = t('Kelola Seminar', 'Manage Seminars');
        $data['seminars'] = $this->Seminar_model->get_seminars();
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/seminars/list', $data);
        $this->load->view('templates/admin_footer');
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
            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/seminars/create', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $thumbnail = 'default_seminar.png';
            $upload_path = './uploads/seminars';
            if (!is_dir($upload_path)) mkdir($upload_path, 0777, TRUE);

            if (!empty($_FILES['thumbnail']['name'])) {
                $config = array(
                    'upload_path' => $upload_path,
                    'allowed_types' => 'jpg|jpeg|png|gif',
                    'max_size' => 2048,
                    'file_name' => 'seminar_' . time()
                );
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('thumbnail')) {
                    $thumbnail = $this->upload->data('file_name');
                }
            }

            $seminar_data = array(
                'speaker_id' => $this->session->userdata('user_id'),
                'title' => $this->input->post('title'),
                'title_en' => $this->input->post('title_en') ?: '',
                'date_time' => $this->input->post('date_time'),
                'price' => $this->input->post('price'),
                'quota' => $this->input->post('quota'),
                'location_link' => $this->input->post('location_link') ?: '',
                'description' => $this->input->post('description'),
                'description_en' => $this->input->post('description_en') ?: '',
                'thumbnail' => $thumbnail,
                'language' => $this->input->post('language') ?: 'id'
            );
            $this->Seminar_model->create_seminar($seminar_data);
            $this->session->set_flashdata('success', t('Seminar berhasil dibuat!', 'Seminar created!'));
            redirect('admin/seminars');
        }
    }

    public function edit_seminar($id) {
        $seminar = $this->Seminar_model->get_seminar_by_id($id);
        if (!$seminar) show_404();

        $this->form_validation->set_rules('title', t('Judul', 'Title'), 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $data['active_page'] = 'seminars';
            $data['title'] = t('Edit Seminar', 'Edit Seminar');
            $data['seminar'] = $seminar;
            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/seminars/edit', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $seminar_data = array(
                'title' => $this->input->post('title'),
                'title_en' => $this->input->post('title_en') ?: '',
                'date_time' => $this->input->post('date_time'),
                'price' => $this->input->post('price'),
                'quota' => $this->input->post('quota'),
                'location_link' => $this->input->post('location_link') ?: '',
                'description' => $this->input->post('description'),
                'description_en' => $this->input->post('description_en') ?: '',
                'language' => $this->input->post('language') ?: 'id'
            );

            if (!empty($_FILES['thumbnail']['name'])) {
                $upload_path = './uploads/seminars';
                if (!is_dir($upload_path)) mkdir($upload_path, 0777, TRUE);
                $config = array(
                    'upload_path' => $upload_path,
                    'allowed_types' => 'jpg|jpeg|png|gif',
                    'max_size' => 2048,
                    'file_name' => 'seminar_' . time()
                );
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('thumbnail')) {
                    $seminar_data['thumbnail'] = $this->upload->data('file_name');
                }
            }

            $this->Seminar_model->update_seminar($id, $seminar_data);
            $this->session->set_flashdata('success', t('Seminar diperbarui!', 'Seminar updated!'));
            redirect('admin/seminars');
        }
    }

    public function delete_seminar($id) {
        $this->Seminar_model->delete_seminar($id);
        $this->session->set_flashdata('success', t('Seminar dihapus.', 'Seminar deleted.'));
        redirect('admin/seminars');
    }

    // ================ MENTORING SESSIONS ================
    public function mentoring() {
        $data['active_page'] = 'mentoring';
        $data['title'] = t('Jadwal Mentoring', 'Mentoring Schedule');
        $data['sessions'] = $this->Mentoring_model->get_all_sessions();
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/mentoring/list', $data);
        $this->load->view('templates/admin_footer');
    }

    // ================ LEARNING PATHS ================
    public function learning_paths() {
        $data['active_page'] = 'learning_paths';
        $data['title'] = t('Learning Paths', 'Learning Paths');
        $data['paths'] = $this->Learning_path_model->get_all();
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/learning_paths/list', $data);
        $this->load->view('templates/admin_footer');
    }

    public function create_learning_path() {
        $this->form_validation->set_rules('title', t('Judul', 'Title'), 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $data['active_page'] = 'learning_paths';
            $data['title'] = t('Buat Learning Path', 'Create Learning Path');
            $data['categories'] = $this->Course_model->get_categories();
            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/learning_paths/create', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $slug = url_title($this->input->post('title'), 'dash', true);
            $this->Learning_path_model->create(array(
                'title' => $this->input->post('title'),
                'title_en' => $this->input->post('title_en') ?: '',
                'slug' => $slug,
                'description' => $this->input->post('description'),
                'description_en' => $this->input->post('description_en') ?: '',
                'category_id' => $this->input->post('category_id') ?: null,
                'color' => $this->input->post('color') ?: '#4361ee',
                'skill_level' => $this->input->post('skill_level') ?: 'all_levels',
                'estimated_hours' => $this->input->post('estimated_hours') ?: 0
            ));
            $this->session->set_flashdata('success', t('Learning Path dibuat!', 'Learning Path created!'));
            redirect('admin/learning_paths');
        }
    }

    public function edit_learning_path($id) {
        $path = $this->Learning_path_model->get_by_id($id);
        if (!$path) show_404();

        $this->form_validation->set_rules('title', t('Judul', 'Title'), 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $data['active_page'] = 'learning_paths';
            $data['title'] = t('Edit Learning Path', 'Edit Learning Path');
            $data['path'] = $path;
            $data['categories'] = $this->Course_model->get_categories();
            $data['contents'] = $this->Learning_path_model->get_contents($id);
            $data['all_courses'] = $this->Course_model->get_courses();
            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/learning_paths/edit', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $this->Learning_path_model->update($id, array(
                'title' => $this->input->post('title'),
                'title_en' => $this->input->post('title_en') ?: '',
                'description' => $this->input->post('description'),
                'description_en' => $this->input->post('description_en') ?: '',
                'category_id' => $this->input->post('category_id') ?: null,
                'color' => $this->input->post('color') ?: '#4361ee',
                'skill_level' => $this->input->post('skill_level') ?: 'all_levels',
                'estimated_hours' => $this->input->post('estimated_hours') ?: 0
            ));
            $this->session->set_flashdata('success', t('Learning Path diperbarui!', 'Learning Path updated!'));
            redirect('admin/learning_paths');
        }
    }

    public function delete_learning_path($id) {
        $this->Learning_path_model->delete($id);
        redirect('admin/learning_paths');
    }

    public function add_path_content($path_id) {
        $this->form_validation->set_rules('course_id', 'Course', 'required|numeric');
        if ($this->form_validation->run()) {
            $this->Learning_path_model->add_content(array(
                'path_id' => $path_id,
                'course_id' => $this->input->post('course_id'),
                'sort_order' => $this->input->post('sort_order') ?: 0
            ));
        }
        redirect('admin/edit_learning_path/' . $path_id);
    }

    public function remove_path_content($id) {
        $this->Learning_path_model->remove_content($id);
        redirect($this->input->server('HTTP_REFERER') ?: 'admin/learning_paths');
    }

    // ================ TAGS ================
    public function tags() {
        $data['active_page'] = 'tags';
        $data['title'] = t('Kelola Tags', 'Manage Tags');
        $data['tags'] = $this->Tag_model->get_all();
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/tags/list', $data);
        $this->load->view('templates/admin_footer');
    }

    public function create_tag() {
        $this->form_validation->set_rules('name', t('Nama', 'Name'), 'required|trim');
        if ($this->form_validation->run()) {
            $slug = url_title($this->input->post('name'), 'dash', true);
            $this->Tag_model->create(array(
                'name' => $this->input->post('name'),
                'name_en' => $this->input->post('name_en') ?: '',
                'slug' => $slug
            ));
            $this->session->set_flashdata('success', t('Tag dibuat!', 'Tag created!'));
        }
        redirect('admin/tags');
    }

    public function delete_tag($id) {
        $this->Tag_model->delete($id);
        redirect('admin/tags');
    }

    // ================ SUBMISSIONS / GRADING ================
    public function submissions() {
        $data['title'] = t('Tugas Siswa', 'Student Submissions');
        $user_id = $this->session->userdata('user_id');
        $role = $this->session->userdata('role');
        
        if ($role === 'admin') {
            // Admin sees ALL submissions
            $all_submissions = $this->Assignment_model->get_all_submissions_with_details();
        } else {
            // Teacher sees only their course submissions
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
        }

        $data['active_page'] = 'submissions';
        $data['submissions'] = $all_submissions;
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/submissions/list', $data);
        $this->load->view('templates/admin_footer');
    }

    public function grade_submission($id) {
        $this->form_validation->set_rules('grade', t('Nilai', 'Grade'), 'required|numeric|greater_than[-1]|less_than[101]');
        if ($this->form_validation->run()) {
            $this->Assignment_model->grade_submission(
                $id,
                $this->input->post('grade'),
                $this->input->post('feedback') ?: ''
            );
            $this->session->set_flashdata('success', t('Nilai berhasil diberikan.', 'Grade submitted.'));
        }
        redirect('admin/submissions');
    }

    public function return_submission($id) {
        $this->Assignment_model->return_submission($id, $this->input->post('feedback') ?: '');
        $this->session->set_flashdata('success', t('Tugas dikembalikan untuk revisi.', 'Submission returned for revision.'));
        redirect('admin/submissions');
    }

    // ================ ASSIGNMENT MANAGEMENT ================
    public function assignments($course_id) {
        $course = $this->Course_model->get_course_by_id($course_id);
        if (!$course) show_404();
        $data['active_page'] = 'courses';
        $data['title'] = t('Tugas', 'Assignments') . ' - ' . $course->title;
        $data['course'] = $course;
        $data['assignments'] = $this->Assignment_model->get_assignments($course_id);
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/assignments/list', $data);
        $this->load->view('templates/admin_footer');
    }

    public function create_assignment($course_id) {
        $course = $this->Course_model->get_course_by_id($course_id);
        if (!$course) show_404();

        $this->form_validation->set_rules('title', t('Judul', 'Title'), 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $data['active_page'] = 'courses';
            $data['title'] = t('Buat Tugas', 'Create Assignment');
            $data['course'] = $course;
            $data['lessons'] = $this->Course_model->get_lessons_by_course($course_id);
            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/assignments/create', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $this->Assignment_model->create_assignment(array(
                'course_id' => $course_id,
                'lesson_id' => $this->input->post('lesson_id') ?: null,
                'title' => $this->input->post('title'),
                'title_en' => $this->input->post('title_en') ?: '',
                'description' => $this->input->post('description'),
                'description_en' => $this->input->post('description_en') ?: '',
                'instructions' => $this->input->post('instructions'),
                'instructions_en' => $this->input->post('instructions_en') ?: '',
                'max_score' => $this->input->post('max_score') ?: 100,
                'due_days' => $this->input->post('due_days') ?: 7,
                'max_file_size' => $this->input->post('max_file_size') ?: 10240,
                'allowed_file_types' => $this->input->post('allowed_file_types') ?: 'pdf,zip,doc,docx,jpg,png',
                'sort_order' => $this->input->post('sort_order') ?: 0
            ));
            $this->session->set_flashdata('success', t('Tugas berhasil dibuat!', 'Assignment created!'));
            redirect('admin/assignments/' . $course_id);
        }
    }

    public function delete_assignment($id) {
        $a = $this->Assignment_model->get_assignment_by_id($id);
        if (!$a) show_404();
        $course_id = $a->course_id;
        $this->Assignment_model->delete_assignment($id);
        $this->session->set_flashdata('success', t('Tugas dihapus.', 'Assignment deleted.'));
        redirect('admin/assignments/' . $course_id);
    }

    // ================ TRANSLATIONS ================
    public function translations() {
        $data['active_page'] = 'translations';
        $data['title'] = t('Terjemahan', 'Translations');
        $data['translations'] = $this->Translation_model->get_all_keys();

        $this->form_validation->set_rules('key', 'Key', 'required|trim');
        if ($this->form_validation->run()) {
            $this->Translation_model->update(
                $this->input->post('key'),
                $this->input->post('value_id'),
                $this->input->post('value_en')
            );
            $this->session->set_flashdata('success', t('Terjemahan disimpan!', 'Translation saved!'));
            redirect('admin/translations');
        }

        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/translations/list', $data);
        $this->load->view('templates/admin_footer');
    }

    // ================ SETTINGS ================
    public function settings($group = 'general') {
        $valid_groups = array('general', 'appearance', 'hero', 'homepage', 'social', 'footer', 'payment');
        if (!in_array($group, $valid_groups)) $group = 'general';

        // Auto-seed payment settings if not exist
        if ($group === 'payment') {
            $defaults = array(
                array('key' => 'pakasir_slug',           'value' => '',  'type' => 'text',    'group' => 'payment', 'label' => 'Pakasir Project Slug'),
                array('key' => 'pakasir_api_key',        'value' => '',  'type' => 'text',    'group' => 'payment', 'label' => 'Pakasir API Key'),
                array('key' => 'pakasir_sandbox',        'value' => '1', 'type' => 'boolean', 'group' => 'payment', 'label' => 'Pakasir Sandbox Mode'),
                array('key' => 'payment_method_qris',          'value' => '1', 'type' => 'boolean', 'group' => 'payment', 'label' => 'QRIS'),
                array('key' => 'payment_method_bri_va',        'value' => '1', 'type' => 'boolean', 'group' => 'payment', 'label' => 'BRI Virtual Account'),
                array('key' => 'payment_method_bni_va',        'value' => '1', 'type' => 'boolean', 'group' => 'payment', 'label' => 'BNI Virtual Account'),
                array('key' => 'payment_method_cimb_niaga_va', 'value' => '1', 'type' => 'boolean', 'group' => 'payment', 'label' => 'CIMB Niaga Virtual Account'),
                array('key' => 'payment_method_maybank_va',    'value' => '1', 'type' => 'boolean', 'group' => 'payment', 'label' => 'Maybank Virtual Account'),
                array('key' => 'payment_method_permata_va',    'value' => '1', 'type' => 'boolean', 'group' => 'payment', 'label' => 'Permata Virtual Account'),
                array('key' => 'payment_method_atm_bersama_va','value' => '1', 'type' => 'boolean', 'group' => 'payment', 'label' => 'ATM Bersama Virtual Account'),
                array('key' => 'payment_method_sampoerna_va',  'value' => '1', 'type' => 'boolean', 'group' => 'payment', 'label' => 'Sampoerna Virtual Account'),
                array('key' => 'payment_method_bnc_va',        'value' => '1', 'type' => 'boolean', 'group' => 'payment', 'label' => 'BNC Virtual Account'),
                array('key' => 'payment_method_artha_graha_va','value' => '1', 'type' => 'boolean', 'group' => 'payment', 'label' => 'Artha Graha Virtual Account'),
            );
            foreach ($defaults as $d) {
                if ($this->Setting_model->get($d['key']) === NULL) {
                    $this->Setting_model->set($d['key'], $d['value'], $d['type'], $d['group'], $d['label']);
                }
            }
        }

        $data['active_page'] = 'settings-' . $group;
        $data['title'] = t('Pengaturan', 'Settings');
        $data['page_title'] = t('Pengaturan ' . ucfirst($group), ucfirst($group) . ' Settings');
        $data['active_group'] = $group;
        $data['settings'] = $this->Setting_model->get_all($group);

        if ($this->input->method() === 'post') {
            $upload_path = './uploads/settings';
            if (!is_dir($upload_path)) mkdir($upload_path, 0777, TRUE);

            foreach ($data['settings'] as $s) {
                $val = $this->input->post($s->key);

                // Handle file uploads
                if ($s->type === 'image' && !empty($_FILES[$s->key]['name'])) {
                    $config = array(
                        'upload_path' => $upload_path,
                        'allowed_types' => 'jpg|jpeg|png|gif|ico|svg|webp',
                        'max_size' => 2048,
                        'file_name' => 'setting_' . $s->key . '_' . time()
                    );
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload($s->key)) {
                        $val = $this->upload->data('file_name');
                        // Delete old file
                        $old = $this->Setting_model->get($s->key);
                        if ($old && $old !== '' && file_exists($upload_path . '/' . $old)) {
                            @unlink($upload_path . '/' . $old);
                        }
                    } else {
                        $val = $this->input->post($s->key . '_existing') ?: '';
                    }
                } elseif ($s->type === 'boolean') {
                    $val = $this->input->post($s->key) ? '1' : '0';
                } elseif ($s->type === 'color') {
                    $val = $this->input->post($s->key) ?: '#0d6efd';
                }

                if ($val !== NULL) {
                    $this->Setting_model->set($s->key, $val, $s->type, $s->group, $s->label);
                }
            }

            $this->session->set_flashdata('success', t('Pengaturan berhasil disimpan!', 'Settings saved!'));
            redirect('admin/settings/' . $group);
        }

        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/settings/index', $data);
        $this->load->view('templates/admin_footer');
    }

    // ================ REFERENCE DOCUMENTS ================
    public function documents() {
        $data['active_page'] = 'documents';
        $data['title'] = t('Dokumen Referensi', 'Reference Documents');
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/partnership/index', $data);
        $this->load->view('templates/admin_footer');
    }

    public function document_view($key) {
        $allowed = array('partnership_discussion', 'business_discussion', 'business_plan');
        if (!in_array($key, $allowed)) show_404();

        $data['active_page'] = 'documents';
        $titles = array(
            'partnership_discussion' => t('Diskusi Partnership', 'Partnership Discussion'),
            'business_discussion' => t('Diskusi Bisnis', 'Business Discussion'),
            'business_plan' => t('Rencana Bisnis', 'Business Plan'),
        );
        $data['title'] = $titles[$key] ?? t('Dokumen', 'Document');

        $views = array(
            'partnership_discussion' => 'admin/partnership/discussion',
            'business_discussion' => 'admin/partnership/business_discussion',
            'business_plan' => 'admin/partnership/business_plan',
        );

        $this->load->view('templates/admin_header', $data);
        $this->load->view($views[$key], $data);
        $this->load->view('templates/admin_footer');
    }

    // ===== USER MANAGEMENT =====
    public function users() {
        $this->load->model('User_model');
        $role = $this->input->get('role');
        $status = $this->input->get('status');
        $search = $this->input->get('search');
        $data['users'] = $this->User_model->get_filtered($role, $status, $search);
        $data['total'] = $this->User_model->count_all($role, $status, $search);
        $data['active_page'] = 'users';
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/users/list', $data);
        $this->load->view('templates/admin_footer');
    }

    public function edit_user($id) {
        $this->load->model('User_model');
        $data['user'] = $this->User_model->get_user_by_id($id);
        if (!$data['user']) show_404();
        $data['enrolled_count'] = $this->User_model->get_user_enrolled_count($id);
        $data['active_page'] = 'users';
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/users/edit', $data);
        $this->load->view('templates/admin_footer');
    }

    public function update_user($id) {
        $this->load->model('User_model');
        $user = $this->User_model->get_user_by_id($id);
        if (!$user) show_404();
        $update_data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'role' => $this->input->post('role'),
            'status' => $this->input->post('status'),
        );
        $this->User_model->update_user($id, $update_data);
        $this->session->set_flashdata('success', t('User berhasil diperbarui.', 'User updated.'));
        redirect('admin/users');
    }

    public function delete_user($id) {
        $this->load->model('User_model');
        $this->User_model->update_user($id, array('status' => 'banned'));
        $this->session->set_flashdata('success', t('Akun dinonaktifkan.', 'Account disabled.'));
        redirect('admin/users');
    }

    // ===== COUPON MANAGEMENT =====
    public function coupons() {
        $data['coupons'] = $this->db->order_by('created_at', 'DESC')->get('coupons')->result();
        $data['active_page'] = 'coupons';
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/coupons/list', $data);
        $this->load->view('templates/admin_footer');
    }

    public function create_coupon() {
        $this->form_validation->set_rules('code', 'Code', 'required|is_unique[coupons.code]');
        if ($this->form_validation->run() === FALSE) {
            $data['active_page'] = 'coupons';
            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/coupons/create', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $this->db->insert('coupons', array(
                'code' => strtoupper($this->input->post('code')),
                'discount_type' => $this->input->post('discount_type'),
                'discount_value' => $this->input->post('discount_value'),
                'min_purchase' => $this->input->post('min_purchase') ?: 0,
                'max_uses' => $this->input->post('max_uses') ?: null,
                'expired_at' => $this->input->post('expired_at') ?: null,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ));
            $this->session->set_flashdata('success', t('Kupon berhasil dibuat.', 'Coupon created.'));
            redirect('admin/coupons');
        }
    }

    public function delete_coupon($id) {
        $this->db->where('id', $id)->delete('coupons');
        $this->session->set_flashdata('success', t('Kupon berhasil dihapus.', 'Coupon deleted.'));
        redirect('admin/coupons');
    }

    // ===== CATEGORY MANAGEMENT =====
    public function categories() {
        $this->load->model('Course_model');
        $data['categories'] = $this->Course_model->get_all_categories_tree();
        $data['active_page'] = 'settings-general';
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/categories/list', $data);
        $this->load->view('templates/admin_footer');
    }

    public function create_category() {
        $this->load->model('Course_model');
        $this->form_validation->set_rules('name', 'Name', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['categories'] = $this->Course_model->get_root_categories();
            $data['active_page'] = 'settings-general';
            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/categories/create', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $slug = url_title($this->input->post('name'), 'dash', TRUE);
            $this->Course_model->create_category(array(
                'name' => $this->input->post('name'),
                'name_en' => $this->input->post('name_en') ?: '',
                'slug' => $slug . '-' . time(),
                'parent_id' => $this->input->post('parent_id') ?: null,
                'icon' => $this->input->post('icon') ?: '',
                'description' => $this->input->post('description') ?: '',
                'description_en' => $this->input->post('description_en') ?: '',
                'sort_order' => $this->input->post('sort_order') ?: 0,
            ));
            $this->session->set_flashdata('success', t('Kategori berhasil dibuat.', 'Category created.'));
            redirect('admin/categories');
        }
    }

    public function edit_category($id) {
        $this->load->model('Course_model');
        $data['category'] = $this->Course_model->get_category_by_id($id);
        if (!$data['category']) show_404();
        $data['categories'] = $this->Course_model->get_root_categories();
        $data['active_page'] = 'settings-general';
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/categories/edit', $data);
        $this->load->view('templates/admin_footer');
    }

    public function update_category($id) {
        $this->load->model('Course_model');
        $this->form_validation->set_rules('name', 'Name', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['category'] = $this->Course_model->get_category_by_id($id);
            $data['categories'] = $this->Course_model->get_root_categories();
            $data['active_page'] = 'settings-general';
            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/categories/edit', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $this->Course_model->update_category($id, array(
                'name' => $this->input->post('name'),
                'name_en' => $this->input->post('name_en') ?: '',
                'parent_id' => $this->input->post('parent_id') ?: null,
                'icon' => $this->input->post('icon') ?: '',
                'description' => $this->input->post('description') ?: '',
                'description_en' => $this->input->post('description_en') ?: '',
                'sort_order' => $this->input->post('sort_order') ?: 0,
            ));
            $this->session->set_flashdata('success', t('Kategori berhasil diperbarui.', 'Category updated.'));
            redirect('admin/categories');
        }
    }

    public function delete_category($id) {
        $this->load->model('Course_model');
        $this->Course_model->delete_category($id);
        $this->session->set_flashdata('success', t('Kategori berhasil dihapus.', 'Category deleted.'));
        redirect('admin/categories');
    }

    // ===== ESSAY GRADING =====
    public function grade_essays($quiz_id) {
        $this->load->model('Quiz_model');
        $data['quiz'] = $this->Quiz_model->get_quiz_by_id($quiz_id);
        if (!$data['quiz']) show_404();

        $data['attempts'] = $this->db
            ->select('quiz_attempts.*, users.name as user_name')
            ->from('quiz_attempts')
            ->join('users', 'users.id = quiz_attempts.user_id')
            ->where('quiz_attempts.quiz_id', $quiz_id)
            ->where('quiz_attempts.answers IS NOT NULL')
            ->order_by('quiz_attempts.finished_at', 'DESC')
            ->get()->result();

        $data['active_page'] = 'courses';
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/quizzes/grade_essays', $data);
        $this->load->view('templates/admin_footer');
    }

    public function save_essay_grade($attempt_id, $question_idx) {
        $score = $this->input->post('score');
        $attempt = $this->db->where('id', $attempt_id)->get('quiz_attempts')->row();
        if (!$attempt) show_404();

        $answers = json_decode($attempt->answers, true);
        if (isset($answers[$question_idx])) {
            $answers[$question_idx]['essay_score'] = (int)$score;
        }

        // Recalculate total
        $total = 0;
        foreach ($answers as $a) {
            $total += isset($a['essay_score']) ? $a['essay_score'] : ($a['score'] ?? 0);
        }

        $this->db->where('id', $attempt_id)->update('quiz_attempts', array(
            'answers' => json_encode($answers),
            'score' => $total,
        ));

        $this->session->set_flashdata('success', t('Nilai essay disimpan.', 'Essay grade saved.'));
        redirect('admin/grade_essays/' . $attempt->quiz_id);
    }

    // ===== PACKAGE MANAGEMENT =====
    public function packages() {
        $data['packages'] = $this->Package_model->get_packages(false);
        $data['active_page'] = 'packages';
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/packages/list', $data);
        $this->load->view('templates/admin_footer');
    }

    public function create_package() {
        $this->form_validation->set_rules('name', t('Nama Paket', 'Package Name'), 'required|trim');
        $this->form_validation->set_rules('price', t('Harga', 'Price'), 'required|numeric');
        $this->form_validation->set_rules('duration_days', t('Durasi (hari)', 'Duration (days)'), 'required|numeric');

        if ($this->form_validation->run() === FALSE) {
            $data['active_page'] = 'packages';
            $data['categories'] = $this->Course_model->get_categories();
            $data['courses'] = $this->Course_model->get_courses(array('status' => 'all'));
            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/packages/create', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $slug = url_title($this->input->post('name'), 'dash', TRUE) . '-' . time();
            $package_id = $this->Package_model->create_package(array(
                'name' => $this->input->post('name'),
                'name_en' => $this->input->post('name_en') ?: '',
                'slug' => $slug,
                'description' => $this->input->post('description') ?: '',
                'description_en' => $this->input->post('description_en') ?: '',
                'price' => $this->input->post('price'),
                'duration_days' => $this->input->post('duration_days'),
                'discount_6mo' => $this->input->post('discount_6mo') ?: 0,
                'access_scope' => $this->input->post('access_scope') ?: 'all',
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'sort_order' => $this->input->post('sort_order') ?: 0,
            ));

            $this->_save_package_items($package_id);
            $this->session->set_flashdata('success', t('Paket berhasil dibuat.', 'Package created.'));
            redirect('admin/packages');
        }
    }

    public function edit_package($id) {
        $package = $this->Package_model->get_package_by_id($id);
        if (!$package) show_404();

        $this->form_validation->set_rules('name', t('Nama Paket', 'Package Name'), 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $data['active_page'] = 'packages';
            $data['package'] = $package;
            $data['existing_items'] = $this->Package_model->get_package_items($id);
            $data['categories'] = $this->Course_model->get_categories();
            $data['courses'] = $this->Course_model->get_courses(array('status' => 'all'));
            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/packages/edit', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $this->Package_model->update_package($id, array(
                'name' => $this->input->post('name'),
                'name_en' => $this->input->post('name_en') ?: '',
                'description' => $this->input->post('description') ?: '',
                'description_en' => $this->input->post('description_en') ?: '',
                'price' => $this->input->post('price'),
                'duration_days' => $this->input->post('duration_days'),
                'discount_6mo' => $this->input->post('discount_6mo') ?: 0,
                'access_scope' => $this->input->post('access_scope') ?: 'all',
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'sort_order' => $this->input->post('sort_order') ?: 0,
            ));

            $this->_save_package_items($id);
            $this->session->set_flashdata('success', t('Paket berhasil diperbarui.', 'Package updated.'));
            redirect('admin/packages');
        }
    }

    public function delete_package($id) {
        $this->Package_model->delete_package($id);
        $this->session->set_flashdata('success', t('Paket berhasil dihapus.', 'Package deleted.'));
        redirect('admin/packages');
    }

    private function _save_package_items($package_id) {
        $items = array();
        if ($this->input->post('access_scope') === 'category') {
            $category_ids = $this->input->post('categories') ?: array();
            foreach ($category_ids as $cat_id) {
                $items[] = array('item_type' => 'category', 'item_id' => (int)$cat_id);
            }
        } elseif ($this->input->post('access_scope') === 'course') {
            $course_ids = $this->input->post('courses') ?: array();
            foreach ($course_ids as $course_id) {
                $items[] = array('item_type' => 'course', 'item_id' => (int)$course_id);
            }
        }
        $this->Package_model->set_package_items($package_id, $items);
    }

}
