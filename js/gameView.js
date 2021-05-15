lobby_username = "";
lobby_joincode = 0;
remainingTime = 60;


function init() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    lobby_username = urlParams.get('username')
    lobby_joincode = urlParams.get('lobby')
}

function submitImage() {
    var fd = new FormData();
    var blob = new Blob([document.getElementById("drawBoard").toDataURL()], { type: "text/plain" });
    fd.append("imageBase64", blob,"imageBase64.txt");
    fd.append("username",lobby_username);
    fd.append("lobby", lobby_joincode);
    fd.append("word", 2);
    $.ajax({
        url: '../Controller/ajax/GameViewSubmitImage.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response)
        },
    });

}

function loadView() {
    //display username
    document.getElementById("username_displaym").innerHTML = lobby_username;
    document.getElementById("username_displayd").innerHTML = lobby_username;

    document.getElementById("drawContainer").removeAttribute("hidden");
    document.getElementById("voteContainer").setAttribute("hidden", "1");
    document.getElementById("endContainer").setAttribute("hidden", "1");
}

function registerTimeEvents() {
    window.setInterval(() => {
        remainingTime = remainingTime - 1;
        document.getElementById("timeLeftToDraw").innerHTML = remainingTime.toString();
        if (remainingTime == 0) {
            alert("drawTime over")
        }
    }, 1000);
}

setTimeout(() => {
    init();
    loadView();
    registerTimeEvents();
    onCanvasLoad();
}, 20);