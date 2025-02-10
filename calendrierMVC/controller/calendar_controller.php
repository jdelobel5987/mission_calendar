<?php

include __DIR__ . '/../template/init_template.php';

require __DIR__ . '/../model/events_model.php';

$subEvents = getAllEvents(); // id, titre & date

include __DIR__ . '/../template/calendar_template.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $eventDetail = getEvent($id);
    $view = 'details_view.php';
    // Inclure ci-dessous le fichier config.php contenant votre clé API Google Maps dans assets/php/ 
    // config.php doit contenir la variable $google_maps_api_key = 'YOUR-VALID-KEY-HERE';
    include __DIR__ . '/../assets/php/config.php'; 
} else {
    $view = 'calendar_view.php';
}

include __DIR__ . '/../view/' . $view;

?>