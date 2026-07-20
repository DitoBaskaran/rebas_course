<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * API Base Controller
 * Base class for all API endpoints
 */
class Api_Controller extends CI_Controller {
    
    protected $current_user = null;
    protected $user_id = null;
    
    public function __construct() {
        parent::__construct();
        
        // Load required libraries and helpers
        $this->load->library('jwt_library');
        $this->load->helper('api');
        $this->load->helper('uuid');
        
        // Set CORS headers
        $this->set_cors_headers();
        
        // Handle preflight requests
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            $this->output->set_status_header(200)->set_output('')->_display();
            exit;
        }
        
        // Authenticate user (except for public endpoints)
        $this->authenticate();
    }
    
    /**
     * Set CORS headers
     */
    private function set_cors_headers() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        header('Access-Control-Max-Age: 86400');
    }
    
    /**
     * Authenticate user from JWT token
     */
    private function authenticate() {
        $auth_header = $this->input->get_request_header('Authorization');
        
        if (!$auth_header) {
            return; // Will be checked in require_auth()
        }
        
        // Extract token from "Bearer <token>"
        if (preg_match('/Bearer\s+(.*)$/i', $auth_header, $matches)) {
            $token = $matches[1];
            $payload = $this->jwt_library->decode($token);
            
            if ($payload && isset($payload['user_id'])) {
                $this->user_id = $payload['user_id'];
                $this->load->model('User_model');
                $this->current_user = $this->User_model->get_user_by_id($this->user_id);
            }
        }
    }
    
    /**
     * Require authentication
     */
    protected function require_auth() {
        if (!$this->current_user) {
            $this->response_error('Unauthorized', 401);
        }
    }
    
    /**
     * Require admin role
     */
    protected function require_admin() {
        $this->require_auth();
        
        if ($this->current_user->role !== 'admin') {
            $this->response_error('Forbidden', 403);
        }
    }
    
    /**
     * Get JSON input data
     */
    protected function get_json_input() {
        $input = file_get_contents('php://input');
        return json_decode($input, true) ?: [];
    }
    
    /**
     * Send JSON response
     */
    protected function response($data, $status_code = 200, $message = null) {
        $response = [
            'success' => $status_code >= 200 && $status_code < 300,
            'data' => $data
        ];
        
        if ($message) {
            $response['message'] = $message;
        }
        
        $this->output
            ->set_status_header($status_code)
            ->set_content_type('application/json')
            ->set_output(json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }
    
    /**
     * Send error response
     */
    protected function response_error($message, $status_code = 400, $errors = null) {
        $response = [
            'success' => false,
            'message' => $message
        ];
        
        if ($errors) {
            $response['errors'] = $errors;
        }
        
        $this->output
            ->set_status_header($status_code)
            ->set_content_type('application/json')
            ->set_output(json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }
    
    /**
     * Get pagination parameters
     */
    protected function get_pagination() {
        $page = (int)$this->input->get('page') ?: 1;
        $per_page = (int)$this->input->get('per_page') ?: 20;
        
        // Limit per_page to max 100
        if ($per_page > 100) {
            $per_page = 100;
        }
        
        $offset = ($page - 1) * $per_page;
        
        return [
            'page' => $page,
            'per_page' => $per_page,
            'offset' => $offset
        ];
    }
    
    /**
     * Format paginated response
     */
    protected function response_paginated($data, $total, $pagination) {
        $response = [
            'success' => true,
            'data' => $data,
            'pagination' => [
                'current_page' => $pagination['page'],
                'per_page' => $pagination['per_page'],
                'total' => $total,
                'total_pages' => ceil($total / $pagination['per_page'])
            ]
        ];
        
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }
}
