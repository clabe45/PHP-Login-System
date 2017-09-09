<?php

define('__CONFIG__', true); // authentication for config.php
require_once "inc/config.php";

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
  <title>Home | Example</title>
</head>
<body>

  <?php
    if (isset($_GET['message']) && $_GET['message'] == 'welcome') echo "<h1>Welcome to Example!</h1>";
  ?>
  <!-- "Optional": may be used, or may be not used -->
  <!-- Formatting likewise to keep |innerHTML| down to an "" -->
  <div class="fixed success"><?php
      if (isset($_GET['success'])) {
        if ($_GET['success'] == 'account')  echo "Account successfully created!";
        else if ($_GET['success'] == 'edit')  echo "Profile data successfully changed";
      }
  ?></div>

  </div>
  <div id="content-area">
  <?php

  if (isset($_SESSION['user_id'])) {
    echo "You are logged in!";
  } else {
    echo "You are not logged in";
  }

  ?>
  </div>

  <script src="assets/js/index.js"></script>

  <?php require_once "inc/footer.php"; ?>

</body>
</html>
