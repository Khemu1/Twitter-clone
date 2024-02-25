<?php
require_once("../config\setup.php");
require_once("../classes/Utils.php");
session_start();
if (!isset($_GET["post_id"]) || !isset($_SESSION["login_id"])) {
  header("location:home.php");
  exit;
}
$post = Utils::selectPost($_GET["post_id"])[0];
print_r($post);
// if (isset($_POST["like"])) {
//   Utils::like($_GET["post_id"], $_GET["poster_id"], $_SESSION["login_id"], );
// }


if (isset($_POST["submit"])) {
  // $file_name = $_FILES["tweet-img"]["name"];
  // $temp_name = $_FILES["tweet-img"]["tmp_name"];
  // $folder = '../assets/images/' . $file_name;
  // if (move_uploaded_file($temp_name, $folder)) {
  //   echo "commented";
  //   Utils::insertComment($_SESSION["login_id"], $_GET["post_id"], $_POST["tweet"], $file_name);
  // }
}

// if (isset($_POST["follow"])) {
//   Utils::follow($post["poster_id"], $_SESSION["login_id"]);
// }
// if (isset($_POST["follow-commenter"])) {
//   Utils::follow($_POST["commenter_id"], $_SESSION["login_id"]);

// }
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets\css\home-left-side.css">
  <link rel="stylesheet" href="../assets\css\home-right-side.css">
  <link rel="stylesheet" href="../assets\css\edit-page.css">
  <title>
    <?= $_SESSION["name"] ?>'s post
  </title>
</head>

<body>
  <div class="post-page">
    <?php
    include("../home\left-side.php")
      ?>
    <div class="posts">
      <?php if ($post) { ?>
        <div class="post">
          <div name="go" class="go">

            <div class="user-img">
              <img src="../assets\icons\user.png" alt="">
              <div class="post-writer" name="post-writer">
                <?= $post["poster_name"] ?>
              </div>
              <form method="POST">
                <?php if ($_SESSION["login_id"] != $post["poster_id"]) { ?>
                  <button
                    class="<?= Utils::is_follower($post["poster_id"], $_SESSION["login_id"]) ? "followed" : "follow" ?>"
                    name="follow">
                    <?= Utils::is_follower($post["poster_id"], $_SESSION["login_id"]) ? "Unfollow" : "Follow" ?>
                  </button>
                <?php } ?>
              </form>
            </div>
            <div class="writer-post">
              <textarea class="text" name="text"><?= trim($post["post_text"]) ?></textarea>
              <?php if (!empty(trim($post["post_img"]))) { ?>
                <img class="post-img" src="../assets/images/<?= $post["post_img"] ?>" alt="" name=post="img">
              </div>
            <?php } ?>
          </div>
          <div class="edit-buttons">
            <?php if (!empty(trim($post["post_img"]))) { ?>
              <button class="tweet-button delete-button" value="1" name="delete-img">Delete All</button>

            <?php } ?>
            <form method="POST">
              <button class="tweet-button" name="edit">Edit</button>
            </form>
          </div>

        </div>
      </div>
    <?php } ?>
    <?php include("../home/right-side.php") ?>
  </div>
</body>

<script>
  let post = <?= json_encode($post, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>;
  let postText = post.post_text;
  let postImg = post.post_img;
  let restButton = document.querySelector(".delete-button")

  let deleteImg = document.querySelector(".delete-button");
  deleteImg.addEventListener("click", () => {
    let value = deleteImg.value;
    deleteImg.value = value === "true" ? "false" : "true";
    toggleImg();
    if (deleteImg.value === "true") {
      deleteImg.textContent = "Reset"
    }
    else {
      deleteImg.textContent = "Delete all"
    }
  });

  document.querySelector(".text").addEventListener("input", () => {
    let text = document.querySelector(".text").value;
    if (!(text === postText)) {
      restButton.textContent = "Reset";
    }
    else {
      restButton.textContent = "Delete All";
    }
  })

  function toggleImg() {
    let img = document.querySelector(".post-img")
    img.classList.toggle("hidden");
  }

</script>