<?php
session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <title>Corble</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Butterfly+Kids%7CRoboto" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="js/init.js"></script>

</head>

<body>

    <!--The Modal-->
    <div id="aboutCorble" class="modal">
        <!--Modal Content-->
        <div class="modal-content textPosition">
            <div class="modal-header textShadow">
                <h2>About Corble</h2>
            </div>
            <div>
                <p class="textformating">
                    Corble ist ein kreatives Zeichnugsspiel, bei dem 4 bis 8 Spieler
                    gegeneinander antreten. Das Ziel ist ein Bild zu malen, welche das
                    angezeigte Wort am besten darstellt.
                </p>
                <div class="textShadow">
                    <h4>Unsere Mission</h4>
                </div>
                <p class="textformating">
                    Spieler dürfen ihre kreative Seite zeigen und diese froide mit allen
                    teilen.
                </p>
                <div class="textShadow">
                    <h4>Background</h4>
                </div>
                <p class="textformating">
                    Corble wurde im Auftrag von der ZHAW kreiert. Das Ziel dieses Projekt ist die
                    Grundkenntnisse von Software Entwicklung 1 zu vertiefen sowie Erkentnisse zu Projekt
                    Management zu sammeln.
                </p>
                <div class="textShadow">
                    <h4>Gründer</h4>
                </div>
                <ul class="textformating">
                    <li>Alguacil Alonso Dominiqu</li>
                    <li>Arslan Selim</li>
                    <li>Berner Roman</li>
                    <li>Ercihan Kaya</li>
                    <li>Pio Loco Gino</li>
                </ul>
                <div class="textShadow">
                    <h4>Dozent/in</h4>
                </div>
                <ul class="listeStyle textformating">
                    <li>Bachmann Matthias</li>
                    <li>Rudin Kirsten</li>
                </ul>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>


    <!--The Modal-->
    <div id="rulesCorble" class="modal">
        <!--Modal Content-->
        <div class="modal-content textPosition">
            <div class="modal-header textShadow">
                <h2>Corble Rules </h2>
            </div>
            <div class="textShadowLight">
                <h4>1. Anmelden und Starten</h4>
            </div>
            <p class="textformating">
                Bevor es losgeht muss du dich mit deinem Künstlernamen anmelden.
                Danach kannst du einem Spiel beitreten oder selber eines erstellen.
            </p>
            <div class="textShadowLight">
                <h4>2. Beitreten oder Erstellen</h4>
            </div>
            <h5>Join Lobby</h5>
            <ul class="textformating">
                <li>Trete einem Spiel bei, dafür gibst du den erhaltenen Code ein.</li>
            </ul>
            <h5>Create Lobby</h5>
            <ul class="textformating">
                <li>Erstelle ein Spiel nach deinen Regeln.</li>
            </ul>
            <div class="textShadowLight">
                <h4>3. Male das Wort</h4>
            </div>
            <p class="textformating">
                In einer vorgegebenen Zeit muss du das angezeigte Wort so genau wie möglich
                malen.
            </p>
            <ul class="textformating">
                <li>1. Verwende Farben</li>
                <li>2. Verwende Stiftgrössen</li>
                <li>3. Mit Clear wird alles gelöst</li>
                <li>4. Bestätige dein Kunstwerk mit Submit</li>
            </ul>
            <div class="textShadowLight">
                <h4>4. Bestimme das beste Bild</h4>
            </div>
            <p class="textformating">
                Die Qual der Wahl, wer hat das beste Bild kreiert? Nach jeder Malrunden muss du
                dich entscheiden, wer hat das beste Bild gezeichnet. Aber bedenke du hast nicht
                ewig Zeit.
            </p>
            <ul class="textformating">
                <li>1. Wähle dein Bild in der Minislideshow.</li>
                <li>2. Das gewählte Bild wird rot markiert und angezeigt.</li>
                <li>3. Ist die Zeit abgelaufen, wird das gewählte Bild genommen.</li>
            </ul>
            <div class="textShadowLight">
                <h4>5. Siegerehrung</h4>
            </div>
            <p class="textformating">
                Sind alle Runden gespielt, wird dir am schluss angezeigt wer das Spiel gewonnen hat.
            </p>
            <ul class="textformating">
                <li>Bestes Bild nach Stimmen</li>
                <li>Bestes Bild nach Algorithmus</li>
                <li>Schlechtestes Bild nach Algorithmus</li>
            </ul>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>




    <ul class="sidenav" id="mobile-nav">
        <li class="usernameDisplay"><a id="username_display" href="#"></a></li>
        <li><a href="#">Leave</a></li>
        <li><a class="modal-trigger" href="#aboutCorble">About</a></li>
        <li><a class="modal-trigger" href="#rulesCorble">Rules</a></li>
    </ul>
    <div class="navbar-fixed">
        <nav class="red" style="padding:0px 10px; position: fixed;">
            <div class="nav-wrapper">
                <a href="#" class="brand-logo logo">&nbsp;</a>

                <a href="#" class="sidenav-trigger" data-target="mobile-nav">
                    <i class="material-icons">menu</i>
                </a>

                <ul class="right hide-on-med-and-down ">
                    <li class="usernameDisplay"><a id="username_display" href="#"></a></li>
                    <li><a href="#">Leave</a></li>
                    <li><a class="modal-trigger" href="#aboutCorble">About</a></li>
                    <li><a class="modal-trigger" href="#rulesCorble">Rules</a></li>
                </ul>
            </div>
        </nav>
    </div>

    <div>
        <a href="php/View/LobbyView.php" target="_blank">Lobby View</a>
        <br>
        <a href="php/View/GameView.php" target="_blank">Game View</a>
    </div>
</body>

</html>