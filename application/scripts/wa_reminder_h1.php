#!/usr/bin/env php
<?php
/**
 * Reminder H-1 sesi mentoring BISATUNTAS.
 * Dijalankan tiap hari via cron (mis. 08:00 WIB): cari sesi confirmed besok,
 * kirim WhatsApp reminder ke MENTOR & MENTEE, tandai reminder_sent_at (anti duplikat).
 * Pesan dikirim lewat antrian wa_message_queue (worker dengan delay 30s/pesan).
 */

error_reporting(E_ALL);
ini_set('display_errors', 'stderr');

date_default_timezone_set('Asia/Jakarta');

$BASE = '/var/www/html/rebas_course';

// ===== DB (sama dengan config) =====
$db = new mysqli('localhost', 'course_user', 'Ditobaskaran123!@#', 'db_course_online');
if ($db->connect_errno) {
    fwrite(STDERR, "DB connect failed: {$db->connect_error}\n");
    exit(1);
}
$db->set_charset('utf8mb4');

function log_line($msg) {
    echo '[' . date('Y-m-d H:i:s') . '] ' . $msg . "\n";
}

function wa_setting($db, $key, $default = '') {
    $res = $db->query("SELECT `value` FROM settings WHERE `key` = '" . $db->real_escape_string($key) . "' LIMIT 1");
    if ($res && $row = $res->fetch_assoc()) return $row['value'] !== null && $row['value'] !== '' ? $row['value'] : $default;
    return $default;
}

function enqueue($db, $phone, $message) {
    $stmt = $db->prepare("INSERT INTO wa_message_queue (phone, message) VALUES (?, ?)");
    $stmt->bind_param('ss', $phone, $message);
    $stmt->execute();
    $stmt->close();
}

function normalize_phone($phone) {
    $phone = preg_replace('/[^0-9]/', '', (string) $phone);
    if (substr($phone, 0, 1) === '0') $phone = '62' . substr($phone, 1);
    elseif (substr($phone, 0, 2) !== '62') $phone = '62' . $phone;
    return $phone;
}

// Format tanggal Indonesia: "Sabtu, 8 November 2025"
function format_date_id($datetime) {
    $days = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
    $months = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
    $ts = strtotime($datetime);
    return $days[(int)date('w', $ts)] . ', ' . (int)date('j', $ts) . ' ' . $months[(int)date('n', $ts)] . ' ' . date('Y', $ts);
}

// Format waktu "19.00–19.30 WIB"
function format_time_range_id($datetime, $duration_min) {
    $start = strtotime($datetime);
    $end = $start + ($duration_min * 60);
    return date('H.i', $start) . '–' . date('H.i', $end) . ' WIB';
}

// Template reminder H-1 (persis dari user)
function reminder_template($nama, $tanggal, $jam, $meet_link, $peran) {
    $base = "Halo Kak {$nama} 👋😊\n\n"
          . "Kami ingin memastikan Kakak sudah menerima informasi untuk sesi mentoring besok.\n\n"
          . "Mentoring Session\n"
          . "📅 {$tanggal}\n"
          . "⏰ {$jam}\n";
    if (!empty($meet_link)) {
        $base .= "📍 {$meet_link}\n";
    }
    $base .= "\nAgar sesi lebih efektif, Kakak dapat melihat terlebih dahulu informasi mengenai mentee, termasuk profil dan pertanyaan yang ingin didiskusikan, melalui:\n\n"
           . "🌐 https://course.ditobaskaran.my.id/\n"
           . "Silakan login menggunakan email yang telah terdaftar.\n\n"
           . "Catatan: apabila Kakak sebelumnya telah melakukan reschedule, mohon abaikan pesan ini dan mengikuti jadwal terbaru yang tercantum di kalender/website BISATUNTAS.\n\n"
           . "Apabila terdapat perubahan atau kendala untuk hadir, mohon informasikan kepada mentee dan tim BISATUNTAS.\n\n"
           . "Thank you, Kak, for making time to share your experience and perspective. We hope this session becomes a valuable experience for both mentor and mentee. 🙏✨\n\n"
           . "See you tomorrow! 👋";
    return $base;
}

// Cek aktif
$enabled = wa_setting($db, 'wa_enabled', '0') === '1';
if (!$enabled) {
    log_line("WA disabled — skip.");
    exit(0);
}

// Sesi confirmed besok (H-1) yang belum dikirimi reminder
$tomorrow = date('Y-m-d');
$day_after = date('Y-m-d', strtotime('+2 days'));
$query = "SELECT b.id, b.scheduled_at, b.duration, b.meeting_url,
                 u_student.id AS student_id, u_student.name AS student_name, u_student.phone AS student_phone,
                 u_mentor.name AS mentor_name, u_mentor.phone AS mentor_phone
          FROM mentoring_bookings b
          JOIN users u_student ON u_student.id = b.user_id
          JOIN mentors m ON m.id = b.mentor_id
          JOIN users u_mentor ON u_mentor.id = m.user_id
          WHERE b.status = 'confirmed'
            AND b.reminder_sent_at IS NULL
            AND b.scheduled_at >= '{$tomorrow} 00:00:00'
            AND b.scheduled_at <  '{$day_after} 00:00:00'
          ORDER BY b.scheduled_at ASC";

$res = $db->query($query);
if (!$res) {
    fwrite(STDERR, "Query failed: {$db->error}\n");
    exit(1);
}

$count = $res->num_rows;
log_line("Reminder check: {$count} sesi H-1 ditemukan.");

while ($row = $res->fetch_assoc()) {
    $id = (int) $row['id'];
    $tanggal = format_date_id($row['scheduled_at']);
    $jam = format_time_range_id($row['scheduled_at'], (int) $row['duration']);
    $meet_link = trim((string) $row['meeting_url']);
    $site = 'https://course.ditobaskaran.my.id/';

    // Pesan ke mentor
    $mentor_phone = normalize_phone($row['mentor_phone']);
    if ($mentor_phone) {
        $msg_mentor = reminder_template($row['mentor_name'], $tanggal, $jam, $meet_link, 'mentor');
        enqueue($db, $mentor_phone, $msg_mentor);
        log_line("  → reminder mentor #{$id} ({$row['mentor_name']}) ke {$mentor_phone}");
    }

    // Pesan ke mentee
    $student_phone = normalize_phone($row['student_phone']);
    if ($student_phone) {
        $msg_student = reminder_template($row['student_name'], $tanggal, $jam, $meet_link, 'mentee');
        enqueue($db, $student_phone, $msg_student);
        log_line("  → reminder mentee #{$id} ({$row['student_name']}) ke {$student_phone}");
    }

    // Tandai sudah dikirim (anti duplikat)
    $db->query("UPDATE mentoring_bookings SET reminder_sent_at = NOW() WHERE id = {$id}");
}

log_line("Selesai.");
$db->close();
