<?php

/**
 *NDAYISABA Claudine
 *	CRUD DE TABLE Candidats
 **/
class  Candidats extends CI_Controller
{
	function __construct()
	{

		parent::__construct();
		$this->have_droit();
		$this->load->model('Blockchain_model');
		$this->load->model('Modele');

	}

	public function have_droit()
	{
		//  if ($this->session->userdata('PARAMETRE') != 1) {

        //        redirect(base_url());
        //   }
	}

	function index()
	{
		$data['title'] = 'Liste des candidats';
        $data['provinces'] = $this->Modele->getRequete('SELECT * FROM syst_provinces WHERE 1 order by PROVINCE_NAME ASC');
        $data['postes'] = $this->Modele->getRequete('SELECT * FROM postes WHERE 1 order by DESCRIPTION ASC');
        $data['parti'] = $this->Modele->getRequete('SELECT * FROM partie_politiques WHERE 1 order by DESCRIPTION ASC');

		$this->load->view('candidats/Candidats_List_View', $data);
	}

	function listing()
	{

		$i = 1;
		$ID_POSTE = $this->input->post('ID_POSTE');
	    $ID_PARTIE_POLITIQUE = $this->input->post('ID_PARTIE_POLITIQUE'); 

		$critere_poste = "";
	    $critere_parti = "";

        $critere_poste = !empty($ID_POSTE) ? "  AND po.ID_POSTE=".$ID_POSTE." ":"";
        $critere_parti = !empty($ID_PARTIE_POLITIQUE) ? "  AND pa.ID_PARTIE_POLITIQUE=".$ID_PARTIE_POLITIQUE." ":"";
       
		$query_principal = 'SELECT col.COLLINE_ID,col.COLLINE_NAME,  zo.ZONE_ID ,zo.ZONE_NAME, co.COMMUNE_ID, co.COMMUNE_NAME,pro.PROVINCE_ID  ,pro.PROVINCE_NAME,ca.* ,po.ID_POSTE,po.DESCRIPTION as poste ,pa.ID_PARTIE_POLITIQUE,pa.DESCRIPTION as parti FROM candidats ca JOIN syst_collines col ON  ca.ID_COLLINE_CANDIDAT=col.COLLINE_ID   JOIN syst_zones zo ON col.ZONE_ID=zo.ZONE_ID  JOIN syst_communes co ON zo.COMMUNE_ID=co.COMMUNE_ID JOIN syst_provinces pro ON
		 pro.PROVINCE_ID=co.PROVINCE_ID JOIN postes po ON po.ID_POSTE=ca.ID_POSTE JOIN partie_politiques pa ON pa.ID_PARTIE_POLITIQUE=ca.ID_PARTIE_POLITIQUE  WHERE 1'. $critere_poste . ' '. $critere_parti . ' ';
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		$limit = 'LIMIT 0,10';

		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';
		
		$order_column = array('ID_CANDIDAT','NOM_CANDIDAT', 'PRENOM_CANDIDAT','ADRESE_CANDIDAT','NUMERO_CNI_CANDIDAT', 'LIEU_NAISSANCE_CANDIDAT', 'IS_ACTIVE_CANDIDAT');

		$order_by = isset($_POST['order']) ? 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NOM_CANDIDAT DESC';

		$search = !empty($_POST['search']['value']) ? ("AND NOM_CANDIDAT LIKE '%$var_search%'") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . ' ' . $limit;
		$query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

		$fetch_infraction = $this->Modele->datatable($query_secondaire);
		$data = array();
		$u=0;
		foreach ($fetch_infraction as $row) {
			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_CANDIDAT   . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a  id='".$row->NOM_CANDIDAT."'  title='".$row->NOM_CANDIDAT."'  onclick='voter(".$row->ID_CANDIDAT.",this.title,this.id)' ><font color='green'>&nbsp;&nbsp;Voter</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('donnees/Candidats/getOne/' . $row->ID_CANDIDAT  ) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_CANDIDAT   . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->NOM_CANDIDAT . "   ".$row->PRENOM_CANDIDAT."</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('donnees/Candidats/delete/' . $row->ID_CANDIDAT  ) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";
	
			$sub_array = array();
			$u=++$u;
			$source = !empty($row->PHOTO_CANDIDAT) ? $row->PHOTO_CANDIDAT : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
			
			$sub_array[]=$u;
			$sub_array[] = '<table> <tbody><tr><td><a href="' . $source . '" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM_CANDIDAT . ' ' . $row->PRENOM_CANDIDAT . '</td></tr></tbody></table></a>';
			$sub_array[] = '<table> <tbody><tr><td>' . $row->TELEPHONE_CANDIDAT . ' ' . $row->EMAIL_CANDIDAT . '</td></tr></tbody></table></a>';
            $sub_array[] = $row->NUMERO_CNI_CANDIDAT;
			$sub_array[] = $this->notifications->ago($row->DATE_NAISSANCE_CANDIDAT, date('Y-m-d'));
            $sub_array[] = $row->SEXE_CANDIDAT;
            $sub_array[] = $row->poste;
            $sub_array[] = $row->parti;
			$sub_array[] = $this->get_icon($row->IS_ACTIVE_CANDIDAT,$row);
			$sub_array[] = $row->COLLINE_NAME.'-'.$row->ZONE_NAME.'-'.$row->COMMUNE_NAME.'-'.$row->PROVINCE_NAME;
			$sub_array[] = $option;
			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST['draw']),
			"recordsTotal" => $this->Modele->all_data($query_principal),
			"recordsFiltered" => $this->Modele->filtrer($query_filter),
			"data" => $data
		);
		echo json_encode($output);
	}
	function get_icon($statut, $row)
	{
	  $html = ($statut == 1) ? "<a class='btn btn-success btn-sm' id='".$row->NOM_CANDIDAT."'  title='".$row->NOM_CANDIDAT."'  onclick='desactiver(".$row->ID_CANDIDAT.",this.title,this.id)' style='float:right' ><span class = 'fa fa-check'></span></a>" : "<a class = 'btn btn-danger btn-sm' id='".$row->NOM_CANDIDAT."'  title='".$row->NOM_CANDIDAT."'  onclick='activer(".$row->ID_CANDIDAT.",this.title,this.id)' style='float:right'><span class = 'fa fa-ban' ></span></a>" ;
	  return $html;
	}
	function activer($id)
    {
          $this->Modele->update('candidats',array('ID_CANDIDAT'=>$id),array('IS_ACTIVE_CANDIDAT'=>1));
       print_r(json_encode(1));
    }
    function desactiver($id)
    {
          $this->Modele->update('candidats',array('ID_CANDIDAT'=>$id),array('IS_ACTIVE_CANDIDAT'=>0));
       print_r(json_encode(1));
    }
	function voter($id)
    {
          $this->Modele->update('candidats',array('ID_CANDIDAT'=>$id),array('IS_ACTIVE_CANDIDAT'=>0));
       print_r(json_encode(1));
    }
	function ajouter()
	{
		$data['title'] = 'Nouveau candidat';
        $data['provinces'] = $this->Modele->getRequete('SELECT * FROM syst_provinces WHERE 1 order by PROVINCE_NAME ASC');
        $data['postes'] = $this->Modele->getRequete('SELECT * FROM postes WHERE 1 order by DESCRIPTION ASC');
        $data['partis'] = $this->Modele->getRequete('SELECT * FROM partie_politiques WHERE 1 order by DESCRIPTION ASC');
		
		$this->load->view('candidats/Candidats_Add_View', $data);
	}
	function validate_name($name)
     {
               if (preg_match('/"/',$name)) {
                 $this->form_validation->set_message("validate_name","Le champ contient des caractères non valides");
                return FALSE;
               }
               else{
                    return TRUE;
               } 
     }
	function add()
	{
		$this->form_validation->set_rules('NOM_CANDIDAT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('PRENOM_CANDIDAT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('TELEPHONE_CANDIDAT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('EMAIL_CANDIDAT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('NUMERO_CNI_CANDIDAT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('DATE_NAISSANCE_CANDIDAT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
		$this->form_validation->set_rules('SEXE_CANDIDAT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_POSTE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_PARTIE_POLITIQUE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_COLLINE_CANDIDAT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
        if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {

			
			$file = $_FILES['PHOTO'];
			$path = './uploads/Candidats/';
			if (!is_dir(FCPATH . '/uploads/Candidats/')) {
				mkdir(FCPATH . '/uploads/Candidats/', 0777, TRUE);
			}

			$thepath = base_url() . 'uploads/Candidats/';
			$config['upload_path'] = './uploads/Candidats/';
			$photonames = date('ymdHisa');
			$config['file_name'] = $photonames;
			$config['allowed_types'] = '*';
			$this->upload->initialize($config);
			$this->upload->do_upload("PHOTO");
			$info = $this->upload->data();

			if ($file == '') {
				$pathfile = base_url() . 'uploads/sevtb.png';
			} else {
				$pathfile = base_url() . '/uploads/Candidats/' . $photonames . $info['file_ext'];
			}


			$camerasImage = $this->input->post('ImageLink');

			if (!empty($camerasImage)) {

				$dir = FCPATH.'/uploads/cameraImageCeni/';
			      if (!is_dir(FCPATH . '/uploads/cameraImageCeni/')) {
				  mkdir(FCPATH . '/uploads/cameraImageCeni/', 0777, TRUE);
			    }

                $photonames = date('ymdHisa');
                $pathfile = base_url() . 'uploads/cameraImageCeni/' . $photonames .".png";
			    $pathfiless = FCPATH . '/uploads/cameraImageCeni/' . $photonames .".png";
			    $file_name = $photonames .".png";

			    $img = $this->input->post('ImageLink'); // Your data 'data:image/png;base64,AAAFBfj42Pj4';
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                file_put_contents($pathfiless, $data);

				//echo "<img src='".$path."' >";
				
			}

			$data_insert = array(
				'NOM_CANDIDAT' => $this->input->post('NOM_CANDIDAT'),
				'PRENOM_CANDIDAT' => $this->input->post('PRENOM_CANDIDAT'),
				'TELEPHONE_CANDIDAT' => $this->input->post('TELEPHONE_CANDIDAT'),
				'EMAIL_CANDIDAT' => $this->input->post('EMAIL_CANDIDAT'),
				'NUMERO_CNI_CANDIDAT' => $this->input->post('NUMERO_CNI_CANDIDAT'),
				'DATE_NAISSANCE_CANDIDAT' => $this->input->post('DATE_NAISSANCE_CANDIDAT'),
				'SEXE_CANDIDAT' => $this->input->post('SEXE_CANDIDAT'),
				'PHOTO_CANDIDAT' => $pathfile,
				'ID_POSTE' => $this->input->post('ID_POSTE'),
				'ID_PARTIE_POLITIQUE' => $this->input->post('ID_PARTIE_POLITIQUE'),
				'ID_COLLINE_CANDIDAT' => $this->input->post('ID_COLLINE_CANDIDAT'),
			);
			$table = 'candidats';
			$this->Modele->create($table, $data_insert);
			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('donnees/Candidats/'));
		}
	}

	function getOne($id)
	{
		$candidats = $this->Modele->getOne('candidats', array('ID_CANDIDAT ' => $id));
		$colline = $this->Modele->getOne('syst_collines', array('COLLINE_ID' =>$candidats['ID_COLLINE_CANDIDAT']));
		$zone = $this->Modele->getOne('syst_zones', array('ZONE_ID' => $colline['ZONE_ID']));
		$commun = $this->Modele->getOne('syst_communes', array('COMMUNE_ID' => $zone['COMMUNE_ID']));
		$prov = $this->Modele->getOne('syst_provinces', array('PROVINCE_ID' => $commun['PROVINCE_ID']));
		
		$data['collines'] = $this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID=' . $colline['ZONE_ID'] . ' ORDER BY COLLINE_NAME ASC');
		$data['zones'] = $this->Model->getRequete('SELECT ZONE_ID,ZONE_NAME FROM syst_zones WHERE COMMUNE_ID=' . $commun['COMMUNE_ID'] . ' ORDER BY ZONE_NAME ASC');
		$data['communes'] = $this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM syst_communes WHERE PROVINCE_ID=' . $prov['PROVINCE_ID'] . ' ORDER BY COMMUNE_NAME ASC');
        $data['provinces'] = $this->Modele->getRequete('SELECT * FROM syst_provinces WHERE 1 order by PROVINCE_NAME ASC');
        $data['provinces'] = $this->Modele->getRequete('SELECT * FROM syst_provinces WHERE 1 order by PROVINCE_NAME ASC');
		$data['postes'] = $this->Modele->getRequete('SELECT * FROM postes WHERE 1 order by DESCRIPTION ASC');
        $data['partis'] = $this->Modele->getRequete('SELECT * FROM partie_politiques WHERE 1 order by DESCRIPTION ASC');
		
		$data['data'] = $candidats;
		$data['selectColl'] = $colline;
		$data['selectZon'] = $zone;
		$data['selectComm'] = $commun;
		$data['selectProv'] = $prov;

		$data['title'] = 'Modification du  candidats';
		$this->load->view('candidats/Candidats_Update_View', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('NOM_CANDIDAT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('PRENOM_CANDIDAT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('TELEPHONE_CANDIDAT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('EMAIL_CANDIDAT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('NUMERO_CNI_CANDIDAT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('DATE_NAISSANCE_CANDIDAT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
		$this->form_validation->set_rules('SEXE_CANDIDAT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_POSTE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_PARTIE_POLITIQUE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_COLLINE_CANDIDAT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
		$id = $this->input->post('ID_CANDIDAT');
//  print $id
//  exit();
		if ($this->form_validation->run() == FALSE) {
			$this->getOne($id);
		} else {

			
			$file = $_FILES['PHOTO'];
			$path = './uploads/Candidats/';
			if (!is_dir(FCPATH . '/uploads/Candidats/')) {
				mkdir(FCPATH . '/uploads/Candidats/', 0777, TRUE);
			}

			$thepath = base_url() . 'uploads/Candidats/';
			$config['upload_path'] = './uploads/Candidats/';
			$photonames = date('ymdHisa');
			$config['file_name'] = $photonames;
			$config['allowed_types'] = '*';
			$this->upload->initialize($config);
			$this->upload->do_upload("PHOTO");
			$info = $this->upload->data();

			if ($file == '') {
				$pathfile = base_url() . 'uploads/sevtb.png';
			} else {
				$pathfile = base_url() . '/uploads/Candidats/' . $photonames . $info['file_ext'];
			}


			$id = $this->input->post('ID_CANDIDAT');
			if(!empty($_FILES['PHOTO']['name'])) {
				$data = array(
					'NOM_CANDIDAT' => $this->input->post('NOM_CANDIDAT'),
					'PRENOM_CANDIDAT' => $this->input->post('PRENOM_CANDIDAT'),
					'TELEPHONE_CANDIDAT' => $this->input->post('TELEPHONE_CANDIDAT'),
					'EMAIL_CANDIDAT' => $this->input->post('EMAIL_CANDIDAT'),
					'NUMERO_CNI_CANDIDAT' => $this->input->post('NUMERO_CNI_CANDIDAT'),
					'DATE_NAISSANCE_CANDIDAT' => $this->input->post('DATE_NAISSANCE_CANDIDAT'),
					'SEXE_CANDIDAT' => $this->input->post('SEXE_CANDIDAT'),
					'PHOTO_CANDIDAT' => $pathfile,
					'ID_POSTE' => $this->input->post('ID_POSTE'),
					'ID_PARTIE_POLITIQUE' => $this->input->post('ID_PARTIE_POLITIQUE'),
					'ID_COLLINE_CANDIDAT' => $this->input->post('ID_COLLINE_CANDIDAT'),
				);
			}
			else{
				$data = array(
					'NOM_CANDIDAT' => $this->input->post('NOM_CANDIDAT'),
					'PRENOM_CANDIDAT' => $this->input->post('PRENOM_CANDIDAT'),
					'TELEPHONE_CANDIDAT' => $this->input->post('TELEPHONE_CANDIDAT'),
					'EMAIL_CANDIDAT' => $this->input->post('EMAIL_CANDIDAT'),
					'NUMERO_CNI_CANDIDAT' => $this->input->post('NUMERO_CNI_CANDIDAT'),
					'DATE_NAISSANCE_CANDIDAT' => $this->input->post('DATE_NAISSANCE_CANDIDAT'),
					'SEXE_CANDIDAT' => $this->input->post('SEXE_CANDIDAT'),
					'ID_POSTE' => $this->input->post('ID_POSTE'),
					'ID_PARTIE_POLITIQUE' => $this->input->post('ID_PARTIE_POLITIQUE'),
					'ID_COLLINE_CANDIDAT' => $this->input->post('ID_COLLINE_CANDIDAT'),
				);
			}
			
			$this->Modele->update('candidats', array('ID_CANDIDAT' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification de la candidature a été effectuée avec succès.</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('donnees/Candidats/'));
		}
	}

	function delete()
	{
		$table = "candidats";
		$criteres['ID_CANDIDAT'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);
		$data['message'] = '<div class="alert alert-success text-center" id="message">L\'element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('donnees/Candidats/'));
	}
	//Fonction utiliser  pour  voter
	public function submit_votDDe($id) {
        $candidat_id =$this->Modele->encrypt_vote($id);
        $electeur_id = $this->Modele->encrypt_vote($this->session->userdata('ID_UTILISATEUR'));
 
        $data_insert = array(
            'ID_ELECTEUR' => $electeur_id,
            'ID_CANDIDAT' =>  $candidat_id,
        );
        $table = 'votes';
        $this->Modele->create($table, $data_insert);
		print_r(json_encode(1));
        // $data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
        // $this->session->set_flashdata($data);
        // redirect(base_url('donnees/Candidats/'));

    }



	public function submit_vote($id) {
        
            $candidate_id = $id;
            $voter_id = $this->session->userdata('ID_UTILISATEUR');

			$data_insert = array(
				'ID_ELECTEUR' => $voter_id,
				'ID_CANDIDAT' =>  $candidate_id,
			);
			$table = 'votes';
			// $this->Modele->create($table, $data_insert);

            if ($this->Modele->create($table, $data_insert)) {
                $this->add_vote_to_blockchain($candidate_id, $voter_id);
                echo "Vote cast successfully!";
            } else {
                echo "Error casting vote or you have already voted!";
            }
    }


	private function add_vote_to_blockchain($candidate_id, $voter_id) {
        $last_block = $this->Blockchain_model->get_last_block();
        $previous_hash = $last_block ? $last_block['HASH'] : '0';

        $transaction = ['candidate_id' => $candidate_id, 'voter_id' => $voter_id, 'timestamp' => time()];
        $transactions = [$transaction];

        $this->Blockchain_model->create_block($previous_hash, $transactions);
    }
	public function results() {
        // Valider la chaîne de blocs avant de récupérer les résultats
        $is_chain_valid = $this->Blockchain_model->validate_chain();
        if (!$is_chain_valid) {
            echo "La chaîne de blocs est invalide!";
            return;
        }
        $candidates = $this->Modele->get_all_candidates();
        $blocks = $this->Blockchain_model->get_all_blocks();
        $votes = $this->count_votes_from_blocks($blocks);

        // Initialisation des votes pour chaque candidat
        foreach ($candidates as &$candidate) {
            $candidate['votes'] = 0;
        }
        // Comptage des votes
        foreach ($votes as $candidate_id => $vote_count) {
            foreach ($candidates as &$candidate) {
                if ($candidate['ID_CANDIDAT'] == $candidate_id) {
                    $candidate['votes'] = $vote_count;
                }
            }
        }
        $data['candidates'] = $candidates;
        $this->load->view('candidats/results', $data);
    }

    private function count_votes_from_blocks($blocks) {
        $votes = [];

        foreach ($blocks as $block) {
            $transactions = json_decode($block['TRANSACTIONS'], true);

            foreach ($transactions as $transaction) {
                $candidate_id = $transaction['candidate_id'];

                if (!isset($votes[$candidate_id])) {
                    $votes[$candidate_id] = 0;
                }

                $votes[$candidate_id]++;
            }
        }

        return $votes;
    }

    // private function count_votes_from_blocks($blocks) {
    //     $votes = [];

    //     foreach ($blocks as $block) {
    //         $transactions = json_decode($block['TRANSACTIONS'], true);

    //         foreach ($transactions as $transaction) {
    //             $candidate_id = $transaction['candidate_id'];

    //             if (!isset($votes[$candidate_id])) {
    //                 $votes[$candidate_id] = 0;
    //             }

    //             $votes[$candidate_id]++;
    //         }
    //     }

    //     return $votes;
    // }
}
