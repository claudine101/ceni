document.addEventListener("DOMContentLoaded", function() {
    const authenticationToken = "23027962-ea6b-4285-a61c-5a43c02ba4ec"; // Remplacez par votre token
    const buttonText = document.getElementById("buttonText");
    const withdrawMoney = document.getElementById("withdrawMoney");
    const guichets = document.getElementById("guichets"); // Vérifiez que cet élément existe dans votre HTML

    // Autres éléments...

    var receivedUID = "";
    var receivedUIDIS = "";
    let isConnected = false;
    let isConnecting = false;

    // Simuler le début de la connexion
    isConnecting = true;
    updateStatusIndicator();

    // Créer une connexion WebSocket
    const ws = new WebSocket(`ws://192.168.137.1813/ws`); // rooter

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

    function updateStatusIndicator() {
        if (buttonText) { // Vérifiez que buttonText existe
            if (isConnected) {
                buttonText.textContent = "Activer la carte"; // Texte par défaut
            } else if (isConnecting) {
                buttonText.textContent = "Connexion en cours..."; // Indication de connexion
            } else {
                buttonText.textContent = "Déconnecté"; // Indication de déconnexion
            }
        } else {
            console.error("L'élément avec l'ID 'buttonText' n'existe pas.");
        }
    }

    if (withdrawMoney) { // Vérifiez que withdrawMoney existe
        withdrawMoney.addEventListener("click", () => {
            buttonText.textContent = "Scanner carte"; 
            // ws.send(...); // Décommentez et complétez cette ligne selon votre logique
        });
    } else {
        console.error("L'élément avec l'ID 'withdrawMoney' n'existe pas.");
    }

    // Autres écouteurs d'événements et logique...
});