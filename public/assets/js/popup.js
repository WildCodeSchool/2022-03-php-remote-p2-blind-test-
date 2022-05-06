const myModal = setTimeout(myGreeting, 3000);
const modal = document.getElementById("myModal");
const close = document.getElementById('close');
const h1 = document.getElementById('h1');

function myGreeting() {
    modal.classList.remove('d-none');
    modal.classList.add('animation-modal');
    h1.classList.add('d-none');
  }

  close.addEventListener('click', () => {
      modal.classList.add('d-none');
      h1.classList.remove('d-none');
});


