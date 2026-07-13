<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', t('Silakan login terlebih dahulu.', 'Please login first.'));
            redirect('auth/login');
        }
        $this->load->model('Package_model');
        $this->load->model('User_subscription_model');
        $this->load->model('Transaction_model');
        $this->load->model('Course_model');
    }

    public function index() {
        $data['title'] = t('Paket Berlangganan', 'Subscription Plans');
        $packages = $this->Package_model->get_packages(true);

        foreach ($packages as $pkg) {
            $pkg->six_month_option = $this->Package_model->calculate_6mo_price($pkg->id);
        }

        $data['packages'] = $packages;

        $user_id = $this->session->userdata('user_id');
        $data['active_subscriptions'] = $this->User_subscription_model->get_active_subscriptions($user_id);

        $this->load->view('templates/header', $data);
        $this->load->view('subscription/index', $data);
        $this->load->view('templates/footer');
    }

    public function detail($slug) {
        $package = $this->Package_model->get_package_by_slug($slug);
        if (!$package) show_404();

        $package->six_month_option = $this->Package_model->calculate_6mo_price($package->id);

        $data['title'] = $package->name;
        $data['package'] = $package;
        $data['items'] = $this->Package_model->get_package_items($package->id);

        // Load category & course names for display
        $data['item_details'] = array();
        foreach ($data['items'] as $item) {
            if ($item->item_type === 'category') {
                $cat = $this->db->get_where('categories', array('id' => $item->item_id))->row();
                if ($cat) $data['item_details'][] = array('type' => 'category', 'name' => $cat->name);
            } elseif ($item->item_type === 'course') {
                $course = $this->Course_model->get_course_by_id($item->item_id);
                if ($course) $data['item_details'][] = array('type' => 'course', 'name' => $course->title);
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('subscription/detail', $data);
        $this->load->view('templates/footer');
    }

    public function buy($id_or_slug, $months = 1) {
        $package = is_numeric($id_or_slug) ? $this->Package_model->get_package_by_id($id_or_slug) : $this->Package_model->get_package_by_slug($id_or_slug);
        if (!$package || !$package->is_active) show_404();

        $months = (int)$this->input->post('duration') ?: (int)$months;
        if (!in_array($months, [1, 6])) $months = 1;

        $user_id = $this->session->userdata('user_id');

        // Check if already has active subscription for this package
        $active = $this->User_subscription_model->get_active_subscriptions($user_id);
        foreach ($active as $sub) {
            if ($sub->package_id == $package->id) {
                $this->session->set_flashdata('info', t('Anda sudah berlangganan paket ini.', 'You already subscribed to this package.'));
                redirect('subscription/my');
            }
        }

        // Calculate amount and duration based on months
        if ($months === 6) {
            $six = $this->Package_model->calculate_6mo_price($package->id);
            $amount = $six ? $six['discounted'] : $package->price * 6;
            $item_type = 'package_6mo';
            $duration_days = $package->duration_days * 6;
        } else {
            $amount = $package->price;
            $item_type = 'package';
            $duration_days = $package->duration_days;
        }

        $tx_data = array(
            'user_id' => $user_id,
            'item_type' => $item_type,
            'item_id' => $package->id,
            'amount' => $amount,
            'notes' => json_encode(array('duration_days' => $duration_days)),
            'status' => 'pending'
        );
        $tx_id = $this->Transaction_model->create_transaction($tx_data);
        redirect('checkout/confirm/' . $tx_id);
    }

    public function my() {
        $user_id = $this->session->userdata('user_id');

        // Auto-expire subscriptions that have passed expiry
        $this->User_subscription_model->expire_past_subscriptions();

        $data['title'] = t('Langganan Saya', 'My Subscriptions');
        $data['subscriptions'] = $this->User_subscription_model->get_user_subscriptions($user_id);

        $this->load->view('templates/header', $data);
        $this->load->view('subscription/my', $data);
        $this->load->view('templates/footer');
    }
}
