<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Mentoring extends Api_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Mentor_model');
        $this->load->model('Mentoring_package_model');
        $this->load->model('Mentor_availability_model');
        $this->load->model('Mentoring_bookings_model');
        $this->load->model('User_mentoring_balance_model');
    }
    
    /**
     * GET /api/mentors
     */
    public function mentors() {
        $pagination = $this->get_pagination();
        $category_id = $this->input->get('category_id');
        $search = $this->input->get('search');
        
        $mentors = $this->Mentor_model->get_all($category_id, $search, $pagination['per_page'], $pagination['offset']);
        $total = $this->Mentor_model->count_all($category_id, $search);
        
        $formatted = array_map(function($mentor) {
            return format_mentor_for_api($mentor);
        }, $mentors);
        
        $this->response_paginated($formatted, $total, $pagination);
    }
    
    /**
     * GET /api/mentors/:id
     */
    public function mentor_detail($id) {
        $mentor = $this->Mentor_model->get_by_id($id);
        
        if (!$mentor) {
            $this->response_error('Mentor not found', 404);
        }
        
        $data = format_mentor_for_api($mentor);
        $data['categories'] = $this->Mentor_model->get_categories($id);
        $data['availability'] = $this->Mentor_availability_model->get_available_slots($id);
        
        $this->response($data);
    }
    
    /**
     * GET /api/mentors/:id/slots
     */
    public function slots($id) {
        $date = $this->input->get('date');
        $slots = $this->Mentor_availability_model->get_available_slots($id, $date);
        
        $formatted = array_map(function($slot) {
            return [
                'id' => $slot->id,
                'day_of_week' => $slot->day_of_week,
                'date' => $slot->date,
                'start_time' => $slot->start_time,
                'end_time' => $slot->end_time,
                'is_available' => !$slot->is_booked
            ];
        }, $slots);
        
        $this->response($formatted);
    }
    
    /**
     * GET /api/mentoring/packages
     */
    public function packages() {
        $packages = $this->Mentoring_package_model->get_all();
        
        $formatted = array_map(function($pkg) {
            return [
                'id' => $pkg->id,
                'name' => $pkg->name,
                'description' => $pkg->description,
                'price' => (float)$pkg->price,
                'duration_minutes' => (int)$pkg->duration_minutes,
                'total_sessions' => (int)$pkg->total_sessions,
                'is_active' => (bool)$pkg->is_active
            ];
        }, $packages);
        
        $this->response($formatted);
    }
    
    /**
     * POST /api/mentoring/book
     */
    public function book() {
        $this->require_auth();
        
        $input = $this->get_json_input();
        
        $mentor_id = $input['mentor_id'] ?? 0;
        $package_id = $input['package_id'] ?? 0;
        $slot_id = $input['slot_id'] ?? 0;
        $scheduled_at = $input['scheduled_at'] ?? '';
        
        if (empty($mentor_id) || empty($package_id) || empty($scheduled_at)) {
            $this->response_error('mentor_id, package_id, and scheduled_at are required');
        }
        
        // Check mentor exists
        $mentor = $this->Mentor_model->get_by_id($mentor_id);
        if (!$mentor) {
            $this->response_error('Mentor not found', 404);
        }
        
        // Check package exists
        $package = $this->Mentoring_package_model->get_by_id($package_id);
        if (!$package) {
            $this->response_error('Package not found', 404);
        }
        
        // Check user balance
        $balance = $this->User_mentoring_balance_model->get_balance($this->user_id, $package_id);
        if (!$balance || $balance->remaining_sessions <= 0) {
            $this->response_error('No remaining sessions. Please purchase a package.', 400);
        }
        
        // Check slot availability if slot_id provided
        if ($slot_id) {
            $slot = $this->Mentor_availability_model->get_slot_by_id($slot_id);
            if (!$slot || $slot->is_booked) {
                $this->response_error('Slot not available', 400);
            }
        }
        
        // Create booking
        $booking_data = [
            'user_id' => $this->user_id,
            'mentor_id' => $mentor_id,
            'balance_id' => $balance->id,
            'slot_id' => $slot_id ?: null,
            'scheduled_at' => $scheduled_at,
            'duration' => $package->duration_minutes,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $booking_id = $this->Mentoring_bookings_model->create_booking($booking_data);
        
        if ($booking_id) {
            // Deduct session
            $this->User_mentoring_balance_model->deduct_session($balance->id);
            
            // Mark slot as booked
            if ($slot_id) {
                $this->Mentor_availability_model->mark_booked($slot_id, $booking_id);
            }
            
            $this->response(['booking_id' => $booking_id], 201, 'Booking created');
        }
        
        $this->response_error('Booking failed', 500);
    }
    
    /**
     * GET /api/mentoring/sessions
     */
    public function sessions() {
        $this->require_auth();
        
        $sessions = $this->Mentoring_bookings_model->get_user_bookings($this->user_id);
        
        $formatted = array_map(function($session) {
            return [
                'id' => $session->id,
                'mentor' => [
                    'id' => $session->mentor_id,
                    'name' => $session->mentor_name,
                    'avatar' => $session->mentor_avatar
                ],
                'scheduled_at' => $session->scheduled_at,
                'duration' => (int)$session->duration,
                'status' => $session->status,
                'meeting_link' => $session->meeting_link,
                'notes' => $session->notes,
                'created_at' => $session->created_at
            ];
        }, $sessions);
        
        $this->response($formatted);
    }
    
    /**
     * POST /api/mentoring/sessions/:id/cancel
     */
    public function cancel($id) {
        $this->require_auth();
        
        $session = $this->Mentoring_bookings_model->get_booking_by_id($id);
        
        if (!$session || $session->user_id != $this->user_id) {
            $this->response_error('Session not found', 404);
        }
        
        if ($session->status === 'completed' || $session->status === 'cancelled') {
            $this->response_error('Cannot cancel completed or cancelled session', 400);
        }
        
        $this->Mentoring_bookings_model->update_booking($id, [
            'status' => 'cancelled',
            'cancelled_at' => date('Y-m-d H:i:s')
        ]);
        
        // Restore session
        if ($session->balance_id) {
            $this->User_mentoring_balance_model->restore_session($session->balance_id);
        }
        
        $this->response(null, 200, 'Session cancelled');
    }
    
    /**
     * POST /api/mentoring/favorite/:mentor_id
     */
    public function favorite($mentor_id) {
        $this->require_auth();
        
        $mentor = $this->Mentor_model->get_by_id($mentor_id);
        if (!$mentor) {
            $this->response_error('Mentor not found', 404);
        }
        
        $existing = $this->db->get_where('mentor_favorites', [
            'user_id' => $this->user_id,
            'mentor_id' => $mentor_id
        ])->row();
        
        if ($existing) {
            $this->db->where('id', $existing->id)->delete('mentor_favorites');
            $this->response(null, 200, 'Removed from favorites');
        } else {
            $this->db->insert('mentor_favorites', [
                'user_id' => $this->user_id,
                'mentor_id' => $mentor_id,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $this->response(null, 201, 'Added to favorites');
        }
    }
    
    /**
     * GET /api/mentoring/favorites
     */
    public function favorites() {
        $this->require_auth();
        
        $favorites = $this->db
            ->select('mentors.*, users.name, users.email, users.avatar')
            ->from('mentor_favorites')
            ->join('mentors', 'mentors.id = mentor_favorites.mentor_id')
            ->join('users', 'users.id = mentors.user_id')
            ->where('mentor_favorites.user_id', $this->user_id)
            ->get()
            ->result();
        
        $formatted = array_map(function($mentor) {
            return format_mentor_for_api($mentor);
        }, $favorites);
        
        $this->response($formatted);
    }
}
