# mission_calendar

creation of a dynamic calendar using PHP and integration of events details

This is a small project to exercize coding with PHP language, from the web dev professional formation from the school LaManu (France)

Tasks are:

* making a form with 2 select lists, one for choosing the month and the other for choosing the year (range of +/- 5 years from current year).
* displaying a calendar based on user selection.
* from a Json file containing events details, making events appear at the corresponding date, and display event details.
* improving UX (month/year navigation, highlight current date, weekends...)

# Access to maps within event details

to access maps while clicking on an event date of the calendar, you should create a config.php file at the root, and indicate a valid key for Maps JavaScript API as follow:

```
<?php
$google_maps_api_key = 'COPY-YOUR-VALID-KEY-HERE';
?>
```

Please visit [this page](https://developers.google.com/maps/documentation/javascript/get-api-key) for guidance on how to get an API key.

# Update 10/02/2025: MVC architecture

A new folder "calendrierMVC" is added in the project. This folder contains another version of the whole calendar project, organized following the Model View Controller architecture. Similarly, to access the maps within the event details view, the user should add is own valid key for Maps JavaScript API, within `assets/php/config.php` as per the code snippet above.
