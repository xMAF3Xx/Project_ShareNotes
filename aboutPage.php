<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/CSS" href="aboutPage.css">
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
            margin-left: 50px;
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
</head> 
<body class="body">
        <div class="container">
            <div>
                <nav class="navbar" class="navbar navbar-dark bg-light fixed-top">
                    <div class="container-fluid">
                        <a href="index.php"><img id="imm" src="img/im.png"></a>
                        <a href="Functionalities.php"><button id="bottone1" class="bottoni"  type="button">FUNZIONALITA'</button></a>
                        <a href="index.php"><button id="bottone2" class="bottoni"   type="button">HOME</button></a>
                        <a href="cercaNote.php"><button id="bottone3" class="bottoni" type="button">CERCA NOTE</button></a>
                        <!--<button id="openPopupBtn" class="bottoni"  type="button"><img id="imm2" src="img/profile.png"></button>-->
                        <?php
                            session_start();
                            include ('utils.inc.php');
                            if (isLogged()) {
                                echo '<a href="profile_page.php"><img id="imm2" src="img/user.png"></a>';
                            }else {
                                //style="background-image: url(\'img/loggedIn.png\');"
                                echo '<a href="index.php"><img id="imm2" src="img/user.png"></a>';
                            }
                        ?>
                    </div>
            </div>
        </div>
        </nav>
        <hr id="linea">
        <div class="titoloOne" style="margin-left: 40px">
            <img id="cerchio" src="img/cerchio.png">
            <img id="cerchio2" src="img/cerchio.png">
            <img src="img/about.png" class="titolo">
        </div>
        <div>
            <div class="tutto">
                <div class="blocco">
                    <div id="centro"><b>CHI SIAMO?</b></div>
                    <b> <p class="titoletto">CHI SIAMO?</p></b><br>
                    <p class="testino">Siamo quattro ragazzi che hanno deciso di realizzare un sito per prendere appunti per partecipare ad un concorso di Informatica (abbiamo tutti sedici anni)</p>
                    <div class="tenor-gif-embed" data-postid="15201219" data-share-method="host" data-aspect-ratio="1" data-width="100%"><img src="img/ciao.gif" class="come" alt="gif senza sfondo"></div>
                </div>
                <div class="blocco2">
                    <div id="centro2"><b>COME FUNZIONA IL SITO?</div>
                        <b> <p class="titoletto2">COME FUNZIONA IL SITO?</p></b><br>
                        <p class="testino2">Il sito permette non solo di prendere appunti, ma anche di cercare appunti fatti da qualcun altro e scaricarli (e' un sito fatto dagli studenti per gli studenti e in questo modo favorisce un aiuto reciproco)</p>
                </div>
            </div>
            <div class="tutto2">
                <div class="blocco3">
                    <div id="centro3"><b>CHE SCUOLA FREQUENTIAMO?</b></div>
                    <b> <p class="titoletto3">CHE SCUOLA FREQUENTIAMO?</p></b><br>
                    <p class="testino3">Tutti e quattro frequentiamo l'ITIS Pino Hensemberger di Monza</p>
                    <button type="button" class="bottone" onclick="apriLink()">SITO SCUOLA</button>
                    <script>
                        function apriLink() {
                            var url = "https://hensemberger.edu.it";
                            window.open(url, "_blank");
                        }
                    </script>
                </div>
                <div class="blocco4">
                    <div id="centro4"><b>COME CONTATTARE IN CASO DI BUG?</b></div>
                    <b> <p class="titoletto4">COME CONTATTARE IN CASO DI BUG?</p></b><br>
                    <p class="testino4">Di seguito sono presenti le nostre mail:</p>
                    <ul class="lista">
                        <li><a href="mailto: f981953@gmail.com">FEDERICO</a></li>
                        <li><a href="mailto: matteograncan@gmail.com">MATTEO</a></li>
                        <li><a href="mailto: ossologabriele@gmail.com">GABRIELE</a></li>
                        <li><a href="mailto: fornazzzzzz@gmail.com" >MATTIA</a></li>
                    </ul>
                </div>
            </div>
        </div>
</body>
</html>