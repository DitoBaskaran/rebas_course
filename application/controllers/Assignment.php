<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assignment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', t('Silakan login terlebih dahulu.', 'Please login first.'));
            redirect('auth/login');
        }
        $this->load->model('Assignment_model');
        $this->load->model('Course_model');
    }

    public function view($encoded_id) {
        $assignment_id = decode_id($encoded_id);
        if (!$assignment_id) show_404();
        $assignment = $this->Assignment_model->get_assignment_by_id($assignment_id);
        if (!$assignment) show_404();
        $course = $this->Course_model->get_course_by_id($assignment->course_id);
        $submission = $this->Assignment_model->get_submission($assignment_id, $this->session->userdata('user_id'));
        $data['title'] = $assignment->title;
        $data['assignment'] = $assignment;
        $data['course'] = $course;
        $data['submission'] = $submission;
        $data['encoded_assignment_id'] = $encoded_id;
        $this->load->view('templates/header', $data);
        $this->load->view('assignment/view', $data);
        $this->load->view('templates/footer');
    }

    public function submit($encoded_id) {
        $this->load->helper('gamification');
        $assignment_id = decode_id($encoded_id);
        if (!$assignment_id) show_404();
        $assignment = $this->Assignment_model->get_assignment_by_id($assignment_id);
        if (!$assignment) show_404();
        $user_id = $this->session->userdata('user_id');
        if (!$this->Course_model->check_enrollment($user_id, $assignment->course_id)) {
            $this->session->set_flashdata('error', t('Anda harus terdaftar di kelas ini.', 'You must be enrolled in this course.'));
            redirect('courses/detail/' . $course->slug);
        }
        if ($assignment->due_days > 0) {
            $enrolled = $this->Course_model->get_enrollment_date($user_id, $assignment->course_id);
            if ($enrolled) {
                $due_date = date('Y-m-d', strtotime($enrolled . ' + ' . $assignment->due_days . ' days'));
                if (date('Y-m-d') > $due_date) {
                    $this->session->set_flashdata('error', t('Tenggat waktu sudah lewat.', 'Due date has passed.'));
                    redirect('assignment/view/' . $encoded_id);
                }
            }
        }
        $existing = $this->Assignment_model->get_submission($assignment_id, $user_id);
        if ($existing && $existing->status !== 'returned') {
            $this->session->set_flashdata('error', t('Anda sudah mengumpulkan tugas ini.', 'You already submitted this assignment.'));
            redirect('assignment/view/' . $encoded_id);
        }
        $text_body = $this->input->post('text_body');
        $file_url = '';
        if (!empty($_FILES['submission_file']['name'])) {
            $upload_path = './uploads/assignments';
            if (!is_dir($upload_path)) mkdir($upload_path, 0777, TRUE);
            $allowed = $assignment->allowed_file_types ?: 'pdf,zip,doc,docx,jpg,png';
            $allowed_types = str_replace(',', '|', $allowed);
            $max_size = $assignment->max_file_size ?: 10240;
            $config = array(
                'upload_path' => $upload_path, 'allowed_types' => $allowed_types,
                'max_size' => $max_size, 'file_name' => 'submission_' . $assignment_id . '_' . $user_id . '_' . time()
            );
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('submission_file')) { $file_url = $this->upload->data('file_name'); }
            else { $this->session->set_flashdata('error', $this->upload->display_errors('', '')); redirect('assignment/view/' . $encoded_id); }
        } elseif (!$text_body) {
            $this->session->set_flashdata('error', t('Upload file atau isi teks jawaban.', 'Upload a file or fill in the text answer.'));
            redirect('assignment/view/' . $encoded_id);
        }
        $data = array(
            'assignment_id' => $assignment_id, 'user_id' => $user_id, 'file_url' => $file_url,
            'text_body' => $text_body, 'notes' => $this->input->post('notes'), 'status' => 'submitted'
        );
        if ($existing) $this->Assignment_model->update_submission($existing->id, $data);
        else $this->Assignment_model->create_submission($data);
        if ($assignment->lesson_id) $this->Course_model->mark_lesson_completed($user_id, $assignment->lesson_id);
        $course = $this->Course_model->get_course_by_id($assignment->course_id);
        redirect('courses/learn/' . $course->slug);
    }
}
