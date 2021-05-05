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
    <script src="../../js/slideshow.js"></script>
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

    <div id="drawContainer" class="content" style="display: none;">
        <div class="row FullHeight NoMargin">
            <div id="drawBoardContainer" class="col s12 l8 NoPadding drawcols">
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
                        <h6>Time Left</h6>
                    </div>
                    <div class="col s6 NoPadding">
                        <h6>23sec</h6>
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
                    <div class="col s6">
                        <button id="submitBtn" class="btn waves-effect waves-light red" type="submit" type="submit" name="login_submit">
                            Submit
                        </button>
                    </div>
                    <div class="col s6">
                        <button id="clearBtn" class="btn waves-effect waves-light red" type="submit" type="submit" name="login_submit">
                            Clear
                        </button>
                    </div>
                </div>
            </div>
            <div class="col s12 l2 NoPadding drawcols">
                <div class="row NoMarginRow">
                    <h5>Leaderboard</h5>
                    <table>
                        <thead>
                            <tr>
                                <th>Score</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>6</td>
                                <td>Gino</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Selim</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Kaya</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Roman</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Dominique</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="voteContainer" class="content">
        <div class="row SizeContainerSlideShow NoMargin">
            <div id="slideshowContainer" class="col s12 l10 NoPadding drawcols">
                <div class="slideShowContainer">
                    <!-- Full-width images with number text -->
                    <div class="mySlidesSlideShowSelected setPictureInCard">
                        <div id="image1" hidden>
                            <div class="card sizeOfPicture">
                                <div class="card-image">
                                    <img src="/img/FIZZ.jpg">
                                    <div class="numbertextSlideShow">1 / 6</div>
                                </div>
                            </div>
                        </div>
                        <div id="image2" hidden>
                            <div class="card sizeOfPicture">
                                <div class="card-image">
                                    <img src="/img/Fiora.jpg">
                                    <div class="numbertextSlideShow">2 / 6</div>
                                </div>
                            </div>
                        </div>
                        <div id="image3" hidden>
                            <div class="card sizeOfPicture">
                                <div class="card-image">
                                    <img src="/img/Yorrick.jpg">
                                    <div class="numbertextSlideShow">3 / 6</div>
                                </div>
                            </div>
                        </div>
                        <div id="image4" hidden>
                            <div class="card sizeOfPicture">
                                <div class="card-image">
                                    <img src="/img/FIZZVOID.png">
                                    <div class="numbertextSlideShow">4 / 6</div>
                                </div>
                            </div>
                        </div>
                        <div id="image5" hidden>
                            <div class="card sizeOfPicture">
                                <div class="card-image">
                                    <img src="/img/1542233.jpg">
                                    <div class="numbertextSlideShow">5 / 6</div>
                                </div>
                            </div>
                        </div>
                        <div id="image6" hidden>
                            <div class="card sizeOfPicture">
                                <div class="card-image">
                                    <img src="/img/Wukong.jpg">
                                    <div class="numbertextSlideShow">6 / 6</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row miniSlideShow ">
                        <div class="col s2 l2">
                            <img id="imagePreview1" class="demoSlideShow cursorSlideShow pictureWidth " src="/img/FIZZ.jpg" onclick="selectSlide(this,1); selectPicture(1)" alt="Fizz">
                        </div>
                        <div class="col s2 l2">
                            <img id="imagePreview2" class="demoSlideShow cursorSlideShow pictureWidth " src="/img/Fiora.jpg" onclick="selectSlide(this,2); selectPicture(2)" alt="Fiora">
                        </div>
                        <div class="col s2 l2">
                            <img id="imagePreview3" class="demoSlideShow cursorSlideShow pictureWidth " src="/img/Yorrick.jpg" onclick="selectSlide(this,3); selectPicture(3)" alt="Yorrick">
                        </div>
                        <div class="col s2 l2">
                            <img id="imagePreview4" class="demoSlideShow cursorSlideShow pictureWidth " src="/img/FIZZVOID.png" onclick="selectSlide(this,4); selectPicture(4)" alt="VoidFizz">
                        </div>
                        <div class="col s2 l2">
                            <img id="imagePreview5" class="demoSlideShow cursorSlideShow pictureWidth" src="/img/1542233.jpg" onclick="selectSlide(this,5); selectPicture(5)" alt="TRÖMP">
                        </div>
                        <div class="col s2 l2">
                            <img id="imagePreview6" class="demoSlideShow cursorSlideShow pictureWidth" src="/img/Wukong.jpg" onclick="selectSlide(this,6); selectPicture(6)" alt="Wukong">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 l2 NoPadding drawcols">
                <div class="row NoMarginRow">
                    <h5>Leaderboard</h5>
                    <table>
                        <thead>
                            <tr>
                                <th>Score</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>6</td>
                                <td>Gino</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Selim</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Kaya</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Roman</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Dominique</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row NoMarginRow">
                        <div class="col s6 NoPadding ">
                            <h5>Runde: </h5>
                        </div>
                        <div class="col s6 NoPadding">
                            <h5>3</h5>
                        </div>
                    </div>
                    <div class="row NoMarginRow">
                        <div class="col s6 NoPadding">
                            <h5>Time Left:</h5>
                        </div>
                        <div class="col s6 NoPadding">
                            <h5>23sec</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div id="endContainer" class="content" style="display: none;">
                <div class="ex1">
                    <div class="row">
                        <h2 class="WelcomeText">Spiel Ende</h2>
                        <h3 class="WelcomeText">Siegerehrung</h3>
                    </div>
                    <div class="row">
                        <div class="col s12 l4">
                            <h5 class="WelcomeText">Bestes Bild nach Stimmen</h5>
                            <div class="card">
                                <div class="card-image">
                                    <img src="/img/Ubuntu.png">
                                    <span class="card-title sketchTitle">Selim</span>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 l4">
                            <h5 class="WelcomeText">Bestes Bild nach Algorithmus</h5>
                            <div class="card">
                                <div class="card-image">
                                    <img src="/img/KimJongUn.png">
                                    <span class="card-title sketchTitle">Selim</span>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 l4">
                            <h5 class="WelcomeText">Schlechtestes Bild nach Algorithmus</h5>
                            <div class="card">
                                <div class="card-image">
                                    <img src="/img/1542233.jpg">
                                    <span class="card-title sketchTitle">Selim</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h2 class="WelcomeText selectColorWinner">
                            Gewinner ist: Selim
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <div id="endContainer" class="content" style="display: none;">
            <div class="ex1">
                <div class="row">
                    <h2 class="WelcomeText">Spiel Ende</h2>
                    <h3 class="WelcomeText">Siegerehrung</h3>
                </div>
                <div class="row">
                    <div class="col s12 l4">
                        <h5 class="WelcomeText">Bestes Bild nach Stimmen</h5>
                        <div class="card">
                            <div class="card-image">
                                <img src="/img/Ubuntu.png">
                                <span class="card-title sketchTitle">Selim</span>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 l4">
                        <h5 class="WelcomeText">Bestes Bild nach Algorithmus</h5>
                        <div class="card">
                            <div class="card-image">
                                <img src="/img/KimJongUn.png">
                                <span class="card-title sketchTitle">Selim</span>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 l4">
                        <h5 class="WelcomeText">Schlechtestes Bild nach Algorithmus</h5>
                        <div class="card">
                            <div class="card-image">
                                <img src="/img/1542233.jpg">
                                <span class="card-title sketchTitle">Selim</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h2 class="WelcomeText selectColorWinner">
                        Gewinner ist: Selim
                    </h2>
                </div>
            </div>
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