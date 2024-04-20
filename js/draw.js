const canvas = document.getElementById('drawingCanvas');
const context = canvas.getContext('2d');
const textarea = document.getElementById('textArea');
const finishButton = document.getElementById('finishButton');
const writeButton = document.getElementById('writeButton');
const eraseButton = document.getElementById('eraseButton');
const fontSelector = document.getElementById('fontSelector');
const fontSizeSelector = document.getElementById('fontSizeSelector');
const thicknessSlider = document.getElementById('thicknessSlider');
const ciao = document.getElementById('moveButton');
const hola = document.getElementById('blocco');
const h = document.getElementById("croce");
const f = document.getElementById("nota");
const uscita = document.getElementById('uscita');
const g = document.getElementById("submit");
let drawingThickness = thicknessSlider.value;
const v = document.getElementById("tutto");
const l = document.getElementById("apri");
const p = document.getElementById("chiudi");
v.style.display = 'none';
const s = document.getElementById("croce");
const d = document.getElementById("annulla");
const tutto2 = document.getElementById("tutto2");
let isCreating=false;
let firstTimeClick = true;


g.style.backgroundColor = "gray";
g.style.borderColor = "gray";
g.classList.add("submit-senza-hover");

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
let erasedDrawings = []; 

// ...
const gommaSlider = document.getElementById('gomma');
let gommaSize = gommaSlider.value;

gommaSlider.addEventListener('input', function() {
    gommaSize = gommaSlider.value;
});

function redrawCanvas() {
    context.fillStyle = '#FFFFFF';
    context.fillRect(0, 0, canvas.width, canvas.height);
    circles.forEach(circle => {
        drawCircle(circle.x, circle.y, circle.radius);
    });
    triangles.forEach(triangle => {
        drawTriangle(triangle.x1, triangle.y1, triangle.x2, triangle.y2);
    });

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

    }
}



let isZoomingOrDezooming = false;


canvas.addEventListener('zoomstart', function() {
    isZoomingOrDezooming = true;
});

canvas.addEventListener('zoomend', function() {
    isZoomingOrDezooming = false;
});


function erase(e) {
    if (!isErasing) return;

    const mouseX = e.clientX - canvas.offsetLeft;
    const mouseY = e.clientY - canvas.offsetTop;

    // "Cancella" il disegno aggiungendo la sua posizione all'array erasedDrawings
    erasedDrawings.push({ x: mouseX, y: mouseY });

    // Pulisci solo la zona dove è presente la gomma
    context.fillStyle = '#FFFFFF';
    context.fillRect(mouseX - gommaSize / 2, mouseY - gommaSize / 2, gommaSize, gommaSize);
}

//Prova da qui: OKK
function eraseTouch(e) {
    if (!isErasing) return;

    var x, y;
    if (e.type.startsWith('touch')) {
        // Handle touch event
        var touch = e.touches[0]; // Get the first touch point
        x = touch.clientX - canvas.offsetLeft;
        y = touch.clientY - canvas.offsetTop;
    } else {
        // Handle mouse event
        x = e.clientX - canvas.offsetLeft;
        y = e.clientY - canvas.offsetTop;
    }

    // "Cancella" il disegno aggiungendo la sua posizione all'array erasedDrawings
    erasedDrawings.push({ x: x, y: y });

    // Pulisci solo la zona dove è presente la gomma
    context.fillStyle = '#FFFFFF';
    context.fillRect(x - gommaSize / 2, y - gommaSize / 2, gommaSize, gommaSize);
}
//Fine prova OKK


function startDrawing(e) {
    if (isErasing || isCreating) return;
    isDrawing = true;
    isTyping = false;

    const textCursor = document.getElementById('textCursor');
    textCursor.style.display = 'block';

    // Calcola la posizione del cursore rispetto al canvas
    const canvasX = e.clientX - canvas.offsetLeft;
    const canvasY = e.clientY - canvas.offsetTop;

    // Posiziona il cursore esattamente sopra il punto di inizio del testo
    textCursor.style.left = canvasX - 560 + 'px';
    textCursor.style.top = canvasY - textCursor.offsetHeight + canvas.offsetTop +20 + 'px';
    context.beginPath();
    context.moveTo(canvasX, canvasY);
    clickStart = { x: canvasX, y: canvasY };
    updateCursorSize();
}

