/**
 * This is done because the canvas element is being loaded after the script tag containing this file
 */
setTimeout(() => {
    onCanvasLoad();
}, 50);

//global variables
var drawing = false;
var canvas;
var ctx;
var mousePos;
var lastPos;
var x;
var y
var wheelOpt;
var wheelEvent;



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

function onCanvasLoad() {
    /**
         * The Variables has to be initalized so that for example a color is
         * present
         */
    x = "black",
        y = 2;

    // Get a regular interval for drawing to the screen
    window.requestAnimFrame = (function (callback) {
        return window.requestAnimationFrame ||
            window.webkitRequestAnimationFrame ||
            window.mozRequestAnimationFrame ||
            window.oRequestAnimationFrame ||
            window.msRequestAnimaitonFrame ||
            function (callback) {
                window.setTimeout(callback, 1000 / 60);
            };
    })();

    // Set up the canvas
    canvas = document.getElementById("drawBoard");
    var drawBoardContainer = document.getElementById("drawBoardContainer");
    ctx = canvas.getContext("2d");
    canvas.width = drawBoardContainer.getBoundingClientRect().width * 0.95;
    canvas.height = drawBoardContainer.getBoundingClientRect().height * 0.95;

    initCanvas();

    // Set up the UI
    //var text = document.getElementById("dataUrl");
    var image = document.getElementById("image");
    var clearBtn = document.getElementById("clearBtn");
    var submitBtn = document.getElementById("submitBtn");
    clearBtn.addEventListener("click", function (e) {
        clearCanvas();
        text.innerHTML = "Data URL";
        image.setAttribute("src", "");
    }, false);
    submitBtn.addEventListener("click", function (e) {
        var dataUrl = canvas.toDataURL();
        image.setAttribute("src", dataUrl);
    }, false);

    // Set up mouse events for drawing

    mousePos = {
        x: 0,
        y: 0
    };
    lastPos = mousePos;
    canvas.addEventListener("mousedown", function (e) {
        drawing = true;
        disableScroll();
        lastPos = getMousePos(canvas, e);
    }, false);
    canvas.addEventListener("mouseup", function (e) {
        drawing = false;
        enableScroll();
    }, false);
    canvas.addEventListener("mousemove", function (e) {
        mousePos = getMousePos(canvas, e);
    }, false);

    // Set up touch events for mobile
    canvas.addEventListener("touchstart", function (e) {
        mousePos = getTouchPos(canvas, e);
        disableScroll(); //otherwise you cannot draw without scrolling around
        var touch = e.touches[0];
        var mouseEvent = new MouseEvent("mousedown", {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
    }, false);
    canvas.addEventListener("touchend", function (e) {
        var mouseEvent = new MouseEvent("mouseup", {});
        canvas.dispatchEvent(mouseEvent);
    }, false);
    canvas.addEventListener("touchmove", function (e) {
        var touch = e.touches[0];
        var mouseEvent = new MouseEvent("mousemove", {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
    }, false);

    // Prevent scrolling when touching the canvas
    document.body.addEventListener("touchstart", function (e) {
        if (e.target == canvas) {
            e.preventDefault();
        }
    }, false);
    document.body.addEventListener("touchend", function (e) {
        if (e.target == canvas) {
            e.preventDefault();
        }
    }, false);
    document.body.addEventListener("touchmove", function (e) {
        if (e.target == canvas) {
            e.preventDefault();
        }
    }, false);

    /**
     * This function allow for animation drawing
     */
    (function drawLoop() {
        requestAnimFrame(drawLoop);
        renderCanvas();
    })();

    /**
    * modern Chrome requires { passive: false } when adding event
    */
    var supportsPassive = false;
    try {
        window.addEventListener("supportPassive", null, Object.defineProperty({}, 'passive', {
            get: function () {
                supportsPassive = true;
            }
        }));
    } catch (e) { }

    wheelOpt = supportsPassive ? {
        passive: false
    } : false;
    wheelEvent = 'onwheel' in document.createElement('div') ? 'wheel' : 'mousewheel';
}
