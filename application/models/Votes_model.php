<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Votes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('encryption');
    }

    public function encrypt_vote($vote_data) {
        $encrypted_vote = $this->encryption->encrypt($vote_data);
        return $encrypted_vote;
    }

    public function decrypt_vote($encrypted_vote) {
        $decrypted_vote = $this->encryption->decrypt($encrypted_vote);
        return $decrypted_vote;
    }
}


// application/models/Vote_model.php
// class Vote_model extends CI_Model {

//     private $privateKey;
//     private $publicKey;

//     public function __construct() {
//         parent::__construct();
//         $this->load->database();

//         // Génération de clés RSA pour la signature numérique
//         $config = array(
//             "config" => "C:/wamp64/bin/apache/apache2.4.46/conf/openssl.cnf",
//             "digest_alg" => "sha256",
//             "private_key_bits" => 2048,
//             "private_key_type" => OPENSSL_KEYTYPE_RSA,
//         );
//         $res = openssl_pkey_new($config);
//         openssl_pkey_export($res, $this->privateKey);
//         $this->publicKey = openssl_pkey_get_details($res)["key"];
//     }

//     public function record_vote($candidate_id, $voter_id) {
//         // Chiffrement des données du vote
//         $data_to_encrypt = $candidate_id . '|' . $voter_id;
//         $private_key_file='C:\Users\Msc Ir claudine/private_key.pem';
//         // Charger la clé privée depuis le fichier
//         $encryption_key = openssl_pkey_get_private(file_get_contents($private_key_file));
//         print_r($encryption_key);
//         // exit();
//         // $this->public_key = file_get_contents('C:\Users\Msc Ir claudine/public_key.pem');
//         // $encryption_key = 'your_secret_key'; // Utilisez une clé de chiffrement sécurisée

//         $iv = openssl_random_pseudo_bytes(16); // Générer un IV aléatoire de 16 octets
//         $encrypted_data = openssl_encrypt($data_to_encrypt, 'aes-256-cbc', $encryption_key, 0,  $iv);

//         // Signature numérique
//         // openssl_sign($encrypted_data, $signature, $this->privateKey, OPENSSL_ALGO_SHA256);
//         if (!openssl_sign($encrypted_data, $signature, $this->privateKey, OPENSSL_ALGO_SHA256)) {
//             throw new Exception('Erreur lors de la signature des données');
//         }

//         // Enregistrement du vote chiffré et signé dans la base de données
//         $data = array(
//             'encrypted_vote' => $encrypted_data,
//             'signature' => base64_encode($signature),
//             'timestamp' => date('Y-m-d H:i:s')
//         );
//         $this->db->insert('votes', $data);
//         return $this->db->insert_id();
//     }

//     public function get_vote_count() {
//         return $this->db->count_all_results('votes');
//     }
//     public function encrypt_vote($vote_data) {
//         $encrypted_vote = $this->encryption->encrypt($vote_data);
//         return $encrypted_vote;
//     }
    // Autres méthodes de modèle selon les besoins
// }
?>

