<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Translation_model extends CI_Model {

    public function get($key, $lang = 'id') {
        $row = $this->db->get_where('translations', array('key' => $key))->row();
        if (!$row) {
            // Auto-create with key as default ID value
            $this->create($key, $key, '');
            return $key;
        }
        if ($lang === 'en' && !empty($row->value_en)) {
            return $row->value_en;
        }
        return $row->value_id ?: $key;
    }

    public function create($key, $value_id, $value_en = '') {
        return $this->db->insert('translations', array(
            'key' => $key,
            'value_id' => $value_id,
            'value_en' => $value_en
        ));
    }

    public function update($key, $value_id, $value_en = '') {
        $this->db->where('key', $key);
        return $this->db->update('translations', array(
            'value_id' => $value_id,
            'value_en' => $value_en
        ));
    }

    public function get_all_keys() {
        return $this->db->get('translations')->result();
    }
}
