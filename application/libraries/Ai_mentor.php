<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ai_mentor — rekomendasi mentor via AI (Hermes gateway, OpenAI-compatible).
 * Siswa ceritakan masalah → AI baca profil mentor BISATUNTAS → rekomendasi terbaik.
 */
class Ai_mentor {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    /** Ambil daftar mentor dari DB + kategorinya, format ringkas utk prompt AI. */
    public function build_mentor_catalog() {
        $this->CI->load->model('Mentor_model');
        $mentors = $this->CI->Mentor_model->get_all();
        $catalog = array();
        foreach ($mentors as $m) {
            $cats = $this->CI->Mentor_model->get_categories($m->id);
            $cat_names = array();
            foreach ($cats as $c) {
                $cat_names[] = $c->name ?: $c->name_en;
            }
            $catalog[] = array(
                'id' => $m->id,
                'name' => $m->name,
                'title' => $m->title,
                'categories' => implode(', ', $cat_names),
                'bio' => $m->bio,
                'meeting' => $m->meeting_platforms,
                'price_per_session' => (float) $m->price_per_session,
            );
        }
        return $catalog;
    }

    /**
     * Minta rekomendasi mentor dari AI.
     * Return array('ok'=>bool, 'mentor_ids'=>int[], 'explanation'=>string, 'error'=>string|null).
     */
    public function recommend($user_problem, $user_name = '') {
        $catalog = $this->build_mentor_catalog();
        if (empty($catalog)) {
            return array('ok' => false, 'mentor_ids' => array(), 'explanation' => '', 'error' => 'no_mentors');
        }

        // Prompt: AI harus memilih mentor dari daftar (berdasarkan id) + beri alasan
        $mentor_list = array();
        foreach ($catalog as $m) {
            $mentor_list[] = "ID {$m['id']}: {$m['name']} — {$m['title']} (Kategori: {$m['categories']}). Bio: {$m['bio']}";
        }
        $site = 'BISATUNTAS';
        $prompt = "Kamu adalah konselor karier & edukasi di platform {$site}. Seorang siswa bercerita:\n\n"
            . "\"{$user_problem}\"\n\n"
            . "Berikut daftar mentor yang tersedia:\n" . implode("\n", $mentor_list) . "\n\n"
            . "Tugasmu: rekomendasikan 1-3 mentor PALING COCOK untuk masalah siswa tsb. "
            . "Jawab dalam Bahasa Indonesia, format JSON saja, tanpa teks lain:\n"
            . "{\"mentor_ids\": [id_mentor], \"reason\": \"penjelasan singkat 2-3 kalimat mengapa mentor ini cocok\"}\n"
            . "Pilih hanya dari ID yang tersedia. Jika tidak ada yang cocok, mentor_ids boleh kosong dan reason menjelaskan alasannya.";

        $result = $this->call_ai($prompt);
        if (!$result['ok']) {
            return array('ok' => false, 'mentor_ids' => array(), 'explanation' => '', 'error' => $result['error']);
        }

        // Parse JSON dari response (AI kadang bungkus dgn markdown ```json ... ```)
        $content = $result['content'];
        $content = trim($content);
        // Ambil blok JSON pertama
        if (preg_match('/```(?:json)?\s*(\{.*?\})\s*```/s', $content, $m)) {
            $content = $m[1];
        }
        $data = json_decode($content, true);
        if (!is_array($data)) {
            // Coba cari objek JSON di dalam teks
            preg_match('/\{.*\}/s', $content, $m2);
            if (!empty($m2)) {
                $data = json_decode($m2[0], true);
            }
        }
        if (!is_array($data)) {
            return array('ok' => false, 'mentor_ids' => array(), 'explanation' => $content, 'error' => 'parse_failed');
        }

        $ids = isset($data['mentor_ids']) ? (array) $data['mentor_ids'] : array();
        $ids = array_filter(array_map('intval', $ids));
        // Validasi: hanya ID yang benar-benar ada di katalog
        $valid_ids = array();
        foreach ($catalog as $m) {
            $valid_ids[] = $m['id'];
        }
        $ids = array_values(array_intersect($ids, $valid_ids));
        $ids = array_slice($ids, 0, 3);

        return array(
            'ok' => true,
            'mentor_ids' => $ids,
            'explanation' => isset($data['reason']) ? $data['reason'] : '',
            'error' => null,
        );
    }

    /**
     * Panggil endpoint AI (OpenAI-compatible). Konfigurasi dari application/config/ai_mentor.php
     * (fallback: env Hermes).
     */
    protected function call_ai($prompt) {
        $base_url = getenv('AI_MENTOR_BASE_URL');
        $api_key = getenv('HERMES_CUSTOM_127_0_0_1_20128_API_KEY');
        $model = getenv('AI_MENTOR_MODEL');

        // Baca dari config CI (file application/config/ai_mentor.php)
        if (!$base_url || !$api_key || !$model) {
            $this->CI->config->load('ai_mentor', true);
            $cfg = $this->CI->config->item('ai_mentor');
            if (!$base_url) $base_url = isset($cfg['ai_mentor_base_url']) ? $cfg['ai_mentor_base_url'] : '';
            if (!$api_key) $api_key = isset($cfg['ai_mentor_api_key']) ? $cfg['ai_mentor_api_key'] : '';
            if (!$model) $model = isset($cfg['ai_mentor_model']) ? $cfg['ai_mentor_model'] : 'combo';
        }
        if (!$api_key || $api_key === 'PASTE_API_KEY_DISINI') {
            return array('ok' => false, 'content' => '', 'error' => 'no_api_key');
        }

        $payload = array(
            'model' => $model,
            'messages' => array(
                array('role' => 'system', 'content' => 'Kamu adalah asisten rekomendasi mentor yang ringkas, akurat, dan membantu. Selalu menjawab dalam Bahasa Indonesia.'),
                array('role' => 'user', 'content' => $prompt),
            ),
            'temperature' => 0.3,
            'max_tokens' => 800,
        );

        $ch = curl_init($base_url . '/chat/completions');
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $api_key,
                'Content-Type: application/json',
            ),
            CURLOPT_TIMEOUT => 60,
        ));
        $response = curl_exec($ch);
        $err = curl_error($ch);
        $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($err) {
            return array('ok' => false, 'content' => '', 'error' => 'curl: ' . $err);
        }
        $data = json_decode($response, true);
        if ($http !== 200 || !isset($data['choices'][0]['message']['content'])) {
            $msg = isset($data['error']['message']) ? $data['error']['message'] : ('http_' . $http);
            return array('ok' => false, 'content' => '', 'error' => $msg);
        }
        return array('ok' => true, 'content' => $data['choices'][0]['message']['content'], 'error' => null);
    }
}
