
<?php
 /// EDMOND :dashboard des grobal
class Dashboard_vote extends CI_Controller
{
         function index(){
                // $dattes=$this->Model->getRequete("SELECT DISTINCT date_format(historiques.DATE_INSERTION,'%Y') AS mois FROM historiques WHERE RAISON_ANNULATION IS NULL ORDER BY  mois ASC");
                 $categorie=$this->Model->getRequete('SELECT ID_POSTE,DESCRIPTION FROM `postes` WHERE 1');     
                // $data['dattes']=$dattes;
                $data['categorie']=$categorie;
                $this->load->view('Dashboard_vote_View',$data);
           }
           function detail1()  
           {
       
                   $KEY=$this->input->post('key');
                  
                   $criteres1="";
                   $search='';
                   $critaire="";     
                   $criteres_date="";
                   $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     
                   $query_principal=" ";
       
       
                   $query_principal=" SELECT s.DESCRIPTION AS sexe, par.DESCRIPTION AS partie ,
                                         col.COLLINE_NAME AS colline ,zo.ZONE_NAME AS zone,
                                        com.COMMUNE_NAME AS commune,pro.PROVINCE_NAME AS province, 
                                       p.* FROM votes v JOIN  participants  p ON p.ID_UTILISATEUR=v.ID_UTILISATEUR
                                           LEFT JOIN partie_politiques par ON par.ID_PARTIE_POLITIQUE=p.ID_PARTIE_POLITIQUE 
                                           LEFT JOIN syst_collines col ON col.COLLINE_ID=p.ID_COLLINE 
                                           LEFT JOIN syst_zones zo ON zo.ZONE_ID=col.COLLINE_ID 
                                           LEFT JOIN syst_communes com ON com.COMMUNE_ID=zo.COMMUNE_ID 
                                           LEFT JOIN syst_provinces pro ON pro.PROVINCE_ID=com.PROVINCE_ID  
                                           LEFT JOIN sexes s ON s.ID_SEXE=p.ID_SEXE WHERE 1  AND v.ID_CANDIDAT=".$KEY;
                           
       
       
               $limit='LIMIT 0,10';
               if($_POST['length'] != -1)
               {
                   $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
               }
               $order_by='';
               if($_POST['order']['0']['column']!=0)
               {
                   $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY ID_PARTICIPANT  ASC'; 
               }
       
               $search = !empty($_POST['search']['value']) ? ("AND (NOM LIKE '%$var_search%'  OR PRENOM LIKE '%$var_search%' OR EMAIL LIKE '%$var_search%'  ) ") : '';
               $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
               $query_filter=$query_principal.'  '.$critaire.' '.$search;
       
               $fetch_data = $this->Model->datatable($query_secondaire);
               $u=0;
               $data = array();
               foreach ($fetch_data as $row) 
               {
                       $u++;
                       $intrant=array();
                       $intrant[] = $u;
                       $source = !empty($row->PHOTO) ? $row->PHOTO : "https://app.développé par claudine.bi/wasiliEate/uploads/personne.png";
                       $intrant[] = '<table> <tbody><tr><td><a href="' . $source . '" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM . ' ' . $row->PRENOM. '</td></tr></tbody></table></a>';
                       $intrant[] = '<table> <tbody><tr><td>' . $row->TELEPHONE . ' ' . $row->EMAIL . '</td></tr></tbody></table></a>';
                       $intrant[] =$row->NUMERO_CNI;
                       $intrant[] =$row->sexe;
                       $intrant[] =$row->DATE_NAISSANCE;
                       $intrant[] = $row->colline.'-'.$row->zone.'-'.$row->commune.'-'.$row->province;
       
                       $data[] = $intrant;
                 }
       
               $output = array(
                   "draw" => intval($_POST['draw']),
                   "recordsTotal" =>$this->Model->all_data($query_principal),
                   "recordsFiltered" => $this->Model->filtrer($query_filter),
                   "data" => $data
               );
       
               echo json_encode($output);
           }
   
