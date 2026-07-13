<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access_library {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('User_subscription_model');
        $this->CI->load->model('User_minute_balance_model');
        $this->CI->load->model('Package_model');
        $this->CI->load->model('Course_model'); // For lesson duration
    }

    /**
     * Checks if a user has access to a course based on active subscriptions or minute balance.
     * This is the primary access check function.
     *
     * @param int $user_id
     * @param int $course_id
     * @param int|null $lesson_id Optional lesson ID for minute consumption check
     * @return array ['has_access' => bool, 'reason' => string, 'access_type' => 'subscription'|'minutes'|'free'|'none']
     */
    public function check_course_access($user_id, $course_id, $lesson_id = null) {
        // 1. Check if course/lesson is free
        if ($lesson_id) {
            $lesson = $this->CI->Course_model->get_lesson_by_id($lesson_id);
            if ($lesson && $lesson->is_free) {
                return ['has_access' => true, 'reason' => t('Materi ini gratis.', 'This lesson is free.'), 'access_type' => 'free'];
            }
        } else {
            $course = $this->CI->Course_model->get_course_by_id($course_id);
            if ($course && $course->price <= 0) {
                return ['has_access' => true, 'reason' => t('Kursus ini gratis.', 'This course is free.'), 'access_type' => 'free'];
            }
        }

        // 2. Check traditional enrollment (one-time purchase)
        if ($user_id && $this->CI->Course_model->check_enrollment($user_id, $course_id)) {
            return ['has_access' => true, 'reason' => t('Anda sudah terdaftar di kursus ini.', 'You are enrolled in this course.'), 'access_type' => 'enrollment'];
        }

        // Anonymous users cannot have subscription or minute access
        if (!$user_id) {
            return ['has_access' => false, 'reason' => t('Silakan login untuk mengakses materi ini.', 'Please login to access this content.'), 'access_type' => 'none'];
        }

        // 3. Check subscription access
        if ($this->CI->User_subscription_model->has_active_subscription_for_course($user_id, $course_id)) {
            return ['has_access' => true, 'reason' => t('Anda memiliki paket langganan aktif.', 'You have an active subscription.'), 'access_type' => 'subscription'];
        }

        // 4. Check minute balance access (if lesson_id is provided)
        if ($lesson_id) {
            $lesson = $this->CI->Course_model->get_lesson_by_id($lesson_id);
            if ($lesson && $lesson->duration > 0) {
                $balance = $this->CI->User_minute_balance_model->get_balance($user_id);
                if ($balance && $balance->balance_seconds >= $lesson->duration) {
                    return ['has_access' => true, 'reason' => t('Anda memiliki saldo menit yang cukup.', 'You have sufficient minute balance.'), 'access_type' => 'minutes'];
                }
            }
        }

        return ['has_access' => false, 'reason' => t('Tidak ada akses untuk materi ini.', 'No access to this content.'), 'access_type' => 'none'];
    }

    /**
     * Checks if a user has an active subscription that grants access to a specific course.
     * @param int $user_id
     * @param int $course_id
     * @return bool
     */
    public function has_subscription_access($user_id, $course_id) {
        return $this->CI->User_subscription_model->has_active_subscription_for_course($user_id, $course_id);
    }

    /**
     * Checks if a user has enough minute balance to watch a specific lesson.
     * @param int $user_id
     * @param int $lesson_id
     * @return bool
     */
    public function has_minute_access_for_lesson($user_id, $lesson_id) {
        $lesson = $this->CI->Course_model->get_lesson_by_id($lesson_id);
        if (!$lesson || $lesson->duration <= 0) {
            return true; // No duration or not found, assume free for minute consumption
        }
        $balance = $this->CI->User_minute_balance_model->get_balance($user_id);
        return ($balance && $balance->balance_seconds >= $lesson->duration);
    }

    /**
     * Checks if a user has ANY active subscription.
     * @param int $user_id
     * @return bool
     */
    public function has_any_active_subscription($user_id) {
        $subscriptions = $this->CI->User_subscription_model->get_active_subscriptions($user_id);
        return !empty($subscriptions);
    }
}
