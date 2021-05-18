<?php
session_start();
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
    <title>Lobby</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Butterfly+Kids%7CRoboto" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="../../js/init.js"></script>
    <script src="../../js/lobbyView.js"></script>
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

    <!----------------------- SideBar ---------------------------------------->
    <ul class="sidenav" id="mobile-nav">
        <li class="usernameDisplay"><a id="username_displaym" href="#">&nbsp;</a></li>
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
                    <li class="usernameDisplay"><a id="username_displayd" href="#">&nbsp;</a></li>
                    <li><a class="modal-trigger" href="#aboutCorble">About</a></li>
                    <li><a class="modal-trigger" href="#rulesCorble">Rules</a></li>
                </ul>
            </div>
        </nav>
    </div>

    <!----------------------- Join Lobby ------------------------------------->
    <div hidden="" id="select_name" class="content">
        <div class="row">
            <h2 class="WelcomeText">Welcome To Corble</h2>
        </div>
        <div class="row">
            <div class="col s0 l3"></div>
            <div class="col s12 l6">
                <h4>Sign in with a new User</h4>
                <div class="row">
                    <div class="col s12">
                        <input id="username" type="text" name="login_username" placeholder="Choose Username" required />
                        <label class="active" for="username">Username</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <button class="btn waves-effect waves-light red confirmNameButton" value="Confirm" onclick="login()">Submit
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col s0 l3"></div>
        </div>
    </div>

    <!----------------------- Configure Lobby -------------------------------->
    <div hidden="" id="lobby_configurator" class="content">
        <div class="row">
            <div id="joinLobbyModal" class="modal">
                <div class="modal-content">
                    <h4>Join Lobby</h4>
                    <form name="join" action="#" method="POST">
                        <input id="lobby_joincode_field" type="text" name="join_joincode" required />
                    </form>
                </div>
                <div class="modal-footer">
                    <a onclick="join_lobby()" href="#!" class="modal-close waves-effect waves-green btn-flat">Join</a>
                </div>
            </div>

            <div id="createLobbyModal" class="modal">
                <div class="modal-content">
                    <h4>Create Lobby</h4>
                    <div class="row">
                        <div class="col s12">
                            <input id="lobby_config_drawtime" type="number" name="lobby_config_drawtime" required />
                            <label for="lobby_config_drawtime">Draw Time</label>
                        </div>
                        <div class="col s12">
                            <input id="lobby_config_votetime" type="number" name="lobby_config_votetime" required />
                            <label for="lobby_config_votetime">Vote Time</label>
                        </div>
                        <div class="col s12">
                            <input id="lobby_config_starttime" type="number" name="lobby_config_starttime" required />
                            <label for="lobby_config_starttime">Start Time</label>
                        </div>
                        <div class="col s12">
                            <div class="input-field col s12">
                                <select id="lobby_config_wordpool" name="lobby_config_wordpool[]" multiple required>
                                    <option value="" disabled selected>Choose your option</option>
                                </select>
                                <label>Word Pool</label>
                            </div>
                        </div>
                        <div class="col s12">
                            <div class="input-field col s12">
                                <select id="lobby_config_maxplayer" name="lobby_config_maxplayer" required>
                                    <option value="" disabled selected>Choose your option</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                </select>
                                <label>Lobby Size</label>
                            </div>
                        </div>
                        <div class="col s12">
                            <input hidden id="createLobbySubmit" onclick="createLobby()" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a onclick="document.getElementById('createLobbySubmit').click()" href="#!" class="modal-close waves-effect waves-green btn-flat">Create</a>
                </div>
            </div>

            <div class="row lobbyControls">
                <div class="col s0 l3"></div>
                <div class="col s12 l6">
                    <div class="row">
                        <div class="col s6">
                            <h5>Join Lobby</h5>
                        </div>
                        <div class="col s6">
                            <a class="waves-effect waves-light btn red modal-trigger" href="#joinLobbyModal">Join Lobby</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            <h5>Create Lobby</h5>
                        </div>
                        <div class="col s6">
                            <a class="waves-effect waves-light btn red modal-trigger" href="#createLobbyModal">Create Lobby</a>
                        </div>
                    </div>
                </div>
                <div class="col s0 l3"></div>
            </div>
        </div>
    </div>

    <!----------------------- Lobby Overview --------------------------------->
    <div hidden="" id="lobby_overview" class="content">

        <h4 class="LobbyTitle">Lobby Overview</h4>
        <div class="row">
            <div class="col s0 l2"></div>
            <div class="col s12 l8">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Value</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td><span>Lobby State :</span></td>
                            <td><span id="lobby_overview_state"></span></td>
                        </tr>
                        <tr>
                            <td><span>Vote Time :</span></td>
                            <td><span id="lobby_overview_votetime"></span></td>
                        </tr>
                        <tr>
                            <td><span>Start Time :</span></td>
                            <td><span id="lobby_overview_starttime"></span></td>
                        </tr>
                        <tr>
                            <td><span>Draw Time :</span></td>
                            <td><span id="lobby_overview_drawtime"></span></td>
                        </tr>
                        <tr>
                            <td><span>Max Players :</span></td>
                            <td><span id="lobby_overview_maxplayer"></span></td>
                        </tr>
                        <tr>
                            <td><span>Join Code :</span></td>
                            <td><span id="lobby_overview_joincode"></span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="row TableDiv">
                                    <span>Players :</span>
                                </div>
                            </td>
                            <td>
                                <div class="row TableDiv">
                                    <div id="lobby_overview_players">&nbsp;</div>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="col s0 l2"></div>
        </div>
    </div>
</body>

</html>