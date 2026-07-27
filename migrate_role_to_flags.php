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

// 1. Add new columns
$sql = "ALTER TABLE `users`
  ADD COLUMN IF NOT EXISTS `is_teacher` TINYINT(1) DEFAULT 0 AFTER `role`,
  ADD COLUMN IF NOT EXISTS `is_mentor` TINYINT(1) DEFAULT 0 AFTER `is_teacher`";
mysqli_query($conn, $sql);
echo "✓ Columns is_teacher / is_mentor added\n";

// 2. Migrate existing data
mysqli_query($conn, "UPDATE `users` SET `is_teacher` = 1 WHERE `role` = 'teacher'");
$t = mysqli_affected_rows($conn);
echo "✓ Migrated {$t} teacher(s)\n";

mysqli_query($conn, "UPDATE `users` SET `is_mentor` = 1 WHERE `role` = 'mentor'");
$m = mysqli_affected_rows($conn);
echo "✓ Migrated {$m} mentor(s)\n";

// 3. Alter role column
$sql = "ALTER TABLE `users`
  MODIFY COLUMN `role` ENUM('student', 'admin') DEFAULT 'student'";
mysqli_query($conn, $sql);
echo "✓ Role column simplified to ENUM('student', 'admin')\n";

echo "\nMigration complete!</pre>";

mysqli_close($conn);