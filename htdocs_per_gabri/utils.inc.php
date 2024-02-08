<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <?php
        function isLoggedS() {
            return empty($_SESSION["UserData"]);
        }
        function isLoggedC() {
            return empty($_COOKIE["UserData"]);
        }
        ?>
    </body>
</html>