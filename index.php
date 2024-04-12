<!doctype html>
<html lang="it-IT">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ShareNotes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style_login.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
    <script src="js/script_login.js"></script>
    <link rel="icon" href="img\logo_favicon.ico" type="image/x-icon"> <!-- inserire qui una nuova immagine come logo della finestra nel browser, chiedere a forna di farla-->
  </head>
  <body id="corpo">
    <div id="blurrato" class="transition-back">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <header>
          <nav id="navbar" class="navbar navbar-dark bg-light fixed-top">
          <div class="container-fluid">
              <img id="img_logo" src="img/logo.png">
            <a href="Functionalities.php"><button class="Functionalities" type="button">Funzionalità</button></a>
            <a href="cercaNote.php"><button class="SearchNotes" type="button">Cerca appunti</button></a>
            <a href="aboutPage.php"><button class="About" type="button">About</button></a>
            <?php

              use PHPMailer\PHPMailer\PHPMailer;
              use PHPMailer\PHPMailer\SMTP;
              use PHPMailer\PHPMailer\Exception;

              require 'PHPMailer/src/Exception.php';
              require 'PHPMailer/src/PHPMailer.php';
              require 'PHPMailer/src/SMTP.php';
              //require 'vendor/autoload.php';

            session_start();
            include ('utils.inc.php');
            include("conn.inc.php");

            if(isset($_POST['loGOut'])){
              logOut();
              if (isset($_COOKIE["UserMail"])){
                unset($_COOKIE["UserData"]);
                setcookie("UserMail", Null, -1,"/");
              }
            }

            function sendMail($mail, $name, $key, $soggetto, $htmlBody, $Alt){
              $messaggio = new PHPMailer(true);
              try {

                $messaggio->isSMTP();                                            //Send using SMTP
                $messaggio->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $messaggio->SMTPAuth   = true;                                   //Enable SMTP authentication
                $messaggio->Username   = 'sharenotes.workspace@gmail.com';                     //SMTP username
                $messaggio->Password   = 'cdpffwaxccrwnyya';                               //SMTP password
                $messaggio->SMTPSecure = PHPmailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $messaggio->Port       = 465;

                $messaggio->SMTPOptions = array(
                  'ssl' => array(
                      'verify_peer' => false,
                      'verify_peer_name' => false,
                      'allow_self_signed' => true
                  )
                );

                $messaggio->setFrom('sharenotes.workspace@gmail.com', 'ShareNotes');
                $messaggio->addAddress($mail, $name);     //Add a recipient
                $messaggio->addReplyTo('sharenotes.workspace@gmail.com', 'ShareNotes');

                $messaggio->isHTML(true);
                $messaggio->addEmbeddedImage('img/logo.png','logo.png');
                $messaggio->addEmbeddedImage('img/sfondo_index.jpg', 'sfondo_index.jpg');
                $messaggio->Subject = $soggetto;
                $messaggio->Body = $htmlBody;
                $messaggio->AltBody = $Alt;

                $messaggio->send();
              } catch(Exception $ex){
                echo "<script>
                  alert('Non e' stato possibile inviare la mail di ripristino, Errore: {$messaggio->ErrorInfo}');
                </script>";
              }
            }

            if(isset($_POST['forgot']) and $_POST['forgot'] == 'avanti'){

              $stmtK = $conn->prepare("SELECT chiave, name FROM user WHERE email=?");
              $stmtK->bind_param('s', $mail);

              $mail = (string) $_POST["emailInput"];

              $stmtK->execute();
              $resultK = $stmtK->get_result();
              $ar = $resultK->fetch_assoc();
              $K = (string) $ar["chiave"];
              $nome = (string) $ar["name"];

              $Body = '<style>
              body{
                  background-image: url(\'sfondo_index.jpg\');
                  text-align: center;
              }
          </style>
          <img src="logo.png" alt="LOGO" style="position:absolute; left:0%; top:0%;
              height: 200px;">
          <h1 style="color: orange; margin-top:100px; font-size:50px;">Pasuwādo no risetto:</h1>
          <p style="color: black; margin-top:40px; font-size:30px;">Risetto o yōkyū shiteinai bāi wa <br> kono mēru o mushi shitekudasai; sonota:</p>
          <a href="http://localhost/nweP.php?key=' . $K. '"><button style="background-color:lightblue; 
              border-color:darkblue; color:black; font-weight:bold; border-radius: 20px; font-size:20px; padding:6px;
              border-width:3px;">Pasuwādo o risetto suru</button></a>';
              $alt = "Ohayo $nome,\r\nPasuwādo o risetto suru ni wa, kono rinku o kurikku shitekudasai:\r\n\r\nhttp://localhost/nweP.php?key=" . $K. "\n";
              $sub = 'Ripristino Password';

              sendMail($mail, $nome, $K, $sub, $Body, $alt);
            }

            if(isset($_POST['logEmailInput'])){
              function check_dati($conn) {
                $email = NULL;
                $stmt_check_mail = $conn->prepare("SELECT password,attivo FROM user WHERE email=?");
                $stmt_check_mail->bind_param('s', $email);

                $password_inserita = (string) $_POST["passwordInput"];
                $email = (string) $_POST["logEmailInput"];

                $stmt_check_mail->execute();
                $result_mail = $stmt_check_mail->get_result();
                $array_dati = $result_mail->fetch_assoc();
                $hash = $array_dati["password"];
                $active = $array_dati["attivo"];
                if (password_verify($password_inserita, $hash) && $active) {
                  return (array) login_utente($email, $conn);
                } else {
                  echo"<script>
                          setTimeout(function() {
                              window.history.back();
                          }, 0)
                      </script>";
                }
              }

              logOut();
              $conn = new mysqli("localhost", "root", "", "share-notes");
              $cock = (int) $_POST["stayLogged"];
              if ($conn->connect_error) {
                die("Connessione al db fallita: ". $conn->connect_error);
              }
              $user_data = check_dati($conn);
              login($user_data, $cock);
            }

            if (isLogged()) {
              //style="background-image: url(\'img/loggedIn.png\');"
              echo '<button class="login_button_1" type="button" id="openPopupBtn" style="background-image: url(\'img/login.png\');"></button>';
            }else {
              if (sexOrCock()){
                $nomeUtente = (string) $_SESSION["UserData"]["name"];
              }else {
                $stmt_nome = $conn->prepare("SELECT name FROM user WHERE email=?");
                $stmt_nome->bind_param('s', $cookieMail);

                $cookieMail = (string) $_COOKIE['UserMail'];

                $stmt_nome->execute();
			          $result_nome = $stmt_nome->get_result();
			          $nomeUtente = (string) ($result_nome->fetch_assoc())['name'];
              }
              echo '<a href="profile_page.php"><button class="login_button_2" type="button">',$nomeUtente , '</button></a>';
              echo '<form action="index.php" method="post">
                <button name="loGOut" value=1 class="logOut" type="submit"></button>
              </form>';
            }

            function addNote($mail, $conn){
              $contenuto = "Blank";

              $conn->begin_transaction();
              try{
                $stmtTabellaBase = $conn->prepare("INSERT INTO nota(email, contenuto) VALUES (?, ?)");
                $stmtTabellaBase->bind_param('ss', $mail, $contenuto);

                $stmtTabellaBase->execute();

                $conn->commit();
              } catch (mysqli_sql_exception $exception){
                $conn->rollback();

                throw $exception;
              }
              
              $resultTabBase = $stmtTabellaBase->affected_rows;
              if($resultTabBase < 1){
                echo '<br><h1 style="text-align: center; text-weight: bold;">Errore creazione nota</h1>';
              }
            }

            if(isset($_POST['regNickInput'])){

              $conn->begin_transaction();
              try{
                $stmt = $conn->prepare("INSERT INTO user(name, email, password, chiave, classe) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param('sssss', $nickname, $email, $password, $key, $class);

                $email = trim((string) $_POST["emailInput"]);
                $password = password_hash((string) $_POST["passwordInput"], PASSWORD_BCRYPT);
                $nickname = (string) $_POST["regNickInput"];
                $class = (string) $_POST["classe-sel"];
                $salt = "keyCreati0n";
                $key = crypt($email, $salt);

                $stmt->execute();

                $conn->commit();
              } catch (mysqli_sql_exception $exception){
                $conn->rollback();

                throw $exception;
              }
              
              $result = $stmt->affected_rows;
              addNote($email, $conn);

              $Body = '<style>
              body{
                background-image: url(\'sfondo_index.jpg\');
                text-align: center;
              }
            </style>
            <img src="logo.png" alt="LOGO" style="position:absolute; left:0%; top:0%;
              height: 200px;">
            <h1 style="color: red; margin-top:100px; font-size:50px;">Benvenuto '.$nickName.'<br>su ShareNotes!!</h1>
            <p style="color: black; margin-top:40px; font-size:30px;">Click here to <br> validate your <br> account:</p>
            <a href="http://localhost/activate.php?key=' .$key. '"><button style="background-color:pink; 
              border-color:blueviolet; color:black; font-weight:bold; border-radius: 15px; font-size:20px; padding:6px;
              border-width:3px;">Validate</button></a>';
              $alt = "Benvenuto $nickName,\r\nper confermare la tua iscrizione clicca sul seguente link:\r\n\r\nhttp://localhost/activate.php?key=" . $key. "\n";
              $sub = 'Attivazione account';

              sendMail($email, $nickname, $key, $sub, $Body, $alt);
            }

            function mostraClassi($conn){
              $stmtClassi = $conn->prepare("SELECT nome FROM class");

              $stmtClassi->execute();
              $resultClassi = $stmtClassi->get_result();
              $numClassi = mysqli_num_rows($resultClassi);
              $class = array();
              while ($row = $resultClassi->fetch_assoc()) {
                $class[] = $row;
              }
              for ($j = 0; $j < $numClassi; $j++) {
                if ((string) $class[$j]["nome"] != "NUL"){
                  echo "<option value='".(string) $class[$j]["nome"]."'>".(string) $class[$j]["nome"]."</option>\n";
                }else {
                  echo "<option value='NULL'>NULL</option>\n";
                }
              }
            }
            ?>
            <!-- to change the side where the off-canvas slides in: change the "offcanvas offcanvas-start ..." to "offcanvas offcanvas-end ..."-->
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
              <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">ShareNotes</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                  <li class="nav-item">
                    <a class="nav-link active" id="Home" aria-current="page" role="button" href="#">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="Link" role="button" href="#">Link</a>
                  </li>
                </ul>
                <form class="d-flex mt-3" role="search">
                  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                  <button class="btn btn-success" type="submit">Search</button>
                </form>
              </div>
            </div>
          </div>
        </nav>
      </header>
      <h1 id="main_title">Benvenuti su Sharenotes!</h1>
      <div class="img-text">
        <img id="img_insert" src="img/immagine.png" alt="Inserire l'immagine...">
          <text id="text_1">Prendere appunti, studiare, lavorare in gruppo e condividere con tutti il tuo lavoro!</text>
      </div>
      <div class="Explore">
        <h3 id="title_Explore">Esplora</h3>
        <text id="txt_Explore">Cerca tutti gli appunti che vuoi quando vuoi!</text>
        <div class="Explore_btn">
          <a href="bhopage" alt="ciao ciao"><button class="UniscitiExplore" type="button">Unisciti a noi</button></a>
        </div>
        <img id="img_Explore" src="img/immagine.png" alt="Inserire un'immagine">
      </div>
      <div class="Create">
        <img id="img_Create" src="img/cration.jpg" alt="Inserire un'immagine">
        <h3 id="title_Create">Crea</h3>
        <text id="txt_Create">Crea appunti, aiutati con immagini, disegni, schemi, colori e dai vita ad opere uniche!</text>
        <div class="Create_btn">
          <a href="#" alt="ciao ciao"><button class="UniscitiCreate" type="button">Unisciti a noi</button></a>
        </div>
      </div>
      <div class="Share">
        <h3 id="title_Share">Condividi</h3>
        <text id="txt_Share">Condividi con chi desideri i tuoi appunti, aiuta e confrontati con i tuoi amici per migliorare sempre di più!</text>
        <div class="Share_btn">
          <a href="bhopage" alt="ciao ciao"><button class="UniscitiShare" type="button">Unisciti a noi</button></a>
        </div>
        <img id="img_Share" src="img/sharing.png" alt="Inserire un'immagine">
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </div>
    <!--<button id="openPopupBtn">Apri Popup</button>-->
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close" id="closePopupBtn">&times;</span>
            <div class="pop-menu">
                <div class="pop-menu">
                    <h1 class="popup-sets">Crea il tuo<br>SnakeID!</h1>
                    <button id="register" class="register-button">Registrati</button><br>
                    <p class="txt-snakeID">Hai già uno SnakeID?
                        <p>
                            <button id="access" class="login-button">Accedi</button><br>
                </div>
            </div>
        </div>
    </div>
    <a name="accesso"></a>;
    <div id="access-popup" class="popup">
        <div class="popup-content">
            <span class="close" id="closeaccess">&times;</span>
            <div class="pop-menu">
                <h1 class="popup-sets-access">Accedi:</h1>
                <form action="index.php" method="post">
                    <input class="login-inputs" type="text" id="emailInputaccess" name="logEmailInput" placeholder="E-mail" autocomplete="email" onchange="validateLogin()"><br>
                    <input class="login-inputs" type="password" id="passwordInputaccess" name="passwordInput" placeholder="Password" autocomplete="current-password" onchange="validateLogin()">
                    <input type="checkbox" id="showPasswordAccess" class="checkbox-login"><br>
                    <text>Vuoi rimanere loggato?</text><br>
                    <text>sì</text><input type="checkbox" id="loggedOn" name="stayLogged" onchange="validateLogin()" onchange="onlyOneYes()" value=1>
                    <text>no</text><input type="checkbox" id="loggedOff" name="stayLogged" onchange="validateLogin()" onchange="onlyOneNo()" value=0>
                    <p id="controlloLog" class="ctr-login">
                        <p>
                            <input type="submit" value="Avanti" id="avanti-access" class="avanti-login-button">
                            <!--<button class="avanti-login-button">Avanti</button>-->
                </form>
                <div class="try">
                    <h6 class="no-account">non hai uno SnakeID?!</h6>
                    <button id="register-out" class="register-out-button">Registrati</button><br>
                    <a id="open-popup-reset" href="#" class="pass-lost">hai perso la password?</a>
                    <!-- aggiugnere al posto di "#" il link per la pagina per reimpostare la password-->
                </div>
            </div>
        </div>
    </div>
    <a name="registrazione"></a>;
    <div id="register-popup" class="popup">
        <div class="popup-content">
            <span class="close" id="closeregister">&times;</span>
            <div class="pop-menu-register">
                <h1 class="popup-sets">Registrati:</h1>
                <form action="index.php" method="post">
                    <input class="login-inputs" type="text" id="nickinput" name="regNickInput" placeholder="Nickname"><br>
                    <input class="login-inputs" type="text" id="emailInput" name="emailInput" placeholder="E-mail" autocomplete="email" onchange="validatePassword()"><br>
                    <input class="login-inputs" type="password" id="passwordInput" name="passwordInput" placeholder="Password" autocomplete="current-password"><br>
                    <input type="checkbox" id="showPasswordRegister" class="checkbox-register">
                    <input class="login-inputs" type="password" id="passwordInputControl" name="passwordInputControl" placeholder="Conferma password" autocomplete="current-password" onchange="validateEmail()"><br>
                    <select id="classes" name="classe-sel" class="class-select" onchange="validatePassword()">
                        <option value="none">classe</option>
                        <?php mostraClassi($conn) ?>
                        <!-- inserire scelte, quella test è di prova -->
                      </select>
                    <p id="controllo" class="ctr-register">
                        <p>
                            <input type="submit" value="Avanti" id="avanti-register" class="avanti-register-button">
                            <!--<button class="avanti-register-button">Avanti</button>-->
                </form>
                <div>
                    <h6 class="no-account">hai già uno SnakeID?!</h6>
                    <button id="access-out" class="login-out-button">Accedi</button>
                </div>
            </div>
        </div>
    </div>
    <div id="popup-requirements" class="popup">
        <div class="popup-content">
            <div class="pop-menu">
                <div class="pop-menu">
                    <h1 class="cookie-title">Noi crediamo nel rispetto della privacy altrui</h1>
                    <p class="cookie-accept-class">Noi e i nostri fornitori archiviamo informazioni quali cookie su un dispositivo (e/o vi accediamo) e trattiamo i dati personali, quali gli identificativi unici e informazioni generali inviate da un dispositivo, per personalizzare gli
                        annunci e i contenuti, misurare le prestazioni di annunci e contenuti, ricavare informazioni sul pubblico e anche per sviluppare e migliorare i prodotti. Con la tua autorizzazione noi e i nostri fornitori possiamo utilizzare dati
                        precisi di geolocalizzazione e identificazione tramite la scansione del dispositivo.</p>
                    <input type="submit" value="rifiuto" id="refuse-requirements" class="refuse-cookie-btn">
                    <input type="submit" value="accetto" id="accept-requirements" class="accept-cookie-btn">
                </div>
            </div>
        </div>
    </div>
    <div id="popup-reset" class="popup">
        <div class="popup-content">
            <span class="close" id="close-reset">&times;</span>
            <div class="pop-menu">
                <div class="pop-menu">
                    <h1 class="popup-reset-sets">Resetta la password</h1>
                    <form action="index.php" method="post">
                        <input class="login-inputs" type="text" id="emailInputReset" name="emailInput" placeholder="E-mail" autocomplete="email" onchange="resetCtr()"><br>
                        <p id="ctr-reset" class="ctr-reset-output"></p><br>
                        <input name="forgot" type="submit" value="avanti" id="reset-password-accept" class="avanti-reset-btn">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>