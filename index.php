<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/default.css">
    <link rel="stylesheet" href="styles/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Dad Jokes</title>
</head>
<body>
  <div id="background">
      <?php include 'navbar.php'; ?>
      <div class="content container">
        <div class="row">
          <div class="col-12 col-md-6">
            <div id="dad-image-container">
              <input id="dad-image" type="image" src="images/dads&moms/dad1.jpg" />
            </div>
          </div>
          <div class="col">
            <div id="stuff">
              <div class="input-rows">
                Dad Joke Text
                <div id="dad-joke-box">
                  
                </div>
              </div>
              <div class="input-rows">
                Voices
                <select id="voices-select">
                  <option value="dad1">Dad #1</option>
                  <option value="dad2">Dad #2</option>
                  <option value="dad3">Dad #3</option>
                  <option value="mom1">Mom #1</option>
                  <option value="mom2">Mom #2</option>
                  <option value="mom3">Mom #3</option>
                </select>
              </div>
              <div class="input-rows">
                <button class="btn btn-primary save-button">Save</button>
              </div>
            </div>
              
          </div>
        </div>
      </div>
  </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>