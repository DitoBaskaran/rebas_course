<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Otp_helper — helper notifikasi WhatsApp untuk BISATUNTAS.
 * Kirim OTP pendaftaran + notifikasi sesi mentoring lewat gateway whatsbas.
 * Semua fungsi aman dipanggil dari mana saja; kegagalan WA tidak menggagalkan alur utama.
 */

if (!function_exists('wa_enabled')) {
    function wa_enabled() {
        $CI =& get_instance();
        $CI->load->library('Whatsapp');
        return $CI->whatsapp->enabled();
    }
}

if (!function_exists('wa_phone')) {
    function wa_phone($phone) {
        $CI =& get_instance();
        $CI->load->library('Whatsapp');
        return $CI->whatsapp->normalize_phone($phone);
    }
}

/** Ambil placeholder {{...}} dari template, lalu isi dengan $vars. */
if (!function_exists('wa_render_template')) {
    function wa_render_template($template, $vars = array()) {
        if (!$template) return '';
        $out = $template;
        foreach ($vars as $k => $v) {
            $out = str_replace('{{' . $k . '}}', (string) $v, $out);
        }
        return $out;
    }
}

/** Ambil setting template WA dengan default. */
if (!function_exists('wa_setting')) {
    function wa_setting($key, $default = '') {
        $CI =& get_instance();
        $CI->load->model('Setting_model');
        $v = $CI->Setting_model->get($key);
        return ($v === NULL || $v === '') ? $default : $v;
    }
}

/**
 * Buat & kirim OTP pendaftaran via WA.
 * Menyimpan kode di tabel otp_verifications (belum ada user — payload JSON).
 */
if (!function_exists('wa_send_register_otp')) {
    function wa_send_register_otp($name, $email, $phone, $payload = array()) {
        $CI =& get_instance();
        $CI->load->library('Whatsapp');
        if (!$CI->whatsapp->enabled()) {
            return array('ok' => false, 'error' => 'whatsapp_disabled');
        }

        $phone = $CI->whatsapp->normalize_phone($phone);
        $otp   = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $ttl   = (int) wa_setting('wa_otp_ttl', 5);
        if ($ttl < 1) $ttl = 5;
        $expires = date('Y-m-d H:i:s', time() + $ttl * 60);

        $site = wa_setting('general_site_name', 'BISATUNTAS');
        $template = wa_setting('wa_otp_template', "Kode OTP {$site} Anda: {{otp}}\nBerlaku {{ttl}} menit. Jangan bagikan kode ini kepada siapa pun.");
        $text = wa_render_template($template, array(
            'otp'  => $otp,
            'ttl'  => $ttl,
            'name' => $name,
            'site' => $site,
        ));

        // Simpan OTP dulu; kirim WA sesudahnya (kalau WA gagal, OTP tidak valid).
        $CI->db->insert('otp_verifications', array(
            'phone'      => $phone,
            'otp_code'   => $otp,
            'purpose'    => 'register',
            'payload'    => json_encode(array_merge(array('name' => $name, 'email' => $email), $payload)),
            'expires_at' => $expires,
        ));

        $res = $CI->whatsapp->send_text($phone, $text);
        if (!$res['ok']) {
            // Hapus OTP yang gagal terkirim agar tidak tersisa kadaluarsa
            $CI->db->where('phone', $phone)->where('purpose', 'register')->where('verified_at', NULL)
                   ->where('otp_code', $otp)->delete('otp_verifications');
        }
        return $res;
    }
}

/** Verifikasi OTP pendaftaran. Return array('ok'=>bool, 'payload'=>array|null, 'error'=>string|null). */
if (!function_exists('wa_verify_register_otp')) {
    function wa_verify_register_otp($phone, $otp) {
        $CI =& get_instance();
        $CI->load->library('Whatsapp');
        $phone = $CI->whatsapp->normalize_phone($phone);

        $row = $CI->db->where('phone', $phone)->where('purpose', 'register')
                      ->where('verified_at', NULL)->where('expires_at >', date('Y-m-d H:i:s'))
                      ->order_by('id', 'DESC')->get('otp_verifications')->row();

        if (!$row) {
            return array('ok' => false, 'payload' => null, 'error' => 'otp_invalid');
        }

        if (hash_equals($row->otp_code, (string) $otp)) {
            $CI->db->where('id', $row->id)->update('otp_verifications', array('verified_at' => date('Y-m-d H:i:s')));
            $payload = json_decode((string) $row->payload, TRUE);
            return array('ok' => true, 'payload' => is_array($payload) ? $payload : array(), 'error' => null);
        }

        $CI->db->where('id', $row->id)->set('attempts', 'attempts+1', FALSE)->update('otp_verifications');
        $new_attempts = $CI->db->where('id', $row->id)->get('otp_verifications')->row()->attempts;
        if ($new_attempts >= 5) {
            $CI->db->where('id', $row->id)->update('otp_verifications', array('expires_at' => date('Y-m-d H:i:s')));
            return array('ok' => false, 'payload' => null, 'error' => 'otp_max_attempts');
        }
        return array('ok' => false, 'payload' => null, 'error' => 'otp_wrong');
    }
}

