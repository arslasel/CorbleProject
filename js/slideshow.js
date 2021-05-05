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
    if (element != null) {
        element.removeAttribute("hidden")
    }

    for (let index = 1; index < 7; index++) {
        var hideElemment = document.getElementById("image" + index.toString());
        if (index != n) {
            hideElemment.setAttribute("hidden", "true");
        }
    }
}

function selectPicture(n) {
    var littelpicture = document.getElementById("imagePreview" + n.toString());
    littelpicture.classList.add("selectedPicture");
    for (let index = 1; index < 7; index++) {
        var temp = document.getElementById("imagePreview" + index.toString())
        if (temp != littelpicture) {
            temp.classList.remove("selectedPicture");
        }
    }
}


setTimeout(() => {
    selectSlide(document.getElementById("imagePreview1"), 1);
}, 100);