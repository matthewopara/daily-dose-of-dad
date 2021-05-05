<?php
    require 'config/config.php';
    session_start();

    if (!isset($_SESSION["loggedIn"]) || empty($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] == false) {
        header("Location: index.php?success=false&loggedIn=false");
        exit();
    } else if (!isset($_POST['joke']) || empty($_POST['joke']) || !isset($_POST['voice-id'])) {
        header("Location: index.php?success=false");
        exit();
    } else {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            echo $mysqli->connect_error;
            exit();
        }

        $statement = $mysqli->prepare("INSERT INTO saved_jokes(joke, users_id, voices_id) VALUES (?, ?, ?)");
        $statement->bind_param("sii", $_POST["joke"], $_SESSION["userId"], $_POST["voice-id"]);
        $executed = $statement->execute();
        if (!$executed) {
            echo $mysqli->error;
        }

        if ($mysqli->affected_rows == 1) {
			header("Location: index.php?success=true");
            exit();
		} else {
			header("Location: index.php?success=false");
            exit();
		}


        $mysqli.close();
    }

?>