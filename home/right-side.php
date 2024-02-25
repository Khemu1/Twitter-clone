<?php
require("../classes/Account.php");
$users = Account::select(["name"]);

require_once("/laragon/www/twitter/config/setup.php");

?>

<link rel="stylesheet" href="../assets\css\home-right-side.css">


<body>
  <div class="right-side">
    <div class="container">
      <input type="text" name="search-accounts" class="search" placeholder="search for users">
      <div class="accounts-area">
        <!-- <div class="account">
          <div class="account-icon">
            <img src="../assets\icons\user.png" alt="">
          </div>
          <div class="account-info">
            <div class="account-name">Name</div>
            <div class="account-posts">Posts: Num</div>
          </div>
        </div> -->
      </div>
    </div>
  </div>

  <script>

    let users = <?= json_encode($users, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>;

    checkChildren();

    document.querySelector(".search").addEventListener("input", () => {
      let text = document.querySelector(".search").value.trim();

      document.querySelectorAll(".account").forEach(account => {
        account.remove();
      });

      if (text.length > 0) {
        users.forEach(user => {
          if (user.name.includes(text)) {
            addUser(user);
            document.querySelector(".accounts-area").classList.remove("empty")
          }

        });
      }
      else {
        document.querySelector(".accounts-area").classList.add("empty")
      }
    });

    function addUser(user) {
      let child = `
        <div class="account">
          <div class="account-icon">
            <img src="../assets/icons/user.png" alt="">
          </div>
          <div class="account-info">
            <div class="account-name">${user.name}</div>
            <div class="account-posts">Posts: Num</div>
          </div>
        </div>
        `
      document.querySelector(".accounts-area").innerHTML += child;
    }
    function checkChildren() {
      let accounts = document.querySelectorAll(".account");
      if (accounts.length < 1) {
        document.querySelector(".accounts-area").classList.toggle("empty")
      }
      else {
        document.querySelector(".accounts-area").classList.remove("empty")
      }
    }
  </script>

</body>