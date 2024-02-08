<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Scegli disegno</title>
        <script src="script_selezione.js"></script>
    </head>
    <body>
        <?php
        session_start();
        $conn = new mysqli("localhost","root","","share-notes");
        include "utils.inc.php";
        if (!empty($_COOKIE["UserData"])){
            if (isLoggedC()) {
                echo "<script>alert('Devi prima loggarti per poter prendere appunti.')
                        setTimeout(function() {
                        window.location.replace(\"index.html\");
                        }, 0)
                    </script>";
            }
            $mail = $_COOKIE["UserData"]["email"];
        }else {
            if (isLoggedS()) {
                echo "<script>alert('Devi prima loggarti per poter prendere appunti.')
                        setTimeout(function() {
                        window.location.replace(\"index.html\");
                        }, 0)
                    </script>";
            }
            $mail = $_SESSION["UserData"]["email"];
        }
        $query_num_note = "SELECT * FROM nota WHERE email='".trim($mail)."'";
        $result_num_note = $conn->query($query_num_note);
        $num_note = mysqli_num_rows($result_num_note);
        $note = array();
        while ($row = $result_num_note->fetch_assoc()) {
            $note[] = $row;
        }
        echo '<form method="POST" action="download.php">';
        for ($j = 0; $j < $num_note; $j++) {
            $codice = $note[$j]['codicenota'];
            $title = $note[$j]['titolo'];
            echo '<button id="bottoneNota" onClick="assegnaValore(', $codice , ', ',"'inputPassaggio'" ,')">', $title, '</button>';
        }
        echo '<input type="number" style="display: none;" name="codNota" id="inputPassaggio">';
        echo '</form>';

         /*$chiavi = array_keys($note);
        foreach ($chiavi as $chiave) {
            echo $chiave . "<br>";
            $cc = array_keys($note[$chiave]);
            foreach ($cc as $c) {
                echo $c ."<br>";
            }   
        }*/
        ?>
        <a href="index.html"><button type="button" class="goBack">Go Back</button></a>
    </body>
</html>