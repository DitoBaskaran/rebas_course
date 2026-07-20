<?php defined('BASEPATH') OR exit('No direct script allowed');

/**
 * OAuth Helper — Google OAuth 2.0 Authentication
 */

function google_login_url() {
    $client_id = setting('google_client_id', '');
    if (empty($client_id)) return '';

    $redirect_uri = base_url('auth/google_callback');
    $scopes = implode(' ', ['openid', 'email', 'profile']);

    $params = http_build_query(array(
        'client_id'     => $client_id,
        'redirect_uri'  => $redirect_uri,
        'response_type' => 'code',
        'scope'         => $scopes,
        'access_type'   => 'online',
        'prompt'        => 'select_account',
    ));

    return 'https://accounts.google.com/o/oauth2/v2/auth?' . $params;
}

function google_exchange_code($code) {
    $ci =& get_instance();
    $client_id     = setting('google_client_id', '');
    $client_secret = setting('google_client_secret', '');
    $redirect_uri  = base_url('auth/google_callback');

    if (empty($client_id) || empty($client_secret)) return false;

    $data = array(
        'code'          => $code,
        'client_id'     => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri'  => $redirect_uri,
        'grant_type'    => 'authorization_code',
    );

    $ch = curl_init('https://oauth2.googleapis.com/token');
    curl_setopt_array($ch, array(
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query($data),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_TIMEOUT        => 30,
    ));
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200) return false;

    $result = json_decode($response, true);
    return isset($result['access_token']) ? $result['access_token'] : false;
}

function google_get_user_info($access_token) {
    $ch = curl_init('https://www.googleapis.com/oauth2/v2/userinfo');
    curl_setopt_array($ch, array(
        CURLOPT_HTTPHEADER     => array('Authorization: Bearer ' . $access_token),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_TIMEOUT        => 30,
    ));
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200) return false;

    $data = json_decode($response, true);
    if (empty($data['email'])) return false;

    return array(
        'google_id' => $data['id'] ?? '',
        'email'     => $data['email'] ?? '',
        'name'      => $data['name'] ?? '',
        'avatar'    => $data['picture'] ?? '',
    );
}
