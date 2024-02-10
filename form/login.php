<?php
require_once("/laragon/www/twitter/config/setup.php");
require_once("/laragon/www/twitter/classes/Account.php");
session_start();



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $password = $_POST["password"];

  $accounts = Account::select(["name", "pass", "id"], ["name" => $name, "pass" => $password]);
  if (count($accounts) > 0) {
    $Dbname = $accounts[0]["name"];
    $Dbpassword = $accounts[0]["pass"];
    $id = $accounts[0]["id"];
    echo $id;
  }

  if (!empty($accounts) && $Dbname === $name && $Dbpassword === $password) {
    echo "Logged in";
    $_SESSION["login_id"] = $id;
    $_SESSION["name"] = $Dbname;
    header("location: ../home\home.php");
  } else {
    echo "Invalid credentials";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets\css\login.css">
  <title>Login</title>
</head>

<body>
  <form method="POST">
    <div class="inputs">
      <input name="name" type="text" placeholder="Name" required>
      <input name="password" type="password" placeholder="Password" required>
    </div>
    <button name="login">Login</button>
    <a href="register.php">Don't have an account?</a>
  </form>
</body>

</html>