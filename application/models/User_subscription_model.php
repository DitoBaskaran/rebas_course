<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_subscription_model extends CI_Model {

    public function get_active_subscriptions($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 'active');
        $this->db->where('expires_at >', date('Y-m-d H:i:s'));
        $this->db->order_by('expires_at', 'ASC');
        return $this->db->get('user_subscriptions')->result();
    }

    public function get_user_subscriptions($user_id) {
        $this->db->select('user_subscriptions.*, packages.name, packages.name_en, packages.slug, packages.access_scope');
        $this->db->from('user_subscriptions');
        $this->db->join('packages', 'packages.id = user_subscriptions.package_id');
        $this->db->where('user_subscriptions.user_id', $user_id);
        $this->db->order_by('user_subscriptions.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_subscription_by_id($id) {
        return $this->db->get_where('user_subscriptions', array('id' => $id))->row();
    }

    public function create_subscription($data) {
        $this->db->insert('user_subscriptions', $data);
        return $this->db->insert_id();
    }

    public function activate_subscription($user_id, $package_id, $duration_days, $transaction_id = null) {
        $data = array(
            'user_id' => $user_id,
            'package_id' => $package_id,
            'transaction_id' => $transaction_id,
            'status' => 'active',
            'started_at' => date('Y-m-d H:i:s'),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+' . $duration_days . ' days')),
        );
        return $this->create_subscription($data);
    }

    public function expire_subscription($id) {
        return $this->db->where('id', $id)->update('user_subscriptions', array('status' => 'expired'));
    }

    public function cancel_subscription($id) {
        return $this->db->where('id', $id)->update('user_subscriptions', array('status' => 'cancelled'));
    }

    public function has_active_subscription_for_course($user_id, $course_id) {
        $this->load->model('Package_model');
        $subscriptions = $this->get_active_subscriptions($user_id);
        foreach ($subscriptions as $sub) {
            if ($this->Package_model->has_access_to_course($sub->package_id, $course_id)) {
                return true;
            }
        }
        return false;
    }

    public function expire_past_subscriptions() {
        $this->db->where('status', 'active');
        $this->db->where('expires_at <=', date('Y-m-d H:i:s'));
        return $this->db->update('user_subscriptions', array('status' => 'expired'));
    }
}
