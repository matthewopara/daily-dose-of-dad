<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:;base64,=">
    <link rel="stylesheet" href="styles/default.css">
    <link rel="stylesheet" href="styles/form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div id="background">
        <h1 id="sign-up"><strong>Login</strong></h1>
        <form id="form">
            <label for="user" class="form-label">Username:</label><br>
            <input type="text" class="form-control" id="user" name="user"></input>
            <small id="userError" class="invalid hidden">No username given</small><br>

            <label for="pass" class="form-label">Password:</label><br>
            <input type="password" class="form-control" id="pass" name="pass"></input>
            <small id="passError" class="invalid hidden">No password given</small><br>
        </form>

        <div id="submit-div">
            <button id="submit-button" class="btn btn-dark">Log In</button>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="scripts/navbar.js"></script>
    <script src="scripts/login.js"></script>
</body>
</html>