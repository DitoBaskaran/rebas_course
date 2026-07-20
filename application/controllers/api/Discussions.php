<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Discussions extends Api_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Discussion_model');
        $this->load->model('Course_enrollment_model');
    }
    
    /**
     * GET /api/courses/:id/discussions
     */
    public function index($course_id) {
        $pagination = $this->get_pagination();
        
        $discussions = $this->Discussion_model->get_discussions($course_id, $pagination['per_page'], $pagination['offset']);
        $total = $this->Discussion_model->count_discussions($course_id);
        
        $formatted = array_map(function($discussion) {
            return [
                'id' => $discussion->id,
                'user_id' => $discussion->user_id,
                'user_name' => $discussion->user_name,
                'user_avatar' => $discussion->avatar,
                'title' => $discussion->title,
                'content' => $discussion->content,
                'reply_count' => (int)$discussion->reply_count,
                'created_at' => $discussion->created_at
            ];
        }, $discussions);
        
        $this->response_paginated($formatted, $total, $pagination);
    }
    
    /**
     * GET /api/discussions/:id
     */
    public function show($id) {
        $discussion = $this->Discussion_model->get_discussion_by_id($id);
        
        if (!$discussion) {
            $this->response_error('Discussion not found', 404);
        }
        
        $replies = $this->Discussion_model->get_replies($id);
        
        $data = [
            'id' => $discussion->id,
            'course_id' => $discussion->course_id,
            'user_id' => $discussion->user_id,
            'user_name' => $discussion->user_name,
            'user_avatar' => $discussion->avatar,
            'title' => $discussion->title,
            'content' => $discussion->content,
            'created_at' => $discussion->created_at,
            'replies' => array_map(function($reply) {
                return [
                    'id' => $reply->id,
                    'user_id' => $reply->user_id,
                    'user_name' => $reply->user_name,
                    'user_avatar' => $reply->avatar,
                    'content' => $reply->content,
                    'is_accepted' => (bool)$reply->is_accepted,
                    'created_at' => $reply->created_at
                ];
            }, $replies)
        ];
        
        $this->response($data);
    }
    
    /**
     * POST /api/courses/:id/discussions
     */
    public function create($course_id) {
        $this->require_auth();
        
        $input = $this->get_json_input();
        
        $this->load->library('form_validation');
        $this->form_validation->set_data($input);
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('content', 'Content', 'required|trim');
        
        if ($this->form_validation->run() === FALSE) {
            $this->response_error('Validation failed', 422, $this->form_validation->error_array());
        }
        
        $discussion_id = $this->Discussion_model->create_discussion([
            'course_id' => $course_id,
            'user_id' => $this->user_id,
            'title' => $input['title'],
            'content' => $input['content'],
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        if ($discussion_id) {
            $this->response(['discussion_id' => $discussion_id], 201, 'Discussion created');
        }
        
        $this->response_error('Failed to create discussion', 500);
    }
    
    /**
     * POST /api/discussions/:id/reply
     */
    public function reply($id) {
        $this->require_auth();
        
        $discussion = $this->Discussion_model->get_discussion_by_id($id);
        if (!$discussion) {
            $this->response_error('Discussion not found', 404);
        }
        
        $input = $this->get_json_input();
        $content = $input['content'] ?? '';
        
        if (empty($content)) {
            $this->response_error('Content is required');
        }
        
        $reply_id = $this->Discussion_model->create_reply([
            'discussion_id' => $id,
            'user_id' => $this->user_id,
            'content' => $content,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        if ($reply_id) {
            $this->response(['reply_id' => $reply_id], 201, 'Reply created');
        }
        
        $this->response_error('Failed to create reply', 500);
    }
}
