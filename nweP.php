<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="R_E.css">
    <title>Ripristino Password</title>
    <link rel="icon" href="img\logo_favicon.ico" type="image/x-icon">
    <script src="js/nweP.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php
            include("utils.inc.php");
            include("conn.inc.php");

            if(isset($_POST['reset'])){

                $conn->begin_transaction();
                try{
                    $stmtChange = $conn->prepare("UPDATE user SET password=? WHERE chiave=?");
                    $stmtChange->bind_param('ss', $newPass, $Key);

                    $Key = (string) $_POST["K"];
                    $newPass = password_hash((string) $_POST["confermaPasswordInput"], PASSWORD_BCRYPT);

                    $stmtChange->execute();

                    $conn->commit();
                } catch (mysqli_sql_exception $exception){
                    $conn->rollback();

                    throw $exception;
                }
                
                $resultChange = $stmtChange->affected_rows;
                
                if($resultChange > 0){
                    echo '<script>
                        setTimeout(function() {
                            window.location.replace("index.php");
                        }, 0)
                    </script>';
                }else {
                    echo '<script>
                        alert("La password non e\' stata aggiornata con successo, riprovare in seguito...");
                    </script>';
                }
            }else {
                $key = (string) $_GET["key"];
            }
        ?>
        <h1 id="titoloM">Cambia la tua password</h1>
        <a href="index.php"><img src="img/logo.png" alt="#" id="logo"></a>
        <div class="block">
            <form action="nweP.php" method="post">
                <h3 id="titoloP">password:</h3>
                <input type="password" placeholder="inserici la tua nuova password" id="password" class="pswInput" name="passwordInput" onchange="ctrPassword()">
                <input type="checkbox" id="showPsw" onchange="makeVisiblePsw()">
                <h3 id="titoloP">conferma:</h3>
                <input type="password" placeholder="conferma la password" id="passwordCtr" class="pswInput" name="confermaPasswordInput" onchange="ctrPassword()">
                <input type="text" name="K" id="KHey" style="display: none;" value=<?php echo $key ?>>
                <p class="controlloPsw" id="ctrPsw"></p>
                <br><input name="reset" class="goBtnOpen" type="submit" value="Avanti" id="go">
            </form>
        </div>
</body>

</html>