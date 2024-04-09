    function Esporta(Canvas){
        const canvasA = document.getElementById(Canvas);
        //canvasA.getContext("2d").fillRect(10, 10, 20, 20);
        const base64 = canvasA.toDataURL();
        var Input = document.getElementById("salvaImmagine");
        Input.value = base64;
    }

    function Importa(Canvas){
        const canvasB = document.getElementById(Canvas);
        const img = new Image();
        img.onload = function() {
            canvasB
            .getContext("2d")
            .drawImage(this, 0, 0, canvasB.width, canvasB.height);
        };
        const immagine = document.getElementById("contenutoNota").value;
        img.src = immagine;
    }

    function SendIt(drawArea){
        Esporta(drawArea);
        document.forms["fTSend"].submit();
    }

    function Esporta2(Canvas){
        const canvasA = document.getElementById(Canvas);
        //canvasA.getContext("2d").fillRect(10, 10, 20, 20);
        const base64 = canvasA.toDataURL();
        var Input = document.getElementById("contenutoTemp");
        Input.value = base64;
    }

    function SendTwo(drawArea){
        Esporta2(drawArea);
        document.forms["Temp"].submit();
    }