const myModal = setTimeout(myGreeting, 3000);
const modal = document.getElementById("myModal");
const close = document.getElementById('close');
const h1 = document.getElementById('h1');

function invisibleH1() {
    h1.classList.add('d-none');
}

function myGreeting() {
    modal.classList.remove('d-none');
    setTimeout(invisibleH1, 1000);
  }

  close.addEventListener('click', () => {
      modal.classList.add('d-none');
      h1.classList.remove('d-none');
});


