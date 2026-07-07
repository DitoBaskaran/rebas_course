<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model {

  public $cache = NULL;
  public $loaded = FALSE;

  public function __construct() {
    parent::__construct();
  }

  private function _ensure_loaded() {
    if ($this->loaded) return;
    $this->loaded = TRUE;
    if (!$this->db->table_exists('settings')) {
      $this->cache = array();
      return;
    }
    $rows = $this->db->get('settings')->result();
    $this->cache = array();
    foreach ($rows as $r) {
      $this->cache[$r->key] = $r;
    }
  }

  public function get($key) {
    $this->_ensure_loaded();
    if (isset($this->cache[$key])) {
      return $this->cache[$key]->value;
    }
    $q = $this->db->where('key', $key)->get('settings');
    return $q->num_rows() ? $q->row()->value : NULL;
  }

  public function set($key, $value, $type = 'text', $group = 'general', $label = '') {
    $existing = $this->db->where('key', $key)->get('settings')->num_rows();
    $data = array('key' => $key, 'value' => $value, 'type' => $type, 'group' => $group, 'label' => $label);
    if ($existing) {
      $this->db->where('key', $key)->update('settings', array('value' => $value));
    } else {
      $this->db->insert('settings', $data);
    }
    $this->cache[$key] = (object) array(
      'key' => $key,
      'value' => $value,
      'type' => $type,
      'group' => $group,
      'label' => $label,
    );
    $this->loaded = TRUE;
    if (function_exists('settings_cache_clear')) {
      settings_cache_clear();
    }
  }

  public function get_all($group = null) {
    if ($this->loaded && empty($group)) {
      return array_values($this->cache);
    }
    $this->db->order_by('sort_order', 'ASC');
    if ($group) {
      $this->db->where('`group`', $group);
    }
    $result = $this->db->get('settings')->result();
    foreach ($result as $row) {
      $this->cache[$row->key] = $row;
    }
    $this->loaded = TRUE;
    return $result;
  }

  public function get_all_grouped() {
    $this->db->order_by('sort_order', 'ASC');
    $rows = $this->db->get('settings')->result();
    $grouped = array();
    foreach ($rows as $r) {
      $grouped[$r->group][] = $r;
    }
    return $grouped;
  }

  public function get_all_as_array() {
    $this->_ensure_loaded();
    $out = array();
    foreach ($this->cache as $key => $r) {
      $out[$key] = $r->value;
    }
    return $out;
  }

  public function delete($key) {
    $this->loaded = FALSE;
    unset($this->cache[$key]);
    $this->loaded = TRUE;
    $this->db->where('key', $key)->delete('settings');
    if (function_exists('settings_cache_clear')) {
      settings_cache_clear();
    }
  }
}
