let jokeTextDivs = document.querySelectorAll(".joke-text")
let soundButtons = document.querySelectorAll(".sound-button")
let jokeInfos = document.querySelectorAll(".joke-info")

let editButton = document.querySelector("#edit")
let editDiv = document.querySelector("#edit-div")
let cancelButton = document.querySelector("#cancel")
let cancelDiv = document.querySelector("#cancel-div")

let deleteButtons = document.querySelectorAll(".delete-button")

let originalJokes = [];

setUp()


function DadJoke(joke, index) {
    this.originalJoke = joke
    this.changed = false
    this.index = index
}



function DadJokeEdit(jokeId, joke) {
    this.jokeId = jokeId
    this.joke = joke
}

let saveButton = document.querySelector("#save")
saveButton.addEventListener("click", function() {
    document.querySelector("#save-div").classList.add("hidden")
    switchToDefaultMode()
    let changedJokes = []
    for (let i = 0; i < originalJokes.length; i++) {
        if (originalJokes[i].changed) {
            changedJokes.push(new DadJokeEdit(soundButtons[i].dataset.jokeid, jokeTextDivs[i].innerText))
            originalJokes[i].originalJoke = jokeTextDivs[i].innerText
            // changedJokes.push(dadJoke)
        }
    }

    let data = JSON.stringify(changedJokes)
    let httpRequest = new XMLHttpRequest()
    httpRequest.open("POST", "edit_joke.php")
    httpRequest.setRequestHeader("Content-Type", "application/json")
    httpRequest.send(data)

    httpRequest.onreadystatechange = function() {

        // readyState == 4 when we have a full response
        if (httpRequest.readyState == 4) {
            // check for errors
            if (httpRequest.status == 200) {
                // 200 means successful
                alert("Edits were saved")

                // set original jokes array to current jokes
            } else {
                console.log("Error")
                console.log(httpRequest.status)
            }
        }
    }
})


editButton.addEventListener("click", function() {
    switchToEditMode()
})

cancelButton.addEventListener("click", function() {

    switchToDefaultMode()
    removeUnsavedEdits()

})



function setUp() {
    originalJokes = []
    for (let i = 0; i < soundButtons.length; i++) {
        let soundButton = soundButtons[i]
        soundButton.onclick = function() {
            // playDadJokeAudio("Hello")
            shakeInterval = setInterval(shake, 10, soundButtons[i])
            let jokeText = jokeTextDivs[i].innerText

            let data = {
                joke: jokeText,
                jokeId: soundButton.dataset.jokeid,
                voiceId: soundButton.dataset.voice,
                hasNewVar: "false"
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
            // // httpRequest.open("GET", "text_to_speech.php?joke=Funny&jokeId=" + soundButton.dataset.jokeid + "&voiceId=" + soundButton.dataset.voice)
            // httpRequest.open("GET", "text_to_speech.php?joke=" + encodeURIComponent(jokeText) +  "&jokeId=" + soundButton.dataset.jokeid + "&voiceId=" + soundButton.dataset.voice)
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
        }
    }

    for (let i = 0; i < jokeTextDivs.length; i++) {
        originalJokes.push(new DadJoke(jokeTextDivs[i].innerText, i))
        jokeTextDivs[i].onkeyup = function(event) {
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
        }
    }

    for (let i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].onclick = function() {
            if (confirm("Are you sure you want to delete this joke?")) {
                let deleteRequest = new XMLHttpRequest()
                let data = {
                    jokeId: soundButtons[i].dataset.jokeid
                }
    
                deleteRequest.open("POST", "delete.php")
                deleteRequest.setRequestHeader("Content-Type", "application/json")
                deleteRequest.send(JSON.stringify(data))
    
                deleteRequest.onreadystatechange = function() {
                    // console.log(deleteRequest.readyState)
    
                    // readyState == 4 when we have a full response
                    if (deleteRequest.readyState == 4) {
                        // check for errors
                        if (deleteRequest.status == 200) {
                            // 200 means successful
                            if (deleteRequest.responseText == "1") {
                                removeUnsavedEdits()
                                switchToDefaultMode()
                                document.querySelector("#container-row").removeChild(jokeInfos[i])
                                resetJokeArrays()
                                setUp()
                                alert("Joke was deleted.")
                            } else {
                                alert("An error occurred.")
                            }
    
                            // set original jokes array to current jokes
                        } else {
                            console.log("Error")
                            console.log(deleteRequest.status)
                        }
                    }
                }
            }
        }
    }
}

let iteration = 0
let increasing = true
let currentRotation = 0
function shake(soundBtn) {
    soundBtn.disabled = true
    if (iteration == 7) {
        clearInterval(shakeInterval)
        soundBtn.style.transform = "rotate(0deg)"
        iteration = 0
        increasing = true
        currentRotation = 0
        soundBtn.disabled = false
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
        soundBtn.style.transform = "rotate(" + rotate + "deg)"
    }
}

function resetJokeArrays() {
    jokeTextDivs = document.querySelectorAll(".joke-text")
    soundButtons = document.querySelectorAll(".sound-button")
    jokeInfos = document.querySelectorAll(".joke-info")
    deleteButtons = document.querySelectorAll(".delete-button")
}

function removeUnsavedEdits() {
    for (let i = 0; i < jokeTextDivs.length; i++) {
        jokeTextDivs[i].innerText = originalJokes[i].originalJoke
        originalJokes[i].changed = false
    }
}

function switchToDefaultMode() {
    document.querySelector("#save-div").classList.add("hidden")
    let jokes = document.querySelectorAll(".joke-text")
    jokes.forEach(jokeDiv => {
        // jokeDiv.style.borderSize = "5px"
        jokeDiv.style.border = ""
        jokeDiv.setAttribute("contenteditable", "false")
    })

    cancelDiv.classList.add("hidden")
    editDiv.classList.remove("hidden")

    deleteButtons.forEach(btn => {
        btn.classList.add("hidden")
    })

    soundButtons.forEach(btn => {
        btn.classList.remove("hidden")
    })
}

function switchToEditMode() {
    let jokes = document.querySelectorAll(".joke-text")
    jokes.forEach(jokeDiv => {
        // jokeDiv.style.borderSize = "5px"
        jokeDiv.style.border = "2px solid black"
        jokeDiv.setAttribute("contenteditable", "true")
    })

    editDiv.classList.add("hidden")
    cancelDiv.classList.remove("hidden")

    soundButtons.forEach(btn => {
        btn.classList.add("hidden")
    })

    deleteButtons.forEach(btn => {
        btn.classList.remove("hidden")
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