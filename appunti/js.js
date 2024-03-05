
const canvas = document.getElementById('drawingCanvas');
const context = canvas.getContext('2d');
const textarea = document.getElementById('textArea');
const finishButton = document.getElementById('finishButton');
const writeButton = document.getElementById('writeButton');
const eraseButton = document.getElementById('eraseButton');
const fontSelector = document.getElementById('fontSelector');
const fontSizeSelector = document.getElementById('fontSizeSelector');
const thicknessSlider = document.getElementById('thicknessSlider');
const ciao=document.getElementById('moveButton');
const hola=document.getElementById('blocco');
const h=document.getElementById("croce");
const f=document.getElementById("nota");
const g=document.getElementById("submit");
let drawingThickness = thicknessSlider.value;


let isDrawing = false;
let isTyping = false;
let isErasing = false;
let drawingColor = '#ff0000';
let currentText = '';
let drawings = [];
let clickStart = { x: 0, y: 0 };
let editingText = null;
let isBold = false;
let isItalic = false;
let isUnderline = false;
let eraseSize;

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;
let erasedDrawings = [];  // Array per mantenere le coordinate degli elementi cancellati

// ...
const gommaSlider = document.getElementById('gomma');
let gommaSize = gommaSlider.value;

gommaSlider.addEventListener('input', function () {
    gommaSize = gommaSlider.value;
});

function erase(e) {
    if (!isErasing) return;

    const mouseX = e.clientX - canvas.offsetLeft;
    const mouseY = e.clientY - canvas.offsetTop;

    context.clearRect(mouseX - gommaSize / 2, mouseY - gommaSize / 2, gommaSize, gommaSize);
}
// ...

function eraseAll() {
    // Aggiungi le coordinate degli elementi di tipo 'image' cancellati
    erasedDrawings = erasedDrawings.concat(
        drawings.filter(item => item.type === 'image').map(erasedDrawing => ({ x: 0, y: 0 }))
    );

    // Pulisci il canvas principale
    context.clearRect(0, 0, canvas.width, canvas.height);

    // Ridisegna gli elementi di tipo 'text' rimanenti nel canvas principale
    drawings.filter(item => item.type !== 'image').forEach(drawItem => {
        if (drawItem.type === 'text') {
            // Disegna il testo
            context.font = drawItem.font;
            context.fillStyle = drawItem.color;
            context.fillText(drawItem.text, drawItem.x, drawItem.y);

            // Applica sottolineato
            if (drawItem.textDecoration === 'underline') {
                const textMetrics = context.measureText(drawItem.text);
                const underlineY = drawItem.y + parseInt(drawItem.fontSize) + 5;
                context.beginPath();
                context.moveTo(drawItem.x, underlineY);
                context.lineTo(drawItem.x + textMetrics.width, underlineY);
                context.stroke();
            }
        }
    });

    // Ridisegna gli elementi cancellati con il colore bianco
    context.fillStyle = '#ffffff';  // Colore bianco
    erasedDrawings.forEach(erasedDrawing => {
        context.fillRect(erasedDrawing.x, erasedDrawing.y, eraseSize, eraseSize);
    });

}


function startDrawing(e) {
    if (isErasing) return;
    isDrawing = true;
    isTyping = false;

    const textCursor = document.getElementById('textCursor');
    textCursor.style.display = 'block';

    // Calcola la posizione del cursore rispetto al canvas
    const canvasX = e.clientX - canvas.offsetLeft;
    const canvasY = e.clientY - canvas.offsetTop;

    // Posiziona il cursore esattamente sopra il punto di inizio del testo
    textCursor.style.left = canvasX + 'px';
    textCursor.style.top = canvasY - textCursor.offsetHeight + canvas.offsetTop + 28 + 'px';
    context.beginPath();
    context.moveTo(canvasX, canvasY);
    clickStart = { x: canvasX, y: canvasY };
    updateCursorSize();
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

    context.lineWidth = drawingThickness;  // Usa lo spessore corrente
    context.lineCap = 'round';
    context.strokeStyle = drawingColor;

    context.lineTo(e.clientX - canvas.offsetLeft, e.clientY - canvas.offsetTop);
    context.stroke();
    context.beginPath();
    context.moveTo(e.clientX - canvas.offsetLeft, e.clientY - canvas.offsetTop);
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

    updateCursorSize();
}
function updateCursorSize() {
    const textCursor = document.getElementById('textCursor');
    const fontSize = getSelectedFontSize();
    const lineHeight = parseInt(fontSize) + 5; // Puoi regolare il valore in base alle tue preferenze
    textCursor.style.height = lineHeight + 'px';
}





