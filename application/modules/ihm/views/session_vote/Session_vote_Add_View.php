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
               <?= $this->session->flashdata('message'); ?>
              <div class="col-md-12">

                <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/Session_vote/add'); ?>" >

                 <div class="row">
                
                    <div class="col-md-6">
                      <label for="Ftype">Postes</label>
                      <select class="form-control" name="ID_POSTE" id="ID_POSTE">
                        <option value="">---Sélectionner---</option>
                        <?php
                        foreach ($postes as $value) {
                        ?>
                          <option value="<?= $value['ID_POSTE'] ?>"><?= $value['DESCRIPTION'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <!-- <div><font color="red" id="error_province"></font></div>  -->
                      <?php echo form_error('ID_POSTE', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="col-md-6">
                      <label for="FName">Date de début</label>
                      <input type="datetime-local" name="DATE_DEBUT" autocomplete="off" id="DATE_DEBUT" value="<?= set_value('DATE_DEBUT') ?>" class="form-control">

                      <?php echo form_error('DATE_DEBUT', '<div class="text-danger">', '</div>'); ?>
                    </div>

                </div>
                <div class="row">
               
                    <div class="col-md-6">
                      <label for="FName"> Date fin</label>
                      <input type="datetime-local" name="DATE_FIN" autocomplete="off" id="DATE_FIN" value="<?= set_value('DATE_FIN') ?>" class="form-control">

                      <?php echo form_error('DATE_FIN', '<div class="text-danger">', '</div>'); ?>
                    </div>
                 
                    <div class="col-md-6" style="margin-top:31px;">
                      <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Enregistrer</button>
                    </div>
                  </div>
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

<?php include VIEWPATH.'templates/footer.php'; ?>



                