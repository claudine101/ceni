<?php 
/**
 * christa
 * crud de marque de voiture
 */
class Moyen_payement extends CI_Controller
{
	
	function __construct()
	{
		# code...
		parent::__construct();
	}

	function index()
	{
		$data['title'] = 'Moyens de payement';
		$this->load->view('Moyen_payement_List_View',$data);
	}
	function listing()
	{
		$query_principal='SELECT MOYEN_PAYEMENT_ID,MOYEN_PAYEMENT FROM `deux_moyen_payement` WHERE 1';


		$var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit='LIMIT 0,10';


		if($_POST['length'] != -1){
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}
		$order_by='';



		$order_column=array('MOYEN_PAYEMENT_ID','MOYEN_PAYEMENT');

		$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY MOYEN_PAYEMENT ASC';

		$search = !empty($_POST['search']['value']) ? (" AND MOYEN_PAYEMENT LIKE '%$var_search%' ") : '';     

		$critaire = '';

		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
		$query_filter = $query_principal.' '.$critaire.' '.$search;


		$fetch_moyen_payement = $this->Modele->datatable($query_secondaire);
		$data = array();
		foreach ($fetch_moyen_payement as $row) {

			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->MOYEN_PAYEMENT_ID . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Moyen_payement/getOne/'.$row->MOYEN_PAYEMENT_ID) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->MOYEN_PAYEMENT_ID. "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" .$row->MOYEN_PAYEMENT."</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Moyen_payement/delete/'.$row->MOYEN_PAYEMENT_ID) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			$sub_array[]=$row->MOYEN_PAYEMENT;  
			$sub_array[]=$option;   


			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST['draw']),
			"recordsTotal" =>$this->Modele->all_data($query_principal),
			"recordsFiltered" => $this->Modele->filtrer($query_filter),
			"data" => $data
		);
		echo json_encode($output);
	}

	function ajouter()
	{
		$data['title'] = 'Nouveau moyen de payement';
		$this->load->view('Moyen_payement_Add_View',$data);
	}
	function add()
	{
		$this->form_validation->set_rules('MOYEN_PAYEMENT','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		if($this->form_validation->run() == FALSE)
		{
			$this->ajouter();
		}else{

			$data_insert=array(
							'MOYEN_PAYEMENT'=>$this->input->post('MOYEN_PAYEMENT')
			                  );

			$table='deux_moyen_payement';
			$this->Modele->create('deux_moyen_payement',$data_insert);

			$data['message']='<div class="alert alert-success text-center" id="message">'."L'enregistrement de nouveau moyen de payement <b>".' '.$this->input->post('MOYEN_PAYEMENT').'</b> '." est fait avec succès".'</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Moyen_payement/'));

		}

	}

	function getOne()
	{
		$id=$this->uri->segment(4);
		$data['Moyenpayement']=$this->Modele->getOne('deux_moyen_payement',array('MOYEN_PAYEMENT_ID'=>$id));

		$data['title'] = 'Modification - Moyen de payement';
		$this->load->view('Moyen_payement_Update_View',$data);		
	}

	function update()
	{
		$this->form_validation->set_rules('MOYEN_PAYEMENT','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		if ($this->form_validation->run() == FALSE) {
			# code...
			$this->getOne();
		}else{
			$id=$this->input->post('MOYEN_PAYEMENT_ID');

			$data=array('MOYEN_PAYEMENT'=>$this->input->post('MOYEN_PAYEMENT'),);

			$this->Modele->update('deux_moyen_payement',array('MOYEN_PAYEMENT_ID'=>$id),$data);
			$datas['message']='<div class="alert alert-success text-center" id="message">La modification de moyen de payement '.$this->input->post('MOYEN_PAYEMENT').'</b> est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Moyen_payement/'));
		}

	}

	function delete()
	{
		$table="deux_moyen_payement";
		$criteres['MOYEN_PAYEMENT_ID']=$this->uri->segment(4);
		$data['rows']= $this->Modele->getOne( $table,$criteres);
		$this->Modele->delete($table,$criteres);

		$data['message']='<div class="alert alert-success text-center" id="message">Le moyen de payement '."".$data['rows']['DESCRIOTION'].' </b> '." est supprimé avec succès".'</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/Moyen_payement/'));

	}
}
 ?>