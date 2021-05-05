let jokeTextDivs = document.querySelectorAll(".joke-text")
let soundButtons = document.querySelectorAll(".sound-button")

for (let i = 0; i < soundButtons.length; i++) {
    let soundButton = soundButtons[i]
    let jokeText = jokeTextDivs[i].innerText
    soundButton.addEventListener("click", function() {
        // playDadJokeAudio("Hello")

        let httpRequest = new XMLHttpRequest()
        httpRequest.open("GET", "text_to_speech.php?joke=Funny")
        // httpRequest.open("GET", "text_to_speech.php?joke=" + encodeURIComponent(jokeText))
        httpRequest.send()

        httpRequest.onreadystatechange = function() {
            console.log(httpRequest.readyState)
    
            // readyState == 4 when we have a full response
            if (httpRequest.readyState == 4) {
                // check for errors
                if (httpRequest.status == 200) {
                    // 200 means successful
                    playAudio(httpRequest.responseText)
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