let ws;

function connectWebSocket() {
    ws = new WebSocket("ws://192.168.137.1817/ws");

    ws.onopen = function () {
        console.log("WebSocket connection established.");
    };

    ws.onmessage = function (event) {
        const receivedData = event.data;
        console.log("Message from server:", receivedData);
    
        self.clients.matchAll().then(clients => {
            clients.forEach(client => {
                console.log("Envoi du message aux clients:", receivedData); // Debug
                client.postMessage({
                    type: 'wsMessage',
                    data: receivedData
                });
            });
        });
    };

    ws.onerror = function (error) {
        console.error("WebSocket error:", error);
    };

    ws.onclose = function () {
        console.log("WebSocket connection closed.");
        setTimeout(connectWebSocket, 1000);
    };
}

self.addEventListener('install', (event) => {
    console.log('Service Worker installed.');
});

self.addEventListener('activate', (event) => {
    console.log('Service Worker activated.');
    connectWebSocket();
});