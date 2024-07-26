// application/blockchain/blockchain.php
<?php

class Blockchain {

    private $blockchainFile; // Fichier pour simuler la blockchain

    public function __construct() {
        // Emplacement du fichier blockchain (vous pouvez ajuster le chemin selon vos besoins)
        $this->blockchainFile = APPPATH . 'blockchain/blockchain.txt';

        // Vérifiez si le fichier existe, sinon créez-le
        if (!file_exists($this->blockchainFile)) {
            $handle = fopen($this->blockchainFile, 'w') or die("Impossible de créer le fichier blockchain.txt");
            fclose($handle);
        }
    }

    public function recordVote($candidate_id, $voter_id) {
        // Génération d'un hash pour simuler une transaction blockchain
        $transaction = json_encode([
            'candidate_id' => $candidate_id,
            'voter_id' => $voter_id,
            'timestamp' => date('Y-m-d H:i:s')
        ]);

        $previousHash = $this->getPreviousHash();
        $currentHash = hash('sha256', $transaction . $previousHash);

        $block = [
            'index' => $this->getBlockCount() + 1,
            'timestamp' => date('Y-m-d H:i:s'),
            'transaction' => $transaction,
            'previous_hash' => $previousHash,
            'hash' => $currentHash
        ];

        $result = file_put_contents($this->blockchainFile, json_encode($block) . PHP_EOL, FILE_APPEND);

        return $result !== false;
    }

    private function getPreviousHash() {
        $lines = file($this->blockchainFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (empty($lines)) {
            return '0'; // Valeur par défaut pour le premier block
        } else {
            $lastLine = end($lines);
            $lastBlock = json_decode($lastLine, true);
            return $lastBlock['hash'];
        }
    }

    private function getBlockCount() {
        $lines = file($this->blockchainFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        return count($lines);
    }

    // Méthode pour afficher la blockchain pour vérification
    public function getBlockchain() {
        $lines = file($this->blockchainFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        return array_map(function($line) {
            return json_decode($line, true);
        }, $lines);
    }
}
?>
