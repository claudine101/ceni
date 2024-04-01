<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include VIEWPATH . 'templates/navbar.php'; ?>
    <!-- Main Sidebar Container -->
    <?php include VIEWPATH . 'templates/sidebar.php'; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-9">

              <h4 class="m-0"><?= $title ?></h4>
            </div><!-- /.col -->

            <div class="col-sm-3">
              <a href="<?= base_url('PSR/Controle/index') ?>" class='btn btn-primary float-right'>
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

                <form name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Controle/update'); ?>">

                  <div class="row">
                    <input type="hidden" class="form-control" name="ID_CONTROLE" value="<?= $controles['ID_CONTROLE'] ?>">


                    <div class="col-md-6">
                      <label for="Ftype">Plaque</label>
                      <select class="form-control" name="NUMERO_PLAQUE" id="NUMERO_PLAQUE">

                        <?php

                        foreach ($plaques as $value) {

                          $selected = "";
                          if ($value['NUMERO_PLAQUE'] == $controles['NUMERO_PLAQUE']) {
                            $selected = "selected";
                          }
                        ?>
                          <option value="<?= $value['NUMERO_PLAQUE'] ?>" <?= $selected ?>><?= $value['NUMERO_PLAQUE'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <?php echo form_error('NUMERO_PLAQUE', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <div class="col-md-6">
                      <label for="FName">N° contrôle</label>
                      <input type="text" name="NUMERO_CONTROLE" autocomplete="off" id="NUMERO_CONTROLE" value="<?= $controles['NUMERO_CONTROLE'] ?>" class="form-control">

                      <?php echo form_error('NUMERO_CONTROLE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName">N° Chassis</label>
                      <input type="text" name="NUMERO_CHASSIS" autocomplete="off" id="NUMERO_CHASSIS" value="<?= $controles['NUMERO_CHASSIS'] ?>" class="form-control">

                      <?php echo form_error('NUMERO_CHASSIS', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName"> Propriètaire</label>
                      <input type="text" name="PROPRIETAIRE" autocomplete="off" id="PROPRIETAIRE" value="<?= $controles['PROPRIETAIRE'] ?>" class="form-control">

                      <?php echo form_error('PROPRIETAIRE', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="col-md-6">
                      <label for="FName"> Début</label>
                      <input type="date" name="DATE_DEBUT" autocomplete="off" id="DATE_DEBUT" value="<?= date("Y-m-d", strtotime($controles['DATE_DEBUT'])) ?>" class="form-control">

                      <?php echo form_error('DATE_DEBUT', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName"> Date validité</label>
                      <input type="date" name="DATE_VALIDITE" autocomplete="off" id="DATE_VALIDITE" value="<?= date("Y-m-d", strtotime($controles['DATE_VALIDITE'])) ?>" class="form-control">

                      <?php echo form_error('DATE_VALIDITE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName"> Type de véhicule</label>
                      <input type="text" name="TYPE_VEHICULE" autocomplete="off" id="TYPE_VEHICULE" value="<?= $controles['TYPE_VEHICULE'] ?>" class="form-control">

                      <?php echo form_error('TYPE_VEHICULE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                  </div>

                  <div class="col-md-6" style="margin-top:31px;">
                    <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Modifier</button>
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

<?php include VIEWPATH . 'templates/footer.php'; ?>