function handleKeyDown(e) {
    if (!isTyping) return;

    if (e.key.length === 1) {
        currentText += e.key;
    } else if (e.key === 'Backspace') {
        currentText = currentText.slice(0, -1);
    }

    if (e.key === 'b') {
        isBold = !isBold;
    }

    if (e.key === 'i') {
        isItalic = !isItalic;
    }

    if (e.key === 'u') {
        isUnderline = !isUnderline;
    }

    redrawCanvas();
}

function redrawCanvas() {
    context.clearRect(0, 0, canvas.width, canvas.height);
    let currentText;
    for (const drawing of drawings) {
        if (drawing.type === 'text') {
            context.font = `${drawing.fontSize}px ${drawing.font}`;
            context.fillStyle = drawing.color;

            // Applica grassetto, corsivo e sottolineato
            if (isBold) context.font = `bold ${context.font}`;
            if (isItalic) context.font = `italic ${context.font}`;
            
            // Disegna il testo
            context.fillText(drawing.text, drawing.x, drawing.y);

            // Ripristina le impostazioni del font
            context.font = `${drawing.fontSize}px ${drawing.font}`;

            // Applica sottolineato
            if (isUnderline) {
                context.beginPath();
                context.moveTo(drawing.x, drawing.y + parseInt(drawing.fontSize) + 5);
                context.lineTo(drawing.x + context.measureText(drawing.text).width, drawing.y + parseInt(drawing.fontSize) + 5);
                context.stroke();
            }
        } else if (drawing.type === 'image') {
            context.putImageData(drawing.imageData, 0, 0);
        }
    }

    if (!isTyping && currentText !== '') {
        context.font = `${getSelectedFontSize()} ${fontSelector.value}`;
        context.fillStyle = drawingColor;

        if (isBold) context.font = `bold ${context.font}`;
        if (isItalic) context.font = `italic ${context.font}`;
        if (isUnderline && drawing.textDecoration === 'underline') {
            const textMetrics = context.measureText(drawing.text);
            const underlineY = drawing.y + parseInt(drawing.fontSize) + 5;
            context.beginPath();
            context.moveTo(drawing.x, underlineY);
            context.lineTo(drawing.x + textMetrics.width, underlineY);
            context.stroke();
        }

        
        context.font = `${getSelectedFontSize()} ${fontSelector.value}`;

        
        if (isUnderline) {
            context.beginPath();
            context.moveTo(clickStart.x, clickStart.y + parseInt(getSelectedFontSize()) + 5);
            context.lineTo(clickStart.x + context.measureText(currentText).width, clickStart.y + parseInt(getSelectedFontSize()) + 5);
            context.stroke();
        }
    }
}



function finishWriting() {
    isTyping = false;
    const text = textarea.value.trim();
    hideWritingOptions();

    if (text !== '') {
        let nextX, nextY;

        if (editingText !== null) {
            nextX = editingText.x;
            nextY = editingText.y;

            editingText.text = text;
            editingText.font = `${getSelectedFontSize()} ${fontSelector.value}`;
            editingText.fontSize = getSelectedFontSize();
            editingText.color = drawingColor;
            editingText.textDecoration = isUnderline ? 'underline' : 'none';
        } else {
 
            nextX = clickStart.x;
            nextY = clickStart.y + parseInt(getSelectedFontSize()) + 10;

            drawings = drawings.filter(drawing => drawing.type !== 'text');
            
            let appliedStyles = '';

            if (isBold) appliedStyles += 'bold ';
            if (isItalic) appliedStyles += 'italic ';
            if (isUnderline) appliedStyles += 'underline ';

            const fontStyle = `${appliedStyles}${getSelectedFontSize()} ${fontSelector.value}`;

            
            const newDrawing = {
                type: 'text',
                text: text,
                x: nextX,
                y: nextY,
                font: fontStyle,
                fontSize: getSelectedFontSize(),
                color: drawingColor,
                textDecoration: isUnderline ? 'underline' : 'none' 
            };

            drawings.push(newDrawing);
        }

        
        context.font = `${getSelectedFontSize()} ${fontSelector.value}`;
        context.fillStyle = drawingColor;
        context.fillText(text, nextX, nextY);

        redrawCanvas();
    }

    currentText = '';
}




