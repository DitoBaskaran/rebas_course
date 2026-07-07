<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pakasir
{
    private $api_base = 'https://app.pakasir.com/api';
    private $slug;
    private $api_key;
    private $sandbox;

    public function __construct()
    {
        $CI =& get_instance();
        $CI->load->helper('settings');
        $this->slug = setting('pakasir_slug', '');
        $this->api_key = setting('pakasir_api_key', '');
        $this->sandbox = setting('pakasir_sandbox', '1') === '1';
    }

    public function is_configured()
    {
        return !empty($this->slug) && !empty($this->api_key);
    }

    public function create_transaction($method, $order_id, $amount)
    {
        $url = $this->api_base . '/transactioncreate/' . $method;

        $payload = array(
            'project'  => $this->slug,
            'order_id' => $order_id,
            'amount'   => (int) $amount,
            'api_key'  => $this->api_key,
        );

        $response = $this->_post($url, $payload);
        return json_decode($response, true);
    }

    public function get_transaction_detail($order_id, $amount)
    {
        $url = $this->api_base . '/transactiondetail?' . http_build_query(array(
            'project'  => $this->slug,
            'order_id' => $order_id,
            'amount'   => (int) $amount,
            'api_key'  => $this->api_key,
        ));

        $response = $this->_get($url);
        return json_decode($response, true);
    }

    public function cancel_transaction($order_id, $amount)
    {
        $url = $this->api_base . '/transactioncancel';

        $payload = array(
            'project'  => $this->slug,
            'order_id' => $order_id,
            'amount'   => (int) $amount,
            'api_key'  => $this->api_key,
        );

        $response = $this->_post($url, $payload);
        return json_decode($response, true);
    }

    public function simulate_payment($order_id, $amount)
    {
        if (!$this->sandbox) {
            return array('error' => 'Sandbox mode is disabled');
        }

        $url = $this->api_base . '/paymentsimulation';

        $payload = array(
            'project'  => $this->slug,
            'order_id' => $order_id,
            'amount'   => (int) $amount,
            'api_key'  => $this->api_key,
        );

        $response = $this->_post($url, $payload);
        return json_decode($response, true);
    }

    private function _post($url, $payload)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_HTTPHEADER     => array(
                'Content-Type: application/json',
            ),
            CURLOPT_TIMEOUT        => 30,
        ));

        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            log_message('error', 'Pakasir POST error: ' . $error);
            return json_encode(array('error' => $error));
        }

        return $result;
    }

    private function _get($url)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPGET        => true,
            CURLOPT_TIMEOUT        => 30,
        ));

        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            log_message('error', 'Pakasir GET error: ' . $error);
            return json_encode(array('error' => $error));
        }

        return $result;
    }
}
