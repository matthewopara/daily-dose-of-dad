let voiceSelector = document.querySelector("#voices-select")
let dadImages = ["images/dads&moms/mufasa.jpg", "images/dads&moms/homer.jpg", "images/dads&moms/mr_incredible.jpg", "images/dads&moms/elastigirl.jpg", "images/dads&moms/sarabi.jpg", "images/dads&moms/marge.jpg"]
let dadImage = document.querySelector("#dad-image")
dadImage.style.opacity = 1
let dadImageInterval = null
let newDadImage = document.querySelector("#new-dad-image")
let soundButton = document.querySelector("#sound-button")

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

let lastAudioText = "";
let lastAudioVoice
soundButton.addEventListener("click", function() {
    console.log(dadJokeBox.innerText)
    console.log(voiceSelector.value)
    if (dadJokeBox.innerText == "") {
        return
    }
    let newJoke = ""
    if (lastAudioText.localeCompare(dadJokeBox.innerText) == 0 && lastAudioVoice == voiceSelector.value) {
        newJoke = "false"
    } else {
        newJoke = "true"
        lastAudioText = dadJokeBox.innerText
        lastAudioVoice = voiceSelector.value
    }
    let httpRequest = new XMLHttpRequest()

    httpRequest.open("GET", "text_to_speech.php?joke=" + encodeURIComponent(dadJokeBox.innerText) +  "&jokeId=-1&voiceId=" + voiceSelector.value + "&new=" + newJoke)
    httpRequest.send()

    httpRequest.onreadystatechange = function() {
        console.log(httpRequest.readyState)

        // readyState == 4 when we have a full response
        if (httpRequest.readyState == 4) {
            // check for errors
            if (httpRequest.status == 200) {
                // 200 means successful
                console.log(httpRequest.responseText)
                playAudio(httpRequest.responseText)
            } else {
                console.log("Error")
                console.log(httpRequest.status)
            }
        }
    }
    return false
})

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

if (get("loggedIn") == "false") {
    alert("You are not logged in")
} else if (get("success") == "false") {
    alert("An error occurred while trying to save the joke")
} else if (get("success") == "true") {
    alert("Joke was saved")
}

function get(name){
    if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
       return decodeURIComponent(name[1]);
}

 function playAudio(mp3File) {
    let audioObj = new Audio(mp3File)
    audioObj.play()
}