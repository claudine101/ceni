<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EAS {
    private $encryption_key;
    private $mac_key;

    public function __construct() {
        $CI =& get_instance();
        $this->encryption_key = $CI->config->item('encryption_key');
        $this->mac_key = $CI->config->item('mac_key');

        if (!$this->encryption_key || !$this->mac_key) {
            throw new Exception("Les clés de chiffrement et MAC doivent être configurées dans config.php.");
        }
    }

    public function encrypt($data) {
        $cipher = "AES-256-CBC";
        $iv = random_bytes(openssl_cipher_iv_length($cipher));
        $encrypted_data = openssl_encrypt($data, $cipher, hex2bin($this->encryption_key), 0, $iv);
        $hmac = hash_hmac('sha256', $encrypted_data, hex2bin($this->mac_key));
        return base64_encode($iv . $hmac . $encrypted_data);
    }

    public function decrypt($data) {
        $cipher = "AES-256-CBC";
        $decoded = base64_decode($data);
        $iv_length = openssl_cipher_iv_length($cipher);
        $iv = substr($decoded, 0, $iv_length);
        $hmac = substr($decoded, $iv_length, 64); // HMAC (256 bits = 64 hex chars)
        $encrypted_data = substr($decoded, $iv_length + 64);

        $calculated_hmac = hash_hmac('sha256', $encrypted_data, hex2bin($this->mac_key));
        if (!hash_equals($hmac, $calculated_hmac)) {
            throw new Exception("HMAC non valide. Les données ont été altérées.");
        }

        return openssl_decrypt($encrypted_data, $cipher, hex2bin($this->encryption_key), 0, $iv);
    }
}
