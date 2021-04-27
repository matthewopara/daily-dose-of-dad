let voiceSelector = document.querySelector("#voices-select");
let dadImages = ["images/dads&moms/dad1.jpg", "images/dads&moms/dad2.jpg", "images/dads&moms/dad3.jpg", "images/dads&moms/mom1.jpg", "images/dads&moms/mom2.jpg", "images/dads&moms/mom3.jpg"]
let dadImage = document.querySelector("#dad-image");
dadImage.style.opacity = 1;;
let dadImageInterval = null;
let newDadImage = document.querySelector("#new-dad-image")

voiceSelector.onchange = function() {
    newDadImage.src = dadImages[parseInt(voiceSelector.value)];
    voiceSelector.disabled = true;
    dadImageInterval = setInterval(fadeDadImage, 1);
}

let dadJokeBox = document.querySelector("#dad-joke-box");
dadJokeBox.addEventListener("keyup", function(event) {
    console.log(dadJokeBox.innerHTML.length);
    if (dadJokeBox.innerHTML.length > 300) {
        document.querySelector("#max-char-error").classList.remove("hidden");
    } else {
        document.querySelector("#max-char-error").classList.add("hidden");
    }
});


function fadeDadImage() {
    let opacity = dadImage.style.opacity;
    if (opacity <= 0) {
        clearInterval(dadImageInterval);
        dadImage.src = newDadImage.src;
        dadImage.style.opacity = 1;
        voiceSelector.disabled = false;
    } else {
        let newopacity = opacity - 0.02;
        dadImage.style.opacity = newopacity;
    }
}