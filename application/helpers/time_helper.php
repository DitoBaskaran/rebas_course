<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('format_duration')) {
    /**
     * Format seconds into human readable duration.
     * @param int $seconds
     * @return string
     */
    function format_duration($seconds) {
        $seconds = (int)$seconds;
        if ($seconds < 60) {
            return $seconds . ' ' . t('detik', 'sec');
        }
        $minutes = floor($seconds / 60);
        $secs = $seconds % 60;
        if ($minutes < 60) {
            return $minutes . ' ' . t('menit', 'min') . ($secs > 0 ? ' ' . $secs . ' ' . t('detik', 'sec') : '');
        }
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        return $hours . ' ' . t('jam', 'h') . ($mins > 0 ? ' ' . $mins . ' ' . t('menit', 'min') : '');
    }
}

if (!function_exists('format_seconds_for_timer')) {
    /**
     * Format seconds for a live countdown timer (MM:SS or HH:MM:SS).
     * @param int $seconds
     * @return string
     */
    function format_seconds_for_timer($seconds) {
        $seconds = (int)$seconds;
        $h = floor($seconds / 3600);
        $m = floor(($seconds % 3600) / 60);
        $s = $seconds % 60;
        if ($h > 0) {
            return sprintf('%02d:%02d:%02d', $h, $m, $s);
        }
        return sprintf('%02d:%02d', $m, $s);
    }
}
