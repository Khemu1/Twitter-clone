<?php
require_once("/laragon/www/twitter/config/setup.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets\css\home.css">
  <title>Home</title>
</head>

<body>
  <div class="page">
    <?php
    include("left-side.php");
    include("mid-side.php");
    include("right-side.php");
    ?>
  </div>
</body>

</html>