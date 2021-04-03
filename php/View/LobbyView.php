<html>

<head>
    <title>Lobby</title>
</head>

<body>
    <div id="content">
        <form name="login" action="#" method="POST">
            <input type="text" name="login_username" required />
            <input type="submit" name="login_submit" />
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
    ?>
</body>

</html>