/**
 * Notifikasi ke student: sesi mentoring dikonfirmasi mentor.
 * $session dari Mentoring_bookings_model::get_by_id (sudah join mentor_name).
 */
if (!function_exists('wa_notify_session_confirmed')) {
    function wa_notify_session_confirmed($session) {
        $CI =& get_instance();
        $CI->load->library('Whatsapp');
        if (!$CI->whatsapp->enabled()) return;

        $user = $CI->db->where('id', $session->user_id)->get('users')->row();
        if (!$user || empty($user->phone)) return;

        $site = wa_setting('general_site_name', 'BISATUNTAS');
        $template = wa_setting('wa_session_confirmed_template',
            "Halo {{student_name}}, sesi mentoring Anda dengan {{mentor_name}} telah dikonfirmasi! 🎉\n📅 {{schedule}}\nDurasi {{duration}} menit.\nSiapkan pertanyaan Anda. Sampai jumpa di sesi!");
        $text = wa_render_template($template, array(
            'student_name' => $user->name,
            'mentor_name'  => $session->mentor_name ?: 'Mentor',
            'schedule'     => date('d M Y H:i', strtotime($session->scheduled_at)),
            'duration'     => (int) $session->duration,
            'site'         => $site,
        ));
        $CI->whatsapp->send_text($user->phone, $text);
    }
}

/** Notifikasi ke mentor: ada booking baru menunggu konfirmasi. */
if (!function_exists('wa_notify_mentor_new_booking')) {
    function wa_notify_mentor_new_booking($session) {
        $CI =& get_instance();
        $CI->load->library('Whatsapp');
        if (!$CI->whatsapp->enabled()) return;

        // session punya mentor_id (id baris tabel mentors) + join mentor_name (nama user)
        $mentor = $CI->db->select('users.phone, users.name')
                         ->from('mentors')->join('users', 'users.id = mentors.user_id')
                         ->where('mentors.id', $session->mentor_id)->get()->row();
        if (!$mentor || empty($mentor->phone)) return;

        $student = $CI->db->where('id', $session->user_id)->get('users')->row();
        $site = wa_setting('general_site_name', 'BISATUNTAS');
        $template = wa_setting('wa_mentor_booking_template',
            "Halo {{mentor_name}}, ada permintaan sesi mentoring baru dari {{student_name}}.\n📅 {{schedule}}\nDurasi {{duration}} menit.\nSilakan konfirmasi atau tolak di dashboard mentor.");
        $text = wa_render_template($template, array(
            'mentor_name'  => $mentor->name,
            'student_name' => $student ? $student->name : 'Siswa',
            'schedule'     => date('d M Y H:i', strtotime($session->scheduled_at)),
            'duration'     => (int) $session->duration,
            'site'         => $site,
        ));
        $CI->whatsapp->send_text($mentor->phone, $text);
    }
}

/** Notifikasi ke student: sesi mentoring ditolak mentor. */
if (!function_exists('wa_notify_session_rejected')) {
    function wa_notify_session_rejected($session) {
        $CI =& get_instance();
        $CI->load->library('Whatsapp');
        if (!$CI->whatsapp->enabled()) return;

        $user = $CI->db->where('id', $session->user_id)->get('users')->row();
        if (!$user || empty($user->phone)) return;

        $site = wa_setting('general_site_name', 'BISATUNTAS');
        $template = wa_setting('wa_session_rejected_template',
            "Halo {{student_name}}, mohon maaf sesi mentoring Anda dengan {{mentor_name}} pada {{schedule}} tidak dapat dikonfirmasi. Kuota sesi Anda telah dikembalikan. Silakan booking jadwal lain.");
        $text = wa_render_template($template, array(
            'student_name' => $user->name,
            'mentor_name'  => $session->mentor_name ?: 'Mentor',
            'schedule'     => date('d M Y H:i', strtotime($session->scheduled_at)),
            'site'         => $site,
        ));
        $CI->whatsapp->send_text($user->phone, $text);
    }
}
