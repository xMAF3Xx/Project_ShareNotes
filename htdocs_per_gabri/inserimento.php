<!DOCTYPE html>
<html>
    <head>
        <title>Inserimento dati</title>
    </head>
    <body>
        <?php
        $connection = new mysqli("localhost", "root", "", "share-notes");
        if($connection ->connect_error){
            die("Connessione fallita:". $connection ->connect_error);
        }
        $email = $_POST["emailInput"];
        $password = $_POST["passwordInput"];
        $nickname = $_POST["nickInput"];
        $query = "INSERT INTO user(name, email, password) VALUES ('$nickname', '$email', '$password')";
        $queryTabellaBase = "INSERT INTO nota(email) VALUES ('$email')";
        $result = $connection -> query($query);
        //$result2 = $connection -> query($queryTabellaBase);

        if($result == true){
            echo '<h1 style="text-align: center; text-weight: bold;">Sei ora Registrato, Grazie</h1>';
        }else{
            echo '<h1 style="text-align: center; text-weight: bold;">Registrazione fallita, Riprova</h1>';
        }
        ?>
        <script>
            setTimeout(function() {
            window.location.replace("index.html");
            }, 1000)
        </script>
    </body>
</html>