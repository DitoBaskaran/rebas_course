<?php
/**
 * Migration: role column → is_teacher / is_mentor flags
 * Run once via browser after updating the code.
 */

$system_path = __DIR__ . '/system';
define('BASEPATH', $system_path . '/core/');
define('APPPATH', __DIR__ . '/application/');
define('VIEWPATH', APPPATH . 'views/');
define('ENVIRONMENT', 'development');
define('FCPATH', __DIR__ . '/');

require_once $system_path . '/core/Common.php';
require_once APPPATH . 'config/database.php';

$db = $db['default'];
$conn = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);

if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

echo "<pre>Starting migration: role → is_teacher / is_mentor flags\n\n";

// 1. Add new columns (check existence first)
$check_t = mysqli_query($conn, "SHOW COLUMNS FROM `users` LIKE 'is_teacher'");
if (mysqli_num_rows($check_t) === 0) {
    mysqli_query($conn, "ALTER TABLE `users` ADD COLUMN `is_teacher` TINYINT(1) DEFAULT 0 AFTER `role`");
    echo "✓ Column is_teacher added\n";
} else {
    echo "✓ Column is_teacher already exists\n";
}
$check_m = mysqli_query($conn, "SHOW COLUMNS FROM `users` LIKE 'is_mentor'");
if (mysqli_num_rows($check_m) === 0) {
    mysqli_query($conn, "ALTER TABLE `users` ADD COLUMN `is_mentor` TINYINT(1) DEFAULT 0 AFTER `is_teacher`");
    echo "✓ Column is_mentor added\n";
} else {
    echo "✓ Column is_mentor already exists\n";
}

// 2. Migrate existing data
mysqli_query($conn, "UPDATE `users` SET `is_teacher` = 1 WHERE `role` = 'teacher'");
$t = mysqli_affected_rows($conn);
echo "✓ Migrated {$t} teacher(s)\n";

mysqli_query($conn, "UPDATE `users` SET `is_mentor` = 1 WHERE `role` = 'mentor'");
$m = mysqli_affected_rows($conn);
echo "✓ Migrated {$m} mentor(s)\n";

// 3. Ensure no old role values remain before altering column
mysqli_query($conn, "UPDATE `users` SET `role` = 'student' WHERE `role` NOT IN ('student', 'admin')");

// 4. Alter role column
$check_role = mysqli_query($conn, "SHOW COLUMNS FROM `users` LIKE 'role'");
$role_row = mysqli_fetch_assoc($check_role);
if (strpos($role_row['Type'], 'admin') !== false && strpos($role_row['Type'], 'teacher') === false) {
    echo "✓ Role column already simplified\n";
} else {
    $sql = "ALTER TABLE `users`
      MODIFY COLUMN `role` ENUM('student', 'admin') DEFAULT 'student'";
    mysqli_query($conn, $sql);
    echo "✓ Role column simplified to ENUM('student', 'admin')\n";
}

echo "\nMigration complete!</pre>";

mysqli_close($conn);