<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="copyright" content="MACode ID, https://macodeid.com/">
  <title>Vote</title>
  <link rel="icon" type="image/jpg" href="<?=base_url()?>assets/img/Logo-CENI.png"/>
  <!-- <link rel="icon" type="image/x-icon" href="<?= base_url() ?>assets/img/flag.png"> -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <script src="<?= base_url() ?>assets/js/jquery-3.5.1.min.js"></script>
  <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>assets/js/google-maps.js"></script>
  <script src="<?= base_url() ?>assets/vendor/wow/wow.min.js"></script>
  <script src="<?= base_url() ?>assets/js/theme.js"></script>
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/maicons.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/animate/animate.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/visatheme.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/css/floating-wpp.css">

  <link href="https://fonts.cdnfonts.com/css/clash-display" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
  <link href="http://fonts.cdnfonts.com/css/clash-display" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

</head>
<body>

  <!-- Back to top button -->
  <div class="back-to-top"></div>
  <header>
      <!-- Top Section start -->
      <!-- Top Section start -->
         <!-- top banner -->
      <?php include VIEWPATH.'includes/top_banner.php';?>
      <!-- Top Section End -->


      <!-- Navbar start -->
         <!-- menu -->
       <?php include VIEWPATH.'includes/menu.php';?>

      <!-- Navbar end -->
      <!-- Navbar end -->



  </header> <!-- Header end-->

  <!-- Etapes visa start-->
  <div class="py-5" style="background-image: url(<?=base_url()?>assets/img/new_bg.png); background-size: cover; background-repeat: no-repeat;" id="intro">
          <div class="text-center fadeInUp">
              <h5 class="section-subtitle">Résultats des élections en Direct</h5>
          </div>
          <div class="text-center fadeInUp">
              <img src="<?=base_url()?>assets/img/uneven_orange_line.svg">
          </div><br>
          <center>
              <div class="col-lg-12 mx-auto">
              <div class="row">
                <div id="container5"  class="col-md-6"  ></div>
                <div id="container6"  class="col-md-6"  ></div>
             </div>
              </div>
          </div>
          </div>
          </center>
  </div>
 
<div id="nouveau6">
</div>
<div id="nouveau5">
</div>


</div>


  <!-- Etapes visa end-->



       <!-- <div style="background-image: url(<?=base_url()?>//assets/img/map_bg_trans_double.png);  background-repeat: none; background-size: cover" class="page-section bg-white" id="faq-visa"> -->
                    <!-- Visa types section start -->
                    <!-- <div> -->
                        <!-- Container start -->
                        <!-- <div class="text-center wow fadeInUp">
                            <h1 class="section-subtitle">Classifications Électorales</h1>
                        </div>
                        <br>
                        <div class="container py-3">
                            <div class="row">
                                <div class="col-12 mx-auto">
                                         <div class="accordion shadow-sm rounded" id="faqExample">
                                                    <?php foreach ($postes as $index => $poste): ?>
                                                        <div class="card">
                                                            <div onclick="clickedDiv(<?= $poste['ID_POSTE']?>,<?= $index ?>);"style="cursor: pointer" data-toggle="collapse" data-target="#collapse<?= $poste['ID_POSTE']?>" aria-expanded="false" aria-controls="collapse<?= $poste['ID_POSTE']?>" class="card-header bg-white" id="heading<?= $poste['ID_POSTE']?>">
                                                                <img  class="btn accordion-button float-left" type="button" src="<?= base_url() ?>assets/img/eyes.png">
                                                                <div class="document-description mt-3 font-weight-bold"><?= $poste['DESCRIPTION'] ?></div>
                                                            </div>
                                                            <div style="background-image: url(<?= base_url() ?>assets/img/poste_bg_trans.png); background-repeat: no-repeat; background-size: cover" id="collapse<?= $poste['ID_POSTE']?>" class="collapse" aria-labelledby="heading<?= $poste['ID_POSTE']?>" data-parent="#faqExample">
                                                                <div style="border-style: dashed; border-radius: 5px; border-width: 2px" class="card-body p-3 m-4">
                                                                    <div class="row">
                                                                        <div class="row">
                                                                            <div id="container<?=$index ?>" class="col-md-6"></div>
                                                                        </div>
                                                                        <div id="nouveau<?= $index ?>" class="col-md-12"></div> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                        </div>
                                    </div>
                                </div> -->
                            <!-- </div>/row -->
            <!-- </div> -->
            <!--container-->
                 <!-- </div> container end -->
                  <!-- </div> Visa types section end -->
</div>
<!--container-->
     </div> <!-- container end -->
      </div> <!-- Visa types section end-->




  <!-- Contacts start -->
  <?php
    //  include VIEWPATH.'includes/contact.php';
  ?>
   <!-- Contacts end -->

 <!-- footer start -->
<?php include VIEWPATH.'includes/footer.php';?>

