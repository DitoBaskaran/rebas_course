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
  `role` ENUM('student', 'admin') DEFAULT 'student',
  `is_teacher` TINYINT(1) DEFAULT 0,
  `is_mentor` TINYINT(1) DEFAULT 0,
  `status` ENUM('active', 'banned') DEFAULT 'active',
  `bio` TEXT NULL,
  `avatar` VARCHAR(255) DEFAULT 'default_avatar.png',
  `phone` VARCHAR(20) DEFAULT '',
  `language` ENUM('id', 'en') DEFAULT 'id',
  `google_id` VARCHAR(100) DEFAULT NULL,
  `last_login` DATETIME NULL,
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
  `uuid` VARCHAR(36) UNIQUE DEFAULT NULL,
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
  `uuid` VARCHAR(32) UNIQUE NOT NULL,
  `user_id` INT NOT NULL,
  `item_type` ENUM('course','seminar','workshop','bootcamp','ebook','project','mentoring','package','package_6mo', 'mentoring_package') NOT NULL,
  `item_id` INT NOT NULL,
  `amount` DECIMAL(10, 2) NOT NULL,
  `coupon_id` INT NULL,
  `discount_amount` DECIMAL(10, 2) DEFAULT 0.00,
  `original_amount` DECIMAL(10, 2) DEFAULT 0.00,
  `payment_proof` VARCHAR(255) DEFAULT NULL,
  `payment_method` VARCHAR(50) DEFAULT '',
  `payment_channel` VARCHAR(50) DEFAULT NULL,
  `gateway_tx_id` VARCHAR(100) DEFAULT NULL,
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
  `is_passed` BOOLEAN DEFAULT 0,
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
  `lesson_id` INT DEFAULT NULL,
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
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`lesson_id`) REFERENCES `lessons`(`id`) ON DELETE CASCADE
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

-- ============================================================
-- SUBSCRIPTIONS, MINUTES, MARKETING & GAMIFICATION
-- ============================================================

-- 26. Packages (subscription tiers defined by admin)
CREATE TABLE IF NOT EXISTS `packages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `name_en` VARCHAR(100) DEFAULT '',
  `slug` VARCHAR(100) UNIQUE NOT NULL,
  `description` TEXT NULL,
  `description_en` TEXT NULL,
  `price` DECIMAL(10, 2) DEFAULT 0.00,
  `duration_days` INT NOT NULL DEFAULT 30,
  `discount_6mo` DECIMAL(5, 2) DEFAULT 0.00 COMMENT 'Diskon persen untuk langganan 6 bulan',
  `access_scope` ENUM('all','category','course') DEFAULT 'all',
  `is_active` BOOLEAN DEFAULT TRUE,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 27. Package Items (content a package grants access to)
CREATE TABLE IF NOT EXISTS `package_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `package_id` INT NOT NULL,
  `item_type` ENUM('category','course') NOT NULL,
  `item_id` INT NOT NULL,
  FOREIGN KEY (`package_id`) REFERENCES `packages`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 28. User Subscriptions (active package subscriptions per user)
CREATE TABLE IF NOT EXISTS `user_subscriptions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `package_id` INT NOT NULL,
  `transaction_id` INT DEFAULT NULL,
  `status` ENUM('active','expired','cancelled') DEFAULT 'active',
  `started_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `expires_at` TIMESTAMP NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`package_id`) REFERENCES `packages`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`transaction_id`) REFERENCES `transactions`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 29. Coupons (discount codes)
CREATE TABLE IF NOT EXISTS `coupons` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `code` VARCHAR(50) NOT NULL,
  `image` VARCHAR(255) NULL,
  `discount_type` VARCHAR(10) DEFAULT 'percent',
  `discount_value` INT DEFAULT 0,
  `min_purchase` INT DEFAULT 0,
  `max_uses` INT NULL,
  `used_count` INT DEFAULT 0,
  `expired_at` DATETIME NULL,
  `is_active` TINYINT DEFAULT 1,
  `created_at` DATETIME NULL,
  INDEX `idx_coupon_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 34. Coupon Usages
CREATE TABLE IF NOT EXISTS `coupon_usages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `coupon_id` INT NULL,
  `user_id` INT NULL,
  `transaction_id` INT NULL,
  `used_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 35. Affiliates
CREATE TABLE IF NOT EXISTS `affiliates` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NULL,
  `referral_code` VARCHAR(50) NOT NULL,
  `total_commission` INT DEFAULT 0,
  `paid_commission` INT DEFAULT 0,
  INDEX `idx_affiliate_code` (`referral_code`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 36. Affiliate Clicks
CREATE TABLE IF NOT EXISTS `affiliate_clicks` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `affiliate_id` INT NULL,
  `ip` VARCHAR(45) NULL,
  `user_agent` VARCHAR(500) NULL,
  `created_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 37. Affiliate Conversions
