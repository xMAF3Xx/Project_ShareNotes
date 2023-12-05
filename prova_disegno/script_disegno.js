const canvas = document.getElementById('drawingCanvas');
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