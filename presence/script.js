//On crée une date
let date1 = new Date();

let dateLocale = date1.toLocaleString('fr-FR',{
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'});

document.getElementById('p1').innerHTML = dateLocale;
