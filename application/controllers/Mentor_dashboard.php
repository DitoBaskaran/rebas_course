<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mentor_dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('auth/login');
        if ($this->session->userdata('role') !== 'mentor') {
            $this->session->set_flashdata('error', t('Akses ditolak.', 'Access denied.'));
            redirect('home');
        }
        $this->load->model('Mentor_model');
        $this->load->model('Mentoring_bookings_model');
        $this->load->model('Mentor_availability_model');
    }

    private function get_mentor_profile() {
        $mentor = $this->Mentor_model->get_by_user_id($this->session->userdata('user_id'));
        if (!$mentor) {
            $this->session->set_flashdata('error', t('Profil mentor tidak ditemukan.', 'Mentor profile not found.'));
            redirect('dashboard');
        }
        return $mentor;
    }

    public function index() {
        $mentor = $this->get_mentor_profile();
        $data['title'] = t('Dashboard Mentor', 'Mentor Dashboard');
        $data['active_page'] = 'dashboard';
        $data['mentor'] = $mentor;
        $data['upcoming'] = $this->Mentoring_bookings_model->get_upcoming_by_mentor($mentor->id);
        $data['total_pending'] = $this->Mentoring_bookings_model->count_by_mentor($mentor->id, 'pending');
        $data['total_completed'] = $this->Mentoring_bookings_model->count_by_mentor($mentor->id, 'completed');
        $this->load->view('templates/student_header', $data);
        $this->load->view('mentor/dashboard', $data);
        $this->load->view('templates/student_footer');
    }

    public function availability() {
        $mentor = $this->get_mentor_profile();
        $data['title'] = t('Jadwal Saya', 'My Schedule');
        $data['active_page'] = 'availability';
        $data['mentor'] = $mentor;
        $data['slots'] = $this->Mentor_availability_model->get_by_mentor($mentor->id);
        $this->load->view('templates/student_header', $data);
        $this->load->view('mentor/availability', $data);
        $this->load->view('templates/student_footer');
    }

    public function add_slot() {
        $mentor = $this->get_mentor_profile();
        $day_of_week = $this->input->post('day_of_week');
        $start_time = $this->input->post('start_time');
        $end_time = $this->input->post('end_time');
        $date_override = $this->input->post('date_override') ?: null;
        $this->form_validation->set_rules('day_of_week', t('Hari', 'Day'), 'required');
        $this->form_validation->set_rules('start_time', t('Jam Mulai', 'Start Time'), 'required');
        $this->form_validation->set_rules('end_time', t('Jam Selesai', 'End Time'), 'required');
        if ($this->form_validation->run()) {
            $this->Mentor_availability_model->create(array(
                'mentor_id' => $mentor->id, 'day_of_week' => $date_override ? null : $day_of_week,
                'start_time' => $start_time, 'end_time' => $end_time, 'date_override' => $date_override,
            ));
            $this->session->set_flashdata('success', t('Slot ditambahkan!', 'Slot added!'));
        }
        redirect('mentor/availability');
    }

    public function delete_slot($encoded_id) {
        $mentor = $this->get_mentor_profile();
        $slot_id = decode_id($encoded_id);
        if (!$slot_id) show_404();
        $slot = $this->Mentor_availability_model->get_by_id($slot_id);
        if ($slot && $slot->mentor_id == $mentor->id && !$slot->is_booked) {
            $this->Mentor_availability_model->delete($slot_id);
            $this->session->set_flashdata('success', t('Slot dihapus.', 'Slot deleted.'));
        }
        redirect('mentor/availability');
    }

    public function sessions() {
        $mentor = $this->get_mentor_profile();
        $data['title'] = t('Sesi Masuk', 'Incoming Sessions');
        $data['active_page'] = 'sessions';
        $data['mentor'] = $mentor;
        $data['sessions'] = $this->Mentoring_bookings_model->get_by_mentor($mentor->id);
        $this->load->view('templates/student_header', $data);
        $this->load->view('mentor/sessions', $data);
        $this->load->view('templates/student_footer');
    }

    public function confirm_session($encoded_id) {
        $mentor = $this->get_mentor_profile();
        $session_id = decode_id($encoded_id);
        if (!$session_id) show_404();
        $session = $this->Mentoring_bookings_model->get_by_id($session_id);
        if ($session && $session->mentor_id == $mentor->id) {
            $this->Mentoring_bookings_model->update($session_id, array('status' => 'confirmed', 'mentor_confirmed_at' => date('Y-m-d H:i:s')));
            $this->session->set_flashdata('success', t('Sesi dikonfirmasi.', 'Session confirmed.'));
        }
        redirect('mentor/sessions');
    }

    public function reject_session($encoded_id) {
        $mentor = $this->get_mentor_profile();
        $session_id = decode_id($encoded_id);
        if (!$session_id) show_404();
        $session = $this->Mentoring_bookings_model->get_by_id($session_id);
        if ($session && $session->mentor_id == $mentor->id) {
            $this->Mentoring_bookings_model->update($session_id, array('status' => 'cancelled', 'cancelled_by' => 'mentor', 'cancelled_at' => date('Y-m-d H:i:s')));
            if ($session->availability_id) $this->Mentor_availability_model->mark_available($session->availability_id);
            if ($session->balance_id) { $this->load->model('User_mentoring_balance_model'); $this->User_mentoring_balance_model->restore_session($session->balance_id); }
            $this->session->set_flashdata('success', t('Sesi ditolak. Kuota dikembalikan ke user.', 'Session rejected. Quota restored to user.'));
        }
        redirect('mentor/sessions');
    }

    public function complete_session($encoded_id) {
        $mentor = $this->get_mentor_profile();
        $session_id = decode_id($encoded_id);
        if (!$session_id) show_404();
        $session = $this->Mentoring_bookings_model->get_by_id($session_id);
        if ($session && $session->mentor_id == $mentor->id && in_array($session->status, array('confirmed'))) {
            $this->Mentoring_bookings_model->update($session_id, array('status' => 'completed', 'completed_at' => date('Y-m-d H:i:s')));
            $this->session->set_flashdata('success', t('Sesi ditandai selesai.', 'Session completed.'));
        }
        redirect('mentor/sessions');
    }

    public function rate_user($encoded_id) {
        $mentor = $this->get_mentor_profile();
        $session_id = decode_id($encoded_id);
        if (!$session_id) show_404();
        $session = $this->Mentoring_bookings_model->get_by_id($session_id);
        if (!$session || $session->mentor_id != $mentor->id || $session->status != 'completed') show_404();
        $this->form_validation->set_rules('rating', t('Rating', 'Rating'), 'required|numeric|greater_than[0]|less_than[6]');
        if ($this->form_validation->run()) {
            $this->db->insert('user_reputations', array(
                'session_id' => $session_id, 'mentor_id' => $mentor->id, 'user_id' => $session->user_id,
                'rating' => $this->input->post('rating'), 'review_text' => $this->input->post('review_text'),
            ));
            $this->session->set_flashdata('success', t('Rating user berhasil dikirim.', 'User rating submitted.'));
        }
        redirect('mentor/sessions');
    }

    public function update_schedule($mentor_id) {
        $mentor = $this->get_mentor_profile();
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run()) {
            $this->Mentor_model->update($mentor->id, array(
                'title' => $this->input->post('title'), 'title_en' => $this->input->post('title_en') ?: '',
                'bio' => $this->input->post('bio'), 'bio_en' => $this->input->post('bio_en') ?: '',
                'durations_available' => $this->input->post('durations_available') ?: '15,30,45,60',
                'meeting_platforms' => $this->input->post('meeting_platforms') ?: 'zoom,gmeet,whatsapp',
            ));
            $this->session->set_flashdata('success', t('Profil diperbarui.', 'Profile updated.'));
        }
        redirect('mentor/dashboard');
    }
}
