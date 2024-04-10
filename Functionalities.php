<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/CSS" href="stile_Functionalities.css">
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
                if (isLogged()) {
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
    <p id="testo">Consulta questa pagina prima di iniziare a creare le tue note, in modo da poterti orientare meglio all'interno del mondo di Sharenotes.
                  Questa pagina è come <br>una mappa, ti aiuterà a scoprire ed a trovare la strada migliore per creare i tuoi appunti.
                   Buon viaggio!!</p>
    <h2 id="titoletto" class="stile">PAGINA PROFILO</h2>
    <img id="immagine" src="img/image.jpg">
    <p id="profilo">La pagina profilo ti permette di visionare le note create e quelle che hai deciso<br> di salvare,
        l'unico punto da segnalare per quanto riguarda questa pagina è che<br> alcune materie più grandi ne contengono altre.<br>
        Ecco l'elenco: <br>
        1] Biologia (biologia,organica,microbiologia,anatomia,igiene, fisiologia)<br>
        2] Meccanica (disegno tecnico, sistemi e automazioni) <br>
        3] Elettronica (tpse, sistemi automatici)<br>
        4] Scienze (fisica, scienze della terra,<br> scienze collegate all'indirizzo, naturali)<br>
        5] Chimica (analitica, orgnica) 
        6] Sistemi e reti verrà aggiunto in seguito </p>
    <h2 id="titoletto2" class="stile">PAGINA CREAZIONE</h2>
    <img id="immagine2" src="img/image2.jpg">
    <p id="creazione">La pagina creazione ti permette di creare le tue note. E' formata da varie barre che <br>possono essere aperte mediante la barra principale [visibile premendo il +]<br>
                      I punti da segnalare sono i seguenti: <br>
                      1] Per confermare la cancellazione di un elemento(come per le varie forme) ripremere <br> sul tasto una volta finito e posizionarsi  con il cursore su qualsiasi punto del foglio<br>
                      2] E' possibile spostare solo l'ultima parola inserita e solo fino a quando non si cambia<br> posizione del cursore<br></p>
    <h2 id="titoletto3" class="stile">PAGINA CERCA NOTE</h2>
    <img id="immagine3" src="img/image3.png">
    <p id="cerca">La pagina cerca note ti permette di trovare e scaricare le note fatte da altre persone.<br>
                  I punti da segnalare sono i seguenti:<br>
                  1] Hai la possibilita' di mettere i likes alle note che più ti piacciono<br>
                  2] Usa i filtri per muoverti più velocemente tra le varie note<br>

    </p>


</body>