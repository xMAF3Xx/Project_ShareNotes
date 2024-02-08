function disegno(canva){
    const canvas = document.getElementById(canva);
    const context = canvas.getContext('2d');
    let isDrawing = false;

    function startDrawing(e) {
        isDrawing = true;
        draw(e);
    }

    function stopDrawing() {
        isDrawing = false;
        context.beginPath();
    }

    function draw(e) {
        if (!isDrawing) return;

        const { clientX, clientY } = e.touches ? e.touches[0] : e;
        const x = clientX - canvas.offsetLeft;
        const y = clientY - canvas.offsetTop;

        context.lineWidth = 5;
        context.lineCap = 'round';
        context.strokeStyle = '#000';

        context.lineTo(x, y);
        context.stroke();
        context.beginPath();
        context.moveTo(x, y);
    }

    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mousemove', draw);

    canvas.addEventListener('touchstart', startDrawing);
    canvas.addEventListener('touchend', stopDrawing);
    canvas.addEventListener('touchmove', draw);
}

    function Esporta(Canvas){
        const canvasA = document.getElementById(Canvas);
        canvasA.getContext("2d").fillRect(10, 10, 20, 20);
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