let voiceSelector = document.querySelector("#voices-select")
let dadImages = ["images/dads&moms/mufasa.jpg", "images/dads&moms/homer.jpg", "images/dads&moms/mr_incredible.jpg", "images/dads&moms/elastigirl.jpg", "images/dads&moms/sarabi.jpg", "images/dads&moms/marge.jpg"]
let dadImage = document.querySelector("#dad-image")
dadImage.style.opacity = 1
let dadImageInterval = null
let newDadImage = document.querySelector("#new-dad-image")

voiceSelector.onchange = function() {
    newDadImage.src = dadImages[parseInt(voiceSelector.value)];
    voiceSelector.disabled = true
    dadImageInterval = setInterval(fadeDadImage, 1)
}

let dadJokeBox = document.querySelector("#dad-joke-box")
dadJokeBox.addEventListener("keyup", function(event) {
    console.log(dadJokeBox.innerHTML.length)
    if (dadJokeBox.innerHTML.length > 300) {
        document.querySelector("#max-char-error").classList.remove("hidden")
    } else {
        document.querySelector("#max-char-error").classList.add("hidden")
    }
});


function fadeDadImage() {
    let opacity = dadImage.style.opacity
    if (opacity <= 0) {
        clearInterval(dadImageInterval)
        dadImage.src = newDadImage.src
        dadImage.style.opacity = 1
        voiceSelector.disabled = false
    } else {
        let newopacity = opacity - 0.02
        dadImage.style.opacity = newopacity
    }
}


let form = document.querySelector("#form")
let saveButton = document.querySelector("#save-button")
saveButton.addEventListener("click", function() {
    if (dadJokeBox.innerText.trim().length == 0) {
        alert("There is no joke to save")
    } else {
        let jokeInput = document.querySelector("#joke-input")
        let voiceInput = document.querySelector("#voice-input")
        jokeInput.value = dadJokeBox.innerText.trim()
        voiceInput.value = voiceSelector.value
        form.submit()
    }
})


if (get("success") == "false" && get("loggedIn") == "false") {
    alert("You must be logged in to save a joke")
} else if (get("success") == "false") {
    alert("An error occurred while trying to save the joke")
} else if (get("success") == "true") {
    alert("Joke was saved")
}

function get(name){
    if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
       return decodeURIComponent(name[1]);
 }