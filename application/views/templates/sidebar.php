

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<style type="text/css">
  .bordersolid {
    border-style: solid;
    border-color: gray;
    border-width: 1px;
  }

  .tooltipp {
    display: inline-block;
    position: relative;
    border-bottom: 1px dotted #666;
    text-align: left;
  }

  .tooltipp .topp {
    min-width: 200px;
    top: -20px;
    left: 50%;
    transform: translate(-50%, -100%);
    padding: 10px 20px;
    color: #111111;
    background-color: #EEEEEE;
    font-weight: normal;
    font-size: 13px;
    border-radius: 8px;
    position: absolute;
    z-index: 99999999;
    box-sizing: border-box;
    box-shadow: 0 1px 8px #FFFFFF;
    display: none;
  }

  .tooltipp:hover .topp {
    display: block;
  }

  .tooltipp .topp i {
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -12px;
    width: 24px;
    height: 12px;
    overflow: hidden;
  }

  .tooltipp .topp i::after {
    content: '';
    position: absolute;
    width: 12px;
    height: 12px;
    left: 50%;
    transform: translate(-50%, -50%) rotate(45deg);
    background-color: #EEEEEE;
    box-shadow: 0 1px 8px #FFFFFF;
  }

  .content-wrapper {
    /*background-color: #312f568f;*/
    background-image: url('<?= base_url() ?>/upload/Artboard.png');
    background-size: cover;
    background-repeat: no-repeat;
    height: 100%;
    margin: 0;
    padding: 0;
  }

  #title {
    color: #fff;
  }

  h1 {
    color: #fff;
  }

  h4 {
    color: #fff;
  }

  h5 {
    color: #000;
  }

  h3 {
    color: #fff;
  }

  h2 {
    color: #fff;
  }

  .list-group-item-heading {
    color: #000;
  }

  strong {
    color: #000;
  }

  .dataTables_filter < label{
    float: left;
  }
  .nav-item{
    font-size: 14px;
  }

  td,th{
    font-size: 14px;
  }

  #imageLogo{
  width: 26px;
  height: 26px;
  border-radius: 50%;
}
.hidden {
    display: none;
}

#statusIndicator {
    margin: 20px;
    font-size: 24px; /* Ajustez la taille des icônes ici */
}

#connectionStatus {
    color: white; /* Couleur du texte */
}

#statusIcon {
    color: green; /* Couleur de l'icône */
}
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <?php $image = !empty($this->session->userdata('ICON_LOGO')) ? $this->session->userdata('ICON_LOGO') : "testImage.webp";


         if ($this->session->userdata('PROFIL_ID') == 2) {

        $inputs = $this->session->userdata('ID_INSTITUTION');

        $condition =  " AND ID_ASSUREUR =".$inputs;


        $assureur = $this->Model->getRequeteOne('SELECT ID_ASSUREUR, ASSURANCE,ICON_LOGO FROM assureur WHERE 1 '.$condition.'  ORDER BY ASSURANCE ASC');

        $icon_logo = $this->Model->getRequeteOne('SELECT ICON_LOGO FROM assureur WHERE ID_ASSUREUR='.$inputs);
        
        $assureur = $assureur['ASSURANCE'];
        $logo = $icon_logo['ICON_LOGO'];


       }else{
        
       $assureur = "";
       $logo=!empty($this->session->userdata('ICON_LOGO')) ? $this->session->userdata('ICON_LOGO') : "testImage.webp";
       }

   ?>

   <?php if ($this->session->userdata('PROFIL_ID') == 2) { ?>
        <!-- <a href="#" class="d-block"><img src="<?= $image ?>" id="imageLogo"> <?= $assureur ?> </a> -->
         <img height="13.5%" width="100%" src="<?= $logo?>" alt="" class="brand-image">
        <?php }else{  ?>
        
         <img height="13.5%" width="100%" src="<?= base_url() ?>upload/logo.png" alt="" class="brand-image">
         <?php } ?>
