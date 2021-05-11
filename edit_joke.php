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
        $newJoke = $data[$i]->joke;
        $jokeId = $data[$i]->jokeId;

        $statement = $mysqli->prepare("UPDATE saved_jokes SET joke = ? WHERE id = ?");
        $statement->bind_param("si", $newJoke, $jokeId);
        $executed = $statement->execute();
        if (!$executed) {
            echo $mysqli->error;
        }

        $jokeMp3 = getJokeMp3($jokeId);
        if ($jokeMp3 != "0") {
            unlink($jokeMp3);
        }
    }

    function getJokeMp3($jokeId) {
        $jokemp3s = scandir("jokemp3s");
        $substring = "joke" . $jokeId . "v=";
        for ($i=0; $i < count($jokemp3s); $i++) {
            if (strpos($jokemp3s[$i], $substring) !== false) {
                return "jokemp3s/" . $jokemp3s[$i];
            }
        }
        return "0";
    }

    $mysqli->close();
?>