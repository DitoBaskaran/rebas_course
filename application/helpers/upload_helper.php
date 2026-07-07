<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function secure_upload($field, $config = array()) {
    $CI =& get_instance();

    $defaults = array(
        'upload_path' => './uploads/',
        'allowed_types' => 'jpg|jpeg|png|gif',
        'max_size' => 2048,
        'encrypt_name' => TRUE,
        'remove_spaces' => TRUE,
    );

    $config = array_merge($defaults, $config);

    $CI->load->library('upload', $config);

    if (!$CI->upload->do_upload($field)) {
        return array('status' => FALSE, 'error' => $CI->upload->display_errors('', ''));
    }

    $data = $CI->upload->data();

    $allowed_mimes = array(
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'pdf' => 'application/pdf',
        'zip' => 'application/zip',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    );

    $ext = strtolower($data['file_ext']);
    $ext = ltrim($ext, '.');

    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $data['full_path']);
        finfo_close($finfo);

        if (isset($allowed_mimes[$ext]) && $mime !== $allowed_mimes[$ext]) {
            @unlink($data['full_path']);
            return array('status' => FALSE, 'error' => 'Invalid file content.');
        }
    }

    return array('status' => TRUE, 'data' => $data);
}
