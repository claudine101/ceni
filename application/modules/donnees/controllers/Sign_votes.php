<?php

/**
 *NDAYISABA Claudine
 *	CRUD DE TABLE Candidats
 **/

 // application/controllers/Vote.php
class Sign_votes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Signature_model');
    }

    public function submit_vote() {
        $vote_data = 'candidat_id:123, poste_id:456';
        $signature = $this->Signature_model->sign_vote($vote_data);

        // Enregistrer le vote et la signature dans la base de données
        // ...

        echo 'Signature : ' . $signature;
    }

    public function verify_vote($vote_data, $signature) {
        $is_valid = $this->Signature_model->verify_vote($vote_data, $signature);
        echo 'Signature valide : ' . ($is_valid ? 'Oui' : 'Non');
    }
}