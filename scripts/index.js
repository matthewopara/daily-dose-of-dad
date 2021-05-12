let voiceSelector = document.querySelector("#voices-select")
let dadImages = ["images/dads&moms/mufasa.jpg", "images/dads&moms/homer.jpg", "images/dads&moms/mr_incredible.jpg", "images/dads&moms/elastigirl.jpg", "images/dads&moms/sarabi.jpg", "images/dads&moms/marge.jpg"]
let dadImage = document.querySelector("#dad-image")
dadImage.style.opacity = 1
let dadImageInterval = null
let newDadImage = document.querySelector("#new-dad-image")
let soundButton = document.querySelectorAll(".sound-button")[0]

voiceSelector.onchange = function() {
    newDadImage.src = dadImages[parseInt(voiceSelector.value)];
    voiceSelector.disabled = true
    dadImageInterval = setInterval(fadeDadImage, 1)
}

let dadJokeBox = document.querySelector("#dad-joke-box")
dadJokeBox.addEventListener("keyup", function(event) {
    if (dadJokeBox.innerHTML.length > 300) {
        document.querySelector("#max-char-error").classList.remove("hidden")
    } else {
        document.querySelector("#max-char-error").classList.add("hidden")
    }
});

let lastAudioText = "";
let lastAudioVoice
let shakeInterval = null
soundButton.addEventListener("click", function() {
    // let rotation = currentRotation +
    shakeInterval = setInterval(shake, 10)
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

    let data = {
        joke: dadJokeBox.innerText,
        jokeId: "-1",
        voiceId: voiceSelector.value,
        hasNewVar: "true",
        new: newJoke
    }

    data = JSON.stringify(data)
    let httpRequest = new XMLHttpRequest()
    httpRequest.open("POST", "text_to_speech.php")
    httpRequest.setRequestHeader("Content-Type", "application/json")
    httpRequest.send(data)

    httpRequest.onreadystatechange = function() {

        // readyState == 4 when we have a full response
        if (httpRequest.readyState == 4) {
            // check for errors
            if (httpRequest.status == 200) {
                // 200 means successful
                playAudio(httpRequest.responseText)
                // set original jokes array to current jokes
            } else {
                console.log("Error")
                console.log(httpRequest.status)
            }
        }
    }


    // let httpRequest = new XMLHttpRequest()

    // httpRequest.open("GET", "text_to_speech.php?joke=" + encodeURIComponent(dadJokeBox.innerText) +  "&jokeId=-1&voiceId=" + voiceSelector.value + "&new=" + newJoke)
    // httpRequest.send()

    // httpRequest.onreadystatechange = function() {
    //     // console.log(httpRequest.readyState)

    //     // readyState == 4 when we have a full response
    //     if (httpRequest.readyState == 4) {
    //         // check for errors
    //         if (httpRequest.status == 200) {
    //             // 200 means successful
    //             playAudio(httpRequest.responseText)
    //         } else {
    //             console.log("Error")
    //             console.log(httpRequest.status)
    //         }
    //     }
    // }
    return false
})

let iteration = 0
let increasing = true
let currentRotation = 0
function shake() {
    soundButton.disabled = true
    if (iteration == 7) {
        clearInterval(shakeInterval)
        soundButton.style.transform = "rotate(0deg)"
        iteration = 0
        increasing = true
        currentRotation = 0
        soundButton.disabled = false
    } else {
        if (increasing && currentRotation == 20) {
            increasing = false
        } else if (!increasing && currentRotation == 0) {
            increasing = true
            iteration++
        }

        if (increasing) {
            currentRotation += 10
        } else {
            currentRotation -= 10
        }
        
        let rotate = iteration % 2 == 0 ? -currentRotation : currentRotation
        soundButton.style.transform = "rotate(" + rotate + "deg)"
    }
}

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
        let data = {
            joke: dadJokeBox.innerText.trim(),
            voiceId: voiceSelector.value
        }
        data = JSON.stringify(data)
        let httpRequest = new XMLHttpRequest()
        httpRequest.open("POST", "save.php")
        httpRequest.setRequestHeader("Content-Type", "application/json")
        httpRequest.send(data)

        httpRequest.onreadystatechange = function() {
            // console.log(httpRequest.readyState)

            // readyState == 4 when we have a full response
            if (httpRequest.readyState == 4) {
                // check for errors
                if (httpRequest.status == 200) {
                    // 200 means successful
                    // alert("Edits were saved")
                    if (httpRequest.responseText == "0") {
                        alert("You are not logged in")
                    } else if (httpRequest.responseText == "2") {
                        alert("Joke was saved")
                    } else {
                        alert("An error occurred while trying to save the joke")
                    }
                    // set original jokes array to current jokes
                } else {
                    console.log("Error")
                    console.log(httpRequest.status)
                }
            }
        }


        // let jokeInput = document.querySelector("#joke-input")
        // let voiceInput = document.querySelector("#voice-input")
        // jokeInput.value = dadJokeBox.innerText.trim()
        // voiceInput.value = voiceSelector.value
        // form.submit()
    }
})

window.onload = function() {
    if (get("loggedIn") == "false") {
        alert("You are not logged in")
    }
}

function get(name){
    if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search)) {
        return name[1]
    }
}

 function playAudio(mp3File) {
    let audioObj = new Audio(mp3File)
    audioObj.play()
}