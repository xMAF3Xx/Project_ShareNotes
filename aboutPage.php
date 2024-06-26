<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="aboutPage.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu a Tendina</title>
    <style>
        .blocco,
        .blocco2,
        .blocco3,
        .blocco4 {
            width: 70%;
            max-width: 450px;
            height: 430px;
            border: 2px solid #000;
            text-align: left;
            margin: 100px 0;
            padding: 50px;
            border-radius: 10px;
            background-color: gainsboro;
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.5s ease-out;
            animation: entrataBlocchi 0.5s ease-in-out;
            margin-left: 0px;
}


.blocco.visible,
.blocco2.visible,
.blocco3.visible,
.blocco4.visible {
    max-height: 500px;
    width: 450px;
    margin-top: 20px; 
}
    </style>
    <script>
    function toggleBlocco(blocco, centroId) {
        blocco.classList.toggle("visible");
        var centroElement = document.getElementById(centroId);

        if (blocco.classList.contains("visible")) {
            centroElement.style.display = "none";
        } else {
            centroElement.style.display = "block";
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        var blocco1 = document.querySelector(".blocco");
        var blocco2 = document.querySelector(".blocco2");
        var blocco3 = document.querySelector(".blocco3");
        var blocco4 = document.querySelector(".blocco4");

        blocco1.addEventListener("click", function () {
            toggleBlocco(blocco1, "centro");
        });

        blocco2.addEventListener("click", function () {
            toggleBlocco(blocco2, "centro2");
        });

        blocco3.addEventListener("click", function () {
            toggleBlocco(blocco3, "centro3");
        });

        blocco4.addEventListener("click", function () {
            toggleBlocco(blocco4, "centro4");
        });
    });
</script>
<style>
@media(max-width:1200px)
{
    .blocco.visible,
.blocco2.visible,
.blocco3.visible,
.blocco4.visible {
    max-height: 500px;
    width: 450px;
    margin-top: 20px; 
}
    #Share
    {
        margin-left: -25px;
    }
    
   .bottone
{
    margin-top: 40px;
    width: 190px;
    height: 40px;
    margin-left: 16px;
}
   
    #bottone1 {
   
        font-size: 14px;
        margin-top: 20px; 
        margin-left: -329.9px;
        margin-bottom: 30px;
    }

    
    #bottone2 {
       
        margin-top: -45px; /* Adjust this value to move the button higher */
        font-size: 14px;
        background: none;
        border: none;
    }
    
    #bottone3 {
        
        font-size: 14px;
        margin-top: -45px; /* Adjust this value to move the button higher */
        background: none;
        border: none;
    }
    #pallini
{
    width: 60px;
    height: 60px;
    position: fixed;
    border-radius: 50%;
    margin-left: -250px;
    margin-top: -28px;
    background-color: pink;

}
#pallini2
{
    width: 60px;
    height: 60px;
    position: fixed;
    border-radius: 50%;
    margin-left: 465px;
    margin-top: 198px;
    background-color: green;
    
}
#pallini3
{
    width: 60px;
    height: 60px;
    position: fixed;
    border-radius: 50%;
    margin-left: 385px;
    margin-top: 338px;
    background-color: red;
  
}
#pallini4
{
    width: 60px;
    height: 60px;
    position: fixed;
    border-radius: 50%;
    margin-left: 305px;
    margin-top: 291px;
    background-color: purple;
    
}
#pallini5
{
    width: 60px;
    height: 60px;
    position: fixed;
    border-radius: 50%;
    margin-left: 465px;
    margin-top: 291px;
    background-color: green;

}
#pallini6
{
    width: 60px;
    height: 60px;
    position: fixed;
    border-radius: 50%;
    margin-left: 385px;
    margin-top: 244px;
    background-color: orange;
   
}
#pallini7
{
    width: 60px;
    height: 60px;
    position: fixed;
    border-radius: 50%;
    margin-left: 465px;
    margin-top: 391px;
    background-color: pink;
   
}
#linea {
    margin-top: -25px;
    border: 1px solid black;
}
#pallini8
{
    width: 60px;
    height: 60px;
    position: fixed;
    border-radius: 50%;
    margin-left: -435px;
    margin-top: 391px;
    background-color: lightblue;
    
}
.blocco,
        .blocco2,
        .blocco3,
        .blocco4 {
            width: 70%;
            max-width: 200px;
            height: 370px;
            border: 2px solid #000;
            text-align: left;
            margin: 100px 30px;
            padding: 50px;
            border-radius: 10px;
            background-color: gainsboro;
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.5s ease-out;
            animation: entrataBlocchi 0.5s ease-in-out;
            margin-left: 55px;
}
#imm2
{
    position: absolute;
    margin-left:-15px;
}
.come
{
    width: 90px;
    height: 90px;
    margin-left: 50px;
    margin-top: -20px;

}

