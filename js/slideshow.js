// Next/previous controls
function plusSlides(n) {
    selectSlide(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
    selectSlide(slideIndex = n);
}

function selectSlide(caller, n) {
    var element = document.getElementById("image" + n.toString());
    var captionElement = document.getElementById("caption");
    if (element != null) {
        element.removeAttribute("hidden")
    }

    for (let index = 1; index < 7; index++) {
        var hideElemment = document.getElementById("image" + index.toString());
        if (index != n) {
            hideElemment.setAttribute("hidden", "true");
        }
    }

    captionElement.innerHTML = caller.alt;
}

setTimeout(() => {
    selectSlide(document.getElementById("imagePreview1"), 1);
}, 100);