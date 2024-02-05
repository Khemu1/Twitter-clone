<?php
require_once("/laragon/www/twitter/config/setup.php");
require_once("/laragon/www/twitter/classes/Account.php");
session_start();



// if you want to compare values of the $_POST or $_GET save the value into an attribute

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"], $_POST["password"])) {
  $name = $_POST["name"];
  $password = $_POST["password"];


  $accounts = Account::select(["name"], ["name" => $name]);

  if (!empty($accounts) && $accounts[0]["name"] === $name) {
    echo "this name is already taken";
  } else {
    if (!empty($name) && !empty($password)) {
      Account::insert(["name" => $name, "pass" => $password]);
      echo "Account created";

      $account = Account::select(["name", "id"], ["name" => $name, "pass" => $password]);

      $dbId = $account[0]["id"];
      $_SESSION["id"] = $dbId;
      $_SESSION["name"] = $_POST["name"];

      header("location: ../home/home.php");

    }
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/login.css">
  <title>Register</title>
</head>

<body>
  <form method="POST">
    <div class="inputs">
      <input name="name" type="text" placeholder="Name" required>
      <input name="password" type="password" placeholder="Password" required>
    </div>
    <button name="register">Register</button>
    <a href="login.php">Have an account ?</a>

  </form>
</body>

</html>