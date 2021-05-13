lobby_username = "";

function loadLobbyData(joincode) {
    $.ajax({
        type: 'get',
        url: '../Controller/ajax/LobbyViewUpdate.php',
        data: {
            joincode: joincode,
        },
        success: function (response) {
            data = JSON.parse(response)
            currentTime = Math.round((new Date()).getTime() / 1000);
            document.getElementById('lobby_overview_state').innerHTML = data.state;
            document.getElementById('lobby_overview_votetime').innerHTML = data.votetime;
            //console.log("data.starttime",data.starttime,"currentTime",currentTime,"data.starttime - currentTime",data.starttime - currentTime)
            document.getElementById('lobby_overview_starttime').innerHTML = data.starttime - currentTime;
            document.getElementById('lobby_overview_drawtime').innerHTML = data.drawtime;
            document.getElementById('lobby_overview_maxplayer').innerHTML = data.maxplayer;
            document.getElementById('lobby_overview_joincode').innerHTML = data.joincode;


            var ul = document.getElementById('lobby_overview_players');
            ul.innerHTML = "";
            data.players.forEach(player => {
                var li = document.createElement('li');
                li.textContent = player;
                ul.appendChild(li);
            });
        }
    });
}

function createLobby() {
    var selected = [];
    for (var option of document.getElementById('lobby_config_wordpool').options) {
        if (option.selected) {
            if(option.value != ""){
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
            wordpools: selected

        },
        success: function (response) {
            console.log(response)
        }
    });
}

function login(){
    $.ajax({
        type: 'get',
        url: '../Controller/ajax/LobbyViewLogin.php',
        data: {
            username: document.getElementById('username').value
        },
        success: function (response) {
            if(response == "success"){
                lobby_username = document.getElementById('username').value
                loadView();
            }else{
                alert(response)    
            }
        }
    });
}

function loadView(){
    if(lobby_username == ""){
        //user is not logged in load login div
        document.getElementById("select_name").removeAttribute("hidden");
        document.getElementById("lobby_configurator").setAttribute("hidden","1");
        document.getElementById("lobby_overview").setAttribute("hidden","1");
    }else{

        document.getElementById("username_displaym").innerHTML = lobby_username;
        document.getElementById("username_displayd").innerHTML = lobby_username;
        //user is logged in show lobby create / join view
        document.getElementById("lobby_configurator").removeAttribute("hidden");
        document.getElementById("select_name").setAttribute("hidden","1");
        document.getElementById("lobby_overview").setAttribute("hidden","1");
    }
}

setTimeout(() => {
    M.AutoInit()
    loadView();
}, 100);