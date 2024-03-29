<?php
require_once("/laragon/www/twitter/config/setup.php");
require_once("../classes/Utils.php");

session_start();
$posts = Utils::selectAllPosts();

if (isset($_POST["like"])) {
  Utils::like($_POST["post_id"], $_POST["poster_id"], $_SESSION["login_id"]);
}
if (isset($_POST["follow"])) {
  Utils::follow($_POST["poster_id"], $_SESSION["login_id"]);
}

if (isset($_POST["post-tweet"])) {
  $file_name = $_FILES['tweet-img']['name'];
  $temp_name = $_FILES['tweet-img']['tmp_name'];
  $folder = 'C:/aragon/www/twitter/assets/images/' . $file_name;
  if (move_uploaded_file($temp_name, $folder)) {
    Utils::postTweet([
      "userId" => $_SESSION["login_id"],
      "text" => $_POST["tweet"],
      "img" => $file_name
    ]);
  }
}
if (isset($_POST["upload-img-button"])) {
  echo "upload-button clicked";
}
if (isset($_POST["delete"])) {
  Utils::deletePost($_POST["delete"]);
}
if (isset($_POST["go"]) || isset($_POST["comment"])) {
  header("location:comments.php?post_id={$_POST["post_id"]}&&poster_id={$_POST["poster_id"]}");
}
if (isset($_POST["edit"])) {
  header("location:editPage.php?post_id={$_POST["post_id"]}");
}

?>

<head>
  <link rel="stylesheet" href="../assets\css\home-mid-side.css">
  <link rel="stylesheet" href="/form/login.php">

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
      <form method="POST" enctype="multipart/form-data" action="home.php">
        <div class="tweet-submit-area">
          <div class="tweet-field">
            <textarea name="tweet" placeholder="What's happening?"></textarea>
          </div>
          <div class="tweet-buttons">

            <div class="tweet-icons">
              <div class="tweet-icon">
                <button class="upload" name="upload-img-button">
                  <img src="../assets/icons/gallery.png" alt="">
                  <input type="file" name="tweet-img">
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
            <button name="post-tweet" class="post-tweet">tweet</button>
          </div>

        </div>
      </form>
    </div>
    <div class="posts">

      <?php
      if (count($posts) > 0) {
        foreach ($posts as $post) {
          ?>
          <div class="post">
            <form method="POST">
              <input type="hidden" name="post_id" value=<?= $post["post_id"] ?>>
              <input type="hidden" name="poster_id" value=<?= $post["poster_id"] ?>>
              <input type="hidden" name="poster_name" value=<?= $post["name"] ?>>
              <input type="hidden" name="post_text" value=<?= $post["text"] ?>>
              <input type="hidden" name="post_img" value=<?= $post["img"] ?>>
              <div name="go" class="go">
                <div class="user-img">
                  <div class="left">
                    <img src="../assets\icons\user.png" alt="">
                    <div class="post-writer" name="post-writer">
                      <?= $post["name"] ?>
                    </div>
                    <?php if ($_SESSION["login_id"] != $post["poster_id"]) { ?>
                      <button
                        class="<?= Utils::is_follower($post["poster_id"], $_SESSION["login_id"]) ? "followed" : "follow" ?>"
                        name="follow">
                        <?= Utils::is_follower($post["poster_id"], $_SESSION["login_id"]) ? "Unfollow" : "Follow" ?>
                      </button>
                    <?php } ?>
                  </div>
                  <?php if ($_SESSION["login_id"] === $post["poster_id"]) { ?>
                    <form method="POST">
                      <ul class="drop-down">
                        <!-- <img src="../assets/icons/down-arrow.png"> -->
                        <ul>
                          <li><button name="edit">Edit</button></li>
                          <li><button name="delete">Delete</button></li>
                        </ul>
                      </ul>
                    </form>
                  <?php } ?>



                </div>
                <div class="writer-post">
                  <a class="a-post"
                    href="comments.php?post_id=<?= $post["post_id"] ?>&&poster_id=<?= $post["poster_id"] ?>">
                    <span class="text" name="text" value="<?= $post["text"] ?>">
                      <?= $post["text"] ?>
                    </span>
                    <?php if (!empty(trim($post["img"]))) { ?>
                      <img src="../assets/images/<?= $post["img"] ?>" alt="" name=post="img">
                    <?php } ?>
                  </a>
                </div>
              </div>
              <div class="post-buttons">

                <button class="post-button" name="comment">
                  <img src="../assets\icons\chat-bubble.png" alt="">
                  <?php
                  if (Utils::comments_num($post["post_id"])) { ?>
                    <span>
                      <?= Utils::comments_num($post["post_id"]) ?>
                    </span>
                  <?php }
                  ?>
                </button>

                <button class="post-button">
                  <img src="../assets\icons\repost.png" alt="">
                </button>
                <button class="<?= Utils::is_liker($_SESSION["login_id"], $post["post_id"]) > 0 ? "like" : "post-button" ?>"
                  name="like">
                  <img src="../assets/icons/heart.png" alt="">
                  <?php if (Utils::returnLikes($post["post_id"]) > 0) { ?>
                    <span>
                      <?= Utils::returnLikes($post["post_id"]) ?>
                    </span>
                  <?php } ?>
                </button>
                <button class="post-button">
                  <img src="../assets\icons\upload.png" alt="">
                </button>
              </div>
            </form>
          </div>

        <?php }
      } ?>

    </div>
  </div>
</body>