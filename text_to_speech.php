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

    $filename = "jokemp3s/joke" . $jokeId . ".mp3";

    if (file_exists($filename)) {
        echo $filename;
    } else {
        $url = ENDPOINT . "?voice=" . $voices[$voiceId];

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
        $myfile = fopen($filename, "w");
        fwrite($myfile, $resp);
        fclose($myfile);
        echo $filename;
    }

    
?>