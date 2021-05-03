<?php

    require 'config/config.php';

    // var_dump($_POST);

    $hasError = false;
    $bigMsg = "Sign Up Successful";
    $smallMsg = "";

    if ( !isset($_POST['user']) || empty($_POST['user'])
	|| !isset($_POST['pass']) || empty($_POST['pass'])) {
        $bigMsg = "Sign Up Unsuccessful";
	    $smallMsg = "No username or password. Please try again";
        $hasError = true;
    } else {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            echo $mysqli->connect_error;
            exit();
        }

        $sql_registered = "SELECT * FROM users
        WHERE username = '" . $_POST["user"] . "'";
        // echo "<hr>" . $sql_registered . "<hr>";

        $results_registered = $mysqli->query($sql_registered);
        if (!$results_registered) {
            echo $mysqli->error;
            exit();
        }

        // var_dump($results_registered);

        if ($results_registered->num_rows > 0) {
            $bigMsg = "Sign Up Unsuccessful";
	        $smallMsg = "Username is already taken. Please try again.";
            $hasError = true;
        } else {
            // Hash the password before storing it into the db
            $password = hash("sha256", $_POST["pass"]);
            // var_dump($password);
    
            // Write SQL to insert this new user into the users table
            $sql = "INSERT INTO users(username, password) VALUES('" . $_POST["user"] . "','" . $password . "');";
            // echo "<hr>" . $sql . "<hr>";
    
            $results = $mysqli->query($sql);
            if (!$results) {
                echo $mysqli->error;
                exit();
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/default.css">
    <link rel="stylesheet" href="styles/sign_up_confirm.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Confirmation</title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div id="background">
        <?php if ($hasError) : ?> 
            <h1 id="big-msg" style="color: red;"><?php echo $bigMsg ?></h1>
        <?php else : ?>
            <h1 id="big-msg" style="color: #1a5200;"><?php echo $bigMsg ?></h1>
        <?php endif; ?>

        <?php if ($hasError) : ?> 
            <h4 id="small-msg"><?php echo $smallMsg ?></h4>
        <?php endif; ?>
        
        <div id="next-action-btn-div">
            <?php if ($hasError) : ?> 
                <button class="btn btn-secondary">Sign Up</button>
            <?php else : ?>
                <button class="btn btn-success">Login</button>
            <?php endif; ?>
                
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="scripts/navbar.js"></script>
    <script src="scripts/sign_up_confirm.js"></script>
</body>
</html>