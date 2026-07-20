<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Users extends Api_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }
    
    /**
     * PUT /api/users/me
     */
    public function update_profile() {
        $this->require_auth();
        
        $input = $this->get_json_input();
        
        $update_data = [];
        
        if (isset($input['name'])) $update_data['name'] = $input['name'];
        if (isset($input['phone'])) $update_data['phone'] = $input['phone'];
        if (isset($input['bio'])) $update_data['bio'] = $input['bio'];
        if (isset($input['address'])) $update_data['address'] = $input['address'];
        if (isset($input['language'])) $update_data['language'] = $input['language'];
        
        if (empty($update_data)) {
            $this->response_error('No data to update');
        }
        
        $this->db->where('id', $this->user_id)->update('users', $update_data);
        
        $user = $this->User_model->get_user_by_id($this->user_id);
        $this->response(format_user_for_api($user), 200, 'Profile updated');
    }
    
    /**
     * PUT /api/users/me/password
     */
    public function change_password() {
        $this->require_auth();
        
        $input = $this->get_json_input();
        
        $current_password = $input['current_password'] ?? '';
        $new_password = $input['new_password'] ?? '';
        
        if (empty($current_password) || empty($new_password)) {
            $this->response_error('Current and new password are required');
        }
        
        if (!password_verify($current_password, $this->current_user->password)) {
            $this->response_error('Current password is incorrect', 400);
        }
        
        if (strlen($new_password) < 6) {
            $this->response_error('New password must be at least 6 characters', 422);
        }
        
        $this->db->where('id', $this->user_id)->update('users', [
            'password' => password_hash($new_password, PASSWORD_BCRYPT)
        ]);
        
        $this->response(null, 200, 'Password changed successfully');
    }
    
    /**
     * PUT /api/users/me/avatar
     */
    public function upload_avatar() {
        $this->require_auth();
        
        if (empty($_FILES['avatar'])) {
            $this->response_error('Avatar file is required');
        }
        
        $this->load->helper('upload');
        $upload_result = upload_file('avatar', 'avatars');
        
        if (!$upload_result['success']) {
            $this->response_error('Upload failed: ' . $upload_result['error']);
        }
        
        // Delete old avatar if exists
        if (!empty($this->current_user->avatar) && file_exists(FCPATH . $this->current_user->avatar)) {
            @unlink(FCPATH . $this->current_user->avatar);
        }
        
        $this->db->where('id', $this->user_id)->update('users', [
            'avatar' => $upload_result['path']
        ]);
        
        $this->response(['avatar_url' => base_url($upload_result['path'])], 200, 'Avatar uploaded');
    }
    
    /**
     * GET /api/users/me/enrollments
     */
    public function enrollments() {
        $this->require_auth();
        
        $this->load->model('Course_enrollment_model');
        $this->load->model('Progress_model');
        
        $enrollments = $this->Course_enrollment_model->get_user_enrollments($this->user_id);
        
        $formatted = array_map(function($enrollment) {
            $progress = $this->Progress_model->get_course_progress($this->user_id, $enrollment->course_id);
            
            return [
                'id' => $enrollment->id,
                'course' => [
                    'id' => $enrollment->course_id,
                    'title' => $enrollment->course_title,
                    'slug' => $enrollment->course_slug,
                    'thumbnail' => $enrollment->course_thumbnail
                ],
                'progress' => $progress,
                'enrolled_at' => $enrollment->enrolled_at
            ];
        }, $enrollments);
        
        $this->response($formatted);
    }
    
    /**
     * GET /api/users/me/transactions
     */
    public function transactions() {
        $this->require_auth();
        
        $this->load->model('Transaction_model');
        $transactions = $this->Transaction_model->get_user_transactions($this->user_id);
        
        $formatted = array_map(function($tx) {
            return format_transaction_for_api($tx);
        }, $transactions);
        
        $this->response($formatted);
    }
}
