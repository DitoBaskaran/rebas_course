<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Lessons extends Api_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Lesson_model');
        $this->load->model('Course_model');
        $this->load->model('Course_enrollment_model');
        $this->load->model('Progress_model');
    }
    
    /**
     * GET /api/lessons/:id
     * Get lesson detail
     */
    public function show($id) {
        $lesson = $this->Lesson_model->get_lesson_by_id($id);
        
        if (!$lesson) {
            $this->response_error('Lesson not found', 404);
        }
        
        // Check access
        $course = $this->Course_model->get_course_by_id($lesson->course_id);
        
        if (!$course) {
            $this->response_error('Course not found', 404);
        }
        
        $is_enrolled = false;
        if ($this->user_id) {
            $enrollment = $this->Course_enrollment_model->get_enrollment($this->user_id, $lesson->course_id);
            $is_enrolled = $enrollment ? true : false;
        }
        
        $data = format_lesson_for_api($lesson);
        
        // Hide content if not enrolled and not free preview
        if (!$is_enrolled && !$lesson->is_free_preview) {
            $data['video_url'] = null;
            $data['content'] = null;
            $data['message'] = 'Please enroll to access this lesson';
        }
        
        $this->response($data);
    }
    
    /**
     * POST /api/lessons/:id/complete
     * Mark lesson as complete
     */
    public function complete($id) {
        $this->require_auth();
        
        $lesson = $this->Lesson_model->get_lesson_by_id($id);
        
        if (!$lesson) {
            $this->response_error('Lesson not found', 404);
        }
        
        // Check enrollment
        $enrollment = $this->Course_enrollment_model->get_enrollment($this->user_id, $lesson->course_id);
        
        if (!$enrollment) {
            $this->response_error('Not enrolled in this course', 403);
        }
        
        // Check if already completed
        $existing = $this->Progress_model->get_lesson_progress($this->user_id, $id);
        
        if ($existing) {
            $this->response_error('Lesson already completed', 400);
        }
        
        // Mark as complete
        $progress_data = [
            'user_id' => $this->user_id,
            'lesson_id' => $id,
            'completed_at' => date('Y-m-d H:i:s')
        ];
        
        $progress_id = $this->Progress_model->mark_lesson_complete($progress_data);
        
        if ($progress_id) {
            // Check if course completed
            $course_progress = $this->Progress_model->get_course_progress($this->user_id, $lesson->course_id);
            
            $response = [
                'progress_id' => $progress_id,
                'course_progress' => $course_progress
            ];
            
            // Award points if gamification enabled
            $this->load->helper('gamification');
            if (function_exists('award_points')) {
                $points_awarded = award_points($this->user_id, 'complete_lesson', $lesson->id);
                $response['points_awarded'] = $points_awarded;
            }
            
            $this->response($response, 201, 'Lesson completed');
        }
        
        $this->response_error('Failed to mark lesson complete', 500);
    }
}
