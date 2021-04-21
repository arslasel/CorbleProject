<?php
session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
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
    <link rel="icon" type="image/png" href="">

</head>

<body>
    <ul class="sidenav" id="mobile-nav">
        <li class="usernameDisplay"><a id="username_display" href="#"></a></li>
        <li><a href="#">Leave</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Rules</a></li>
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
                    <li><a href="#">About</a></li>
                    <li><a href="#">Rules</a></li>
                </ul>
            </div>
        </nav>
    </div>

    <div id="drawContainer" class="content">
        <div class="row">
            <div id="drawBoardContainer" class="col s12 l8">
                <canvas id="drawBoard">
                </canvas>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary" id="submitBtn">
                            Submit
                        </button>
                        <button class="btn btn-default" id="clearBtn">
                            Clear
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div>Choose Color</div>
                        <div style="width:50px;height:50px;background:green;" id="green" onclick="color(this)"></div>
                        <div style="width:50px;height:50px;background:blue;" id="blue" onclick="color(this)"></div>
                        <div style="width:50px;height:50px;background:red;" id="red" onclick="color(this)"></div>
                        <div style="width:50px;height:50px;background:yellow;" id="yellow" onclick="color(this)"></div>
                        <div style="width:50px;height:50px;background:orange;" id="orange" onclick="color(this)"></div>
                        <div style="width:50px;height:50px;background:black;" id="black" onclick="color(this)"></div>
                        <div>Eraser</div>
                        <div style="width:50px;height:50px;background:white;border:2px solid;" id="white" onclick="color(this)"></div>
                    </div>
                </div>
            </div>
            <div class="col s12 l2">M</div>
            <div class="col s12 l2">L</div>
        </div>
    </div>

    <div hidden="" id="voteContainer" class="content">
        vote
    </div>

    <div hidden="" id="endContainer" class="content">
        <!-- TODO selim  -->
    </div>

    <?php
    ini_set('display_errors', 1);
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