    function detail2()  
    {

            $KEY=$this->input->post('key');
            $critereKey="";

            if($KEY==1){
                $critereKey="AND p.ID_PARTICIPANT NOT IN (SELECT v.ID_UTILISATEUR FROM votes v JOIN session_votes ss ON v.ID_SESSIN_VOTE=ss.ID_SESSIN_VOTE WHERE 1)";
            }
            else{
                $critereKey="AND p.ID_PARTICIPANT  IN (SELECT v.ID_UTILISATEUR FROM votes v JOIN session_votes ss ON v.ID_SESSIN_VOTE=ss.ID_SESSIN_VOTE WHERE 1)";

            }
            $criteres1="";
            $search='';
            $critaire="";     
            $criteres_date="";
            $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     
            $query_principal=" ";


            $query_principal=" SELECT s.DESCRIPTION AS sexe, par.DESCRIPTION AS partie ,
                                  col.COLLINE_NAME AS colline ,zo.ZONE_NAME AS zone,
                                 com.COMMUNE_NAME AS commune,pro.PROVINCE_NAME AS province, 
                                p.* FROM  participants p 
                                    LEFT JOIN partie_politiques par ON par.ID_PARTIE_POLITIQUE=p.ID_PARTIE_POLITIQUE 
                                    LEFT JOIN syst_collines col ON col.COLLINE_ID=p.ID_COLLINE 
                                    LEFT JOIN syst_zones zo ON zo.ZONE_ID=col.COLLINE_ID 
                                    LEFT JOIN syst_communes com ON com.COMMUNE_ID=zo.COMMUNE_ID 
                                    LEFT JOIN syst_provinces pro ON pro.PROVINCE_ID=com.PROVINCE_ID  
                                    LEFT JOIN sexes s ON s.ID_SEXE=p.ID_SEXE WHERE 1 ".$critereKey;
                    


        $limit='LIMIT 0,10';
        if($_POST['length'] != -1)
        {
            $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
        }
        $order_by='';
        if($_POST['order']['0']['column']!=0)
        {
            $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY ID_PARTICIPANT  ASC'; 
        }

        $search = !empty($_POST['search']['value']) ? ("AND (NOM LIKE '%$var_search%'  OR PRENOM LIKE '%$var_search%' OR EMAIL LIKE '%$var_search%'  ) ") : '';
        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {
                $u++;
                $intrant=array();
                $intrant[] = $u;
                $source = !empty($row->PHOTO) ? $row->PHOTO : "https://app.développé par claudine.bi/wasiliEate/uploads/personne.png";
                $intrant[] = '<table> <tbody><tr><td><a href="' . $source . '" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM . ' ' . $row->PRENOM. '</td></tr></tbody></table></a>';
                $intrant[] = '<table> <tbody><tr><td>' . $row->TELEPHONE . ' ' . $row->EMAIL . '</td></tr></tbody></table></a>';
                $intrant[] =$row->NUMERO_CNI;
                $intrant[] =$row->sexe;
                $intrant[] =$row->DATE_NAISSANCE;
                $intrant[] = $row->colline.'-'.$row->zone.'-'.$row->commune.'-'.$row->province;

                $data[] = $intrant;
          }

        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" =>$this->Model->all_data($query_principal),
            "recordsFiltered" => $this->Model->filtrer($query_filter),
            "data" => $data
        );

        echo json_encode($output);
    }
    
    function detail3()  
    {

            $KEY=$this->input->post('key');
            $criteres1="";
            $search='';
            $critaire="";     
            $criteres_date="";
            $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     
            $query_principal=" ";
            if($KEY==4){
                $query_principal=" SELECT 
                'Participant' AS TYPE,
            p.ID_PARTICIPANT,
            p.NOM AS DESIGNATION ,
            p.PRENOM AS DESCRIPTION,
            p.TELEPHONE,
            p.EMAIL,
            p.PHOTO
                
            FROM 
                participants p
            WHERE 
                p.IS_CANDIDAT = 1 AND p.IS_ACTIVE=1 AND p.ID_POSTE =".$KEY;
            }
            else {
                $query_principal="  SELECT 
                        'Parti Politique' AS TYPE,
                        pp.ID_PARTIE_POLITIQUE,
                        pp.DESIGNATION,
                        pp.DESCRIPTION,
                        pp.TELEPHONE,
                        pp.EMAIL,
                        pp.PHOTO
                    FROM 
                        partie_politiques pp
                    WHERE 
                        1 AND pp.IS_ACTIVE=1
                    
                    UNION ALL
                    
                    SELECT 
                        'Participant' AS TYPE,
                    p.ID_PARTICIPANT,
                    p.NOM,
                    p.PRENOM,
                    p.TELEPHONE,
                    p.EMAIL,
                    p.PHOTO
                        
                    FROM 
                        participants p
                    WHERE 
                        p.IS_CANDIDAT = 1 AND p.IS_ACTIVE=1 AND p.ID_POSTE=".$KEY;
                        }


          
        $limit='LIMIT 0,10';
        if($_POST['length'] != -1)
        {
            $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
        }
        $order_by='';
        if($_POST['order']['0']['column']!=0)
        {
            $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY ID_PARTICIPANT  ASC'; 
        }

        $search = !empty($_POST['search']['value']) ? ("AND (NOM LIKE '%$var_search%'  OR PRENOM LIKE '%$var_search%' OR EMAIL LIKE '%$var_search%'  ) ") : '';
        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {
                $u++;
                $intrant=array();
                $intrant[] = $u;
                $source = !empty($row->PHOTO) ? $row->PHOTO : "https://app.développé par claudine.bi/wasiliEate/uploads/personne.png";
                $intrant[] = '<table> <tbody><tr><td><a href="' . $source . '" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->DESIGNATION . '</td></tr></tbody></table></a>';
                // $intrant[] = '<table> <tbody><tr><td>' . $row->TELEPHONE . ' ' . $row->EMAIL . '</td></tr></tbody></table></a>';
                $intrant[] = $row->DESCRIPTION;
                $intrant[] = $row->TELEPHONE;
                $intrant[] = $row->EMAIL;



                $data[] = $intrant;
          }

        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" =>$this->Model->all_data($query_principal),
            "recordsFiltered" => $this->Model->filtrer($query_filter),
            "data" => $data
        );

        echo json_encode($output);
    }

