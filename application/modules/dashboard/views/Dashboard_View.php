<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>



<style type="text/css">
  .mapbox-improve-map {
    display: none;
  }
  .card-body {
    min-height: 350px; /* Vous pouvez ajuster cette valeur en fonction de vos besoins */
  }
  .leaflet-control-attribution {
    display: none !important;
  }

  .leaflet-control-attribution {
    display: none !important;
  }


  .mapbox-logo {
    display: none;
  }

  a
</style>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include VIEWPATH . 'templates/navbar.php'; ?>

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include VIEWPATH . 'templates/sidebar.php'; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-8">
              <h4 class="m-0">Tableau de bord</h4>
            </div><!-- /.col -->


            <div class="col-sm-4 text-right">



            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->


        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">

        <div class="row">  
              <div class="col-md-4 col-xl-4">
                          <div class="card overflow-hidden" style="background-color:#1A96D8">
                                    <div class="card-body">
                                                  <div class="row">
                                                      <div class="col-7 col-md-3">
                                                    
                                                      <i class="fa fa-paper-plane  fa-3x fa-fw fa-9x" aria-hidden="true" style='color:white'></i>
                                                      </div>
                                                      <div class="col-8 col-md-3"></div>
                                                        <div class="col-8 col-md-3">
                                                              <h1 class="mb-0">1</h1>
                                                              <h1 class="fw-bold mt-3 mb-0">Votes</h1>
                                                      
                                                        </div>
                                      </div>
                            </div>
                     </div>
              </div>




              <div class="col-md-4 col-xl-4" >
                          <div class="card overflow-hidden" style="background-color:green">
                                    <div class="card-body">
                                                <div class="row">
                                                      <div class="col-7 col-md-3" >
                                                      <i class="fa fa-database  fa-3x fa-fw fa-9x" aria-hidden="true" style='color:white'></i>
                                                      </div>
                                                      <div class="col-8 col-md-3"></div>
                                                        <div class="col-8 col-md-6">
                                                              <h1 class="mb-0">1</h1>
                                                              <h1 class="fw-bold mt-3 mb-0">Electeurs</h1>
                                                      
                                                        </div>
                                      </div>
                            </div>
                     </div>
              </div>


              <div class="col-md-4 col-xl-4">
                          <div class="card overflow-hidden" style="background-color:#D9DE32">
                                    <div class="card-body">
                                                  <div class="row">
                                                      <div class="col-7 col-md-3">
                                                      <i class="fa fa-cog fa-spin fa-3x fa-fw fa-9x"" aria-hidden="true"  style='color:white'></i>

                                                      </div>
                                                      <div class="col-8 col-md-3"></div>
                                                        <div class="col-8 col-md-6">
                                                              <h1 class="mb-0">1 jour</h1>
                                                              <h1 class="fw-bold mt-3 mb-0">Restant</h1>
                                                      
                                                        </div>
                                                  </div>
                                      </div>
                            </div>
                     </div>
              </div>
              <div class="row">  
                      <div class="col-xl-6">
                        <div class="card">
                          <div class="card-header border-0 pb-0">
                            <h4 class="fs-20 font-w600">Profile Stregth</h4>
                          </div>
                          <div class="card-body">
                             <div class="row align-items-center">
                                 <div class="col-xl-6 col-sm-6">
                                 <?php if (!empty($votes)) { ?>
                                          <?php foreach ($votes as $value) { ?>
                                            <div class="progress default-progress">
                                              <div class="progress-bar bg-vigit progress-animated" style="width: <?= $value['nbre_vote'] ?>%; height:23px;" role="progressbar">
                                                <span class="sr-only"><?= $value['nbre_vote'] ?> Complete</span>
                                              </div>
                                            </div>
                                            <div class="d-flex align-items-end mt-2 pb-4 justify-content-between">
                                              <span class="fs-14 font-w500"><?= $value['NOM_CANDIDAT'] ?></span>
                                              <span class="fs-16"><span class="text-black pe-2"></span><?= $value['nbre_vote'] ?></span>
                                            </div>
                                          <?php } ?>
                                        <?php } else { ?>
                                          <div class="no-data">
                                            <p>Aucune donnée disponible</p>
                                          </div>
                                        <?php } ?>
                                   </div>
                               </div>
                           </div>

                        </div>
                      </div>
                      <div class="col-xl-6">
                      <div id="container1"></div>
                      </div>
              </div>
              

            
            </div>

      </div>

      <!-- Rapport partie -->



      <!-- End Rapport partie -->

    </div>
  </div>
  </div>
  </div>


  </section>


  <!-- /.content -->
  </div>

  </div>
  <!-- ./wrapper -->
  <?php include VIEWPATH . 'templates/footer.php'; ?>
</body>
<script type="text/javascript">
  Highcharts.chart('container1', {
    chart: {
      type: 'column'
    },
    title: {
      text: '<?= $nom1 ?>officier connecté',
    },
    subtitle: {
      text: ''
    },
    xAxis: {
      type: 'category'
    },
    yAxis: {
      min: 0,
      title: {
        text: ''
      }
    },
    plotOptions: {


      column: {
        cursor: 'pointer',
        depth: 25,
        point: {
          events: {
            click: function() {

              $("#titre2").html("Liste des officiers connectés par date");

              $("#myModal2").modal();


              var row_count = "1000000";
              $("#mytable2").DataTable({
                "processing": true,
                "serverSide": true,
                "bDestroy": true,
                "oreder": [],
                "ajax": {
                  url: "<?= base_url('dashboard/Useer_Policier_Dash/detailUsers') ?>",
                  type: "POST",
                  data: {
                    key: this.key,


                  }
                },
                lengthMenu: [
                  [10, 50, 100, row_count],
                  [10, 50, 100, "All"]
                ],
                pageLength: 10,
                "columnDefs": [{
                  "targets": [],
                  "orderable": false
                }],

                dom: 'Bfrtlip',
                buttons: [
                  'excel', 'print', 'pdf'
                ],
                language: {
                  "sProcessing": "Traitement en cours...",
                  "sSearch": "Rechercher&nbsp;:",
                  "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
                  "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                  "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                  "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                  "sInfoPostFix": "",
                  "sLoadingRecords": "Chargement en cours...",
                  "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
                  "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
                  "oPaginate": {
                    "sFirst": "Premier",
                    "sPrevious": "Pr&eacute;c&eacute;dent",
                    "sNext": "Suivant",
                    "sLast": "Dernier"
                  },
                  "oAria": {
                    "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                  }
                }

              });






            }
          }
        },
        dataLabels: {
          enabled: true
        },
        showInLegend: true
      }
    },
    series: [{
      name: 'officier connecté par date',

      data: [<?= $donnees1 ?>]
    }]
  });
  Highcharts.chart('container', {
    chart: {
      type: 'line'
    },
    title: {
      text: '<?= $nom ?>officier au total'
    },
    subtitle: {
      text: ''
    },
    xAxis: {
      // categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
      type: 'category'
    },
    yAxis: {
      title: {
        text: 'nbre d officier connecté'
      }
    },
    plotOptions: {
      line: {
        dataLabels: {
          enabled: true
        },
        enableMouseTracking: false

      }


    },
    credits: {
      enabled: true,
      href: "",
      text: "MEDIABOX"
    },
    series: [{
        name: 'officier connecté',
        data: [<?= $donnees ?>]


      }

    ]
  });
</script>


</html>


