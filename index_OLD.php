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

	<title>Corble</title>

	<!-- Compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<!-- Compiled and minified JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<link rel="stylesheet" href="style.css">
    <style>
        body {
            padding-top: 20px;
            padding-bottom: 20px;
        }

        #drawBoard {
            border: 2px dotted #CCCCCC;
            border-radius: 5px;
            cursor: crosshair;
        }

        #dataUrl {
            width: 100%;
        }

        /*html, body {
		    margin: 0;
		    height: 100%;
		    overflow: hidden;
		}*/

        /*canvas{
		    max-width: 100%;
		    min-width: 75%;
		    min-height:50%;
		    max-height: 50%;
		    overflow: auto;
		}*/
    </style>
</head>

<body>
    <!-- Content -->
    <div class="container">
        <div class="row" width="100%">
            <div class="col-md-12">
                <img src="img/CorbleLogo.png" width="350px" style="max-width:100%;">
            </div>
        </div>
        <!--<div class="row">
			<div class="col-md-12">!-->
        <canvas id="drawBoard">
        </canvas>
        <!--</div>
		</div>!-->
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
        <br />
        <br />
        <div class="row">
            <div class="col-md-12">
                <img id="image" alt="Picture will be here" />
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
    <div>Testpixel: <a href="php/View/LobbyView.php" target="_blank">Lobby View</a>
        <?php
        //If debugging is required the comment the following in
        //ini_set('display_errors', 1);
        //This is a test for the ImageProcessorModel with our corbleLogo
        include('php/Model/ImageProcessorModel.php');
        $imageProcessorModel = new ImageProcessorModel("img/CorbleLogo.png");
        $pixelsInArray = $imageProcessorModel->pixelCount();
        echo "<br>";
        echo "The black Counter is: " . $pixelsInArray[0] . "<br>";
        echo "The red Counter is: " . $pixelsInArray[1] . "<br>";
        echo "The green Counter is: " . $pixelsInArray[2] . "<br>";
        echo "The blue Counter is: " . $pixelsInArray[3] . "<br>";
        echo "The yellow Counter is: " . $pixelsInArray[4] . "<br>";
        echo "The orange Counter is: " . $pixelsInArray[5] . "<br>";
        ?>
    </div>
    <!-- The needed internal repositories -->
    <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script>
        /**
         * The Variables has to be initalized so that for example a color is
         * present
         */
        var x = "black",
            y = 2;
        var ctx;
        /**
         * In this function all nessecary Canvas settings initalizations, events
         * rendering, getPositions of touch or mousepointer and so on
         */
        (function() {
            // Get a regular interval for drawing to the screen
            window.requestAnimFrame = (function(callback) {
                return window.requestAnimationFrame ||
                    window.webkitRequestAnimationFrame ||
                    window.mozRequestAnimationFrame ||
                    window.oRequestAnimationFrame ||
                    window.msRequestAnimaitonFrame ||
                    function(callback) {
                        window.setTimeout(callback, 1000 / 60);
                    };
            })();

            // Set up the canvas
            var canvas = document.getElementById("drawBoard");
            ctx = canvas.getContext("2d");
            canvas.width = window.innerWidth / 1.35;
            canvas.height = window.innerHeight / 2;
            initCanvas();

            // Set up the UI
            //var text = document.getElementById("dataUrl");
            var image = document.getElementById("image");
            var clearBtn = document.getElementById("clearBtn");
            var submitBtn = document.getElementById("submitBtn");
            clearBtn.addEventListener("click", function(e) {
                clearCanvas();
                text.innerHTML = "Data URL";
                image.setAttribute("src", "");
            }, false);
            submitBtn.addEventListener("click", function(e) {
                var dataUrl = canvas.toDataURL();
                //console.log(dataUrl); //TODO: Remove for debugging reasons
                image.setAttribute("src", dataUrl);
                //TODO: Moegliche Implementierung in JS von Pixelauszaehlung
                //funktioniert aber noch nicht
                /*for(pixelW = 0 ; pixelW < canvas.width ; pixelW++){
				    for(pixelH = 0 ; pixelH < canvas.height ; pixelH++){
				        var imageData = image.getImageData(pixelW, pixelH, canvas.width, canvas.height);
				         var index = (y*imageData.width + x) * 4;
                        var red = imageData.data[index];
                        var green = imageData.data[index + 1];
                        var blue = imageData.data[index + 2];
                        var alpha = imageData.data[index + 3];
				    }
				    
				}
				
				list(type, data) = explode(';', dataUrl);
				list($data) = explode(',', $data);
				
				$data = base64_decode($dataUrl);
				file_put_contents('img/image.png', $data);*/
            }, false);

            // Set up mouse events for drawing
            var drawing = false;
            var mousePos = {
                x: 0,
                y: 0
            };
            var lastPos = mousePos;
            canvas.addEventListener("mousedown", function(e) {
                drawing = true;
                disableScroll();
                lastPos = getMousePos(canvas, e);
            }, false);
            canvas.addEventListener("mouseup", function(e) {
                drawing = false;
                enableScroll();
            }, false);
            canvas.addEventListener("mousemove", function(e) {
                mousePos = getMousePos(canvas, e);
            }, false);

            // Set up touch events for mobile
            canvas.addEventListener("touchstart", function(e) {
                mousePos = getTouchPos(canvas, e);
                disableScroll(); //otherwise you cannot draw without scrolling around
                var touch = e.touches[0];
                var mouseEvent = new MouseEvent("mousedown", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(mouseEvent);
            }, false);
            canvas.addEventListener("touchend", function(e) {
                var mouseEvent = new MouseEvent("mouseup", {});
                canvas.dispatchEvent(mouseEvent);
            }, false);
            canvas.addEventListener("touchmove", function(e) {
                var touch = e.touches[0];
                var mouseEvent = new MouseEvent("mousemove", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(mouseEvent);
            }, false);

            // Prevent scrolling when touching the canvas
            document.body.addEventListener("touchstart", function(e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);
            document.body.addEventListener("touchend", function(e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);
            document.body.addEventListener("touchmove", function(e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);

            /**
             * This function is used for getting the position of the mouse
             * relative to the canvas
             * @input: Canvas canvasDom
             * @input: Event mouseEvent
             */
            // 
            function getMousePos(canvasDom, mouseEvent) {
                var rect = canvasDom.getBoundingClientRect();
                return {
                    x: mouseEvent.clientX - rect.left,
                    y: mouseEvent.clientY - rect.top
                };
            }

            /**
             * This function is used for getting the position of a touch
             * relative to the canvas
             * @input: Canvas canvasDom
             * @input: Event touchEvent
             */
            function getTouchPos(canvasDom, touchEvent) {
                var rect = canvasDom.getBoundingClientRect();
                return {
                    x: touchEvent.touches[0].clientX - rect.left,
                    y: touchEvent.touches[0].clientY - rect.top
                };
            }

            /**
             * This function is used for render/draw the canvas
             */
            function renderCanvas() {
                if (drawing) {
                    ctx.moveTo(lastPos.x, lastPos.y);
                    ctx.lineTo(mousePos.x, mousePos.y);
                    ctx.stroke();
                    lastPos = mousePos;
                }
            }

            /**
             * This function clears the canvas
             */
            function clearCanvas() {
                canvas.width = canvas.width;
            }

            /**
             * This function allow for animation drawing
             */
            (function drawLoop() {
                requestAnimFrame(drawLoop);
                renderCanvas();
            })();

        })();

        /**
         * This function allows us to change the color of the drawing style in the
         * canvas
         * @input: canvas object
         */
        function color(obj) {
            switch (obj.id) {
                case "green":
                    x = "green";
                    initCanvas();
                    break;
                case "blue":
                    x = "blue";
                    initCanvas();
                    break;
                case "red":
                    x = "red";
                    initCanvas();
                    break;
                case "yellow":
                    x = "yellow";
                    initCanvas();
                    break;
                case "orange":
                    x = "orange";
                    initCanvas();
                    break;
                case "black":
                    x = "black";
                    initCanvas();
                    break;
                case "white":
                    x = "white";
                    initCanvas();
                    break;
            }
            if (x == "white") y = 14;
            else y = 2;

        }

        /**
         * The beginPath() allows to use different colors without changing the whole drawn
         * and other inital stuff witch have to be repeatily used
         */
        function initCanvas() {
            ctx.beginPath();
            ctx.strokeStyle = x;
            ctx.lineWith = y;
            /*canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;*/
        }

        /**
         * This function is recursive and iterates in the event.
         * It is used for prevent the scrolling while drawing.
         * @input Event e
         */
        function preventDefault(e) {
            e.preventDefault();
        }

        /**
         * This function checks the inputted scroll keys
         * @input Event e
         */
        function preventDefaultForScrollKeys(e) {
            if (keys[e.keyCode]) {
                preventDefault(e);
                return false;
            }
        }

        /**
         * modern Chrome requires { passive: false } when adding event
         */
        var supportsPassive = false;
        try {
            window.addEventListener("supportPassive", null, Object.defineProperty({}, 'passive', {
                get: function() {
                    supportsPassive = true;
                }
            }));
        } catch (e) {}

        var wheelOpt = supportsPassive ? {
            passive: false
        } : false;
        var wheelEvent = 'onwheel' in document.createElement('div') ? 'wheel' : 'mousewheel';

        /**
         * This function is called to disable scrolling
         */
        function disableScroll() {
            window.addEventListener('DOMMouseScroll', preventDefault, false); // older FF
            window.addEventListener(wheelEvent, preventDefault, wheelOpt); // modern desktop
            window.addEventListener('touchmove', preventDefault, wheelOpt); // mobile
            window.addEventListener('keydown', preventDefaultForScrollKeys, false);
        }

        /**
         * This function is called to enable scrolling
         */
        function enableScroll() {
            window.removeEventListener('DOMMouseScroll', preventDefault, false);
            window.removeEventListener(wheelEvent, preventDefault, wheelOpt);
            window.removeEventListener('touchmove', preventDefault, wheelOpt);
            window.removeEventListener('keydown', preventDefaultForScrollKeys, false);
        }
    </script>
</body>

</html>