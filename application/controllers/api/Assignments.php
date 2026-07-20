<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Assignments extends Api_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Assignment_model');
        $this->load->model('Submission_model');
        $this->load->model('Course_model');
        $this->load->model('Course_enrollment_model');
    }
    
    /**
     * GET /api/assignments/:id
     * Get assignment detail
     */
    public function show($id) {
        $assignment = $this->Assignment_model->get_assignment_by_id($id);
        
        if (!$assignment) {
            $this->response_error('Assignment not found', 404);
        }
        
        $data = [
            'id' => $assignment->id,
            'course_id' => $assignment->course_id,
            'lesson_id' => $assignment->lesson_id,
            'title' => $assignment->title,
            'description' => $assignment->description,
            'instructions' => $assignment->instructions,
            'attachment' => $assignment->attachment,
            'max_score' => (int)$assignment->max_score,
            'due_days' => (int)$assignment->due_days,
            'allowed_file_types' => $assignment->allowed_file_types,
            'created_at' => $assignment->created_at
        ];
        
        // Add course info
        $course = $this->Course_model->get_course_by_id($assignment->course_id);
        if ($course) {
            $data['course'] = [
                'id' => $course->id,
                'title' => $course->title,
                'slug' => $course->slug
            ];
        }
        
        // Check user submission
        if ($this->user_id) {
            $submission = $this->Submission_model->get_user_submission($this->user_id, $id);
            if ($submission) {
                $data['submission'] = [
                    'id' => $submission->id,
                    'file_url' => $submission->file_url,
                    'text_body' => $submission->text_body,
                    'grade' => $submission->grade,
                    'feedback' => $submission->feedback,
                    'status' => $submission->status,
                    'submitted_at' => $submission->submitted_at,
                    'graded_at' => $submission->graded_at
                ];
            }
        }
        
        $this->response($data);
    }
    
    /**
     * POST /api/assignments/:id/submit
     * Submit assignment
     */
    public function submit($id) {
        $this->require_auth();
        
        $assignment = $this->Assignment_model->get_assignment_by_id($id);
        
        if (!$assignment) {
            $this->response_error('Assignment not found', 404);
        }
        
        // Check enrollment
        $enrollment = $this->Course_enrollment_model->get_enrollment($this->user_id, $assignment->course_id);
        if (!$enrollment) {
            $this->response_error('Not enrolled in this course', 403);
        }
        
        // Check if already submitted
        $existing = $this->Submission_model->get_user_submission($this->user_id, $id);
        if ($existing && $existing->status !== 'returned') {
            $this->response_error('Assignment already submitted', 400);
        }
        
        $input = $this->get_json_input();
        
        $submission_data = [
            'assignment_id' => $id,
            'user_id' => $this->user_id,
            'text_body' => $input['text_body'] ?? '',
            'notes' => $input['notes'] ?? '',
            'status' => 'submitted',
            'submitted_at' => date('Y-m-d H:i:s')
        ];
        
        // Handle file upload if any
        if (!empty($_FILES['file'])) {
            $this->load->helper('upload');
            $upload_result = upload_file('file', 'assignments');
            
            if (!$upload_result['success']) {
                $this->response_error('Upload failed: ' . $upload_result['error']);
            }
            
            $submission_data['file_url'] = $upload_result['path'];
        }
        
        if ($existing && $existing->status === 'returned') {
            // Update existing submission
            $updated = $this->Submission_model->update_submission($existing->id, $submission_data);
            if ($updated) {
                $this->response(['submission_id' => $existing->id], 200, 'Assignment re-submitted');
            }
        } else {
            // Create new submission
            $submission_id = $this->Submission_model->create_submission($submission_data);
            if ($submission_id) {
                $this->response(['submission_id' => $submission_id], 201, 'Assignment submitted');
            }
        }
        
        $this->response_error('Failed to submit assignment', 500);
    }
}
