<!DOCTYPE html>
<html>
    <head>
        <title>Invio canvas al db</title>
    </head>
    <body>
        <?php
        $conn = mysqli_connect("localhost", "root", "", "share-notes");
        $contenutoNota = $_POST["Salva"];
        $query = "INSERT INTO nota(contenuto) VALUE ('$contenutoNota')";
        $result = mysqli_query($conn, $query);
        if ($result == true) {
            echo '<h1 style="text-align: center; text-weight: bold;">Nota Salvata</h1>';
        }else {
            echo '<h1 style="text-align: center; text-weight: bold;">Nota non Salvata</h1>';
        }
        ?>
        <script>
            setTimeout(function() {
            window.location.replace("index.html");
            }, 1500)
            </script>
    </body>
</html>