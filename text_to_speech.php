<?php
    require 'config/config.php';

    $joke = $_GET["joke"];
    $url = ENDPOINT;

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

    $myfile = fopen("joke.mp3", "w");
    fwrite($myfile, $resp);
    fclose($myfile);
    echo "joke.mp3";
?>