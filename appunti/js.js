const canvas = document.getElementById('drawingCanvas');
const context = canvas.getContext('2d');
const editor = document.getElementById('editor');

let isDrawing = false;
let isTyping = false;
let drawingColor = '#ff0000';
let currentText = '';

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

function startDrawing(e) {
    isDrawing = true;
    isTyping = false;
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

function handleKeyDown(e) {
    if (!isTyping) return;

    if (e.key.length === 1) {
        currentText += e.key;
        context.font = '20px Arial';
        context.fillStyle = drawingColor;
        context.fillText(currentText, e.clientX - canvas.offsetLeft, e.clientY - canvas.offsetTop);
    } else if (e.key === 'Backspace') {
        currentText = currentText.slice(0, -1);
        redrawCanvas();
    }
}

function redrawCanvas() {
    context.clearRect(0, 0, canvas.width, canvas.height);
    if (currentText !== '') {
        context.font = '20px Arial';
        context.fillStyle = drawingColor;
        context.fillText(currentText, 50, 50);
    }
}

canvas.addEventListener('mousedown', startDrawing);
canvas.addEventListener('mouseup', stopDrawing);
canvas.addEventListener('mousemove', draw);

window.addEventListener('resize', function () {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    redrawCanvas();
});

document.addEventListener('keydown', handleKeyDown);

const colorPicker = document.getElementById('colorPicker');
colorPicker.addEventListener('input', function () {
    setDrawingColor(colorPicker.value);
});

// Aggiungi un gestore di eventi click alla canvas
editor.addEventListener('click', function () {
    // Imposta il focus sulla canvas quando viene cliccata
    editor.focus();
    isTyping = true;
});

// Aggiungi un gestore di eventi keydown alla canvas
editor.addEventListener('keydown', function (e) {
    // Inserisci il testo sulla canvas
    editor.innerHTML += e.key;
    // Impedisce l'azione predefinita della tastiera per evitare la duplicazione del testo
    e.preventDefault();
});
 