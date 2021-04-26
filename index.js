let voiceSelector = document.querySelector("#voices-select");
let dadImages = ["images/dads&moms/dad1.jpg", "images/dads&moms/dad2.jpg", "images/dads&moms/dad3.jpg", "images/dads&moms/mom1.jpg", "images/dads&moms/mom2.jpg", "images/dads&moms/mom3.jpg"]
let dadImage = document.querySelector("#dad-image")

voiceSelector.onchange = function() {
    dadImage.src = dadImages[parseInt(voiceSelector.value)];
}