let jokeTextDivs = document.querySelectorAll(".joke-text")
let soundButtons = document.querySelectorAll(".sound-button")

for (let i = 0; i < soundButtons.length; i++) {
    let soundButton = soundButtons[i]
    let jokeText = jokeTextDivs[i].innerText
    soundButton.addEventListener("click", function() {
        // playDadJokeAudio("Hello")

        let httpRequest = new XMLHttpRequest()
        console.log(soundButton.dataset.voice)
        console.log(soundButton.dataset.jokeid)
        // httpRequest.open("GET", "text_to_speech.php?joke=Funny&jokeId=" + soundButton.dataset.jokeid + "&voiceId=" + soundButton.dataset.voice)
        httpRequest.open("GET", "text_to_speech.php?joke=" + encodeURIComponent(jokeText) +  "&jokeId=" + soundButton.dataset.jokeid + "&voiceId=" + soundButton.dataset.voice)
        httpRequest.send()

        httpRequest.onreadystatechange = function() {
            console.log(httpRequest.readyState)
    
            // readyState == 4 when we have a full response
            if (httpRequest.readyState == 4) {
                // check for errors
                if (httpRequest.status == 200) {
                    // 200 means successful
                    playAudio(httpRequest.responseText)
                    // console.log(httpRequest.responseText)
                } else {
                    console.log("Error")
                    console.log(httpRequest.status)
                }
            }
        }
        return false
    })
}

function playAudio(mp3File) {
    let audioObj = new Audio(mp3File)
    audioObj.play()
}

function displayJoke(responseText) {
    let jokeBox = document.querySelector("#dad-joke-box")
    let results = JSON.parse(responseText)
    jokeBox.innerHTML =  results.joke
}