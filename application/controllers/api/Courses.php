<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Courses extends Api_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Course_model');
        $this->load->model('Category_model');
        $this->load->model('Tag_model');
        $this->load->model('Lesson_model');
        $this->load->model('Course_enrollment_model');
        $this->load->model('Progress_model');
    }
    
    /**
     * GET /api/courses
     * List courses with filters
     */
    public function index() {
        $pagination = $this->get_pagination();
        
        $filters = [
            'category_id' => $this->input->get('category_id'),
            'tag' => $this->input->get('tag'),
            'search' => $this->input->get('search'),
            'level' => $this->input->get('level'),
            'min_price' => $this->input->get('min_price'),
            'max_price' => $this->input->get('max_price'),
            'sort' => $this->input->get('sort') ?? 'newest'
        ];
        
        $courses = $this->Course_model->get_courses($filters, $pagination['per_page'], $pagination['offset']);
        $total = $this->Course_model->count_courses($filters);
        
        $formatted_courses = array_map(function($course) {
            return format_course_for_api($course);
        }, $courses);
        
        $this->response_paginated($formatted_courses, $total, $pagination);
    }
    
    /**
     * GET /api/courses/featured
     * Get featured courses
     */
    public function featured() {
        $limit = (int)$this->input->get('limit') ?: 10;
        $courses = $this->Course_model->get_featured_courses($limit);
        
        $formatted_courses = array_map(function($course) {
            return format_course_for_api($course);
        }, $courses);
        
        $this->response($formatted_courses);
    }
    
    /**
     * GET /api/courses/:id
     * Get course detail
     */
    public function show($id) {
        $course = $this->Course_model->get_course_by_id($id);
        
        if (!$course) {
            $this->response_error('Course not found', 404);
        }
        
        $course_data = format_course_for_api($course);
        
        // Add mentor info
        $this->load->model('User_model');
        $mentor = $this->User_model->get_user_by_id($course->mentor_id);
        if ($mentor) {
            $course_data['mentor'] = [
                'id' => $mentor->id,
                'name' => $mentor->name,
                'avatar' => $mentor->avatar,
                'bio' => $mentor->bio
            ];
        }
        
        // Add category info
        $category = $this->Category_model->get_category_by_id($course->category_id);
        if ($category) {
            $course_data['category'] = [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug
            ];
        }
        
        // Add tags
        $tags = $this->Tag_model->get_tags_by_course($id);
        $course_data['tags'] = $tags;
        
        // Check if user enrolled
        if ($this->user_id) {
            $enrollment = $this->Course_enrollment_model->get_enrollment($this->user_id, $id);
            $course_data['is_enrolled'] = $enrollment ? true : false;
            
            if ($enrollment) {
                $progress = $this->Progress_model->get_course_progress($this->user_id, $id);
                $course_data['progress'] = $progress;
            }
        }
        
        $this->response($course_data);
    }
    
    /**
     * GET /api/courses/:id/lessons
     * Get lessons for a course
     */
    public function lessons($id) {
        $course = $this->Course_model->get_course_by_id($id);
        
        if (!$course) {
            $this->response_error('Course not found', 404);
        }
        
        $lessons = $this->Lesson_model->get_lessons_by_course($id);
        
        // Check if user enrolled
        $is_enrolled = false;
        if ($this->user_id) {
            $enrollment = $this->Course_enrollment_model->get_enrollment($this->user_id, $id);
            $is_enrolled = $enrollment ? true : false;
        }
        
        $formatted_lessons = array_map(function($lesson) use ($is_enrolled) {
            $data = format_lesson_for_api($lesson);
            
            // Hide video URL if not enrolled and not free preview
            if (!$is_enrolled && !$lesson->is_free_preview) {
                $data['video_url'] = null;
                $data['content'] = null;
            }
            
            return $data;
        }, $lessons);
        
        $this->response($formatted_lessons);
    }
    
    /**
     * GET /api/courses/:id/progress
     * Get user progress for a course
     */
    public function progress($id) {
        $this->require_auth();
        
        $course = $this->Course_model->get_course_by_id($id);
        
        if (!$course) {
            $this->response_error('Course not found', 404);
        }
        
        $progress = $this->Progress_model->get_course_progress($this->user_id, $id);
        
        $this->response($progress);
    }
    
    /**
     * POST /api/courses/:id/enroll
     * Enroll in a course
     */
    public function enroll($id) {
        $this->require_auth();
        
        $course = $this->Course_model->get_course_by_id($id);
        
        if (!$course) {
            $this->response_error('Course not found', 404);
        }
        
        // Check if already enrolled
        $existing = $this->Course_enrollment_model->get_enrollment($this->user_id, $id);
        
        if ($existing) {
            $this->response_error('Already enrolled', 400);
        }
        
        // Check if course is free
        if ($course->price > 0) {
            $this->response_error('This is a paid course. Please checkout first.', 400);
        }
        
        // Enroll user
        $enrollment_data = [
            'user_id' => $this->user_id,
            'course_id' => $id,
            'enrolled_at' => date('Y-m-d H:i:s')
        ];
        
        $enrollment_id = $this->Course_enrollment_model->create_enrollment($enrollment_data);
        
        if ($enrollment_id) {
            // Update course student count
            $this->db->where('id', $id)->set('total_students', 'total_students + 1', FALSE)->update('courses');
            
            $this->response(['enrollment_id' => $enrollment_id], 201, 'Enrolled successfully');
        }
        
        $this->response_error('Enrollment failed', 500);
    }
}
