<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all($target = NULL, $active_only = FALSE) {
        $this->db->from('banners');
        if ($target !== NULL && in_array($target, array('student', 'mentor'))) {
            $this->db->where("(target = 'both' OR target = '" . $this->db->escape_str($target) . "')");
        }
        if ($active_only) {
            $this->db->where('is_active', 1);
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get('banners')->row();
    }

    public function create($data) {
        $this->db->insert('banners', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id)->update('banners', $data);
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->where('id', $id)->delete('banners');
        return $this->db->affected_rows();
    }
}
