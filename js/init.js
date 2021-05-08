document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems, {});
});

$(document).ready(function() {
    $('.sidenav').sidenav();
});

document.addEventListener('DOMContentLoaded', function() {
    var Modalelem = document.querySelector('.modal');
    var instanceModal = M.Modal.init(Modalelem);
});

setTimeout(() => {
    M.AutoInit(document.body)
}, 100);