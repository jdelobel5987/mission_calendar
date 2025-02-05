<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$days = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];
$dayOfWeek = date('N'); // de 1 à 7: 1 = lundi, 2=mardi...
$thisDay = $days[$dayOfWeek-1]; // -1 pour l'indice du jour en français dans $days
$day = date('j'); // jour du mois courant de 1 à 31
$months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"];
$month = date('n'); // de 1 à 12: 1 = Janvier, 2=Février...
$thisMonth = $months[$month-1]; // -1 pour l'indice du mois en français dans $months
$thisYear = date('Y'); // année courante à 4 chiffres
$years = range($thisYear-5, $thisYear+5);

// $formatterMonthFR = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE, 'Europe/Paris', IntlDateFormatter::GREGORIAN, 'MMMM'); // Création d'un objet IntlDateFormatter pour le formatage des dates en français
// $randomDate = new DateTime('this month');
// $f_month = $formatterMonthFR->format(new DateTime('today'));
// echo $f_month;
// echo "<br>";
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier LaManuEcology</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header></header>
    <main>
        <div class="container-calendar">
            <h2>Calendrier La ManuEcology</h2>
            <form action=<?php echo $_SERVER['PHP_SELF']; ?> method="get">
                <label for="year">Année :</label>
                <select name="year" id="year">
                    <?php
                    $selectedYear = isset($_GET['year'])? (int)$_GET['year'] : (int)$thisYear;  // si pas d'envoie formulaire, prend l'année en cours
                    foreach ($years as $year) {
                        $selected = ($year == $selectedYear) ? "selected" : "";
                        echo "<option value='$year' $selected>$year</option>";  // une option pour chaque année de $years
                    }
                    ?>
                </select>
                <label for="month">Mois : </label>
                <select name="month" id="month">
                    <?php
                    $selectedMonth = isset($_GET['month'])? (int)$_GET['month'] : (int)$month; // si pas d'envoie formulaire, prend le mois en cours (mois 1-12)
                    foreach ($months as $index => $monthName) {
                        $selected = ($index + 1 == $selectedMonth) ? "selected" : "";   // donne l'attribut selected au mois en cours
                        echo "<option value='" . ($index+1) . "' $selected>$monthName</option>";    // une option pour chaque mois de $months
                    }
                    ?>
                </select>
                <div class="display-calendar">
                    <i id="prevYear" class="fa fa-angle-double-left"></i>
                    <i id="prevMonth" class="fa fa-angle-left"></i>
                    <button id="displayCalendar" type="submit">Afficher <i class="fa fa-calendar"></i></button>
                    <i id="nextMonth" class="fa fa-angle-right"></i>
                    <i id="nextYear" class="fa fa-angle-double-right"></i>
                </div>
            </form>
            <div class="calendar">
                <?php
                    $displayYear = isset($_GET['year']) ? (int)$_GET['year'] : (int)$thisYear;    // récupère l'année ou prend l'année en cours
                    $displayMonth = isset($_GET['month']) ? (int)$_GET['month'] : (int)$month;    // récupère le mois ou prend le mois en cours

                    // Vérification des valeurs du mois et de l'année
                    if ($displayMonth < 1 || $displayMonth > 12) {
                        $displayMonth = (int)$month;    // si un utilisateur passe une valeur incorrecte directement en url, prend le mois en cours
                    } 
                    else {
                        $displayMonth = (int)$displayMonth;
                    }

                    if ($displayYear < $thisYear - 5 || $displayYear > $thisYear + 5) {
                        $displayYear = (int)$thisYear;  // si un utilisateur passe une valeur incorrecte directement en url, prend l'année en cours
                    } 
                    else {
                        $displayYear = (int)$displayYear;
                    }

                    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $displayMonth, $displayYear);   // Calcul du nombre de jours dans le mois
                    $displayDate = new DateTime("$displayYear-$displayMonth-01");   // crée un objet DateTime pour le premier jour du mois/année
                    $startDay = $displayDate->format('N'); // récupère le numéro du premier jour du mois/année (1 = lundi...)
                    $firstDayOfMonth = $days[$startDay-1]; // récupère le jour de la semaine correspondant dans le tableau $days ['Lundi', 'Mardi'...]
                    $lastOfMonth = $startDay -1 + $daysInMonth; // récupère le numéro du dernier jour du mois (1 = lundi...)

                    // $daysOfPrevMth = cal_days_in_month(CAL_GREGORIAN, $displayMonth-1, $displayYear);
                    // $daysOfNextMth = cal_days_in_month(CAL_GREGORIAN, $displayMonth+1, $displayYear);

                    $today = new DateTime();
                    $currentDay = ($displayYear == $today->format('Y') && $displayMonth == $today->format('n')) ? $today->format('j') : null; // attribue le numéro du jour actuel si mois/année sont actuels, sinon null
                    
                    $json = file_get_contents('assets/json/events.json');
                    $events = json_decode($json, true)['evenements'];
                    $eventDates = [];
                
                    foreach ($events as $event) {   // crée un tableau avec les dates en tant que clés, et les événements associés en tant que valeurs
                        $eventDates[date('Y-m-d', strtotime($event['date']))] = $event;
                    }

                    ?>

                <table>
                    <tr>
                        <th colspan="7"><?php echo $months[$displayMonth - 1] . ' ' . $displayYear; ?></th>  
                    </tr>
                    <tr>
                        <?php
                        foreach ($days as $day) {
                            echo "<th>$day</th>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <?php
                        for ($i = 1; $i < $startDay; $i++) {
                            echo "<td class='empty'></td>";     // affiche des cellules vides jusqu'au premier jour du mois
                        }
                        for ($j = 1; $j <= $daysInMonth; $j++) {
                            $class = '';
                            $currentDate = sprintf('%04d-%02d-%02d', $displayYear, $displayMonth, $j);  //sprintf pour formater les dates ($displayMonth et $j commencent à 1,2,3 -> 01,02,03...)
                            if (($j + $startDay - 1) % 7 == 6 || ($j + $startDay - 1) % 7 == 0) {   // ($j + $startDay -1) réfère à la position dans une ligne de 1 à 7 soit lundi à dimanche --> %7==6 et %7==0 correspondent aux position de samedi et dimanche
                                $class = 'weekend';
                            }
                            if ($currentDay && $j == $currentDay) {
                                $class .= ' today';
                            }
                            if (isset($eventDates[$currentDate])) { // si $currentDate est une clé du tableau $eventDates, ajout classe 'event' et affiche la date en lien avec les paramètres url jour/mois/année
                                $class .= ' event';
                                echo "<td class='$class'><a href='event.php?day=$j&month=$displayMonth&year=$displayYear'>$j</a></td>";
                            } else {
                                echo "<td class='$class'>$j</td>";
                            }
                            if (($j + $startDay - 1) % 7 == 0) { // si 7e position dans la ligne: fin de ligne et début nouvelle ligne
                                echo "</tr><tr>";
                            }
                        }
                        if ($lastOfMonth < 7) { // si dernier jour du mois n'est pas en 7e position, complète la ligne avec des cellules vides
                            for ($k = 1; $k <= 7 - $lastOfMonth; $k++) {
                                echo "<td class='empty'></td>";
                            }
                        }
                        ?>
                    </tr>
                </table>

            </div>
        </div>

    </main>
    <footer></footer>

    <script>    // variables à passer à script.js
        let years = <?php echo json_encode($years);?>;
        const months = <?php echo json_encode(range(1, 12));?>;
        let displayYear = <?php echo $displayYear;?>;
        let displayMonth = <?php echo $displayMonth;?>;
    </script>

    <script src="assets/js/script.js"></script>
</body>
</html>