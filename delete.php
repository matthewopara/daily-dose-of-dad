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
        $jokeMp3 = getJokeMp3($data->jokeId);
        if ($jokeMp3 != "0") {
            unlink($jokeMp3);
        }

        echo "1";
        exit();
    } else {
        echo "0";
        exit();
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