<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH.'templates/header.php';?>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include VIEWPATH.'templates/navbar.php'; ?>
    <!-- Main Sidebar Container -->
    <?php include VIEWPATH.'templates/sidebar.php'; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-9">
              <h4 class="m-0"><?=$title?></h4>
            </div><!-- /.col -->
            <div class="col-sm-3">
              <a href="<?=base_url('ihm/Partie_politique/index')?>" class='btn btn-primary float-right'>
                <i class="nav-icon fas fa-list ul"></i>
                Liste
              </a>
            </div><!-- /.col -->
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="col-md-12 col-xl-12 grid-margin stretch-card">

          <div class="card">
            <div class="card-body">

              <div class="col-md-12">

               <form enctype="multipart/form-data"  name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/Partie_politique/update'); ?>" >

                <div class="row">
                <div class="col-md-6">
                      <label for="FName">Designation</label>
                      <input type="tel" name="DESIGNATION" autocomplete="off" id="DESIGNATION"  value="<?= $data['DESIGNATION'] ?>" class="form-control">

                      <?php echo form_error('DESIGNATION', '<div class="text-danger">', '</div>'); ?>

                    </div>
                  <div class="col-md-6">

                    <input type="hidden" class="form-control" name="ID_PARTIE_POLITIQUE" value="<?=$data['ID_PARTIE_POLITIQUE']?>" >
                    <label for="FName">Description</label>
                    <input type="text" name="DESCRIPTION" value="<?=$data['DESCRIPTION'] ?>"  id="DESCRIPTION" class="form-control">

                    <?php echo form_error('DESCRIPTION', '<div class="text-danger">', '</div>'); ?> 

                  </div>
                  <div class="col-md-6">
                      <label for="FName">Téléphone</label>
                      <input type="tel" name="TELEPHONE" autocomplete="off" id="TELEPHONE"  value="<?= $data['TELEPHONE'] ?>" class="form-control">

                      <?php echo form_error('TELEPHONE', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="FName"> Email</label>
                      <input type="text" name="EMAIL" autocomplete="off" id="EMAIL" value="<?= $data['EMAIL'] ?>" class="form-control">

                      <?php echo form_error('EMAIL', '<div class="text-danger">', '</div>'); ?>
                    </div>
                
                    <div class="col-md-6 row">
                      <div class="col-md-1">
                        <label for="text" style="font-size: 10px;top:" id="fileName"></label></BR>
                        <label class="label" data-toggle="tooltip" title="Attacher un fichier">
                          <font style="font-size: 40PX;color: green"><i class="fas fa-image rounded" id="avatar" alt="avatar"></i></font>
                          <input type="file" class="sr-only" id="PHOTO" name="PHOTO" accept="image/*" >
                        </label>
                      </div>

                       <div class="col-md-6" style="margin-top:-8px">
                        <label for="text" style="font-size: 100px;" id="fileName"></label>
                        <div class="col-md-12" style="margin-top:-8px;margin-left:10px" style="margin-top: 5px" id="resultGet"></div>                   
                      </div>
                    </div>
                    <div class="col-md-12" style="margin-top:31px;">
                      <!-- <a href="#" class="next">suivant &raquo;</a>
                      <button type="button" style="float: right;" onclick='suivant()' class="btn btn-primary"><span class="fas fa-save"></span> suivant</button> -->
                      <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Enregistrer</button>
                    </div>
                  </div>
                   </div>


                  <!-- SUIVANT -->
                  
                   </div>
                </form>
              </div>
            </div>

          </div>
        </div>

      </section>
    </div>
  </div>
</body>



<!-- MODAL IMAGE CAMERA -->



  <div class='modal fade' id='PaiementModal'>
    <div class='modal-dialog modal-lg'>
      <div class='modal-content'>
        <div class="modal-header" style="background-color: #000;color: #fff;">
          <h5 class="modal-title" id="staticBackdropLabel"></h5>
          <span class="btn btn-default btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></span>
        </div>
        <div class='modal-body'>
          <center>
            <video id="video" width="500"  height="480" autoplay style="border: 1px solid black;"></video>
            <canvas id="canvas" width="500" height="480" ></canvas>
          </center>
        </div>
        <div class='modal-footer'><center>
          <span id="changeMode" style=""><button onclick="canvasGet()" class='btn btn-warning btn-md' type="button">Capturer</button></span>
          <button class='btn btn-default btn-md'  onclick="cameraGetNew()">Annuler</button></center>

          <!--  data-dismiss='modal' -->
        </div>
      </div>
    </div>
  </div>

<?php include VIEWPATH . 'templates/footer.php'; ?>

<script type="text/javascript">
  $(document).ready(function() {
    add();
  });
  $('#canvas').hide()
 function add(){
  $('#add').show()
  $('#suivant').hide()
  $('titleNouveau').hide()
  $('titleAffectation').hide()
  }
  function suivant(){
  $('#add').hide()
  $('#suivant').show()
  $('titleNouveau').hide()
  $('titleAffectation').hide()
  }

function cameraGetNew(){
  $('#video').show()
  $('#canvas').hide()
  $('#changeMode').html('<button onclick="canvasGet()" class="btn btn-warning btn-md" type="button">Capturer</button>')
}

function convertCanvasToImage() {
  var canvas = document.getElementById('canvas');
  var image = new Image();
  image.id = "imageGet"
  image.src = canvas.toDataURL("image/png");
  var type = 'image/png';
  var imgName = generate_code(7)+".png";
  download(canvas.toDataURL("image/png"), imgName);
  // $('#PHOTO').val(image);
  console.log(image)
  $('#ImageLink').val(canvas.toDataURL("image/png"));
  $('#resultGet').html(image);
}
function cameraGet(){
  $('#video').show()
  $('#canvas').hide()

  var video = document.getElementById('video');
  // Get access to the camera!
  if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
      // Not adding `{ audio: true }` since we only want video now
      navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
          //video.src = window.URL.createObjectURL(stream);
          video.srcObject = stream;
          video.play();
      });
  }
}

