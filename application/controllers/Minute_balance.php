<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Minute_balance extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', t('Silakan login terlebih dahulu.', 'Please login first.'));
            redirect('auth/login');
        }
        $this->load->model('Minute_bundle_model');
        $this->load->model('User_minute_balance_model');
        $this->load->model('Transaction_model');
        $this->load->helper('time');
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');

        $data['title'] = t('Saldo Menit', 'Minute Balance');
        $data['active_page'] = 'minute_balance';
        $data['bundles'] = $this->Minute_bundle_model->get_bundles(true);
        $data['balance'] = $this->User_minute_balance_model->get_balance($user_id);
        $data['consumption_logs'] = $this->User_minute_balance_model->get_consumption_logs($user_id, 20);

        $this->load->view('templates/header', $data);
        $this->load->view('minute_balance/index', $data);
        $this->load->view('templates/footer');
    }

    public function buy($bundle_id) {
        $bundle = $this->Minute_bundle_model->get_bundle_by_id($bundle_id);
        if (!$bundle || !$bundle->is_active) show_404();
        redirect('checkout/initiate/minute_bundle/' . $bundle_id);
    }
}
