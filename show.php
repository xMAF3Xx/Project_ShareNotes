<!DOCTYPE html>
<html>
    <head>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
        <link rel="stylesheet" href="show.css">
        <script src="js/show.js"></script>
        <script src="js/scarica.js"></script>
        <link rel="icon" href="img\logo_favicon.ico" type="image/x-icon">
    </head>
    <body>
        <?php
            session_start();
            include("conn.inc.php");
            include "utils.inc.php";
            $codice = (int) $_POST['codNota'];

            if(isset($_POST['like'])){
                if(!isLogged()){
                    $stmtPresente = $conn->prepare("SELECT * FROM bloccolike WHERE email=? AND codice=?");
                    $stmtPresente->bind_param("si", $mail, $codice);

                    if(sexOrCock()){
                        $mail = (string) $_SESSION['UserData']['email'];
                    }else {
                        $mail = (string) $_COOKIE['UserMail'];
                    }

                    $stmtPresente->execute();
                    $presenteResult = $stmtPresente->get_result();

                    if($presenteResult->num_rows == 0){

                        $conn->begin_transaction();
                        try{
                            $stmtMipiace = $conn->prepare("INSERT INTO bloccolike(codice, email) VALUES (?, ?)");
                            $stmtMipiace->bind_param("is", $codice, $mail);

                            $stmtMipiace->execute();

                            $conn->commit();
                        } catch (mysqli_sql_exception $exception){
                            $conn->rollback();

                            throw $exception;
                        }
                        $Mipiace = $stmtMipiace->affected_rows;

                        if($Mipiace == 1){
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
                        }
                    }else {
                        $conn->begin_transaction();
                        try{
                            $stmtNonpiace = $conn->prepare("DELETE FROM bloccolike WHERE codice=? AND email=?");
                            $stmtNonpiace->bind_param("is", $codice, $mail);

                            $stmtNonpiace->execute();

                            $conn->commit();
                        } catch (mysqli_sql_exception $exception){
                            $conn->rollback();

                            throw $exception;
                        }
                        $Nonpiace = $stmtNonpiace->affected_rows;

                        if($Nonpiace == 1){
                            $conn->begin_transaction();
                            try{
                                $stmtDislike = $conn->prepare("UPDATE nota SET likes=likes-1 WHERE codicenota=?");
                                $stmtDislike->bind_param('i', $codice);

                                $stmtDislike->execute();

                                $conn->commit();
                            } catch (mysqli_sql_exception $exception){
                                $conn->rollback();

                                throw $exception;
                            }
                    
                            $resultDislike = $stmtDislike->affected_rows;
                            if($resultDislike < 1){
                                echo '<script>
                                    alert("Non e\' stato possibile togliere il like dalla nota, riprovare in seguito...");
                                </script>';
                            }
                        }
                    }
                }else {
                    echo '<script>
                        alert("Devi prima loggarti per poter mettere like o modificare le note, per farlo recati alla pagina home e clicca sul\'icona del profilo.");
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
                        alert("Devi prima loggarti per poter mettere like o modificare le note, per farlo recati alla pagina home e clicca sul\'icona del profilo.");
                    </script>';
                }
            }

        ?>
        <div class="barra">
            <a href="index.php"><img src="img/logo.png" alt="LOGO" id="logo"></a>
            <a href="index.php"><button style="border: none; background: none;" id="home">Home</button></a>
            <a href="Functionalities.php"><button style="border: none; background: none;" id="funzionalita">Funzionalità</button></a>
            <a href="aboutPage.php"><button style="border: none; background: none;" id="about">About</button></a>
            <!-- Pulsante profilo da mettere con php -->
            <?php
                if(isLogged()){
                    echo '<a href="index.php"><img src="img/user.png" alt="USER" id="user"></a>';
                }else {
                    echo '<a href="profile_page.php"><img src="img/user.png" alt="USER" id="user"></a>';
                }
            ?>
            <hr id="fine-barra">
        </div>
        <h2 id="title"><?php echo $titolo ?></h2>
        <div class="noteContainer">
            <img id="nota" src="<?php echo $contenuto ?>">
        </div>
        <div class="bottoni">
            <button onclick="downloadNota('<?php echo $titolo ?>','<?php echo $contenuto ?>')"><img src="img/scarica.png" alt="Salva" id="save"></button>
            <form action="show.php" method="post"> <!-- MODIFICA -->
                <input name="codNota" type="number" value=<?php echo $codice ?> style="display: none;">
                <button name="modifica" value=1><img src="img/prova2.png" alt="Modifica" id="modify"></button>
            </form>
            <form action="show.php" method="post"> <!-- LIKE -->
                <input name="codNota" type="number" value=<?php echo $codice ?> style="display: none;">
                <button name="like" value=1 class="likes"><img src="img/cuore.png" alt="Like" id="like"><img src="img/cuorerosso.png" id="rosso"></button>
            </form>
            <p id="nLikes"> <?php echo $like ?> </p>
        </div>
        <div class="info">
            <h4 id="titleinfo">Info</h4>
            <li class="dati">
                <ul>Creatore:   <?php echo $nomeCrt ?></ul>
                <ul>Materia:    <?php echo $materia ?></ul>
                <ul>Classe:    <?php echo $classe ?></ul>
                <ul>Anno:   <?php echo $anno ?></ul>
            </li>
        </div>
    </body>
</html>