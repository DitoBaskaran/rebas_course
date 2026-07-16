<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('generate_uuid')) {
    function generate_uuid() {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}

if (!function_exists('encode_id')) {
    function encode_id($id, $secret_key = 'BISATUNTAS_SECRET') {
        $encrypted = base64_encode($id . ':' . $secret_key);
        return rtrim(strtr($encrypted, '+/', '-_'), '=');
    }
}

if (!function_exists('decode_id')) {
    function decode_id($encoded, $secret_key = 'BISATUNTAS_SECRET') {
        $encoded = strtr($encoded, '-_', '+/');
        $padded = $encoded . str_repeat('=', (4 - strlen($encoded) % 4) % 4);
        $decoded = base64_decode($padded);
        if ($decoded === false) return false;
        $parts = explode(':', $decoded, 2);
        if (count($parts) !== 2 || $parts[1] !== $secret_key) return false;
        return (int)$parts[0];
    }
}
