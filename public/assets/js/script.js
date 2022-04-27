const formQuiz = document.getElementById('form-quiz');
const audio = document.querySelector('audio');
let time_seconds = 5;

// Fonction qui gère le compte à rebours
function startCountDown(duration, element) {

    let secondsRemaining = duration;
    let sec = 0;

    let countInterval = setInterval(function () {
        sec = parseInt(secondsRemaining % 60);

        element.textContent = sec;
       // On décrémente le compte à rebours
        secondsRemaining = secondsRemaining - 1;

        // Si le compte à rebours < 0 alors ont cache le compte à rebours, ont affiche le formulaire et on lance la musique
        if (secondsRemaining < 0) {
            clearInterval(countInterval);
            element.classList.toggle("time");
            element.classList.toggle("invisible");
            formQuiz.classList.toggle("invisible");
            audio.play();};
    }, 1000);
}

// Affichage du compte à rebours dans le DOM
window.onload = function () {
    element = document.querySelector('#count-down-timer');
    element.textContent = time_seconds;
    startCountDown(--time_seconds, element);
    element.classList.toggle("time");
};

// Ont cache le bouton, on rend le compte à rebours visible et on lance l'animation au click du bouton.
// play.addEventListener("click", function (event) {
//     play.classList.toggle("invisible");
//     element.classList.toggle("invisible");
//     element.classList.toggle("time");

// });
