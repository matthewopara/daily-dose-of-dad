document.querySelector("#submit-button").onclick = function(event) {
    let user = document.querySelector("#user")
    let userError = document.querySelector("#user-error")
    let pass = document.querySelector("#pass")
    let passError = document.querySelector("#pass-error")
    let confirmPass = document.querySelector("#confirm-pass")
    let confirmPassError = document.querySelector("#confirm-pass-error")

    if (user.value.trim().length == 0) {
        userError.classList.remove("hidden")
    } else {
        userError.classList.add("hidden")
    }

    if (pass.value.trim().length == 0) {
        passError.classList.remove("hidden");
    } else {
        passError.classList.add("hidden");
    }

    if (confirmPass.value.trim() != pass.value.trim()) {
        confirmPassError.classList.remove("hidden");
    } else {
        confirmPassError.classList.add("hidden");
    }

    if (document.querySelectorAll('.hidden').length == 3) {
        submitForm(user.value, pass.value)
    }
}

function submitForm(user, pass) {
    let data = {
        user: user,
        pass: pass
    }
    data = JSON.stringify(data)
    let httpRequest = new XMLHttpRequest()
    httpRequest.open("POST", "sign_up_confirmation.php")
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
        alert(response.message)
        window.location.replace("login.php")
    }
}