//Prova da qui:
function startDrawingTouch(e) {
    if (isErasing || isCreating) return;
    isDrawing = true;
    isTyping = false;

    const textCursor = document.getElementById('textCursor');
    textCursor.style.display = 'block';

    // Determine if the event is from a touch device
    let clientX, clientY;
    if (e.type.startsWith('touch')) {
        // Prevent default behavior like scrolling
        e.preventDefault();
        clientX = e.touches[0].clientX;
        clientY = e.touches[0].clientY;
    } else {
        clientX = e.clientX;
        clientY = e.clientY;
    }

    // Calculate the position relative to the canvas
    const canvasX = clientX - canvas.offsetLeft;
    const canvasY = clientY - canvas.offsetTop;

    // Position the cursor exactly above the start point of the text
    textCursor.style.left = canvasX - 560 + 'px'; // Adjust this value based on your specific layout
    textCursor.style.top = canvasY - textCursor.offsetHeight + canvas.offsetTop + 20 + 'px';

    context.beginPath();
    context.moveTo(canvasX, canvasY);
    clickStart = { x: canvasX, y: canvasY };
    updateCursorSize();
}
//Fine prova

canvas.addEventListener('mousemove', function(e) {

    if (isErasing) {
        erase(e);
    } else if (isDrawing) {
        draw(e);
    }
    if (isDragging && draggedText !== null) {
        const mouseX = e.clientX - canvas.offsetLeft;
        const mouseY = e.clientY - canvas.offsetTop;

        const deltaX = mouseX - lastMouseX;
        const deltaY = mouseY - lastMouseY;

        // Sposta il testo
        draggedText.x += deltaX;
        draggedText.y += deltaY;

        // Ridisegna il canvas con il testo spostato
        redrawCanvas();

        // Aggiorna le coordinate del mouse
        lastMouseX = mouseX;
        lastMouseY = mouseY;
    }
});

//Prova da qui: OKK
canvas.addEventListener('touchmove', function(e){
    if (isErasing) {
        eraseTouch(e);
    } else if (isDrawing) {
        draw(e);
    }
});
canvas.addEventListener('touchstart', startDrawingTouch);
canvas.addEventListener('touchend', stopDrawing);
//Fine prova OKK



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
    
    var isTouch = e.type.startsWith('touch');
    e.preventDefault();
   
    var x, y;
    if (isTouch) {

        x = e.touches[0].clientX - canvas.offsetLeft;
        y = e.touches[0].clientY - canvas.offsetTop;
    } else {
        
        x = e.clientX - canvas.offsetLeft;
        y = e.clientY - canvas.offsetTop;
    }

    
    context.lineWidth = drawingThickness; 
    context.lineCap = 'round';
    context.strokeStyle = drawingColor;

    context.lineTo(x, y);
    context.stroke();
    context.beginPath();
    context.moveTo(x, y);
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
    context.fillStyle = '#FFFFFF';
    context.fillRect(0, 0, canvas.width, canvas.height);
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



const riquadro=document.getElementById("fotina3");
const barretta=document.getElementById("barretta");
barretta.style.display='none';

riquadro.addEventListener('click',function(){
    if(barretta.style.display==='block')
    {
        barretta.style.display='none';
    }
    else if(barretta2.style.display==='block') 
    {
      barretta2.style.display='none';
      barretta.style.display='block';
    }
    else if(barretta7.style.display==='block') 
    {
      barretta7.style.display='none';
      barretta.style.display='block';
    }
    
    else
    {
        barretta.style.display='block';
    }
})

const riquadro2=document.getElementById("fotina4");
const barretta2=document.getElementById("barretta2");
barretta2.style.display='none';

