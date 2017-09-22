<!-- PUBLIC/PRIVATE --><!-- this means the user is not redirected if not logged in - or if logged in -->
<?php

define('__CONFIG__', true); // authentication for config.php
require_once "inc/config.php";

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
  <title>Home | {sitename}</title>
</head>
<body>

  <?php  require_once "inc/header.php"; ?>
  <!-- "Optional": may be used, or may be not used -->
  <!-- Formatting likewise to keep |innerHTML| down to an "" -->
  <div class="fixed success"><?php
      if (isset($_GET['success'])) {
        switch($_GET['success']) {
          case "account": {
             echo "Account successfully created!";
             break;
          }
          case "edit": {
            echo "Profile data successfully changed";
            break;
          }
          case "changepw": {
            echo "Password successfully changed";
            break;
          }
          default: {
            echo "Success with something ?";
            break;
          }
        }
      }
  ?></div>

  </div>
  <div id="content-area">
    <?php

    if (isset($_GET['message']) && $_GET['message'] == 'welcome') echo "<h1>Welcome to {sitename}!</h1>";

    if (isset($_SESSION['user_id'])) {
      new User($_SESSION['user_id'], true); // log user out if doens't exist
      // user is logged in: this is where things happen

      echo
        '<div class="post">
          <div class="post-info">
            <a class="post-user" href="profile.php?user_id=7">test12</a>
            <span class="post-timestamp">1 minute ago</span>
          </div>
          <span class="post-content">
            Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...
          </span>
        </div>';

    } else {
      echo
        'Welcome to {sitename}! Here, you can ...<ul>
          <li><span style="color:#04E824">message users</span> in group chats</li>
          <li><span style="color:#04E824">post</span> text, images, videos, articles, links, and embedded content</li>
          <li><span style="color:#04E824">vote up</span> other people\'s posts to make them seen by more people</li>
        </ul>';
      echo '<br>';
      echo 'Click <span style="color:#F21B3F">Sign up</span> to get started!' . '<br><br>';
      echo '<em>P.S. don\'t forget to invite your friends here so you can socialize with them!</em>';
    }

    ?>
  </div>

  <script src="assets/js/index.js"></script>

  <?php require_once "inc/footer.php"; ?>

</body>
</html>
