<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>

<body class="hold-transition sidebar-mini layout-fixed">

<style type="text/css">
       #imageGet{
        width: 100px;
        height: 100px;
       }
       .loading-icon {
            font-size: 20px; /* Taille de l'icône */
            animation: spin 1s linear infinite; /* Animation de rotation */
            color: white; /* Couleur de l'icône */
        }
        .hidden {
            display: none;
      }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        } 
       
     </style>

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
            <div class="col-sm-6">
              <div id="titleNouveau"><h4  class="m-0"><?= $title ?></h4></div>
            </div><!-- /.col -->
       
             <!-- Bouton  activer les guichet -->
              <div class="col-sm-2 "  id="guichet">
              <a href="javascript:void(0)" class='btn btn-primary float-right' id="guichets" >
              <!-- <i class="fa fa-toggle-on" style="color: green;"></i> -->
              <i class="fa fa-toggle-off" style="color: red;"></i>
                Activer  les guichets
              </a>
            </div><!-- /.col -->
            <!-- isconnect -->
              <div class="col-sm-2 hidden"  id="notConn">
              <a href="javascript:void(0)" class='btn btn-primary float-right' >
                <i class="fas fa-spinner  loading-icon" ></i>
                is connecting......
              </a>
            </div><!-- /.col -->
            <!-- notconnect -->
            <div class="col-sm-2 hidden"  id="isConn">
              <a href="javascript:void(0)" class='btn btn-primary float-right' id="withdrawMoney">
                <!-- <i class="nav-icon fas fa-list ul"></i> -->
                <i class="fas fa-id-card " ></i>
                <span id="buttonText"></span>
              </a>
            </div><!-- /.col -->
            <div class="col-sm-2 hidden"  id="isClose">
              <a href="javascript:void(0)" class='btn btn-primary float-right' id="">
                <!-- <i class="nav-icon fas fa-list ul"></i> -->
                <i class="fas fa-exclamation-circle " ></i>
                 is close
              </a>
            </div><!-- /.col -->
            
            <div class="col-sm-2" >
              <a href="<?= base_url('donnees/Electeurs/index') ?>" class='btn btn-primary float-right'>
                <i class="nav-icon fas fa-list ul"></i>
                Liste
              </a>
            </div><!-- /.col -->
            <!-- </div> -->
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

                <form enctype="multipart/form-data" name="myform" method="post" class="form-horizontal" action="<?= base_url('donnees/Electeurs/add'); ?>">
                  <div id="add">
                    <div class="row">
                      <div class="col-md-12">
                      <label for="FName">ID</label>
                      <input type="text" disabled  name="receivedUIDIS" autocomplete="off" id="receivedUIDIS" value="<?= set_value('receivedUIDIS') ?>" class="form-control" >
                      <input type="hidden"  name="receivedUID" autocomplete="off" id="receivedUID" value="<?= set_value('receivedUID') ?>" class="form-control" >
                      
                      <?php echo form_error('receivedUID', '<div class="text-danger">', '</div>'); ?>
                    </div>
                      
                      <input type="hidden" name="Password" autocomplete="off" id="Password" value="<?= set_value('Password') ?>" class="form-control" >
                      <input type="hidden"  name="finger" autocomplete="off" id="finger" value="<?= set_value('finger') ?>" class="form-control" >
                      
                    </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="FName">Nom</label>
                      <input type="text" name="NOM" autocomplete="off" id="NOM" value="<?= set_value('NOM') ?>" class="form-control" >
                      <?php echo form_error('NOM', '<div class="text-danger">', '</div>'); ?>
                    </div>


                    <div class="col-md-6">
                      <label for="FName">Prenom</label>
                      <input type="text" name="PRENOM" autocomplete="off" id="PRENOM" value="<?= set_value('PRENOM') ?>" class="form-control">
                      <?php echo form_error('PRENOM', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="FName">Téléphone</label>
                      <input type="tel" name="TELEPHONE" autocomplete="off" id="TELEPHONE" value="<?= set_value('TELEPHONE') ?>" class="form-control">

                      <?php echo form_error('TELEPHONE', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="FName"> Email</label>
                      <input type="text" name="EMAIL" autocomplete="off" id="EMAIL" value="<?= set_value('EMAIL') ?>" class="form-control">

                      <?php echo form_error('EMAIL', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName">Numero CNI</label>
                      <input type="text" name="NUMERO_CNI" autocomplete="off" id="NUMERO_CNI" value="<?= set_value('NUMERO_CNI') ?>" class="form-control">
                      <?php echo form_error('NUMERO_CNI', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    
                    <div class="col-md-6">
                      <label for="FName"> Date de naissance</label>
                      <input type="date" name="DATE_NAISSANCE" autocomplete="off" id="DATE_NAISSANCE" value="<?= set_value('DATE_NAISSANCE') ?>" class="form-control">

                      <?php echo form_error('DATE_NAISSANCE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    
                    <div class="col-md-6">
                      <label for="Ftype">Sexe</label>
                      <select class="form-control" name="ID_SEXE" id="ID_SEXE" onchange="get_communes();">
                        <option value="">---Sélectionner---</option>
                        <?php
                        foreach ($sexe as $value) {
                        ?>
                          <option value="<?= $value['ID_SEXE'] ?>"><?= $value['DESCRIPTION'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <!-- <div><font color="red" id="error_province"></font></div>  -->
                      <?php echo form_error('ID_SEXE', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    

                    <div class="col-md-6">
                      <label for="Ftype">Province</label>
                      <select class="form-control" name="ID_PROVINCE" id="ID_PROVINCE" onchange="get_communes();">
                        <option value="">---Sélectionner---</option>
                        <?php
                        foreach ($provinces as $value) {
                        ?>
                          <option value="<?= $value['PROVINCE_ID'] ?>"><?= $value['PROVINCE_NAME'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <!-- <div><font color="red" id="error_province"></font></div>  -->
                      <?php echo form_error('ID_PROVINCE', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="col-md-6">
                      <label for="Ftype">Commune</label>
                      <select class="form-control" name="ID_COMMUNE" id="ID_COMMUNE" onchange="get_zones();">
                        <option value="">---Sélectionner---</option>
                      </select>
                      <!-- <div><font color="red" id="error_commune"></font></div> -->
                      <?php echo form_error('ID_COMMUNE', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="col-md-6">
                      <label for="Ftype">Zone</label>
                      <select class="form-control" name="ID_ZONE" id="ID_ZONE" onchange="get_collines();">
                        <option value="">---Sélectionner---</option>
                      </select>
                      <!-- <div><font color="red" id="error_zone"></font></div> -->
                      <?php echo form_error('ID_ZONE', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="col-md-6">
                      <label for="Ftype">Colline</label>
                      <select class="form-control" name="ID_COLLINE" id="ID_COLLINE">
                        <option value="">---Sélectionner---</option>
                      </select>
                      <!-- <div><font color="red" id="error_colline"></font></div> -->
                      <?php echo form_error('ID_COLLINE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    

                    <div class="col-md-6 row">
                      <div class="col-md-1">
                        <label for="text" style="font-size: 10px;top:" id="fileName"></label></BR>
                        <label class="label" data-toggle="tooltip" title="Attacher un fichier">
                          <font style="font-size: 40PX;color: green"><i class="fas fa-image rounded" id="avatar" alt="avatar"></i></font>
                          <input type="file" class="sr-only" id="PHOTO" name="PHOTO" accept="image/*" >
                        </label>
                      </div>

                      <div class="col-md-1" style="margin-top:-8px">
                        <label for="text" style="font-size: 5px;" id="fileName"></label>
                        <input type="hidden" name="ImageLink" id="ImageLink">
                        <a class="btn btn-md" data-toggle="modal" data-target="#PaiementModal" style="top:-10px" onclick="cameraGet()" id="newImagePrise">
                        <font style="font-size: 40PX;color: green" ><i class="fas fa-camera"></i></font></a>                       
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
   
 const authenticationToken = "23027962-ea6b-4285-a61c-5a43c02ba4ec"; // Replace with your actual token
        const withdrawMoney = document.getElementById("withdrawMoney");
        const guichets = document.getElementById("guichets");
        const reset = document.getElementById("reset");
        const receivedIDHidden = document.getElementById("receivedID");
        const receivedUIDHidden = document.getElementById("receivedUID");
        const receivedUIDisa = document.getElementById("receivedUIDIS");

        var receivedUID="";
        var receivedUIDIS="";
        let isConnected = false;
        let isConnecting = false;

        // Simuler le début de la connexion
        isConnecting = true;
        updateStatusIndicator();

        // const ws = new WebSocket("ws://10.30.20.84/ws");
        const ws = new WebSocket(`ws://192.168.137.181/ws`); //rooter
        ws.onopen = function() {
          console.log("WebSocket connection opened");
            isConnected = true;
            isConnecting = false;
            updateStatusIndicator();
        };
        ws.onclose = function() {
          console.log("WebSocket connection closed");
          isConnected = false;
          isConnecting = false;
          updateStatusIndicator();
        };

 // Appel initial pour mettre à jour l'affichage
 updateStatusIndicator();

// Appeler updateStatusIndicator toutes les 10 secondes
setInterval(updateStatusIndicator, 10000); // 10000 millisecondes = 10 secondes
   
const buttonText = document.getElementById("buttonText");

  function updateStatusIndicator() {
    if (isConnected) {
      $('#isConn').removeClass('hidden'); // Afficher le conteneur du bouton
      $('#notConn').addClass('hidden'); // Afficher le conteneur du bouton

      
      buttonText.textContent = "Activer la carte"; // Texte par défaut
    }
    else if(isConnecting) {
      $('#notConn').removeClass('hidden'); // Afficher le conteneur du bouton
      $('#isConn').addClass('hidden'); // Afficher le conteneur du bouton

    }
     else{
      //  $('#isClose').removeClass('hidden'); // Afficher le conteneur du bouton
     } 

    }

        withdrawMoney.addEventListener("click", () => {
            console.log("Ok");
            const message = "enrollRFID";
            // ws.send(${authenticationToken}:${message}); 
            buttonText.textContent = "Scanner carte"; // Change le texte si connecté 
           ws.send(`${authenticationToken}:${message}:''`);
        });
        guichets.addEventListener("click", () => {
            console.log("activer");
            const message = "ACTIVATED";
            buttonText.textContent = "Scanner carte"; // Change le texte si connecté 
           ws.send(`${authenticationToken}:${message}:''`);
        });



      // Fonction de déchiffrement
      function decryptMessage(encryptedText) {
            // Déclarer la clé et l'IV
            const aesKey = [23, 45, 56, 67, 67, 87, 98, 12, 32, 34, 45, 56, 67, 87, 65, 5];
            const aesIv = [123, 43, 46, 89, 29, 187, 58, 213, 78, 50, 19, 106, 205, 1, 5, 7];

            // Convertir les clés et IV en format WordArray
            const key = CryptoJS.enc.Hex.parse(aesKey.map(num => ('0' + num.toString(16)).slice(-2)).join(''));
            const iv = CryptoJS.enc.Hex.parse(aesIv.map(num => ('0' + num.toString(16)).slice(-2)).join(''));

            // Déchiffrer le texte
            const decrypted = CryptoJS.AES.decrypt(
                { ciphertext: CryptoJS.enc.Base64.parse(encryptedText) },
                key,
                { iv: iv, mode: CryptoJS.mode.CBC, padding: CryptoJS.pad.Pkcs7 }
            );

            // Convertir le résultat en chaîne
            return decrypted.toString(CryptoJS.enc.Utf8);
        }
        ws.addEventListener("message", event => {
        // alert('test')
            const receivedData = event.data;
            const parts = receivedData.split(":");
            console.log(receivedData)
            
             if (parts.length === 5) {      // want to withdraw using RFID
              const receivedToken = parts[0];
                   const customerPassword = decryptMessage(parts[3]);
                      receivedUID = decryptMessage(parts[2]);  // UID
                      receivedUIDIS = decryptMessage(parts[2]);  // UID
                     const IDfINGER = decryptMessage(parts[4]);
                      receivedUIDHidden.value=receivedUID;
                      receivedUIDisa.value=receivedUIDIS;
                      Password.value=customerPassword
                      finger.value=IDfINGER

                console.log(customerPassword)
                if (receivedToken === authenticationToken) {
                    if (customerPassword.length===4) {
                        console.log(receivedData);
                    }else{
                      message = "WD";
                      rfidFeedbackElement.textContent = "Oups! Wrong Password. Only 4 digits are allowed.";
                      // ws.send(${authenticationToken}:${message});  
                     ws.send(`${authenticationToken}:${message}:''`);
                      console.log(message);
                      $('#RFID_SMS').modal('show');
                    }
                    
                } else {
                    // messageDiv.innerHTML = "Invalid token!";
                    console.log("Invalid token!");
                }
            }else if (parts.length === 3) {
                const receivedToken = parts[0];
                const decryptedUid = decryptMessage(parts[1]);
                const decryptedFingerId = decryptMessage(parts[2]);
                $.ajax({
                  url: "<?=base_url()?>donnees/Electeurs/connexion/",
                  type : "POST",
                  dataType: "JSON",
                  cache:false,
                  data:{
                    receivedUID:decryptedUid,
                    fingerId:decryptedFingerId,
                  },
                  success: function(response) {
                    if (response.status === 'success') {
                        // Connexion réussie
                        message = "LOGIN_OK";
                        let candList = ''; // Déclaration de la variable pour stocker le résultat

                        $.ajax({
                              url: "<?=base_url()?>donnees/Electeurs/Candidatlisting",
                              type: "GET",
                              dataType: "JSON",
                              cache: false,
                              success: function(response) {
                                  console.log(response); // Afficher les données pour le débogage

                                  // Vérifiez le statut de la réponse
                                  if (response.status === 'success') {
                                      // Accéder au tableau de candidats
                                      const candidates = response.data;

                                      candList = candidates.map(item => `${item.ID} ${item.DESCRIPTION}`).join('*'); // Utilisez la variable externe

                                      // Vérifiez le contenu de candList
                                      console.log("candList avant envoi :", candList);

                                      // Envoyer le message après avoir obtenu candList
                                      ws.send(`${authenticationToken}:${message}:${candList}`);

                                  } else {
                                      console.log("Erreur : statut de la réponse est 'error'.");
                                  }
                              },
                              error: function(jqXHR, textStatus, errorThrown) {
                                  console.error("Erreur AJAX : ", textStatus, errorThrown);
                              }
                          });
                        
                    } 
                   
                    else if (response.status === 'errors') {
                       // Connexion réussie
                       message = "LOGIN_ECHEC";
                       ws.send(`${authenticationToken}:${message}`);
                        console.log(message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Erreur AJAX : " + error);
                    // alert("Erreur de la connexion. Veuillez réessayer."); // Message personnalisé pour l'erreur de connexion
                    console.log(message);

                }
            });
            } 
            else if (parts.length === 2) {
                const candidat = decryptMessage(parts[1]);
                $.ajax({
                  url: "<?=base_url()?>donnees/Electeurs/votesCandidat/",
                  type : "POST",
                  dataType: "JSON",
                  cache:false,
                  data:{
                    candidat:candidat,
                  },
                  success: function(response) {
                    if (response.status === 'success') {
                        // Connexion réussie
                        message = "VOTE_DONE";
                       ws.send(`${authenticationToken}:${message}:''`);
                        console.log(message);
                        // Appel pour actualiser le contenu de Home_view
                    } else if (response.status === 'error') {
                       // Connexion réussie
                       message = "VOTE_ECHEC";
                       ws.send(`${authenticationToken}:${message}:''`);
                        console.log(message);
                    }
                    else if (response.status === 'errorDate') {
                       // Connexion réussie
                       message = "ERROR_DATE";
                       ws.send(`${authenticationToken}:${message}:''`);
                        console.log(message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Erreur AJAX : " + error);
                    alert("Erreur de la connexion. Veuillez réessayer."); // Message personnalisé pour l'erreur de connexion
                    console.log(message);

                }
            });

            }
            else if (parts.length === 1) {
              console.error("ACTIVATION" );
            }
            else{
                // messageDiv.innerHTML = "Invalid payload format!";
                alert("Invalid payload format!")
                console.log("Invalid payload format!");
            }
        });

        // Fonction pour mettre à jour le graphique avec les nouvelles données
        function updateHomeView() {
            $.ajax({
                url: '<?= base_url("donnees/get_rapport") ?>',
                method: 'GET',
                dataType: 'json', // Assurez-vous que le type de données est JSON
                success: function(data) {
                    // Vérifiez que les données sont reçues
                    console.log(data)
                    if (data.rapp3) {
                        // Évaluez le script contenant le graphique
                        eval(data.rapp3); // Cela exécutera le script pour mettre à jour le graphique
                    }
                },
                error: function(err) {
                    console.error('Erreur lors de l\'appel à donnees/get_rapport:', err);
                }
            });
        }  
function openModalAfterTask() {
    // Perform your specific task here
    // For example, you can use a setTimeout to simulate a task completion
    setTimeout(function() {
        // Get a reference to your modal element
        var modal = document.getElementById('withdraw_modal');

        // Display the modal by changing its style to "block"
        modal.style.display = 'block';
    }, 2000); // Change this value to control the delay before the modal appears (in milliseconds)
}

</script>

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
      // Not adding { audio: true } since we only want video now
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

function decrypts(encryptedMessage) {
    // Séparer la clé, l'IV et le texte chiffré
    const [base64Key, base64Iv, base64Encrypted] = encryptedMessage.split('@');

    // Décoder la clé, l'IV et le texte chiffré
    const key = CryptoJS.enc.Base64.parse(base64Key);
    const iv = CryptoJS.enc.Base64.parse(base64Iv);
    const ciphertext = base64Encrypted;

    // Déchiffrer
    const decrypted = CryptoJS.AES.decrypt(ciphertext, key, {
        iv: iv,
        mode: CryptoJS.mode.CBC,
        padding: CryptoJS.pad.Pkcs7,
    });

    // Retourner le texte déchiffré
    return decrypted.toString(CryptoJS.enc.Utf8);
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
//   get_test()
  function get_communes(){
    var ID_PROVINCE = $('#ID_PROVINCE').val();
    if (ID_PROVINCE == '') {
      $('#ID_COMMUNE').html('<option value="">---Sélectionner---</option>');
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    }
    else { 
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_communes/" + ID_PROVINCE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_COMMUNE').html(data);
        }
      });
    }
  }

  function get_zones() {
    var ID_COMMUNE = $('#ID_COMMUNE').val();
    if (ID_COMMUNE == '') {
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_zones/" + ID_COMMUNE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_ZONE').html(data);
        }
      });

    }
  }
  function get_collines(){
    var ID_ZONE = $('#ID_ZONE').val();
    if (ID_ZONE == '') {
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    } else {
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_collines/" + ID_ZONE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_COLLINE').html(data);
        }
      });

    }
  }

 function get_communes_affectation(){
    var ID_PROVINCE_AFFECTATION = $('#ID_PROVINCE_AFFECTATION').val();
    if (ID_PROVINCE_AFFECTATION == '') {
      $('#ID_COMMUNE_AFFECTATION').html('<option value="">---Sélectionner---</option>');
      $('#ID_ZONE_AFFECTATION').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE_AFFECTATION').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_communes/" + ID_PROVINCE_AFFECTATION,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_COMMUNE_AFFECTATION').html(data);
        }
      });

    }
  }
  function get_zones_affectation() {
    var ID_COMMUNE_AFFECTATION = $('#ID_COMMUNE_AFFECTATION').val();
    if (ID_COMMUNE_AFFECTATION == '') {
      $('#ID_ZONE_AFFECTATION').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE_AFFECTATION').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#ID_COLLINE_AFFECTATION').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_zones/" + ID_COMMUNE_AFFECTATION,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_ZONE_AFFECTATION').html(data);
        }
      });

    }
  }


  function get_collines_affectation() {
    var ID_ZONE_AFFECTATION = $('#ID_ZONE_AFFECTATION').val();
    // alert(ID_ZONE)
    if (ID_ZONE == '') {
      $('#ID_COLLINE_AFFECTATION').html('<option value="">---Sélectionner---</option>');
    } else {
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_collines/" + ID_ZONE_AFFECTATION,
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