riquadro2.addEventListener('click',function(){
    if(barretta2.style.display==='block')
    {
        barretta2.style.display='none';
    }
    else if(barretta.style.display==='block') 
    {
      barretta.style.display='none';
      barretta2.style.display='block';
    }
    else if(barretta7.style.display==='block') 
    {
      barretta7.style.display='none';
      barretta2.style.display='block';
    }
    else
    {
        barretta2.style.display='block';
    }
})

canvas.addEventListener('mousedown', function(e) {
    if (e.button === 1) { // Controllo se il pulsante premuto è il pulsante centrale del mouse
        isDragging = true;
        lastMouseX = e.clientX - canvas.offsetLeft;
        lastMouseY = e.clientY - canvas.offsetTop;

        // Trova il testo su cui è stato fatto clic
        for (let i = drawings.length - 1; i >= 0; i--) {
            const drawing = drawings[i];
            if (drawing.type === 'text') {
                context.font = `${drawing.fontSize} ${drawing.font}`;
                const textWidth = context.measureText(drawing.text).width;
                const lineHeight = parseInt(drawing.fontSize) + 10;

                if (
                    lastMouseX > drawing.x &&
                    lastMouseX < drawing.x + textWidth &&
                    lastMouseY > drawing.y - lineHeight &&
                    lastMouseY < drawing.y
                ) {
                    // Imposta il testo corrente come quello da trascinare
                    draggedText = drawing;
                    break;
                }
            }
        }
    }
});


canvas.addEventListener('mouseup', function(e) {
    if (e.button === 1 && isDragging) { // Controllo se il pulsante rilasciato è il pulsante centrale del mouse
        isDragging = false;
        draggedText = null;
    }
});

canvas.addEventListener('mousemove', function(e) {
     if (isDragging && draggedText !== null) {
        const mouseX = e.clientX - canvas.offsetLeft;
        const mouseY = e.clientY - canvas.offsetTop;

        const deltaX = mouseX - lastMouseX;
        const deltaY = mouseY - lastMouseY;

        // Sposta il testo
        draggedText.x += deltaX;
        draggedText.y += deltaY;

        // Ridisegna il canvas con il testo spostato
        redrawCanvas();

        // Aggiorna le coordinate del mouse
        lastMouseX = mouseX;
        lastMouseY = mouseY;
    }
});



const riquadro3=document.getElementById("fotina5");
let interazioneAbilitata;
const riquadro4=document.getElementById("moveButton");
const riquadro5=document.getElementById("chiudi");

riquadro3.addEventListener('click', function() {
    if (interazioneAbilitata) {
        barretta2.style.display='none';
        barretta7.style.display='none';
        riquadro.style.display='none';
        riquadro2.style.display='none';
        riquadro4.style.display='none';
        riquadro5.style.display='none';
        uscita.style.display='none';
        barretta.style.display='none';
        riquadro7.style.display='none';


        isCreating=true;
        interazioneAbilitata = false;
    } else {
        // Riattiva l'interazione con il canvas
        riquadro.style.display='block';
        riquadro2.style.display='block';
        uscita.style.display='block';
        riquadro4.style.display='block';
        riquadro5.style.display='block';
        riquadro7.style.display='block';
        isCreating=false;
        interazioneAbilitata = true;
    }
});

let isCreatingTriangle = false;
let triangles = []; // Array per memorizzare tutti i triangoli creati
let start3X, start3Y, current3X, current3Y;

const forme3Button = document.getElementById('forme2');



forme3Button.addEventListener('click', function() {
    isCreatingTriangle = !isCreatingTriangle; // Cambia lo stato del flag
    if (!isCreatingTriangle) {
        // Se smettiamo di creare triangoli, rimuoviamo anche l'ascoltatore di eventi mousemove
        canvas.removeEventListener('mousemove', onMouseMoveTriangle);
    }
});


