<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ai_course — rekomendasi kursus via AI (Hermes gateway, OpenAI-compatible).
 * Siswa ceritakan tujuan belajar → AI pilih kursus BISATUNTAS paling cocok + alasan.
 */
class Ai_course {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    /** Ambil daftar kursus published dari DB + kategori, format ringkas utk prompt. */
    public function build_course_catalog() {
        $this->CI->db->select('courses.*, categories.name as category_name')
            ->from('courses')
            ->join('categories', 'categories.id = courses.category_id', 'left')
            ->where('courses.status', 'published')
            ->order_by('courses.featured', 'DESC')
            ->order_by('courses.created_at', 'DESC');
        $courses = $this->CI->db->get()->result();

        $catalog = array();
        $lvl_map = array('beginner' => 'Pemula', 'intermediate' => 'Menengah', 'advanced' => 'Mahir', 'all_levels' => 'Semua Level');
        foreach ($courses as $c) {
            $catalog[] = array(
                'id' => $c->id,
                'title' => $c->title,
                'type' => $c->content_type,
                'category' => $c->category_name,
                'level' => isset($lvl_map[$c->skill_level]) ? $lvl_map[$c->skill_level] : $c->skill_level,
                'price' => (float) $c->price,
                'description' => $c->description,
            );
        }
        return $catalog;
    }

    /**
     * Minta rekomendasi kursus dari AI.
     * Return array('ok'=>bool, 'course_ids'=>int[], 'explanation'=>string, 'error'=>string|null).
     */
    public function recommend($user_goal, $user_name = '') {
        $catalog = $this->build_course_catalog();
        if (empty($catalog)) {
            return array('ok' => false, 'course_ids' => array(), 'explanation' => '', 'error' => 'no_courses');
        }

        $course_list = array();
        foreach ($catalog as $c) {
            $course_list[] = "ID {$c['id']}: {$c['title']} [{$c['type']}] (Kategori: {$c['category']}, Level: {$c['level']}, Harga: Rp " . number_format($c['price'], 0, ',', '.') . "). Deskripsi: {$c['description']}";
        }
        $site = 'BISATUNTAS';
        $prompt = "Kamu adalah konselor edukasi yang ramah dan profesional di platform {$site}. "
            . "Seorang siswa menyampaikan tujuan belajarnya:\n\n"
            . "\"{$user_goal}\"\n\n"
            . "Berikut daftar kursus yang tersedia:\n" . implode("\n", $course_list) . "\n\n"
            . "Tugasmu: rekomendasikan 1-3 kursus PALING COCOK untuk mencapai tujuan siswa tsb. "
            . "Jawab dalam Bahasa Indonesia, format JSON saja, tanpa teks lain:\n"
            . "{\"course_ids\": [id_kursus], \"reason\": \"penjelasan 2-3 kalimat mengapa kursus ini cocok\"}\n"
            . "Pilih hanya dari ID yang tersedia.\n\n"
            . "ATURAN PENTING:\n"
            . "1. Jika input siswa TIDAK JELAS / terlalu umum / hanya sapaan (mis. 'halo', 'tes', 'bantuan', '??'), "
            . "maka course_ids KOSONG dan reason berisi respons ramah yang meminta siswa menyebutkan tujuan belajarnya lebih spesifik, "
            . "sambil menyebutkan contoh topik yang tersedia (mis. web development, data science, desain, video editing, musik, IELTS).\n"
            . "2. Jika input siswa DI LUAR LINGKUP layanan BISATUNTAS (bukan pendidikan/keterampilan, mis. tanya cuaca, harga barang, resep masakan, hal ilegal), "
            . "maka course_ids KOSONG dan reason berisi respons SOPAN: jelaskan bahwa BISATUNTAS fokus pada kursus & pembelajaran keterampilan, "
            . "lalu ajak siswa menyebutkan skill yang ingin dipelajari.\n"
            . "3. Selalu tetap sopan, empatik, dan tidak menghakimi, apapun inputnya.\n"
            . "4. Jangan pernah berasumsi kursus yang tidak ada di daftar.";

        $result = $this->call_ai($prompt);
        if (!$result['ok']) {
            return array('ok' => false, 'course_ids' => array(), 'explanation' => '', 'error' => $result['error']);
        }

        $content = trim($result['content']);
        if (preg_match('/```(?:json)?\s*(\{.*?\})\s*```/s', $content, $m)) {
            $content = $m[1];
        }
        $data = json_decode($content, true);
        if (!is_array($data)) {
            preg_match('/\{.*\}/s', $content, $m2);
            if (!empty($m2)) {
                $data = json_decode($m2[0], true);
            }
        }
        if (!is_array($data)) {
            return array('ok' => false, 'course_ids' => array(), 'explanation' => $content, 'error' => 'parse_failed');
        }

        $ids = isset($data['course_ids']) ? (array) $data['course_ids'] : array();
        $ids = array_filter(array_map('intval', $ids));
        $valid_ids = array();
        foreach ($catalog as $c) {
            $valid_ids[] = $c['id'];
        }
        $ids = array_values(array_intersect($ids, $valid_ids));
        $ids = array_slice($ids, 0, 3);

        return array(
            'ok' => true,
            'course_ids' => $ids,
            'explanation' => isset($data['reason']) ? $data['reason'] : '',
            'error' => null,
        );
    }

    /**
     * Panggil endpoint AI (OpenAI-compatible). Konfigurasi dari application/config/ai_mentor.php
     * (dipakai bersama library Ai_mentor — gateway sama).
     */
    protected function call_ai($prompt) {
        $base_url = getenv('AI_MENTOR_BASE_URL');
        $api_key = getenv('HERMES_CUSTOM_127_0_0_1_20128_API_KEY');
        $model = getenv('AI_MENTOR_MODEL');

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
                array('role' => 'system', 'content' => 'Kamu adalah asisten rekomendasi kursus yang ringkas, akurat, dan membantu. Selalu menjawab dalam Bahasa Indonesia.'),
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
