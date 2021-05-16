lobby_username = "";
lobby_joincode = 0;
remainingTime = 60;


function init() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    lobby_username = urlParams.get('username')
    lobby_joincode = urlParams.get('lobby')
    $.when(initGame()).done(function (response) {remainingTime = response.votetime;})
}

function initGame() {
    return $.ajax({
        type: 'get',
        url: '../Controller/ajax/GameViewInitGame.php',
        dataType: 'JSON',
        data: {
            joincode: lobby_joincode
        }
    });

}

function initGameEnd() {

    document.getElementById("endContainer").removeAttribute("hidden");
    document.getElementById("drawContainer").setAttribute("hidden", "1");
    document.getElementById("voteContainer").setAttribute("hidden", "1");


    loadWinnerName();
    loadPlayerNameOfWorstAlgoPicture();
    loadPlayerNameOfBestVotedPicture();
    loadPlayerNameOfBestAlgoPicture();
    loadPictureWinnerVote();
    loadPictureBestAlgoVote();
    loadPictureWorstAlgoVote();
}

function submitImage() {
    var fd = new FormData();
    var blob = new Blob([document.getElementById("drawBoard").toDataURL()], { type: "text/plain" });
    fd.append("imageBase64", blob, "imageBase64.txt");
    fd.append("username", lobby_username);
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

function loadPictureWinnerVote() {
    $.ajax({
        type: "GET",
        url: '../Controller/ajax/GameViewEndLoadPictureWinnerVote.php',
        data: {
            roundIndex: 1, //insert real round index later,
            username: lobby_username
        },
        success: function (data) {
            $.ajax({
                type: "GET",
                url: data.replace('/home/rigpdqdi/public_html/corble.ch', ''),
                success: function (data) {
                    document.getElementById('get_img_WinnerVoted')
                        .setAttribute(
                            'src', data
                        );
                }
            });
        }
    });
}

function loadPictureBestAlgoVote() {
    $.ajax({
        type: "GET",
        url: '../Controller/ajax/GameViewEndLoadPictureBestAlgoVote.php',
        data: {
            roundIndex: 1, //insert real round index later,
            username: lobby_username
        },
        success: function (data) {
            $.ajax({
                type: "GET",
                url: data.replace('/home/rigpdqdi/public_html/corble.ch', ''),
                success: function (data) {
                    document.getElementById('get_img_BestAlgoVote')
                        .setAttribute(
                            'src', data
                        );
                }
            });
        }
    });
}

function loadPictureWorstAlgoVote() {
    $.ajax({
        type: "GET",
        url: '../Controller/ajax/GameViewEndLoadPictureWorstAlgoVote.php',
        data: {
            roundIndex: 1, //insert real round index later,
            username: lobby_username
        },
        success: function (data) {
            $.ajax({
                type: "GET",
                url: data.replace('/home/rigpdqdi/public_html/corble.ch', ''),
                success: function (data) {
                    document.getElementById('get_img_worstAlgoVote')
                        .setAttribute(
                            'src', data
                        );
                }
            });
        }
    });
}

function loadPlayerNameOfBestVotedPicture() {
    $.ajax({
        type: "GET",
        url: '../Controller/ajax/GameViewEndLoadPlayerNamePictureVote.php',
        data: {
            roundIndex: 1, //insert real round index later,
            username: lobby_username
        },
        success: function (data) {
            span = document.getElementById("bestVotedPlayer");
            span.innerHTML = data;
        }
    });
}

function loadPlayerNameOfBestAlgoPicture() {
    $.ajax({
        type: "GET",
        url: '../Controller/ajax/GameViewEndLoadPlayerNameBestAlgoVote.php',
        data: {
            roundIndex: 1, //insert real round index later,
            username: lobby_username
        },
        success: function (data) {
            span = document.getElementById("bestAlgoName");
            span.innerHTML = data;
        }
    });
}

function loadPlayerNameOfWorstAlgoPicture() {
    $.ajax({
        type: "GET",
        url: '../Controller/ajax/GameViewEndLoadPlayerNameWorstAlgoVote.php',
        data: {
            roundIndex: 1, //insert real round index later,
            username: lobby_username
        },
        success: function (data) {
            span = document.getElementById("worstAlgoName");
            span.innerHTML = data;
        }
    });
}

function loadWinnerName() {
    $.ajax({
        type: "GET",
        url: '../Controller/ajax/GameViewEndLoadWinner.php',
        data: {
            roundIndex: 1, //insert real round index later,
            username: lobby_username
        },
        success: function (data) {
            span = document.getElementById("winnerMessage");
            span.innerHTML = data;
        }
    });
}

function registerTimeEvents() {
    window.setInterval(() => {
        remainingTime = remainingTime - 1;
        document.getElementById("timeLeftToDraw").innerHTML = remainingTime.toString();
        if (remainingTime <= 0) {
            submitImage()
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

