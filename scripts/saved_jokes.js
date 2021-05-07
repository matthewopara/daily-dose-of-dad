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

function DadJoke(joke, index) {
    this.originalJoke = joke
    this.changed = false
    this.index = index
}
let originalJokes = [];
for (let i = 0; i < jokeTextDivs.length; i++) {
    originalJokes.push(new DadJoke(jokeTextDivs[i].innerText, i))
    jokeTextDivs[i].addEventListener("keyup", function(event) {
        if (originalJokes[i].originalJoke != jokeTextDivs[i].innerText) {
            originalJokes[i].changed = true
        } else {
            originalJokes[i].changed = false
        }

        let updated = originalJokes.some((dadJoke) => dadJoke.changed)
        if (updated) {
            document.querySelector("#save-div").classList.remove("hidden")
        } else {
            document.querySelector("#save-div").classList.add("hidden")
        }
    });
}

function DadJokeEdit(jokeId, joke) {
    this.jokeId = jokeId
    this.joke = joke
}

document.querySelector("#save-div").addEventListener("click", function() {
    let changedJokes = []
    for (let i = 0; i < originalJokes.length; i++) {
        if (originalJokes[i].changed) {
            changedJokes.push(new DadJokeEdit(soundButtons[i].dataset.jokeid, jokeTextDivs[i].innerText))
            // changedJokes.push(dadJoke)
        }
    }

    let data = JSON.stringify(changedJokes)
    let httpRequest = new XMLHttpRequest()
    httpRequest.open("POST", "edit_joke.php")
    httpRequest.setRequestHeader("Content-Type", "application/json")
    httpRequest.send(data)

    httpRequest.onreadystatechange = function() {
        console.log(httpRequest.readyState)

        // readyState == 4 when we have a full response
        if (httpRequest.readyState == 4) {
            // check for errors
            if (httpRequest.status == 200) {
                // 200 means successful
                console.log(httpRequest.responseText)
            } else {
                console.log("Error")
                console.log(httpRequest.status)
            }
        }
    }
})

function playAudio(mp3File) {
    let audioObj = new Audio(mp3File)
    audioObj.play()
}

function displayJoke(responseText) {
    let jokeBox = document.querySelector("#dad-joke-box")
    let results = JSON.parse(responseText)
    jokeBox.innerHTML =  results.joke
}