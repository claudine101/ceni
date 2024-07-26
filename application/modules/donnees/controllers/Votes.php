<?php

/**
 *NDAYISABA Claudine
 *	CRUD DE TABLE Candidats
 **/
class Votes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Votes_model');
    }
    public function submit_vote($id) {
        $candidat = $this->Model->getRequeteOne('SELECT * FROM candidats WHERE  IS_ACTIVE_CANDIDAT=1 AND  ID_CANDIDAT=' . $id . '');
		if (!empty($candidat)) {

				$candidat_id =$this->Modele->encrypt_vote($id);
				$electeur_id = $this->Modele->encrypt_vote($this->session->userdata('ID_UTILISATEUR'));
		
				$data_insert = array(
					'ID_ELECTEUR' => $electeur_id,
					'ID_CANDIDAT' =>  $candidat_id,
				);
				$table = 'votes';
				$this->Modele->create($table, $data_insert);
				print_r(json_encode(1));
		}

    }

    public function view_vote($encrypted_vote) {
        $decrypted_vote = $this->Votes_model->decrypt_vote($encrypted_vote);
        echo 'Vote déchiffré : ' . $decrypted_vote;
    }
}

// application/controllers/Vote.php

// class Votes extends CI_Controller {

//     public function __construct() {
//         parent::__construct();
//         $this->load->model('Vote_model');
//         require_once(APPPATH . '/blockchain/blockchain.php');
//     }

//     public function index() {
//         // Afficher le formulaire de vote
//         $this->load->view('vote_form');
//     }

//     public function submit_vote() {
//         $candidate_id = $this->input->post('candidate_id');
//         $voter_id = $this->input->post('voter_id');

//         // Enregistrement du vote sur la blockchain simulée
//         $blockchain = new Blockchain();
//         $blockchain_success = $blockchain->recordVote($candidate_id, $voter_id);

//         if ($blockchain_success) {
//             // Enregistrement du vote dans la base de données après validation blockchain
//             $vote_id = $this->Vote_model->record_vote($candidate_id, $voter_id);
//             redirect('donnees/Vote/result/' . $vote_id);
//         } else {
//             // Gestion des erreurs si l'enregistrement sur la blockchain échoue
//             echo "Erreur lors de l'enregistrement du vote sur la blockchain.";
//         }
//     }

//     public function result() {
//         // Charger les résultats du vote depuis le modèle
//         $data['vote_count'] = $this->Vote_model->get_vote_count();

//         // Afficher la vue des résultats du vote
//         $this->load->view('vote_result', $data);
//     }

//     // Autres méthodes du contrôleur selon les besoins
// }
?>
