<?php

class Amende_percu_journe extends CI_Controller
{

  function index()
  {
    
  	$Chaussee=$this->Modele->getRequete("SELECT ID_HISTORIQUE as ID,DATE_FORMAT(hs.DATE_INSERTION, '%d-%m-%Y') AS DATE_VERIFIF,SUM(MONTANT) as total,user.NOM_UTILISATEUR  FROM historiques hs LEFT JOIN utilisateurs user on user.ID_UTILISATEUR=hs.ID_UTILISATEUR WHERE 1 GROUP BY hs.ID_UTILISATEUR");

  	$nombre=0;
  	$donne="";



  	foreach ($Chaussee as $value) 
  	{
  	   $nombre=$nombre+$value['total'];
  	   $name= (!empty($value['NOM_UTILISATEUR'])) ? $value['NOM_UTILISATEUR']: "Aucun";
  	   $nb= (!empty($value['total'])) ? $value['total']: "0";



  	   $key_id=($value['ID']>0) ? $value['ID'] : "0" ;
  	   $donne.="{name:'".str_replace("'","\'",$name)."', y:".$nb.",key:".$key_id."},";
  	}
  
  	
  	$data['title']="Rapport sur les amendes  par policien";
  	$data['donne']=$donne;
  	$data['nombre']=$nombre;

    
    $data=$this->load->view('amande_par_journe_v',$data);

   }


   function detailChausse()
   {
   	
   $KEY=$this->input->post('key');

   $gravite=$this->input->post('gravite');

   $condition='';
   if(!empty($gravite)) {
      $condition .=  ' and a.ID_GRAVITE="'.$gravite.'"';
    }


   	$break=explode(".", $KEY);
   	$ID=$KEY;

   	$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

   	$query_principal=('SELECT c.NOM_CHAUSSE,`PLAQUE`,If(VALIDATION=1,"valide","invalide") as VALIDATION, a.DESCRIPTION , c.NOM_CHAUSSE,a.LONGITUDE, a.LATITUDE, `DATE_INSERTION`,g.DESCRIPTION as GRAVITE FROM sign_accident a JOIN chaussee c on a.ID_CHAUSSEE=c.ID_CHAUSSEE join type_gravite g on g.ID_TYPE_GRAVITE=a.ID_GRAVITE WHERE 1 '.$condition.'  and c.ID_CHAUSSEE='.$ID);


   	$limit='LIMIT 0,10';
   	 if($_POST['length'] != -1)
  {
  $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
  }

  $order_by='';

    if($_POST['order']['0']['column']!=0)
 {
  $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY PLAQUE  DESC';
 }
   
  $search = !empty($_POST['search']['value']) ? (" AND (PLAQUE LIKE '%$var_search%' OR  DATE LIKE '%$var_search%'  ) ") : '';

  $query_secondaire=$query_principal.' '.$search.' '.$order_by.'   '.$limit;
  $query_filter=$query_principal.' '.$search;


  $fetch_data = $this->Modele->datatable($query_secondaire);
  $u=0;
  $data = array();
  foreach ($fetch_data as $row)
  {

  $u++;
  $intrant=array();
  $intrant[] = $u;
  $intrant[] =$row->NOM_CHAUSSE;
  $intrant[] =$row->PLAQUE;
  $intrant[] =$row->GRAVITE;
  $intrant[] =$row->VALIDATION;
  $intrant[] =$row->DESCRIPTION;
  $intrant[] =$row->DATE_INSERTION;

  $data[] = $intrant;

 } 

  $output = array(
  "draw" => intval($_POST['draw']),
  "recordsTotal" =>$this->Modele->all_data($query_principal),
  "recordsFiltered" => $this->Modele->filtrer($query_filter),
  "data" => $data
 );

 echo json_encode($output);

 } 

 }
 ?>
