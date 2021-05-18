<?php
session_start();
include_once('../Controller/GameEndController.php');
?>

<!DOCTYPE HTML>
<html>

<!----------------------- Head ----------------------------------------------->
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
    <title>Game</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Butterfly+Kids%7CRoboto" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="../../js/init.js"></script>
    <script src="../../js/canvas.js"></script>
    <script src="../../js/gameView.js"></script>
    <link rel="icon" type="image/png" href="">

</head>

<body>
    <!----------------------- About Corble ----------------------------------->
    <div id="aboutCorble" class="modal">
        <div class="modal-content textPosition">
            <div class="modal-header textShadow">
                <h2>About Corble</h2>
            </div>
            <div>
                <p class="textformating">
                    Corble ist ein kreatives Zeichnungsspiel, bei dem 6 Spielern
                    gegeneinander antreten. Das Ziel ist es, ein Bild zu malen, welches das
                    angezeigte Wort so gut wie möglich darstellt.
                </p>
                <div class="textShadow">
                    <h4>Unsere Mission</h4>
                </div>
                <p class="textformating">
                    Spieler dürfen ihre kreative Seite zeigen und diese freude mit allen
                    teilen.
                </p>
                <div class="textShadow">
                    <h4>Background</h4>
                </div>
                <p class="textformating">
                    Corble wurde im Auftrag von der ZHAW kreiert. Das Ziel dieses Projektes ist, die
                    Grundkenntnisse von Software Entwicklung 1 zu vertiefen, sowie Erkentnisse in Projekt-
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

    <!----------------------- Rules of Corble -------------------------------->
    <div id="rulesCorble" class="modal">
        <div class="modal-content textPosition">
            <div class="modal-header textShadow">
                <h2>Corble Rules </h2>
            </div>
            <div class="textShadowLight">
                <h4>1. Anmelden und Starten</h4>
            </div>
            <p class="textformating">
                Bevor es losgeht muss du dich mit deinem Namen anmelden.
                Danach kannst du einem Spiel beitreten oder selber eines erstellen.
            </p>
            <div class="textShadowLight">
                <h4>2. Beitreten oder Erstellen</h4>
            </div>
            <h5>Join Lobby</h5>
            <ul class="textformating">
                <li>Trete einem Spiel bei. Dafür gibst du den erhaltenen Join-Code ein.</li>
            </ul>
            <h5>Create Lobby</h5>
            <ul class="textformating">
                <li>Erstelle ein Spiel nach deinen Regeln.</li>
            </ul>
            <div class="textShadowLight">
                <h4>3. Zeichne das Wort</h4>
            </div>
            <p class="textformating">
                In einer vorgegebenen Zeit, muss du das angezeigte Wort so genau wie möglich
                zeichnen.
            </p>
            <ul class="textformating">
                <li>1. Verwende Farben</li>
                <li>2. Verwende Stiftgrössen</li>
                <li>3. Mit Clear wird alles gelöst</li>
                <li>4. Bestätige dein Kunstwerk mit "Submit"</li>
            </ul>
            <div class="textShadowLight">
                <h4>4. Bestimme das beste Bild</h4>
            </div>
            <p class="textformating">
                Die Qual der Wahl: Wer hat das beste Bild kreiert? Nach jeder Runde musst du
                dich entscheiden, wer das beste Bild gezeichnet hat. Aber bedenke, du hast nicht
                ewig Zeit!
            </p>
            <ul class="textformating">
                <li>1. Wähle dein Bild in der Slideshow.</li>
                <li>2. Das gewählte Bild wird rot markiert und angezeigt.</li>
                <li>3. Ist die Zeit abgelaufen, wird das gewählte Bild als bestes Bild bewerted.</li>
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

    <!----------------------- Navigation -------------------------------------->
    <ul class="sidenav" id="mobile-nav">
        <li class="usernameDisplay"><a id="username_displaym" href="#"></a></li>
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
                    <li class="usernameDisplay"><a id="username_displayd" href="#"></a></li>
                    <li><a class="modal-trigger" href="#aboutCorble">About</a></li>
                    <li><a class="modal-trigger" href="#rulesCorble">Rules</a></li>
                </ul>
            </div>
        </nav>
    </div>

    <!----------------------- Draw Picture ----------------------------------->
    <div hidden id="drawContainer" class="content">
        <div class="row FullHeight NoMargin">
            <div id="drawBoardContainer" class="col s12 l10 NoPadding drawcols">
                <canvas id="drawBoard">
                </canvas>
                <div class="row NoMarginRow">
                    <div class="controllsPull">
                        <i class="material-icons medium">arrow_drop_down</i>
                    </div>
                </div>
            </div>
            <div class="col s12 l2 NoPadding drawcols">
                <div class="row NoMarginRow">
                    <div class="col s6 NoPadding">
                        <h6>Time Left :</h6>
                    </div>
                    <div class="col s6 NoPadding">
                        <h6 id="timeLeftToDraw"></h6>
                    </div>
                </div>
                <div class="row NoMarginRow">
                    <div class="col s6 NoPadding">
                        <h6>Word :</h6>
                    </div>
                    <div class="col s6 NoPadding">
                        <h6 id="wordToDraw"></h6>
                    </div>
                </div>
                <div class="row NoMarginRow">
                    <h6>Color</h6>
                </div>
                <div class="row NoMarginRow">
                    <div class="col s4">
                        <div class="corbleColor corbleGreen" id="green" onclick="select_color(this)">&nbsp;</div>
                    </div>
                    <div class="col s4">
                        <div class="corbleColor corbleBlue" id="blue" onclick="select_color(this)">&nbsp;</div>
                    </div>
                    <div class="col s4">
                        <div class="corbleColor corbleRed" id="red" onclick="select_color(this)">&nbsp;</div>
                    </div>
                </div>
                <div class="row NoMarginRow">
                    <div class="col s4">
                        <div class="corbleColor corbleYellow" id="yellow" onclick="select_color(this)">&nbsp;</div>
                    </div>
                    <div class="col s4">
                        <div class="corbleColor corbleOrange" id="orange" onclick="select_color(this)">&nbsp;</div>
                    </div>
                    <div class="col s4">
                        <div class="corbleColor corbleBlack" id="black" onclick="select_color(this)">&nbsp;</div>
                    </div>
                </div>
                <div class="row NoMarginRow">
                    <div class="col s4">
                        <div class="corbleColor corbleBrown" id="brown" onclick="select_color(this)">&nbsp;</div>
                    </div>
                    <div class="col s4">
                        <div class="corbleColor corbleGrey" id="grey" onclick="select_color(this)">&nbsp;</div>
                    </div>
                    <div class="col s4">
                        <div class="corbleColor corbleWhite" id="white" onclick="select_color(this)">&nbsp;</div>
                    </div>
                </div>
                <div class="row NoMarginRow">
                    <h6>Line Size</h6>
                </div>
                <div class="row NoMarginRow">
                    <div class="corbleColor corbleWhite" id="line_thickness_s" onclick="select_line_thickness(this)">S</div>
                </div>
                <div class="row NoMarginRow">
                    <div class="corbleColor corbleWhite" id="line_thickness_m" onclick="select_line_thickness(this)">M</div>
                </div>
                <div class="row NoMarginRow">
                    <div class="corbleColor corbleWhite" id="line_thickness_l" onclick="select_line_thickness(this)">L</div>
                </div>
                <div class="row NoMarginRow">
                    <div class="col s12">
                        <button id="clearBtn" class="btn waves-effect waves-light red">
                            Clear
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!----------------------- Vote Picture ----------------------------------->
    <div hidden id="voteContainer" class="content">
        <div class="row NoMarginRow">
            <div class="col s6 l2 NoPadding">
                <h6>Time Left to vote:</h6>
            </div>
            <div class="col s6 l10NoPadding">
                <h6 id="timeLeftToVote"></h6>
            </div>
        </div>
        <div class="row SizeContainerSlideShow NoMargin">
            <div id="slideshowContainer" class="col s12 l12 NoPadding drawcols">
                <div class="slideShowContainer">
                    <div class="mySlidesSlideShowSelected setPictureInCard">
                        <div class="card sizeOfPicture">
                            <div class="card-image">
                                <img id="previewImage">
                            </div>
                        </div>
                    </div>
                    <div id="img_mini_container" class="row miniSlideShow "></div>
                </div>
            </div>
        </div>
    </div>

    <!----------------------- GameEnd ---------------------------------------->  
    <div hidden id="endContainer" class="content">
        <div class="row">
            <h2 class="WelcomeText">Spiel Ende</h2>
            <h3 class="WelcomeText">Siegerehrung</h3>
        </div>
        <div class="row">
            <div class="col s12 l4">
                <h5 class="WelcomeText">Bestes Bild nach Stimmen</h5>
                <div class="card">
                    <div class="card-image">
                        <!--<img src="/img/Ubuntu.png">-->
                        <img id="get_img_WinnerVoted" onload="loadPictureWinnerVote();">
                        <span id="bestVotedPlayer" class="card-title sketchTitle" onload="loadPlayerNameOfBestVotedPicture();">
                        </span>
                    </div>
                </div>
            </div>
            <div class="col s12 l4">
                <h5 class="WelcomeText">Bestes Bild nach Algorithmus</h5>
                <div class="card">
                    <div class="card-image">
                        <!--<img src="/img/Ubuntu.png">-->
                        <img id="get_img_BestAlgoVote" onload="loadPictureBestAlgoVote();">
                        <span id="bestAlgoName" class="card-title sketchTitle" onload="loadPlayerNameOfBestAlgoPicture();">
                        </span>
                    </div>
                </div>
            </div>
            <div class="col s12 l4">
                <h5 class="WelcomeText">Schlechtestes Bild nach Algorithmus</h5>
                <div class="card">
                    <div class="card-image">
                        <!--<img src="/img/1542233.jpg">-->
                        <img id="get_img_worstAlgoVote" onload="loadPictureWorstAlgoVote();">
                        <span id="worstAlgoName" class="card-title sketchTitle" onload="loadPlayerNameOfWorstAlgoPicture();">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <h2 class="WelcomeText selectColorWinner">
                Der Gewinner ist:
                <span id="winnerMessage" onload="loadWinnerName();">
                </span>
            </h2>
        </div>
    </div>
</body>

</html>