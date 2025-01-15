 const authenticationToken = "23027962-ea6b-4285-a61c-5a43c02ba4ec"; // Replace with your actual token
        const withdrawMoney = document.getElementById("withdrawMoney");
        const withdrawByRFID = document.getElementById("withdrawByRFID");
        const reset = document.getElementById("reset");
        const amountToWithdrawLabel = document.getElementById("amountToWithdrawLabel");
        const accuracy = document.getElementById("accuracy");
        const accountNumberHidden = document.getElementById("accountNumberHidden");
        const receivedIDHidden = document.getElementById("receivedID");
        const receivedUIDHidden = document.getElementById("receivedUID");
        const receivedUIDisa = document.getElementById("receivedUIDIS");
        const accountNameModal = document.getElementById("accountNameModal");
        var rfidFeedbackElement = document.getElementById("RFID_Feedback");
        var hiddenType = document.getElementById("hiddenType");
        //message for low balance
        var lowBalance = document.getElementById('lowBalance');
        var approveButton = document.getElementById('approveButton');

        var receivedUID="";
        var receivedUIDIS="";
         // Simulate WebSocket connection status changes
        let isConnected = false;
        let isConnecting = false;

        // Simuler le début de la connexion
        isConnecting = true;
        updateStatusIndicator();

        // const ws = new WebSocket("ws://10.30.20.84/ws");
        const ws = new WebSocket("ws://192.168.137.1817/ws"); //rooter
        ws.onopen = function() {
          console.log("WebSocket connection opened");
          // Simulate WebSocket connection status changes (for testing purposes)
            isConnected = true;
            isConnecting = false;
            updateStatusIndicator();
        };
        // ws.onconnecting = function() {
        //   console.log("WebSocket is connecting");
        //     isConnecting = true;
        //      updateStatusIndicator();
        // };
        ws.onclose = function() {
          console.log("WebSocket connection closed");
          isConnected = false;
          isConnecting = false;
          updateStatusIndicator();
        };

       
        // Gestion des erreurs
// ws.onerror = function() {
//     console.log("WebSocket error occurred");
//     hasError = true; // Définir l'état d'erreur
//     isConnecting = true; // Assurez-vous que ce n'est pas en cours de connexion
//     isConnected = true; // Réinitialiser la connexion
//     updateStatusIndicator();
// };

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


        // reset.addEventListener("click", () => {
        //     const message = "Reset";
        //     ws.send(${authenticationToken}:${message});
        // });

        ws.addEventListener("message", event => {
        // alert('test')
            const receivedData = event.data;
            const parts = receivedData.split(":");
            console.log(receivedData)
            
             if (parts.length === 4) {      // want to withdraw using RFID
              const receivedToken = parts[0];
                const customerPassword = parts[3];
                      receivedUID = parts[2];  // UID
                      receivedUIDIS = parts[2];  // UID
                      receivedUIDHidden.value=receivedUID;
                      receivedUIDisa.value=receivedUIDIS;
                      Password.value=customerPassword
                console.log(customerPassword)
                if (receivedToken === authenticationToken) {
                    if (customerPassword.length===4) {
                        // verifyRFID(receivedUID,customerPassword)
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
                    alert("Invalid token!")
                    console.log("Invalid token!");
                }
            }else if (parts.length === 3) {
                const receivedToken = parts[0];
                const receivedUID = parts[1];  // UID Card
                const password = parts[2];  // pwd
                $.ajax({
                  url: "<?=base_url()?>donnees/Electeurs/connexion/",
                  type : "POST",
                  dataType: "JSON",
                  cache:false,
                  data:{
                    receivedUID:receivedUID,
                    password:password,
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
                    else if (response.status === 'error') {
                       // Connexion réussie
                       message = "LOGIN_ECHEC";
                       ws.send(`${authenticationToken}:${message}:''`);
                        console.log(message);
                    }
                    else if (response.status === 'errors') {
                       // Connexion réussie
                       message = "LOGIN_ECHEC";
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
            } else if (parts.length === 2) {
                // message = "VOTE_DONE";
                // ws.send(${authenticationToken}:${message});
                //ws.send(`${authenticationToken}:${message}:''`);
                // console.log(message);


                const candidat = parts[1];
               
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

            }else{
                // messageDiv.innerHTML = "Invalid payload format!";
                alert("Invalid payload format!")
                console.log("Invalid payload format!");
            }
        });

        
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