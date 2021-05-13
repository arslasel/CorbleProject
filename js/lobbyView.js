lobby_username = "";
lobby_joincode = 0;

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

            if(data.starttime - currentTime == 0){
                alert("game starts now");
            }
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
            wordpools: selected,
            username: lobby_username

        },
        success: function (response) {
            lobby_joincode = parseInt(response);
            if(lobby_joincode>0){
                loadView();
                window.setInterval(()=>{
                    loadLobbyData(lobby_joincode);
                },1000);
            }
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

function loadWordPools(){
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

function join_lobby(){
    $.ajax({
        type: 'get',
        url: '../Controller/ajax/LobbyViewJoin.php',
        data: {
            joincode: document.getElementById('lobby_joincode_field').value,
            username: lobby_username
        },
        success: function (response) {
            lobby_joincode = document.getElementById('lobby_joincode_field').value
            loadView();
            window.setInterval(()=>{
                loadLobbyData(lobby_joincode);
            },1000);
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
        //display username
        document.getElementById("username_displaym").innerHTML = lobby_username;
        document.getElementById("username_displayd").innerHTML = lobby_username;

        if(lobby_joincode == 0){
            //user is logged in show lobby create / join view
            document.getElementById("lobby_configurator").removeAttribute("hidden");
            document.getElementById("select_name").setAttribute("hidden","1");
            document.getElementById("lobby_overview").setAttribute("hidden","1");
        }else{
            document.getElementById("lobby_overview").removeAttribute("hidden");
            document.getElementById("select_name").setAttribute("hidden","1");
            document.getElementById("lobby_configurator").setAttribute("hidden","1");
        }
    }
}

setTimeout(() => {
    loadView();
    loadWordPools();
}, 50);