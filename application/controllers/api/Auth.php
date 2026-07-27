<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Auth extends Api_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Setting_model');
        $this->load->helper('oauth');
    }
    
    /**
     * POST /api/auth/login
     */
    public function login() {
        $input = $this->get_json_input();
        
        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            $this->response_error('Email and password are required');
        }
        
        $user = $this->User_model->login($email, $password);
        
        if (!$user) {
            $this->response_error('Invalid email or password', 401);
        }
        
        if ($user->status === 'banned') {
            $this->response_error('Account is banned', 403);
        }
        
        // Update last login
        $this->db->where('id', $user->id)->update('users', ['last_login' => date('Y-m-d H:i:s')]);
        
        // Generate JWT
        $token = $this->jwt_library->encode([
            'user_id' => $user->id,
            'role' => $user->role,
            'is_teacher' => $user->is_teacher,
            'is_mentor' => $user->is_mentor
        ]);
        
        $this->response([
            'token' => $token,
            'user' => format_user_for_api($user)
        ], 200, 'Login successful');
    }
    
    /**
     * POST /api/auth/register
     */
    public function register() {
        $input = $this->get_json_input();
        
        $this->load->library('form_validation');
        $this->form_validation->set_data($input);
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        
        if ($this->form_validation->run() === FALSE) {
            $this->response_error('Validation failed', 422, $this->form_validation->error_array());
        }
        
        $data = [
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
            'role' => 'student',
            'language' => $input['language'] ?? 'id'
        ];
        
        if ($this->User_model->register($data)) {
            $user = $this->db->where('email', $input['email'])->get('users')->row();
            
            $this->response(format_user_for_api($user), 201, 'Registration successful');
        }
        
        $this->response_error('Registration failed', 500);
    }
    
    /**
     * POST /api/auth/google
     */
    public function google() {
        $input = $this->get_json_input();
        $token = $input['token'] ?? '';
        
        if (empty($token)) {
            $this->response_error('Google token is required');
        }
        
        // Verify Google token using helper
        $this->load->helper('oauth');
        $google_user = google_verify_token($token);
        
        if (!$google_user || empty($google_user['email'])) {
            $this->response_error('Invalid Google token', 401);
        }
        
        $user = $this->db->where('email', $google_user['email'])->get('users')->row();
        
        if (!$user) {
            $password = bin2hex(random_bytes(16));
            $insert_data = [
                'name' => $google_user['name'],
                'email' => $google_user['email'],
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'google_id' => $google_user['sub'] ?? '',
                'role' => 'student',
                'avatar' => $google_user['picture'] ?? 'default_avatar.png',
                'language' => $input['language'] ?? 'id'
            ];
            
            $this->db->insert('users', $insert_data);
            $user = $this->db->where('email', $google_user['email'])->get('users')->row();
        } elseif (empty($user->google_id) && !empty($google_user['sub'])) {
            $this->db->where('id', $user->id)->update('users', ['google_id' => $google_user['sub']]);
        }
        
        if ($user->status === 'banned') {
            $this->response_error('Account is banned', 403);
        }
        
        $this->db->where('id', $user->id)->update('users', ['last_login' => date('Y-m-d H:i:s')]);
        
        $jwt = $this->jwt_library->encode([
            'user_id' => $user->id,
            'role' => $user->role,
            'is_teacher' => $user->is_teacher,
            'is_mentor' => $user->is_mentor
        ]);
        
        $this->response([
            'token' => $jwt,
            'user' => format_user_for_api($user)
        ], 200, 'Google login successful');
    }
    
    /**
     * POST /api/auth/forgot-password
     */
    public function forgot_password() {
        $input = $this->get_json_input();
        $email = $input['email'] ?? '';
        
        if (empty($email)) {
            $this->response_error('Email is required');
        }
        
        $user = $this->db->where('email', $email)->get('users')->row();
        
        if ($user) {
            $token = bin2hex(random_bytes(32));
            $this->db->insert('password_resets', [
                'email' => $email,
                'token' => $token,
                'expired_at' => date('Y-m-d H:i:s', strtotime('+1 hour'))
            ]);
            
            // Send email via helper
            $this->load->helper('mail');
            $reset_link = base_url('auth/reset_password/' . $token);
            $subject = 'Reset Password - ' . setting('general_site_name', 'BISATUNTAS');
            $body = 'Klik link berikut untuk mereset password Anda: ' . $reset_link;
            send_email($email, $subject, $body);
        }
        
        // Always return success to prevent email enumeration
        $this->response(null, 200, 'If email is registered, a reset link has been sent');
    }
    
    /**
     * POST /api/auth/reset-password
     */
    public function reset_password() {
        $input = $this->get_json_input();
        
        $token = $input['token'] ?? '';
        $password = $input['password'] ?? '';
        
        if (empty($token) || empty($password)) {
            $this->response_error('Token and password are required');
        }
        
        $reset = $this->db
            ->where('token', $token)
            ->where('expired_at >=', date('Y-m-d H:i:s'))
            ->where('used_at IS NULL')
            ->get('password_resets')
            ->row();
        
        if (!$reset) {
            $this->response_error('Invalid or expired token', 400);
        }
        
        $this->db->where('email', $reset->email)->update('users', [
            'password' => password_hash($password, PASSWORD_BCRYPT)
        ]);
        
        $this->db->where('id', $reset->id)->update('password_resets', [
            'used_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->response(null, 200, 'Password reset successfully');
    }
    
    /**
     * GET /api/auth/me
     */
    public function me() {
        $this->require_auth();
        $this->response(format_user_for_api($this->current_user));
    }
    
    /**
     * POST /api/auth/logout
     */
    public function logout() {
        $this->require_auth();
        // With JWT, logout is handled client-side by discarding token
        $this->response(null, 200, 'Logged out successfully');
    }
}
