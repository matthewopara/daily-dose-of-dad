let button = document.querySelector("#next-action-btn-div")
button = button.firstElementChild
console.log(button)

button.onclick = function() {
    if (button.classList.contains("btn-success")) {
        window.location.replace("login.php")
    } else {
        window.location.replace("sign_up.php")
    }
}
