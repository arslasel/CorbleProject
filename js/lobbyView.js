lobby_username = "";
lobby_joincode = 0;
start_RoundID = 0;

function loadLobbyData(joincode) {
    $.ajax({
        type: 'get',
        url: '../Controller/ajax/LobbyViewUpdate.php',
        data: {
            joincode: lobby_joincode,
        },
        success: function (response) {
            data = JSON.parse(response)
            currentTime = Math.round((new Date()).getTime() / 1000);
            document.getElementById('lobby_overview_state').innerHTML = data.state;
            document.getElementById('lobby_overview_votetime').innerHTML = data.voteTime;
            document.getElementById('lobby_overview_starttime').innerHTML = data.startTime - currentTime;
            document.getElementById('lobby_overview_drawtime').innerHTML = data.drawTime;
            document.getElementById('lobby_overview_maxplayer').innerHTML = data.maxPlayer;
            document.getElementById('lobby_overview_joincode').innerHTML = data.joinCode;

            var ul = document.getElementById('lobby_overview_players');
            ul.innerHTML = "";
            data.players.forEach(player => {
                var li = document.createElement('li');
                li.textContent = player;
                ul.appendChild(li);
            });

            if (data.startTime - currentTime <= 0) {
                redirectToGame()
            }
        }
    });
}

function createLobby() {
    var selected = [];
    for (var option of document.getElementById('lobby_config_wordpool').options) {
        if (option.selected) {
            if (option.value != "") {
                selected.push(option.value);
            }
        }
    }
    $.ajax({
        type: 'get',
        url: '../Controller/ajax/LobbyViewCreateLobby.php',
        data: {
            drawtime: document.getElementById('lobby_config_drawtime').value,
            votetime: document.getElementById('lobby_config_votetime').value,
            starttime: document.getElementById('lobby_config_starttime').value,
            maxplayer: document.getElementById("lobby_config_maxplayer").value,
            wordpools: selected,
            username: lobby_username

        },
        success: function (response) {
            data = JSON.parse(response);

            lobby_joincode = parseInt(data.joincode);
            start_RoundID = parseInt(data.roundID);
            if (lobby_joincode > 0 && start_RoundID > 0) {
                loadView();
                window.setInterval(() => {
                    loadLobbyData(lobby_joincode);
                }, 1000);
            }
        }
    });
}

function login() {
    $.ajax({
        type: 'get',
        url: '../Controller/ajax/LobbyViewLogin.php',
        data: {
            username: document.getElementById('username').value
        },
        success: function (response) {
            if (response == "success") {
                lobby_username = document.getElementById('username').value
                loadView();
            } else {
                alert(response)
            }
        }
    });
}

function loadWordPools() {
    $.ajax({
        type: 'get',
        url: '../Controller/ajax/LobbyViewLoadWordPools.php',
        data: {},
        success: function (response) {
            json = JSON.parse(response);

            var select = document.getElementById('lobby_config_wordpool');
            select.innerHTML = "";
            json.forEach(wordpool => {
                var opt = document.createElement('option');
                opt.value = wordpool.index;
                opt.innerHTML = wordpool.name;
                select.appendChild(opt);
            });

            M.AutoInit();
        }
    });
}

function join_lobby() {
    $.ajax({
        type: 'get',
        url: '../Controller/ajax/LobbyViewJoin.php',
        data: {
            joincode: document.getElementById('lobby_joincode_field').value,
            username: lobby_username
        },
        success: function (response) {
            lobby_joincode = document.getElementById('lobby_joincode_field').value
            $start_RoundID = parseInt(JSON.parse(response));
            loadView();
            window.setInterval(() => {
                loadLobbyData(lobby_joincode);
            }, 1000);
        }
    });
}

function loadView() {
    if (lobby_username == "") {
        //user is not logged in load login div
        document.getElementById("select_name").removeAttribute("hidden");
        document.getElementById("lobby_configurator").setAttribute("hidden", "1");
        document.getElementById("lobby_overview").setAttribute("hidden", "1");
    } else {
        //display username
        document.getElementById("username_displaym").innerHTML = lobby_username;
        document.getElementById("username_displayd").innerHTML = lobby_username;

        if (lobby_joincode == 0) {
            //user is logged in show lobby create / join view
            document.getElementById("lobby_configurator").removeAttribute("hidden");
            document.getElementById("select_name").setAttribute("hidden", "1");
            document.getElementById("lobby_overview").setAttribute("hidden", "1");
        } else {
            document.getElementById("lobby_overview").removeAttribute("hidden");
            document.getElementById("select_name").setAttribute("hidden", "1");
            document.getElementById("lobby_configurator").setAttribute("hidden", "1");
        }
    }
}

function redirectToGame() {
    url = "https://corble.ch/php/View/GameView.php?username=" + lobby_username + "&lobby=" + lobby_joincode + "&roundID=" + start_RoundID;
    window.location.replace(url)
}

setTimeout(() => {
    loadView();
    loadWordPools();
}, 50);