<!-- <?= $assureur ?> -->
 
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
          <?php if (!empty($this->session->userdata('ICON_LOGO'))) { ?>
        <a href="#" class="d-block"><img src="<?= $this->session->userdata('ICON_LOGO')?>" id="imageLogo">  <?= $this->session->userdata('USER_NAME') ?> </a>
        <?php }else{  ?>
        <a href="#" class="d-block"><i class="fa fa-user"></i> <?= $this->session->userdata('USERNAME') ?></a>

         <?php } ?>
      </div>
      <!--  <div class="info">
       
      </div> -->
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">


      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
      <a href="<?= base_url('dashboard/Dashboard_vote/index') ?>" class="nav-link <?php if ($this->router->class == 'Dashboard_vote') echo 'active'; ?>">
          <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Tableau de bord 
              </p>
            </a>
            </li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if ($this->router->class == 'Utilisateurs'  || $this->router->class == 'Profils' || $this->router->class == 'Droit') echo 'active'; ?>">
              <i class="nav-icon fa fa-user-md"></i>
              <p>
                Administration
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('administration/Utilisateurs/index') ?>" class="nav-link <?php if ($this->router->class == 'Utilisateurs') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Utilisateurs </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('administration/Profils/index') ?>" class="nav-link <?php if ($this->router->class == 'Profils') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profils</p>
                </a>
              </li>

             
            
                <li class="nav-item">
                  <a href="<?= base_url('administration/Droit/index') ?>" class="nav-link <?php if ($this->router->class == 'Droit') echo 'active'; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Droits</p>
                  </a>
                </li>

            </ul>

          </li>
          <!-- IHM -->

          <li class="nav-item">
            <a href="#" class="nav-link <?php if ($this->router->class == 'Postes'||$this->router->class =='Partie_politique'||$this->router->class =='Provinces'||$this->router->class =='Communes' ||$this->router->class =='Zones' ||$this->router->class =='Collines') echo 'active'; ?>">
              <i class="nav-icon fa fa-desktop"></i>
              <p>
                IHM
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="<?= base_url('ihm/Partie_politique/index') ?>" class="nav-link <?php if ($this->router->class == 'Partie_politique') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Partie politiques</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('ihm/Postes/index') ?>" class="nav-link <?php if ($this->router->class == 'Postes') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Postes </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('ihm/Provinces/index') ?>" class="nav-link <?php if ($this->router->class == 'Provinces') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Provinces </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('ihm/Communes/index') ?>" class="nav-link <?php if ($this->router->class == 'Communes') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Communes </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('ihm/Zones/index') ?>" class="nav-link <?php if ($this->router->class == 'Zones') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Zones </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('ihm/Collines/index') ?>" class="nav-link <?php if ($this->router->class == 'Collines') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Collines </p>
                </a>
              </li>

            </ul>
          </li>
  <!-- DONNNEES -->
    <li class="nav-item">
            <a href="#" class="nav-link <?php if ($this->router->class == 'Candidats'||$this->router->class == 'Electeurs') echo 'active'; ?>">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Données
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="font-size: 12px;">
              
                <li class="nav-item">
                  <a href="<?= base_url('donnees/Candidats/index') ?>" class="nav-link <?php if ($this->router->class == 'Candidats') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                    <!-- <i class="nav-icon fas fa-user-circle" style="color:green"></i> -->
                    <p>
                       Candidats
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('donnees/Electeurs/index') ?>" class="nav-link <?php if ($this->router->class == 'Electeurs') echo 'active'; ?>">
                    <!-- <i class="nav-icon fas fa-user-circle" style="color:green"></i> -->
                  <i class="far fa-circle nav-icon"></i>
                    <p>
                       Electeurs
                    </p>
                  </a>
                </li>
            </ul>
          </li>
      
 <!-- CONFIGURATION -->

  <li class="nav-item">
          <a href="#" class="nav-link <?php if ($this->router->class == 'Session_vote') echo 'active'; ?>">

              <i class="nav-icon fa fa-history"></i>
              <p>
                Configuration
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="<?= base_url('ihm/Session_vote/index') ?>" class="nav-link <?php if ($this->router->class == 'Session_vote') echo 'active'; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Session de vote</p>
                  </a>
                </li>
               
            </ul>
          </li>
          <li class="nav-item">
          <a href="javascript:void(0)" id="withdrawGuichet" class="nav-link">

          <i class="fas fa-toggle-on"></i> 
              <p>
               Activer les guichets</p>
            </a>
            </li>
            <i class=""></i> 
                <div id="statusIndicator">
                    <span id="connectionStatus" class="hidden">Connexion : <i id="statusIcon" class="fas"></i></span>
              </div>
            </li>


