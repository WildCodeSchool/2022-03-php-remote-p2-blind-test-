const player = document.querySelector('audio');
const boxMUsic = document.querySelector('.boxContainer');

player.addEventListener("play", function() {
    boxMUsic.classList.toggle("invisible");
});

player.addEventListener("pause", function() {
    boxMUsic.classList.toggle("invisible");
});

