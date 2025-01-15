// assets/js/app.js

// Vérifier si le navigateur prend en charge les Service Workers
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/service-worker.js')
        .then(function(registration) {
            console.log('Service Worker registered with scope:', registration.scope);
        })
        .catch(function(error) {
            console.error('Service Worker registration failed:', error);
        });
}

// Demander la permission pour les notifications
Notification.requestPermission().then(function(result) {
    if (result === 'granted') {
        console.log('Notification permission granted.');
    } else {
        console.log('Notification permission denied.');
    }
});