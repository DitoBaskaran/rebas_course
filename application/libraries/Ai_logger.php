<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ai_logger — pencatat pemakaian AI (rekomendasi mentor/kursus).
 * Dipanggil dari library Ai_mentor / Ai_course agar semua call tercatat:
 * siapa user-nya, pesan input, respons AI, dan konsumsi token.
 */
class Ai_logger {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    /**
     * Simpan satu baris log pemakaian AI.
     *
     * @param int    $user_id           ID user pemanggil (0 = anonim)
     * @param string $module            'mentor' | 'course'
     * @param string $status            'success' | 'error'
     * @param string $user_message      Input user (cerita masalah / tujuan belajar)
     * @param string $ai_response       Respons AI (reason/penjelasan) — JSON mentah saat gagal parse
     * @param array  $usage             Array token dari API: prompt_tokens, completion_tokens, total_tokens (optional)
     * @param string $model_name        Nama model yang dipakai (optional)
     * @return int|false                ID baris baru, false kalau gagal
     */
    public function log_usage($user_id, $module, $status, $user_message, $ai_response, $usage = array(), $model_name = '') {
        // Tabel ini dipakai MYSQL, bukan memakai query builder khusus biar ringkas.
        $data = array(
            'user_id'           => (int) $user_id,
            'module'            => ($module === 'course') ? 'course' : 'mentor',
            'status'            => ($status === 'error') ? 'error' : 'success',
            'user_message'      => mb_substr((string) $user_message, 0, 4000),
            'ai_response'       => mb_substr((string) $ai_response, 0, 8000),
            'prompt_tokens'     => isset($usage['prompt_tokens']) ? (int) $usage['prompt_tokens'] : 0,
            'completion_tokens' => isset($usage['completion_tokens']) ? (int) $usage['completion_tokens'] : 0,
            'total_tokens'      => isset($usage['total_tokens']) ? (int) $usage['total_tokens'] : 0,
            'model_name'        => mb_substr((string) $model_name, 0, 100),
        );

        // Kalau tabel belum ada (mis. sebelum migrasi dijalankan), jangan sampai merusak fitur AI.
        if (!$this->CI->db->table_exists('ai_usage_logs')) {
            return false;
        }

        $this->CI->db->insert('ai_usage_logs', $data);
        return $this->CI->db->affected_rows() ? $this->CI->db->insert_id() : false;
    }
}
