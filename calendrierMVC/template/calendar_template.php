<!-- all variables nessecary for the form&calendar -->

<?php
// 
// for the form
//

$days = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];
$dayOfWeek = date('N'); // de 1 à 7: 1 = lundi, 2=mardi...
$thisDay = $days[$dayOfWeek - 1]; // -1 pour l'indice du jour en français dans $days
$day = date('j'); // jour du mois courant de 1 à 31

$thisYear = date('Y'); // année courante à 4 chiffres
$years = range($thisYear - 5, $thisYear + 5);
$selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : (int)$thisYear;  // si pas d'envoie formulaire, prend l'année en cours

$months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"];
$month = date('n'); // de 1 à 12: 1 = Janvier, 2=Février...
$selectedMonth = isset($_GET['month']) ? (int)$_GET['month'] : (int)$month; // si pas d'envoie formulaire, prend le mois en cours (mois 1-12)

$thisMonth = $months[$month - 1]; // -1 pour l'indice du mois en français dans $months

// 
// for the calendar
// 

$displayYear = isset($_GET['year']) ? (int)$_GET['year'] : (int)$thisYear;    // récupère l'année ou prend l'année en cours
$displayMonth = isset($_GET['month']) ? (int)$_GET['month'] : (int)$month;    // récupère le mois ou prend le mois en cours

// Vérification des valeurs du mois et de l'année
if ($displayMonth < 1 || $displayMonth > 12) {
    $displayMonth = (int)$month;    // si un utilisateur passe une valeur incorrecte directement en url, prend le mois en cours
} else {
    $displayMonth = (int)$displayMonth;
}

if ($displayYear < $thisYear - 5 || $displayYear > $thisYear + 5) {
    $displayYear = (int)$thisYear;  // si un utilisateur passe une valeur incorrecte directement en url, prend l'année en cours
} else {
    $displayYear = (int)$displayYear;
}

$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $displayMonth, $displayYear);   // Calcul du nombre de jours dans le mois
$displayDate = new DateTime("$displayYear-$displayMonth-01");   // crée un objet DateTime pour le premier jour du mois/année
$startDay = $displayDate->format('N'); // récupère le numéro du premier jour du mois/année (1 = lundi...)
$firstDayOfMonth = $days[$startDay - 1]; // récupère le jour de la semaine correspondant dans le tableau $days ['Lundi', 'Mardi'...]
$lastOfMonth = $startDay - 1 + $daysInMonth; // récupère le numéro du dernier jour du mois (1 = lundi...)

$today = new DateTime();
$currentDay = ($displayYear == $today->format('Y') && $displayMonth == $today->format('n')) ? $today->format('j') : null; // attribue le numéro du jour actuel si mois/année sont actuels, sinon null

$eventDates = [];
foreach ($subEvents as $event) {
    $eventDates[date('Y-m-d', strtotime($event['date']))] = $event;
}


// 
// for the detail view
// 
$formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE, 'Europe/Paris', IntlDateFormatter::GREGORIAN, 'd MMMM yyyy'); // Création d'un objet IntlDateFormatter pour le formatage des dates en français

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $eventDetail = getEvent($id);
    $eventDate = date('Y-m-d', strtotime($eventDetail['date']));
    $f_eventDate = $formatter->format(new DateTime($eventDate));
    $eventYear = (int)date('Y', strtotime($eventDate));
    $eventMonth = (int)date('n', strtotime($eventDate));
}


?>