<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Certificates extends Api_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Certificate_model');
        $this->load->model('Course_model');
    }
    
    /**
     * GET /api/certificates
     * Get user's certificates
     */
    public function index() {
        $this->require_auth();
        
        $certificates = $this->Certificate_model->get_user_certificates($this->user_id);
        
        $formatted = array_map(function($cert) {
            $data = format_certificate_for_api($cert);
            
            $course = $this->Course_model->get_course_by_id($cert->course_id);
            if ($course) {
                $data['course'] = [
                    'id' => $course->id,
                    'title' => $course->title,
                    'slug' => $course->slug,
                    'thumbnail' => $course->thumbnail
                ];
            }
            
            return $data;
        }, $certificates);
        
        $this->response($formatted);
    }
    
    /**
     * GET /api/certificates/:code
     * Verify certificate
     */
    public function verify($code) {
        $certificate = $this->Certificate_model->get_certificate_by_code($code);
        
        if (!$certificate) {
            $this->response_error('Certificate not found', 404);
        }
        
        $data = format_certificate_for_api($certificate);
        
        // Add user info
        $this->load->model('User_model');
        $user = $this->User_model->get_user_by_id($certificate->user_id);
        if ($user) {
            $data['user'] = [
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->avatar
            ];
        }
        
        // Add course info
        $course = $this->Course_model->get_course_by_id($certificate->course_id);
        if ($course) {
            $data['course'] = [
                'id' => $course->id,
                'title' => $course->title,
                'slug' => $course->slug
            ];
        }
        
        $this->response($data);
    }
}
