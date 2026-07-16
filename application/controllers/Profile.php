<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Course_model');
        $this->load->model('Certificate_model');
    }

    public function index() {
        if (!$this->session->userdata('logged_in')) redirect('auth/login');
        $user_id = $this->session->userdata('user_id');
        $user = $this->User_model->get_user_by_id($user_id);
        if (!$user) show_404();
        $data['title'] = t('Profil: ', 'Profile: ') . $user->name;
        $data['user'] = $user;
        $data['certificates'] = $this->Certificate_model->get_user_certificates($user_id);
        $data['enrolled_courses'] = $this->Course_model->get_user_enrolled_courses($user_id);
        $recent_activity = $this->db
            ->select('progress.*, lessons.title as lesson_title, courses.title as course_title')
            ->from('progress')
            ->join('lessons', 'lessons.id = progress.lesson_id')
            ->join('courses', 'courses.id = lessons.course_id')
            ->where('progress.user_id', $user_id)
            ->order_by('progress.updated_at', 'DESC')
            ->limit(10)
            ->get()->result();
        $data['recent_activity'] = $recent_activity;
        if ($user->role === 'teacher') {
            $data['courses'] = $this->Course_model->get_courses(array('teacher_id' => $user_id));
        }
        $data['active_page'] = 'profile';
        $this->load->view('templates/student_header', $data);
        $this->load->view('profile/index', $data);
        $this->load->view('templates/student_footer');
    }

    public function edit() {
        if (!$this->session->userdata('logged_in')) redirect('auth/login');
        $user_id = $this->session->userdata('user_id');
        $this->form_validation->set_rules('name', t('Nama', 'Name'), 'required|trim');
        $this->form_validation->set_rules('bio', t('Bio', 'Bio'), 'trim');
        $this->form_validation->set_rules('phone', t('No. HP', 'Phone'), 'trim');
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = t('Edit Profil', 'Edit Profile');
            $data['active_page'] = 'profile';
            $data['user'] = $this->User_model->get_user_by_id($user_id);
            $this->load->view('templates/student_header', $data);
            $this->load->view('profile/edit', $data);
            $this->load->view('templates/student_footer');
        } else {
            $update = array('name' => $this->input->post('name'), 'bio' => $this->input->post('bio'), 'phone' => $this->input->post('phone'));
            if (!empty($_FILES['avatar']['name'])) {
                $config = array(
                    'upload_path' => './uploads/avatars', 'allowed_types' => 'jpg|jpeg|png',
                    'max_size' => 512, 'file_name' => 'avatar_' . $user_id . '_' . time()
                );
                if (!is_dir('./uploads/avatars')) mkdir('./uploads/avatars', 0777, TRUE);
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('avatar')) $update['avatar'] = $this->upload->data('file_name');
            }
            $this->User_model->update_profile($user_id, $update);
            $this->session->set_flashdata('success', t('Profil berhasil diperbarui.', 'Profile updated.'));
            redirect('profile');
        }
    }

    public function change_password() {
        if (!$this->session->userdata('logged_in')) redirect('auth/login');
        $this->form_validation->set_rules('current_password', t('Password Saat Ini', 'Current Password'), 'required');
        $this->form_validation->set_rules('new_password', t('Password Baru', 'New Password'), 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', t('Konfirmasi Password', 'Confirm Password'), 'required|matches[new_password]');
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = t('Ganti Password', 'Change Password');
            $data['active_page'] = 'profile';
            $data['user'] = $this->User_model->get_user_by_id($this->session->userdata('user_id'));
            $this->load->view('templates/student_header', $data);
            $this->load->view('profile/change_password', $data);
            $this->load->view('templates/student_footer');
        } else {
            $user = $this->User_model->get_user_by_id($this->session->userdata('user_id'));
            if (!password_verify($this->input->post('current_password'), $user->password)) {
                $this->session->set_flashdata('error', t('Password saat ini salah.', 'Current password is wrong.'));
                redirect('profile/change_password');
            }
            $this->User_model->update_profile($user->id, array('password' => password_hash($this->input->post('new_password'), PASSWORD_BCRYPT)));
            $this->session->set_flashdata('success', t('Password berhasil diubah.', 'Password changed.'));
            redirect('profile');
        }
    }
}
