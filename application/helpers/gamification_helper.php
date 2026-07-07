<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function award_points($user_id, $points, $source, $reference_id = null) {
    $CI =& get_instance();

    // Add points
    $existing = $CI->db->where('user_id', $user_id)->get('user_points')->row();
    if ($existing) {
        $CI->db->where('user_id', $user_id)->update('user_points', array(
            'points' => $existing->points + $points,
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        $new_total = $existing->points + $points;
    } else {
        $CI->db->insert('user_points', array(
            'user_id' => $user_id,
            'points' => $points,
            'level' => 1,
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        $new_total = $points;
    }

    // Log transaction
    $CI->db->insert('point_transactions', array(
        'user_id' => $user_id,
        'points' => $points,
        'source' => $source,
        'reference_id' => $reference_id,
        'created_at' => date('Y-m-d H:i:s'),
    ));

    // Calculate level: level^2 * 100
    $new_level = 1;
    for ($l = 1; $l <= 100; $l++) {
        if ($new_total >= ($l * $l * 100)) {
            $new_level = $l;
        } else {
            break;
        }
    }

    $CI->db->where('user_id', $user_id)->update('user_points', array('level' => $new_level));

    // Check badges
    _check_badges($user_id, $new_total);

    return $new_level;
}

function _check_badges($user_id, $points) {
    $CI =& get_instance();
    $badges = $CI->db->get('badges')->result();
    foreach ($badges as $badge) {
        $earned = $CI->db->where('user_id', $user_id)->where('badge_id', $badge->id)->count_all_results('user_badges');
        if ($earned > 0) continue;

        $qualified = false;
        if ($badge->criteria === 'points' && $points >= $badge->criteria_value) {
            $qualified = true;
        } elseif ($badge->criteria === 'courses_completed') {
            $count = $CI->db->where('user_id', $user_id)->count_all_results('certificates');
            if ($count >= $badge->criteria_value) $qualified = true;
        }

        if ($qualified) {
            $CI->db->insert('user_badges', array(
                'user_id' => $user_id,
                'badge_id' => $badge->id,
                'earned_at' => date('Y-m-d H:i:s'),
            ));
        }
    }
}

function seed_default_badges() {
    $CI =& get_instance();
    if ($CI->db->count_all_results('badges') > 0) return;

    $defaults = array(
        array('name' => 'Fast Learner', 'icon' => '🔥', 'description' => 'Selesaikan 5 lesson dalam 1 hari', 'criteria' => 'points', 'criteria_value' => 50),
        array('name' => 'Quiz Master', 'icon' => '🏆', 'description' => 'Perfect score 3 quiz berturut-turut', 'criteria' => 'points', 'criteria_value' => 100),
        array('name' => 'Bookworm', 'icon' => '📚', 'description' => 'Selesaikan 10 course', 'criteria' => 'courses_completed', 'criteria_value' => 10),
        array('name' => 'Path Finder', 'icon' => '🚀', 'description' => 'Selesaikan 1 learning path', 'criteria' => 'points', 'criteria_value' => 200),
        array('name' => 'Mentor', 'icon' => '⭐', 'description' => 'Selesaikan 5 mentoring sessions', 'criteria' => 'points', 'criteria_value' => 500),
    );

    foreach ($defaults as $b) {
        $CI->db->insert('badges', $b);
    }
}
