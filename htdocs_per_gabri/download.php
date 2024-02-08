<!DOCTYPE html>
<html>
    <head>
        <title>Raccolta immagine dal db</title>
        <script src="script_disegno.js"></script>
        <link rel="stylesheet" href="style_disegno.css">
    </head>
    <body>
        <?php
        $conn = new mysqli("localhost","root","","share-notes");
        $codiceNota = $_POST["codNota"];
        $query_codice = "SELECT * FROM nota WHERE codicenota=$codiceNota";
        $result = $conn->query($query_codice);
        if ($result) {
            echo '<h1 style="text-align: center;">Connesso</h1>';
        }else{
            echo '<h1 style="text-align: center;">Non connesso</h1>';
        }
        $rigaNota = $result->fetch_assoc();
        $contenutoNota = $rigaNota["contenuto"];
        ?>
        <input type="text" id="contenutoNota" value="<?php echo $contenutoNota ?>">
        <canvas id="canvasPreso" width="800" height="600" onclick="Importa('canvasPreso');disegno('canvasPreso')"></canvas>

        <form id="Form" method="post" action="upload.php">
            <input type="text" name="Salva" id="salvaImmagine">
            <input type="submit" value="SalvaAppunto" onclick="Esporta('canvasPreso')">
        </form>
        <a href="index.html"><button type="button" class="goBack">Go Back</button></a>
    </body>
</html>