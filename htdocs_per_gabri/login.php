<!DOCTYPE html>
<html>
    <head>
        <title>Check_Utente</title>
    </head>
    <body>
        <?php
        session_start();
        session_unset();
        session_destroy();
        unset($_COOKIE["UserData"]);
        $conn = new mysqli("localhost", "root", "", "share-notes");
        $cock = $_POST["stayLogged"];
        if ($conn->connect_error) {
            die("Connessione al db fallita: ". $conn->connect_error);
        }
        $user_data = check_dati($conn);
        login($user_data, $cock);
        echo "Benvenuto a te {$user_data["name"]}";

        function check_dati($conn) {
            $password_inserita = $_POST["passwordInput"];
            $email = $_POST["emailInput"];
            $query_check_mail = "SELECT password FROM user WHERE email='".trim($email)."'";
            $result_mail = $conn->query($query_check_mail);
            $array_dati = $result_mail->fetch_assoc();
            if (mysqli_num_rows($result_mail) > 0 && $array_dati["password"] == $password_inserita) {
                return (array) login_utente($email, $password_inserita, $conn);
            } else {
                header("Location: index.html");
                exit;
            }
        }

        function login_utente($mail, $password, $conn) {
            $query_dati = "SELECT email,name,password FROM user WHERE email='".trim($mail)."' and password='$password' limit 1";
            $result_dati = $conn->query($query_dati);
            return (array) $result_dati->fetch_assoc();
        }

        function login($data, $cocks){
            echo "ecco il risultato della checkbox", $cocks;
            if ($cocks){
                setcookie("UserData", $data, strtotime("+1 year"));
            }else {
                $_SESSION ["UserData"] = $data;
            }
        }
        ?>
        <script>
            setTimeout(function() {
            window.location.replace("index.html");
            }, 2000)
        </script>
    </body>
</html>