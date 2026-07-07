<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('lang')) {
    function lang($key, $default = '') {
        $CI =& get_instance();
        $current_lang = $CI->session->userdata('site_lang') ?: 'id';
        if (!isset($CI->translation_model)) {
            $CI->load->model('Translation_model');
        }
        return $CI->translation_model->get($key, $current_lang);
    }
}

if (!function_exists('current_lang')) {
    function current_lang() {
        $CI =& get_instance();
        return $CI->session->userdata('site_lang') ?: 'id';
    }
}

if (!function_exists('t')) {
    function t($id_text, $en_text = '') {
        if (current_lang() === 'en' && $en_text !== '') {
            return $en_text;
        }
        return $id_text;
    }
}

if (!function_exists('skill_level_label')) {
    function skill_level_label($level) {
        $labels = array(
            'beginner' => t('Pemula', 'Beginner'),
            'intermediate' => t('Menengah', 'Intermediate'),
            'advanced' => t('Mahir', 'Advanced'),
            'all_levels' => t('Semua Level', 'All Levels')
        );
        return $labels[$level] ?? $level;
    }
}

if (!function_exists('content_type_label')) {
    function content_type_label($type) {
        $labels = array(
            'course' => t('Kelas Online', 'Online Course'),
            'workshop' => t('Workshop', 'Workshop'),
            'bootcamp' => t('Bootcamp', 'Bootcamp'),
            'ebook' => t('E-Book', 'E-Book'),
            'project' => t('Proyek', 'Project'),
            'article' => t('Artikel', 'Article'),
            'video' => t('Video', 'Video'),
            'podcast' => t('Podcast', 'Podcast'),
            'template' => t('Template', 'Template')
        );
        return $labels[$type] ?? $type;
    }
}

if (!function_exists('time_elapsed')) {
    function time_elapsed($datetime) {
        $diff = time() - strtotime($datetime);
        if ($diff < 60) return t('Baru saja', 'Just now');
        if ($diff < 3600) return floor($diff/60) . ' ' . t('menit lalu', 'min ago');
        if ($diff < 86400) return floor($diff/3600) . ' ' . t('jam lalu', 'hours ago');
        if ($diff < 2592000) return floor($diff/86400) . ' ' . t('hari lalu', 'days ago');
        return date('d M Y', strtotime($datetime));
    }
}
