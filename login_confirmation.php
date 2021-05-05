<?php
    require 'config/config.php';

    if (!isset($_POST['user']) || empty($_POST['user'])
	|| !isset($_POST['pass']) || empty($_POST['pass'])) {
        header("Location: login.php");
        exit();
    } else {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            echo $mysqli->connect_error;
            exit();
        }

        $password = hash("sha256", $_POST["pass"]);

        $statement = $mysqli->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $statement->bind_param("ss", $_POST["user"], $password);
        $executed = $statement->execute();
		if (!$executed) {
			echo $mysqli->error;
		}

        $result = $statement->get_result();

        if ($result->num_rows == 1) {
            session_start();
            $_SESSION["loggedIn"] = true;
            $_SESSION["username"] = $_POST["user"];
            $_SESSION["userId"] = $result->fetch_assoc()["id"];
            header("Location: index.php");
            exit();
        } else {
            header("Location: login_fail.php");
            exit();
        }
    }

    $mysqli->close();
?>