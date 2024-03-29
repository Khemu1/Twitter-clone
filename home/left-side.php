<?php
// require_once("/laragon/www/twitter/config/setup.php");

if (isset($_POST["logout"])) {
  session_destroy();
  header("location:../form/login.php");
  exit;
}
?>


<link rel="stylesheet" href="../assets\css\home-left-side.css">

<body>

  <div class="left-side">
    <div class="bird">
      <a href="home.php">
        <img src="../assets\icons\Logo_of_Twitter.svg.webp">
      </a>
    </div>

    <div class="buttons">
      <div class="button">
        <a href="home.php">
          <div class="img">
            <img src="../assets\icons\home.png">
          </div>
          <span>home</span>
        </a>
      </div>

      <div class="button">
        <a href="home.php">
          <div class="img">
            <img src="../assets\icons\loupe.png">
          </div>
          <span>explore</span>
        </a>
      </div>

      <div class="button">
        <a href="home.php">
          <div class="img">
            <img src="../assets\icons\notification.png">
          </div>
          <span>notifications</span>
        </a>
      </div>

      <div class="button">
        <a href="home.php">
          <div class="img">
            <img src="../assets\icons\email.png">
          </div>
          <span>messages</span>
        </a>
      </div>

      <div class="button">
        <a href="home.php">
          <div class="img">
            <img src="../assets\icons\bookmark.png">
          </div>
          <span>bookmarks</span>
        </a>
      </div>

      <div class="button">
        <a href="home.php">
          <div class="img">
            <img src="../assets\icons\list.png">
          </div>
          <span>lists</span>
        </a>
      </div>

      <div class="button">
        <a href="home.php">
          <div class="img">
            <img src="../assets\icons\user.png">
          </div>
          <span>profile</span>
        </a>
      </div>

      <div class="button">
        <a href="home.php">
          <div class="img">
            <img src="../assets\icons\category.png">
          </div>
          <span>more</span>
        </a>
      </div>
    </div>

    <button class="tweet">tweet</button>
    <form method="POST">
      <button class="tweet logout" name="logout">Logout</button>
    </form>

  </div>

</body>