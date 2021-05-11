<?php
    require 'config/config.php';

    $data = file_get_contents("php://input");
    $data = json_decode($data);

    if ($data == NULL) {
        $data = new class {
            public $error = true;
            public $message = "No username or password given. Please try again";
        };
        $response = json_encode($data);
        echo $response;
        exit();
    } else {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            unknownError();
        }

        $password = hash("sha256", $data->pass);

        $statement = $mysqli->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $statement->bind_param("ss", $data->user, $password);
        $executed = $statement->execute();
		if (!$executed) {
			unknownError();
		}

        $result = $statement->get_result();

        if ($result->num_rows == 1) {
            session_start();
            $_SESSION["loggedIn"] = true;
            $_SESSION["username"] = $data->user;
            $_SESSION["userId"] = $result->fetch_assoc()["id"];
            
            $data = new class {
                public $error = false;
                public $message = "Logged in successfully";
            };
            $response = json_encode($data);
            echo $response;
            exit();
        } else {
            $data = new class {
                public $error = true;
                public $message = "Incorrect username or password";
            };
            $response = json_encode($data);
            echo $response;
            exit();
        }
    }

    $mysqli->close();

    
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