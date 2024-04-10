<!DOCTYPE html>
<html>

<head>
    <title>CERCA NOTE</title>
    <link rel="stylesheet" href="cercaNote.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="js/cercaNote.js"></script>
    <link rel="stylesheet" href="style_login.css">
    <script src="script_login.js"></script>
</head>

<body onload="setAll()">
    <?php
    session_start();
    include("conn.inc.php");
    include "utils.inc.php";

    if(isset($_POST['materia'])){
        $materia = (string) $_POST['materia'];
    }
    if(isset($_POST['anno'])){
        $anno = (int) $_POST['anno'];
    }
    if(isset($_POST['classe'])){
        $classe = (string) $_POST['classe'];
    }
    if(isset($_POST['SearchBar'])){
        $ricerca = (string) $_POST['SearchBar'];
    }

    function mostraMaterie($conn){
        $stmtMat = $conn->prepare("SELECT * FROM materia");

        $stmtMat->execute();
        $resultMat = $stmtMat->get_result();
        $num_mate = mysqli_num_rows($resultMat);
		$mate = array();
		while ($row = $resultMat->fetch_assoc()) {
			$mate[] = $row;
		}
			for ($j = 0; $j < $num_mate; $j++) {
				$nome = $mate[$j]["nome"];
                echo "<option value='".$nome."'>".$nome."</option>";
			}
    }

    function mostraClassi($conn){
        $stmtClass = $conn->prepare("SELECT * FROM class");

        $stmtClass->execute();
        $resultClass = $stmtClass->get_result();
        $num_class = mysqli_num_rows($resultClass);
		$mate = array();
		while ($row = $resultClass->fetch_assoc()) {
			$mate[] = $row;
		}
		for ($j = 0; $j < $num_class; $j++) {
			$nome = $mate[$j]["nome"];
            echo "<option value='".$nome."'>".$nome."</option>";
		}
    }

    function swap(&$first = array(), &$second = array()){
        $toSwap = array();

        $toSwap = $first;
        $first = $second;
        $second = $toSwap;
    }

    function sortMatByVal(&$mat = array(), $lenght){
        for ($j = 1; $j < $lenght; $j++){
            for ($i = $j; $i > 0 and $mat[$i]['likes'] > $mat[$i-1]['likes']; $i--){
                swap($mat[$i], $mat[$i-1]);
            }
        }
    }

    function searchT($nome, $find, $codice){
        if(stripos($nome, $find) or stripos($find, $nome)){
            echo "<br><button name='codNota' value=$codice>$nome</button>";
        }else if($find == NULL){
            echo "<br><button name='codNota' value=$codice>$nome</button>";
        }
    }

    function searchM($subject, $materia, $nome, $find, $codice){
        if($subject == 'all'){
            searchT($nome, $find, $codice);
        }else if($subject == $materia){
            searchT($nome, $find, $codice);
        }
    }

    function searchC($class, $classe, $subject, $materia, $nome, $find, $codice){
        if($class == 'none'){
            searchM($subject, $materia, $nome, $find, $codice);
        }else if($class == $classe){
            searchM($subject, $materia, $nome, $find, $codice);
        }
    }

    function stampaNote($conn, $year, $class, $subject, $find){
        //Tutte le note di base in base ai like in ordine decrescente...
        $mine = NULL;
        $shared = NULL;
        $stmtNote = $conn->prepare("SELECT * FROM nota WHERE mia=? and condivisa=?");
        $stmtNote->bind_param('ii', $mine, $shared);

        $mine = 1;
        $shared = 1;

        $stmtNote->execute();
        $resultNote = $stmtNote->get_result();
        $num_note = mysqli_num_rows($resultNote);
		$note = array();
		while ($row = $resultNote->fetch_assoc()) {
			$note[] = $row;
		}
        sortMatByVal($note, $num_note);
        echo "<form target='_blank' action='show.php' method='post'>";
		for ($j = 0; $j < $num_note; $j++) {
			$nome = ' '.$note[$j]["titolo"];
            $materia = $note[$j]["materia"];
            $anno = $note[$j]["annoScolastico"];
            $classe = $note[$j]["classe"];
            $codice = $note[$j]["codicenota"];
            if($year == 0){
;                searchC($class, $classe, $subject, $materia, $nome, $find, $codice);
            }else if($year == $anno){
                searchC($class, $classe, $subject, $materia, $nome, $find, $codice);
            }
		}
        echo "</form>";
    }
    ?>
    <nav class="navbar" class="navbar navbar-dark bg-light fixed-top">
        <div class="container-fluid">
            <a href="index.php"><img id="imm" class="bar-Btns" src="img/im.png" style="height:95px; width: 220px"></a>
            <a href="Functionalities.php"><button id="bottone1"  class="bar-Btns" type="button">Funzionalità</button></a>
            <a href="index.php"><button id="bottone2"  class="bar-Btns" type="button">Home</button></a>
            <a href="aboutPage.php"><button  id="bottone3" class="bar-Btns" type="button">Chi Siamo?</button></a>
          <?php
            if (isLogged()) {
                echo '<a href="index.php" ><button id="bottone5" type="button"><img src="img/user.png" style="height: 80px"></button></a>';
            }else {
                echo '<a href="profile_page.php" ><button id="bottone5" type="button"><img src="img/user.png" style="height: 80px"></button></a>';
            }
          ?>
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
                </div>
            </div>
        </div>
    </nav>
    <hr id="rowUpper">
    <div class="ciao">
        <div class="sidebar">
            <h1 id="titolo">Cerca tutti gli appunti che desideri</h1>
            <hr id="titleRow">
            <!-- materia, anno, classe-->
            <h3 id="titleFilters">Filtri:</h3>
            <div class="filtersBlock">
                <form action="cercaNote.php" method="post" id="Filters">
                    <select name="materia" id="matFilter" onchange="submitSelected('matFilter')">
                    <option value='all'>Materia</option>
                    <?php mostraMaterie($conn) ?>
                </select><br>
                    <select name="anno" id="annoFilter" onchange="submitSelected('annoFilter')">
                    <option value=0>Anno</option>
                    <option value=1>1°</option>
                    <option value=2>2°</option>
                    <option value=3>3°</option>
                    <option value=4>4°</option>
                    <option value=5>5°</option>
                </select><br>
                    <select name="classe" id="classFilter" onchange="submitSelected('classFilter')">
                    <option value='none'>Classe</option>
                    <?php mostraClassi($conn) ?>
                </select>
                </form>
            </div>
            <div id="vr" style="height:100%; width:1px;margin-left:270px;margin-top:-378px;"></div>
        </div>
    <div class="input-container">
        <form action="cercaNote.php" method="post" id="Search">
            <input name="SearchBar" id="input" type="text" placeholder="CERCA DEGLI APPUNTI TRAMITE IL LORO TITOLO:" onchange="submitSelected('input', 'Search')">
        </form>
        <div id="allNotes">
            <?php stampaNote($conn, $anno ?? 0, $classe ?? 'none', $materia ?? 'all', $ricerca ?? NULL); ?>
        </div>
    </div>
  </div>
</body>
</html>