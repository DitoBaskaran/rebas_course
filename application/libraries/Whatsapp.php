<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Whatsapp — wrapper tipis untuk WhatsApp Gateway whatsbas (wa.ditobaskaran.my.id)
 * Config diambil dari tabel settings (group 'whatsapp'), diedit lewat admin/settings/whatsapp.
 */
class Whatsapp {

    protected $CI;
    protected $base_url = 'https://wa.ditobaskaran.my.id/api.php';

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('Setting_model');
    }

    protected function api_key() {
        return $this->CI->Setting_model->get('wa_api_key');
    }

    protected function device_id() {
        return $this->CI->Setting_model->get('wa_device_id');
    }

    public function enabled() {
        return $this->api_key() && $this->device_id() && $this->CI->Setting_model->get('wa_enabled') === '1';
    }

    /** Rapikan nomor ke format internasional 62xxxx tanpa + */
    public function normalize_phone($phone) {
        $phone = preg_replace('/[^0-9]/', '', (string) $phone);
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        } elseif (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }
        return $phone;
    }

    /**
     * Kirim pesan teks LANGSUNG ke gateway (dipakai HANYA oleh worker antrian).
     * Jangan panggil ini dari alur request web — pakai enqueue() supaya tidak spam.
     */
    public function send_text_now($to, $text) {
        if (!$this->enabled()) {
            return array('ok' => false, 'error' => 'whatsapp_disabled');
        }
        $to = $this->normalize_phone($to);
        $url = $this->base_url . '?action=send-text&device_id=' . urlencode($this->device_id());

        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => json_encode(array('to' => $to, 'text' => $text)),
            CURLOPT_HTTPHEADER => array(
                'X-API-Key: ' . $this->api_key(),
                'Content-Type: application/json',
            ),
            CURLOPT_TIMEOUT => 15,
        ));
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            log_message('error', 'Whatsapp::send_text_now curl error: ' . $err);
            return array('ok' => false, 'error' => $err);
        }
        $data = json_decode($response, TRUE);
        if (!is_array($data) || empty($data['ok'])) {
            $msg = is_array($data) && isset($data['error']) ? $data['error'] : 'unknown_error';
            log_message('error', 'Whatsapp::send_text_now failed: ' . $msg . ' | to=' . $to);
            return array('ok' => false, 'error' => $msg);
        }
        return array('ok' => true, 'error' => null);
    }

    /**
     * Masukkan pesan ke antrian (dikirim worker dengan jeda 30 detik/pesan agar tidak dianggap spam).
     * Return array('ok' => bool, 'error' => string|null) — ok berarti berhasil MASUK antrian, bukan terkirim.
     */
    public function send_text($to, $text) {
        if (!$this->enabled()) {
            return array('ok' => false, 'error' => 'whatsapp_disabled');
        }
        $to = $this->normalize_phone($to);
        $this->CI->db->insert('wa_message_queue', array(
            'phone' => $to,
            'message' => $text,
        ));
        return array('ok' => true, 'error' => null);
    }
}
