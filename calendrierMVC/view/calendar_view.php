<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaManuEcology - calendrier</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">

</head>

<body>
    <main>
        <div class="container-calendar">
            <h2>Calendrier La ManuEcology</h2>
            
            <form action=<?php echo $_SERVER['PHP_SELF']; ?> method="get">
                <label for="year">Année :</label>
                <select name="year" id="year">
                    <?php
                    foreach ($years as $year) {
                        $selected = ($year == $selectedYear) ? "selected" : "";
                        echo "<option value='$year' $selected>$year</option>";  // une option pour chaque année de $years
                    }
                    ?>
                </select>
                <label for="month">Mois : </label>
                <select name="month" id="month">
                    <?php
                        foreach ($months as $index => $monthName) {
                            $selected = ($index + 1 == $selectedMonth) ? "selected" : "";   // donne l'attribut selected au mois sélectionné, ou une chaine vide pour les autres mois
                            echo "<option value='" . ($index + 1) . "' $selected>$monthName</option>";    // une option pour chaque mois de $months
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
                                $id = $eventDates[$currentDate]['id'];
                                echo "<td class='$class'><a href='index.php?id=$id'>$j</a></td>";
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

    <script>    // variables à passer à script.js
        let years = <?php echo json_encode($years);?>;
        const months = <?php echo json_encode(range(1, 12));?>;
        // let displayYear = <?php echo $displayYear;?>;
        // let displayMonth = <?php echo $displayMonth;?>;
    </script>

    <script src="assets/js/script.js"></script>
</body>

</html>