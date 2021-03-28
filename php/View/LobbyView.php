<html>
    <head>
        <title>Lobby</title>
    </head>
    <body>
        <h1 id="title">Hallo&nbsp;</h1>
        <form name="helloWorld" action="#" method="POST">
            <input type="text" name="nameText" required />
            <input type="submit" name="submit" />
        </form>
        <?php
            ini_set('display_errors', 1);
            include("../Controller/LobbyController.php");
            $lobbyController = new LobbyController();
            
            if (isset($_POST['submit'])){
                $returnOfHW = $lobbyController->helloWorld($_POST['nameText']);
                
                echo "<script> 
               document.getElementById('title').innerHTML += 'Hallo&nbsp;" .$returnOfHW ."'; 
              </script>";
            };
        ?>
    </body>
</html>