</ul>

    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>




<div class="modal fade" id="ImageConstatr" style="z-index: 1111111;">
       <div class="modal-dialog modal-lg" >
         <div class="modal-content">
           <div class="modal-header" style="background: black;">
           <!--  <div id="title"><b><h4 id="" style="color:#fff;font-size: 18px;"></h4>
              
            </div> -->
            <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </div>
         </div>
         <div class="modal-body">

           <div class="col-md-12" id="imageGet">
                        </div>
      </div>
      <div class="modal-footer"> 
          
      </div>
    </div>
  </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let isConnecting = false;
        let isConnected = false;

        function updateStatusIndicator() {
            // Afficher le conteneur du statut de connexion
            $('#connectionStatus').removeClass('hidden');
            
            if (isConnecting) {
                console.log("WebSocket is connecting...");
                $('#statusIcon').removeClass('fas fa-check-circle fa-times-circle').addClass('fas fa-spinner fa-pulse'); // Icône de chargement
                $('#isConn').addClass('hidden'); // Cacher le conteneur lors de la connexion
            } else if (isConnected) {
                console.log("WebSocket connection opened");
                $('#statusIcon').removeClass('fas fa-spinner fa-pulse fa-times-circle').addClass('fas fa-check-circle'); // Icône de connecté
                $('#isConn').removeClass('hidden'); // Afficher le conteneur lorsque connecté
            } else {
                console.log("WebSocket connection closed");
                $('#statusIcon').removeClass('fas fa-spinner fa-pulse fa-check-circle').addClass('fas fa-times-circle'); // Icône de déconnecté
                $('#isConn').addClass('hidden'); // Cacher le conteneur lorsque déconnecté
            }
        }

        // Simuler le début de la connexion
        isConnecting = true;
        updateStatusIndicator();

        // Créer la connexion WebSocket
        const ws = new WebSocket("ws://192.168.137.181/ws");

        ws.onopen = function() {
            isConnected = true;
            isConnecting = false;
            updateStatusIndicator();
        };

        ws.onmessage = function(event) {
            console.log("Message received: ", event.data);
        };

        ws.onerror = function(error) {
            console.log("WebSocket error: ", error);
            isConnecting = false;
            updateStatusIndicator();
        };

        ws.onclose = function() {
            isConnected = false;
            isConnecting = false;
            updateStatusIndicator();
        };

        // Mettre à jour l'indicateur de statut initial
        updateStatusIndicator();
    });
</script>
  <script type="text/javascript">
    
    function get_imag(src) {
      
      $('#ImageConstatr').modal()
      $('#imageGet').html('<img src="'+src+'" width="100%" >')
    }

    const withdrawGuichet = document.getElementById("withdrawGuichet");
    withdrawGuichet.addEventListener("click", () => {
            console.log("Ok");
            // const message = "enrollRFID";
            const message = "activeGuichet";

            // ws.send(${authenticationToken}:${message});  
            ws.send(`${authenticationToken}:${message}`);
        });

  </script>