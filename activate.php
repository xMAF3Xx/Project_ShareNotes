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
                $user = $_GET['key'];

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
                
                if (true) {
                    echo '<p id="conferma">Il tuo account è stato <br> attivato con successo !!</p><br>
                        <br><h2 id="thanks">Grazie per averci <br> scelto ora puoi tornare <br> alla home</h2>';
                }
            ?>
        </div>
        <a href="index.php"><img src="img/logo.png" alt="Logo" id="logo"></a>
    </body>
</html>