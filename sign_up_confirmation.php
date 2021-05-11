<?php

    require 'config/config.php';

    $data = file_get_contents("php://input");
    $data = json_decode($data);

    if ($data == NULL) {
        $data = new class {
            public $error = true;
            public $message = "No username or password. Please try again";
        };
        $response = json_encode($data);
        echo $response;
    } else {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            unknownError();
        }

        $statement = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
        $statement->bind_param("s", $data->user);
        $executed = $statement->execute();
        if (!$executed) {
            unknownError();
        }

        if ($statement->get_result()->num_rows > 0) {
            $data = new class {
                public $error = true;
                public $message = "Username is already taken. Please try again.";
            };
            $response = json_encode($data);
            echo $response;

        } else {
            $password = hash("sha256", $data->pass);
            
            $statement = $mysqli->prepare("INSERT INTO users(username, password) VALUES (?, ?)");
            $statement->bind_param("ss", $data->user, $password);
            $executed = $statement->execute();
            if (!$executed) {
                unknownError();
            } else {
                $data = new class {
                    public $error = false;
                    public $message = "Sign up was successful";
                };
                $response = json_encode($data);
                echo $response;
            }
        }

        $mysqli->close();
    }


    function unknownError() {
        $data = new class {
            public $error = true;
            public $message = "Something went wrong";
        };
        $response = json_encode($data);
        echo $response;
        exit();
    }

?>