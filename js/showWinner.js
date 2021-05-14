function loadDocShowWinner() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("winnerMessage").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "ajax_info.txt", true); //Adresse oder Path vom Name des Gewinner im zweiten Argument
    xhttp.send(null);
}