.prova
{
    margin-top: -60px;
    margin-left: -30px;
    
}
#imm
{
    margin-left: -10px;
    margin-top: 10px;
    
    width: 90px;
    height: 110px;
}
.navbar {
    background-color: white;
    justify-content: center;
    align-items: center;
    justify-content: space-between;
    position: fixed; 
    top: 0;
    left: 0;
    right: 0;
    height: 170px;
    width: 100%;
    margin: 0;
    padding: 0;
    display:flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 10px;
}
body
{
    background-image: url('img/sfondo.png');
    background-size: contain;
    height: 100vh;
    width: 100vh;
}
}
@media(max-width:1800px)
{

    #pallini
    {
        width: 100px;
        height: 100px;
        position: fixed;
        border-radius: 50%;
        margin-left: -450px;
        margin-top: -28px;
        background-color: pink;
    
    }
    #pallini2
    {
        width: 100px;
        height: 100px;
        position: fixed;
        border-radius: 50%;
        margin-left: 655px;
        margin-top: 138px;
        background-color: green;
        
    }
    #pallini3
    {
        width: 100px;
        height: 100px;
        position: fixed;
        border-radius: 50%;
        margin-left: 525px;
        margin-top: 338px;
        background-color: red;
      
    }
    #pallini4
    {
        width: 100px;
        height: 100px;
        position: fixed;
        border-radius: 50%;
        margin-left: 375px;
        margin-top: 291px;
        background-color: purple;
        
    }
    #pallini5
    {
        width: 100px;
        height: 100px;
        position: fixed;
        border-radius: 50%;
        margin-left: 655px;
        margin-top: 291px;
        background-color: green;
    
    }
    #pallini6
    {
        width: 100px;
        height: 100px;
        position: fixed;
        border-radius: 50%;
        margin-left: 525px;
        margin-top: 224px;
        background-color: orange;
       
    }
    #pallini7
    {
        width: 100px;
        height: 100px;
        position: fixed;
        border-radius: 50%;
        margin-left: 655px;
        margin-top: 431px;
        background-color: pink;
       
    }
    body
    {
        background-image: url('img/sfondo.png');
        height: 100vh;
        width: 100vw;
        background-size: contain;
        background-position: center;
    }
    #Share
    {
        margin-left: 90px;
    }
}

</style>
<link rel="icon" href="img\logo_favicon.ico" type="image/x-icon">
</head>
<body class="body">
    <div class="container">

<div>
    <nav class="navbar" class="navbar navbar-dark bg-light fixed-top">
        <div class="container-fluid">
        <a href="index.php"><img id="imm" src="img/im.png"></a>
                        <a href="Functionalities.php"><button id="bottone1" class="bottoni"  type="button">Funzionalita'</button></a>
                        <a href="index.php"><button id="bottone2" class="bottoni"   type="button">Home</button></a>
                        <a href="cercaNote.php"><button id="bottone3" class="bottoni" type="button">Cerca Note</button></a>
                        <button id="openPopupBtn" class="bottoni" class="prova" type="button"><img id="imm2" class="prova" src="img/profile.png"></button>
                        
                        <?php
                            session_start();
                            include ('utils.inc.php');
                            if (!isLogged()) {
                                echo '<a href="profile_page.php"><img id="imm2" src="img/user.png"></a>';
                            }else {
                                //style="background-image: url(\'img/loggedIn.png\');"
                                echo '<a href="index.php"><img id="imm2" src="img/user.png"></a>';
                            }
                        ?>
          <hr id="linea">
            </div>
          </div>
        </div>
    </nav>
    
