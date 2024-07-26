<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Signature_model extends CI_Model {

    private $private_key;
    private $public_key;

    public function __construct() {
        parent::__construct();
        $this->private_key = file_get_contents('C:\Users\Msc Ir claudine/private_key.pem');
        $this->public_key = file_get_contents('C:\Users\Msc Ir claudine/public_key.pem');
    }

    public function sign_vote($vote_data) {
        openssl_sign($vote_data, $signature, $this->private_key, OPENSSL_ALGO_SHA256);
        return base64_encode($signature);
    }

    public function verify_vote($vote_data, $signature) {
        $signature = base64_decode($signature);
        $result = openssl_verify($vote_data, $signature, $this->public_key, OPENSSL_ALGO_SHA256);
        return $result === 1;
    }
}
