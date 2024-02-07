const canvas = document.getElementById('drawingCanvas');
const context = canvas.getContext('2d');
const textarea = document.getElementById('textArea');
const finishButton = document.getElementById('finishButton');
const writeButton = document.getElementById('writeButton');
const eraseButton = document.getElementById('eraseButton');
const fontSelector = document.getElementById('fontSelector');
const fontSizeSelector = document.getElementById('fontSizeSelector');

let isDrawing = false;
let isTyping = false;
let isErasing = false;
let drawingColor = '#ff0000';
let currentText = '';
let drawings = [];
let clickStart = { x: 0, y: 0 };
let editingText = null;

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

function startDrawing(e) {
    if (isErasing) return;
    isDrawing = true;
    isTyping = false;
    context.beginPath();
    context.moveTo(e.clientX - canvas.offsetLeft, e.clientY - canvas.offsetTop);
    clickStart = { x: e.clientX - canvas.offsetLeft, y: e.clientY - canvas.offsetTop };
}

function stopDrawing() {
    if (isErasing) return;
    isDrawing = false;
    context.beginPath();
    drawings.push({
        type: 'image',
        imageData: context.getImageData(0, 0, canvas.width, canvas.height)
    });
}

function setDrawingColor(color) {
    drawingColor = color;
}

function draw(e) {
    if (!isDrawing || isErasing) return;

    context.lineWidth = 5;
    context.lineCap = 'round';
    context.strokeStyle = drawingColor;

    context.lineTo(e.clientX - canvas.offsetLeft, e.clientY - canvas.offsetTop);
    context.stroke();
    context.beginPath();
    context.moveTo(e.clientX - canvas.offsetLeft, e.clientY - canvas.offsetTop);
}

function erase(e) {
    if (!isErasing) return;

    const mouseX = e.clientX - canvas.offsetLeft;
    const mouseY = e.clientY - canvas.offsetTop;

    const eraseSize = 20;
    context.clearRect(mouseX - eraseSize / 2, mouseY - eraseSize / 2, eraseSize, eraseSize);
}

function toggleEraser() {
    isErasing = !isErasing;
    if (isErasing) {
        canvas.style.cursor = 'url("https://cdn-icons-png.flaticon.com/512/2728/2728991.png"), auto';
    } else {
        canvas.style.cursor = 'auto';
    }
}

function setFont(font) {
    context.font = `${getSelectedFontSize()} ${font}`;
    redrawCanvas();
}

function setFontSize(fontSize) {
    fontSizeSelector.value = fontSize;
    context.font = `${fontSize} ${fontSelector.value}`;
    redrawCanvas();
}

function handleKeyDown(e) {
    if (!isTyping) return;

    if (e.key.length === 1) {
        currentText += e.key;
    } else if (e.key === 'Backspace') {
        currentText = currentText.slice(0, -1);
    }

    redrawCanvas();
}

function redrawCanvas() {
    context.clearRect(0, 0, canvas.width, canvas.height);

    for (const drawing of drawings) {
        if (drawing.type === 'text') {
            if (drawing !== editingText) {
                context.font = `${drawing.fontSize} ${drawing.font}`;
                context.fillStyle = drawing.color;
                context.fillText(drawing.text, drawing.x, drawing.y);
            }
        } else if (drawing.type === 'image') {
            context.putImageData(drawing.imageData, 0, 0);
        }
    }

    if (!isTyping && currentText !== '') {
        context.font = `${getSelectedFontSize()} ${fontSelector.value}`;
        context.fillStyle = drawingColor;
        context.fillText(currentText, clickStart.x, clickStart.y);
    }
}


function finishWriting() {
    isTyping = false;
    const text = textarea.value.trim(); // Rimuovi gli spazi vuoti all'inizio e alla fine del testo
    textarea.value = '';
    hideWritingOptions();

    if (text !== '') { // Controlla se il testo non è vuoto dopo la rimozione degli spazi vuoti
        const nextX = clickStart.x;
        const nextY = clickStart.y + parseInt(getSelectedFontSize()) + 10;

        if (editingText !== null) {
            // Trova l'indice della versione precedente della parola
            const index = drawings.findIndex(drawing => drawing.type === 'text' && drawing === editingText);

            // Sostituisci la vecchia parola con la nuova parola
            drawings[index].text = text;
        } else {
            // Disegna il testo
            context.font = `${getSelectedFontSize()} ${fontSelector.value}`;
            context.fillStyle = drawingColor;
            context.fillText(text, nextX, nextY);

            // Aggiungi il testo all'array
            drawings.push({
                type: 'text',
                text: text,
                x: nextX,
                y: nextY,
                font: `${getSelectedFontSize()} ${fontSelector.value}`,
                fontSize: getSelectedFontSize(),
                color: drawingColor
            });
        }
    }

    currentText = '';
}






function eraseAll() {
    context.clearRect(0, 0, canvas.width, canvas.height);
    drawings = [];
}

function enableWriting() {
    isDrawing = false;
    isTyping = true;
    canvas.style.cursor = 'auto';
    textarea.style.display = 'block';
    finishButton.style.display = 'block';
    textarea.focus();

    if (editingText !== null) {
        textarea.value = editingText.text;
    }
}

function hideWritingOptions() {
    textarea.style.display = 'none';
    finishButton.style.display = 'none';
    editingText = null;
}

function getSelectedFontSize() {
    return fontSizeSelector.value + 'px';
}

function editText(e) {
    if (isDrawing || isErasing) return;

    const mouseX = e.clientX - canvas.offsetLeft;
    const mouseY = e.clientY - canvas.offsetTop;

    for (const drawing of drawings) {
        if (drawing.type === 'text') {
            context.font = `${drawing.fontSize} ${drawing.font}`;
            const textWidth = context.measureText(drawing.text).width;
            const lineHeight = parseInt(drawing.fontSize) + 10;

            if (mouseX > drawing.x && mouseX < drawing.x + textWidth &&
                mouseY > drawing.y - lineHeight && mouseY < drawing.y) {
                editingText = drawing;
                currentText = drawing.text;
                redrawCanvas();
                enableWriting();
                break;
            }
        }
    }
}

fontSelector.addEventListener('change', function () {
    setFont(fontSelector.value);
});

fontSizeSelector.addEventListener('change', function () {
    setFontSize(fontSizeSelector.value);
});

eraseButton.addEventListener('click', function () {
    toggleEraser();
});

canvas.addEventListener('mousedown', startDrawing);
canvas.addEventListener('mouseup', stopDrawing);
canvas.addEventListener('mousemove', function (e) {
    if (isErasing) {
        erase(e);
    } else if (isDrawing) {
        draw(e);
    }
});
canvas.addEventListener('click', editText);

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

writeButton.addEventListener('click', function () {
    eraseAll();
    enableWriting();
});

finishButton.addEventListener('click', finishWriting);

document.addEventListener('keyup', function (e) {
    if (e.key === 'Enter' && isTyping) {
        finishWriting();
    }
});
