const buttonEasy = document.querySelector('.easy');
const buttonHard = document.querySelector('.hard');
const h1Categry = document.querySelector('.h1-category');
const h2Categry = document.querySelector('.h2-category');

let chemin = window.location.href;
let id = chemin. split("?");
let time_seconds = 3;

// Fonction qui gère le compte à rebours
function startCountDown(duration, element) {

    let secondsRemaining = duration;
    let sec = 0;

    let countInterval = setInterval(function () {
        sec = parseInt(secondsRemaining % 60);

        element.textContent = sec;
       // On décrémente le compte à rebours
        secondsRemaining = secondsRemaining - 1;
        if (secondsRemaining < 0) {
            element.classList.toggle("invisible");
            clearInterval(countInterval);
            document.location.href= "/quizz/start?"+ id[1] +"&level=" + level;
        };
    }, 1000);
}

// Ont cache le bouton, on rend le compte à rebours visible et on lance l'animation au click du bouton.
function service(button1, button2, mode) {
    button1.classList.toggle("invisible");
    button2.classList.toggle("invisible");
    level = mode;
    startCountDown(--time_seconds, element);
    h1Categry.classList.toggle("invisible");
    h2Categry.classList.toggle("invisible");
    element.classList.toggle("invisible");
    element.classList.toggle("time");
}


window.onload = function () {
    element = document.querySelector('#count-down-timer');
    element.textContent = time_seconds;
    buttonEasy.addEventListener("click", function () {
        service(buttonEasy, buttonHard, 1);
    });
    buttonHard.addEventListener("click", function () {
        service(buttonHard, buttonEasy, 2);
    });
};
