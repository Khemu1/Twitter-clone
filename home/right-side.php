<?php
require_once("/laragon/www/twitter/config/setup.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets\css\home-right-side.css">
  <title>Document</title>
</head>

<body>
  <div class="right-side">
    <div class="container">
      <form action="POST">
        <input type="text" name="accounts" placeholder="search for users">
      </form>
      <div class="accounts-area">
        <div class="account">
          <div class="account-icon">
            <img src="../assets\icons\user.png" alt="">
          </div>
          <div class="account-info">
            <div class="account-name">Name</div>
            <div class="account-posts">Num</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>