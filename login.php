<?php

define('__CONFIG__', true); // authentication for config.php
require_once "inc/config.php";

forceHome();

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
  <title>Log in | Example</title>
</head>
<body>
  <h1>Log in</h1>
  <form id="login-form">
    <table>
      <tr>
        <td><label for="username-or-email">Username or email: </label></td>
        <td><input id="username-or-email" required="required" placeholder="email@example.com"/></td>
      </tr>
      <tr>
        <td><label for="password">Password: </label></td>
        <td><input type="password" required="required" id="password" value="0b01000011;"/></td>
      </tr>
      <tr>
        <td></td>
        <td><button type="submit"><strong>Log in</strong></button></td>
      </tr>
    </table>
    Don't have an account? <a class="special" href="register.php">Sign up</a>
    <div class="success"></div>
    <div class="error"></div>
  </form>
  <?php require_once "inc/footer.php"; ?>
  <script src="assets/js/login.js"></script>

</body>
</html>
