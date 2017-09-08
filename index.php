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

  <h1>Welcome!</h1><br>
  <div class="top">
    <a href="login.php">Log in</a> or <a class="special" href="register.php">Sign up</a>
  </div>
  <div id="content-area">
    This is an example website. Normally, there is content here.
  </div>

  <?php require_once "inc/footer.php"; ?>

</body>
</html>
