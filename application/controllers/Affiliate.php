<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Affiliate extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('auth/login');
        $this->load->model('User_model');
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $affiliate = $this->db->where('user_id', $user_id)->get('affiliates')->row();

        if (!$affiliate) {
            $code = strtoupper(substr(md5($user_id . time()), 0, 8));
            $this->db->insert('affiliates', array(
                'user_id' => $user_id,
                'referral_code' => $code,
                'total_commission' => 0,
                'paid_commission' => 0,
            ));
            $affiliate = $this->db->where('user_id', $user_id)->get('affiliates')->row();
        }

        $data['affiliate'] = $affiliate;
        $data['clicks'] = $this->db->where('affiliate_id', $affiliate->id)->count_all_results('affiliate_clicks');
        $data['conversions'] = $this->db->where('affiliate_id', $affiliate->id)->get('affiliate_conversions')->result();
        $data['referral_link'] = base_url('?ref=' . $affiliate->referral_code);
        $data['title'] = t('Affiliate - BISATUNTAS', 'Affiliate - BISATUNTAS');
        $data['active_page'] = 'affiliate';

        $this->load->view('templates/student_header', $data);
        $this->load->view('affiliate/index', $data);
        $this->load->view('templates/student_footer');
    }
}
