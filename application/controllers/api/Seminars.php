<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Seminars extends Api_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Seminar_model');
    }
    
    /**
     * GET /api/seminars
     */
    public function index() {
        $pagination = $this->get_pagination();
        
        $seminars = $this->Seminar_model->get_seminars($pagination['per_page'], $pagination['offset']);
        $total = $this->Seminar_model->count_seminars();
        
        $formatted = array_map(function($seminar) {
            return [
                'id' => $seminar->id,
                'title' => $seminar->title,
                'description' => $seminar->description,
                'date_time' => $seminar->date_time,
                'location' => $seminar->location,
                'capacity' => (int)$seminar->capacity,
                'registrations' => (int)$seminar->registrations,
                'speaker' => $seminar->speaker_name,
                'price' => (float)$seminar->price,
                'image' => $seminar->image
            ];
        }, $seminars);
        
        $this->response_paginated($formatted, $total, $pagination);
    }
    
    /**
     * GET /api/seminars/:id
     */
    public function show($id) {
        $seminar = $this->Seminar_model->get_seminar_by_id($id);
        
        if (!$seminar) {
            $this->response_error('Seminar not found', 404);
        }
        
        $data = [
            'id' => $seminar->id,
            'title' => $seminar->title,
            'description' => $seminar->description,
            'date_time' => $seminar->date_time,
            'location' => $seminar->location,
            'capacity' => (int)$seminar->capacity,
            'registrations' => (int)$seminar->registrations,
            'speaker' => [
                'id' => $seminar->speaker_id,
                'name' => $seminar->speaker_name
            ],
            'price' => (float)$seminar->price,
            'image' => $seminar->image,
            'is_full' => $seminar->registrations >= $seminar->capacity
        ];
        
        // Check if user registered
        if ($this->user_id) {
            $data['is_registered'] = $this->Seminar_model->check_registration($this->user_id, $id);
        }
        
        $this->response($data);
    }
    
    /**
     * POST /api/seminars/:id/register
     */
    public function register($id) {
        $this->require_auth();
        
        $seminar = $this->Seminar_model->get_seminar_by_id($id);
        
        if (!$seminar) {
            $this->response_error('Seminar not found', 404);
        }
        
        // Check if already registered
        $already_registered = $this->Seminar_model->check_registration($this->user_id, $id);
        
        if ($already_registered) {
            $this->response_error('Already registered', 400);
        }
        
        // Check capacity
        if ($seminar->registrations >= $seminar->capacity) {
            $this->response_error('Seminar is full', 400);
        }
        
        $result = $this->Seminar_model->register_user($this->user_id, $id);
        
        if ($result) {
            $this->db->where('id', $id)->set('registrations', 'registrations + 1', FALSE)->update('seminars');
            $this->response(null, 201, 'Registered successfully');
        }
        
        $this->response_error('Registration failed', 500);
    }
    
    /**
     * GET /api/seminars/mine
     */
    public function mine() {
        $this->require_auth();
        
        $seminars = $this->Seminar_model->get_user_registered_seminars($this->user_id);
        
        $formatted = array_map(function($seminar) {
            return [
                'id' => $seminar->id,
                'title' => $seminar->title,
                'date_time' => $seminar->date_time,
                'location' => $seminar->location,
                'speaker' => $seminar->speaker_name,
                'registered_at' => $seminar->registered_at
            ];
        }, $seminars);
        
        $this->response($formatted);
    }
}
