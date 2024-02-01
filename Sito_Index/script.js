let prevScrollpos = window.pageYOffset;

window.onscroll = function() {
    let currentScrollPos = window.pageYOffset;
    let navbar = document.getElementById("navbar");

    if (prevScrollpos > currentScrollPos) {
        navbar.style.top = "0";
        navbar.style.opacity = "1"; // Mostra gradualmente
    } else {
        navbar.style.top = "-50px"; // Aggiusta in base all'altezza della tua barra di navigazione
        navbar.style.opacity = "0"; // Scompare gradualmente
    }

    prevScrollpos = currentScrollPos;
}

function azione(variabile) { 
    if(document.getElementById(variabile).style.display=='') { 
    document.getElementById(variabile).style.display='none'; 
    }else{ 
    document.getElementById(variabile).style.display=''; 
    } 
}