CREATE TABLE IF NOT EXISTS `affiliate_conversions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `affiliate_id` INT NULL,
  `referred_user_id` INT NULL,
  `transaction_id` INT NULL,
  `commission` INT DEFAULT 0,
  `status` VARCHAR(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- USER ENGAGEMENT
-- ============================================================

-- 38. User Sources (UTM tracking)
CREATE TABLE IF NOT EXISTS `user_sources` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NULL,
  `source` VARCHAR(100) NULL,
  `medium` VARCHAR(100) NULL,
  `campaign` VARCHAR(100) NULL,
  `referrer` VARCHAR(500) NULL,
  `landing_page` VARCHAR(500) NULL,
  `created_at` DATETIME NULL,
  INDEX `idx_user_source_user` (`user_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 39. Wishlists
CREATE TABLE IF NOT EXISTS `wishlists` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NULL,
  `course_id` INT NULL,
  `created_at` DATETIME NULL,
  UNIQUE KEY `user_course_wish` (`user_id`, `course_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 40. Password Resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) NULL,
  `token` VARCHAR(100) NOT NULL,
  `expired_at` DATETIME NULL,
  `used_at` DATETIME NULL,
  INDEX `idx_reset_token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 41. Contact Messages
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NULL,
  `email` VARCHAR(255) NULL,
  `message` TEXT NULL,
  `created_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- GAMIFICATION
-- ============================================================

-- 42. User Points (gamification)
CREATE TABLE IF NOT EXISTS `user_points` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NULL,
  `points` INT DEFAULT 0,
  `level` INT DEFAULT 1,
  `updated_at` DATETIME NULL,
  UNIQUE KEY `uq_user_points` (`user_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 43. Point Transactions
CREATE TABLE IF NOT EXISTS `point_transactions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NULL,
  `points` INT DEFAULT 0,
  `source` VARCHAR(50) NULL,
  `reference_id` INT NULL,
  `created_at` DATETIME NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 44. Badges
CREATE TABLE IF NOT EXISTS `badges` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NULL,
  `icon` VARCHAR(255) NULL,
  `description` TEXT NULL,
  `criteria` VARCHAR(50) NULL,
  `criteria_value` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 45. User Badges
CREATE TABLE IF NOT EXISTS `user_badges` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NULL,
  `badge_id` INT NULL,
  `earned_at` DATETIME NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`badge_id`) REFERENCES `badges`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 46. Settings (for site configuration)
CREATE TABLE IF NOT EXISTS `settings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `key` VARCHAR(100) UNIQUE NOT NULL,
  `value` TEXT NULL,
  `type` VARCHAR(50) DEFAULT 'text',
  `group` VARCHAR(50) DEFAULT 'general',
  `label` VARCHAR(255) DEFAULT '',
  `sort_order` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- MENTORING 1-ON-1
-- ============================================================

-- 47. Mentor Categories
CREATE TABLE IF NOT EXISTS `mentor_categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `name_en` VARCHAR(100) DEFAULT '',
  `slug` VARCHAR(100) UNIQUE NOT NULL,
  `icon` VARCHAR(255) DEFAULT '',
  `description` TEXT NULL,
  `sort_order` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 48. Mentors (profile extension for users with role='mentor')
CREATE TABLE IF NOT EXISTS `mentors` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL UNIQUE,
  `title` VARCHAR(255) DEFAULT '',
  `title_en` VARCHAR(255) DEFAULT '',
  `bio` TEXT NULL,
  `bio_en` TEXT NULL,
  `avatar` VARCHAR(255) DEFAULT '',
  `price_per_session` DECIMAL(10,2) DEFAULT 0.00,
  `durations_available` VARCHAR(50) DEFAULT '15,30,45,60',
  `meeting_platforms` VARCHAR(100) DEFAULT 'zoom,gmeet,whatsapp',
  `is_active` TINYINT(1) DEFAULT 1,
  `is_available_instant` TINYINT(1) DEFAULT 0,
  `avg_rating` DECIMAL(2,1) DEFAULT 0.0,
  `total_reviews` INT DEFAULT 0,
  `total_sessions` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 49. Mentor Category Pivot
CREATE TABLE IF NOT EXISTS `mentor_category_pivot` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `mentor_id` INT NOT NULL,
  `category_id` INT NOT NULL,
  UNIQUE KEY `mentor_cat_unique` (`mentor_id`, `category_id`),
  FOREIGN KEY (`mentor_id`) REFERENCES `mentors`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`category_id`) REFERENCES `mentor_categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 50. Mentoring Packages (what users buy)
CREATE TABLE IF NOT EXISTS `mentoring_packages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `name_en` VARCHAR(100) DEFAULT '',
  `slug` VARCHAR(100) UNIQUE NOT NULL,
  `description` TEXT NULL,
  `description_en` TEXT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `session_count` INT NOT NULL DEFAULT 1,
  `session_duration` INT NOT NULL DEFAULT 30 COMMENT 'minutes per session',
  `is_active` TINYINT(1) DEFAULT 1,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 51. User Mentoring Balances (when user buys a package)
CREATE TABLE IF NOT EXISTS `user_mentoring_balances` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `package_id` INT NOT NULL,
  `total_sessions` INT NOT NULL,
  `remaining_sessions` INT NOT NULL,
  `session_duration` INT NOT NULL COMMENT 'minutes per session from package',
  `expired_at` DATE NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`package_id`) REFERENCES `mentoring_packages`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 53. Dashboard Banners (carousel student & mentor)
CREATE TABLE IF NOT EXISTS `banners` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `link` VARCHAR(255) DEFAULT NULL,
  `target` ENUM('student','mentor','both') DEFAULT 'both',
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 52. Mentor Availability (recurring weekly slots)
CREATE TABLE IF NOT EXISTS `mentor_availability` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `mentor_id` INT NOT NULL,
  `day_of_week` TINYINT NULL COMMENT '0=Sun, 1=Mon, ... 6=Sat',
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  `is_booked` TINYINT(1) DEFAULT 0,
  `booking_session_id` INT NULL,
  `date_override` DATE NULL COMMENT 'specific date override',
  FOREIGN KEY (`mentor_id`) REFERENCES `mentors`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 53. Mentoring Bookings (1-on-1 booked appointments)
CREATE TABLE IF NOT EXISTS `mentoring_bookings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `mentor_id` INT NOT NULL,
  `balance_id` INT NULL,
  `availability_id` INT NULL,
  `scheduled_at` DATETIME NOT NULL,
  `duration` INT NOT NULL DEFAULT 30 COMMENT 'minutes',
  `status` ENUM('pending','confirmed','completed','cancelled','no_show') DEFAULT 'pending',
  `meeting_platform` VARCHAR(50) DEFAULT '',
  `meeting_url` VARCHAR(500) DEFAULT '',
  `notes` TEXT NULL,
  `user_confirmed_at` DATETIME NULL,
  `mentor_confirmed_at` DATETIME NULL,
  `cancelled_by` VARCHAR(10) NULL COMMENT 'user/mentor',
  `cancelled_at` DATETIME NULL,
  `completed_at` DATETIME NULL,
  `reminder_sent_at` DATETIME NULL COMMENT 'H-1 reminder WhatsApp sent',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`mentor_id`) REFERENCES `mentors`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`balance_id`) REFERENCES `user_mentoring_balances`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 54. Mentor Favorites
