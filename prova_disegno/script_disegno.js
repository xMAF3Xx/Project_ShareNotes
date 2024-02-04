// script_disegno.js

const canvas = document.getElementById('drawingCanvas');
const context = canvas.getContext('2d');
let isDrawing = false;
let drawingColor = '#ff0000'; 

function startDrawing(e) {
    isDrawing = true;
    draw(e);
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

    const { clientX, clientY } = e.touches ? e.touches[0] : e;
    const x = clientX - canvas.offsetLeft;
    const y = clientY - canvas.offsetTop;

    context.lineWidth = 5;
    context.lineCap = 'round';
    context.strokeStyle = drawingColor; // Utilizza il colore del disegno

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

// Aggiungi un ascoltatore per l'input del selettore di colore
const colorPicker = document.getElementById('colorPicker');
colorPicker.addEventListener('input', function() {
    setDrawingColor(colorPicker.value);
});

// Imposta le dimensioni della canvas come le dimensioni della finestra
var canvasDim = document.querySelector('canvas');
canvasDim.width = window.innerWidth;
canvasDim.height = window.innerHeight;
