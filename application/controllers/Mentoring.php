<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mentoring extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', t('Silakan login terlebih dahulu.', 'Please login first.'));
            redirect('auth/login');
        }
        $this->load->model('Mentoring_model');
        $this->load->model('Course_model');
    }

    public function index() {
        $data['title'] = t('Mentoring & Konsultasi', 'Mentoring & Consultation');
        $data['mentors'] = $this->Mentoring_model->get_available_mentors();

        $this->load->view('templates/header', $data);
        $this->load->view('mentoring/index', $data);
        $this->load->view('templates/footer');
    }

    public function my() {
        $user_id = $this->session->userdata('user_id');
        $data['title'] = t('Sesi Mentoring Saya', 'My Mentoring Sessions');
        $role = $this->session->userdata('role');

        if ($role === 'teacher' || $role === 'admin') {
            $data['sessions'] = $this->Mentoring_model->get_mentor_sessions($user_id);
        } else {
            $data['sessions'] = $this->Mentoring_model->get_student_sessions($user_id);
        }

        $this->load->view('templates/header', $data);
        $this->load->view('mentoring/my', $data);
        $this->load->view('templates/footer');
    }

    public function book($mentor_id) {
        $mentor = $this->db->get_where('users', array('id' => $mentor_id, 'role' => 'teacher'))->row();
        if (!$mentor) show_404();

        $this->form_validation->set_rules('scheduled_at', t('Jadwal', 'Schedule'), 'required');
        $this->form_validation->set_rules('course_id', t('Kelas', 'Course'), 'numeric');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = t('Booking Mentoring', 'Book Mentoring');
            $data['mentor'] = $mentor;
            $data['courses'] = $this->Course_model->get_user_enrolled_courses($this->session->userdata('user_id'));

            $this->load->view('templates/header', $data);
            $this->load->view('mentoring/book', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Mentoring_model->create_session(array(
                'mentor_id' => $mentor_id,
                'student_id' => $this->session->userdata('user_id'),
                'course_id' => $this->input->post('course_id') ?: null,
                'scheduled_at' => $this->input->post('scheduled_at'),
                'duration' => $this->input->post('duration') ?: 60,
                'meeting_link' => '',
                'status' => 'scheduled'
            ));
            $this->session->set_flashdata('success', t('Sesi mentoring berhasil dijadwalkan.', 'Mentoring session scheduled.'));
            redirect('mentoring/my');
        }
    }

    public function cancel($id) {
        $session = $this->Mentoring_model->get_session_by_id($id);
        if (!$session || ($session->student_id != $this->session->userdata('user_id') && $session->mentor_id != $this->session->userdata('user_id'))) {
            show_404();
        }
        $this->Mentoring_model->update_session($id, array('status' => 'cancelled'));
        $this->session->set_flashdata('success', t('Sesi mentoring dibatalkan.', 'Session cancelled.'));
        redirect('mentoring/my');
    }

    public function complete($id) {
        $session = $this->Mentoring_model->get_session_by_id($id);
        if (!$session || ($session->mentor_id != $this->session->userdata('user_id') && $this->session->userdata('role') !== 'admin')) {
            show_404();
        }
        $this->Mentoring_model->update_session($id, array(
            'status' => 'completed',
            'notes' => $this->input->post('notes') ?: ''
        ));
        $this->session->set_flashdata('success', t('Sesi mentoring diselesaikan.', 'Session completed.'));
        redirect('mentoring/my');
    }
}