canvas.addEventListener('mousedown', function(e) {
    if (isCreatingTriangle) {
        start3X = e.clientX - canvas.offsetLeft;
        start3Y = e.clientY - canvas.offsetTop;
        current3X = start3X;
        current3Y = start3Y;
        redrawCanvas();
        canvas.addEventListener('mousemove', onMouseMoveTriangle);
    }
});

function onMouseMoveTriangle(e) {
    current3X = e.clientX - canvas.offsetLeft;
    current3Y = e.clientY - canvas.offsetTop;
    redrawCanvas();
    drawTriangle(start3X, start3Y, current3X, current3Y);
}

canvas.addEventListener('mouseup', function() {
    if (isCreatingTriangle && start3X !== undefined && start3Y !== undefined) {
        triangles.push({ x1: start3X, y1: start3Y, x2: current3X, y2: current3Y });
        start3X = undefined;
        start3Y = undefined;
        current3X = undefined;
        current3Y = undefined;
        canvas.removeEventListener('mousemove', onMouseMoveTriangle);
    }
});

//Prova da qui: OKK
canvas.addEventListener('touchstart', function(e) {
    e.preventDefault(); // Prevents default scrolling behavior on touch devices
    if (isCreatingTriangle) {
        let touch = e.touches[0]; // Get the first touch point
        start3X = touch.clientX - canvas.offsetLeft;
        start3Y = touch.clientY - canvas.offsetTop;
        current3X = start3X;
        current3Y = start3Y;
        redrawCanvas();
        canvas.addEventListener('touchmove', onTouchMoveTriangleTouch);
    }
});

function onTouchMoveTriangleTouch(e) {
    e.preventDefault();
    let touch = e.touches[0]; // Get the first touch point
    current3X = touch.clientX - canvas.offsetLeft;
    current3Y = touch.clientY - canvas.offsetTop;
    redrawCanvas();
    drawTriangle(start3X, start3Y, current3X, current3Y);
}

canvas.addEventListener('touchend', function(e) {
    e.preventDefault();
    if (isCreatingTriangle && start3X !== undefined && start3Y !== undefined) {
        triangles.push({ x1: start3X, y1: start3Y, x2: current3X, y2: current3Y });
        start3X = undefined;
        start3Y = undefined;
        current3X = undefined;
        current3Y = undefined;
        canvas.removeEventListener('touchmove', onTouchMoveTriangleTouch);
    }
});
//Fine prova OKK

function drawTriangle(x1, y1, x2, y2) {
    context.beginPath();
    context.moveTo(x1, y1);
    context.lineTo(x2, y2);
    context.lineTo(x1 + (x1 - x2), y2);
    context.closePath();
    context.strokeStyle = '#000000';
    context.lineWidth = 2;
    context.stroke();
}

function getUpdatedFontStyle(fontStyle) {
    // Aggiorna gli stili al font in base allo stato corrente di grassetto e corsivo
    return `${fontStyle} ${isBold ? 'bold' : ''} ${isItalic ? 'italic' : ''}`;
}



function enableWriting() {

    // Mostra l'area di testo e il pulsante di completamento
    textarea.style.display = 'block';
    finishButton.style.display = 'block';
    isErasing=true;

    // Focalizza sull'area di testo
    textarea.focus();

    // Se stai modificando un testo esistente, imposta il valore dell'area di testo
    if (editingText !== null) {
        textarea.value = editingText.text;
    }
}


