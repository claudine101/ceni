<?php

/**
 *NDAYISABA Claudine
 *	CRUD DE TABLE Session_vote
 **/
class  Session_vote extends CI_Controller
{
	function __construct()
	{

		parent::__construct();
		$this->have_droit();
	}

	public function have_droit()
	{
		//  if ($this->session->userdata('PARAMETRE') != 1) {

        //        redirect(base_url());
        //   }
	}

	function index()
	{
		$data['title'] = 'Liste des Sessions de vote';
		$this->load->view('session_vote/Session_vote_List_View', $data);
	}

	function listing()
	{

		$i = 1;
		$query_principal = 'SELECT s.*,p.DESCRIPTION  FROM session_votes s JOIN  postes p ON p.ID_POSTE=s.ID_POSTE WHERE 1';
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		$limit = 'LIMIT 0,10';

		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';

		$order_column = array('ID_SESSIN_VOTE ','DESCRIPTION','DATE_DEBUT','DATE_FIN','IS_CURRENT');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_DEBUT DESC';

		$search = !empty($_POST['search']['value']) ? ("AND DATE_DEBUT LIKE '%$var_search%'") : '';

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
			data-target='#mydelete" . $row->ID_SESSIN_VOTE. "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/session_vote/getOne/' . $row->ID_SESSIN_VOTE) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_SESSIN_VOTE. "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->DATE_DEBUT . " </i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/session_vote/delete/' . $row->ID_SESSIN_VOTE) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";
			$sub_array = array();
			$u=++$u;
			$sub_array[]=$u;
			$sub_array[] = $row->DESCRIPTION;
			$sub_array[] = $row->DATE_DEBUT;
			$sub_array[] = $row->DATE_FIN;
			$sub_array[] = ($row->IS_CURRENT==1 )?'En cours':(($row->IS_CURRENT==2)? 'Termine':'En attente');

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

	function ajouter()
	{
		$data['title'] = 'Nouvelle session';
        $data['postes'] = $this->Modele->getRequete('SELECT * FROM postes WHERE 1 order by DESCRIPTION ASC');
		$this->load->view('session_vote/Session_vote_Add_View', $data);
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
		$this->form_validation->set_rules('ID_POSTE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('DATE_DEBUT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('DATE_FIN', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {
          
			$poste = $this->Model->getRequeteOne('SELECT * FROM session_votes WHERE  ID_POSTE="' . $this->input->post('ID_POSTE') . '"');

			$message = "";
			if (!empty($poste)) {
				$datas['message'] = '<div class="alert alert-success text-center" id="message">Ce poste est déjà planifié. Veuillez planifier un autre poste.</div>';
			 $this->session->set_flashdata($datas);
			$this->ajouter();
			}
			else{

			$data_insert = array(
				'DATE_DEBUT' => $this->input->post('DATE_DEBUT'),
				'ID_POSTE' => $this->input->post('ID_POSTE'),
				'DATE_FIN' => $this->input->post('DATE_FIN'),
			);
			$table = 'session_votes';
			$this->Modele->create($table, $data_insert);
			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/session_vote/'));
		}
	}
}

	function getOne($id)
	{
		$data['data'] = $this->Modele->getOne('session_votes', array('ID_SESSIN_VOTE' => $id));
		$data['postes'] = $this->Modele->getRequete('SELECT * FROM postes WHERE 1 order by DESCRIPTION ASC');

		$data['title'] = 'Modification du session de vote';
		$this->load->view('session_vote/Session_vote_Update_View', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('ID_POSTE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('DATE_DEBUT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('DATE_FIN', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
		$id = $this->input->post('ID_SESSIN_VOTE');

		if ($this->form_validation->run() == FALSE) {
			$this->getOne($id);
		} else {
			$id = $this->input->post('ID_SESSIN_VOTE ');

			$data = array(
				'DATE_DEBUT' => $this->input->post('DATE_DEBUT'),
				'ID_POSTE' => $this->input->post('ID_POSTE'),
				'DATE_FIN' => $this->input->post('DATE_FIN')
			);
			$this->Modele->update('session_votes', array('ID_SESSIN_VOTE' =>  $this->input->post('ID_SESSIN_VOTE')), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du parti politique est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/session_vote/'));
		}
	}

	function delete()
	{
		$table = "session_votes";
		$criteres['ID_SESSIN_VOTE'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);
		$data['message'] = '<div class="alert alert-success text-center" id="message">L\'element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/session_vote/'));
	}
}
