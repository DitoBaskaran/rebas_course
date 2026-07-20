<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Contact extends Api_Controller {
    
    /**
     * POST /api/contact
     * Send contact message
     */
    public function send() {
        $input = $this->get_json_input();
        
        $this->load->library('form_validation');
        $this->form_validation->set_data($input);
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('subject', 'Subject', 'required|trim');
        $this->form_validation->set_rules('message', 'Message', 'required|trim');
        
        if ($this->form_validation->run() === FALSE) {
            $this->response_error('Validation failed', 422, $this->form_validation->error_array());
        }
        
        $message_data = [
            'name' => $input['name'],
            'email' => $input['email'],
            'subject' => $input['subject'],
            'message' => $input['message'],
            'user_id' => $this->user_id,
            'status' => 'new',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $message_id = $this->db->insert('contact_messages', $message_data);
        
        if ($message_id) {
            // Send notification email to admin
            $this->load->helper('mail');
            $admin_email = setting('admin_email', 'admin@example.com');
            $subject = 'New Contact Message: ' . $input['subject'];
            $body = "Name: {$input['name']}\nEmail: {$input['email']}\n\n{$input['message']}";
            send_email($admin_email, $subject, $body);
            
            $this->response(['message_id' => $this->db->insert_id()], 201, 'Message sent successfully');
        }
        
        $this->response_error('Failed to send message', 500);
    }
    
    /**
     * GET /api/contact/history
     * Get user's contact history (if logged in)
     */
    public function history() {
        if (!$this->user_id) {
            $this->response_error('Login required', 401);
        }
        
        $messages = $this->db
            ->where('user_id', $this->user_id)
            ->order_by('created_at', 'DESC')
            ->get('contact_messages')
            ->result();
        
        $formatted = array_map(function($msg) {
            return [
                'id' => $msg->id,
                'subject' => $msg->subject,
                'message' => $msg->message,
                'status' => $msg->status,
                'reply' => $msg->reply,
                'created_at' => $msg->created_at,
                'replied_at' => $msg->replied_at
            ];
        }, $messages);
        
        $this->response($formatted);
    }
}
