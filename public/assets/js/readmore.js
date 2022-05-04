function myFunction() {
     const moreText = document.getElementById("more");
    const btnText = document.getElementById("myBtn");

    if (moreText.style.display === "none") {
      btnText.innerHTML = "Show less";
      moreText.style.display = "inline";
    } else {

      btnText.innerHTML = "Full Ranking";
      moreText.style.display = "none";

    }
  }
