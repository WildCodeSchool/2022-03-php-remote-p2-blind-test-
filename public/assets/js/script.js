const lancer = document.querySelector('.btn-lancer');

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
            document.location.href= "/quizz/start?"+ id[1];
        };
    }, 1000);
}

// Ont cache le bouton, on rend le compte à rebours visible et on lance l'animation au click du bouton.
window.onload = function () {
    element = document.querySelector('#count-down-timer');
    element.textContent = time_seconds;
    lancer.addEventListener("click", function () {
        lancer.classList.toggle("invisible");
        startCountDown(--time_seconds, element);
        element.classList.toggle("invisible");
        element.classList.toggle("time");
    });
};
