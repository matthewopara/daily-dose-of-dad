<?php
    require 'config/config.php';
    session_start();

    if (!isset($_SESSION["loggedIn"]) || empty($_SESSION["loggedIn"]) || !$_SESSION["loggedIn"]) {
        header("Location: index.php?loggedIn=false");
        exit();
    } else {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            echo $mysqli->connect_error;
            exit();
        }

        $statement = $mysqli->prepare("SELECT joke, id AS joke_id, voices_id FROM saved_jokes WHERE users_id = ?");
        $statement->bind_param("i", $_SESSION["userId"]);
        $executed = $statement->execute();
        if (!$executed) {
            echo $mysqli->error;
        }

        $results = $statement->get_result();
        $mysqli->close();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/default.css">
    <link rel="stylesheet" href="styles/savedjokes.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Saved Jokes</title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div id="background">
        <div id="save-div" class="hidden">
            <button id="save" class="btn btn-success">Save</button>
        </div>
        <div id="edit-div">
            <button id="edit" class="btn btn-dark">Edit</button>
        </div>
        <div id="cancel-div" class="hidden">
            <button id="cancel" class="btn btn-warning">Cancel</button>
        </div>
        
        <h1 id="saved-jokes"><strong>Saved Jokes</strong></h1>
        
        <div id="list" class="container">
            <div id="container-row" class="row">
                <?php while ($row = $results->fetch_assoc()) : ?>
                    <div class="joke-info col-12 col-sm-6 col-md-4">
                        <div class="row">
                            <div class="col-1 col-sm-2 col-xl-1">
                                <input class="sound-button" type="image" src="images/icon_volume.png" data-jokeid=<?php echo $row["joke_id"];?> data-voice=<?php echo $row["voices_id"];?> />
                                <input class="delete-button hidden" type="image" src="images/icon_trash.png" data-jokeid=<?php echo $row["joke_id"];?> data-voice=<?php echo $row["voices_id"];?> />
                            </div>
                            <div class="col joke-text">
                                <?php echo $row["joke"]?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="scripts/navbar.js"></script>
    <script src="scripts/saved_jokes.js"></script>
</body>
</html>