function loadPictureWinnerVote() {
    $.ajax({
        type: "GET",
        url: '/php/Controller/ajax/GameViewEndLoadPictureWinnerVote.php',
        /**
         * data: Variablen müssen nocht angegeben werden mit dem Spielindex
         * siehe Beispiel Lobbyview
         */
        data: {
            //TODO
        },
        success: function(data) {
            document.getElementById("get_img_WinnerVoted").appendChild(data);
        }
    });
}


function loadPictureBestAlgoVote() {
    $.ajax({
        type: "GET",
        url: '/php/Controller/ajax/GameViewEndLoadPictureBestAlgo.php',
        /**
         * data: Variablen müssen nocht angegeben werden mit dem Spielindex
         * siehe Beispiel Lobbyview
         */
        data: {
            //TODO
        },
        success: function(data) {
            document.getElementById("get_img_BestAlgoVote").appendChild(data);
        }
    });
}