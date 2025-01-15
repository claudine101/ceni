<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }
  public function index($params = NULL)
  {
     $postes=$this->Model->getRequete('SELECT P.ID_POSTE,P.DESCRIPTION FROM postes p JOIN session_votes s ON s.ID_POSTE=p.ID_POSTE WHERE s.IS_CURRENT=0');   

     $data['postes']=$postes;
    $this->load->view('Home_View.php',$data);
  }
  public function rapport($params = NULL)
  {
    
    $this->load->view('Home_V.php');
  }
  public function check_newVote(){ 

    $lastCheck = $this->input->post('lastCheck');
    
    if ($lastCheck) {
        // Convertir la date en format MySQL
// Retirer la partie entre parenthèses qui cause des problèmes
$lastCheck = preg_replace('/\s*\(.*?\)\s*/', '', $lastCheck);

// Créer un objet DateTime à partir de la chaîne
$dateTime = new DateTime($lastCheck);
$formattedDate = $dateTime->format('Y-m-d H:i:s');
         $nbre=$this->Model->getRequeteOne("SELECT COUNT(*) as count FROM votes WHERE DATE_VOTE > '".$formattedDate."'");
        echo json_encode(['newVotes' => $nbre['count'] > 0]);
    } else {
        echo json_encode(['newVotes' => false]);
    }

  }
  public function get_rapport(){ 

    $CANDIDAT=$this->input->post('CANDIDAT');
    $ELECTEUR=$this->input->post('ELECTEUR');
    $ID_POSTE=$this->input->post('ID_POSTE');
    $poste="";
    $postes="";
    if (!empty($ID_POSTE)){
    $poste.="  AND  p.ID_POSTE=".$ID_POSTE;
    $postes.="  AND  ss.ID_POSTE=".$ID_POSTE;
        
    }
        $search='';
        if (!empty($CANDIDAT)) {
        $search=' and h.CANDIDAT like "%'.$CANDIDAT.'%"'; 
        }
        $plaque='';

        if (!empty($ELECTEUR)) {
        $plaque=' and h.ELECTEUR like "%'.$ELECTEUR.'%"'; 
        }
        $sessionVote = $this->Model->getRequeteOne('SELECT * FROM session_votes WHERE  IS_CURRENT=1');


// pj

$statParticipant=$this->Model->getRequete("SELECT p.ID_PARTICIPANT,COUNT(p.ID_PARTICIPANT) AS tout, 
(SELECT COUNT(p.ID_PARTICIPANT)  FROM participants p  WHERE p.ID_PARTICIPANT NOT IN (SELECT v.ID_UTILISATEUR FROM votes v JOIN session_votes ss ON v.ID_SESSIN_VOTE=ss.ID_SESSIN_VOTE WHERE 1  ".$postes.")  ) as nonVote, 
(SELECT COUNT(p.ID_PARTICIPANT)  FROM participants p  WHERE p.ID_PARTICIPANT  IN (SELECT v.ID_UTILISATEUR FROM votes v JOIN session_votes ss ON v.ID_SESSIN_VOTE=ss.ID_SESSIN_VOTE WHERE 1  ".$postes.") ) as isVote FROM participants p WHERE 1");

$pj_categorie=" ";
$pj_categorie_monta=" ";
$pj_categorie_total=0;
$pj_categorie_total_monta=0;

foreach ($statParticipant as  $value) {
  
  
$key_id1=($value['ID_PARTICIPANT']>0) ? $value['ID_PARTICIPANT'] : "0" ;
$monta=($value['isVote']>0) ? $value['isVote'] : "0" ;
$nom=(!empty($value['tout'])) ? $value['tout'] : "Vehicule trouvé" ;
$nbre=($value['nonVote']>0) ? $value['nonVote'] : "0" ;


$pj_categorie_monta.="{name:'".str_replace("'","\'", $nom)."', y:". $monta.",key:2}";
$pj_categorie.="{name:'".str_replace("'","\'", $nom)."', y:". $nbre.",key:1}";
$pj_categorie_total=$pj_categorie_total+$value['nonVote'];
$pj_categorie_total_monta=$pj_categorie_total_monta+$value['isVote'];

 }


//poste

// $immatricula=$this->Model->getRequete("SELECT r.ID_CANDIDAT AS ID, p.NOM  AS DESCRIPTION ,p.PRENOM,p.TELEPHONE,p.EMAIL,p.PHOTO,R.VOTES AS VOTES FROM participants 
// p LEFT JOIN resultants_votes r ON r.ID_CANDIDAT=p.ID_PARTICIPANT WHERE P.IS_CANDIDAT=1");


$immatricula=$this->Model->getRequete("SELECT p.ID_PARTIE_POLITIQUE AS ID, p.DESIGNATION AS DESCRIPTION, 'Partie Politique' AS TYPE, COALESCE(r.VOTES, 0) AS VOTES
		FROM partie_politiques p LEFT JOIN resultants_votes r ON r.ID_CANDIDAT=p.ID_PARTIE_POLITIQUE
		WHERE p.IS_ACTIVE = 1

		UNION ALL

		SELECT pa.ID_PARTIE_POLITIQUE AS ID,  CONCAT(pa.NOM, ' ', pa.PRENOM) AS DESCRIPION, 'Participant' AS TYPE, COALESCE(r.VOTES, 0) AS VOTES
		FROM participants pa LEFT JOIN resultants_votes r ON r.ID_CANDIDAT=pa.ID_PARTICIPANT
		WHERE pa.IS_CANDIDAT = 1 AND pa.IS_ACTIVE = 1 AND pa.ID_POSTE =".$sessionVote['ID_POSTE']."
        
        UNION ALL

            SELECT 
                0 AS ID, 
                'VOTE NULLE' AS DESCRIPTION, 
                'Vote Nulle' AS TYPE, 
                COUNT(*) AS VOTES
            FROM 
                resultants_votes r
            WHERE 
                r.ID_CANDIDAT = 0
        
        ");


$immatricula_categorie=" ";
$immatricula_categorie_monta=" ";
$immatricula_categorie_total=0;
$immatricula_categorie_total_monta=0;

foreach ($immatricula as  $value) {
  
  
    $key_id1=($value['ID']>0) ? $value['ID'] : "0" ;
    $monta=($value['VOTES']>0) ? $value['VOTES'] : "0" ;
    $nom=(!empty($value['DESCRIPTION'])) ? $value['DESCRIPTION'] : "Immatriculation trouvé" ;
    $nbre=($value['VOTES']>0) ? $value['VOTES'] : "0" ;


    $immatricula_categorie_monta.="{name:'".str_replace("'","\'", $nom)."', y:". $monta.",key:'". $key_id1."'},";
    $immatricula_categorie.="{name:'".str_replace("'","\'", $nom)."', y:". $nbre.",key:'". $key_id1."'},";
    $immatricula_categorie_total=$immatricula_categorie_total+$value['VOTES'];
}




$rapp2="<script type=\"text/javascript\">
Highcharts.chart('container6', {

chart: {
    type: 'column'
},
title: {
    text: '<b> Progression de la participation des électeurs </b>  du ".date('d-m-Y')." '
},
subtitle: {
    text: ''
},
xAxis: {
      type: 'category',
    crosshair: true
},
yAxis: {
    min: 0,
    title: {
        text: ''
    }
},
tooltip: {
    headerFormat: '<span style=\"font-size:10px\">{point.key}</span><table>',
    pointFormat: '<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>' +
        '<td style=\"padding:0\"><b>{point.y:.f} </b></td></tr>',
    footerFormat: '</table>',
    shared: true,
    useHTML: true
},
plotOptions: {
    column: {
         pointPadding: 0.2,
        borderWidth: 0,
        depth: 40,
         cursor:'pointer',
         point:{
            events: {
              click: function()
{
$(\"#titre1\").html(\"Détails \");
$(\"#myModal1\").modal();
var row_count ='1000000';
$(\"#mytable1\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_vote/detail2')."\",
type:\"POST\",
data:{
key:this.key, 
                             key1:this.key1,
                            mois:$('#mois').val(),
                            jour:$('#jour').val(),
                            heure:$('#heure').val(),
                            CANDIDAT:$('#CANDIDAT').val(),
                             ELECTEUR:$('#ELECTEUR').val(),
                              IS_PAID:$('#IS_PAID').val(),
                              ID_CATEGORIE:$('#ID_CATEGORIE').val()

}
},
lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
pageLength: 10,
\"columnDefs\":[{
\"targets\":[],
\"orderable\":false
}],
dom: 'Bfrtlip',
buttons: [
'excel', 'print','pdf'
],
language: {
\"sProcessing\":     \"Traitement en cours...\",
\"sSearch\":         \"Rechercher&nbsp;:\",
\"sLengthMenu\":     \"Afficher _MENU_ &eacute;l&eacute;ments\",
\"sInfo\":           \"Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments\",
\"sInfoEmpty\":      \"Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment\",
\"sInfoFiltered\":   \"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)\",
\"sInfoPostFix\":    \"\",
\"sLoadingRecords\": \"Chargement en cours...\",
\"sZeroRecords\":    \"Aucun &eacute;l&eacute;ment &agrave; afficher\",
\"sEmptyTable\":     \"Aucune donn&eacute;e disponible dans le tableau\",
\"oPaginate\": {
\"sFirst\":      \"Premier\",
\"sPrevious\":   \"Pr&eacute;c&eacute;dent\",
\"sNext\":       \"Suivant\",
\"sLast\":       \"Dernier\"
},
\"oAria\": {
\"sSortAscending\":  \": activer pour trier la colonne par ordre croissant\",
\"sSortDescending\": \": activer pour trier la colonne par ordre d&eacute;croissant\"
}
}
                          
});


                       

               }
           }
       },
       dataLabels: {
         enabled: true,
         format: '{point.y:f}'
     },
     showInLegend: true
 }
}, 
credits: {
enabled: true,
href: \"\",
text: \"Développé par Claudine\"
},

series: [
{
    
    color: 'green',
    name:'Electeur n\'ayant pas voté : (".number_format($pj_categorie_total,0,',',' ').")',
    data: [".$pj_categorie."]
},
 {
    color: 'yellow',  
    name:'Électeur  vote : (".number_format($pj_categorie_total_monta,0,',',' ').")',
    data: [".$pj_categorie_monta."]
},

]

});
</script>
 ";

 $rapp3="<script type=\"text/javascript\">
