    function Esporta(Canvas){
        const canvasA = document.getElementById(Canvas);
        var base64;
        if(canvasA.height > canvasA.width){
            const context = canvasA.getContext('2d');
            const tempCanvas = document.createElement('canvas');
            const tempContext = tempCanvas.getContext('2d');
            tempCanvas.width = canvasA.height;
            tempCanvas.height = canvasA.width;
            tempContext.rotate(-90 * Math.PI / 180);
            tempContext.drawImage(canvasA, -canvasA.width, 0);
            base64 = tempCanvas.toDataURL()
        }else {
            base64 = canvasA.toDataURL();
        }
        var Input = document.getElementById("salvaImmagine");
        Input.value = base64;
    }

    function Importa(Canvas) {
        const canvasB = document.getElementById(Canvas);
        const context = canvasB.getContext('2d');
    
        const img = new Image();
        img.onload = function() {
            if (canvasB.height > canvasB.width) {
                // Rotate the canvas context
                context.save(); // Save the current context state
                context.translate(canvasB.width / 2, canvasB.height / 2);
                context.rotate(90 * Math.PI / 180);
                context.drawImage(this, -canvasB.height / 2, -canvasB.width / 2, canvasB.height, canvasB.width);
                context.restore(); // Restore the context to its original state
            } else {
                context.drawImage(this, 0, 0, canvasB.width, canvasB.height);
            }
        };
        const immagine = document.getElementById("contenutoNota").value;
        if (immagine == 1) {
            context.fillStyle = '#FFFFFF';
            context.fillRect(0, 0, canvasB.width, canvasB.height);
        } else {
            img.src = immagine;
        }
    }

    function SendIt(drawArea){
        Esporta(drawArea);
        document.forms["fTSend"].submit();
    }

    function Esporta2(Canvas){
        const canvasA = document.getElementById(Canvas);
        var base64;
        if(canvasA.height > canvasA.width){
            const context = canvasA.getContext('2d');
            const tempCanvas = document.createElement('canvas');
            const tempContext = tempCanvas.getContext('2d');
            tempCanvas.width = canvasA.height;
            tempCanvas.height = canvasA.width;
            tempContext.rotate(-90 * Math.PI / 180);
            tempContext.drawImage(canvasA, -canvasA.width, 0);
            base64 = tempCanvas.toDataURL()
        }else {
            base64 = canvasA.toDataURL();
        }
        var Input = document.getElementById("contenutoTemp");
        Input.value = base64;
    }

    function SendTwo(drawArea){
        Esporta2(drawArea);
        document.forms["Temp"].submit();
    }

    window.addEventListener('resize', function() {
        // Reload the current page without using the cache
        window.location.reload(true);
    });