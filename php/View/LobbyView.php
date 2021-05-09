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
    <title>Lobby</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Butterfly+Kids%7CRoboto" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="../../js/init.js"></script>
    <link rel="icon" type="image/png" href="">

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
        <div class="modal-content">
            <div class="modal-header">
                <h2>Modal Header</h2>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>


    <div hidden>
        <form name="lobby_overview_refresh" action="#" method="POST">
            <input id="lobby_overview_refresh" type="submit" name="lobby_overview_refresh_submit" />
        </form>
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

    <div hidden="" id="select_name" class="content">
        <div class="row">
            <h2 class="WelcomeText">Welcome To Corble</h2>
        </div>
        <div class="row">
            <div class="col s0 l3"></div>
            <div class="col s12 l6">
                <h4>Join Lobby</h4>
                <form name="login" action="#" method="POST" autocomplete="off">
                    <div class="row">
                        <div class="col s12">
                            <input id="username" type="text" name="login_username" placeholder="Choose Username" required />
                            <label class="active" for="username">Username</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <button class="btn waves-effect waves-light red confirmNameButton" type="submit" type="submit" value="Confirm" name="login_submit">Submit
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col s0 l3"></div>
        </div>
    </div>
    <div hidden="" id="lobby_configurator" class="content">
        <div class="row">
            <div id="joinLobbyModal" class="modal">
                <div class="modal-content">
                    <h4>Join Lobby</h4>
                    <form name="join" action="#" method="POST">
                        <input type="text" name="join_joincode" required />
                        <input hidden id="joinLobbySubmit" type="submit" name="join_submit" />
                    </form>
                </div>
                <div class="modal-footer">
                    <a onclick="document.getElementById('joinLobbySubmit').click()" href="#!" class="modal-close waves-effect waves-green btn-flat">Join</a>
                </div>
            </div>

            <div id="createLobbyModal" class="modal">
                <div class="modal-content">
                    <h4>Create Lobby</h4>
                    <form name="lobby_config" action="#" method="POST">
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
                                    <select name="lobby_config_maxplayer" required>
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
                                <input hidden id="createLobbySubmit" type="submit" name="lobby_config__submit" />
                            </div>
                        </div>
                    </form>
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
                                    <div id="lobby_overview_players"></div>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="col s0 l2"></div>
        </div>
    </div>
    <?php
    ini_set('display_errors', 1);
    include_once("../Controller/LobbyController.php");
    $lobbyController = new LobbyController();

    if (isset($_POST['join_submit'])) {
        $lobbyController->joinLobby($_POST['join_joincode']);
    }

    if (isset($_POST['login_submit'])) {
        $returnOfHW = $lobbyController->login($_POST['login_username']);
        if ($returnOfHW == false) {
            echo "<script> alert('username taken') </script>";
        }
    };

    if (isset($_POST['lobby_config__submit'])) {
        $lobbyController->createLobby($_POST['lobby_config_votetime'], $_POST['lobby_config_drawtime'], $_POST['lobby_config_starttime'], $_POST['lobby_config_maxplayer'], $_POST['lobby_config_wordpool']);
    };

    if (!isset($_SESSION["lobby_lobbyINDX"])) {
        if (!isset($_SESSION["lobby_username"])) {
            echo "<script>document.getElementById('select_name').removeAttribute('hidden'); </script>";
        } else {
            echo "<script>document.getElementById('select_name').setAttribute(hidden', ''); </script>";
            echo "<script>document.getElementById('lobby_configurator').removeAttribute('hidden'); </script>";

            $wordpools = $lobbyController->getWordPools();

            foreach ($wordpools as $wordpool) {
                echo "<script>
                    var select = document.getElementById('lobby_config_wordpool');
                    var opt = document.createElement('option');
                    opt.value = '" . $wordpool->getIndx() . "';
                    opt.innerHTML = '" . $wordpool->getName() . "';
                    select.appendChild(opt);
                </script>";
            }
        }
    } else {
        echo "<script>document.getElementById('select_name').setAttribute(hidden', ''); </script>";
        echo "<script>document.getElementById('lobby_configurator').setAttribute(hidden', ''); </script>";
        echo "<script>document.getElementById('lobby_overview').removeAttribute('hidden'); </script>";



        echo "
        <script>
            window.setInterval(()=>{
                loadLobbyData();
            },1000);

            function loadLobbyData(){
                var joincode = ". $_SESSION['lobby_joincode'].";
                $.ajax({
                    type: 'post',
                    url: '../Controller/LobbyViewAjaxUpdate.php',
                    data: {
                        joincode:joincode,
                    },
                    dataType: 'JSON',
                    success:function(response){
                        document.getElementById('lobby_overview_state').innerHTML = response.state;
                        document.getElementById('lobby_overview_votetime').innerHTML = response.votetime;
                        document.getElementById('lobby_overview_starttime').innerHTML = response.starttime;
                        document.getElementById('lobby_overview_drawtime').innerHTML = response.drawtime;
                        document.getElementById('lobby_overview_maxplayer').innerHTML = response.maxplayer;
                        document.getElementById('lobby_overview_joincode').innerHTML = response.joincode;
                    }
                });
            }
        </script>";








        // echo "<script>
        //     window.setInterval(()=>{
        //         document.getElementById('lobby_overview_refresh').click();
        //         console.log('fetching data');
        //     },1000);
        // </script>";

        if (isset($_POST['lobby_overview_refresh_submit'])) {
            $model = $lobbyController->readLobbyDataFromDB();
            echo "<script>document.getElementById('lobby_overview_state').innerHTML = '" . $model->getState() . "'; </script>";
            echo "<script>document.getElementById('lobby_overview_votetime').innerHTML = '" . $model->getVoteTime() . "'; </script>";
            echo "<script>document.getElementById('lobby_overview_starttime').innerHTML = '" . $model->getStartTime() . "'; </script>";
            echo "<script>document.getElementById('lobby_overview_drawtime').innerHTML = '" . $model->getDrawTime() . "'; </script>";
            echo "<script>document.getElementById('lobby_overview_maxplayer').innerHTML = '" . $model->getMaxPlayers() . "'; </script>";
            echo "<script>document.getElementById('lobby_overview_joincode').innerHTML = '" . $model->getJoinCode() . "'; </script>";

            echo "<script>
                var div = document.getElementById('lobby_overview_players');
                var ul = document.createElement('ul');
                ul.id = 'lobby_overview_players_list';
                div.innerHTML = '';
                div.appendChild(ul);
            </script>";

            //TODO add word pools to lobby overview
            foreach ($model->getPlayers() as $player) {
                echo "<script>
                var ul = document.getElementById('lobby_overview_players_list');
                var li = document.createElement('li');
                li.textContent = '" . $player->getName() . "';
                ul.appendChild(li);
            </script>";
            }
        }
    }

    //username_display
    if (isset($_SESSION["lobby_username"])) {
        echo "<script>
            var usernameElement = document.getElementById('username_display');
            usernameElement.innerHTML = '" . $_SESSION["lobby_username"] . "';
        </script>";
    }


    echo "<script>M.AutoInit()</script>"; // init all materiallize components
    ?>
</body>

</html>