<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Referral extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index($code = null) {
        if (!$code) $code = $this->input->get('ref');

        if ($code) {
            $affiliate = $this->db->where('referral_code', $code)->get('affiliates')->row();

            if ($affiliate) {
                // Log click
                $this->db->insert('affiliate_clicks', array(
                    'affiliate_id' => $affiliate->id,
                    'ip' => $this->input->ip_address(),
                    'user_agent' => $this->input->user_agent(),
                    'created_at' => date('Y-m-d H:i:s'),
                ));

                // Save referrer to session
                $this->session->set_userdata('referred_by', $affiliate->id);

                // Set cookie for 30 days
                set_cookie('referred_by', $affiliate->id, 30 * 24 * 3600);
            }
        }

        redirect('courses');
    }
}
