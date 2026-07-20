<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * JWT Library - Manual Implementation
 * Simple JWT implementation for API authentication
 */
class Jwt_library {
    
    private $secret_key;
    private $algorithm = 'HS256';
    
    public function __construct() {
        $this->CI =& get_instance();
        $this->secret_key = $this->CI->config->item('encryption_key') ?: 'your-secret-key-change-this-in-production';
    }
    
    /**
     * Generate JWT Token
     */
    public function encode($payload) {
        $header = [
            'typ' => 'JWT',
            'alg' => $this->algorithm
        ];
        
        // Add issued at and expiration
        $payload['iat'] = time();
        $payload['exp'] = time() + (24 * 60 * 60); // 24 hours
        
        $base64Header = $this->base64UrlEncode(json_encode($header));
        $base64Payload = $this->base64UrlEncode(json_encode($payload));
        
        $signature = hash_hmac('sha256', $base64Header . '.' . $base64Payload, $this->secret_key, true);
        $base64Signature = $this->base64UrlEncode($signature);
        
        return $base64Header . '.' . $base64Payload . '.' . $base64Signature;
    }
    
    /**
     * Decode JWT Token
     */
    public function decode($token) {
        $parts = explode('.', $token);
        
        if (count($parts) !== 3) {
            return false;
        }
        
        list($base64Header, $base64Payload, $base64Signature) = $parts;
        
        // Verify signature
        $signature = $this->base64UrlDecode($base64Signature);
        $expectedSignature = hash_hmac('sha256', $base64Header . '.' . $base64Payload, $this->secret_key, true);
        
        if (!hash_equals($signature, $expectedSignature)) {
            return false;
        }
        
        $payload = json_decode($this->base64UrlDecode($base64Payload), true);
        
        // Check expiration
        if (isset($payload['exp']) && time() >= $payload['exp']) {
            return false;
        }
        
        return $payload;
    }
    
    /**
     * Base64 URL Encode
     */
    private function base64UrlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    /**
     * Base64 URL Decode
     */
    private function base64UrlDecode($data) {
        return base64_decode(strtr($data, '-_', '+/'));
    }
}