<!-- begin button whatsapp  -->
  <?php include VIEWPATH.'includes/whatsapp.php';?>
<!-- end button whatsapp  -->


<!-- footer end -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url()?>assets/js/floating-wpp.js"></script>


<!-- Modal etablissement start -->
<div tabindex="-1" class="modal pmd-modal fade" id="etablissementmodal" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content p-4">

            <div style="background-image: url(<?=base_url()?>assets/img/blue_gradient_bg.png); background-repeat: no-repeat; background-size: cover" class="modal-header text-center">
            <div class="pmd-card-icon modal-title w-100">
                <i style="font-size:60px" class="fa fa-id-card text-white"></i><br><br>
                <h5 class="section-subtitle text-white"><?=$this->lang->line('service_mdl_visa_etabl_title')?></h5>
        </div>
            </div>

            <div class="modal-body">

                <div class="row"><p><?=$this->lang->line('service_mdl_visa_etabl_descr1')?></p></div>

      <div class="row mb-4">
          <div class="col-lg-1"><img style="margin-right: 50px" src="<?=base_url()?>assets/img/1.png"></div>
          <div class="col-lg-11 modal-title"><?=$this->lang->line('service_mdl_visa_etabl_descr2')?></div>
                </div>

                 <div class="row mb-4">
          <div class="col-lg-1"><img style="margin-right: 50px" src="<?=base_url()?>assets/img/2.png"></div>
          <div class="col-lg-11 modal-title"><?=$this->lang->line('service_mdl_visa_etabl_descr3')?></div>
                </div>


                <div class="row mb-4">
          <div class="col-lg-1"><img style="margin-right: 50px" src="<?=base_url()?>assets/img/3.png"></div>
          <div class="col-lg-11 modal-title"><?=$this->lang->line('service_mdl_visa_etabl_descr4')?></div>
                </div>


                <div class="row mb-4">
          <div class="col-lg-1"><img style="margin-right: 50px" src="<?=base_url()?>assets/img/4.png"></div>
          <div class="col-lg-11 modal-title"><?=$this->lang->line('service_mdl_visa_etabl_descr5')?></div>
                </div>

                <div class="row"><p><?=$this->lang->line('service_mdl_visa_etabl_descr6')?></p></div>


      </div>
      <div class="modal-footer justify-content-center">
        <button data-dismiss="modal" class="btn mybtn btn-split float-right" href="#"><?=$this->lang->line('service_mdl_visa_etabl_btn')?> <div class="fab"><i class="fa fa-close"></i></div></button>
      </div>
    </div>
  </div>
</div>
<!-- Modal etablissement end -->


<!-- Modal permanent start -->
<div tabindex="-1" class="modal pmd-modal fade" id="permanentmodal" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content p-4">

            <div style="background-image: url(<?=base_url()?>assets/img/blue_gradient_bg.png); background-repeat: no-repeat; background-size: cover" class="modal-header text-center">
            <div class="pmd-card-icon modal-title w-100">
                <i style="font-size:60px" class="fa fa-id-card text-white"></i><br><br>
                <h5 class="section-subtitle text-white"><?=$this->lang->line('service_mdl_visa_perm_title')?></h5>
        </div>
            </div>

            <div class="modal-body m-2">

                <div class="row"><p><?=$this->lang->line('service_mdl_visa_perm_descr1')?></p></div>

      <div class="row mb-4">
          <div class="col-lg-1"><img style="margin-right: 50px" src="<?=base_url()?>assets/img/1.png"></div>
          <div class="col-lg-11 modal-title"><?=$this->lang->line('service_mdl_visa_perm_descr2')?></div>
                </div>

                 <div class="row mb-4">
          <div class="col-lg-1"><img style="margin-right: 50px" src="<?=base_url()?>assets/img/2.png"></div>
          <div class="col-lg-11 modal-title"><?=$this->lang->line('service_mdl_visa_perm_descr3')?></div>
                </div>


                <div class="row mb-4">
          <div class="col-lg-1"><img style="margin-right: 50px" src="<?=base_url()?>assets/img/3.png"></div>
          <div class="col-lg-11 modal-title"><?=$this->lang->line('service_mdl_visa_perm_descr4')?></div>
                </div>


                <div class="row mb-4">
          <div class="col-lg-1"><img style="margin-right: 50px" src="<?=base_url()?>assets/img/4.png"></div>
          <div class="col-lg-11 modal-title"><?=$this->lang->line('service_mdl_visa_perm_descr5')?></div>
                </div>


                 <div class="row mb-4">
          <div class="col-lg-1"><img style="margin-right: 50px" src="<?=base_url()?>assets/img/5.png"></div>
          <div class="col-lg-11 modal-title"><?=$this->lang->line('service_mdl_visa_perm_descr6')?></div>
                </div>



                 <div class="row mb-4">
          <div class="col-lg-1"><img style="margin-right: 50px" src="<?=base_url()?>assets/img/6.png"></div>
          <div class="col-lg-11 modal-title"><?=$this->lang->line('service_mdl_visa_perm_descr7')?></div>
                </div>


                      <br><br>
                <div class="row"><p><?=$this->lang->line('service_mdl_visa_perm_descr8')?></p></div>


                 <div class="row mb-4">
          <div class="col-lg-1"><img style="margin-right: 50px" src="<?=base_url()?>assets/img/1.png"></div>
          <div class="col-lg-11 modal-title"><?=$this->lang->line('service_mdl_visa_perm_descr9')?></div>
                </div>

                 <div class="row mb-4">
          <div class="col-lg-1"><img style="margin-right: 50px" src="<?=base_url()?>assets/img/2.png"></div>
          <div class="col-lg-11 modal-title"><?=$this->lang->line('service_mdl_visa_perm_descr10')?></div>
                </div>


                <div class="row mb-4">
          <div class="col-lg-1"><img style="margin-right: 50px" src="<?=base_url()?>assets/img/3.png"></div>
          <div class="col-lg-11 modal-title"><?=$this->lang->line('service_mdl_visa_perm_descr11')?></div>
                </div>

                 <div class="row"><p><?=$this->lang->line('service_mdl_visa_perm_descr12')?></p></div>




      </div>
      <div class="modal-footer justify-content-center">
        <button data-dismiss="modal" class="btn mybtn btn-split float-right" href="#"><?=$this->lang->line('service_mdl_visa_perm_btn')?><div class="fab"><i class="fa fa-close"></i></div></button>
      </div>
    </div>
  </div>
