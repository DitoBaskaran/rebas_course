USE db_course_online;

CREATE TABLE IF NOT EXISTS `roles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `slug` VARCHAR(50) UNIQUE NOT NULL,
  `name` VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `role_permissions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `role_id` INT NOT NULL,
  `module` VARCHAR(50) NOT NULL,
  `action` ENUM('create','read','update','delete') NOT NULL,
  `allowed` TINYINT(1) NOT NULL DEFAULT 1,
  UNIQUE KEY `role_module_action` (`role_id`,`module`,`action`),
  FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `user_permissions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `module` VARCHAR(50) NOT NULL,
  `action` ENUM('create','read','update','delete') NOT NULL,
  `allowed` TINYINT(1) NOT NULL DEFAULT 0,
  UNIQUE KEY `user_module_action` (`user_id`,`module`,`action`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `roles` (`slug`,`name`) VALUES
  ('guru','Guru'), ('mentor','Mentor'), ('user','User (Student)');

-- ============ Seed template: GURU ============
INSERT IGNORE INTO `role_permissions` (`role_id`,`module`,`action`,`allowed`)
SELECT r.id, p.module, p.action, p.allowed FROM roles r JOIN (
  SELECT 'courses' module, 'create' action, 1 allowed UNION ALL
  SELECT 'courses','read',1 UNION ALL SELECT 'courses','update',1 UNION ALL SELECT 'courses','delete',1 UNION ALL
  SELECT 'lessons','create',1 UNION ALL SELECT 'lessons','read',1 UNION ALL SELECT 'lessons','update',1 UNION ALL SELECT 'lessons','delete',1 UNION ALL
  SELECT 'seminars','create',1 UNION ALL SELECT 'seminars','read',1 UNION ALL SELECT 'seminars','update',1 UNION ALL SELECT 'seminars','delete',1 UNION ALL
  SELECT 'assignments','create',1 UNION ALL SELECT 'assignments','read',1 UNION ALL SELECT 'assignments','update',1 UNION ALL SELECT 'assignments','delete',1 UNION ALL
  SELECT 'submissions','create',0 UNION ALL SELECT 'submissions','read',1 UNION ALL SELECT 'submissions','update',1 UNION ALL SELECT 'submissions','delete',0 UNION ALL
  SELECT 'quizzes','create',1 UNION ALL SELECT 'quizzes','read',1 UNION ALL SELECT 'quizzes','update',1 UNION ALL SELECT 'quizzes','delete',1 UNION ALL
  SELECT 'forum','create',1 UNION ALL SELECT 'forum','read',1 UNION ALL SELECT 'forum','update',0 UNION ALL SELECT 'forum','delete',0 UNION ALL
  SELECT 'mentoring','create',0 UNION ALL SELECT 'mentoring','read',0 UNION ALL SELECT 'mentoring','update',0 UNION ALL SELECT 'mentoring','delete',0 UNION ALL
  SELECT 'learning_paths','create',0 UNION ALL SELECT 'learning_paths','read',1 UNION ALL SELECT 'learning_paths','update',0 UNION ALL SELECT 'learning_paths','delete',0
) p ON p.module IS NOT NULL WHERE r.slug = 'guru';

-- ============ Seed template: MENTOR ============
INSERT IGNORE INTO `role_permissions` (`role_id`,`module`,`action`,`allowed`)
SELECT r.id, p.module, p.action, p.allowed FROM roles r JOIN (
  SELECT 'mentoring' module, 'create' action, 1 allowed UNION ALL
  SELECT 'mentoring','read',1 UNION ALL SELECT 'mentoring','update',1 UNION ALL SELECT 'mentoring','delete',1 UNION ALL
  SELECT 'forum','create',1 UNION ALL SELECT 'forum','read',1 UNION ALL SELECT 'forum','update',0 UNION ALL SELECT 'forum','delete',0 UNION ALL
  SELECT 'courses','create',0 UNION ALL SELECT 'courses','read',1 UNION ALL SELECT 'courses','update',0 UNION ALL SELECT 'courses','delete',0 UNION ALL
  SELECT 'seminars','create',0 UNION ALL SELECT 'seminars','read',1 UNION ALL SELECT 'seminars','update',0 UNION ALL SELECT 'seminars','delete',0 UNION ALL
  SELECT 'learning_paths','create',0 UNION ALL SELECT 'learning_paths','read',1 UNION ALL SELECT 'learning_paths','update',0 UNION ALL SELECT 'learning_paths','delete',0
) p ON p.module IS NOT NULL WHERE r.slug = 'mentor';

-- ============ Seed template: USER (student) ============
INSERT IGNORE INTO `role_permissions` (`role_id`,`module`,`action`,`allowed`)
SELECT r.id, p.module, p.action, p.allowed FROM roles r JOIN (
  SELECT 'courses' module, 'create' action, 0 allowed UNION ALL
  SELECT 'courses','read',1 UNION ALL SELECT 'courses','update',0 UNION ALL SELECT 'courses','delete',0 UNION ALL
  SELECT 'lessons','create',0 UNION ALL SELECT 'lessons','read',1 UNION ALL SELECT 'lessons','update',0 UNION ALL SELECT 'lessons','delete',0 UNION ALL
  SELECT 'seminars','create',1 UNION ALL SELECT 'seminars','read',1 UNION ALL SELECT 'seminars','update',0 UNION ALL SELECT 'seminars','delete',0 UNION ALL
  SELECT 'mentoring','create',1 UNION ALL SELECT 'mentoring','read',1 UNION ALL SELECT 'mentoring','update',0 UNION ALL SELECT 'mentoring','delete',0 UNION ALL
  SELECT 'forum','create',1 UNION ALL SELECT 'forum','read',1 UNION ALL SELECT 'forum','update',1 UNION ALL SELECT 'forum','delete',1 UNION ALL
  SELECT 'submissions','create',1 UNION ALL SELECT 'submissions','read',1 UNION ALL SELECT 'submissions','update',0 UNION ALL SELECT 'submissions','delete',0 UNION ALL
  SELECT 'learning_paths','create',0 UNION ALL SELECT 'learning_paths','read',1 UNION ALL SELECT 'learning_paths','update',0 UNION ALL SELECT 'learning_paths','delete',0
) p ON p.module IS NOT NULL WHERE r.slug = 'user';
