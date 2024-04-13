<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="activateStyle.css">
        <link rel="icon" href="img\logo_favicon.ico" type="image/x-icon">
    </head>
    <body>
        <h1 id="pageTitle">VALIDAZIONE <br> INDIRIZZO E-MAIL</h1>
        <div class="result">
            <?php
                include("utils.inc.php");
                include("conn.inc.php");
                $stmtDati = $conn->prepare("SELECT name FROM user WHERE chiave=?");
                $stmtDati->bind_param('s', $user);

                $user = (string) $_GET["key"];

                $stmtDati->execute();

                $conn->begin_transaction();
                try{
                    $stmtActivate = $conn->prepare("UPDATE user SET attivo=1 WHERE chiave=?");
                    $stmtActivate->bind_param('s', $user);

                    $stmtActivate->execute();

                    $conn->commit();
                } catch (mysqli_sql_exception $exception){
                    $conn->rollback();

                    throw $exception;
                }
                
                $resultDati = $stmtDati->get_result();
                $resultActivate = $stmtActivate->affected_rows;
                $dati = $resultDati->fetch_assoc();
                $name = $dati["name"];
                if ($resultActivate > 0) {
                    echo '<p id="conferma">Il tuo account è stato <br> attivato con successo '. $name. '!!</p><br>
                        <br><h2 id="thanks">Grazie per averci <br> scelto ora puoi tornare <br> alla home</h2>';
                }else {
                    echo "<p id='conferma'>Siamo spiacenti c'è stato un errore <br> nell'attivazione del tuo account  :(</p><br>
                        <br><h2 id='thanks'>Riprova più tardi...</h2>";
                }
            ?>
        </div>
        <a href="index.php"><img src="img/logo.png" alt="Logo" id="logo"></a>
    </body>
</html>