</div>
<!-- Modal permanent end -->
<!-- ChartJS -->
<script src="<?=base_url()?>plugins/chart.js/Chart.min.js"></script>
<!-- Hichart -->
<script src="<?=base_url()?>plugins/highcharts/highcharts.js"></script>
<script src="<?=base_url()?>plugins/highcharts/modules/sunburst.js"></script>
<script src="<?=base_url()?>plugins/highcharts/modules/exporting.js"></script>
<script src="<?=base_url()?>plugins/highcharts/modules/xrange.js"></script>
<script src="<?=base_url()?>plugins/highcharts/modules/export-data.js"></script>
<script src="<?=base_url()?>plugins/highcharts/highcharts-3d.js"></script>


</body>
</html>

<script type="text/javascript">
 $( document ).ready(function() {
    get_rapport();
    // alert();
});   
function get_i() {

    $('#jour').html('');
    $('#heure').html('');
    get_rapport();
   
}
</script>
<script type="text/javascript">
    
function get_m() {

    $('#heure').html('');
    get_rapport();
   
}
let lastCheckTime = new Date(); // Stocke la dernière date de vérification
function checkForNewVotes() {
        $.ajax({
            url: 'Home/check_newVote', // URL de ma endpoint
            dataType: 'json',
            method: 'POST',
            data: { lastCheck: lastCheckTime }, // Envoie la dernière date de vérification
            success: function(data) {
                if (data.newVotes) {
                      lastCheckTime = new Date(); // Ou utilisez une date d'insertion spécifique
                      get_rapport();
                }
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors de la récupération des votes :', error);
            }
        });
    }

    // Vérifie chaque 10 secondes
    setInterval(checkForNewVotes, 1000);

    function clickedDiv(id,index){

        $.ajax({
        url : "<?=base_url()?>Home/get_poste/",
        type : "POST",
        dataType: "JSON",
        cache:false,
        data:{
            ID_POSTE:id,
            index:index
        },
        success:function(data){   
            $('#container'+ index).html("");             
            $('#nouveau'+ index).html(data.rapp);
        },            

        });  
}
function get_rapport(){ 

var CANDIDAT=$('#CANDIDAT').val();
var ELECTEUR=$('#ELECTEUR').val();
var mois=$('#mois').val();  
var jour=$('#jour').val();
var heure=$('#heure').val();  
var IS_PAID=$('#IS_PAID').val();
var ID_POSTE=$('#ID_POSTE').val();





$.ajax({
url : "<?=base_url()?>Home/get_rapport",
type : "POST",
dataType: "JSON",
cache:false,
data:{
CANDIDAT:CANDIDAT,
ELECTEUR:ELECTEUR,  
mois:mois,
jour:jour,  
heure:heure,
IS_PAID:IS_PAID,
ID_POSTE:ID_POSTE,
 
},
success:function(data){   
$('#container').html("");             
$('#nouveau').html(data.rapp );
$('#container0').html("");             
$('#nouveau0').html(data.rapp0 );
$('#container4').html("");             
$('#nouveau4').html(data.rapp4 );
$('#container1').html("");             
$('#nouveau1').html(data.rapp1 );
$('#container6').html("");             
$('#nouveau6').html(data.rapp2 );
$('#container5').html("");             
$('#nouveau5').html(data.rapp3 );

},            

});  
}

</script> 