<div>
<hr>
<img id="cerchio" src="img/cerchio.png">
<img id="cerchio2" src="img/cerchio.png">
<img src="img/about.png" class="titolo">
<div  id="pallini" ></div>
<div  id="pallini2" ></div>
<div  id="pallini3"  ></div>
<div  id="pallini4"  ></div>
<div  id="pallini5" ></div>
<div  id="pallini6"  ></div>
<div  id="pallini7"  ></div>
<div  id="pallini8"  ></div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ciao = document.getElementById("pallini");
        var ciao2 = document.getElementById("pallini2");
        var ciao3 = document.getElementById("pallini3");
        var ciao4 = document.getElementById("pallini4");
        var ciao5 = document.getElementById("pallini5");
        var ciao6 = document.getElementById("pallini6");
        var ciao7 = document.getElementById("pallini7");
        var ciao8 = document.getElementById("pallini8");
        function ok(){
            moveElementRandomly(ciao);
            moveElementRandomly(ciao2);
            moveElementRandomly(ciao3);
            moveElementRandomly(ciao4);
            moveElementRandomly(ciao5);
            moveElementRandomly(ciao6);
            moveElementRandomly(ciao7);
            moveElementRandomly(ciao8);
                            
        }
        
        var cont = 0; // Contatore per i pallini scoppiati
        function cambiaColoreContinuo() {
            var colori = ["red", "green", "blue", "yellow", "orange"];
            var indiceColore = 0;
        
            const intervalloColore = setInterval(function() {
                ciao.style.backgroundColor = colori[indiceColore];
                indiceColore = (indiceColore + 1) % colori.length;
            }, 500);
        
            setTimeout(function() {
                clearInterval(intervalloColore);
                ciao.style.backgroundColor = "pink";
                ciao.addEventListener("click", function() {
                    if (ciao.style.backgroundColor === "pink") {
                        ciao.style.animation = "explode 0.5s forwards";
                        // Rimuovi l'event listener dopo l'esplosione
                        ciao.removeEventListener("click", arguments.callee);
                        
                        ok();
                    }
                });
            }, 5000);
        }
        
        setTimeout(cambiaColoreContinuo, 1000);
        
        
        // Funzione per spostare un elemento in modo casuale sullo schermo e farlo rimbalzare
        function moveElementRandomly(element) {
            var windowWidth = 1920; // Larghezza dello schermo
            var windowHeight = 1080; // Altezza dello schermo
            var speedX = 1; // Velocità sull'asse X
            var speedY = 1; // Velocità sull'asse Y
            var posX = Math.random() * (windowWidth - 50); // Posizione iniziale sull'asse X
            var posY = Math.random() * (windowHeight - 50); // Posizione iniziale sull'asse Y
        
            function move() {
                posX += speedX;
                posY += speedY;
        
                // Controllo dei limiti dello schermo e rimbalzo
                if (posX <= 0 || posX + element.offsetWidth >= windowWidth) {
                    speedX *= -1; // Inverti la direzione sull'asse X
                }
                if (posY <= 0 || posY + element.offsetHeight >= windowHeight) {
                    speedY *= -1; // Inverti la direzione sull'asse Y
                }
        
                // Limita le posizioni all'interno dell'area specificata
                posX = Math.min(Math.max(posX, 0), windowWidth - element.offsetWidth);
                posY = Math.min(Math.max(posY, 0), windowHeight - element.offsetHeight);
                
                // Aggiorna la posizione del pallino
                element.style.left = posX + 'px';
                element.style.top = posY + 'px';
        
                // Richiama la funzione move() al prossimo ciclo di rendering
                requestAnimationFrame(move);
            }
        
            // Avvia il movimento
            move();
        
            // Gestisci l'esplosione al clic
            element.addEventListener("click", function() {
                element.style.animation = "explode 0.5s forwards";
                cont += 1; // Incrementa il contatore dei pallini scoppiati
                cambiaSfondoSeNecessario(); // Controlla se è necessario cambiare lo sfondo
                element.removeEventListener("click", arguments.callee); // Rimuovi l'event listener clic dopo lo scoppio
            });
        }
        
        // Funzione per controllare e cambiare lo sfondo se tutti i pallini sono stati scoppiati
        function cambiaSfondoSeNecessario() {
            var numeroPallini = 8; // Numero totale di pallini
            if (cont === numeroPallini-1) {
                document.body.style.backgroundImage = "url('img/sfondo.png')";
            

            }
        }
});



    
</script>


</div>
</div>
<div> 

</div>
<div>
    <div class="tutto">
    <div class="blocco">
        <div id="centro"><b>CHI SIAMO?</b></div>
       <b> <p class="titoletto">CHI SIAMO?</p></b><br>
        <b><p class="testino">Siamo quattro ragazzi che hanno deciso di realizzare un sito per prendere appunti per milgiorare le nostre capacità e sotto consiglio delle nostre prof di informatica</p></b>
        <div class="tenor-gif-embed" data-postid="15201219" data-share-method="host" data-aspect-ratio="1" data-width="100%"><img src="img/ciao.gif" class="come" alt="gif senza sfondo">
    </div>
    </div>
    <div class="blocco2">
        <div id="centro2"><b>COME FUNZIONA IL SITO?</div>
        <b> <p class="titoletto2">COME FUNZIONA IL SITO?</p></b><br>
        <p class="testino2">Il sito permette non solo di prendere appunti, ma anche di cercare appunti fatti da qualcun altro e scaricarli (e' un sito fatto dagli studenti per gli studenti)</p>

</div>
</div>
   <div>
</div>
<div class="tutto2">
    <div class="blocco3">
        <div id="centro3"><b>CHE SCUOLA FREQUENTIAMO</b></div>
        <b> <p class="titoletto3">CHE SCUOLA FREQUENTIAMO</p></b><br>
         <p class="testino3">Tutti e quattro frequentiamo l'istituto tecnico industriale Pino Hensemberger di Monza</p>
         <button type="button" class="bottone" onclick="apriLink()">SITO SCUOLA</button>

<script>
    function apriLink() {
        var url = "https://hensemberger.edu.it";
        window.open(url, "_blank");
    }
</script>
         

</div>
<div class="blocco4">
    <div id="centro4"><b>COME CONTATTARCI</b></div>
    <b> <p class="titoletto4">COME CONTATTARCI</p></b><br>
     <p class="testino4">Di seguito la mail del sito:</p>
     <a href="sharenotes.workspace@gmail.com" id="Share">SHARENOTES</a>
   </div>
</div>
</body>
</html>