Highcharts.chart('container5', {

chart: {
    type: 'bar'
},
title: {
    text: '<b> Nombre de Votes par Chaque Candidat </b> '
},
subtitle: {
    text: ''
},
xAxis: {
      type: 'category',
    crosshair: true
},
yAxis: {
    min: 0,
    title: {
        text: ''
    }
},
tooltip: {
    headerFormat: '<span style=\"font-size:10px\">{point.key}</span><table>',
    pointFormat: '<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>' +
        '<td style=\"padding:0\"><b>{point.y:.f} </b></td></tr>',
    footerFormat: '</table>',
    shared: true,
    useHTML: true
},
plotOptions: {
    bar: {
         pointPadding: 0.2,
        borderWidth: 0,
        depth: 40,
         cursor:'pointer',
         point:{
            events: {
              click: function()
{
             
$(\"#titre\").html(\"Les candidats pour les  \"+this.name);
$(\"#myModal\").modal();
var row_count ='1000000';
$(\"#mytable\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_vote/detail3')."\",
type:\"POST\",
data:{
key:this.key, 
                             key:this.key,

}
},
lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
pageLength: 10,
\"columnDefs\":[{
\"targets\":[],
\"orderable\":false
}],
dom: 'Bfrtlip',
buttons: [
'excel', 'print','pdf'
],
language: {
\"sProcessing\":     \"Traitement en cours...\",
\"sSearch\":         \"Rechercher&nbsp;:\",
\"sLengthMenu\":     \"Afficher _MENU_ &eacute;l&eacute;ments\",
\"sInfo\":           \"Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments\",
\"sInfoEmpty\":      \"Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment\",
\"sInfoFiltered\":   \"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)\",
\"sInfoPostFix\":    \"\",
\"sLoadingRecords\": \"Chargement en cours...\",
\"sZeroRecords\":    \"Aucun &eacute;l&eacute;ment &agrave; afficher\",
\"sEmptyTable\":     \"Aucune donn&eacute;e disponible dans le tableau\",
\"oPaginate\": {
\"sFirst\":      \"Premier\",
\"sPrevious\":   \"Pr&eacute;c&eacute;dent\",
\"sNext\":       \"Suivant\",
\"sLast\":       \"Dernier\"
},
\"oAria\": {
\"sSortAscending\":  \": activer pour trier la colonne par ordre croissant\",
\"sSortDescending\": \": activer pour trier la colonne par ordre d&eacute;croissant\"
}
}
                          
});


                       

               }
           }
       },
       dataLabels: {
         enabled: true,
         format: '{point.y:f}'
     },
     showInLegend: true
 }
}, 
credits: {
enabled: true,
href: \"\",
text: \"Développé par Claudine\"
},

