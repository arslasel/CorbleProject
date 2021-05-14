function loadLobbyData(joincode) {
    $.ajax({
        type: 'get',
        url: '../Controller/LobbyViewAjaxUpdate.php',
        data: {
            joincode: joincode,
        },
        success: function(response) {
            data = JSON.parse(response)
            document.getElementById('lobby_overview_state').innerHTML = data.state;
            document.getElementById('lobby_overview_votetime').innerHTML = data.votetime;
            document.getElementById('lobby_overview_starttime').innerHTML = data.starttime;
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