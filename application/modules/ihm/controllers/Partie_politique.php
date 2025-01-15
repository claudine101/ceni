<?php

/**
 *NDAYISABA Claudine
 *	CRUD DE TABLE Partie_politique
 **/
class  Partie_politique extends CI_Controller
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
		$data['title'] = 'Liste des partis politiques';
		$this->load->view('partie_politique/Partie_politique_List_View', $data);
	}

	function listing()
	{

		$i = 1;
		$query_principal = 'SELECT * FROM partie_politiques WHERE 1';
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		$limit = 'LIMIT 0,10';

		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';

		$order_column = array('ID_PARTIE_POLITIQUE','DESCRIPTION');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DESCRIPTION DESC';

		$search = !empty($_POST['search']['value']) ? ("AND DESCRIPTION LIKE '%$var_search%'") : '';

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
			data-target='#mydelete" . $row->ID_PARTIE_POLITIQUE  . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Partie_politique/getOne/' . $row->ID_PARTIE_POLITIQUE ) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_PARTIE_POLITIQUE  . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->DESCRIPTION . " </i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Partie_politique/delete/' . $row->ID_PARTIE_POLITIQUE ) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";
			$sub_array = array();
			$u=++$u;
			$source = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
			$sub_array[]=$u;
			$sub_array[] = '<table> <tbody><tr><td><a href="' . $source . '" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->DESIGNATION .'</td></tr></tbody></table></a>';
			$sub_array[] = '<table> <tbody><tr><td>' . $row->TELEPHONE . ' ' . $row->EMAIL . '</td></tr></tbody></table></a>';
			 $sub_array[] = $row->DESCRIPTION;
			 $sub_array[] = $this->get_icon($row->IS_ACTIVE,$row);
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
	  $html = ($statut == 1) ? "<a class='btn btn-success btn-sm' id='".$row->DESCRIPTION."'  title='".$row->DESIGNATION."'  onclick='desactiver(".$row->ID_PARTIE_POLITIQUE .",this.title,this.id)' style='float:right' ><span class = 'fa fa-check'></span></a>" : "<a class = 'btn btn-danger btn-sm' id='".$row->DESCRIPTION."'  title='".$row->DESIGNATION."'  onclick='activer(".$row->ID_PARTIE_POLITIQUE.",this.title,this.id)' style='float:right'><span class = 'fa fa-ban' ></span></a>" ;
	  return $html;
	}
	function activer($id)
    {
          $this->Modele->update('partie_politiques',array('ID_PARTIE_POLITIQUE'=>$id),array('IS_ACTIVE'=>1));
       print_r(json_encode(1));
    }
    function desactiver($id)
    {
          $this->Modele->update('partie_politiques',array('ID_PARTIE_POLITIQUE'=>$id),array('IS_ACTIVE'=>0));
       print_r(json_encode(1));
    }
	function ajouter()
	{
		$data['title'] = 'Nouveau parti politique';
		$this->load->view('partie_politique/Partie_politique_Add_View', $data);
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
		$this->form_validation->set_rules('DESCRIPTION', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('TELEPHONE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('EMAIL', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {
            
			$file = $_FILES['PHOTO'];
			PRINT
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
				'DESCRIPTION' => $this->input->post('DESCRIPTION'),
				'TELEPHONE' => $this->input->post('TELEPHONE'),
				'EMAIL' => $this->input->post('EMAIL'),
				'PHOTO' => $pathfile,
			);
			$table = 'partie_politiques';
			$this->Modele->create($table, $data_insert);
			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Partie_politique/'));
		}
	}

	function getOne($id)
	{
		$data['data'] = $this->Modele->getOne('partie_politiques', array('ID_PARTIE_POLITIQUE ' => $id));
		$data['title'] = 'Modification du parti politique';
		$this->load->view('partie_politique/Partie_politique_Update_View', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('DESCRIPTION', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('TELEPHONE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('EMAIL', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
		$id = $this->input->post('ID_PARTIE_POLITIQUE ');

		if ($this->form_validation->run() == FALSE) {
			$this->getOne($id);
		} else {
			$id = $this->input->post('ID_PARTIE_POLITIQUE');



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


			// $id = $this->input->post('ID_PARTICIPANT');
			if(!empty($_FILES['PHOTO']['name'])) {
				$data = array(
					'DESCRIPTION' => $this->input->post('DESCRIPTION'),
					'TELEPHONE' => $this->input->post('TELEPHONE'),
					'EMAIL' => $this->input->post('EMAIL'),
					'PHOTO' => $pathfile,
				);
			}
			else{
				$data = array(
					'DESCRIPTION' => $this->input->post('DESCRIPTION'),
					'TELEPHONE' => $this->input->post('TELEPHONE'),
					'EMAIL' => $this->input->post('EMAIL'),
					// 'PHOTO' => $pathfile,
				);
			}

			
			
			$this->Modele->update('partie_politiques', array('ID_PARTIE_POLITIQUE ' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du parti politique est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Partie_politique/'));
		}
	}

	function delete()
	{
		$table = "partie_politiques";
		$criteres['ID_PARTIE_POLITIQUE '] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);
		$data['message'] = '<div class="alert alert-success text-center" id="message">L\'element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/Partie_politique/'));
	}
}
