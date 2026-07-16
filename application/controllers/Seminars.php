<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seminars extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Seminar_model');
        $this->load->model('Transaction_model');
    }

    public function index() {
        $data['title'] = t('Katalog Seminar & Webinar', 'Seminar & Webinar Catalog');
        $data['seminars'] = $this->Seminar_model->get_seminars();

        $this->load->view('templates/header', $data);
        $this->load->view('seminars/index', $data);
        $this->load->view('templates/footer');
    }

    public function mine() {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        $data['title'] = t('Seminar Saya', 'My Seminars');
        $data['active_page'] = 'seminars';
        $data['registered_seminars'] = $this->Seminar_model->get_user_registered_seminars($this->session->userdata('user_id'));
        $this->load->view('templates/student_header', $data);
        $this->load->view('seminars/mine', $data);
        $this->load->view('templates/student_footer');
    }

    public function detail($encoded_id) {
        $id = decode_id($encoded_id);
        if (!$id) show_404();
        $seminar = $this->Seminar_model->get_seminar_by_id($id);
        if (!$seminar) show_404();

        $data['title'] = $seminar->title;
        $data['seminar'] = $seminar;
        $data['attendee_count'] = $this->Seminar_model->get_attendee_count($id);
        $data['is_registered'] = FALSE;

        if ($this->session->userdata('logged_in')) {
            $data['is_registered'] = $this->Seminar_model->check_registration($this->session->userdata('user_id'), $id);
        }

        $this->load->view('templates/header', $data);
        $this->load->view('seminars/detail', $data);
        $this->load->view('templates/footer');
    }

    public function register($encoded_id) {
        $id = decode_id($encoded_id);
        if (!$id) show_404();
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', t('Silakan login terlebih dahulu.', 'Please login first.'));
            redirect('auth/login');
        }

        $seminar = $this->Seminar_model->get_seminar_by_id($id);
        if (!$seminar) show_404();

        $user_id = $this->session->userdata('user_id');

        if ($this->Seminar_model->check_registration($user_id, $id)) {
            $this->session->set_flashdata('error', t('Anda sudah terdaftar di seminar ini.', 'Already registered.'));
            redirect('seminars/detail/' . $id);
        }

        $attendee_count = $this->Seminar_model->get_attendee_count($id);
        if ($attendee_count >= $seminar->quota) {
            $this->session->set_flashdata('error', t('Maaf, kuota seminar sudah penuh.', 'Sorry, quota is full.'));
            redirect('seminars/detail/' . $id);
        }

        if ($seminar->price <= 0) {
            $this->Seminar_model->register_user($user_id, $id);
            $this->session->set_flashdata('success', t('Berhasil mendaftar seminar!', 'Registered successfully!'));
            redirect('seminars/detail/' . $id);
        }

        redirect('checkout/initiate/seminar/' . $id);
    }
}