series: [
{
    
    color: 'green',
    name:'Nombre : (".number_format($immatricula_categorie_total,0,',',' ').")',
    data: [".$immatricula_categorie."]
},


]

});
</script>
 "; 

echo json_encode(array('rapp2'=>$rapp2,'rapp3'=>$rapp3));

}

public function get_poste(){ 

    $id=$this->input->post('ID_POSTE');
    $index=$this->input->post('index');
//techn   
$votes=$this->Model->getRequete("SELECT r.ID_CANDIDAT,r.VOTES AS vote,p.PRENOM,p.NOM FROM participants p JOIN resultants_votes r ON r.ID_CANDIDAT=p.ID_PARTICIPAN WHERE p.IS_CANDIDAT=1 AND p.ID_POSTE= ".$id."");

$candidat_vote=" ";
$votes_nbre=" ";
$votes_nbre_total=0;
$votes_nbre_total_chiffre=0;

foreach ($votes as  $value) {
  
  
                $key_id1=($value['ID_CANDIDAT']>0) ? $value['ID_CANDIDAT'] : "0" ;
                $nom=$value['PRENOM']  ;
                $monta=($value['vote']>0) ? $value['vote'] : "0" ;
                $nbre=($value['vote']>0) ? $value['vote'] : "0" ;


                $votes_nbre.="{name:'".str_replace("'","\'", $value['PRENOM'])."', y:". $monta.",key:'". $key_id1."'},";
                $candidat_vote.="{name:'".str_replace("'","\'", $nom)." : ".number_format($nbre,0,',',' ')."', y:". $nbre.",key:'". $key_id1."'},";
                $votes_nbre_total=$votes_nbre_total+$value['vote'];
                $votes_nbre_total_chiffre=$votes_nbre_total_chiffre+$value['vote'];


 }



$rapp1="<script type=\"text/javascript\">
Highcharts.chart('container".$index."', {
       chart: {
    type: 'pie',
   
},
title: {
    text: '<b>Résultats des votes pour chaque candidat </b> '
},
accessibility: {
    point: {
        valueSuffix: '%'
    }
},
tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
},

plotOptions: {
    pie: {
         allowPointSelect: true,
        cursor: 'pointer',
        depth: 35,
   cursor:'pointer',
         point:{
            events: {
click: function()
{
$(\"#titre1\").html(\"Electeurs qui ont voté pour   \"+this.name);
$(\"#myModal1\").modal();
var row_count ='1000000';
$(\"#mytable1\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_vote/detail1')."\",
type:\"POST\",
data:{
key:this.key, 
}
},
lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
pageLength: 10,
\"columnDefs\":[{
\"targets\":[],
\"orderable\":false
}],
dom: 'Bfrtlip',
buttons: [
'excel', 'print','pdf'
],
language: {
\"sProcessing\":     \"Traitement en cours...\",
\"sSearch\":         \"Rechercher&nbsp;:\",
\"sLengthMenu\":     \"Afficher _MENU_ &eacute;l&eacute;ments\",
\"sInfo\":           \"Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments\",
\"sInfoEmpty\":      \"Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment\",
\"sInfoFiltered\":   \"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)\",
\"sInfoPostFix\":    \"\",
\"sLoadingRecords\": \"Chargement en cours...\",
\"sZeroRecords\":    \"Aucun &eacute;l&eacute;ment &agrave; afficher\",
\"sEmptyTable\":     \"Aucune donn&eacute;e disponible dans le tableau\",
\"oPaginate\": {
\"sFirst\":      \"Premier\",
\"sPrevious\":   \"Pr&eacute;c&eacute;dent\",
\"sNext\":       \"Suivant\",
\"sLast\":       \"Dernier\"
},
\"oAria\": {
\"sSortAscending\":  \": activer pour trier la colonne par ordre croissant\",
\"sSortDescending\": \": activer pour trier la colonne par ordre d&eacute;croissant\"
}
}
                          
});


                       

               }
           }
       },
     showInLegend: false
 }
},

credits: {
enabled: true,
href: \"\",
text: \"Develope par Claudine\"
},      
series: [{
    type: 'pie',
    name: 'Vote en pourcentage',
    data: [".$candidat_vote."]
}]
});
</script>
 ";


echo json_encode(array('rapp1'=>$rapp1));

}



}
