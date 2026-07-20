<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Mentor_Dashboard extends Api_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->require_auth();
        
        // Check if user is mentor
        if ($this->current_user->role !== 'mentor') {
            $this->response_error('Access denied. Mentor role required.', 403);
        }
        
        $this->load->model('Mentor_model');
        $this->load->model('Mentor_availability_model');
        $this->load->model('Mentoring_bookings_model');
    }
    
    /**
     * GET /api/mentor/dashboard
     */
    public function index() {
        $mentor = $this->Mentor_model->get_by_user_id($this->user_id);
        
        if (!$mentor) {
            $this->response_error('Mentor profile not found', 404);
        }
        
        $stats = [
            'total_sessions' => $this->Mentoring_bookings_model->count_mentor_sessions($mentor->id),
            'completed_sessions' => $this->Mentoring_bookings_model->count_mentor_sessions($mentor->id, 'completed'),
            'pending_sessions' => $this->Mentoring_bookings_model->count_mentor_sessions($mentor->id, 'pending'),
            'total_students' => $this->Mentoring_bookings_model->count_unique_students($mentor->id),
            'rating' => (float)$mentor->rating
        ];
        
        $this->response([
            'mentor' => format_mentor_for_api($mentor),
            'stats' => $stats
        ]);
    }
    
    /**
     * GET /api/mentor/availability
     */
    public function availability() {
        $mentor = $this->Mentor_model->get_by_user_id($this->user_id);
        if (!$mentor) $this->response_error('Mentor not found', 404);
        
        $slots = $this->Mentor_availability_model->get_mentor_slots($mentor->id);
        
        $formatted = array_map(function($slot) {
            return [
                'id' => $slot->id,
                'day_of_week' => $slot->day_of_week,
                'date' => $slot->date,
                'start_time' => $slot->start_time,
                'end_time' => $slot->end_time,
                'is_booked' => (bool)$slot->is_booked,
                'booking_id' => $slot->booking_id
            ];
        }, $slots);
        
        $this->response($formatted);
    }
    
    /**
     * POST /api/mentor/add-slot
     */
    public function add_slot() {
        $mentor = $this->Mentor_model->get_by_user_id($this->user_id);
        if (!$mentor) $this->response_error('Mentor not found', 404);
        
        $input = $this->get_json_input();
        
        $date = $input['date'] ?? '';
        $start_time = $input['start_time'] ?? '';
        $end_time = $input['end_time'] ?? '';
        
        if (empty($date) || empty($start_time) || empty($end_time)) {
            $this->response_error('date, start_time, and end_time are required');
        }
        
        $slot_data = [
            'mentor_id' => $mentor->id,
            'date' => $date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'is_booked' => false,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $slot_id = $this->Mentor_availability_model->create_slot($slot_data);
        
        if ($slot_id) {
            $this->response(['slot_id' => $slot_id], 201, 'Slot added');
        }
        
        $this->response_error('Failed to add slot', 500);
    }
    
    /**
     * DELETE /api/mentor/delete-slot/:id
     */
    public function delete_slot($id) {
        $mentor = $this->Mentor_model->get_by_user_id($this->user_id);
        if (!$mentor) $this->response_error('Mentor not found', 404);
        
        $slot = $this->Mentor_availability_model->get_slot_by_id($id);
        if (!$slot || $slot->mentor_id != $mentor->id) {
            $this->response_error('Slot not found', 404);
        }
        
        if ($slot->is_booked) {
            $this->response_error('Cannot delete booked slot', 400);
        }
        
        $this->Mentor_availability_model->delete_slot($id);
        $this->response(null, 200, 'Slot deleted');
    }
    
    /**
     * GET /api/mentor/sessions
     */
    public function sessions() {
        $mentor = $this->Mentor_model->get_by_user_id($this->user_id);
        if (!$mentor) $this->response_error('Mentor not found', 404);
        
        $status = $this->input->get('status');
        $sessions = $this->Mentoring_bookings_model->get_mentor_sessions($mentor->id, $status);
        
        $formatted = array_map(function($session) {
            return [
                'id' => $session->id,
                'user' => [
                    'id' => $session->user_id,
                    'name' => $session->user_name,
                    'avatar' => $session->user_avatar
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
     * POST /api/mentor/confirm-session/:id
     */
    public function confirm_session($id) {
        $mentor = $this->Mentor_model->get_by_user_id($this->user_id);
        if (!$mentor) $this->response_error('Mentor not found', 404);
        
        $session = $this->Mentoring_bookings_model->get_booking_by_id($id);
        if (!$session || $session->mentor_id != $mentor->id) {
            $this->response_error('Session not found', 404);
        }
        
        if ($session->status !== 'pending') {
            $this->response_error('Session cannot be confirmed', 400);
        }
        
        $input = $this->get_json_input();
        $meeting_link = $input['meeting_link'] ?? '';
        
        $this->Mentoring_bookings_model->update_booking($id, [
            'status' => 'confirmed',
            'meeting_link' => $meeting_link,
            'confirmed_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->response(null, 200, 'Session confirmed');
    }
    
    /**
     * POST /api/mentor/reject-session/:id
     */
    public function reject_session($id) {
        $mentor = $this->Mentor_model->get_by_user_id($this->user_id);
        if (!$mentor) $this->response_error('Mentor not found', 404);
        
        $session = $this->Mentoring_bookings_model->get_booking_by_id($id);
        if (!$session || $session->mentor_id != $mentor->id) {
            $this->response_error('Session not found', 404);
        }
        
        if ($session->status !== 'pending') {
            $this->response_error('Session cannot be rejected', 400);
        }
        
        $this->Mentoring_bookings_model->update_booking($id, [
            'status' => 'rejected',
            'rejected_at' => date('Y-m-d H:i:s')
        ]);
        
        // Restore user session
        if ($session->balance_id) {
            $this->load->model('User_mentoring_balance_model');
            $this->User_mentoring_balance_model->restore_session($session->balance_id);
        }
        
        $this->response(null, 200, 'Session rejected');
    }
    
    /**
     * POST /api/mentor/complete-session/:id
     */
    public function complete_session($id) {
        $mentor = $this->Mentor_model->get_by_user_id($this->user_id);
        if (!$mentor) $this->response_error('Mentor not found', 404);
        
        $session = $this->Mentoring_bookings_model->get_booking_by_id($id);
        if (!$session || $session->mentor_id != $mentor->id) {
            $this->response_error('Session not found', 404);
        }
        
        if ($session->status !== 'confirmed') {
            $this->response_error('Session cannot be completed', 400);
        }
        
        $this->Mentoring_bookings_model->update_booking($id, [
            'status' => 'completed',
            'completed_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->response(null, 200, 'Session completed');
    }
    
    /**
     * POST /api/mentor/rate-user/:id
     */
    public function rate_user($id) {
        $mentor = $this->Mentor_model->get_by_user_id($this->user_id);
        if (!$mentor) $this->response_error('Mentor not found', 404);
        
        $session = $this->Mentoring_bookings_model->get_booking_by_id($id);
        if (!$session || $session->mentor_id != $mentor->id) {
            $this->response_error('Session not found', 404);
        }
        
        if ($session->status !== 'completed') {
            $this->response_error('Can only rate completed sessions', 400);
        }
        
        $input = $this->get_json_input();
        $rating = (int)($input['rating'] ?? 0);
        $comment = $input['comment'] ?? '';
        
        if ($rating < 1 || $rating > 5) {
            $this->response_error('Rating must be between 1 and 5', 422);
        }
        
        // Check if already rated
        $existing = $this->db->get_where('mentor_user_ratings', ['booking_id' => $id])->row();
        if ($existing) {
            $this->response_error('Already rated', 400);
        }
        
        $this->db->insert('mentor_user_ratings', [
            'booking_id' => $id,
            'mentor_id' => $mentor->id,
            'user_id' => $session->user_id,
            'rating' => $rating,
            'comment' => $comment,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->response(null, 201, 'User rated');
    }
}
