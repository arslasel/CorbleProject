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
    console.log(selected)
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