function canvasGet(){

  var canvas = document.getElementById('canvas');
  var context = canvas.getContext('2d');
  var video = document.getElementById('video');
  context.drawImage(video, 0, 0, 500, 480);

  $('#video').hide()
  $('#canvas').show()
  $('#changeMode').html('<button onclick="convertCanvasToImage()" class="btn btn-success" data-dismiss="modal" type="button">Terminer</button>')
}
function download(dataurl, filename) {
  const link = document.createElement("a");
  link.href = dataurl;
  link.download = filename;
  link.click();
}



function generate_code(taille=0){

    var Caracteres = '0123456789'; 
    var QuantidadeCaracteres = Caracteres.length; 
    QuantidadeCaracteres--; 
    var Hash= ''; 
      for(var x =1; x <= taille; x++){ 
          var Posicao = Math.floor(Math.random() * QuantidadeCaracteres);
          Hash +=  Caracteres.substr(Posicao, 1); 
      }
      return "25"+Hash; 
}

</script>
<script>
  get_test()
  function get_communes(){
    var PROVINCE_ID = $('#PROVINCE_ID').val();
    if (PROVINCE_ID == '') {
      $('#COMMUNE_ID').html('<option value="">---Sélectionner---</option>');
      $('#ZONE_ID').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    }
    else { 
      $('#ZONE_ID').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_communes/" + PROVINCE_ID,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#COMMUNE_ID').html(data);
        }
      });
    }
  }

  function get_zones() {
    var COMMUNE_ID = $('#COMMUNE_ID').val();
    if (COMMUNE_ID == '') {
      $('#ZONE_ID').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_zones/" + COMMUNE_ID,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ZONE_ID').html(data);
        }
      });

    }
  }
  function get_collines(){
    var ZONE_ID = $('#ZONE_ID').val();
    if (ZONE_ID == '') {
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    } else {
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_collines/" + ZONE_ID,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_COLLINE').html(data);
        }
      });

    }
  }

 function get_communes_affectation(){
    var PROVINCE_ID_AFFECTATION = $('#PROVINCE_ID_AFFECTATION').val();
    if (PROVINCE_ID_AFFECTATION == '') {
      $('#COMMUNE_ID_AFFECTATION').html('<option value="">---Sélectionner---</option>');
      $('#ZONE_ID_AFFECTATION').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE_AFFECTATION').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#ZONE_ID').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_communes/" + PROVINCE_ID_AFFECTATION,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#COMMUNE_ID_AFFECTATION').html(data);
        }
      });

    }
  }
  function get_zones_affectation() {
    var COMMUNE_ID_AFFECTATION = $('#COMMUNE_ID_AFFECTATION').val();
    if (COMMUNE_ID_AFFECTATION == '') {
      $('#ZONE_ID_AFFECTATION').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE_AFFECTATION').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#ID_COLLINE_AFFECTATION').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_zones/" + COMMUNE_ID_AFFECTATION,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ZONE_ID_AFFECTATION').html(data);
        }
      });

    }
  }


  function get_collines_affectation() {
    var ZONE_ID_AFFECTATION = $('#ZONE_ID_AFFECTATION').val();
    alert(ZONE_ID)
    if (ZONE_ID == '') {
      $('#ID_COLLINE_AFFECTATION').html('<option value="">---Sélectionner---</option>');
    } else {
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_collines/" + ZONE_ID_AFFECTATION,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_COLLINE_AFFECTATION').html(data);
        }
      });

    }
  }
  //  function get_test()
  // {
  //    alert()

  //     $.ajax(
  //     {
  //       url:"https://api.eacpass.eac.int/data-integration/api/check",
  //       type:"GET",
  //       dataType:"JSON",
  //       success: function(data)
  //       {        
  //         console.log(data)
  //       }
  //     });


  // }
</script>
<script type="text/javascript">
  function readURL(input) {

    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        //alert(e.target.result);
        $('#buttonFile').delay(100).show('hide');
        let myArr = e.target.result;
        const myArrData = myArr.split(":");
        let deux_name = myArrData[1].split("/");

        if (deux_name[0] == 'image') {
          var back_lect = '<img  height="80" src="' + e.target.result + '">';
          $('#resultGet').html(back_lect);
        } else {
          $('#resultGet').html('');
        }

      }

      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }

  $("#PHOTO").change(function() {
    readURL(this);
  });
</script>

<script type="text/javascript">
  $(function() {
    var dtToday = new Date();

    var month = dtToday.getMonth() + 1; // jan=0; feb=1 .......
    var day = dtToday.getDate();
    var year = dtToday.getFullYear() - 18;
    if (month < 10)
      month = '0' + month.toString();
    if (day < 10)
      day = '0' + day.toString();
    var minDate = year + '-' + month + '-' + day;
    var maxDate = year + '-' + month + '-' + day;
    $('#DATE_NAISSANCE').attr('max', maxDate);
  });
</script>