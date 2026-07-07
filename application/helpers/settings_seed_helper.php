<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('seed_marketing_tables')) {
  function seed_marketing_tables() {
    $CI =& get_instance();
    $CI->load->dbforge();

    // user_sources — UTM tracking
    if (!$CI->db->table_exists('user_sources')) {
      $CI->dbforge->add_field(array(
        'id'           => array('type' => 'INT', 'auto_increment' => TRUE),
        'user_id'      => array('type' => 'INT', 'null' => TRUE),
        'source'       => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => TRUE),
        'medium'       => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => TRUE),
        'campaign'     => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => TRUE),
        'referrer'     => array('type' => 'VARCHAR', 'constraint' => 500, 'null' => TRUE),
        'landing_page' => array('type' => 'VARCHAR', 'constraint' => 500, 'null' => TRUE),
        'created_at'   => array('type' => 'DATETIME', 'null' => TRUE),
      ));
      $CI->dbforge->add_key('id', TRUE);
      $CI->dbforge->add_key('user_id');
      $CI->dbforge->create_table('user_sources', TRUE);
    }

    // coupons — discount codes
    if (!$CI->db->table_exists('coupons')) {
      $CI->dbforge->add_field(array(
        'id'             => array('type' => 'INT', 'auto_increment' => TRUE),
        'code'           => array('type' => 'VARCHAR', 'constraint' => 50),
        'discount_type'  => array('type' => 'VARCHAR', 'constraint' => 10, 'default' => 'percent'),
        'discount_value' => array('type' => 'INT', 'default' => 0),
        'min_purchase'   => array('type' => 'INT', 'default' => 0),
        'max_uses'       => array('type' => 'INT', 'null' => TRUE),
        'used_count'     => array('type' => 'INT', 'default' => 0),
        'expired_at'     => array('type' => 'DATETIME', 'null' => TRUE),
        'is_active'      => array('type' => 'TINYINT', 'default' => 1),
        'created_at'     => array('type' => 'DATETIME', 'null' => TRUE),
      ));
      $CI->dbforge->add_key('id', TRUE);
      $CI->dbforge->add_key('code');
      $CI->dbforge->create_table('coupons', TRUE);
    }

    // coupon_usages
    if (!$CI->db->table_exists('coupon_usages')) {
      $CI->dbforge->add_field(array(
        'id'             => array('type' => 'INT', 'auto_increment' => TRUE),
        'coupon_id'      => array('type' => 'INT', 'null' => TRUE),
        'user_id'        => array('type' => 'INT', 'null' => TRUE),
        'transaction_id' => array('type' => 'INT', 'null' => TRUE),
        'used_at'        => array('type' => 'DATETIME', 'null' => TRUE),
      ));
      $CI->dbforge->add_key('id', TRUE);
      $CI->dbforge->create_table('coupon_usages', TRUE);
    }

    // wishlists
    if (!$CI->db->table_exists('wishlists')) {
      $CI->dbforge->add_field(array(
        'id'        => array('type' => 'INT', 'auto_increment' => TRUE),
        'user_id'   => array('type' => 'INT', 'null' => TRUE),
        'course_id' => array('type' => 'INT', 'null' => TRUE),
        'created_at' => array('type' => 'DATETIME', 'null' => TRUE),
      ));
      $CI->dbforge->add_key('id', TRUE);
      $CI->dbforge->add_key(array('user_id', 'course_id'));
      $CI->dbforge->create_table('wishlists', TRUE);
    }

    // subscriptions
    if (!$CI->db->table_exists('subscriptions')) {
      $CI->dbforge->add_field(array(
        'id'                     => array('type' => 'INT', 'auto_increment' => TRUE),
        'user_id'                => array('type' => 'INT', 'null' => TRUE),
        'plan'                   => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => 'basic'),
        'start_date'             => array('type' => 'DATETIME', 'null' => TRUE),
        'end_date'               => array('type' => 'DATETIME', 'null' => TRUE),
        'status'                 => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => 'active'),
        'gateway_subscription_id' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => TRUE),
        'created_at'             => array('type' => 'DATETIME', 'null' => TRUE),
      ));
      $CI->dbforge->add_key('id', TRUE);
      $CI->dbforge->create_table('subscriptions', TRUE);
    }

    // Add status and last_login columns to users table if they don't exist
    if ($CI->db->table_exists('users')) {
        $user_fields = $CI->db->field_data('users');
        $user_field_names = array();
        foreach ($user_fields as $f) { $user_field_names[] = $f->name; }
        if (!in_array('status', $user_field_names)) {
            $CI->dbforge->add_column('users', array('status' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => 'active')));
        }
        if (!in_array('last_login', $user_field_names)) {
            $CI->dbforge->add_column('users', array('last_login' => array('type' => 'DATETIME', 'null' => TRUE)));
        }
    }

    // password_resets
    if (!$CI->db->table_exists('password_resets')) {
      $CI->dbforge->add_field(array(
        'id'         => array('type' => 'INT', 'auto_increment' => TRUE),
        'email'      => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
        'token'      => array('type' => 'VARCHAR', 'constraint' => 100),
        'expired_at' => array('type' => 'DATETIME', 'null' => TRUE),
        'used_at'    => array('type' => 'DATETIME', 'null' => TRUE),
      ));
      $CI->dbforge->add_key('id', TRUE);
      $CI->dbforge->add_key('token');
      $CI->dbforge->create_table('password_resets', TRUE);
    }

    // user_points (gamification)
    if (!$CI->db->table_exists('user_points')) {
      $CI->dbforge->add_field(array(
        'id'         => array('type' => 'INT', 'auto_increment' => TRUE),
        'user_id'    => array('type' => 'INT', 'null' => TRUE),
        'points'     => array('type' => 'INT', 'default' => 0),
        'level'      => array('type' => 'INT', 'default' => 1),
        'updated_at' => array('type' => 'DATETIME', 'null' => TRUE),
      ));
      $CI->dbforge->add_key('id', TRUE);
      $CI->dbforge->add_key('user_id');
      $CI->dbforge->create_table('user_points', TRUE);
    }

    // point_transactions
    if (!$CI->db->table_exists('point_transactions')) {
      $CI->dbforge->add_field(array(
        'id'           => array('type' => 'INT', 'auto_increment' => TRUE),
        'user_id'      => array('type' => 'INT', 'null' => TRUE),
        'points'       => array('type' => 'INT', 'default' => 0),
        'source'       => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => TRUE),
        'reference_id' => array('type' => 'INT', 'null' => TRUE),
        'created_at'   => array('type' => 'DATETIME', 'null' => TRUE),
      ));
      $CI->dbforge->add_key('id', TRUE);
      $CI->dbforge->create_table('point_transactions', TRUE);
    }

    // badges
    if (!$CI->db->table_exists('badges')) {
      $CI->dbforge->add_field(array(
        'id'          => array('type' => 'INT', 'auto_increment' => TRUE),
        'name'        => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => TRUE),
        'icon'        => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
        'description' => array('type' => 'TEXT', 'null' => TRUE),
        'criteria'    => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => TRUE),
        'criteria_value' => array('type' => 'INT', 'default' => 0),
      ));
      $CI->dbforge->add_key('id', TRUE);
      $CI->dbforge->create_table('badges', TRUE);
    }

    // user_badges
    if (!$CI->db->table_exists('user_badges')) {
      $CI->dbforge->add_field(array(
        'id'        => array('type' => 'INT', 'auto_increment' => TRUE),
        'user_id'   => array('type' => 'INT', 'null' => TRUE),
        'badge_id'  => array('type' => 'INT', 'null' => TRUE),
        'earned_at' => array('type' => 'DATETIME', 'null' => TRUE),
      ));
      $CI->dbforge->add_key('id', TRUE);
      $CI->dbforge->create_table('user_badges', TRUE);
    }

    // Add payment gateway columns to transactions table
    if ($CI->db->table_exists('transactions')) {
        $tx_fields = $CI->db->field_data('transactions');
        $tx_field_names = array();
        foreach ($tx_fields as $f) { $tx_field_names[] = $f->name; }
        if (!in_array('payment_channel', $tx_field_names)) {
            $CI->dbforge->add_column('transactions', array('payment_channel' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => TRUE)));
        }
        if (!in_array('gateway_tx_id', $tx_field_names)) {
            $CI->dbforge->add_column('transactions', array('gateway_tx_id' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => TRUE)));
        }
    }

    // affiliates
    if (!$CI->db->table_exists('affiliates')) {
      $CI->dbforge->add_field(array(
        'id'               => array('type' => 'INT', 'auto_increment' => TRUE),
        'user_id'          => array('type' => 'INT', 'null' => TRUE),
        'referral_code'    => array('type' => 'VARCHAR', 'constraint' => 50),
        'total_commission' => array('type' => 'INT', 'default' => 0),
        'paid_commission'  => array('type' => 'INT', 'default' => 0),
       ));
      $CI->dbforge->add_key('id', TRUE);
      $CI->dbforge->add_key('referral_code');
      $CI->dbforge->create_table('affiliates', TRUE);
    }

    // affiliate_clicks
    if (!$CI->db->table_exists('affiliate_clicks')) {
      $CI->dbforge->add_field(array(
        'id'           => array('type' => 'INT', 'auto_increment' => TRUE),
        'affiliate_id' => array('type' => 'INT', 'null' => TRUE),
        'ip'           => array('type' => 'VARCHAR', 'constraint' => 45, 'null' => TRUE),
        'user_agent'   => array('type' => 'VARCHAR', 'constraint' => 500, 'null' => TRUE),
        'created_at'   => array('type' => 'DATETIME', 'null' => TRUE),
      ));
      $CI->dbforge->add_key('id', TRUE);
      $CI->dbforge->create_table('affiliate_clicks', TRUE);
    }

    // affiliate_conversions
    if (!$CI->db->table_exists('affiliate_conversions')) {
      $CI->dbforge->add_field(array(
        'id'              => array('type' => 'INT', 'auto_increment' => TRUE),
        'affiliate_id'    => array('type' => 'INT', 'null' => TRUE),
        'referred_user_id' => array('type' => 'INT', 'null' => TRUE),
        'transaction_id'  => array('type' => 'INT', 'null' => TRUE),
        'commission'      => array('type' => 'INT', 'default' => 0),
        'status'          => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => 'pending'),
      ));
      $CI->dbforge->add_key('id', TRUE);
      $CI->dbforge->create_table('affiliate_conversions', TRUE);
    }

    // contact_messages
    if (!$CI->db->table_exists('contact_messages')) {
      $CI->dbforge->add_field(array(
        'id'         => array('type' => 'INT', 'auto_increment' => TRUE),
        'name'       => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
        'email'      => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
        'message'    => array('type' => 'TEXT', 'null' => TRUE),
        'created_at' => array('type' => 'DATETIME', 'null' => TRUE),
      ));
      $CI->dbforge->add_key('id', TRUE);
      $CI->dbforge->create_table('contact_messages', TRUE);
    }
  }
}