function hideWritingOptions() {
    textarea.style.display = 'none';
    finishButton.style.display = 'none';
    editingText = null;
    isErasing=false;
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

// Aggiungi gli eventi touch
canvas.addEventListener('touchstart', function(e) {
    e.preventDefault(); // Evita che il browser gestisca l'evento di tocco in modo predefinito
    const touch = e.touches[0]; // Ottieni il primo tocco
    const touchX = touch.clientX - canvas.offsetLeft;
    const touchY = touch.clientY - canvas.offsetTop;

    // Trova il testo su cui è stato fatto tocco
    for (let i = drawings.length - 1; i >= 0; i--) {
        const drawing = drawings[i];
        if (drawing.type === 'text') {
            context.font = `${drawing.fontSize} ${drawing.font}`;
            const textWidth = context.measureText(drawing.text).width;
            const lineHeight = parseInt(drawing.fontSize) + 10;

            if (
                touchX > drawing.x &&
                touchX < drawing.x + textWidth &&
                touchY > drawing.y - lineHeight &&
                touchY < drawing.y
            ) {
                // Imposta il testo corrente come quello da trascinare
                draggedText = drawing;
                isDragging = true;
                lastMouseX = touchX;
                lastMouseY = touchY;
                break;
            }
        }
    }
});

canvas.addEventListener('touchmove', function(e) {
    e.preventDefault(); // Evita che il browser gestisca l'evento di tocco in modo predefinito
    if (isDragging && draggedText !== null) {
        const touch = e.touches[0]; // Ottieni il primo tocco
        const touchX = touch.clientX - canvas.offsetLeft;
        const touchY = touch.clientY - canvas.offsetTop;

        const deltaX = touchX - lastMouseX;
        const deltaY = touchY - lastMouseY;

        // Sposta il testo
        draggedText.x += deltaX;
        draggedText.y += deltaY;

        // Ridisegna il canvas con il testo spostato
        redrawCanvas();

        // Aggiorna le coordinate del tocco
        lastMouseX = touchX;
        lastMouseY = touchY;
    }
});

canvas.addEventListener('touchend', function(e) {
    if (isDragging && draggedText !== null) {
        isDragging = false;
        draggedText = null;
    }
});





fontSelector.addEventListener('change', function() {
    setFont(fontSelector.value);
});

fontSizeSelector.addEventListener('change', function() {
    setFontSize(fontSizeSelector.value);
});

eraseButton.addEventListener('click', function() {
    toggleEraser();
});

 

let isDragging = false;
let draggedText = null;
let lastMouseX, lastMouseY;

canvas.addEventListener('mousedown', function(e) {
    if (e.button === 1) { // Controllo se il pulsante premuto è il pulsante centrale del mouse
        lastMouseX = e.clientX - canvas.offsetLeft;
        lastMouseY = e.clientY - canvas.offsetTop;

        // Trova il testo su cui è stato fatto clic
        for (let i = drawings.length - 1; i >= 0; i--) {
            const drawing = drawings[i];
            if (drawing.type === 'text') {
                context.font = `${drawing.fontSize} ${drawing.font}`;
                const textWidth = context.measureText(drawing.text).width;
                const lineHeight = parseInt(drawing.fontSize) + 10;

                if (
                    lastMouseX > drawing.x &&
                    lastMouseX < drawing.x + textWidth &&
                    lastMouseY > drawing.y - lineHeight &&
                    lastMouseY < drawing.y
                ) {
                    // Imposta il testo corrente come quello da trascinare
                    draggedText = drawing;
                    isDragging = true;
                    break;
                }
            }
        }
    } else {
        startDrawing(e); // Inizia a disegnare solo se non si sta trascinando il testo
    }
});

canvas.addEventListener('mouseup', function(e) {
    if (e.button === 1 && isDragging) { // Controllo se il pulsante rilasciato è il pulsante centrale del mouse e si sta trascinando
        isDragging = false;
        draggedText = null;
    } else {
        stopDrawing(); // Interrompi il disegno solo se non si sta trascinando il testo
    }
});



let isCreatingCircle = false;
let circles = []; // Array per memorizzare tutti i cerchi creati
let startXCircle, startYCircle, currentXCircle, currentYCircle;

const forme2Button = document.getElementById('forme3');

forme2Button.addEventListener('click', function() {
    if(isCreatingCircle) {
        isCreatingCircle = false;
    } else {
        isCreatingCircle = true;
    }
});

canvas.addEventListener('mousedown', function(e) {
    if (isCreatingCircle) {
        startXCircle = e.clientX - canvas.offsetLeft;
        startYCircle = e.clientY - canvas.offsetTop;
        currentXCircle = startXCircle;
        currentYCircle = startYCircle;
        canvas.addEventListener('mousemove', onMouseMoveCircle);
    }
});

function onMouseMoveCircle(e) {
    currentXCircle = e.clientX - canvas.offsetLeft;
    currentYCircle = e.clientY - canvas.offsetTop;
    redrawCanvas();
    const radius = Math.sqrt((currentXCircle - startXCircle) ** 2 + (currentYCircle - startYCircle) ** 2);
    drawCircle(startXCircle, startYCircle, radius);
}

canvas.addEventListener('mouseup', function() {
    if (isCreatingCircle && startXCircle !== undefined && startYCircle !== undefined) {
        const radius = Math.sqrt((currentXCircle - startXCircle) ** 2 + (currentYCircle - startYCircle) ** 2);
        circles.push({ x: startXCircle, y: startYCircle, radius: radius });
        startXCircle = undefined;
        startYCircle = undefined;
        currentXCircle = undefined;
        currentYCircle = undefined;
        canvas.removeEventListener('mousemove', onMouseMoveCircle);
    }
});

//Prova da qui in poi: OKK
canvas.addEventListener('touchstart', function(e) {
    e.preventDefault(); // Prevent default touch behavior, like scrolling
    if (isCreatingCircle) {
        let touch = e.touches[0]; // Get the first touch
        startXCircle = touch.clientX - canvas.offsetLeft;
        startYCircle = touch.clientY - canvas.offsetTop;
        currentXCircle = startXCircle;
        currentYCircle = startYCircle;
        canvas.addEventListener('touchmove', onMouseMoveCircleTouch);
    }
});

function onMouseMoveCircleTouch(e) {
    e.preventDefault();
    let touch = e.touches[0]; // Get the first touch
    currentXCircle = touch.clientX - canvas.offsetLeft;
    currentYCircle = touch.clientY - canvas.offsetTop;
    redrawCanvas();
    const radius = Math.sqrt((currentXCircle - startXCircle) ** 2 + (currentYCircle - startYCircle) ** 2);
    drawCircle(startXCircle, startYCircle, radius);
}

canvas.addEventListener('touchend', function(e) {
    e.preventDefault(); // Prevent default touch behavior
    if (isCreatingCircle && startXCircle !== undefined && startYCircle !== undefined) {
        const radius = Math.sqrt((currentXCircle - startXCircle) ** 2 + (currentYCircle - startYCircle) ** 2);
        circles.push({ x: startXCircle, y: startYCircle, radius: radius });
        startXCircle = undefined;
        startYCircle = undefined;
        currentXCircle = undefined;
        currentYCircle = undefined;
        canvas.removeEventListener('touchmove', onMouseMoveCircleTouch);
    }
});
//Fine prova OKK

function drawCircle(x, y, radius) {
    context.beginPath();
    context.arc(x, y, radius, 0, 2 * Math.PI);
    context.strokeStyle = '#000000';
    context.lineWidth = 2;
    context.stroke();
}





 
let triangButton = document.getElementById("forme2");

triangButton.addEventListener("click", function(){
});





const submitButton = document.getElementById('submit');
canvas.addEventListener('click', editText);

window.addEventListener('resize', function() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    redrawCanvas();
});

