<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaManuEcology - Détails évènements</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_maps_api_key; ?>&callback=initMap" async defer></script>
    <script>
        function initMap() {
            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 5,
                // center: {lat: 46.603354, lng: 1.888334} // Centré sur la France
            });

            let lat = <?php echo $eventDetail['latitude']; ?>;
            let lng = <?php echo $eventDetail['longitude']; ?>;
            let title = '<?php echo addslashes($eventDetail['titre']); ?>';

            console.log(lat, lng, title);

            let marker = new google.maps.Marker({
                position: {lat: lat, lng: lng},
                map: map,
                title: title
            });
                
            map.setCenter({lat: lat, lng: lng});
        }
    </script>
</head>

<body>
    <div class="event-details">
        <h2>évènement(s) du <?php echo $f_eventDate; ?></h2>
        <table>
            <tr>
                <th>Titre :</th>
                <td>
                    <h3><?php echo $eventDetail['titre']; ?></h3>
                </td>
            </tr>
            <tr>
                <th>Lieu :</th>
                <td><?php echo $eventDetail['ville']; ?></td>
            </tr>
            <tr>
                <th>Description :</th>
                <td><?php echo $eventDetail['description']; ?></td>
            </tr>
        </table><br>
        <div id="map"></div>
        <br><a href="index.php?year=<?php echo $eventYear;?>&month=<?php echo $eventMonth;?>">Retour au calendrier</a>
    </div>
</body>

</html>