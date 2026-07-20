<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Learning_Paths extends Api_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Learning_path_model');
    }
    
    /**
     * GET /api/learning-paths
     */
    public function index() {
        $pagination = $this->get_pagination();
        
        $paths = $this->Learning_path_model->get_all_paths($pagination['per_page'], $pagination['offset']);
        $total = $this->Learning_path_model->count_paths();
        
        $formatted = array_map(function($path) {
            return [
                'id' => $path->id,
                'title' => $path->title,
                'slug' => $path->slug,
                'description' => $path->description,
                'image' => $path->image,
                'total_courses' => (int)$path->total_courses,
                'total_students' => (int)$path->total_students
            ];
        }, $paths);
        
        $this->response_paginated($formatted, $total, $pagination);
    }
    
    /**
     * GET /api/learning-paths/:id
     */
    public function show($id) {
        $path = $this->Learning_path_model->get_path_by_id($id);
        
        if (!$path) {
            $this->response_error('Learning path not found', 404);
        }
        
        $courses = $this->Learning_path_model->get_path_courses($id);
        
        $data = [
            'id' => $path->id,
            'title' => $path->title,
            'slug' => $path->slug,
            'description' => $path->description,
            'image' => $path->image,
            'courses' => array_map(function($course) {
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'slug' => $course->slug,
                    'thumbnail' => $course->thumbnail,
                    'sort_order' => (int)$course->sort_order
                ];
            }, $courses)
        ];
        
        $this->response($data);
    }
    
    /**
     * POST /api/learning-paths/:id/enroll
     */
    public function enroll($id) {
        $this->require_auth();
        
        $path = $this->Learning_path_model->get_path_by_id($id);
        if (!$path) {
            $this->response_error('Learning path not found', 404);
        }
        
        $existing = $this->Learning_path_model->check_enrollment($this->user_id, $id);
        if ($existing) {
            $this->response_error('Already enrolled', 400);
        }
        
        $enrolled = $this->Learning_path_model->enroll_user($this->user_id, $id);
        
        if ($enrolled) {
            $this->response(null, 201, 'Enrolled successfully');
        }
        
        $this->response_error('Enrollment failed', 500);
    }
    
    /**
     * GET /api/learning-paths/mine
     */
    public function mine() {
        $this->require_auth();
        
        $paths = $this->Learning_path_model->get_user_paths($this->user_id);
        
        $formatted = array_map(function($path) {
            return [
                'id' => $path->id,
                'title' => $path->title,
                'slug' => $path->slug,
                'image' => $path->image,
                'progress' => (int)$path->progress,
                'started_at' => $path->started_at
            ];
        }, $paths);
        
        $this->response($formatted);
    }
}
