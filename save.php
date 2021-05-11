<?php
    require 'config/config.php';
    session_start();

    $data = file_get_contents("php://input");
    $data = json_decode($data);

    if (!isset($_SESSION["loggedIn"]) || empty($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] == false) {
        echo "0";
    } else if ($data == NULL) {
        echo "1";
    } else {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            echo $mysqli->connect_error;
        }

        $statement = $mysqli->prepare("INSERT INTO saved_jokes(joke, users_id, voices_id) VALUES (?, ?, ?)");
        $statement->bind_param("sii", $data->joke, $_SESSION["userId"], $data->voiceId);
        $executed = $statement->execute();
        if (!$executed) {
            echo $mysqli->error;
        }

        if ($mysqli->affected_rows == 1) {
			echo "2";
		} else {
			echo "1";
		}

        $mysqli->close();
    }

?>