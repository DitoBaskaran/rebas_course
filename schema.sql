CREATE DATABASE IF NOT EXISTS `db_course_online` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_course_online`;

-- ============================================================
-- CORE TABLES
-- ============================================================

-- 1. Users
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) UNIQUE NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('student', 'teacher', 'admin') DEFAULT 'student',
  `bio` TEXT NULL,
  `avatar` VARCHAR(255) DEFAULT 'default_avatar.png',
  `phone` VARCHAR(20) DEFAULT '',
  `language` ENUM('id', 'en') DEFAULT 'id',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Categories (hierarchical)
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `parent_id` INT DEFAULT NULL,
  `name` VARCHAR(100) NOT NULL,
  `name_en` VARCHAR(100) DEFAULT '',
  `slug` VARCHAR(100) UNIQUE NOT NULL,
  `icon` VARCHAR(255) DEFAULT '',
  `description` TEXT NULL,
  `description_en` TEXT NULL,
  `sort_order` INT DEFAULT 0,
  FOREIGN KEY (`parent_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Tags
CREATE TABLE IF NOT EXISTS `tags` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `name_en` VARCHAR(100) DEFAULT '',
  `slug` VARCHAR(100) UNIQUE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- CONTENT (Courses, Workshops, E-books, etc.)
-- ============================================================

-- 4. Courses (main content table — unified for all types)
CREATE TABLE IF NOT EXISTS `courses` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT DEFAULT NULL,
  `teacher_id` INT NOT NULL,
  `content_type` ENUM('course','workshop','bootcamp','ebook','project','article','video','podcast','template') DEFAULT 'course',
  `title` VARCHAR(255) NOT NULL,
  `title_en` VARCHAR(255) DEFAULT '',
  `slug` VARCHAR(255) UNIQUE DEFAULT '',
  `description` TEXT NOT NULL,
  `description_en` TEXT,
  `price` DECIMAL(10, 2) DEFAULT 0.00,
  `thumbnail` VARCHAR(255) DEFAULT 'default_course.png',
  `skill_level` ENUM('beginner','intermediate','advanced','all_levels') DEFAULT 'all_levels',
  `language` ENUM('id','en') DEFAULT 'id',
  `duration_total` INT DEFAULT 0,
  `status` ENUM('draft','published','archived') DEFAULT 'published',
  `featured` BOOLEAN DEFAULT FALSE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`teacher_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Content-Tags (many-to-many)
CREATE TABLE IF NOT EXISTS `content_tags` (
  `content_id` INT NOT NULL,
  `tag_id` INT NOT NULL,
  PRIMARY KEY (`content_id`, `tag_id`),
  FOREIGN KEY (`content_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`tag_id`) REFERENCES `tags`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Lessons (for courses, workshops, bootcamps)
CREATE TABLE IF NOT EXISTS `lessons` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `course_id` INT NOT NULL,
  `lesson_type` ENUM('video','text','quiz','assignment','live_session') DEFAULT 'video',
  `title` VARCHAR(255) NOT NULL,
  `title_en` VARCHAR(255) DEFAULT '',
  `description` TEXT NULL,
  `description_en` TEXT,
  `content` TEXT NULL,
  `content_en` TEXT,
    `video_url` VARCHAR(255) NULL,
    `live_url` VARCHAR(500) DEFAULT NULL,
    `duration` INT DEFAULT 0,
  `sort_order` INT DEFAULT 0,
  `is_free` BOOLEAN DEFAULT FALSE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Enrollments (access to courses)
