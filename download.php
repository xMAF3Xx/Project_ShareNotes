<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paint-Like Drawing</title>
    <link rel="stylesheet" href="stile.css">
    <link rel="icon" href="img\logo_favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
</head>

<body class="body" onload="Importa('drawingCanvas')">

 <?php
        include("conn.inc.php");

        if(isset($_POST['Temporary'])){

            $conn->begin_transaction();
            try{
                $stmtTemp = $conn->prepare("UPDATE nota SET contenuto=? WHERE codicenota=?");
                $stmtTemp->bind_param("si", $newContent, $codeN);

                $codeN = (int) $_POST['codNota'];
                $newContent = (string) $_POST['contenutoTemp'];

                $stmtTemp->execute();

                $conn->commit();
            } catch (mysqli_sql_exception $exception){
                $conn->rollback();

                throw $exception;
            }

        }

        if(isset($_POST['upCodice'])){
            $contenutoN = (string) $_POST["Salva"];
            $contenutoNota = (string) $_POST['Vecchio'];

            $conn->begin_transaction();
            try{
                if($contenutoNota != $contenutoN){
                    $stmt = $conn->prepare("UPDATE nota SET contenuto=?, materia=?, titolo=?, annoScolastico=?, mia=? WHERE codicenota=?");
                    $stmt->bind_param('sssiii', $contenutoN, $mat, $titolo, $ann, $mine, $codiceN);
                }else {
                    $stmt = $conn->prepare("UPDATE nota SET contenuto=?, materia=?, titolo=?, annoScolastico=? WHERE codicenota=?");
                    $stmt->bind_param('sssii', $contenutoN, $mat, $titolo, $ann, $codiceN);
                }
    
                $mine = 1;
                $codiceN = (int) $_POST["upCodice"];
                $titolo = (string) $_POST["title"];
                $mat = (string) $_POST["matScelta"];
                $ann = (int) $_POST['anno'];
                
                $stmt->execute();

                $conn->commit();
            } catch (mysqli_sql_exception $exception){
                $conn->rollback();

                throw $exception;
            }
            
            $result = $stmt->affected_rows;

            echo '<script>
                setTimeout(function() {
                    window.location.replace("profile_page.php");
                }, 0)
            </script>';
        }

        $codiceNota = (int) $_POST["codNota"];
        $stmt_codice = $conn->prepare("SELECT contenuto,titolo,materia,annoScolastico FROM nota WHERE codicenota=?");
        $stmt_codice->bind_param('i', $codiceNota);

        $stmt_codice->execute();
        $resultRiga = $stmt_codice->get_result();
        $rigaNota = $resultRiga->fetch_assoc();
        $contenutoNota = $rigaNota["contenuto"];
        $title = $rigaNota["titolo"];
        $materia = $rigaNota["materia"];
        $anno = $rigaNota["annoScolastico"];

        function stampaMaterie($conn){
            $stmtMaterie = $conn->prepare("SELECT * FROM materia");

            $stmtMaterie->execute();
            $resultMaterie = $stmtMaterie->get_result();
            $numMaterie = mysqli_num_rows($resultMaterie);
            $Materie = array();
            while ($row = $resultMaterie->fetch_assoc()) {
                $Materie[] = $row;
            }
            for($j = 0; $j < $numMaterie; $j++){
                echo '<option value="'.$Materie[$j]['nome'].'">'.$Materie[$j]['nome'].'</option>';
            }
        }

    ?>

    <input type="text" id="contenutoNota" style="display: none;" value="<?php if($contenutoNota == null) echo 1; else echo $contenutoNota ?>">
    <div id="tutto2">
        <img id="apri" src="img/+.jpg">
        <div id="ciao">
            <div class="tutto" id="tutto">
                <img id="fotina5" src="img/foto2.png">
                <img id="uscita" src="img/foto.png">
                <img id="fotina3" src="img/foto3.png">
                <img id="fotina7" src="img/foto7.png">
                <img id="fotina4" src="img/foto4.png">

                <div id="textOptions">
                    <img src="img/foto6.png" id="chiudi">
                </div>
                <div id="textCursor" class="cursor"></div>
                <div id="bottoni">
                    <form action="download.php" method="post" id="Temp">
                        <input type="text" name="contenutoTemp" style="display: none;" id="contenutoTemp">
                        <input type="number" name="codNota" style="display: none;" value=<?php echo $codiceNota ?>>
                        <input type="number" name='Temporary' value=1 style="display:none;">
                    </form>
                    <button style="border: none; background: none; margin-top: -10px; margin-left: -15px" id="salvaTemp" onclick="SendTwo('drawingCanvas')"><img id="moveButton" src="img/foto5.png"></button>
                </div>
                <br>
            </div>
        </div>
        <div id="barretta" class="tutto2">
            <img id="foto3" src="img/prova.png">
            <img id="fotona" src="img/cocco.png">
            <img src="img/foglio.png" id="writeButton">
            <select class="select" id="fontSelector">
            <option  class="testo" value="Arial">Arial</option>
            <option  class="testo"value="Times New Roman">Times New Roman</option>
            <option  class="testo" value="Courier New">Courier New</option>
            </select>
            <div id="selettore">
            <select id="fontSizeSelector">
            <option   class="testo" value="12">12px</option>
            <option  class="testo"value="16">16px</option>
            <option   class="testo" value="20">20px</option>
            <option   class="testo" value="24">24px</option>
            <option  class="testo" value="28">28px</option>
            <option    class="testo" value="32">32px</option>
            </select>
            </div>
            <img src ="img/corsivo.png" id="boldButton" onclick="toggleBold()">
            <img src="img/ita.png" id="italicButton" onclick="toggleItalic()">
            <img src="img/sottolineato.png" id="underlineButton" onclick="toggleUnderline()">
         </div>
    </div>
    <div id="barretta2" class="tutto3" style="display:none">
        <img id="foto3" src="img/prova2.png">
        <div id="colore">
            <label for="colorPicker">Colore:</label>
            <input type="color" id="colorPicker" value="#ff0000">
        </div>
        <div id="tools">
             
            <label id="labello" for="thicknessSlider"><img id="matita" src="img/matita.png"></label>
            <input type="range" id="thicknessSlider" min="1" max="100" value="5">
        </div>
        <div id="gomma2">
            <label id="labello2" for="gomma"><img id="foto-gomma" src="img/gomma.png"></label>
            <input type="range" id="gomma" min="1" max="100" value="5">
        </div>
        <img src="img/gommina.png" id="eraseButton">
        
    </div>
       <div class="tutto4" id="tutto4">
         <img src="img/formine.png" id="formine">
         <img src="img/rett.png" id="forme">
         <img src="img/cerchio.png" id="forme3">
         <img src="img/triang.png" id="forme2">
    </div>
    <button id="finishButton"></button>
    <textarea id="textArea" style="display:none;"></textarea>
    <canvas id="drawingCanvas"></canvas>
    <div id="blocco">
        <span class="close-pop-up" id="croce">&times;</span>
        <!-- cambio tipo di pulsante per la chiusura del pop-up-->
        <h1 id="titolino">Salva la tua nota</h1>
        <!--cambiato titolo-->
        <form action="download.php" method="post" id="fTSend">
            <input id="nota" type="text" placeholder="nome della nota" name="title" value="<?php echo $title ?>" onchange="validateSave()">
            <!--aggiunto placeholder-->
            <input id="salvaImmagine" name="Salva" type="text" style="display: none;">
            <input name="upCodice" type="number" style="display: none;" value=<?php echo $codiceNota ?>>
            <input name="Vecchio" type="text" style="display: none;" value=<?php echo $contenutoNota ?>>
            <select ID="nota2" name="matScelta" onchange="validateSave()"> <!-- cambiaton "CURRENT" con "materia" e reso minuscolo le varie materie e cambio del valore del primo elemento della lista-->
                <option value="<?php echo $materia ?>"><?php echo $materia ?></option>
                <?php stampaMaterie($conn) ?>
            </select>
            <select ID="nota3" name="anno" onchange="validateSave()">
                <option value=<?php echo $anno ?>><?php echo $anno ?>°</option> <!-- cambiato "CURRENT" con "anno" e cambio del valore del primo elemento della lista-->
                <option value=1>1°</option>
                <option value=2>2°</option>
                <option value=3>3°</option>
                <option value=4>4°</option>
                <option value=5>5°</option>
            </select>
        </form>
        <div>
            <p id="ctr"></p>
            <!--aggiunta paragrafo di controllo-->
            <input id="submit" class="submit-con-hover" type="button" value="Salva" onclick="SendIt('drawingCanvas')">
            <!--aggiunta di una classe-->
        </div>
    </div>
    <div id="banner" style="display:none;">
        <h1 id="banner-text">Vuoi salvare le modifiche?</h1>
        <button class="save-btns" id="confermaSalvataggio">Sì</button>
        <button class="save-btns" id="annullaSalvataggio">No</button>
        <button class="save-btns" id="annulla">Annulla</button>
    </div>
    <script src="js/draw.js"></script>
    <script src="js/script_disegno.js"></script>
</body>

</html>
