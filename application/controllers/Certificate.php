<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificate extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Certificate_model');
        $this->load->model('Course_model');
    }

    public function verify($code) {
        $cert = $this->Certificate_model->get_certificate_by_code($code);
        if (!$cert) {
            $data['title'] = t('Sertifikat Tidak Ditemukan', 'Certificate Not Found');
            $data['error'] = true;
        } else {
            $data['title'] = t('Verifikasi Sertifikat', 'Certificate Verification');
            $data['cert'] = $cert;
            $data['error'] = false;
        }
        $this->load->view('templates/header', $data);
        $this->load->view('certificate/verify', $data);
        $this->load->view('templates/footer');
    }

    public function view($encoded_id) {
        $id = decode_id($encoded_id);
        if (!$id) show_404();
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', t('Silakan login.', 'Please login.'));
            redirect('auth/login');
        }
        $cert = $this->Certificate_model->get_certificate_by_id($id);
        if (!$cert || $cert->user_id != $this->session->userdata('user_id')) show_404();
        $data['title'] = t('Sertifikat', 'Certificate');
        $data['cert'] = $cert;
        $this->load->view('templates/header', $data);
        $this->load->view('certificate/view', $data);
        $this->load->view('templates/footer');
    }

    public function my() {
        if (!$this->session->userdata('logged_in')) redirect('auth/login');
        $data['title'] = t('Sertifikat Saya', 'My Certificates');
        $data['active_page'] = 'certificates';
        $data['certificates'] = $this->Certificate_model->get_user_certificates($this->session->userdata('user_id'));
        $this->load->view('templates/student_header', $data);
        $this->load->view('certificate/my', $data);
        $this->load->view('templates/student_footer');
    }
}