let riquadro7=document.getElementById("fotina7");
let barretta7=document.getElementById("tutto4");
 barretta7.style.display='none';

riquadro7.addEventListener("click",function(){
  if(barretta7.style.display==='block')
  {
    barretta7.style.display='none'
  }
  else if(barretta.style.display==='block') 
    {
      barretta.style.display='none';
      barretta7.style.display='block';
    }
    else if(barretta2.style.display==='block') 
    {
      barretta2.style.display='none';
      barretta7.style.display='block';
    }
  else
  {
    barretta7.style.display='block'
  }
})



document.addEventListener('keydown', handleKeyDown);

const colorPicker = document.getElementById('colorPicker');
colorPicker.addEventListener('input', function() {
    setDrawingColor(colorPicker.value);
});


submitButton.addEventListener('click', function() {
    ripristinaPosizioneOriginaria();
});

writeButton.addEventListener('click', function() {
    enableWriting();
});
finishButton.style.display = 'none';

finishButton.addEventListener('click', finishWriting);

document.addEventListener('keyup', function(e) {
    if (e.key === 'Enter') {
        finishWriting();
    }
});
thicknessSlider.addEventListener('input', function() {
    drawingThickness = thicknessSlider.value;
});
moveButton.addEventListener('click', function() {
    
});

