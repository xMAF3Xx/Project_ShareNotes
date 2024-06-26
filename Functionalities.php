<!DOCTYPE html>
<head>
    <link  href="stile_Functionalities.css" rel="stylesheet" type="text/CSS">
    <link rel="icon" href="img\logo_favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="body">
    <nav class="navbar" class="navbar navbar-dark bg-light fixed-top">
        <div class="container-fluid">
            <img id="imm" src="img/im.png">
            <a href="index.php"><button id="bottone1" class="bottoni"  type="button">Home</button></a>
            <a href="aboutPage.php"><button id="bottone2" class="bottoni"   type="button">About</button></a>
            <a href="cercaNote.php"><button  id="bottone3" class="bottoni"  type="button">Cerca Note</button></a>
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
    <div class="upper-Section">
        <h1 id="titolo">FUNZIONALITA'</h1>
        <p id="testo" class="font">Consulta questa pagina prima di iniziare a creare le tue note, in modo da poterti orientare meglio all'interno del mondo di<br> Sharenotes.
            (Ricorda che questo sito è ottimizzato solo per pc al momento)Questa pagina è come <br>una mappa, ti aiuterà a scoprire ed a trovare la strada migliore per creare i tuoi appunti.
            Buon viaggio!!
        </p>
    </div>
    <div class="profile-Section">
        <h2 class="font" id="titoletto" class="stile">PAGINA PROFILO</h2>
        <img id="immagine" src="img/profilo.png">
        <p id="profilo" class="font">La pagina profilo ti permette di visionare le note create e quelle che hai deciso<br> di salvare,
            l'unico punto da segnalare per quanto riguarda questa pagina è che<br> alcune materie più grandi ne contengono altre.<br>
            Ecco l'elenco: <br>
            1] Biologia (biologia,organica,microbiologia,anatomia,igiene, fisiologia)<br>
            2] Meccanica (disegno tecnico, sistemi e automazioni) <br>
            3] Elettronica (tpse, sistemi automatici)<br>
            4] Scienze (fisica, scienze della terra,<br> scienze collegate all'indirizzo, naturali)<br>
            5] Chimica (analitica, orgnica) <br>
            6] Sistemi e reti verrà aggiunto in seguito
        </p>
    </div>
    <div class="create-Section">
        <h2 id="titoletto2" class="font" class="stile">PAGINA CREAZIONE</h2>
        <p id="creazione" class="font">La pagina creazione ti permette di creare le tue note. E' formata da varie<br> barre che possono essere aperte mediante la barra principale [visibile <br>premendo il +]<br>
            I punti da segnalare sono i seguenti: <br>
            1] Per confermare la cancellazione di un elemento(come per le varie forme)<br> ripremere  sul tasto una volta finito e posizionarsi  con il cursore su qualsiasi <br>punto del foglio<br>
            2] E' possibile spostare solo l'ultima parola inserita e solo fino a quando<br> non si cambia posizione del cursore<br>
            3] Per modificare una parola, ripremere il bottone scrivi. Dopo averlo fatto <br>vedrai la parola inserita precedentemente (cambiandola e premendo invio<br> verrà modificata), altrimenti cancellala e scrivi qualcos altro per inserire un<br> nuovo testo<br>
            4] STAI ATTENTO con il salvataggio, ricorda quando rientri in una nota<br> salvata temporaneamente clicca sul canvas perchè altrimenti VERRA'<br> <span style="background-color:yellow">CANCELLATO TUTTO IL TUO LAVORO!</span>
        </p>
        <img id="immagine2" src="img/crea.png">
        <!--<img id="prova" src="img/sfondino.png">-->
    </div>
    <div class="search-Section">
        <h2 id="titoletto3" class="stile" class="font">PAGINA CERCA NOTE</h2>
        <img id="immagine3" src="img/reset.png">
        <p id="cerca" class="font">La pagina cerca note ti permette di trovare e scaricare le note<br> fatte da altre persone.
            I punti da segnalare sono i seguenti:<br>
            1] Hai la possibilita' di mettere i likes alle note che più ti piacciono<br>
            2] Usa i filtri per muoverti più velocemente tra le varie note<br>
            <br>
            <br>
            P.S: Per il reset password per questioni di sicurezza valgono i seguenti criteri:<br>
            1] Minimo 8 caratteri <br>
            2] Non devono avere spazi <br>
            3] Non devono iniziuare ne con $ ne con @  <br>
            4] Non può essere password, PASSWORD, 12345678, 00000000, ABCDEFGH o abcdefgh <br>
        </p>
    </div>



</body>
