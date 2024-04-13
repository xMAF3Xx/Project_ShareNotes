<!DOCTYPE html>
<html lang="it-IT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
    <link type="text/CSS" rel="stylesheet" href="profile_page.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
    <script src="js/profile_page.js"></script>
    <script src="js/script_selezione.js"></script>
    <script src="js/scarica.js"></script>
    <link rel="icon" href="img\logo_favicon.ico" type="image/x-icon">
    <!-- inserire qui una nuova immagine come logo della finestra nel browser, chiedere a forna di farla-->
</head>

<body onload="setAll()">
    <?php
        session_start();
        include("conn.inc.php");
        include "utils.inc.php";

        if (isLogged()) {
            echo "<script>alert('Devi prima loggarti per poter prendere appunti.')
                    setTimeout(function() {
                    window.location.replace(\"index.php\");
                    }, 0)
                </script>";
        }

        if(isset($_POST['share'])){ //da aggiungere  a Matte...
            $checkShare = $conn->prepare("SELECT mia FROM nota WHERE codicenota=?");
            $checkShare->bind_param('i', $code);

            $code = (int) $_POST['share'];

            $checkShare->execute();
            $resultCShare = $checkShare->get_result();
            $mia = ($resultCShare->fetch_assoc())['mia'];
            if($mia == 1){

                $conn->begin_transaction();
                try{
                    $stmtShare = $conn->prepare("UPDATE nota SET condivisa=1 WHERE codicenota=?");
                    $stmtShare->bind_param('i', $code);

                    $stmtShare->execute();

                    $conn->commit();
                } catch (mysqli_sql_exception $exception){
                    $conn->rollback();

                    throw $exception;
                }
                
                $resultShare = $stmtShare->affected_rows;
                if($resultShare < 1){
                    echo '<script>
                        alert("Non e\' stato possibile condividere la nota, riprova in seguito...");
                    </script>';
                }
            }else {
                echo '<script>
                    alert("Non puoi condividere una nota non tua, devi prima modificarla...");
                </script>';
            }
        }

        if(isset($_POST['creaNota']) and ((int) $_POST['creaNota']) == 1){
            if (sexOrCock()){
                $mail = (string) $_SESSION["UserData"]["email"];
                $classe = (string) $_SESSION["UserData"]["classe"];
            }else {
                $stmtClass = $conn->prepare("SELECT classe FROM user WHERE email=?");
                $stmtClass->bind_param('s', $mail);

                $mail = (string) $_COOKIE["UserMail"];

                $stmtClass->execute();
                $resultClass = $stmtClass->get_result();
                $classe = ($resultClass->fetch_assoc())['classe'];
            }
            $stmtSearch = $conn->prepare("SELECT * FROM nota WHERE email=? and titolo=?");
            $stmtSearch->bind_param('ss', $mail, $titolo);

            $titolo = "NotaBianca";

            $stmtSearch->execute();
            $resultSearch = $stmtSearch->get_result();

            if($resultSearch->num_rows > 0){
                echo '<script>
                    alert("Hai già una nuova nota non modificata!?!; Sei pregato di usare prima quella.");
                </script>';
            }else{

                $conn->begin_transaction();
                try{
                    $stmtNuovaNota = $conn->prepare("INSERT INTO nota(email, classe) VALUES (?,?)");
                    $stmtNuovaNota->bind_param('ss', $mail, $classe);

                    $stmtNuovaNota->execute();

                    $conn->commit();
                } catch (mysqli_sql_exception $exception){
                    $conn-> rollback();

                    throw $exception;
                }
                
                $resultNuovaNota = $stmtNuovaNota->affected_rows;

                $stmtCodice = $conn->prepare("SELECT codicenota FROM nota WHERE email=? and titolo=?");
                $stmtCodice->bind_param('ss', $mail, $blank);

                $blank = 'NotaBianca';

                $stmtCodice->execute();
                $resultCode = $stmtCodice->get_result();
                $codice = ($resultCode->fetch_assoc())['codicenota'];
                echo '<form method="post" action="download.php" id="fTSend">
                    <input type="number" name="codNota" style="display: none;" value='.$codice.'>
                </form>
                <script>
                    document.getElementById("fTSend").submit();
                </script>';
            }
        }

        if (isset($_SESSION["UserData"])){
            $mail = (string) $_SESSION["UserData"]["email"];
			$nomeUtente = (string) $_SESSION["UserData"]["name"];
        }else {
			$stmt_nome = $conn->prepare("SELECT name FROM user WHERE email=?");
            $stmt_nome->bind_param('s', $mail);

            $mail = (string) $_COOKIE["UserMail"];

            $stmt_nome->execute();
			$result_nome = $stmt_nome->get_result();
			$nomeUtente = ($result_nome->fetch_assoc())['name'];
        }

        if(isset($_POST['eliminaNota'])){
            $checkNota = $conn->prepare("SELECT * FROM nota WHERE email=?");
            $checkNota->bind_param('s', $mail);

            $checkNota->execute();
            $resultCheck = $checkNota->get_result();
            $numNota = $resultCheck->num_rows;
            if($numNota > 1){

                $conn->begin_transaction();
                try{
                    $eliminazione = $conn->prepare("DELETE FROM nota WHERE codicenota=?");
                    $eliminazione->bind_param('i', $code);

                    $code = (int) $_POST['eliminaNota'];

                    $eliminazione->execute();

                    $conn->commit();
                } catch (mysqli_sql_exception $exception){
                    $conn->rollback();

                    throw $exception;
                }
                
                $resultEliminazione = $eliminazione->affected_rows;
                if($resultEliminazione < 1){
                    echo '<script>
                        alert("La nota non e\' stata eliminata correttamente, riprovare in seguito...");
                    </script>';
                }
            }else {
                echo '<script>
                        alert("La nota che stai tentando di eliminare e\' l\'ultima che ti rimane, non puoi eliminarla...");
                    </script>';
            }
        }

        function printNote($codice, $title, $content, $classe, $anno, $likes){ //In più rispetto a Matte... (poi da aggiungere)
            echo '<div class="NoteBlock">
                    <form method="POST" action="download.php" class="Apri">
                        <button name="codNota" class="ApriNota" value=', $codice ,'>', $title ,'</button>
                    </form>
                    <hr class="verticalLine">
                    <p class="Classe">Classe: ', $classe ,'</p>
                    <p class="Anno">Anno: ', $anno ,'\'</p>
                    <p class="likes"><img src="img/cuore.png" class="cuore">', $likes ,'</p>
                    <form method="POST" action="profile_page.php" class="Elimina">
                        <button name="eliminaNota" value=', $codice, ' class="EliminaNota"> 
                            <div class="container-bidoni">
                                <img src="img/bidone.png" class="bidone">
                                <img src="img/bidone.gif" class="bidone-profile">
                            </div>
                        </button>
                    </form>
                    <form action="profile_page.php" method="post" class="Condividi">
                        <button name="share" value=', $codice, ' class="CondividiNota"><img src="img/share.png" class="share"></button>
                    </form>
                    <button onclick="downloadNota(\''.$title.'\',\''.$content.'\')" class="DownloadNota"><img src="img/scarica.png" class="scarica"></button>
                </div>';
        }

        function filterA($anno, $ann, $codice, $title, $content, $class, $likes){
            if($anno == 0){
                printNote($codice, $title, $content, $class, $ann, $likes);
            }else if($anno == $ann){
                printNote($codice, $title, $content, $class, $ann, $likes);
            }
        }

		function mostra($mat, $mail, $conn, $anno, $appartenenza){

            $anno = (int) $anno;
            $appartenenza = (int) $appartenenza;
			$stmt_num_mate = $conn->prepare("SELECT * FROM nota WHERE email=? and materia=?");
            $stmt_num_mate->bind_param('ss', $mail, $mat);

            $stmt_num_mate->execute();
			$result_num_mate = $stmt_num_mate->get_result();
			$num_mate = mysqli_num_rows($result_num_mate);
			$mate = array();
			while ($row = $result_num_mate->fetch_assoc()) {
				$mate[] = $row;
			}
			for ($j = 0; $j < $num_mate; $j++) {
				$codice = $mate[$j]['codicenota'];
				$title = $mate[$j]['titolo'];
                $app = (int) $mate[$j]['mia'];
                $ann = (int) $mate[$j]['annoScolastico'];
                $content = (string) $mate[$j]['contenuto'];
                $likes = (int) $mate[$j]['likes'];
                $class = (string) $mate[$j]['classe'];
                if($appartenenza == 2){
                    filterA($anno, $ann, $codice, $title, $content, $class, $likes);
                }else if($appartenenza == $app){
                    filterA($anno, $ann, $codice, $title, $content, $class, $likes);
                }
			}
		}

        function stampaMaterie($conn){
            $stmtMaterie = $conn->prepare("SELECT * FROM materia");

            $stmtMaterie->execute();
            $resultMaterie = $stmtMaterie->get_result();
            $numMaterie = mysqli_num_rows($resultMaterie);
            $Materie = array();
            while ($row = $resultMaterie->fetch_assoc()) {
                $Materie[] = $row;
            }
            for($j = 0; $j < $numMaterie; $j++){
                echo '<option value="'.$Materie[$j]['nome'].'">'.$Materie[$j]['nome'].'</option>';
            }
        }

        function filter($materiaCorrente, $mail, $conn, $year, $mine){
            echo '<div class="folders" id="folder-'.$materiaCorrente.'" onclick="cambiaStatoMateria(\'folder-'.$materiaCorrente.'\')">
                    <h6 class="'.$materiaCorrente.'" id="titleSub-'.$materiaCorrente.'">'.$materiaCorrente.'
                        <h6>
                            <hr class="line-horizontal">';
                            mostra($materiaCorrente, $mail, $conn, $year, $mine);
                echo '</div>';
        }

        function stampaCartelleMaterie($conn, $mail){
            $filtro = 'All';

            if(isset($_POST['Classe'])){
                $year = (int) $_POST['Classe'];
            }
    
            if(isset($_POST['Proprieta'])){
                $mine = (int) $_POST['Proprieta'];
            }

            if(isset($_POST['Materia'])){
                $filtro = (string) $_POST['Materia'];
            }

            $stmtMat = $conn->prepare("SELECT * FROM materia");

            $stmtMat->execute();
            $resultMat = $stmtMat->get_result();
            $numMat = mysqli_num_rows($resultMat);
            $Mat = array();
            while ($row = $resultMat->fetch_assoc()) {
                $Mat[] = $row;
            }
            for($j = 0; $j < $numMat; $j++){
                $materiaCorrente = $Mat[$j]['nome'];
                if($filtro == 'All'){
                    filter($materiaCorrente, $mail, $conn, $year ?? 0, $mine ?? 2);
                }else if($materiaCorrente == $filtro){
                    filter($materiaCorrente, $mail, $conn, $year ?? 0, $mine ?? 2);
                }
            }
        }
        ?>
        <div class='container-verti'>
            <div class='horizontal'>
                <a href="index.php"><img class="logo" src="img/logo.png"></a>
                <a href="index.php"><button class="top-buttons-style">Home</button></a>
                <a href="aboutPage.php"><button class="top-buttons-style">Chi siamo?</button></a>
                <a href="cercaNote.php"><button class="top-buttons-style">Cerca appunti</button></a>
                <a href="Functionalities.php"><button class="top-buttons-style">Funzionalità</button></a>
                <hr class="line-horizontal">
                <div class="open-zone">
                    <h1 class="main-title">Appunti</h1>
                    <div class="scrollable">
                        <?php stampaCartelleMaterie($conn, $mail) ?>
                    </div>
                </div>
            </div>
            <hr class="line-vertical">
            <div class='vertical'>
                <div class="red-circle">
                    <form action="index.php" method="post">
                        <button type="submit" name="loGOut" value=1 style="background:none; border:none;"><img class="exit-btn" src="img\exit.png"></button>
                        <!-- da aggiungere a matte... -->
                    </form>
                </div>
                <img src="img/user.png" class="user-img">
                <h1 class="center-user-name">
                    <?php echo $nomeUtente ?>
                    <h1>
                        <h3 class="center-user-mail">
                            <?php echo $mail ?>
                            <h3>
                                <div class="line-horizontal"></div>
                                <h3 class="divisions">Filtri:</h3>
                                <nav class="division-column">
                                    <ul>
                                        <form action="profile_page.php" method="post" id="formFilter">
                                            <li>
                                                <select id="materia" name="Materia" class="options-dims" onchange="submitSelected('materia')">
            					            <option value="All">All</option>
                                            <?php stampaMaterie($conn) ?>
							            </select>
                                            </li>
                                            <li>
                                                <select id="classe" name="Classe" class="options-dims" onchange="submitSelected('classe')">
            					                <option value=0>All</option>
  								                <option value=1>Prima</option>
  								                <option value=2>Seconda</option>
 								                <option value=3>Terza</option>
  								                <option value=4>Quarta</option>
  								                <option value=5>Quinta</option>
							                </select>
                                            </li>
                                            <li>
                                                <select id="proprita" name="Proprieta" class="options-dims" onchange="submitSelected('proprita')">
            					                <option value=2>All</option>
  								                <option value=1>Creati da te</option>
  								                <option value=0>Creati da altri</option>
							                </select>
                                            </li>
                                        </form>
                                        <ul>
                                </nav>
                                <p class="crea-txt">Crea</p>
                                <form action="profile_page.php" method="post">
                                    <button value=1 name="creaNota" style="background:none; border:none;"> <!-- da aggiungere a matte... -->
                        <img src="img\create.png" class="create-btn">
                    </button>
                                </form>
                                <!--<a href="logout.php"><img class="exit-btn" src="img\exit.png"></a>-->
                                <!--tag probabilmente da cambiare per far uscire l'utente dall'account-->
            </div>
        </div>
</body>

</html>