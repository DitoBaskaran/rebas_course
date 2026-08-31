<?php
/**
 * Sinkronisasi flag users.is_mentor dengan tabel mentors.
 *
 * Masalah: seed.php membuat baris di `mentors` tanpa menyetel users.is_mentor=1.
 * Akibatnya user tampil sebagai mentor di halaman publik /mentoring dan bisa
 * di-booking, tapi guard Mentor_dashboard (cek is_mentor) menendang mereka
 * ke /home sehingga booking tidak pernah bisa dikonfirmasi.
 *
 * Jalankan sekali: php migrate_sync_mentor_flag.php
 */

$db_file = __DIR__ . '/application/config/database.php';
if (!file_exists($db_file)) {
    exit("database.php tidak ditemukan\n");
}
define('BASEPATH', true);
define('ENVIRONMENT', 'production');
require $db_file;

$cfg  = $db['default'];
$conn = new mysqli($cfg['hostname'], $cfg['username'], $cfg['password'], $cfg['database']);
if ($conn->connect_error) {
    exit('Koneksi gagal: ' . $conn->connect_error . "\n");
}

echo "Sinkronisasi flag is_mentor\n";
echo str_repeat('-', 50) . "\n";

$before = $conn->query("
    SELECT u.id, u.name, u.is_mentor
    FROM users u
    JOIN mentors m ON m.user_id = u.id
    WHERE u.is_mentor = 0
");

$rows = [];
while ($r = $before->fetch_assoc()) {
    $rows[] = $r;
    echo "  perlu diperbaiki: user {$r['id']} ({$r['name']}) is_mentor={$r['is_mentor']}\n";
}

if (!$rows) {
    echo "  Tidak ada yang perlu diperbaiki.\n";
    $conn->close();
    exit(0);
}

$conn->query("
    UPDATE users u
    JOIN mentors m ON m.user_id = u.id
    SET u.is_mentor = 1
    WHERE u.is_mentor = 0
");
echo "\n  " . $conn->affected_rows . " user diperbarui.\n";

echo "\nHasil akhir:\n";
$after = $conn->query("
    SELECT u.id, u.name, u.is_teacher, u.is_mentor, m.is_active
    FROM users u
    JOIN mentors m ON m.user_id = u.id
    ORDER BY u.id
");
while ($r = $after->fetch_assoc()) {
    echo "  user {$r['id']} {$r['name']}: is_teacher={$r['is_teacher']} is_mentor={$r['is_mentor']} mentor_active={$r['is_active']}\n";
}

$conn->close();
echo "\nSelesai.\n";
