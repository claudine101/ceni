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
              <a href="<?=base_url('PSR/Signalement_embouteillage/index')?>" class='btn btn-primary float-right'>
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
                <!--  -->

                <form  name="myform" method="post" class="form-horizontal" enctype="multipart/form-data" action="<?= base_url('PSR/Signalement_embouteillage/add'); ?>" >
                 <div class="row">

                  <div class="col-md-6">
                    <label for="FName">CHAUSSE</label>
                    <input type="text" name="CHAUSSE" autocomplete="off" id="CHAUSSE" value="<?= set_value('CHAUSSE') ?>"  class="form-control">
                    
                    <?php echo form_error('CHAUSSE', '<div class="text-danger">', '</div>'); ?> 

                  </div>

                  <div class="col-md-6">
                    <label for="FName">CAUSE</label>
                    <input type="text" name="CAUSE" autocomplete="off" id="CAUSE" value="<?= set_value('CAUSE') ?>"  class="form-control">
                    
                    <?php echo form_error('CAUSE', '<div class="text-danger">', '</div>'); ?> 

                  </div>

                   <div class="col-md-6 row">
                     <div class="col-md-6">
                      <label for="text" style="font-size: 10px;" id="fileName"></label></BR>
                      <label class="label" data-toggle="tooltip" title="Attacher un fichier">
                        <font style="font-size: 40PX;color: green" ><i class="fas fa-image rounded" id="avatar" alt="avatar"></i></font>
                        <input type="file" class="sr-only" id="IMAGE_1" name="IMAGE_1" accept="image/*" required>
                      </label>
                    </div>
                    <div class="col-md-6" style="margin-top: 5px" id="resultGet"></div>
                    
                  </div>
                </div>

                <div class="col-md-6" style="margin-top:31px;">
                  <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Enregistrer</button>
                </div>
              </div>

            </div>
          </div>

                        <!-- <div class="row">
                          
                        </div> -->
                      </form>

                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </body>

      <?php include VIEWPATH.'templates/footer.php'; ?>


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
        var back_lect = '<img  height="80" src="'+e.target.result+'">';
        $('#resultGet').html(back_lect);
      }else{
        $('#resultGet').html('');
      }
      
    }
    
     reader.readAsDataURL(input.files[0]); // convert to base64 string
   }
 }

 $("#IMAGE_1").change(function() {
   readURL(this);
 });

</script>