CREATE TABLE IF NOT EXISTS `mentor_favorites` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `mentor_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `user_mentor_fav` (`user_id`, `mentor_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`mentor_id`) REFERENCES `mentors`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 55. Mentor Reviews (user → mentor)
CREATE TABLE IF NOT EXISTS `mentor_reviews` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `session_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `mentor_id` INT NOT NULL,
  `rating` TINYINT NOT NULL CHECK (`rating` BETWEEN 1 AND 5),
  `review_text` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `session_review` (`session_id`),
  FOREIGN KEY (`session_id`) REFERENCES `mentoring_bookings`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`mentor_id`) REFERENCES `mentors`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 56. User Reputations (mentor → user)
CREATE TABLE IF NOT EXISTS `user_reputations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `session_id` INT NOT NULL,
  `mentor_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `rating` TINYINT NOT NULL CHECK (`rating` BETWEEN 1 AND 5),
  `review_text` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `session_reputation` (`session_id`),
  FOREIGN KEY (`session_id`) REFERENCES `mentoring_bookings`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`mentor_id`) REFERENCES `mentors`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 57. Roles (template akses menu: GURU / MENTOR / USER)
CREATE TABLE IF NOT EXISTS `roles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `slug` VARCHAR(50) UNIQUE NOT NULL,
  `name` VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 58. Role permissions (matriks default per role)
CREATE TABLE IF NOT EXISTS `role_permissions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `role_id` INT NOT NULL,
  `module` VARCHAR(50) NOT NULL,
  `action` ENUM('create','read','update','delete') NOT NULL,
  `allowed` TINYINT(1) NOT NULL DEFAULT 1,
  UNIQUE KEY `role_module_action` (`role_id`,`module`,`action`),
  FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 59. User permissions (override per user: 0 larang, 1 izinkan; kosong = ikut role)
CREATE TABLE IF NOT EXISTS `user_permissions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `module` VARCHAR(50) NOT NULL,
  `action` ENUM('create','read','update','delete') NOT NULL,
  `allowed` TINYINT(1) NOT NULL DEFAULT 0,
  UNIQUE KEY `user_module_action` (`user_id`,`module`,`action`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 60. AI usage logs (riwayat pemakaian AI rekomendasi mentor/kursus + token)
CREATE TABLE IF NOT EXISTS `ai_usage_logs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `module` ENUM('mentor','course') NOT NULL,
  `status` ENUM('success','error') NOT NULL DEFAULT 'success',
  `user_message` TEXT NOT NULL,
  `ai_response` TEXT NOT NULL,
  `prompt_tokens` INT NOT NULL DEFAULT 0,
  `completion_tokens` INT NOT NULL DEFAULT 0,
  `total_tokens` INT NOT NULL DEFAULT 0,
  `model_name` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_user` (`user_id`),
  KEY `idx_module` (`module`),
  KEY `idx_created` (`created_at`),
  CONSTRAINT `fk_ai_logs_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
