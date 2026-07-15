<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_mentoring_balance_model extends CI_Model {

    public function get_by_user($user_id) {
        $this->db->select('user_mentoring_balances.*, mentoring_packages.name, mentoring_packages.name_en');
        $this->db->from('user_mentoring_balances');
        $this->db->join('mentoring_packages', 'mentoring_packages.id = user_mentoring_balances.package_id');
        $this->db->where('user_mentoring_balances.user_id', $user_id);
        $this->db->where('user_mentoring_balances.remaining_sessions >', 0);
        $this->db->group_start();
        $this->db->where('user_mentoring_balances.expired_at IS NULL');
        $this->db->or_where('user_mentoring_balances.expired_at >=', date('Y-m-d'));
        $this->db->group_end();
        $this->db->order_by('user_mentoring_balances.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('user_mentoring_balances', array('id' => $id))->row();
    }

    public function create($data) {
        $this->db->insert('user_mentoring_balances', $data);
        return $this->db->insert_id();
    }

    public function deduct_session($id) {
        $this->db->set('remaining_sessions', 'remaining_sessions - 1', false);
        $this->db->where('id', $id);
        $this->db->where('remaining_sessions >', 0);
        return $this->db->update('user_mentoring_balances');
    }

    public function restore_session($id) {
        $this->db->set('remaining_sessions', 'remaining_sessions + 1', false);
        $this->db->where('id', $id);
        return $this->db->update('user_mentoring_balances');
    }
}
