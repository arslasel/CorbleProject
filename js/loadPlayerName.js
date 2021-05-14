function loadPlayerNameOfBestVotedPicture() {
    $.ajax({
        type: "GET",
        url: '../Controller/ajax/GameViewEndLoadPlayerName.php',
        /**
         * data: Variablen müssen nocht angegeben werden mit dem Spielindex
         * siehe Beispiel Lobbyview
         */
        data: {
            //TODO
        },
        success: function(data) {
            span = document.getElementById("bestVotedPlayer");
            txt = document.createTextNode(data);
            span.appendChild(txt);
        }
    });
}

function loadPlayerNameOfBestAlgoPicture() {
    $.ajax({
        type: "GET",
        url: '../Controller/ajax/GameViewEndLoadPlayerNameBestAlgoVote.php',
        /**
         * data: Variablen müssen nocht angegeben werden mit dem Spielindex
         * siehe Beispiel Lobbyview
         */
        data: {
            //TODO
        },
        success: function(data) {
            span = document.getElementById("bestAlgoName");
            txt = document.createTextNode(data);
            span.appendChild(txt);
        }
    });
}

function loadPlayerNameOfWorstAlgoPicture() {
    $.ajax({
        type: "GET",
        url: '../Controller/ajax/GameViewEndLoadPlayerNameWorstAlgoVote.php',
        /**
         * data: Variablen müssen nocht angegeben werden mit dem Spielindex
         * siehe Beispiel Lobbyview
         */
        data: {
            //TODO
        },
        success: function(data) {
            span = document.getElementById("worstAlgoName");
            txt = document.createTextNode(data);
            span.appendChild(txt);
        }
    });
}

function loadWinnerName() {
    $.ajax({
        type: "GET",
        url: '../Controller/ajax/GameViewEndLoadWinner.php',
        /**
         * data: Variablen müssen nocht angegeben werden mit dem Spielindex
         * siehe Beispiel Lobbyview
         */
        data: {
            //TODO
        },
        success: function(data) {
            span = document.getElementById("winnerMessage");
            txt = document.createTextNode(data);
            span.appendChild(txt);
        }
    });
}