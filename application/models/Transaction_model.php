<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->_ensure_uuid_column();
    }

    private function _ensure_uuid_column() {
        if (!$this->db->field_exists('uuid', 'transactions')) {
            $this->load->dbforge();
            $this->dbforge->add_column('transactions', array(
                'uuid' => array('type' => 'VARCHAR', 'constraint' => 32)
            ));
            $this->db->query("UPDATE transactions SET uuid = SUBSTRING(MD5(CONCAT(id, RAND(), UNIX_TIMESTAMP())), 1, 8) WHERE uuid IS NULL OR uuid = ''");
        }
    }

    public function create_transaction($data) {
        if (!isset($data['uuid'])) {
            $data['uuid'] = substr(md5(uniqid(mt_rand(), true)), 0, 8);
        }
        $this->db->insert('transactions', $data);
        return $this->db->insert_id();
    }

    public function get_by_uuid($uuid) {
        return $this->db->get_where('transactions', array('uuid' => $uuid))->row();
    }

    public function get_user_transactions($user_id) {
        $this->db->select('transactions.*, users.name as user_name');
        $this->db->from('transactions');
        $this->db->join('users', 'users.id = transactions.user_id');
        $this->db->where('transactions.user_id', $user_id);
        $this->db->order_by('transactions.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_all_transactions() {
        $this->db->select('transactions.*, users.name as user_name');
        $this->db->from('transactions');
        $this->db->join('users', 'users.id = transactions.user_id');
        $this->db->order_by('transactions.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_transaction_by_id($id) {
        return $this->db->get_where('transactions', array('id' => $id))->row();
    }

    public function update_transaction_status($id, $status) {
        $this->db->where('id', $id);
        return $this->db->update('transactions', array('status' => $status));
    }
}
