<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/CSS" href="stile_Functionalities.css">
    <link rel="icon" href="img\logo_favicon.ico" type="image/x-icon">
</head>
<body class="body">
    <nav class="navbar" class="navbar navbar-dark bg-light fixed-top">
        <div class="container-fluid">
            <img id="imm" src="img/im.png">
            <a href="index.php"><button id="bottone1" class="bottoni"  type="button">HOME</button></a>
            <a href="aboutPage.php"><button id="bottone2" class="bottoni"   type="button">ABOUT</button></a>
            <a href="cercaNote.php"><button  id="bottone3" class="bottoni"  type="button">CERCA NOTE</button></a>
            <?php
                  session_start();
                  include ('utils.inc.php');
                  if (!isLogged()) {
                      echo '<a  id="bott" href="profile_page.php" ><button id="si" class="bottoni"  type="button"><img id="imm2" id="bottone5"  src="img/user.png"></button></a>';
                  }else {
                      //style="background-image: url(\'img/loggedIn.png\');"
                      echo '<a  id="bott" href="index.php" ><button id="si" class="bottoni"  type="button"><img id="imm2" id="bottone5"  src="img/user.png"></button></a>';
                  }
              ?>
              <hr id="linea">
        </div>
    </nav>
    <h1 id="titolo">FUNZIONALITA'</h1>
    <p id="testo" class="font">Consulta questa pagina prima di iniziare a creare le tue note, in modo da poterti orientare meglio all'interno del mondo di<br> Sharenotes.
                  Questa pagina è come <br>una mappa, ti aiuterà a scoprire ed a trovare la strada migliore per creare i tuoi appunti.
                   Buon viaggio!!</p>
    <h2 class="font" id="titoletto" class="stile">PAGINA PROFILO</h2>
    <img id="immagine" src="img/image.jpg">
    <img id="prova" src="img/sfondino.png">
    </b><p id="profilo" class="font">La pagina profilo ti permette di visionare le note create e quelle che hai deciso<br> di salvare,
        l'unico punto da segnalare per quanto riguarda questa pagina è che<br> alcune materie più grandi ne contengono altre.<br>
        Ecco l'elenco: <br>
        1] Biologia (biologia,organica,microbiologia,anatomia,igiene, fisiologia)<br>
        2] Meccanica (disegno tecnico, sistemi e automazioni) <br>
        3] Elettronica (tpse, sistemi automatici)<br>
        4] Scienze (fisica, scienze della terra,<br> scienze collegate all'indirizzo, naturali)<br>
        5] Chimica (analitica, orgnica) <br>
        6] Sistemi e reti verrà aggiunto in seguito </p></b>
    <h2 id="titoletto2" class="font" class="stile">PAGINA CREAZIONE</h2>
    <img id="immagine2" src="img/image2.jpg">
    </b><p id="creazione" class="font">La pagina creazione ti permette di creare le tue note. E' formata da varie<br> barre che possono essere aperte mediante la barra principale [visibile <br>premendo il +]<br>
                      I punti da segnalare sono i seguenti: <br>
                      1] Per confermare la cancellazione di un elemento(come per le varie forme)<br> ripremere  sul tasto una volta finito e posizionarsi  con il cursore su qualsiasi <br>punto del foglio<br>
                      2] E' possibile spostare solo l'ultima parola inserita e solo fino a quando<br> non si cambia posizione del cursore<br></p></b>
    <h2 id="titoletto3" class="stile" class="font">PAGINA CERCA NOTE</h2>
    <img id="immagine3" src="img/image3.png">
     </b><p id="cerca" class="font">La pagina cerca note ti permette di trovare e scaricare le note<br> fatte da altre persone.
                  I punti da segnalare sono i seguenti:<br>
                  1] Hai la possibilita' di mettere i likes alle note che più ti piacciono<br>
                  2] Usa i filtri per muoverti più velocemente tra le varie note<br>

    </p></b>


</body>
