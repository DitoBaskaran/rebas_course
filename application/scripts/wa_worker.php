#!/usr/bin/env php
<?php
/**
 * Worker antrian WhatsApp BISATUNTAS.
 * Jalan terus-menerus (systemd): ambil 1 pesan pending → kirim via gateway whatsbas
 * → tidur WA_QUEUE_DELAY (default 30 detik) → ulangi. Delay antar-pesan mencegah spam.
 *
 * Dibuat mandiri (tanpa bootstrap CodeIgniter) supaya ringan & stabil di daemon.
 */

error_reporting(E_ALL);
ini_set('display_errors', 'stderr');

$BASE = '/var/www/html/rebas_course';
$delay = (int) (getenv('WA_QUEUE_DELAY') ?: 30);
if ($delay < 1) $delay = 30;

// ===== Konfigurasi DB (sama dengan application/config/database.php) =====
$db = new mysqli('localhost', 'course_user', 'Ditobaskaran123!@#', 'db_course_online');
if ($db->connect_errno) {
    fwrite(STDERR, "DB connect failed: {$db->connect_error}\n");
    exit(1);
}
$db->set_charset('utf8mb4');

// ===== Konfigurasi gateway dari tabel settings =====
function wa_settings($db) {
    $out = array();
    $res = $db->query("SELECT `key`, `value` FROM settings WHERE `key` IN ('wa_api_key','wa_device_id','wa_enabled','wa_queue_delay')");
    if ($res) {
        while ($row = $res->fetch_assoc()) $out[$row['key']] = $row['value'];
    }
    return $out;
}

$cfg = wa_settings($db);
$api_key = isset($cfg['wa_api_key']) ? $cfg['wa_api_key'] : '';
$device_id = isset($cfg['wa_device_id']) ? $cfg['wa_device_id'] : '';
$enabled = isset($cfg['wa_enabled']) && $cfg['wa_enabled'] === '1';
if (!empty($cfg['wa_queue_delay']) && (int) $cfg['wa_queue_delay'] > 0) {
    $delay = (int) $cfg['wa_queue_delay'];
}

function log_line($msg) {
    fwrite(STDOUT, '[' . date('Y-m-d H:i:s') . '] ' . $msg . "\n");
}

log_line("WhatsApp queue worker started (delay={$delay}s, enabled=" . ($enabled ? 'yes' : 'no') . ")");

while (true) {
    $cfg = wa_settings($db); // reload tiap loop supaya perubahan settings langsung kena
    $api_key = $cfg['wa_api_key'] ?? '';
    $device_id = $cfg['wa_device_id'] ?? '';
    $enabled = isset($cfg['wa_enabled']) && $cfg['wa_enabled'] === '1';
    if (!empty($cfg['wa_queue_delay']) && (int) $cfg['wa_queue_delay'] > 0) {
        $delay = (int) $cfg['wa_queue_delay'];
    }

    if (!$enabled || !$api_key || !$device_id) {
        sleep(10);
        continue;
    }

    // Ambil 1 pesan pending tertua
    $res = $db->query("SELECT id, phone, message FROM wa_message_queue WHERE status='pending' ORDER BY id ASC LIMIT 1");
    if (!$res || $res->num_rows === 0) {
        $res && $res->free();
        sleep(5); // antrian kosong — polling ringan
        continue;
    }
    $row = $res->fetch_assoc();
    $res->free();
    $msg_id = (int) $row['id'];

    $payload = json_encode(array('to' => $row['phone'], 'text' => $row['message']));
    $url = 'https://wa.ditobaskaran.my.id/api.php?action=send-text&device_id=' . urlencode($device_id);

    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_POST => TRUE,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => array('X-API-Key: ' . $api_key, 'Content-Type: application/json'),
        CURLOPT_TIMEOUT => 20,
    ));
    $response = curl_exec($ch);
    $err = curl_error($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $ok = false;
    $error = $err ?: '';
    if (!$err) {
        $data = json_decode($response, TRUE);
        $ok = is_array($data) && !empty($data['ok']);
        if (!$ok) $error = isset($data['error']) ? $data['error'] : ("http_{$http}: " . substr($response, 0, 200));
    }

    if ($ok) {
        $stmt = $db->prepare("UPDATE wa_message_queue SET status='sent', sent_at=NOW(), error=NULL WHERE id=?");
        $stmt->bind_param('i', $msg_id);
        $stmt->execute();
        $stmt->close();
        log_line("sent #{$msg_id} -> {$row['phone']}");
    } else {
        $attempts = 1 + (int) $db->query("SELECT attempts FROM wa_message_queue WHERE id={$msg_id}")->fetch_assoc()['attempts'];
        $status = ($attempts >= 3) ? 'failed' : 'pending';
        $stmt = $db->prepare("UPDATE wa_message_queue SET attempts=?, status=?, error=? WHERE id=?");
        $stmt->bind_param('issi', $attempts, $status, $error, $msg_id);
        $stmt->execute();
        $stmt->close();
        log_line("fail #{$msg_id} -> {$row['phone']} ({$error}) attempts={$attempts}");
    }

    // Jeda antar pesan — kunci anti-spam
    sleep($delay);
}
