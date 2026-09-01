<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pengecualian CSRF untuk webhook gateway pembayaran.
 *
 * File ini sengaja DIPISAH dari config.php (yang ter-ignore git karena berisi
 * kredensial) supaya perbaikan keamanan ini ikut ter-versioning dan tidak
 * hilang saat repo diklone/deploy ke server lain.
 *
 * Di-load dari application/config/config.php:
 *   $webhook = __DIR__ . '/webhook_csrf.php';
 *   if (file_exists($webhook)) {
 *       $config['csrf_exclude_uris'] = array_merge(
 *           $config['csrf_exclude_uris'],
 *           (array) require $webhook
 *       );
 *   }
 *
 * CATATAN: daftar ini HANYA untuk endpoint server-to-server yang dipanggil
 * oleh gateway (Pakasir/Midtrans) TANPA session login. Jangan menambahkan
 * endpoint user biasa ke sini.
 */
return array(
    // Webhook Pakasir (web + API)
    'checkout/pakasir_webhook',
    'api/checkout/pakasir/webhook',

    // Notifikasi Midtrans (web + API)
    'checkout/midtrans_callback',
    'checkout/midtrans/notification',
    'api/checkout/midtrans/notification',

    // Endpoint AJAX Konsultasi AI (Mentoring) — dipanggil fetch() dari panel student.
    // Aman: controller wajib session logged_in + validasi panjang input; bukan mutasi data.
    'mentoring/ai-recommend',
);
