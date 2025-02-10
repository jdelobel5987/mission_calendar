<?php

function loadEventsData() {
  // simulation de la connection à la base de données
  include __DIR__.'/../assets/datas/events.php'; // Inclure le fichier events.php
  return $database_events; // Retourner le tableau $database_events à la place d'une instance de la base de données
}

function getEvent($id) {
    // simulation de la requête SQL
  $events = loadEventsData();
  foreach ($events as $event) {
    if ($event['id'] == $id) {
      return $event;
    }
  }
  return null; // Retourne null si l'événement n'est pas trouvé
}

function getAllEvents() {
    // simulation de la requête SQL
  $events = loadEventsData();
  return array_map(function ($event) {
    return [
      'id' => $event['id'],
      'titre' => $event['titre'],
      'date' => $event['date']
    ];
  }, $events);
}

?>