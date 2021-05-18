lobby_username = "";
lobby_joincode = 0;
start_roundID = 0;
remainingTime = 9999;
selectedImgID = 0;


function init() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    lobby_username = urlParams.get('username')
    lobby_joincode = urlParams.get('lobby')
    start_roundID = urlParams.get('roundID')
    initGame();
    initWord();
}

function initGame() {
    $.ajax({
        type: 'get',
        url: '../Controller/ajax/GameViewInitGame.php',
        data: {
            joincode: lobby_joincode
        },
        success: function (data) {
            remainingTime = parseInt(JSON.parse(data).voteTime);
        }
    });

}

function initWord() {
    $.ajax({
        type: 'get',
        url: '../Controller/ajax/GameViewInitWord.php',
        data: {
            joincode: lobby_joincode,
            roundIndex: start_roundID
        },
        success: function (data) {
            console.log(data);
            document.getElementById("wordToDraw").innerHTML = data;
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

function initVote() {
    $.ajax({
        type: 'get',
        url: '../Controller/ajax/GameViewVoteTime.php',
        data: {
            joincode: lobby_joincode,
            roundIndex: start_roundID
        },
        success: function (data) {        
            remainingTime = data;
        }
    });

    document.getElementById("voteContainer").removeAttribute("hidden");
    document.getElementById("drawContainer").setAttribute("hidden", "1");
    document.getElementById("endContainer").setAttribute("hidden", "1");

    loadPicturesVote();
}

function submitImage() {
    var fd = new FormData();
    var blob = new Blob([document.getElementById("drawBoard").toDataURL()], { type: "text/plain" });
    fd.append("imageBase64", blob, "imageBase64.txt");
    fd.append("lobby_username", lobby_username);
    fd.append("lobby_joincode", lobby_joincode);
    fd.append("start_roundID", start_roundID);
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

function loadPicturesVote() {
    $.ajax({
        type: "GET",
        url: '../Controller/ajax/GameViewVoteLoadPictures.php',
        data: {
            roundIndex: 1,
            username: lobby_username,
            joincode: lobby_joincode,
            start_roundID: start_roundID
        },
        success: function (data) {
            console.log(data);
            images = JSON.parse(data);
            img_mini_container = document.getElementById("img_mini_container");
            img_mini_container.innerHTML = "";
            images.forEach(img => {
                $.ajax({
                    type: "GET",
                    url: img.path.replace('/home/rigpdqdi/public_html/corble.ch', ''),
                    success: function (data) {
                        imgdiv = document.createElement('div')
                        imgdiv.className = "col s2 l2";
                        imgelement = document.createElement('img')
                        imgelement.setAttribute("src", data)
                        imgelement.className = "demoSlideShow cursorSlideShow pictureWidth slideshowpics";
                        imgelement.onclick = function(){
                            selectedImgID = img.dbIndex;
                            document.getElementById("previewImage").setAttribute("src", data);
                            
                            list = document.getElementsByClassName("slideshowpics");
                            for (var i = 0; i < list.length; i++) {
                                list[i].classList.remove("selectedPicture");
                            }
                        
                            
                            this.classList.add("selectedPicture");

                        }
                        imgdiv.appendChild(imgelement);
                        img_mini_container.appendChild(imgdiv);
                        imgelement.click();
                    }
                });
            });
        }
    });
}

function loadPictureWinnerVote() {
    $.ajax({
        type: "GET",
        url: '../Controller/ajax/GameViewEndLoadPictureWinnerVote.php',
        data: {
            roundIndex: 1, //insert real round index later,
            username: lobby_username,
            joincode: lobby_joincode,
            start_roundID: start_roundID
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
            username: lobby_username,
            joincode: lobby_joincode,
            start_roundID: start_roundID
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
            username: lobby_username,
            joincode: lobby_joincode,
            start_roundID: start_roundID
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
            username: lobby_username,
            joincode: lobby_joincode,
            start_roundID: start_roundID
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
            username: lobby_username,
            joincode: lobby_joincode,
            start_roundID: start_roundID
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
            username: lobby_username,
            joincode: lobby_joincode,
            start_roundID: start_roundID
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
            roundIndex: 1, 
            username: lobby_username,
            joincode: lobby_joincode,
            start_roundID: start_roundID
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
        document.getElementById("timeLeftToVote").innerHTML = remainingTime.toString();
        if (remainingTime == 0) {
            submitImage();
          //  initVote();
        }
        if(remainingTime < 0){ remainingTime = -1;}
    }, 1000);
}

setTimeout(() => {
    init();
    loadView();
    registerTimeEvents();
    onCanvasLoad();
}, 20);

