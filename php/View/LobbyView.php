<html>

<head>
    <title>Lobby</title>

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</head>

<body>
    <div hidden="" id="select_name" class="content">
        <form name="login" action="#" method="POST">
            <input type="text" name="login_username" required />
            <input type="submit" name="login_submit" />
        </form>
    </div>
    <div hidden="" id="lobby_configurator" class="content">
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
                        <select name="lobby_config_wordpool" multiple>
                            <option value="" disabled selected>Choose your option</option>
                            <option value="1">Option 1</option>
                            <option value="2">Option 2</option>
                            <option value="3">Option 3</option>
                        </select>
                        <label>Word Pool</label>
                    </div>
                </div>
                <div class="col s12">
                    <div class="input-field col s12">
                        <select>
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
                    <input type="submit" name="lobby_config__submit" />
                </div>
            </div>
        </form>
    </div>
    <?php
    ini_set('display_errors', 1);
    include("../Controller/LobbyController.php");
    $lobbyController = new LobbyController();

    if (isset($_POST['login_submit'])) {
        $returnOfHW = $lobbyController->login($_POST['login_username']);
        if ($returnOfHW == false) {
            echo "<script> 
               alert('false') 
              </script>";
        } else {
            echo "<script> 
               alert('true') 
              </script>";
        }
    };

    if (!isset($_SESSION["lobby_username"])) {
    } else {
    }


    echo "<script>M.AutoInit()</script>"; // init all materiallize components
    ?>
</body>

</html>