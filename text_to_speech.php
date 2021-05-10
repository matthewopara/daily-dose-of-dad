<?php
    require 'config/config.php';

    $voices = array(
        "en-US_HenryV3Voice",
        "en-US_MichaelV3Voice",
        "en-US_KevinV3Voice",
        "en-US_OliviaV3Voice",
        "en-US_LisaV3Voice",
        "en-US_EmilyV3Voice"
    );

    $joke = $_GET["joke"];
    $jokeId = $_GET["jokeId"];
    $voiceId = $_GET["voiceId"];

    $filePrefix = "jokemp3s/joke" . $jokeId;
    $filename = "jokemp3s/joke" . $jokeId . ".mp3";

    if ($jokeId == "-1") {
        if (!isset($_GET["new"]) || empty($_GET["new"]) || $_GET["new"] != "true") {
            echo getPresavedJokeMP3();
        } else {
            $presaved = getPresavedJokeMP3();
            if ($presaved != "0") {
                unlink($presaved);
            }
            $filename = "jokemp3s/joke-" . time() . ".mp3";
            createMP3($filename, $joke, $voices[$voiceId]);
        }
    } else if (getJokeMp3($jokeId) != "0") {
        echo getJokeMp3($jokeId);
    } else {
        $file = $filePrefix . "v=" . time() . ".mp3";
        createMP3($file, $joke, $voices[$voiceId]);
    }

    function createMP3($file, $joke, $voice) {
        $url = ENDPOINT . "?voice=" . $voice;

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $headers = array(
        "Content-Type: application/json",
        "Accept: audio/mp3",
        "Authorization: Basic " . ENCODED_API_KEY,
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        
        $data = '{"text":"' . $joke . '"}';
        
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $resp = curl_exec($curl);
        curl_close($curl);

        $jokemp3s = scandir("jokemp3s");
        // minus 2 to ignore "." and ".."
        if (count($jokemp3s) - 2 >= 30) {
            unlink("jokemp3s/" . $jokemp3s[2]);
        } 
        $myfile = fopen($file, "w");
        fwrite($myfile, $resp);
        fclose($myfile);
        echo $file;
    }

    function getPresavedJokeMP3() {
        $jokemp3s = scandir("jokemp3s");
        for ($i=0; $i < count($jokemp3s); $i++) { 
            if (substr($jokemp3s[$i], 4, 1) == '-') {
                return "jokemp3s/" . $jokemp3s[$i];
            }
        }
        return "0";
    }

    function getJokeMp3($jokeId) {
        $jokemp3s = scandir("jokemp3s");
        $substring = "joke" . $jokeId . "v=";
        for ($i=0; $i < count($jokemp3s); $i++) {
            // $vPos = strpos($jokemp3s[$i], 'v')
            if (strpos($jokemp3s[$i], $substring) !== false) {
                return "jokemp3s/" . $jokemp3s[$i];
            }
        }
        return "0";
    }

    
?>