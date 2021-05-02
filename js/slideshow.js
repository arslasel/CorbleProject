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

    /*
    var i;
    var slides = document.getElementsByClassName("mySlidesSlideShow");
    var dots = document.getElementsByClassName("demoSlideShow");
    var captionText = document.getElementById("caption");
    if (n > slides.length) {
        slideIndex = 1
    }
    if (n < 1) {
        slideIndex = slides.length
    }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    console.log(slides);
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
    captionText.innerHTML = dots[slideIndex - 1].alt;
    */
}

setTimeout(() => {
    selectSlide(document.getElementById("imagePreview1"), 1);
}, 100);