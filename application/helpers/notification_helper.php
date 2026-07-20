<?php defined('BASEPATH') OR exit('No direct script allowed');

/**
 * Notification Helper — Send email notifications for platform events
 */

function notify_welcome($user) {
    $CI =& get_instance();
    $CI->load->helper('mail');

    $name = is_array($user) ? ($user['name'] ?? '') : ($user->name ?? '');
    $email = is_array($user) ? ($user['email'] ?? '') : ($user->email ?? '');

    $title = 'Selamat Datang di ' . setting('general_site_name', 'BISATUNTAS');
    $body = 'Halo ' . $name . ',<br><br>' .
            'Selamat datang di ' . setting('general_site_name', 'BISATUNTAS') . '! Akun Anda berhasil dibuat.<br><br>' .
            'Mulai eksplorasi kursus dan jalur belajar yang tersedia untuk mengembangkan skillmu.';
    $cta_text = 'Mulai Belajar';
    $cta_link = base_url('courses');

    send_email($email, $title, email_template('Selamat Datang!', $body, $cta_text, $cta_link));
}

function notify_enrollment($user, $course) {
    $CI =& get_instance();
    $CI->load->helper('mail');

    $name = is_array($user) ? ($user['name'] ?? '') : ($user->name ?? '');
    $email = is_array($user) ? ($user['email'] ?? '') : ($user->email ?? '');
    $course_name = is_array($course) ? ($course['title'] ?? '') : ($course->title ?? '');
    $course_slug = is_array($course) ? ($course['slug'] ?? '') : ($course->slug ?? '');

    $title = 'Berhasil Terdaftar di Kursus';
    $body = 'Halo ' . $name . ',<br><br>' .
            'Anda berhasil terdaftar di kursus <strong>' . $course_name . '</strong>.<br><br>' .
            'Anda bisa langsung mulai belajar sekarang. Semangat belajar!';
    $cta_text = 'Mulai Belajar';
    $cta_link = base_url('courses/learn/' . $course_slug);

    send_email($email, $title, email_template('Pendaftaran Berhasil!', $body, $cta_text, $cta_link));
}

function notify_certificate_issued($user, $course, $cert_code) {
    $CI =& get_instance();
    $CI->load->helper('mail');

    $name = is_array($user) ? ($user['name'] ?? '') : ($user->name ?? '');
    $email = is_array($user) ? ($user['email'] ?? '') : ($user->email ?? '');
    $course_name = is_array($course) ? ($course['title'] ?? '') : ($course->title ?? '');

    $title = 'Sertifikat Telah Diterbitkan';
    $body = 'Selamat, ' . $name . '! 🎉<br><br>' .
            'Anda telah menyelesaikan kursus <strong>' . $course_name . '</strong> dan sertifikat telah diterbitkan.<br><br>' .
            '<strong>Kode Sertifikat:</strong> ' . $cert_code . '<br><br>' .
            'Anda bisa mengunduh sertifikat atau membagikannya.';
    $cta_text = 'Lihat Sertifikat';
    $cta_link = base_url('certificate/my');

    send_email($email, $title, email_template('Sertifikat Diterbitkan!', $body, $cta_text, $cta_link));
}

function notify_quiz_result($user, $quiz_title, $score, $total, $passed) {
    $CI =& get_instance();
    $CI->load->helper('mail');

    $name = is_array($user) ? ($user['name'] ?? '') : ($user->name ?? '');
    $email = is_array($user) ? ($user['email'] ?? '') : ($user->email ?? '');

    $status = $passed ? 'Lulus' : 'Belum Lulus';
    $icon = $passed ? '✅' : '📝';

    $title = 'Hasil Quiz: ' . $quiz_title;
    $body = $icon . ' Halo ' . $name . ',<br><br>' .
            'Berikut hasil quiz Anda:<br><br>' .
            '<strong>Quiz:</strong> ' . $quiz_title . '<br>' .
            '<strong>Nilai:</strong> ' . $score . ' / ' . $total . '<br>' .
            '<strong>Status:</strong> ' . $status;
    $cta_text = 'Lihat Kursus';
    $cta_link = base_url('courses');

    send_email($email, $title, email_template('Hasil Quiz', $body, $cta_text, $cta_link));
}
