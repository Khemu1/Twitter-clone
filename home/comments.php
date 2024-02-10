<?php
require_once("../config\setup.php");
require_once("../classes/Utils.php");
session_start();
$post = Utils::selectPost($_GET["post_id"]);
$post = $post[0];
$comments = Utils::selectComments($_GET["post_id"]);
echo count($comments);
if (!isset($_GET["post_id"])) {
  header("location:home.php");
  exit;
}

if (isset($_POST["like"])) {
  Utils::like($_GET["post_id"], $_SESSION["poster_id"], $_SESSION["login_id"], );
}

if (isset($_POST["submit"])) {
  $file_name = $_FILES["tweet-img"]["name"];
  $temp_name = $_FILES["tweet-img"]["tmp_name"];
  $folder = '../assets/images' . $file_name;
  if (move_uploaded_file($temp_name, $folder)) {
    echo "commented";
    Utils::insertComment($_SESSION["login_id"], $_GET["post_id"], $_POST["tweet"], $file_name);
  }
}


?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets\css\home-left-side.css">
  <link rel="stylesheet" href="../assets\css\home-right-side.css">
  <link rel="stylesheet" href="../assets\css\comment-page.css">
  <title>comment</title>
</head>

<body>
  <div class="post-page">
    <?php
    include("../home\left-side.php")
      ?>
    <div class="posts">
      <div class="post">
        <div name="go" class="go">
          <div class="user-img">
            <img src="../assets\icons\user.png" alt="">
            <div class="post-writer" name="post-writer">
              <?= $post["poster_name"] ?>
            </div>
          </div>
          <div class="writer-post">
            <span class="text" name="text">
              <?= $post["post_text"] ?>
            </span>
            <?php if (!empty(trim($post["post_img"]))) { ?>
              <img src="../assets/images<?= $post["post_img"] ?>" alt="" name=post="img">
            <?php } ?>
          </div>
        </div>
        <div class="post-buttons">
          <button class="post-button send-comment">
            <img src="../assets\icons\chat-bubble.png" alt="">
            <span>
              <?= Utils::comments_num($_GET["post_id"]) > 0 ? Utils::comments_num($_GET["post_id"]) : "" ?>
            </span>
          </button>

          <button class="post-button">
            <img src="../assets\icons\repost.png" alt="">
          </button>
          <form method="POST">
            <button class="<?= Utils::is_liker($_SESSION["login_id"], $_GET["post_id"]) ? "like" : "post-button" ?>"
              name="like">
              <img src="../assets\icons\heart.png" alt="">
              <?php if (Utils::returnLikes($_GET["post_id"]) > 0) { ?>
                <span>
                  <?= Utils::returnLikes($_GET["post_id"]) ?>
                </span>
              <?php } ?>
            </button>
          </form>


          <button class="post-button">
            <img src="../assets\icons\upload.png" alt="">
          </button>
        </div>
        <div class="tweet-area hidden">
          <div class="user-icon">
            <img src="../assets\icons\user.png" alt="">
          </div>
          <form method="POST" enctype="multipart/form-data">
            <div class="tweet-submit-area">
              <div class="tweet-field">
                <textarea name="tweet" placeholder="What's happening?"></textarea>
              </div>
              <div class="tweet-buttons">

                <div class="tweet-icons">
                  <div class="tweet-icon">
                    <button class="upload">
                      <img src="../assets\icons\gallery.png" alt="">
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
                <button name="submit" class="post-tweet">tweet</button>
              </div>

            </div>
          </form>
        </div>
      </div>
      <?php if (count($comments)) {
        foreach ($comments as $comment) { ?>

          <div class="post">
            <div name="go" class="go">
              <div class="user-img">
                <img src="../assets\icons\user.png" alt="">
                <div class="post-writer" name="post-writer">
                  <?= $comment["commenter_name"] ?>
                </div>
              </div>
              <div class="writer-post">
                <span class="text" name="text">
                  <span class="mention">@
                    <?= $post["poster_name"] ?>
                  </span> <br><br>
                  <?= $comment["comment_text"] ?>
                </span>
                <?php if (!empty(trim($comment["comment_img"]))) { ?>
                  <img src="../assets/images<?= $comment["comment_img"] ?>" alt="" name=post="img">
                <?php } ?>
              </div>
            </div>
            <div class="post-buttons">
              <button class="post-button send-comment">
                <img src="../assets\icons\chat-bubble.png" alt="">
                <?php
                if (Utils::comments_num($comment["comment_id"]) > 0) { ?>
                  <span>
                    <?= Utils::comments_num(Utils::comments_num($comment["comment_id"])) ?>
                  </span>
                  <?php
                }
                ?>
              </button>
              <button class="post-button">
                <img src="../assets\icons\repost.png" alt="">
              </button>
              <form method="POST">
                <button
                  class="<?= Utils::is_liker($_SESSION["login_id"], $comment["comment_id"]) ? "like" : "post-button" ?>"
                  name="like">
                  <img src="../assets\icons\heart.png" alt="">
                  <?php if (Utils::returnLikes($comment["comment_id"]) > 0) { ?>
                    <span>
                      <?= Utils::returnLikes($comment["comment_id"]) ?>
                    </span>
                  <?php } ?>
                </button>
              </form>
              <button class="post-button">
                <img src="../assets\icons\upload.png" alt="">
              </button>
            </div>
          </div>

        <?php }
      } ?>
    </div>
    <?php include("../home/right-side.php") ?>
  </div>
</body>

<script>

  let send = document.querySelectorAll(".send-comment");
  send.forEach((button) => {
    button.addEventListener("click", () => {
      let buttons = button.parentNode;
      let post = buttons.parentNode; // somthing new 
      console.log(post.childElementCount)
      if (post) {
        let tweetArea = post.querySelector('.tweet-area');
        if (tweetArea) {
          tweetArea.classList.toggle("hidden");
        }
      }
    });
  });

  let like = document.querySelectorAll(".like-button");
  like.forEach((button) => {
    button.addEventListener("click", () => {
      button.classList.toggle("like");
    });
  });


</script>