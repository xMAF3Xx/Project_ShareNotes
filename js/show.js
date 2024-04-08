function imgShow(immagine){
    const selec = document.getElementById(immagine);
    const img = new Image();
    img.onload = function() {
        selec
        //.getContext("2d")
        .drawImage(this, 0, 0, selec.width, selec.height);
    };
    const codice = document.getElementById("content").value;
    img.src = codice;
}