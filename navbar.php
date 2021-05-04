<?php
  session_start();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background-color: #bad7f2;">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Daily Dose of Dad</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link dest" href="index.php">Dad Jokes</a>
        <a class="nav-link dest" href="saved_jokes.php">Saved Jokes</a>
        <div class="dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php 
              if (isset($_SESSION["loggedIn"]) && !empty($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
                echo $_SESSION["username"];
              } else {
                echo "Account";
              }
            ?>
          </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <?php if (isset($_SESSION["loggedIn"]) && !empty($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]): ?>
                <li><a class="dropdown-item dest" href="logout.php">Logout</a></li>
              <?php else: ?>
                <li><a class="dropdown-item dest" href="login.php">Login</a></li>
                <li><a class="dropdown-item dest" href="sign_up.php">Sign Up</a></li>
              <?php endif; ?>
            </ul>
        </div>
      </div>
    </div>
  </div>
</nav>