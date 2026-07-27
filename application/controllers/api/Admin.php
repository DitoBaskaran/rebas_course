<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Admin extends Api_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->require_admin();
        
        $this->load->model('Course_model');
        $this->load->model('User_model');
        $this->load->model('Category_model');
        $this->load->model('Lesson_model');
        $this->load->model('Quiz_model');
        $this->load->model('Assignment_model');
        $this->load->model('Transaction_model');
        $this->load->model('Package_model');
        $this->load->model('Seminar_model');
        $this->load->model('Tag_model');
    }
    
    /**
     * GET /api/admin/dashboard
     */
    public function dashboard() {
        $stats = [
            'total_users' => $this->db->count_all_results('users'),
            'total_students' => $this->db->where('role', 'student')->count_all_results('users'),
            'total_teachers' => $this->db->where('is_teacher', 1)->count_all_results('users'),
            'total_mentors' => $this->db->where('is_mentor', 1)->count_all_results('users'),
            'total_courses' => $this->Course_model->count_all_courses(),
            'total_seminars' => $this->Seminar_model->count_seminars(),
            'total_enrollments' => $this->db->count_all_results('enrollments'),
            'total_revenue' => (float)$this->db->select_sum('amount')
                ->where('status', 'completed')
                ->get('transactions')->row()->amount ?? 0,
            'pending_transactions' => $this->db->where('status', 'pending')
                ->count_all_results('transactions')
        ];
        
        // Recent enrollments
        $recent_enrollments = $this->db
            ->select('enrollments.*, users.name as user_name, courses.title as course_title')
            ->join('users', 'users.id = enrollments.user_id')
            ->join('courses', 'courses.id = enrollments.course_id')
            ->order_by('enrolled_at', 'DESC')
            ->limit(10)
            ->get('enrollments')
            ->result();
        
        $stats['recent_enrollments'] = array_map(function($e) {
            return [
                'user_name' => $e->user_name,
                'course_title' => $e->course_title,
                'enrolled_at' => $e->enrolled_at
            ];
        }, $recent_enrollments);
        
        $this->response($stats);
    }
    
    // ===== USERS MANAGEMENT =====
    
    /**
     * GET /api/admin/users
     */
    public function users() {
        $pagination = $this->get_pagination();
        $role = $this->input->get('role');
        $search = $this->input->get('search');
        
        $users = $this->User_model->get_filtered($role, $search, $pagination['per_page'], $pagination['offset']);
        $total = $this->User_model->count_filtered($role, $search);
        
        $formatted = array_map(function($user) {
            return format_user_for_api($user);
        }, $users);
        
        $this->response_paginated($formatted, $total, $pagination);
    }
    
    /**
     * PUT /api/admin/users/:id/status
     */
    public function update_user_status($id) {
        $input = $this->get_json_input();
        $status = $input['status'] ?? '';
        
        if (!in_array($status, ['active', 'banned'])) {
            $this->response_error('Invalid status');
        }
        
        $this->db->where('id', $id)->update('users', ['status' => $status]);
        $this->response(null, 200, 'User status updated');
    }
    
    /**
     * PUT /api/admin/users/:id/role
     */
    public function update_user_role($id) {
        $input = $this->get_json_input();
        $role = $input['role'] ?? '';
        
        if (!in_array($role, ['student', 'teacher', 'admin', 'mentor'])) {
            $this->response_error('Invalid role');
        }
        
        $update = ['role' => ($role === 'admin' ? 'admin' : 'student')];
        $update['is_teacher'] = ($role === 'teacher') ? 1 : 0;
        $update['is_mentor'] = ($role === 'mentor') ? 1 : 0;
        if ($role === 'admin') {
            $update['is_teacher'] = 0;
            $update['is_mentor'] = 0;
        }
        
        $this->db->where('id', $id)->update('users', $update);
        $this->response(null, 200, 'User role updated');
    }
    
    // ===== COURSES MANAGEMENT =====
    
    /**
     * GET /api/admin/courses
     */
    public function courses() {
        $pagination = $this->get_pagination();
        $status = $this->input->get('status');
        $search = $this->input->get('search');
        
        $courses = $this->Course_model->get_all_courses($status, $search, $pagination['per_page'], $pagination['offset']);
        $total = $this->Course_model->count_all_courses($status, $search);
        
        $formatted = array_map(function($course) {
            return format_course_for_api($course);
        }, $courses);
        
        $this->response_paginated($formatted, $total, $pagination);
    }
    
    /**
     * POST /api/admin/courses
     */
    public function create_course() {
        $input = $this->get_json_input();
        
        $required = ['title', 'mentor_id', 'price', 'description'];
        foreach ($required as $field) {
            if (empty($input[$field])) {
                $this->response_error("Field '$field' is required", 422);
            }
        }
        
        $course_data = [
            'title' => $input['title'],
            'description' => $input['description'],
            'category_id' => $input['category_id'] ?? null,
            'mentor_id' => $input['mentor_id'],
            'price' => $input['price'],
            'discount_price' => $input['discount_price'] ?? null,
            'thumbnail' => $input['thumbnail'] ?? 'default_course.png',
            'is_active' => $input['is_active'] ?? true,
            'is_featured' => $input['is_featured'] ?? false,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $course_id = $this->Course_model->create_course($course_data);
        
        if ($course_id) {
            $this->response(['course_id' => $course_id], 201, 'Course created');
        }
        
        $this->response_error('Failed to create course', 500);
    }
    
    /**
     * PUT /api/admin/courses/:id
     */
    public function update_course($id) {
        $input = $this->get_json_input();
        
        $course = $this->Course_model->get_course_by_id($id);
        if (!$course) {
            $this->response_error('Course not found', 404);
        }
        
        $update_data = array_filter([
            'title' => $input['title'] ?? null,
            'description' => $input['description'] ?? null,
            'category_id' => $input['category_id'] ?? null,
            'mentor_id' => $input['mentor_id'] ?? null,
            'price' => $input['price'] ?? null,
            'discount_price' => $input['discount_price'] ?? null,
            'thumbnail' => $input['thumbnail'] ?? null,
            'is_active' => $input['is_active'] ?? null,
            'is_featured' => $input['is_featured'] ?? null,
            'updated_at' => date('Y-m-d H:i:s')
        ], function($v) { return $v !== null; });
        
        $this->Course_model->update_course($id, $update_data);
        $this->response(null, 200, 'Course updated');
    }
    
    /**
     * DELETE /api/admin/courses/:id
     */
    public function delete_course($id) {
        $course = $this->Course_model->get_course_by_id($id);
        if (!$course) {
            $this->response_error('Course not found', 404);
        }
        
        $this->Course_model->delete_course($id);
        $this->response(null, 200, 'Course deleted');
    }
    
    // ===== TRANSACTIONS MANAGEMENT =====
    
    /**
     * GET /api/admin/transactions
     */
    public function transactions() {
        $pagination = $this->get_pagination();
        $status = $this->input->get('status');
        $search = $this->input->get('search');
        
        $transactions = $this->Transaction_model->get_all_transactions($status, $search, $pagination['per_page'], $pagination['offset']);
        $total = $this->Transaction_model->count_transactions($status, $search);
        
        $formatted = array_map(function($tx) {
            return format_transaction_for_api($tx);
        }, $transactions);
        
        $this->response_paginated($formatted, $total, $pagination);
    }
    
    /**
     * PUT /api/admin/transactions/:uuid/status
     */
    public function update_transaction_status($uuid) {
        $input = $this->get_json_input();
        $status = $input['status'] ?? '';
        $notes = $input['notes'] ?? '';
        
        if (!in_array($status, ['approved', 'rejected'])) {
            $this->response_error('Invalid status');
        }
        
        $tx = $this->Transaction_model->get_by_uuid($uuid);
        if (!$tx) {
            $this->response_error('Transaction not found', 404);
        }
        
        $this->Transaction_model->update_transaction($tx->id, [
            'status' => $status,
            'notes' => $notes,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        // If approved, enroll user
        if ($status === 'approved') {
            $this->load->model('Course_enrollment_model');
            
            if (in_array($tx->item_type, ['course', 'workshop', 'bootcamp', 'ebook', 'project'])) {
                $existing = $this->Course_enrollment_model->get_enrollment($tx->user_id, $tx->item_id);
                if (!$existing) {
                    $this->Course_enrollment_model->create_enrollment([
                        'user_id' => $tx->user_id,
                        'course_id' => $tx->item_id,
                        'enrolled_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }
        
        $this->response(null, 200, 'Transaction status updated');
    }
    
    // ===== CATEGORIES MANAGEMENT =====
    
    /**
     * POST /api/admin/categories
     */
    public function create_category() {
        $input = $this->get_json_input();
        
        if (empty($input['name']) || empty($input['slug'])) {
            $this->response_error('Name and slug are required', 422);
        }
        
        $cat_data = [
            'name' => $input['name'],
            'slug' => $input['slug'],
            'description' => $input['description'] ?? '',
            'icon' => $input['icon'] ?? '',
            'parent_id' => $input['parent_id'] ?? null,
            'sort_order' => $input['sort_order'] ?? 0
        ];
        
        $cat_id = $this->Category_model->create_category($cat_data);
        
        if ($cat_id) {
            $this->response(['category_id' => $cat_id], 201, 'Category created');
        }
        
        $this->response_error('Failed to create category', 500);
    }
    
    /**
     * PUT /api/admin/categories/:id
     */
    public function update_category($id) {
        $input = $this->get_json_input();
        
        $update_data = array_filter([
            'name' => $input['name'] ?? null,
            'slug' => $input['slug'] ?? null,
            'description' => $input['description'] ?? null,
            'icon' => $input['icon'] ?? null,
            'parent_id' => $input['parent_id'] ?? null,
            'sort_order' => $input['sort_order'] ?? null
        ], function($v) { return $v !== null; });
        
        $this->Category_model->update_category($id, $update_data);
        $this->response(null, 200, 'Category updated');
    }
    
    /**
     * DELETE /api/admin/categories/:id
     */
    public function delete_category($id) {
        $this->Category_model->delete_category($id);
        $this->response(null, 200, 'Category deleted');
    }
    
    // ===== LESSONS MANAGEMENT =====
    
    /**
     * POST /api/admin/courses/:course_id/lessons
     */
    public function create_lesson($course_id) {
        $input = $this->get_json_input();
        
        if (empty($input['title'])) {
            $this->response_error('Title is required', 422);
        }
        
        $lesson_data = [
            'course_id' => $course_id,
            'title' => $input['title'],
            'description' => $input['description'] ?? '',
            'content' => $input['content'] ?? '',
            'video_url' => $input['video_url'] ?? '',
            'duration' => $input['duration'] ?? 0,
            'sort_order' => $input['sort_order'] ?? 0,
            'is_free_preview' => $input['is_free_preview'] ?? false,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $lesson_id = $this->Lesson_model->create_lesson($lesson_data);
        
        if ($lesson_id) {
            $this->response(['lesson_id' => $lesson_id], 201, 'Lesson created');
        }
        
        $this->response_error('Failed to create lesson', 500);
    }
    
    /**
     * PUT /api/admin/lessons/:id
     */
    public function update_lesson($id) {
        $input = $this->get_json_input();
        
        $update_data = array_filter([
            'title' => $input['title'] ?? null,
            'description' => $input['description'] ?? null,
            'content' => $input['content'] ?? null,
            'video_url' => $input['video_url'] ?? null,
            'duration' => $input['duration'] ?? null,
            'sort_order' => $input['sort_order'] ?? null,
            'is_free_preview' => $input['is_free_preview'] ?? null,
            'updated_at' => date('Y-m-d H:i:s')
        ], function($v) { return $v !== null; });
        
        $this->Lesson_model->update_lesson($id, $update_data);
        $this->response(null, 200, 'Lesson updated');
    }
    
    /**
     * DELETE /api/admin/lessons/:id
     */
    public function delete_lesson($id) {
        $this->Lesson_model->delete_lesson($id);
        $this->response(null, 200, 'Lesson deleted');
    }
    
    // ===== SETTINGS =====
    
    /**
     * GET /api/admin/settings
     */
    public function settings() {
        $this->load->model('Setting_model');
        $settings = $this->Setting_model->get_all_settings();
        $this->response($settings);
    }
    
    /**
     * PUT /api/admin/settings
     */
    public function update_settings() {
        $this->load->model('Setting_model');
        $input = $this->get_json_input();
        
        foreach ($input as $key => $value) {
            $this->Setting_model->update_setting($key, $value);
        }
        
        $this->response(null, 200, 'Settings updated');
    }
}
