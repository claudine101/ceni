<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Blockchain_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create_block($previous_hash, $transactions) {
        $date = new DateTime();
        $currentDate = $date->format('Y-m-d H:i:s');
        $index = $this->db->count_all('blocks') + 1;
        $block = [
            'INDEXE' => $index,
            'DATE_INSERTION' => $currentDate,
            'TRANSACTIONS' => json_encode($transactions),
            'PREVIOUS_HASH' => $previous_hash,
            'HASH' => $this->calculate_hash($index, $previous_hash, $transactions, $currentDate)
        ];
        $this->db->insert('blocks', $block);
        return $block;
    }
    
    private function calculate_hash($index, $previous_hash, $transactions, $timestamp) {
        $data = $index . $previous_hash . json_encode($transactions) . $timestamp;
        return hash('sha256', $data);
    }
    

    public function get_last_block() {
        $this->db->order_by('ID_BLOCK', 'DESC');
        $query = $this->db->get('blocks', 1);
        return $query->row_array();
    }
    public function get_all_blocks() {
        $query = $this->db->get('blocks');
        return $query->result_array();
    }

     // Valide la chaîne de blocs en vérifiant les hash et previous_hash
     public function validate_chain() {
        $blocks = $this->get_all_blocks();
        $previous_block = null;
    
        foreach ($blocks as $block) {
            if ($previous_block !== null) {
                // Vérification du previous_hash
                if ($block['PREVIOUS_HASH'] !== $previous_block['HASH']) {
                    return false; // La chaîne est invalide
                }
    
                // Vérification du hash du bloc
                $calculated_hash = $this->calculate_hash(
                    $block['INDEXE'],
                    $block['PREVIOUS_HASH'],
                    json_decode($block['TRANSACTIONS']),
                    $block['DATE_INSERTION']
                );
                if ($calculated_hash !== $block['HASH']) {
                    return false; // La chaîne est invalide
                }
            }
            $previous_block = $block;
        }
    
        return true; // La chaîne est valide
    }
    
}