let isCreatingRectangle = false;
let rectangles = []; // Array per memorizzare tutti i rettangoli creati
let startX, startY, currentX, currentY;

const formeButton = document.getElementById('forme');

formeButton.addEventListener('click', function() {
    if(isCreatingRectangle===true)
    {
        isCreatingRectangle=false;
    }
    else
    {
        isCreatingRectangle = true;
    }
});

canvas.addEventListener('mousedown', function(e) {
    if (isCreatingRectangle) {
        startX = e.clientX - canvas.offsetLeft;
        startY = e.clientY - canvas.offsetTop;
        currentX = startX;
        currentY = startY;
        redrawCanvas();
        drawRectangle(startX, startY, 0, 0);
    }
});

canvas.addEventListener('mousemove', function(e) {
    if (isCreatingRectangle && startX !== undefined && startY !== undefined) {
        currentX = e.clientX - canvas.offsetLeft;
        currentY = e.clientY - canvas.offsetTop;
        redrawCanvas();
        drawRectangle(startX, startY, currentX - startX, currentY - startY);
    }
});

canvas.addEventListener('mouseup', function() {
    if (isCreatingRectangle && startX !== undefined && startY !== undefined) {
        let width = currentX - startX;
        let height = currentY - startY;
        if (width < 0) {
            startX += width;
            width = Math.abs(width);
        }
        if (height < 0) {
            startY += height;
            height = Math.abs(height);
        }
        rectangles.push({ x: startX, y: startY, width: width, height: height });
        redrawCanvas();
        startX = undefined;
        startY = undefined;
        currentX = undefined;
        currentY = undefined;
    }
});

// prova da qui in poi: OKK
canvas.addEventListener('touchend', function(e) {
    e.preventDefault(); // Prevent default touch behavior, like scrolling
    if (isCreatingRectangle && startX !== undefined && startY !== undefined) {
        let touch = e.changedTouches[0]; // Get the first touch
        let currentX = touch.clientX - canvas.offsetLeft;
        let currentY = touch.clientY - canvas.offsetTop;

        let width = currentX - startX;
        let height = currentY - startY;
        if (width < 0) {
            startX += width;
            width = Math.abs(width);
        }
        if (height < 0) {
            startY += height;
            height = Math.abs(height);
        }
        rectangles.push({ x: startX, y: startY, width: width, height: height });
        redrawCanvas();
        startX = undefined;
        startY = undefined;
        currentX = undefined;
        currentY = undefined;
    }
});

canvas.addEventListener('touchstart', function(e) {
    e.preventDefault();
    if (isCreatingRectangle) {
        let touch = e.touches[0];
        startX = touch.clientX - canvas.offsetLeft;
        startY = touch.clientY - canvas.offsetTop;
    }
});

canvas.addEventListener('touchmove', function(e) {
    e.preventDefault();
    if (isCreatingRectangle && startX !== undefined && startY !== undefined) {
        let touch = e.touches[0];
        currentX = touch.clientX - canvas.offsetLeft;
        currentY = touch.clientY - canvas.offsetTop;
        redrawCanvas();
        drawRectangle(startX, startY, currentX - startX, currentY - startY);
    }
});
//Fine prova OKK

function drawRectangle(x, y, width, height) {
    context.strokeStyle = '#000000';
    context.lineWidth = 2;
    context.strokeRect(x, y, width, height);
}





let materia = document.getElementById('nota2').value;
let annoScolastico = document.getElementById('nota3').value;
let controlloElement = document.getElementById('ctr');

