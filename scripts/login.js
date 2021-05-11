document.querySelector("#submit-button").onclick = function(event) {
    let submitButton = document.querySelector("#submit-button")
    let username = document.querySelector("#user")
    let userError = document.querySelector("#userError")
    let password = document.querySelector("#pass")
    let passError = document.querySelector("#passError")

    if (username.value.trim().length == 0) {
        userError.classList.remove("hidden")
    } else {
        userError.classList.add("hidden")
    }

    if (password.value.trim().length == 0) {
        passError.classList.remove("hidden")
    } else {
        passError.classList.add("hidden")
    }

    if (document.querySelectorAll('.hidden').length == 2) {
        submitForm(username.value, password.value)
    }
}

function submitForm(user, pass) {
    let data = {
        user: user,
        pass: pass
    }
    data = JSON.stringify(data)
    let httpRequest = new XMLHttpRequest()
    httpRequest.open("POST", "login_confirmation.php")
    httpRequest.setRequestHeader("Content-Type", "application/json")
    httpRequest.send(data)

    httpRequest.onreadystatechange = function() {

        // readyState == 4 when we have a full response
        if (httpRequest.readyState == 4) {
            // check for errors
            if (httpRequest.status == 200) {
                // 200 means successful
                processResponse(httpRequest.responseText)
                // set original jokes array to current jokes
            } else {
                console.log("Error")
                console.log(httpRequest.status)
            }
        }
    }
}

function processResponse(responseText) {
    let response = JSON.parse(responseText)
    if (response.error) {
        alert(response.message)
    } else {
        window.location.replace("index.php")
    }
}