<?php
    require 'config/config.php';

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }
    // echo "Delete"
    $data = file_get_contents("php://input");
    $data = json_decode($data);
    // echo $data->jokeId

    $statement = $mysqli->prepare("DELETE FROM saved_jokes WHERE id = ?");
    $statement->bind_param("i", $data->jokeId);
    $executed = $statement->execute();
    if (!$executed) {
        echo $mysqli->error;
    }

    // $results = $statement->get_result();

    if ($mysqli->affected_rows == 1) {
        $filename = "jokemp3s/joke" . $data->jokeId . ".mp3";
        $jokemp3s = scandir("jokemp3s");
        for ($i=0; $i < count($jokemp3s); $i++) { 
            if (in_array("joke" . $data->jokeId . ".mp3", $jokemp3s)) {
                unlink($filename);
                break;
            }
        }

        echo "1";
        exit();
    } else {
        echo "0";
        exit();
    }

    $mysqli->close();
?>