<?php
/**
 * TEMPORARY SCRIPT - DELETE AFTER USE
 * Run this once via browser to create missing learning path tables.
 * 
 * IMPORTANT: This script uses your CodeIgniter database configuration
 * to connect and execute the required SQL.
 */

// Load CodeIgniter
$system_path = __DIR__ . '/system';
define('BASEPATH', $system_path . '/core/');
define('APPPATH', __DIR__ . '/application/');
define('VIEWPATH', APPPATH . 'views/');
define('ENVIRONMENT', 'development');
define('FCPATH', __DIR__ . '/');

require_once $system_path . '/core/Common.php';
require_once APPPATH . 'config/database.php';

$db_config = $db['default'];
$conn = mysqli_connect($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

$sql = "
CREATE TABLE IF NOT EXISTS `learning_path_contents` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `path_id` INT NOT NULL,
  `course_id` INT NOT NULL,
  `sort_order` INT DEFAULT 0,
  `is_required` BOOLEAN DEFAULT TRUE,
  FOREIGN KEY (`path_id`) REFERENCES `learning_paths`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `path_enrollments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `path_id` INT NOT NULL,
  `progress_pct` INT DEFAULT 0,
  `started_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `completed_at` TIMESTAMP NULL,
  UNIQUE KEY `user_path` (`user_id`, `path_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`path_id`) REFERENCES `learning_paths`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

if (mysqli_multi_query($conn, $sql)) {
    echo '<h2 style="color:green;">Tables created successfully!</h2>';
    echo '<p>learning_path_contents and path_enrollments are now ready.</p>';
    // Clear results buffer
    while (mysqli_next_result($conn)) {;}
} else {
    echo '<h2 style="color:red;">Error creating tables:</h2>';
    echo '<p>' . mysqli_error($conn) . '</p>';
}

mysqli_close($conn);
echo '<p><strong>Delete this file after use!</strong></p>';
