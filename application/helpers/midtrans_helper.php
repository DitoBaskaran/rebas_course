<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function get_midtrans_token($order_id, $amount, $item_name, $customer, $server_key, $is_production = false) {
    $base_url = $is_production
        ? 'https://app.midtrans.com/snap/v1/transactions'
        : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

    $payload = array(
        'transaction_details' => array(
            'order_id' => 'CRS-' . $order_id . '-' . time(),
            'gross_amount' => (int)$amount,
        ),
        'credit_card' => array(
            'secure' => true,
        ),
        'customer_details' => array(
            'first_name' => $customer['first_name'],
            'email' => $customer['email'],
        ),
        'item_details' => array(
            array(
                'id' => $order_id,
                'price' => (int)$amount,
                'quantity' => 1,
                'name' => $item_name,
            ),
        ),
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $base_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Basic ' . base64_encode($server_key . ':'),
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code === 201) {
        $result = json_decode($response, true);
        return $result['token'] ?? '';
    }

    return '';
}
