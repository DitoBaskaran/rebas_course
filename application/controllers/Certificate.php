<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificate extends MY_Controller {

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
        $data['active_page'] = 'certificates';
        if ($this->session->userdata('logged_in')) {
            $this->load->view('templates/student_header', $data);
            $this->load->view('certificate/view', $data);
            $this->load->view('templates/student_footer');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('certificate/view', $data);
            $this->load->view('templates/footer');
        }
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

    public function download($encoded_id) {
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', t('Silakan login.', 'Please login.'));
            redirect('auth/login');
        }
        $id = decode_id($encoded_id);
        if (!$id) show_404();

        $cert = $this->Certificate_model->get_certificate_by_id($id);
        if (!$cert || $cert->user_id != $this->session->userdata('user_id')) show_404();

        $this->load->helper('pdf');
        download_certificate_pdf(array(
            'user_name'         => $cert->user_name,
            'title'             => $cert->title,
            'title_en'          => $cert->title_en,
            'certificate_code'  => $cert->certificate_code,
            'issued_at'         => $cert->issued_at,
        ));
    }
}