if (!function_exists('seed_default_settings')) {
  function seed_default_settings() {
    $CI =& get_instance();
    $CI->load->model('Setting_model');
    $CI->load->dbforge();

    if (!$CI->db->table_exists('settings')) {
      $CI->dbforge->add_field(array(
        'id' => array('type' => 'INT', 'auto_increment' => TRUE),
        'key' => array('type' => 'VARCHAR', 'constraint' => 100, 'unique' => TRUE),
        'value' => array('type' => 'TEXT', 'null' => TRUE),
        'type' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'text'),
        'group' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'general'),
        'label' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
        'sort_order' => array('type' => 'INT', 'default' => 0),
      ));
      $CI->dbforge->add_key('id', TRUE);
      $CI->dbforge->create_table('settings', TRUE);
    }

    $defaults = array(

      // General
      array('key' => 'general_site_name',        'value' => 'REBAS COURSE',             'type' => 'text',     'group' => 'general', 'label' => 'Site Name', 'sort_order' => 1),
      array('key' => 'general_site_description', 'value' => 'Platform belajar online modern dengan kelas terstruktur dan seminar interaktif dari para ahli terbaik Indonesia.', 'type' => 'textarea', 'group' => 'general', 'label' => 'Site Description', 'sort_order' => 2),
      array('key' => 'general_site_keywords',    'value' => 'belajar online, kursus, seminar, workshop, bootcamp, e-book', 'type' => 'text', 'group' => 'general', 'label' => 'Site Keywords', 'sort_order' => 3),
      array('key' => 'general_site_logo',        'value' => '',                          'type' => 'image',    'group' => 'general', 'label' => 'Site Logo', 'sort_order' => 4),
      array('key' => 'general_site_favicon',     'value' => '',                          'type' => 'image',    'group' => 'general', 'label' => 'Favicon', 'sort_order' => 5),
      array('key' => 'general_admin_email',      'value' => 'admin@rebascourse.com',      'type' => 'email',    'group' => 'general', 'label' => 'Admin Email', 'sort_order' => 6),
      array('key' => 'general_contact_email',    'value' => 'support@rebascourse.com',   'type' => 'email',    'group' => 'general', 'label' => 'Contact Email', 'sort_order' => 7),
      array('key' => 'general_contact_phone',    'value' => '021-1234-5678',             'type' => 'text',     'group' => 'general', 'label' => 'Contact Phone', 'sort_order' => 8),
      array('key' => 'general_contact_address',  'value' => 'Jakarta, Indonesia',        'type' => 'textarea', 'group' => 'general', 'label' => 'Address', 'sort_order' => 9),

      // Appearance
      array('key' => 'appearance_primary_color',   'value' => '#0d6efd', 'type' => 'color', 'group' => 'appearance', 'label' => 'Primary Color', 'sort_order' => 1),
      array('key' => 'appearance_secondary_color', 'value' => '#6c757d', 'type' => 'color', 'group' => 'appearance', 'label' => 'Secondary Color', 'sort_order' => 2),
      array('key' => 'appearance_accent_color',    'value' => '#6366f1', 'type' => 'color', 'group' => 'appearance', 'label' => 'Accent Color', 'sort_order' => 3),
      array('key' => 'appearance_body_font',       'value' => '',        'type' => 'text',  'group' => 'appearance', 'label' => 'Body Font Family', 'sort_order' => 4),
      array('key' => 'appearance_heading_font',    'value' => '',        'type' => 'text',  'group' => 'appearance', 'label' => 'Heading Font Family', 'sort_order' => 5),

      // Hero
      array('key' => 'hero_enabled',           'value' => '1',      'type' => 'boolean', 'group' => 'hero', 'label' => 'Enable Hero Section', 'sort_order' => 1),
      array('key' => 'hero_badge',             'value' => 'Platform Belajar Skill #1', 'type' => 'text', 'group' => 'hero', 'label' => 'Hero Badge Text', 'sort_order' => 2),
      array('key' => 'hero_badge_en',          'value' => '#1 Skill Learning Platform', 'type' => 'text', 'group' => 'hero', 'label' => 'Hero Badge Text (English)', 'sort_order' => 3),
      array('key' => 'hero_title',             'value' => 'Belajar <span class="text-warning">Skill</span> Apapun, Kapanpun', 'type' => 'textarea', 'group' => 'hero', 'label' => 'Hero Title', 'sort_order' => 4),
      array('key' => 'hero_title_en',          'value' => 'Learn <span class="text-warning">Any Skill</span>, Anytime', 'type' => 'textarea', 'group' => 'hero', 'label' => 'Hero Title (English)', 'sort_order' => 5),
      array('key' => 'hero_subtitle',          'value' => 'Akses ribuan konten belajar terstruktur: programming, desain, bisnis, soft skill, musik, dan banyak lagi. Dari pemula hingga mahir.', 'type' => 'textarea', 'group' => 'hero', 'label' => 'Hero Subtitle', 'sort_order' => 6),
      array('key' => 'hero_subtitle_en',       'value' => 'Access thousands of structured learning content: programming, design, business, soft skills, music, and more.', 'type' => 'textarea', 'group' => 'hero', 'label' => 'Hero Subtitle (English)', 'sort_order' => 7),
      array('key' => 'hero_cta_text',          'value' => 'Cari Konten', 'type' => 'text', 'group' => 'hero', 'label' => 'Hero CTA Text', 'sort_order' => 8),
      array('key' => 'hero_cta_text_en',       'value' => 'Browse Content', 'type' => 'text', 'group' => 'hero', 'label' => 'Hero CTA Text (English)', 'sort_order' => 9),
      array('key' => 'hero_cta_link',          'value' => 'courses', 'type' => 'text', 'group' => 'hero', 'label' => 'Hero CTA Link', 'sort_order' => 10),
      array('key' => 'hero_secondary_cta_text',     'value' => 'Skill Tree', 'type' => 'text', 'group' => 'hero', 'label' => 'Hero Secondary CTA Text', 'sort_order' => 11),
      array('key' => 'hero_secondary_cta_text_en',  'value' => 'Skill Tree', 'type' => 'text', 'group' => 'hero', 'label' => 'Hero Secondary CTA Text (English)', 'sort_order' => 12),
      array('key' => 'hero_secondary_cta_link',     'value' => 'learning_paths', 'type' => 'text', 'group' => 'hero', 'label' => 'Hero Secondary CTA Link', 'sort_order' => 13),

      // Homepage
      array('key' => 'home_show_stats',          'value' => '1', 'type' => 'boolean', 'group' => 'homepage', 'label' => 'Show Stats Strip', 'sort_order' => 1),
      array('key' => 'home_show_categories',     'value' => '1', 'type' => 'boolean', 'group' => 'homepage', 'label' => 'Show Categories Section', 'sort_order' => 2),
      array('key' => 'home_show_featured',       'value' => '1', 'type' => 'boolean', 'group' => 'homepage', 'label' => 'Show Featured Section', 'sort_order' => 3),
      array('key' => 'home_show_recent',         'value' => '1', 'type' => 'boolean', 'group' => 'homepage', 'label' => 'Show Recent Content Section', 'sort_order' => 4),
      array('key' => 'home_show_tags',           'value' => '1', 'type' => 'boolean', 'group' => 'homepage', 'label' => 'Show Popular Tags', 'sort_order' => 5),
      array('key' => 'home_show_seminars',       'value' => '1', 'type' => 'boolean', 'group' => 'homepage', 'label' => 'Show Seminars Section', 'sort_order' => 6),
      array('key' => 'home_show_cta',            'value' => '1', 'type' => 'boolean', 'group' => 'homepage', 'label' => 'Show CTA Section', 'sort_order' => 7),
      array('key' => 'home_featured_count',      'value' => '4', 'type' => 'number',  'group' => 'homepage', 'label' => 'Number of Featured Items', 'sort_order' => 8),
      array('key' => 'home_recent_count',        'value' => '6', 'type' => 'number',  'group' => 'homepage', 'label' => 'Number of Recent Items', 'sort_order' => 9),
      array('key' => 'home_cta_title',           'value' => 'Siap Menguasai Skill Baru?', 'type' => 'text',     'group' => 'homepage', 'label' => 'CTA Title', 'sort_order' => 10),
      array('key' => 'home_cta_title_en',        'value' => 'Ready to Master a New Skill?', 'type' => 'text',     'group' => 'homepage', 'label' => 'CTA Title (English)', 'sort_order' => 11),
      array('key' => 'home_cta_subtitle',        'value' => 'Daftar gratis sekarang dan mulai perjalanan belajarmu bersama ribuan siswa lainnya.', 'type' => 'textarea', 'group' => 'homepage', 'label' => 'CTA Subtitle', 'sort_order' => 12),
      array('key' => 'home_cta_subtitle_en',     'value' => 'Register for free and start your learning journey with thousands of other students.', 'type' => 'textarea', 'group' => 'homepage', 'label' => 'CTA Subtitle (English)', 'sort_order' => 13),
      array('key' => 'home_cta_button_text',     'value' => 'Daftar Gratis', 'type' => 'text', 'group' => 'homepage', 'label' => 'CTA Button Text', 'sort_order' => 14),
      array('key' => 'home_cta_button_text_en',  'value' => 'Register Free', 'type' => 'text', 'group' => 'homepage', 'label' => 'CTA Button Text (English)', 'sort_order' => 15),
      array('key' => 'home_cta_button_link',     'value' => 'auth/register', 'type' => 'text', 'group' => 'homepage', 'label' => 'CTA Button Link', 'sort_order' => 16),

      // Social Media
      array('key' => 'social_facebook',  'value' => '#', 'type' => 'url', 'group' => 'social', 'label' => 'Facebook URL', 'sort_order' => 1),
      array('key' => 'social_instagram', 'value' => '#', 'type' => 'url', 'group' => 'social', 'label' => 'Instagram URL', 'sort_order' => 2),
      array('key' => 'social_youtube',   'value' => '#', 'type' => 'url', 'group' => 'social', 'label' => 'YouTube URL', 'sort_order' => 3),
      array('key' => 'social_tiktok',    'value' => '#', 'type' => 'url', 'group' => 'social', 'label' => 'TikTok URL', 'sort_order' => 4),
      array('key' => 'social_whatsapp',  'value' => '#', 'type' => 'url', 'group' => 'social', 'label' => 'WhatsApp URL', 'sort_order' => 5),
      array('key' => 'social_twitter',   'value' => '#', 'type' => 'url', 'group' => 'social', 'label' => 'Twitter URL', 'sort_order' => 6),
      array('key' => 'social_linkedin',  'value' => '#', 'type' => 'url', 'group' => 'social', 'label' => 'LinkedIn URL', 'sort_order' => 7),

      // Footer
      array('key' => 'footer_about_text',     'value' => 'Platform belajar online modern dengan kelas terstruktur dan seminar interaktif dari para ahli terbaik Indonesia.', 'type' => 'textarea', 'group' => 'footer', 'label' => 'Footer About Text', 'sort_order' => 1),
      array('key' => 'footer_about_text_en',  'value' => 'Modern online learning platform with structured classes and interactive seminars from Indonesia\'s best experts.', 'type' => 'textarea', 'group' => 'footer', 'label' => 'Footer About Text (English)', 'sort_order' => 2),
      array('key' => 'footer_copyright',      'value' => 'REBAS COURSE. All rights reserved.', 'type' => 'text', 'group' => 'footer', 'label' => 'Copyright Text', 'sort_order' => 3),

      // Analytics
      array('key' => 'analytics_ga4_id',      'value' => '', 'type' => 'text', 'group' => 'general', 'label' => 'Google Analytics 4 Measurement ID', 'sort_order' => 50),
      array('key' => 'analytics_fb_pixel',    'value' => '', 'type' => 'text', 'group' => 'general', 'label' => 'Facebook Pixel ID', 'sort_order' => 51),

      // Marketing
      array('key' => 'marketing_social_proof',      'value' => '1', 'type' => 'boolean', 'group' => 'general', 'label' => 'Show Social Proof Bar', 'sort_order' => 52),
      array('key' => 'marketing_exit_popup',        'value' => '1', 'type' => 'boolean', 'group' => 'general', 'label' => 'Show Exit-Intent Popup', 'sort_order' => 53),
      array('key' => 'marketing_exit_popup_text',   'value' => 'Dapatkan diskon 20% untuk kursus pertama Anda!', 'type' => 'text', 'group' => 'general', 'label' => 'Exit Popup Text', 'sort_order' => 54),

      // Email
      array('key' => 'mailgun_api_key',      'value' => '', 'type' => 'text', 'group' => 'general', 'label' => 'Mailgun API Key', 'sort_order' => 55),
      array('key' => 'mailgun_domain',       'value' => '', 'type' => 'text', 'group' => 'general', 'label' => 'Mailgun Domain', 'sort_order' => 56),
      array('key' => 'smtp_host',            'value' => '', 'type' => 'text', 'group' => 'general', 'label' => 'SMTP Host', 'sort_order' => 57),
      array('key' => 'smtp_port',            'value' => '587', 'type' => 'number', 'group' => 'general', 'label' => 'SMTP Port', 'sort_order' => 58),
      array('key' => 'smtp_user',            'value' => '', 'type' => 'text', 'group' => 'general', 'label' => 'SMTP Username', 'sort_order' => 59),
      array('key' => 'smtp_pass',            'value' => '', 'type' => 'text', 'group' => 'general', 'label' => 'SMTP Password', 'sort_order' => 60),

      // Midtrans
      array('key' => 'midtrans_server_key',  'value' => '', 'type' => 'text', 'group' => 'general', 'label' => 'Midtrans Server Key', 'sort_order' => 61),
      array('key' => 'midtrans_client_key',  'value' => '', 'type' => 'text', 'group' => 'general', 'label' => 'Midtrans Client Key', 'sort_order' => 62),
      array('key' => 'midtrans_is_production', 'value' => '0', 'type' => 'boolean', 'group' => 'general', 'label' => 'Midtrans Production Mode', 'sort_order' => 63),

      // Coupon defaults
      array('key' => 'coupon_welcome_code',   'value' => 'WELCOME20', 'type' => 'text', 'group' => 'general', 'label' => 'Welcome Coupon Code', 'sort_order' => 64),
      array('key' => 'coupon_welcome_discount', 'value' => '20', 'type' => 'number', 'group' => 'general', 'label' => 'Welcome Discount (%)', 'sort_order' => 65),

      // Bank/Payment
      array('key' => 'payment_bank_name', 'value' => 'Bank Mandiri', 'type' => 'text', 'group' => 'general', 'label' => 'Bank Name', 'sort_order' => 70),
      array('key' => 'payment_account_number', 'value' => '1234567890', 'type' => 'text', 'group' => 'general', 'label' => 'Account Number', 'sort_order' => 71),
      array('key' => 'payment_account_name', 'value' => 'REBAS COURSE', 'type' => 'text', 'group' => 'general', 'label' => 'Account Holder Name', 'sort_order' => 72),

    );

    foreach ($defaults as $d) {
      $CI->Setting_model->set($d['key'], $d['value'], $d['type'], $d['group'], $d['label']);
    }
  }
}
