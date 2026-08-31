<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Learning_paths extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Learning_path_model');
        $this->load->model('Course_model');
    }

    public function index() {
        $data['title'] = t('Learning Paths (Skill Tree)', 'Learning Paths (Skill Tree)');
        $data['paths'] = $this->Learning_path_model->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('learning_paths/index', $data);
        $this->load->view('templates/footer');
    }

    public function mine() {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        $data['title'] = t('Learning Path Saya', 'My Learning Paths');
        $data['active_page'] = 'learning_paths';
        $data['learning_paths'] = $this->Learning_path_model->get_user_paths($this->session->userdata('user_id'));
        $this->load->view('templates/student_header', $data);
        $this->load->view('learning_paths/mine', $data);
        $this->load->view('templates/student_footer');
    }

    public function detail($slug) {
        $path = $this->Learning_path_model->get_by_slug($slug);
        if (!$path) show_404();

        $contents = $this->Learning_path_model->get_contents($path->id);

        $data['title'] = $path->title;
        $data['path'] = $path;
        $data['contents'] = $contents;

        if ($this->session->userdata('logged_in')) {
            $user_id = $this->session->userdata('user_id');
            $data['enrollment'] = $this->Learning_path_model->get_user_enrollment($user_id, $path->id);

            foreach ($contents as $c) {
                $c->is_enrolled = $this->Course_model->check_enrollment($user_id, $c->course_id);
            }
        } else {
            $data['enrollment'] = null;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('learning_paths/detail', $data);
        $this->load->view('templates/footer');
    }

    public function enroll($encoded_id) {
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', t('Silakan login.', 'Please login.'));
            redirect('auth/login');
        }

        $path_id = decode_id($encoded_id);
        if (!$path_id) show_404();

        $path = $this->Learning_path_model->get_by_id($path_id);
        if (!$path) show_404();

        $this->Learning_path_model->enroll_user($this->session->userdata('user_id'), $path_id);
        $this->Learning_path_model->update_progress($this->session->userdata('user_id'), $path_id);
        $this->session->set_flashdata('success', t('Anda terdaftar di learning path ini!', 'You are enrolled in this learning path!'));
        redirect('learning_paths/detail/' . $path->slug);
    }
}
