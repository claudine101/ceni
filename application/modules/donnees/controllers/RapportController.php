<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RapportController extends CI_Controller {
             public function get_rapportOld()
                      {
                                   

                                    //poste

                                    $immatricula=$this->Model->getRequete("SELECT r.ID_CANDIDAT, p.NOM ,p.PRENOM,p.TELEPHONE,p.EMAIL,p.PHOTO,R.VOTES FROM participants 
                                    p LEFT JOIN resultants_votes r ON r.ID_CANDIDAT=p.ID_PARTICIPANT WHERE P.IS_CANDIDAT=1");

                                    $immatricula_categorie=" ";
                                    $immatricula_categorie_monta=" ";
                                    $immatricula_categorie_total=0;
                                    $immatricula_categorie_total_monta=0;

                                    foreach ($immatricula as  $value) {
                                    
                                    
                                        $key_id1=($value['ID_CANDIDAT']>0) ? $value['ID_CANDIDAT'] : "0" ;
                                        $monta=($value['VOTES']>0) ? $value['VOTES'] : "0" ;
                                        $nom=(!empty($value['NOM'])) ? $value['NOM']." ".$value['PRENOM'] : "Immatriculation trouvé" ;
                                        $nbre=($value['VOTES']>0) ? $value['VOTES'] : "0" ;


                                        $immatricula_categorie_monta.="{name:'".str_replace("'","\'", $nom)."', y:". $monta.",key:'". $key_id1."'},";
                                        $immatricula_categorie.="{name:'".str_replace("'","\'", $nom)."', y:". $nbre.",key:'". $key_id1."'},";
                                        $immatricula_categorie_total=$immatricula_categorie_total+$value['VOTES'];
                                    }


                                    $rapp3="<script type=\"text/javascript\">
                                    Highcharts.chart('container3', {

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
                                        name:'Nombreeee : (".number_format($immatricula_categorie_total,0,',',' ').")',
                                        data: [".$immatricula_categorie."]
                                    },


                                    ]

                                    });
                                    </script>
                                    "; 

                                    echo json_encode(array('rapp3'=>$rapp3));
                                }

                                    public function get_rapport() {
                                        // Récupération des données des candidats et des votes
                                        $immatricula = $this->Model->getRequete("SELECT r.ID_CANDIDAT, p.NOM, p.PRENOM, r.VOTES FROM participants p LEFT JOIN resultants_votes r ON r.ID_CANDIDAT = p.ID_PARTICIPANT WHERE p.IS_CANDIDAT = 1");
                                
                                        $candidatesData = [];
                                        $totalVotes = 0;
                                
                                        foreach ($immatricula as $value) {
                                            $key_id1 = ($value['ID_CANDIDAT'] > 0) ? $value['ID_CANDIDAT'] : "0";
                                            $votes = ($value['VOTES'] > 0) ? $value['VOTES'] : "0";
                                            $name = (!empty($value['NOM'])) ? $value['NOM'] . " " . $value['PRENOM'] : "Immatriculation trouvé";
                                
                                            $candidatesData[] = ['name' => $name, 'y' => (int)$votes, 'key' => $key_id1];
                                            $totalVotes += (int)$votes;
                                        }
                                
                                        // Renvoyer les données au format JSON
                                        echo json_encode([
                                            'candidates' => $candidatesData,
                                            'totalVotes' => number_format($totalVotes, 0, ',', ' ')
                                        ]);
                                    }
}