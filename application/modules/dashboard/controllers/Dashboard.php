<?php

if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Dashboard extends MY_Controller
{	

	function __construct() 
	{
		parent::__construct();
	}
	
	function index()
	{
		
      //   $id= $this->session->userdata('memberid');
      //   //POUR LE 1ER NIVEAU
      //   $db1=$this->Model->readRequeteOne("SELECT COUNT(id_membre_tier1)  AS tie1 from tier1 WHERE id_water_source= ".$id);

                        
      //   $niv1=0;
      //   if(empty($db1))
      //   {
      //     $niv1=0;
      //   }
      //   else
      //   {
      //     $niv1=$db1['tie1'];

      //    }
      //    //POUR LE 2 NIVEAU
      //   $db2=$this->Model->readRequeteOne("SELECT COUNT(id_membre_tier2)  AS tie2 from tier2 WHERE id_water_source= ".$id);

      //   $niv2=0;
      //   if(empty($db2))
      //   {
      //     $niv2=0;
      //   }
      //   else
      //   {
      //     $niv2=$db2['tie2'];
      //    }
      //    //POUR LE 3 NIVEAU
      //    $db3=$this->Model->readRequeteOne("SELECT COUNT(id_membre_tier3)  AS tie3 from tier3 WHERE id_water_source= ".$id);
      //    $niv3=0;
      //   if(empty($db3))
      //   {
      //     $niv3=0;
      //   }
      //   else
      //   {
      //     $niv3=$db3['tie3'];
      //   }
      //   //POUR GIFTS RECU 
      //   $db4=$this->Model->readRequeteOne("SELECT COUNT(id_membre_receveur)  AS proof from proof_paiement WHERE id_membre_receveur=".$id);
      //   $recu=0;
      //   if(empty($db4))
      //   {
      //     $recu=0;
      //   }
      //   else
      //   {
      //     $recu=$db4['proof'];
      //   }
      //   //POUR VERIFICATION DU COMPTE
      //   $db5=$this->Model->readRequeteOne("SELECT  * from membre WHERE id_membre=".$id);
      //   $veri=0;
      //   if($db5['tele_membre']==null)
      //   {
      //     $veri=0;  
      //   }
      //   else
      //   {
      //    $veri=50;
         
      //    if($db5['facebook_url']!=null)
      //     {
      //       $veri=$veri+10;
      //     }
      //   if($db5['telegram_url']!=null)
      //   {
      //       $veri=$veri+10;
      

      //     }
      //   if($db5['photo_membre']!=null)
      //   {
      //       $veri=$veri+20;
      

      //     }
      //   if($db5['id_mode_paiement']!=0)
      //     {
      //       $veri=$veri+10;
      //     }
      //    }
      //    //POUR MODE DE PAYEMENT PREFERE
      //    $db6=$this->Model->readRequeteOne("SELECT *   from membre WHERE id_membre=".$id);
      //   $db6['id_mode_paiement'];
      //  if($db6['id_mode_paiement']==0)
      //   {
      //     $paye="0";
      //   }
      //   else
      //   {
      //    $paye="100";
      //    }
      //    //POUR GRAINE
      //    $db7=$this->Model->readRequeteOne("SELECT  * from proof_paiement WHERE id_membre_donateur=".$id);
      //   $graine=0;
      //   if(empty($db7))
      //   {
      //     $graine=0;
           
      //   }
      //   else
      //   {
      //     $graine=100;
            
      //   }
      //   //POUR GIFTS RECU ET RECOLTE
      //   $db8=$this->Model->readRequeteOne("SELECT  count(id_membre_receveur) AS receveur from proof_paiement WHERE id_membre_receveur=".$id);
      //   $recolte=0;
      //   if(empty($db8))
      //   {
      //     $recolte=0;
           
      //   }
      //   else
      //   {
      //     $recolte=$db8['receveur'];
            
      //   }
      //   //POUR DON CARITATIF
      //   $data=$this->Model->readRequeteOne("SELECT * from donation WHERE id_membre=".$id);
        
      //    if(empty($data))
      //   {
      //     $don=0;
           
      //   }
      //   else
      //   {
      //     $don=100;
            
      //   }
      //   $data_don="progress-bar bg-secondary w-". $don;
        

      //    $data_recolte="progress-bar bg-info w-".$recolte;
      //    $data_graine="progress-bar bg-info w-".$graine;
      //    $data_payement="progress-bar bg-pink w-".$paye;            
      //    $data_veri="progress-bar bg-primary w-".$veri;
      //    $data_bar1="progress-bar bg-primary w-".( $niv1*100)/2;
      //    $data_bar2="progress-bar bg-warning w-".( $niv2*100)/4;
      //    $data_bar3="progress-bar bg-danger w-".( $niv3*100)/8;
         
      //    $data = array('niveau1' =>$niv1,'niveau2' =>$niv2,'niveau3' =>$niv3,'data_bar1'=>$data_bar1,'data_bar2'=>$data_bar2,'data_bar3'=>$data_bar3,'recu'=>$recu,'verification'=>$veri,'data_veri'=>$data_veri,'payement'=>$paye,'data_payement'=>$data_payement,'graine'=>$graine,'data_graine'=>$data_graine,'recolte'=>$recolte,'data_recolte'=>$data_recolte,'don'=>$don,'data_don'=>$data_don);
      $votes=$this->Modele->getRequete('SELECT v.DATE_VOTE,
    c.ID_CANDIDAT, 
    c.NOM_CANDIDAT , 
    COALESCE(COUNT(v.ID_VOTE), 0) AS nbre_vote
FROM 
    candidats c
LEFT JOIN 
    votes v ON c.ID_CANDIDAT = v.ID_CANDIDAT
GROUP BY 
    c.ID_CANDIDAT, c.NOM_CANDIDAT
ORDER BY 
    nbre_vote DESC;');
  
      $nombre=0;
      
      $donnees="";
      $nombre1=0;
      
      $donnees1="";

 //$categorie1='';
 foreach ($votes as  $value) {
  
  $nombre=$nombre+$value['nbre_vote'];
  
 
  $name=(!empty($value['NOM_CANDIDAT']))? $value['NOM_CANDIDAT']:'aucun enregistrement';
  $nbre=(!empty($value['nbre_vote']))? $value['nbre_vote']:'0';




  $donnees.="{name:'".str_replace("'","\'",$name)."', y:".$nbre."},";
 }

 foreach ($votes as  $value) {
  
  $nombre1=$nombre1+$value['nbre_vote'];
  
 
  $name=(!empty($value['DATE_VOTE']))? $value['DATE_VOTE']:'aucun enregistrement';
  $nbre=(!empty($value['nbre_vote']))? $value['nbre_vote']:'0';

     $key_id=($value['DATE_VOTE']>0) ? $value['DATE_VOTE'] : "0" ;


  $donnees1.="{name:'".str_replace("'","\'",$name)."', y:".$nbre.",key:'".$key_id."'},";
 }


    
    $data['title']='Statut des Officiers connectés ';
    $data['donnees']=$donnees;
    $data['nom']=$nombre;
    $data['donnees1']=$donnees1;
    $data['nom1']=$nombre1;
    $data['votes']=$votes;
    // $data['name']=$name;


// $this->load->view('User_Policier_View',$data);
      $this->load->view('dashboard/Dashboard_View', $data);

	}

	function Profile()
	{
		$this->load->view('admin/Profile_View');
	}

	function Active_network()
	{
		$this->load->view('admin/Active_Network_View');
	}

	function Waiting_list()
	{
		$this->load->view('admin/Waiting_List_View');
	}

	function Seed()
	{
		$this->load->view('admin/Seed_View');
	}
	function donation()
	{
		$this->load->view('admin/Donnation_View');
	}
	function recolte()
	{
		$this->load->view('admin/Recolte_View');
	}



}

