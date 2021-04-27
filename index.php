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
          <div class="col-md-6">
            <div id="dad-image-container">
              <img id="new-dad-image" src="images/dads&moms/dad2.jpg" />
              <img id="dad-image" src="images/dads&moms/dad1.jpg" />
            </div>
            
          </div>
          <div class="col-md-6">
            <div id="stuff">
              <div class="input-rows">
                <div id="input-title">
                  <strong>Dad Joke Text</strong>
                </div>
                <div contenteditable="true" id="dad-joke-box"></div>
              </div>
              <div class="input-rows">
                <div class="row">
                  <div class="col-2">
                    <input id="sound-button" type="image" src="images/icon_volume.png" />
                  </div>
                  <div class="col-10">
                    <div id="input-title">
                      <strong>Voices</strong>
                    </div>
                    <select id="voices-select">
                      <option value="0">Henry</option>
                      <option value="1">Kevin</option>
                      <option value="2">Michael</option>
                      <option value="3">Allison</option>
                      <option value="4">Olivia</option>
                      <option value="5">Emily</option>
                    </select>
                  </div>
                    
                  
                </div>
                
              </div>
              <div class="input-rows">
                <button class="btn btn-dark save-button">Save</button>
              </div>
            </div>
              
          </div>
        </div>
      </div>
  </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
      <script src="index.js"></script>
</body>
</html>