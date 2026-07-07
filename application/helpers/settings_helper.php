<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('_settings_cache')) {
  function _settings_cache() {
    static $cache = NULL;
    if ($cache !== NULL) return $cache;
    $CI =& get_instance();
    try {
      if ($CI->db->table_exists('settings')) {
        $rows = $CI->db->get('settings')->result();
        $cache = array();
        foreach ($rows as $r) {
          $cache[$r->key] = $r->value;
        }
      } else {
        $cache = array();
      }
    } catch (Exception $e) {
      $cache = array();
    }
    return $cache;
  }
}

if (!function_exists('settings_cache_clear')) {
  function settings_cache_clear() {
    static $cache = NULL;
    $cache = NULL;
  }
}

if (!function_exists('setting')) {
  function setting($key, $default = '') {
    $s = _settings_cache();
    return isset($s[$key]) ? $s[$key] : $default;
  }
}

if (!function_exists('settings')) {
  function settings() {
    return _settings_cache();
  }
}

if (!function_exists('settings_css_vars')) {
  function settings_css_vars() {
    $s = settings();
    $vars = '';
    $map = array(
      'appearance_primary_color'   => '--primary',
      'appearance_secondary_color' => '--secondary',
      'appearance_accent_color'    => '--info',
      'appearance_heading_font'    => '--heading-font',
      'appearance_body_font'       => '--font-family',
    );
    foreach ($map as $key => $var) {
      if (!empty($s[$key])) {
        $vars .= sprintf('%s: %s; ', $var, htmlspecialchars($s[$key], ENT_QUOTES, 'UTF-8'));
      }
    }
    return $vars;
  }
}

if (!function_exists('setting_image_url')) {
  function setting_image_url($key, $default = '') {
    $val = setting($key);
    if ($val && $val !== '') {
      return base_url('uploads/settings/' . $val);
    }
    return $default;
  }
}

if (!function_exists('site_logo_url')) {
  function site_logo_url() {
    $logo = setting('general_site_logo');
    if ($logo) {
      return base_url('uploads/settings/' . $logo);
    }
    return '';
  }
}

if (!function_exists('site_favicon_url')) {
  function site_favicon_url() {
    $fav = setting('general_site_favicon');
    if ($fav) {
      return base_url('uploads/settings/' . $fav);
    }
    return '';
  }
}
