<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <?php
        session_start();
        session_unset();
        session_destroy();
        //session_regenerate_id();
        ?>
        <h1 style="text-align: center; text-weight: bold;">Sei ora sloggato</h1>
        <script>
            setTimeout(function() {
            window.location.replace("index.html");
            }, 1000)
        </script>
    </body>
</html>