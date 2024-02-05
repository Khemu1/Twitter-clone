<?php
require_once("/laragon/www/twitter/config/setup.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets\css\home-mid-side.css">
  <title>Document</title>
</head>

<body>
  <div class="mid-side">
    <header>
      <span>
        <?= $_SESSION["name"] ?>
      </span>
      <div class="img">
        <img src="../assets/icons/star.png">
      </div>
    </header>
    <div class="tweet-area">
      <div class="user-icon">
        <img src="../assets\icons\user.png" alt="">
      </div>
      <form method="POST">
        <div class="tweet-submit-area">
          <div class="tweet-field">
            <textarea name="tweet" placeholder="What's happening?" required></textarea>
          </div>
          <div class="tweet-buttons">

            <div class="tweet-icons">
              <div class="tweet-icon">
                <button class="upload">
                  <img src="../assets\icons\gallery.png" alt="">
                  <input type="file">
                </button>
              </div>

              <div class="tweet-icon">
                <img src="../assets\icons\gif.png" alt="">
              </div>

              <div class="tweet-icon">
                <img src="../assets\icons\bar-chart.png" alt="">
              </div>

              <div class="tweet-icon">
                <img src="../assets\icons\happiness.png" alt="">
              </div>

            </div>
            <button name="submit" class="post-tweet">tweet</button>
          </div>

        </div>
      </form>
    </div>
  </div>
</body>

</html>