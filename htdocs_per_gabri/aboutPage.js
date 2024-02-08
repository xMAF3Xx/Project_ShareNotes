function toggleBlocco(blocco, centroId) {
    blocco.classList.toggle("visible");
    var centroElement = document.getElementById(centroId);

    if (blocco.classList.contains("visible")) {
        centroElement.style.display = "none";
    } else {
        centroElement.style.display = "block";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    var blocco1 = document.querySelector(".blocco");
    var blocco2 = document.querySelector(".blocco2");
    var blocco3 = document.querySelector(".blocco3");
    var blocco4 = document.querySelector(".blocco4");

    blocco1.addEventListener("click", function () {
        toggleBlocco(blocco1, "centro");
    });

    blocco2.addEventListener("click", function () {
        toggleBlocco(blocco2, "centro2");
    });

    blocco3.addEventListener("click", function () {
        toggleBlocco(blocco3, "centro3");
    });

    blocco4.addEventListener("click", function () {
        toggleBlocco(blocco4, "centro4");
    });
});

function apriLink() {
    var url = "https://hensemberger.edu.it";
    window.open(url, "_blank");
}