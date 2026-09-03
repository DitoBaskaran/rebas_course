<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access_library {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('User_subscription_model');
        $this->CI->load->model('Package_model');
        $this->CI->load->model('Course_model');
    }

    /**
     * Checks if a user has access to a course based on active subscriptions.
     * This is the primary access check function.
     *
     * @param int $user_id
     * @param int $course_id
     * @return array ['has_access' => bool, 'reason' => string, 'access_type' => 'subscription'|'free'|'none']
     */
    public function check_course_access($user_id, $course_id) {
        // 1. Check if course is free
        $course = $this->CI->Course_model->get_course_by_id($course_id);
        if ($course && $course->price <= 0) {
            return ['has_access' => true, 'reason' => t('Kursus ini gratis.', 'This course is free.'), 'access_type' => 'free'];
        }

        // 2. Check traditional enrollment (one-time purchase)
        if ($user_id && $this->CI->Course_model->check_enrollment($user_id, $course_id)) {
            return ['has_access' => true, 'reason' => t('Anda sudah terdaftar di kursus ini.', 'You are enrolled in this course.'), 'access_type' => 'enrollment'];
        }

        // Anonymous users cannot have subscription access
        if (!$user_id) {
            return ['has_access' => false, 'reason' => t('Silakan login untuk mengakses materi ini.', 'Please login to access this content.'), 'access_type' => 'none'];
        }

        // 3. Check subscription access
        if ($this->CI->User_subscription_model->has_active_subscription_for_course($user_id, $course_id)) {
            return ['has_access' => true, 'reason' => t('Anda memiliki paket langganan aktif.', 'You have an active subscription.'), 'access_type' => 'subscription'];
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
     * Checks if a user has ANY active subscription.
     * @param int $user_id
     * @return bool
     */
    public function has_any_active_subscription($user_id) {
        $subscriptions = $this->CI->User_subscription_model->get_active_subscriptions($user_id);
        return !empty($subscriptions);
    }

    // ================= Menu/module permission (role-based + per-user override) =================

    protected $_perm_cache = array();

    /**
     * Cek apakah user sesi saat ini boleh melakukan $action pada $module.
     * Prioritas: admin selalu TRUE > override user_permissions (menang) > gabungan role_permissions
     * (mengikuti flag role/is_teacher/is_mentor yang sudah ada) > default FALSE kalau tidak ada baris sama sekali.
     *
     * @param string $module 'courses'|'lessons'|'seminars'|'assignments'|'submissions'|'quizzes'|'forum'|'mentoring'|'learning_paths'
     * @param string $action 'create'|'read'|'update'|'delete'
     */
    public function can($module, $action) {
        if ($this->CI->session->userdata('role') === 'admin') return true;
        $user_id = (int)$this->CI->session->userdata('user_id');
        if (!$user_id) return false;
        return $this->user_can($user_id, $module, $action);
    }

    /**
     * Sama seperti can() tapi untuk user_id sembarang (dipakai admin saat mengedit akses user lain).
     */
    public function user_can($user_id, $module, $action) {
        $perms = $this->_load_permissions($user_id);
        $key = $module . ':' . $action;
        if (array_key_exists($key, $perms['override'])) {
            return (bool)$perms['override'][$key];
        }
        return !empty($perms['role'][$key]);
    }

    /**
     * Ambil (dan cache per-request) permission efektif seorang user: role_permissions gabungan
     * dari semua role yang dipegang (union: 1 role saja izinkan sudah cukup) + override user.
     */
    protected function _load_permissions($user_id) {
        if (isset($this->_perm_cache[$user_id])) return $this->_perm_cache[$user_id];

        $this->CI->load->model('User_model');
        $user = $this->CI->User_model->get_user_by_id($user_id);
        $role_slugs = array();
        if ($user) {
            if (!empty($user->is_teacher)) $role_slugs[] = 'guru';
            if (!empty($user->is_mentor)) $role_slugs[] = 'mentor';
            if (empty($role_slugs) && $user->role !== 'admin') $role_slugs[] = 'user';
        }

        $role = array();
        if (!empty($role_slugs)) {
            $rows = $this->CI->db
                ->select('rp.module, rp.action, MAX(rp.allowed) as allowed')
                ->from('role_permissions rp')
                ->join('roles r', 'r.id = rp.role_id')
                ->where_in('r.slug', $role_slugs)
                ->group_by('rp.module, rp.action')
                ->get()->result();
            foreach ($rows as $r) {
                $role[$r->module . ':' . $r->action] = (int)$r->allowed;
            }
        }

        $override = array();
        $rows = $this->CI->db->where('user_id', $user_id)->get('user_permissions')->result();
        foreach ($rows as $r) {
            $override[$r->module . ':' . $r->action] = (int)$r->allowed;
        }

        return $this->_perm_cache[$user_id] = array('role' => $role, 'override' => $override);
    }
}
