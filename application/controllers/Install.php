<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends CI_Controller {

    public function index() {
        // Only accessible from localhost for security
        $ip = $this->input->ip_address();
        if (!in_array($ip, array('127.0.0.1', '::1', 'localhost'))) {
            show_error('Access denied. Localhost only.', 403);
        }

        echo "<h1>BISATUNTAS — Database Installation</h1>";
        echo "<pre>";

        $this->load->dbforge();
        $this->load->model('Setting_model');
        $this->load->helper('settings_seed');
        $this->load->helper('gamification');

        // 1. Create all marketing/feature tables
        echo "Running seed_marketing_tables()...\n";
        seed_marketing_tables();
        echo "✅ Marketing tables created.\n\n";

        // 2. Ensure default settings exist
        echo "Running seed_default_settings()...\n";
        seed_default_settings();
        echo "✅ Default settings seeded.\n\n";

        // 3. Seed default badges
        echo "Running seed_default_badges()...\n";
        seed_default_badges();
        echo "✅ Badges seeded.\n\n";

        // 4. Verify all tables exist
        $expected_tables = array(
            'settings', 'translations', 'users', 'categories', 'tags', 'courses', 
            'content_tags', 'lessons', 'enrollments', 'progress', 'seminars',
            'seminar_registrations', 'transactions', 'learning_paths', 
            'learning_path_contents', 'path_enrollments', 'quizzes', 'quiz_questions',
            'quiz_attempts', 'assignments', 'submissions', 'certificates', 'reviews',
            'discussions', 'discussion_replies', 'mentoring_sessions',
            'user_sources', 'coupons', 'coupon_usages', 'wishlists', 'subscriptions',
            'password_resets', 'user_points', 'point_transactions', 'badges',
            'user_badges', 'affiliates', 'affiliate_clicks', 'affiliate_conversions',
            'contact_messages'
        );

        $existing_tables = $this->db->list_tables();
        
        echo "Verifying " . count($expected_tables) . " expected tables...\n";
        $all_ok = true;
        foreach ($expected_tables as $table) {
            if (in_array($table, $existing_tables)) {
                echo "  ✅ {$table}\n";
            } else {
                echo "  ❌ {$table} — MISSING!\n";
                $all_ok = false;
            }
        }

        echo "\n";
        if ($all_ok) {
            echo "🎉 ALL " . count($expected_tables) . " TABLES VERIFIED SUCCESSFULLY!\n";
        } else {
            echo "⚠️ Some tables are missing. Check errors above.\n";
        }

        echo "</pre>";
        echo '<p><a href="' . base_url('admin/dashboard') . '">→ Go to Admin Dashboard</a></p>';
    }
}