public function get_rapport(){ 

        $CANDIDAT=$this->input->post('CANDIDAT');
        $ELECTEUR=$this->input->post('ELECTEUR');
        $ID_POSTE=$this->input->post('ID_POSTE');
        $poste="";
        $postes="";
        $sessionVote = $this->Model->getRequeteOne('SELECT * FROM session_votes WHERE  IS_CURRENT=1');

        if (!empty($ID_POSTE)){
        $poste.="  AND  pa.ID_POSTE=".$ID_POSTE;
        $postes.="  AND  ss.ID_POSTE=".$ID_POSTE;
            
        }
        else{
            $poste.="  AND  pa.ID_POSTE=".$sessionVote['ID_POSTE'];
            $postes.="  AND  ss.ID_POSTE=".$sessionVote['ID_POSTE'];  
        }
            $search='';
            if (!empty($CANDIDAT)) {
            $search=' and h.CANDIDAT like "%'.$CANDIDAT.'%"'; 
            }
            $plaque='';

            if (!empty($ELECTEUR)) {
            $plaque=' and h.ELECTEUR like "%'.$ELECTEUR.'%"'; 
            }
//techn   
$votes=$this->Model->getRequete("SELECT p.ID_PARTIE_POLITIQUE AS ID, p.DESIGNATION AS DESCRIPTION, 'Partie Politique' AS TYPE, COALESCE(r.VOTES, 0) AS VOTES
FROM partie_politiques p LEFT JOIN resultants_votes r ON r.ID_CANDIDAT=p.ID_PARTIE_POLITIQUE
WHERE p.IS_ACTIVE = 1

UNION ALL

SELECT pa.ID_PARTIE_POLITIQUE AS ID,  CONCAT(pa.NOM, ' ', pa.PRENOM) AS DESCRIPTION, 'Participant' AS TYPE, COALESCE(r.VOTES, 0) AS VOTES
FROM participants pa LEFT JOIN resultants_votes r ON r.ID_CANDIDAT=pa.ID_PARTICIPANT
WHERE pa.IS_CANDIDAT = 1 AND pa.IS_ACTIVE = 1 ".$poste."

UNION ALL

    SELECT 
        0 AS ID, 
        'VOTE NULLE' AS DESCRIPTION, 
        'Vote Nulle' AS TYPE, 
        COUNT(*) AS VOTES
    FROM 
        resultants_votes r
    WHERE 
        r.ID_CANDIDAT = 0");

$candidat_vote=" ";
$votes_nbre=" ";
$votes_nbre_total=0;
$votes_nbre_total_chiffre=0;
 
 foreach ($votes as  $value) {
      
      
$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;
$nom=$value['DESCRIPTION']  ;
$monta=($value['VOTES']>0) ? $value['VOTES'] : "0" ;
$nbre=($value['VOTES']>0) ? $value['VOTES'] : "0" ;


$votes_nbre.="{name:'".str_replace("'","\'", $value['DESCRIPTION'])."', y:". $monta.",key:'". $key_id1."'},";
$candidat_vote.="{name:'".str_replace("'","\'", $nom)." : ".number_format($nbre,0,',',' ')."', y:". $nbre.",key:'". $key_id1."'},";
$votes_nbre_total=$votes_nbre_total+$value['VOTES'];
$votes_nbre_total_chiffre=$votes_nbre_total_chiffre+$value['VOTES'];

    
     }

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

// $immatricula=$this->Model->getRequete("SELECT p.ID_POSTE,p.DESCRIPTION,COUNT(pa.ID_PARTICIPANT) as candidats FROM
//  postes p  LEFT JOIN participants pa ON pa.ID_POSTE=p.ID_POSTE WHERE 1 " .$poste."   GROUP BY p.ID_POSTE");

// $immatricula=$this->Model->getRequete("SELECT 
// p.ID_POSTE,
// p.DESCRIPTION,
// COUNT(pa.ID_PARTICIPANT) AS candidats,
// (SELECT COUNT(pp.ID_PARTIE_POLITIQUE) FROM partie_politiques pp WHERE pp.IS_ACTIVE=1) AS total_partis,
// COUNT(pa.ID_PARTICIPANT) + (SELECT COUNT(pp.ID_PARTIE_POLITIQUE) FROM partie_politiques pp WHERE pp.IS_ACTIVE=1 ) AS total_candidats
// FROM 
// postes p
// LEFT JOIN 
// participants pa ON p.ID_POSTE = pa.ID_POSTE WHERE 1 AND pa.IS_CANDIDAT=1 AND pa.IS_ACTIVE=1 " .$poste."  
// GROUP BY 
// p.ID_POSTE, p.DESCRIPTION");

$immatricula=$this->Model->getRequete("SELECT 
    p.ID_POSTE,
    p.DESCRIPTION,
    COUNT(pa.ID_PARTICIPANT) AS candidats,
    (SELECT COUNT(pp.ID_PARTIE_POLITIQUE) FROM partie_politiques pp WHERE pp.IS_ACTIVE = 1) AS total_partis,
    COUNT(pa.ID_PARTICIPANT) + (SELECT COUNT(pp.ID_PARTIE_POLITIQUE) FROM partie_politiques pp WHERE pp.IS_ACTIVE = 1) AS total_candidats
FROM 
    postes p
LEFT JOIN 
    participants pa ON p.ID_POSTE = pa.ID_POSTE AND pa.IS_CANDIDAT = 1 AND pa.IS_ACTIVE = 1 
GROUP BY 
    p.ID_POSTE, p.DESCRIPTION;");

$immatricula_categorie=" ";
$immatricula_categorie_monta=" ";
$immatricula_categorie_total=0;
$immatricula_categorie_total_monta=0;
 
 foreach ($immatricula as  $value) {
      
      if($value['ID_POSTE']==4){
        $key_id1=($value['ID_POSTE']>0) ? $value['ID_POSTE'] : "0" ;
        $monta=($value['candidats']>0) ? $value['candidats'] : "0" ;
        $nom=(!empty($value['DESCRIPTION'])) ? $value['DESCRIPTION'] : "Immatriculation trouvé" ;
        $nbre=($value['candidats']>0) ? $value['candidats'] : "0" ;


        $immatricula_categorie_monta.="{name:'".str_replace("'","\'", $nom)."', y:". $monta.",key:'". $key_id1."'},";
        $immatricula_categorie.="{name:'".str_replace("'","\'", $nom)."', y:". $nbre.",key:'". $key_id1."'},";
        $immatricula_categorie_total=$immatricula_categorie_total+$value['candidats'];

      }
      else{
        $key_id1=($value['ID_POSTE']>0) ? $value['ID_POSTE'] : "0" ;
        $monta=($value['total_candidats']>0) ? $value['total_candidats'] : "0" ;
        $nom=(!empty($value['DESCRIPTION'])) ? $value['DESCRIPTION'] : "Immatriculation trouvé" ;
        $nbre=($value['total_candidats']>0) ? $value['total_candidats'] : "0" ;


        $immatricula_categorie_monta.="{name:'".str_replace("'","\'", $nom)."', y:". $monta.",key:'". $key_id1."'},";
        $immatricula_categorie.="{name:'".str_replace("'","\'", $nom)."', y:". $nbre.",key:'". $key_id1."'},";
        $immatricula_categorie_total=$immatricula_categorie_total+$value['total_candidats'];
      }
       
 }
   

   $rapp1="<script type=\"text/javascript\">
   Highcharts.chart('container1', {
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


     //PARTICIPAMT
 $rapp2="<script type=\"text/javascript\">
    Highcharts.chart('container2', {
   
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

//poste
     $rapp3="<script type=\"text/javascript\">
    Highcharts.chart('container3', {
   
chart: {
        type: 'bar'
    },
    title: {
        text: '<b> Nombre de candidats par catégorie d\'élection </b> '
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
        
        color: 'pink',
        name:'Nombre : (".number_format($immatricula_categorie_total,0,',',' ').")',
        data: [".$immatricula_categorie."]
    },
    
    
    ]

});
</script>
     "; 

echo json_encode(array('rapp1'=>$rapp1,'rapp2'=>$rapp2,'rapp3'=>$rapp3));
// echo json_encode(array('rapp1'=>$rapp1));


 }


}
?>




