<?php

    $data = file_get_contents("php://input");
    $data = json_decode($data);

    // take $data and update the jokes in the database

?>