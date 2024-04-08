<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <?php
        function isLogged() {
            if (isset($_SESSION["UserData"])){
                return false;
            }else if (isset($_COOKIE["UserMail"])){
                return false;
            }else {
                return true;
            }
        }

        function sexOrCock() {
            if (isset($_SESSION["UserData"])){
                return true;
            }else if (isset($_COOKIE["UserMail"])){
                return false;
            }
        }
        
        function logOut() {
            session_unset();
            session_destroy();
            session_start();
            session_regenerate_id();
        }

        function login($data, $cocks = false){
            if ($cocks){
                setcookie("UserMail",$data["email"],strtotime("+1 year"));
            }else {
                $_SESSION["UserData"]=$data;
            }
        }

        function login_utente($mail, $conn) {
            $stmt_dati = $conn->prepare("SELECT * FROM user WHERE email=?");
            $stmt_dati->bind_param('s', $mail);

            $stmt_dati->execute();
            $result_dati = $stmt_dati->get_result();
            return (array) $result_dati->fetch_assoc();
        }
        ?>
    </body>
</html>