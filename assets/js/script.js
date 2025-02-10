// attribution des éléments du DOM
const prevYear = document.getElementById('prevYear');
const prevMonth = document.getElementById('prevMonth');
const displayButton = document.getElementById('displayCalendar');
const nextMonth = document.getElementById('nextMonth');
const nextYear = document.getElementById('nextYear');

const selectedYear = document.querySelector('select[name="year"]');
const selectedMonth = document.querySelector('select[name="month"]');


// récupération de variables php passées en fin de body avant l'appel à ce script.js
let minYear = parseInt(years[0]);
let maxYear = parseInt(years[years.length - 1]);
let minMonth = parseInt(months[0]);
let maxMonth = parseInt(months[months.length - 1]);
// console.log(years);
// console.log(months);
// console.log(minYear, maxYear);
// console.log(displayMonth, displayYear);


// gestion des flèches de navigation années/mois
prevYear.addEventListener('click', () => {
    if (selectedYear.value == minYear) {
        return;
    } else {
        selectedYear.value = parseInt(selectedYear.value) - 1;
        displayButton.click();
    }
});

nextYear.addEventListener('click', () => {
    if (selectedYear.value == maxYear) {
        return;
    } else {
        selectedYear.value = parseInt(selectedYear.value) + 1;
        displayButton.click();
    }
});


prevMonth.addEventListener('click', () => {
    if (selectedMonth.value == minMonth) {
        if (selectedYear.value == minYear) {
            return;
        } else {
            selectedMonth.value = maxMonth;
            selectedYear.value = parseInt(selectedYear.value) - 1;
            displayButton.click();
        }
    } else {
        selectedMonth.value = parseInt(selectedMonth.value) - 1;
        displayButton.click();
    }
});

nextMonth.addEventListener('click', () => {
    if (selectedMonth.value == maxMonth) {
        if (selectedYear.value == maxYear) {
            return;
        } else {
            selectedMonth.value = minMonth;
            selectedYear.value = parseInt(selectedYear.value) + 1;
            displayButton.click();
        }
    } else {
        selectedMonth.value = parseInt(selectedMonth.value) + 1;
        displayButton.click();
    }
});