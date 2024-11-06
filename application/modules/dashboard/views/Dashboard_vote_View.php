<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH.'templates/header.php'; ?>


<style type="text/css">
 .mapbox-improve-map{
  display: none;
}

.leaflet-control-attribution{
  display: none !important;
}
.leaflet-control-attribution{
  display: none !important;
}


.mapbox-logo {
  display: none;
}
</style>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include VIEWPATH.'templates/navbar.php'; ?>

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include VIEWPATH.'templates/sidebar.php'; ?>
 <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
         <div class="col-sm-6 p-md-0">
 <div class="welcome-text">
    <h4 style='color:#FFFFFF'>Tableau de bord des statistiques électorales</h4>

     </div>
    </div>
       </div><!-- /.container-fluid -->
     </div>
     <!-- /.content-header -->
<div class="col-md-12 col-xl-12 grid-margin stretch-card">
<div class="row column1">
  <div class="col-md-12">
   <div class="white_shd full margin_bottom_10">
    <div class="full graph_head">
      <div class="row" style="margin-top: 0px">
      <!-- <div class="form-group col-md-3">
      </div> -->
<div class="form-group col-md-4">
<label style='color:#FFFFFF'>Poste</label>
<select class="form-control"  onchange="get_rapport()" name="ID_POSTE" id="ID_POSTE">
       <option value="">Sélectionner</option>
<?php

foreach ($categorie as $value){
if ($value['ID_POSTE'] == set_value('ID_POSTE'))
{?>
<option value="<?=$value['ID_POSTE']?>" selected><?=$value['DESCRIPTION']?></option>
<?php } else{ 
 ?>
<option value="<?=$value['ID_POSTE']?>" ><?=$value['DESCRIPTION']?></option>
<?php } } ?>
      </select>
    </div>
 
<div class="form-group col-md-4">
 
 <label style='color:#FFFFFF'>Candidat</label>
    <div class="input-group mb-3">
     <input type="text" class="form-control" name="CANDIDAT"  id="CANDIDAT"  placeholder="Recherche" value="<?=set_value('CANDIDAT')?>">
    <div class="input-group-prepend">
    <span class="input-group-text"><a href="#" onclick="get_rapport()"><i class="fa fa-search" aria-hidden="true"></i></a></span>
    </div>
     </div>
</div>
<div class="form-group col-md-4">
 
    <label style='color:#FFFFFF'>Electeur</label>
    <div class="input-group mb-3">
      <input type="text" class="form-control " name="ELECTEUR"  id="ELECTEUR"  placeholder="Recherche" value="<?=set_value('ELECTEUR')?>">
      <div class="input-group-prepend">
        <span class="input-group-text"><a href="#" onclick="get_rapport()"><i class="fa fa-search" aria-hidden="true"></i></a></span>
      </div>
    </div>
</div>
<!-- <div class="form-group col-md-3">
</div> -->


     


     </div>
   </div>
  </div>
 </div>
</div>


<div class="row">
  <div class="col-md-12" style="margin-bottom: 20px"></div>
  <div id="container1"  class="col-md-6"  ></div>
  <div id="container2"  class="col-md-6"  ></div>
  <div class="col-md-12" style="margin-bottom: 20px"></div>
  <div id="container3"  class="col-md-12"  ></div>
  <div id="container4"  class="col-md-6"  ></div>
  <div class="col-md-12" style="margin-bottom: 20px"></div>
  
</div>
</div>
</div>


<div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg" style ="width:1000px">
          <div class="modal-content  modal-lg">
            <div class="modal-header">
              <h4 class="modal-title"><span id="titre"></span></h4>
            </div>
            <div class="modal-body">
              <div class="table-responsive">
                <table id='mytable' class='table table-bordered table-striped table-hover table-condensed' style="width:1000px">
                  <thead>
                      <th>#</th>
                      <th>CANDIDAT</th>
                      <th>CONTACT</th>
                      <th>CNI</th>
                      <th>SEXE</th>
                      <th>DATE DE NAISSANCE</th>
                      <th>LIEU DE NAISSANCE</th>
                      <th>PARTIE POLITIQUE</th>
                  </thead>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Quitter</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="myModal1" role="dialog">
        <div class="modal-dialog modal-lg" style ="width:1000px">
          <div class="modal-content  modal-lg">
            <div class="modal-header">
              <h4 class="modal-title"><span id="titre1"></span></h4>
            </div>
            <div class="modal-body">
              <div class="table-responsive">
                <table id='mytable1' class='table table-bordered table-striped table-hover table-condensed' style="width:1000px">
                  <thead>
                      <th>#</th>
                      <th>CANDIDAT</th>
                      <th>CONTACT</th>
                      <th>CNI</th>
                      <th>SEXE</th>
                      <th>DATE DE NAISSANCE</th>
                      <th>LIEU DE NAISSANCE</th>
                  </thead>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Quitter</button>
            </div>
          </div>
        </div>
      </div>
       





</div>
</div></div></div>
<div id="nouveau">
</div>
<div id="nouveau1">
</div>
<div id="nouveau2">
</div>
<div id="nouveau3">
</div>
<div id="nouveau4">
</div>
<div id="nouveau0">
</div>

</div>



    

<?php include VIEWPATH.'templates/footer.php'; ?>
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
</script>

<script> 
function get_rapport(){ 

var CANDIDAT=$('#CANDIDAT').val();
var ELECTEUR=$('#ELECTEUR').val();
var mois=$('#mois').val();  
var jour=$('#jour').val();
var heure=$('#heure').val();  
var IS_PAID=$('#IS_PAID').val();
var ID_POSTE=$('#ID_POSTE').val();





$.ajax({
url : "<?=base_url()?>dashboard/Dashboard_vote/get_rapport",
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
$('#container2').html("");             
$('#nouveau2').html(data.rapp2 );
$('#container3').html("");             
$('#nouveau3').html(data.rapp3 );
$('#jour').html(data.select_month);
$('#heure').html(data.selectjour);
},            

});  
}

</script> 