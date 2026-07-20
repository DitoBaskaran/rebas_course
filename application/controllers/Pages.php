<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Course_model');
        $this->load->model('User_model');
    }

    public function about() {
        $data['title'] = t('Tentang Kami - BISATUNTAS', 'About Us - BISATUNTAS');
        $data['og_title'] = t('Tentang BISATUNTAS', 'About BISATUNTAS');
        $data['total_courses'] = $this->Course_model->count_all(array('status' => 'published'));
        $data['total_students'] = $this->User_model->count_all('student');
        $data['total_teachers'] = $this->User_model->count_all('teacher');
        $this->load->view('templates/header', $data);
        $this->load->view('pages/about', $data);
        $this->load->view('templates/footer');
    }

    public function contact() {
        $data['title'] = t('Kontak - BISATUNTAS', 'Contact - BISATUNTAS');
        $data['og_title'] = t('Hubungi Kami', 'Contact Us');
        $this->load->view('templates/header', $data);
        $this->load->view('pages/contact');
        $this->load->view('templates/footer');
    }

    public function contact_send() {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $message = $this->input->post('message');
        // Log ke database atau kirim email
        $this->db->insert('contact_messages', array(
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'created_at' => date('Y-m-d H:i:s'),
        ));
        $this->session->set_flashdata('success', t('Pesan berhasil dikirim!', 'Message sent!'));
        redirect('contact');
    }

    public function faq() {
        $data['title'] = t('FAQ - BISATUNTAS', 'FAQ - BISATUNTAS');
        $data['og_title'] = t('Pertanyaan Umum', 'Frequently Asked Questions');
        $this->load->view('templates/header', $data);
        $this->load->view('pages/faq');
        $this->load->view('templates/footer');
    }

    public function pricing() {
        $data['title'] = t('Harga - BISATUNTAS', 'Pricing - BISATUNTAS');
        $data['og_title'] = t('Pilih Paket Belajar', 'Choose Your Plan');
        $this->load->view('templates/header', $data);
        $this->load->view('pages/pricing');
        $this->load->view('templates/footer');
    }

    public function terms() {
        $data['title'] = t('Syarat & Ketentuan - BISATUNTAS', 'Terms & Conditions - BISATUNTAS');
        $this->load->view('templates/header', $data);
        $this->load->view('pages/terms');
        $this->load->view('templates/footer');
    }

    public function privacy() {
        $data['title'] = t('Kebijakan Privasi - BISATUNTAS', 'Privacy Policy - BISATUNTAS');
        $this->load->view('templates/header', $data);
        $this->load->view('pages/privacy');
        $this->load->view('templates/footer');
    }
}
