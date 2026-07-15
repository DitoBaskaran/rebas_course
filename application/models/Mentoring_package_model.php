<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mentoring_package_model extends CI_Model {

    public function get_all($active_only = true) {
        if ($active_only) $this->db->where('is_active', 1);
        $this->db->order_by('sort_order', 'ASC');
        return $this->db->get('mentoring_packages')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('mentoring_packages', array('id' => $id))->row();
    }

    public function create($data) {
        $this->db->insert('mentoring_packages', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('mentoring_packages', $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete('mentoring_packages');
    }
}
