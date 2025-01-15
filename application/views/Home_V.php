<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats des Élections</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
</head>
<body>

    <script>
        let ws = new WebSocket('ws://192.168.137.181/ws'); // Changez l'URL si nécessaire

        ws.onopen = function() {
            console.log('WebSocket connecté');
        };

//         ws.onmessage = function(event) {
//             const data = event.data.split(':'); // Traitez le message
//             const messageType = data[1]; // Récupérez le type de message
//             console.log(messageType);
//             if (messageType === 'VOTE_DONE') {
//                 updateHomeView(); // Met à jour le graphique lorsque le vote est enregistré
//             console.log("messageType");

//     }
//    };

        ws.onerror = function(error) {
            console.error('WebSocket Error: ' + error);
        };
        let myChart;

        function initChart() {
            myChart = Highcharts.chart('container3', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: '<b> Nombre de Votes par Chaque Candidat </b>'
                },
                xAxis: {
                    type: 'category',
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.f} </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                series: [{
                    color: 'green',
                    name: 'Nombre total : (0)', // Placeholder, sera mis à jour
                    data: [] // Commence avec un tableau vide
                }]
            });
        }

        function updateHomeView() {
            $.ajax({
                url: '<?= base_url("donnees/get_rapport") ?>', // Chemin vers le contrôleur
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data); // Pour déboguer et vérifier les données

                    if (data.candidates) {
                        myChart.update({
                            series: [{
                                color: 'green',
                                name: 'Nombre total : (' + data.totalVotes + ')',
                                data: data.candidates // Met à jour avec les nouvelles données
                            }]
                        });
                    }
                },
                error: function(err) {
                    console.error('Erreur lors de l\'appel à get_rapport:', err);
                }
            });
        }

        // Appel initial pour créer le graphique
        initChart();
        updateHomeView(); // Mettre à jour le graphique lors du chargement de la page
    </script>
</body>
</html>