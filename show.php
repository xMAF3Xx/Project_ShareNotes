<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="show.css">
        <script src="js/show.js"></script>
    </head>
    <body>
        <?php
            session_start();
            include("conn.inc.php");
            include "utils.inc.php";
            $codice = (int) $_POST['codNota'];

            if(isset($_POST['like'])){
                if(!isLogged()){

                    $conn->begin_transaction();
                    try{
                        $stmtLike = $conn->prepare("UPDATE nota SET likes=likes+1 WHERE codicenota=?");
                        $stmtLike->bind_param('i', $codice);

                        $stmtLike->execute();

                        $conn->commit();
                    } catch (mysqli_sql_exception $exception){
                        $conn->rollback();

                        throw $exception;
                    }
                    
                    $resultLike = $stmtLike->affected_rows;
                    if($resultLike < 1){
                        echo '<script>
                            alert("Non e\' stato possibile mettere like alla nota, riprovare in seguito...");
                        </script>';
                    }
                }else {
                    echo '<script>
                        alert("Devi prima loggarti per poter mettere like, salvare e/o modificare le note, per farlo recati alla pagina home e clicca sul\'icona del profilo.");
                    </script>';
                }
            }

            $stmtNota = $conn->prepare("SELECT * FROM nota WHERE codicenota=?");
            $stmtNota->bind_param('i', $codice);

            $stmtNota->execute();
            $resultNota = $stmtNota->get_result();
            $nota = $resultNota->fetch_assoc();
            $contenuto = $nota['contenuto'];
            $titolo = $nota['titolo'];
            $anno = $nota['annoScolastico'];
            $materia = $nota['materia'];
            $classe = $nota['classe'];
            $newLikes = 0;
            $newMia = 0;
            $like = $nota['likes'];
            $stmtCreatore = $conn->prepare("SELECT name FROM user WHERE email=?");
            $stmtCreatore->bind_param('s', $mailCrt);

            $mailCrt = $nota['email'];

            $stmtCreatore->execute();
            $resultCreatore = $stmtCreatore->get_result();
            $nomeCrt = ($resultCreatore->fetch_assoc())['name'];

            if(isset($_POST['salva'])){
                if(!isLogged()){
                    if(sexOrCock()){
                        $mail = $_SESSION['UserData']['email'];
                    }else{
                        $mail = $_COOKIE['UserMail'];
                    }

                    $conn->begin_transaction();
                    try{
                        $stmtAdd = $conn->prepare("INSERT INTO nota(email, materia, classe, annoScolastico, likes, contenuto, titolo, mia)
                                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmtAdd->bind_param('sssiissi', $mail, $materia, $classe, $anno, $newLikes, $contenuto, $titolo, $newMia);

                        $stmtAdd->execute();

                        $conn->commit();
                    } catch (mysqli_sql_exception $exception){
                        $conn->rollback();

                        throw $exception;
                    }
                    
                    $resultAdd = $stmtAdd->affected_rows;
                    if($resultAdd < 1){
                        echo '<script>
                            alert("Non e\' stato possibile aggiungere la nota alla libreria, riprovare in seguito...");
                        </script>';
                    }
                }else {
                    echo '<script>
                        alert("Devi prima loggarti per poter mettere like, salvare e/o modificare le note, per farlo recati alla pagina home e clicca sul\'icona del profilo.");
                    </script>';
                }
            }

            if(isset($_POST['modifica'])){
                if(!isLogged()){
                    if(sexOrCock()){
                        $mail = $_SESSION['UserData']['email'];
                    }else{
                        $mail = $_COOKIE['UserMail'];
                    }

                    $conn->begin_transaction();
                    try{
                        $stmtMod = $conn->prepare("INSERT INTO nota(email, materia, classe, annoScolastico, likes, contenuto, titolo, mia)
                                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmtMod->bind_param('sssiissi', $mail, $materia, $classe, $anno, $newLikes, $contenuto, $titolo, $newMia);

                        $stmtMod->execute();

                        $conn->commit();
                    } catch (mysqli_sql_exception $exception){
                        $conn->rollback();

                        throw $exception;
                    }
                    
                    $resultMod = $stmtMod->affected_rows;
                    if($resultMod < 1){
                        echo '<script>
                            alert("Non e\' stato possibile aggiungere la nota alla libreria e modificarla, riprovare in seguito...");
                        </script>';
                    }
                    $newCode = mysqli_insert_id($conn);
                    echo '<form method="post" action="download.php" id="fTS">
                        <input name="codNota" value='.$newCode.' style="display:none;">;
                    </form>';
                    echo '<script>
                        document.getElementById("fTS").submit()
                    </script>';
                }else {
                    echo '<script>
                        alert("Devi prima loggarti per poter mettere like, salvare e/o modificare le note, per farlo recati alla pagina home e clicca sul\'icona del profilo.");
                    </script>';
                }
            }

        ?>
        <h1 id="titoloNota"><?php echo $titolo ?></h1>
        <a href="index.php"><img src="img/logo.png" alt="LOGO" id="logo"></a>
        <div class="cornice">
            <img src="<?php echo $contenuto ?>" alt="Immagine Scelta" id="notaScelta">
        </div>
        <div class="dati">
            <h2 id="titoloDati">Dati della nota:</h2>
            <br><h4 id="dato">Materia:</h4><p id="valore"><?php echo $materia ?></><br>
            <br><h4 id="dato">Classe:</h4><p id="valore"><?php echo $classe ?></p><br>
            <br><h4 id="dato">Anno:</h4><p id="valore"><?php echo $anno ?></p><br>
            <br><h4 id="dato">Likes:</h4><p id="valore"><?php echo $like ?></p><br>
            <br><h4 id="dato">Creatore:</h4><p id="valore"><?php echo $nomeCrt ?></p><br>
        </div>
        <div class="bottoni">
            <form action="show.php" method="post"> <!-- LIKE -->
                <input name="codNota" type="number" value=<?php echo $codice ?> style="display: none;">
                <button name="like" value=1><img src="img/like.png" alt="Like" id="like"></button>
            </form>
            <form action="show.php" method="post"> <!-- SALVA -->
                <input name="codNota" type="number" value=<?php echo $codice ?> style="display: none;">
                <button name="salva" value=1><img src="img/save.png" alt="Salva" id="save"></button>
            </form>
            <form action="show.php" method="post"> <!-- MODIFICA -->
                <input name="codNota" type="number" value=<?php echo $codice ?> style="display: none;">
                <button name="modifica" value=1><img src="img/modify.png" alt="Modifica" id="modify"></button>
            </form>
        </div>
    </body>
</html>