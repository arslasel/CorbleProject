function loadDocShowWinner() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var image = document.getElementById("get_img_WinnerVoted");
            document.getElementById("get_img_WinnerVoted").innerHTML = this.responseURL;
        }
    };
    xhttp.open("GET", "ajax_info.txt", true); //Adresse oder Path, Dateiname etc. vom Bild des GewinnerVotes im zweiten Argument
    xhttp.send(null);
}