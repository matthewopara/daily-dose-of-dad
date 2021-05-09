<?php
    require 'config/config.php';
    session_start();

    $data = file_get_contents("php://input");
    $data = json_decode($data);
    // take $data and update the jokes in the database

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }

    for ($i = 0; $i < count($data); $i++) {
        // var_dump($data[$i]);
        $newJoke = $data[$i]->joke;
        $jokeId = $data[$i]->jokeId;

        $statement = $mysqli->prepare("UPDATE saved_jokes SET joke = ? WHERE id = ?");
        $statement->bind_param("si", $newJoke, $jokeId);
        $executed = $statement->execute();
        if (!$executed) {
            echo $mysqli->error;
        }

        $filename = "jokemp3s/joke" . $jokeId . ".mp3";
        $jokemp3s = scandir("jokemp3s");
        for ($i=0; $i < count($jokemp3s); $i++) { 
            if (in_array("joke" . $jokeId . ".mp3", $jokemp3s)) {
                unlink($filename);
                break;
            }
        }
    }

    $mysqli->close();
?>