h.addEventListener('click', function() {
    hola.style.display = 'none';
    tutto2.style.filter = 'none'; // Rimuovi lo sfondo sfocato
    document.getElementById('tutto2').style.pointerEvents = 'auto';
})
f.addEventListener('input', function() {
    if (this.value.length > 20 || this.value.length < 5  (this.value.toLowerCase() === "notabianca")) {
        controlloElement.innerText = 'valori inseriti non validi :(';
        g.disabled = true;
        g.style.backgroundColor = "gray";
        g.style.borderColor = "gray";
        g.classList.add("submit-senza-hover");
    } else {
        controlloElement.innerText = '';
        g.disabled = false;
        g.style.backgroundColor = "#FFD847";
        g.style.borderColor = "#FFD847";
        g.classList.remove("submit-senza-hover");
    }
})

function validateSave() {
    let materia = document.getElementById('nota2').value;
    let annoScolastico = document.getElementById('nota3').value;
    let titleNote = document.getElementById('nota').value;
    let controlloElement = document.getElementById('ctr');
    if (titleNote.length < 20 && titleNote.length > 5 && materia != 'CURRENT' && annoScolastico != 'CURRENT' && (titleNote.toLowerCase() != "notabianca")) {
        controlloElement.innerText = '';
        g.disabled = false;
        g.style.backgroundColor = "#FFD847";
        g.style.borderColor = "#FFD847";
        g.classList.remove("submit-senza-hover");
    } else {

        controlloElement.innerText = 'valori inseriti non validi :(';
        g.disabled = true;
        g.style.backgroundColor = "gray";
        g.style.borderColor = "gray";
        g.classList.add("submit-senza-hover");
    }
}

l.addEventListener('click', function() {
    const kiko = document.getElementById('ciao');
    kiko.classList.add('aperta')
    v.style.display = 'block';
    l.style.display = 'none';

})

p.addEventListener('click', function() {
    if(barretta.style.display==='block')
    {
        barretta.style.display='none';
        v.style.display = 'none';
        l.style.display = 'block';
    }
    else if(barretta2.style.display==='block')
    {
        barretta2.style.display='none';
        v.style.display = 'none';
        l.style.display = 'block';
    }
    else if(barretta7.style.display==='block')
    {
        barretta7.style.display='none';
        v.style.display = 'none';
        l.style.display = 'block';
    }
    else
    {
        v.style.display = 'none';
        l.style.display = 'block';
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

const banner = document.getElementById('banner');
const confermaSalvataggio = document.getElementById('confermaSalvataggio');
const annullaSalvataggio = document.getElementById('annullaSalvataggio');
const bloccoSalvataggio = document.getElementById('bloccoSalvataggio');

uscita.addEventListener('click', function() {
    event.stopPropagation();
    banner.style.display = 'block';
    hola.style.display = 'none';
    tutto2.style.filter = 'blur(5px)';
});

confermaSalvataggio.addEventListener('click', function() {
    hola.style.display = 'block';
    banner.style.display = 'none';
    tutto2.style.filter = 'blur(5px)';
    event.stopPropagation();
});
d.addEventListener('click', function() {
    banner.style.display = 'none';
    tutto2.style.filter = 'none';
})

annullaSalvataggio.addEventListener('click', function() {
    window.location.href = 'profile_page.php';
});

function applicaSfocatura() {
    document.body.classList.add('sfocato');
}

function rimuoviSfocatura() {
    document.body.classList.remove('sfocato');
}

ciao.addEventListener('click', function() {
    applicaSfocatura();
});

document.addEventListener('click', function(event) {
    var isClickInsidePopups = hola.contains(event.target) || banner.contains(event.target);
    if (!isClickInsidePopups) {
        hidePopup()
        tutto2.style.filter = 'none';
        document.getElementById('tutto2').style.pointerEvents = 'auto';
    }
});

function hidePopup() {
    hola.style.display = 'none';
    banner.style.display = 'none';
}
