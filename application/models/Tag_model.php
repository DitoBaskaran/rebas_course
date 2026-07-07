<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag_model extends CI_Model {

    public function get_all() {
        $this->db->order_by('name', 'ASC');
        return $this->db->get('tags')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('tags', array('id' => $id))->row();
    }

    public function get_by_slug($slug) {
        return $this->db->get_where('tags', array('slug' => $slug))->row();
    }

    public function create($data) {
        $this->db->insert('tags', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tags', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id)->delete('tags');
    }

    public function get_or_create($name, $name_en = '', $slug = '') {
        $slug = $slug ?: url_title($name, 'dash', true);
        $existing = $this->get_by_slug($slug);
        if ($existing) return $existing->id;
        $data = array('name' => $name, 'name_en' => $name_en ?: $name, 'slug' => $slug);
        return $this->create($data);
    }

    public function get_popular($limit = 10) {
        $this->db->select('tags.*, COUNT(content_tags.tag_id) as usage_count');
        $this->db->from('tags');
        $this->db->join('content_tags', 'content_tags.tag_id = tags.id');
        $this->db->group_by('tags.id');
        $this->db->order_by('usage_count', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
}
