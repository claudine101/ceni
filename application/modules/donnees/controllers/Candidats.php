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
       
		$COLLINE_ID = $this->input->post('COLLINE_ID');
	    $ZONE_ID = $this->input->post('ZONE_ID'); 
		$COMMUNE_ID = $this->input->post('COMMUNE_ID');
	    $PROVINCE_ID = $this->input->post('PROVINCE_ID'); 

		$critere_local = "";

		if(!empty($PROVINCE_ID)){
			$critere_local .="  AND pro.PROVINCE_ID=".$PROVINCE_ID." " ;
		}
		if(!empty($COMMUNE_ID)){
			$critere_local .="  AND co.COMMUNE_ID=".$COMMUNE_ID." ";
			
		}
		if(!empty($ZONE_ID)){
			$critere_local .="  AND zo.ZONE_ID=".$ZONE_ID." ";
			
		}
		if(!empty($COLLINE_ID)){
			$critere_local .= "  AND col.COLLINE_ID=".$COLLINE_ID." ";
			
		}

		$query_principal = 'SELECT col.COLLINE_ID,col.COLLINE_NAME,  zo.ZONE_ID ,zo.ZONE_NAME, co.COMMUNE_ID, co.COMMUNE_NAME,pro.PROVINCE_ID  ,pro.PROVINCE_NAME,ca.* ,po.ID_POSTE,po.DESCRIPTION as poste ,pa.ID_PARTIE_POLITIQUE,pa.DESCRIPTION as parti FROM participants ca JOIN syst_collines col ON  ca.ID_COLLINE=col.COLLINE_ID   JOIN syst_zones zo ON col.ZONE_ID=zo.ZONE_ID  JOIN syst_communes co ON zo.COMMUNE_ID=co.COMMUNE_ID JOIN syst_provinces pro ON
		 pro.PROVINCE_ID=co.PROVINCE_ID JOIN postes po ON po.ID_POSTE=ca.ID_POSTE JOIN partie_politiques pa ON pa.ID_PARTIE_POLITIQUE=ca.ID_PARTIE_POLITIQUE  WHERE  IS_CANDIDAT=1'. $critere_poste . ' '. $critere_parti . ' '.$critere_local;
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		$limit = 'LIMIT 0,10';

		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';
		
		$order_column = array('ID_PARTICIPANT','NOM', 'PRENOM','ADRESE','NUMERO_CNI', 'LIEU_NAISSANCE', 'IS_ACTIVE');

		$order_by = isset($_POST['order']) ? 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NOM DESC';

		$search = !empty($_POST['search']['value']) ? ("AND NOM LIKE '%$var_search%'") : '';

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
			data-target='#mydelete" . $row->ID_PARTICIPANT. "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a  id='".$row->NOM."'  title='".$row->NOM."'  onclick='voter(".$row->ID_PARTICIPANT.",this.title,this.id)' ><font color='green'>&nbsp;&nbsp;Voter</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('donnees/Candidats/getOne/' . $row->ID_PARTICIPANT  ) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_PARTICIPANT. "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->NOM . "   ".$row->PRENOM."</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('donnees/Candidats/delete/' . $row->ID_PARTICIPANT  ) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";
	
			$sub_array = array();
			$u=++$u;
			$source = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
			
			$sub_array[]=$u;
			$sub_array[] = '<table> <tbody><tr><td><a href="' . $source . '" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM . ' ' . $row->PRENOM . '</td></tr></tbody></table></a>';
			$sub_array[] = '<table> <tbody><tr><td>' . $row->TELEPHONE . ' ' . $row->EMAIL . '</td></tr></tbody></table></a>';
            $sub_array[] = $row->NUMERO_CNI;
			$sub_array[] = $this->notifications->ago($row->DATE_NAISSANCE, date('Y-m-d'));
            $sub_array[] = $row->ID_SEXE;
            $sub_array[] = $row->poste;
            $sub_array[] = $row->parti;
			$sub_array[] = $this->get_icon($row->IS_ACTIVE,$row);
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
	  $html = ($statut == 1) ? "<a class='btn btn-success btn-sm' id='".$row->NOM."'  title='".$row->NOM."'  onclick='desactiver(".$row->ID_PARTICIPANT.",this.title,this.id)' style='float:right' ><span class = 'fa fa-check'></span></a>" : "<a class = 'btn btn-danger btn-sm' id='".$row->NOM."'  title='".$row->NOM."'  onclick='activer(".$row->ID_PARTICIPANT.",this.title,this.id)' style='float:right'><span class = 'fa fa-ban' ></span></a>" ;
	  return $html;
	}
	function activer($id)
    {
          $this->Modele->update('participants',array('ID_PARTICIPANT'=>$id),array('IS_ACTIVE'=>1));
       print_r(json_encode(1));
    }
    function desactiver($id)
    {
          $this->Modele->update('participants',array('ID_PARTICIPANT'=>$id),array('IS_ACTIVE'=>0));
       print_r(json_encode(1));
    }
	function voter($id)
    {
          $this->Modele->update('participants',array('ID_PARTICIPANT'=>$id),array('IS_ACTIVE'=>0));
       print_r(json_encode(1));
    }
	function ajouter()
	{
		$data['title'] = 'Nouveau candidat';
        $data['provinces'] = $this->Modele->getRequete('SELECT * FROM syst_provinces WHERE 1 order by PROVINCE_NAME ASC');
        $data['postes'] = $this->Modele->getRequete('SELECT * FROM postes WHERE 1 order by DESCRIPTION ASC');
        $data['partis'] = $this->Modele->getRequete('SELECT * FROM partie_politiques WHERE 1 order by DESCRIPTION ASC');
        $data['sexe'] = $this->Modele->getRequete('SELECT * FROM sexes WHERE 1 order by DESCRIPTION ASC');

		
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
		$this->form_validation->set_rules('NOM', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('PRENOM', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('TELEPHONE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('EMAIL', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('NUMERO_CNI', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('DATE_NAISSANCE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
		$this->form_validation->set_rules('ID_SEXE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_POSTE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_PARTIE_POLITIQUE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_COLLINE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
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
			$data_users = array(
				'USERNAME' => $this->input->post('EMAIL'),
				'PASSWORD' => md5($this->input->post('TELEPHONE')),
				'ID_PROFIL' => 2,
			);
			$tableusers = 'utilisateurs';

			$idUsers = $this->Modele->insert_last_id($tableusers, $data_users);

			$data_insert = array(
				'NOM' => $this->input->post('NOM'),
				'PRENOM' => $this->input->post('PRENOM'),
				'TELEPHONE' => $this->input->post('TELEPHONE'),
				'EMAIL' => $this->input->post('EMAIL'),
				'NUMERO_CNI' => $this->input->post('NUMERO_CNI'),
				'DATE_NAISSANCE' => $this->input->post('DATE_NAISSANCE'),
				'ID_SEXE' => $this->input->post('ID_SEXE'),
				'PHOTO' => $pathfile,
				'ID_POSTE' => $this->input->post('ID_POSTE'),
				'ID_PARTIE_POLITIQUE' => $this->input->post('ID_PARTIE_POLITIQUE'),
				'ID_COLLINE' => $this->input->post('ID_COLLINE'),
				'IS_CANDIDAT'=>1,
				'ID_UTILISATEUR'=>$idUsers
			);
           

			$table = 'Participants';
			$this->Modele->create($table, $data_insert);
			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('donnees/Candidats/'));
		}
	}

	function getOne($id)
	{
		$candidats = $this->Modele->getOne('participants', array('ID_PARTICIPANT' => $id));
		$colline = $this->Modele->getOne('syst_collines', array('COLLINE_ID' =>$candidats['ID_COLLINE']));
		$zone = $this->Modele->getOne('syst_zones', array('ZONE_ID' => $colline['ZONE_ID']));
		$commun = $this->Modele->getOne('syst_communes', array('COMMUNE_ID' => $zone['COMMUNE_ID']));
		$prov = $this->Modele->getOne('syst_provinces', array('PROVINCE_ID' => $commun['PROVINCE_ID']));
		$sexe = $this->Modele->getOne('sexes', array('ID_SEXE' => $candidats['ID_SEXE']));

		
		$data['collines'] = $this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID=' . $colline['ZONE_ID'] . ' ORDER BY COLLINE_NAME ASC');
		$data['zones'] = $this->Model->getRequete('SELECT ZONE_ID,ZONE_NAME FROM syst_zones WHERE COMMUNE_ID=' . $commun['COMMUNE_ID'] . ' ORDER BY ZONE_NAME ASC');
		$data['communes'] = $this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM syst_communes WHERE PROVINCE_ID=' . $prov['PROVINCE_ID'] . ' ORDER BY COMMUNE_NAME ASC');
        $data['provinces'] = $this->Modele->getRequete('SELECT * FROM syst_provinces WHERE 1 order by PROVINCE_NAME ASC');
        $data['provinces'] = $this->Modele->getRequete('SELECT * FROM syst_provinces WHERE 1 order by PROVINCE_NAME ASC');
		$data['postes'] = $this->Modele->getRequete('SELECT * FROM postes WHERE 1 order by DESCRIPTION ASC');
        $data['partis'] = $this->Modele->getRequete('SELECT * FROM partie_politiques WHERE 1 order by DESCRIPTION ASC');
        $data['sexe'] = $this->Modele->getRequete('SELECT * FROM sexes WHERE 1 order by DESCRIPTION ASC');
		
		$data['data'] = $candidats;
		$data['selectColl'] = $colline;
		$data['selectZon'] = $zone;
		$data['selectComm'] = $commun;
		$data['selectProv'] = $prov;
		$data['selectSexe'] = $prov;


		$data['title'] = 'Modification du  candidats';
		$this->load->view('candidats/Candidats_Update_View', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('NOM', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('PRENOM', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('TELEPHONE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('EMAIL', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('NUMERO_CNI', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('DATE_NAISSANCE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
		$this->form_validation->set_rules('ID_SEXE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_POSTE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_PARTIE_POLITIQUE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_COLLINE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
		$id = $this->input->post('ID_PARTICIPANT');
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


			$id = $this->input->post('ID_PARTICIPANT');
			if(!empty($_FILES['PHOTO']['name'])) {
				$data = array(
					'NOM' => $this->input->post('NOM'),
					'PRENOM' => $this->input->post('PRENOM'),
					'TELEPHONE' => $this->input->post('TELEPHONE'),
					'EMAIL' => $this->input->post('EMAIL'),
					'NUMERO_CNI' => $this->input->post('NUMERO_CNI'),
					'DATE_NAISSANCE' => $this->input->post('DATE_NAISSANCE'),
					'ID_SEXE' => $this->input->post('ID_SEXE'),
					'PHOTO' => $pathfile,
					'ID_POSTE' => $this->input->post('ID_POSTE'),
					'ID_PARTIE_POLITIQUE' => $this->input->post('ID_PARTIE_POLITIQUE'),
					'ID_COLLINE' => $this->input->post('ID_COLLINE'),
				);
			}
			else{
				$data = array(
					'NOM' => $this->input->post('NOM'),
					'PRENOM' => $this->input->post('PRENOM'),
					'TELEPHONE' => $this->input->post('TELEPHONE'),
					'EMAIL' => $this->input->post('EMAIL'),
					'NUMERO_CNI' => $this->input->post('NUMERO_CNI'),
					'DATE_NAISSANCE' => $this->input->post('DATE_NAISSANCE'),
					'ID_SEXE' => $this->input->post('ID_SEXE'),
					'ID_POSTE' => $this->input->post('ID_POSTE'),
					'ID_PARTIE_POLITIQUE' => $this->input->post('ID_PARTIE_POLITIQUE'),
					'ID_COLLINE' => $this->input->post('ID_COLLINE'),
				);
			}
			
			$this->Modele->update('participants', array('ID_PARTICIPANT' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification de la candidature a été effectuée avec succès.</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('donnees/Candidats/'));
		}
	}

	function delete()
	{
		$table = "participants";
		$table_votes = "votes";
		$table_users = "utilisateurs";
		$users = $this->Modele->getOne('participants', array('ID_PARTICIPANT' => $this->uri->segment(4)));
		
		$criteres['ID_PARTICIPANT'] = $this->uri->segment(4);
		$criteres_votes['ID_CANDIDAT'] = $this->uri->segment(4);
		$criteres_user['ID_UTILISATEUR'] = $users['ID_UTILISATEUR'];

		$data['rows'] = $this->Modele->getOne($table, $criteres);

		$this->Modele->delete($table, $criteres);
		$this->Modele->delete($table_votes, $criteres_votes);
		$this->Modele->delete($table_users, $criteres_user);

		$data['message'] = '<div class="alert alert-success text-center" id="message">L\'element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('donnees/Candidats/'));
	}
	public function submit_votes($id) {
        
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
/**
     * Enregistrer un vote.
     */
    public function submit_vote($id) {
        $id_candidat = $id;
        $id_utilisateur = $this->session->userdata('ID_UTILISATEUR');

        if ($this->Modele->enregistrer_vote($id_utilisateur, $id_candidat)) {
            $this->session->set_flashdata('message', 'Votre vote a été enregistré avec succès.');
        } else {
            $this->session->set_flashdata('error', 'Erreur lors de l\'enregistrement du vote.');
        }
        redirect('votes/resultats');
    }

	/**
     * Affiche les résultats des votes valides avec le nombre de votes par candidat.
     */
    public function resultats() {
        $data['votes_valides'] = $this->Modele->compter_votes_valides();
        $this->load->view('resultats_view', $data);
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
        $candidates = $this->Modele->get_alles();
        $blocks = $this->Blockchain_model->get_all_blocks();
        $votes = $this->count_votes_from_blocks($blocks);

        // Initialisation des votes pour chaque candidat
        foreach ($candidates as &$candidate) {
            $candidate['votes'] = 0;
        }
        // Comptage des votes
        foreach ($votes as $candidate_id => $vote_count) {
            foreach ($candidates as &$candidate) {
                if ($candidate['ID_PARTICIPANT'] == $candidate_id) {
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
