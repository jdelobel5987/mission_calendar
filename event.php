<?php
// Récupération des données de l'URL
$day = $_GET['day'];
$year = $_GET['year'];
$month = $_GET['month'];

// Récupération des données des évènements dans un tableau associatif
$json = file_get_contents('assets/json/events.json');
$events = json_decode($json, true)['evenements'];
$eventDates = [];
foreach ($events as $event) {
    if ($event['date'] == sprintf('%04d-%02d-%02d', $year, $month, $day)) {
        $eventDates[] = $event; // Ne stocke que les événements de la date sélectionnée
    }
}

// Formattage de la date choisie en français
$formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE, 'Europe/Paris', IntlDateFormatter::GREGORIAN, 'd MMMM yyyy'); // Création d'un objet IntlDateFormatter pour le formatage des dates en français
$date = new DateTime("$year-$month-$day");
$f_date = $formatter->format($date);

include 'config.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Évènements LaManuEcology</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_maps_api_key; ?>&callback=initMap" async defer></script>
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 5,
                center: {lat: 46.603354, lng: 1.888334} // Centré sur la France
            });

            var locations = <?php echo json_encode($eventDates); ?>;

            // Vérifier si locations est un tableau
            if (Array.isArray(locations) && locations.length > 0) {
                locations.forEach(function(event) {
                    var marker = new google.maps.Marker({
                        position: {lat: event.latitude, lng: event.longitude},
                        map: map,
                        title: event.titre
                    });
                });
            } else {
                console.error("Locations n'est pas un tableau ou est vide.");
            }
        }
    </script>
</head>
<body>

<div class="event-details">
    <h2>Évènement(s) du <?php echo $f_date; ?></h2>

    <?php
    if (!empty($eventDates)) {
        foreach ($eventDates as $event) {
            echo <<<DETAILS
                <table>
                    <tr>
                        <th>Titre :</th>
                        <td><h3>{$event['titre']}</h3></td>
                    </tr>
                    <tr>
                        <th>Lieu :</th>
                        <td>{$event['ville']}</td>
                    </tr>
                    <tr>
                        <th>Description :</th>
                        <td>{$event['description']}</td>
                    </tr>
                </table><br>
            DETAILS;
        }
    } else {
        echo "<p>Aucun évènement pour cette date.</p>";
    }
    ?>

    <div id="map"></div>
    
    <br><a href="index.php?year=<?php echo $year; ?>&month=<?php echo $month; ?>">Retour au calendrier</a>
</div>

</body>
</html>