function redrawCanvas() {
    context.clearRect(0, 0, canvas.width, canvas.height);

    for (const drawing of drawings) {
        if (drawing.type === 'text') {
            context.font = drawing.font;
            context.fillStyle = drawing.color;

            // Disegna il testo
            context.fillText(drawing.text, drawing.x, drawing.y);

            // Applica sottolineato
            if (drawing.textDecoration === 'underline') {
                const textMetrics = context.measureText(drawing.text);
                const underlineY = drawing.y + parseInt(drawing.fontSize) + 5;
                context.beginPath();
                context.moveTo(drawing.x, underlineY);
                context.lineTo(drawing.x + textMetrics.width, underlineY);
                context.stroke();
            }
        } else if (drawing.type === 'image') {
            context.putImageData(drawing.imageData, 0, 0);
        }
    }

    if (isTyping && currentText !== '') {
        const fontStyle = `${getSelectedFontSize()} ${fontSelector.value}`;
        context.font = fontStyle;
        context.fillStyle = drawingColor;

        // Applica grassetto, corsivo e sottolineato
        if (isBold) context.font = `bold ${context.font}`;
        if (isItalic) context.font = `italic ${context.font}`;
        if (isUnderline) {
            const textMetrics = context.measureText(currentText);
            const underlineY = clickStart.y + parseInt(getSelectedFontSize()) + 5;
            context.beginPath();
            context.moveTo(clickStart.x, underlineY);
            context.lineTo(clickStart.x + textMetrics.width, underlineY);
            context.stroke();
        }

        // Non disegnare il testo qui
    }
}




function getUpdatedFontStyle(fontStyle) {
    // Aggiorna gli stili al font in base allo stato corrente di grassetto e corsivo
    return `${fontStyle} ${isBold ? 'bold' : ''} ${isItalic ? 'italic' : ''}`;
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
let lastClickedText = null;
function editText(e) {
    if (isDrawing || isErasing || !isTyping) return;

    const mouseX = e.clientX - canvas.offsetLeft;
    const mouseY = e.clientY - canvas.offsetTop;

    // Trova l'elemento di testo su cui l'utente ha cliccato
    for (let i = drawings.length - 1; i >= 0; i--) {
        const drawing = drawings[i];
        if (drawing.type === 'text') {
            context.font = `${drawing.fontSize} ${drawing.font}`;
            const textWidth = context.measureText(drawing.text).width;
            const lineHeight = parseInt(drawing.fontSize) + 10;

            if (
                mouseX > drawing.x &&
                mouseX < drawing.x + textWidth &&
                mouseY > drawing.y - lineHeight &&
                mouseY < drawing.y
            ) {
                // Imposta la variabile editingText quando viene cliccato un testo
                editingText = drawing;
                lastClickedText = null;
                enableWriting();
                return;
            }
        }
    }

    // Se non è stato cliccato nessun testo, esegui il normale comportamento di editText
    lastClickedText = null;
    editingText = null; // Aggiunta per assicurarsi che la variabile sia resettata quando non si sta modificando
    enableWriting();
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
thicknessSlider.addEventListener('input', function () {
    drawingThickness = thicknessSlider.value;
});
moveButton.addEventListener('click', function() {
    if (hola.style.display === 'block') {
        hola.style.display = 'none'; 
    } else {
        hola.style.display = 'block'; 
    }
});
let alertShown = false;

h.addEventListener('click',function(){
    hola.style.display='none';
})
f.addEventListener('input',function(){
    if(this.value.length>20 && !alertShown)
    {
        alert("non puoi inserire un nome che superi i 20 caratteri");
        alertShown = true;
         g.disabled=true;
    }
    else if(this.value.length<5 || (this.value.toLowerCase() === "notabianca"))
    {
        g.disabled=true;
    }
    else
    {
        g.disabled=false;
    }
})



function handleKeyUp(e) {
    if (!isTyping) return;

    if (e.key === 'b') {
        isBold = false;
    }

    if (e.key === 'i') {
        isItalic = false;
    }

    if (e.key === 'u') {
        isUnderline = false;
    }

    redrawCanvas();
}

document.addEventListener('keyup', handleKeyUp);
function toggleBold() {
    isBold = !isBold;
    redrawCanvas();
}

function toggleItalic() {
    isItalic = !isItalic;
    redrawCanvas();
}

function toggleUnderline() {
    isUnderline = !isUnderline;
    redrawCanvas();
}