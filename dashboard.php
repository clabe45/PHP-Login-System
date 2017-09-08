<?php

define('__CONFIG__', true); // authentication for config.php
require_once 'inc/config.php';

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
  <title>Sign Up | Example</title>
</head>
<body>
  <h1>
    <?php
      if (isset($_GET['message']) && $_GET['message'] == 'welcome') echo "Welcome to Example!";
      else echo "Dashboard";
    ?>
  </h1>
  <!-- Formatting likewise to keep |innerHTML| down to an "" -->
  <div class="success"><?php
      if (isset($_GET['success'])) echo "Account successfully created!";
  ?></div>
  <script src="assets/js/dashboard.js"></script>

  <?php include_once('inc/footer.php'); ?>
</body>
</html>
