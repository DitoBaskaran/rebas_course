<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Minute_bundle_model extends CI_Model {

    public function get_bundles($active_only = true) {
        if ($active_only) {
            $this->db->where('is_active', 1);
        }
        $this->db->order_by('sort_order', 'ASC');
        return $this->db->get('minute_bundles')->result();
    }

    public function get_bundle_by_id($id) {
        return $this->db->get_where('minute_bundles', array('id' => $id))->row();
    }

    public function create_bundle($data) {
        $this->db->insert('minute_bundles', $data);
        return $this->db->insert_id();
    }

    public function update_bundle($id, $data) {
        return $this->db->where('id', $id)->update('minute_bundles', $data);
    }

    public function delete_bundle($id) {
        return $this->db->where('id', $id)->delete('minute_bundles');
    }
}
