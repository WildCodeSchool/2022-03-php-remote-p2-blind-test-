function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

const updateChrono = function(seconds) {
    const counter = document.getElementById("counter");
    if (counter) {
        counter.innerText = seconds > 0 ?
            new Date(seconds * 1000).toISOString().substr(14, 5)  : '';
    }

}

let timer;
const chronometer = function (pageLoaded = true) {
    let endedAt = new Date(getCookie("endedAt") * 1000);

    let currentDate = new Date();
    // calculate time before the end of laps in milliseconds
    let endedIn = endedAt.getTime() - currentDate.getTime();

    if (endedIn > 0) {
        timer = setTimeout(function () {
            chronometer(false);
        }, 1000)
    } else {
        clearTimeout(timer);
        endedIn = 0;
        if (!pageLoaded) {
            window.location.href = "/";
        }
    }
    updateChrono(Math.ceil(endedIn / 1000))
}

chronometer();

function validate() {
    if (document.forms.form.validate[0].checked) alert('1');// permet de tester le choix 1
    if (document.forms.form.validate[1].checked) alert('2');// permet de tester le choix 2
    if (document.forms.form.validate[2].checked) alert('3');// permet de tester le choix 3
    if (document.forms.form.validate[3].checked) alert('4');// permet de tester le choix 3
}
