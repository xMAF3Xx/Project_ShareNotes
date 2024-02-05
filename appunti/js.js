const canvas = document.getElementById('drawingCanvas');
const context = canvas.getContext('2d');
let isDrawing = false;
let drawingColor = '#ff0000';

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

function startDrawing(e) {
    isDrawing = true;
    context.beginPath();
    context.moveTo(e.clientX - canvas.offsetLeft, e.clientY - canvas.offsetTop);
}

function stopDrawing() {
    isDrawing = false;
    context.beginPath();
}

function setDrawingColor(color) {
    drawingColor = color;
}

function draw(e) {
    if (!isDrawing) return;

    context.lineWidth = 5;
    context.lineCap = 'round';
    context.strokeStyle = drawingColor;

    context.lineTo(e.clientX - canvas.offsetLeft, e.clientY - canvas.offsetTop);
    context.stroke();
    context.beginPath();
    context.moveTo(e.clientX - canvas.offsetLeft, e.clientY - canvas.offsetTop);
}

canvas.addEventListener('mousedown', startDrawing);
canvas.addEventListener('mouseup', stopDrawing);
canvas.addEventListener('mousemove', draw);

canvas.addEventListener('touchstart', function(e) {
    if (e.touches.length === 1) {
        startDrawing(e.touches[0]);
    }
});

canvas.addEventListener('touchend', stopDrawing);
canvas.addEventListener('touchmove', function(e) {
    if (isDrawing) {
        draw(e.touches[0]);
    }
});

window.addEventListener('resize', function() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});

const colorPicker = document.getElementById('colorPicker');
colorPicker.addEventListener('input', function() {
    setDrawingColor(colorPicker.value);
});
