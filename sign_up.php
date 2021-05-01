<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/default.css">
    <link rel="stylesheet" href="styles/form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Sign Up</title>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div id="background">
        <h1 id="sign-up"><strong>Sign Up</strong></h1>
        <form id="form" action="sign_up_confirmation.php" method="POST">
            <label for="user" class="form-label">Username:</label><br>
            <input type="text" class="form-control" id="user" name="user"></input>
            <small id="user-error" class="invalid hidden">Invalid Username</small><br>

            <label for="pass" class="form-label">Password:</label><br>
            <input type="password" class="form-control" id="pass" name="pass"></input>
            <small id="pass-error" class="invalid hidden">Invalid Password</small><br>

            <label for="confirm-pass" class="form-label">Confirm Password:</label><br>
            <input type="password" class="form-control" id="confirm-pass"></input>
            <small id="confirm-pass-error" class="invalid hidden">Passwords Don't Match</small><br>

            <input id="submit-button" type="submit" class="btn btn-dark"></input><br>
        </form>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="scripts/navbar.js"></script>
    <script>
        document.querySelector("#form").onsubmit = function(event) {
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

            return document.querySelectorAll('.hidden').length == 3;
        }
    </script>
</body>
</html>