CREATE TABLE IF NOT EXISTS `enrollments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `course_id` INT NOT NULL,
  `enrolled_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `user_course` (`user_id`, `course_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 8. Progress (lesson completion tracking)
CREATE TABLE IF NOT EXISTS `progress` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `lesson_id` INT NOT NULL,
  `status` ENUM('in_progress', 'completed') DEFAULT 'completed',
  `completed_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `user_lesson` (`user_id`, `lesson_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`lesson_id`) REFERENCES `lessons`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- SEMINARS
-- ============================================================

-- 9. Seminars
CREATE TABLE IF NOT EXISTS `seminars` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `speaker_id` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `title_en` VARCHAR(255) DEFAULT '',
  `description` TEXT NOT NULL,
  `description_en` TEXT,
  `date_time` DATETIME NOT NULL,
  `price` DECIMAL(10, 2) DEFAULT 0.00,
  `location_link` VARCHAR(255) DEFAULT '',
  `thumbnail` VARCHAR(255) DEFAULT 'default_seminar.png',
  `quota` INT DEFAULT 100,
  `language` ENUM('id','en') DEFAULT 'id',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`speaker_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 10. Seminar Registrations
CREATE TABLE IF NOT EXISTS `seminar_registrations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `seminar_id` INT NOT NULL,
  `registered_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `user_seminar` (`user_id`, `seminar_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`seminar_id`) REFERENCES `seminars`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TRANSACTIONS
-- ============================================================

-- 11. Transactions (unified for all content types)
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `item_type` ENUM('course','seminar','workshop','bootcamp','ebook','project','mentoring') NOT NULL,
  `item_id` INT NOT NULL,
  `amount` DECIMAL(10, 2) NOT NULL,
  `payment_proof` VARCHAR(255) DEFAULT NULL,
  `payment_method` VARCHAR(50) DEFAULT 'manual_transfer',
  `notes` TEXT NULL,
  `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- LEARNING PATHS (Skill Trees / Curricula)
-- ============================================================

-- 12. Learning Paths
CREATE TABLE IF NOT EXISTS `learning_paths` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT DEFAULT NULL,
  `title` VARCHAR(255) NOT NULL,
  `title_en` VARCHAR(255) DEFAULT '',
  `slug` VARCHAR(255) UNIQUE NOT NULL,
  `description` TEXT,
  `description_en` TEXT,
  `icon` VARCHAR(255) DEFAULT '',
  `color` VARCHAR(7) DEFAULT '#4361ee',
  `skill_level` ENUM('beginner','intermediate','advanced','all_levels') DEFAULT 'all_levels',
  `estimated_hours` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 13. Learning Path Contents
CREATE TABLE IF NOT EXISTS `learning_path_contents` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `path_id` INT NOT NULL,
  `course_id` INT NOT NULL,
  `sort_order` INT DEFAULT 0,
  `is_required` BOOLEAN DEFAULT TRUE,
  FOREIGN KEY (`path_id`) REFERENCES `learning_paths`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 14. Path Enrollments
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

-- ============================================================
-- QUIZZES
-- ============================================================

-- 15. Quizzes
CREATE TABLE IF NOT EXISTS `quizzes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `course_id` INT NOT NULL,
  `lesson_id` INT DEFAULT NULL,
  `title` VARCHAR(255) NOT NULL,
  `title_en` VARCHAR(255) DEFAULT '',
  `description` TEXT,
  `description_en` TEXT,
  `passing_score` INT DEFAULT 70,
    `time_limit` INT DEFAULT 0,
  `max_attempts` INT DEFAULT 3,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`lesson_id`) REFERENCES `lessons`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 16. Quiz Questions
CREATE TABLE IF NOT EXISTS `quiz_questions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `quiz_id` INT NOT NULL,
  `question` TEXT NOT NULL,
  `question_en` TEXT,
  `question_type` ENUM('multiple_choice','true_false','short_answer','essay') DEFAULT 'multiple_choice',
  `options` JSON NULL,
  `options_en` JSON NULL,
  `correct_answer` TEXT,
  `points` INT DEFAULT 1,
  `sort_order` INT DEFAULT 0,
  FOREIGN KEY (`quiz_id`) REFERENCES `quizzes`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 17. Quiz Attempts
CREATE TABLE IF NOT EXISTS `quiz_attempts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `quiz_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `score` INT DEFAULT 0,
  `total_points` INT DEFAULT 0,
  `answers` JSON NULL,
  `started_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `finished_at` TIMESTAMP NULL,
  FOREIGN KEY (`quiz_id`) REFERENCES `quizzes`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- ASSIGNMENTS (Projects / Portfolios)
-- ============================================================

-- 18. Assignments
CREATE TABLE IF NOT EXISTS `assignments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `course_id` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `title_en` VARCHAR(255) DEFAULT '',
  `description` TEXT NOT NULL,
  `description_en` TEXT,
  `instructions` TEXT,
  `instructions_en` TEXT,
  `attachment` VARCHAR(255) DEFAULT NULL,
  `max_score` INT DEFAULT 100,
  `due_days` INT DEFAULT 7,
  `max_file_size` INT DEFAULT 10,
  `allowed_file_types` VARCHAR(255) DEFAULT 'pdf,zip,rar,doc,docx',
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 19. Submissions
CREATE TABLE IF NOT EXISTS `submissions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `assignment_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `file_url` VARCHAR(255) DEFAULT NULL,
  `text_body` LONGTEXT,
  `text_body_en` LONGTEXT,
  `notes` TEXT,
  `grade` INT DEFAULT NULL,
  `feedback` TEXT,
  `feedback_en` TEXT,
  `status` ENUM('submitted','graded','returned') DEFAULT 'submitted',
  `submitted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `graded_at` TIMESTAMP NULL,
  FOREIGN KEY (`assignment_id`) REFERENCES `assignments`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- CERTIFICATES
-- ============================================================

-- 20. Certificates
CREATE TABLE IF NOT EXISTS `certificates` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `course_id` INT NOT NULL,
  `title` VARCHAR(255) DEFAULT '',
  `title_en` VARCHAR(255) DEFAULT '',
  `certificate_code` VARCHAR(50) NOT NULL UNIQUE,
  `issued_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- REVIEWS & RATINGS
-- ============================================================

-- 21. Reviews
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `course_id` INT NOT NULL,
  `rating` TINYINT NOT NULL,
  `review` TEXT,
  `review_en` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `user_content_review` (`user_id`, `course_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- FORUMS / DISCUSSIONS
-- ============================================================

-- 22. Discussions
CREATE TABLE IF NOT EXISTS `discussions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `course_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `is_pinned` BOOLEAN DEFAULT FALSE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 23. Discussion Replies
CREATE TABLE IF NOT EXISTS `discussion_replies` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `discussion_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `content` TEXT NOT NULL,
  `is_best_answer` BOOLEAN DEFAULT FALSE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`discussion_id`) REFERENCES `discussions`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- MENTORING
-- ============================================================

-- 24. Mentoring Sessions
CREATE TABLE IF NOT EXISTS `mentoring_sessions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `mentor_id` INT NOT NULL,
  `student_id` INT NOT NULL,
  `course_id` INT DEFAULT NULL,
  `scheduled_at` DATETIME NOT NULL,
  `topic` VARCHAR(255) DEFAULT '',
  `topic_en` VARCHAR(255) DEFAULT '',
  `duration` INT DEFAULT 60,
  `meeting_link` VARCHAR(255) DEFAULT '',
  `notes` TEXT,
  `notes_en` TEXT,
  `status` ENUM('scheduled','completed','cancelled') DEFAULT 'scheduled',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`mentor_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`student_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- MULTI-LANGUAGE TRANSLATIONS
-- ============================================================

-- 25. Translations (for UI strings)
CREATE TABLE IF NOT EXISTS `translations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `key` VARCHAR(255) NOT NULL UNIQUE,
  `value_id` TEXT,
  `value_en` TEXT,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
