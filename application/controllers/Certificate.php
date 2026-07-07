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

    public function my() {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        $data['title'] = t('Sertifikat Saya', 'My Certificates');
        $data['certificates'] = $this->Certificate_model->get_user_certificates($this->session->userdata('user_id'));

        $this->load->view('templates/header', $data);
        $this->load->view('certificate/my', $data);
        $this->load->view('templates/footer');
    }
}
