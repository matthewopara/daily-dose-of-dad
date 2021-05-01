let httpRequest = new XMLHttpRequest()
let endpoint = "https://icanhazdadjoke.com/"

let generateBtn = document.querySelector("#generate-button")
generateBtn.onclick = function() {
    httpRequest.open("GET", endpoint)
    httpRequest.setRequestHeader("Accept", "application/json")
    httpRequest.send()

    httpRequest.onreadystatechange = function() {
        console.log(httpRequest.readyState)

        // readyState == 4 when we have a full response
        if (httpRequest.readyState == 4) {
            // check for errors
            if (httpRequest.status == 200) {
                // 200 means successful
                displayJoke(httpRequest.responseText)
            } else {
                console.log("Error")
                console.log(httpRequest.status)
            }
        }
    }
}

function displayJoke(responseText) {
    let jokeBox = document.querySelector("#dad-joke-box")
    let results = JSON.parse(responseText)
    jokeBox.innerHTML =  results.joke
}