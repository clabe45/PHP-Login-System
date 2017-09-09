<?php

define('__CONFIG__', true); // authentication for config.php
require_once 'inc/config.php';

forceHome();

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
  <title>Sign Up | Example</title>
</head>
<body>
  <h1>Register</h1>
  <form id="register-form">
    <table>
      <tr>
        <td><label for="name">Full name: </label></td>
        <td><input id="name" required="required" placeholder="Joe Smith"/></td>
      </tr>
      <tr>
        <td><label for="username">Username: </label></td>
        <td><input id="username" required="required" placeholder="jsmith101"/></td>
      </tr>
      <tr>
        <td><label for="email">Email: </label></td>
        <td><input type="email" id="email" required="required" placeholder="email@example.com"/></td>
      </tr>
      <tr>
        <td><label for="password">Password: </label></td>
        <td><input type="password" required="required" id="password"/></td>
      </tr>
      <tr>
        <td><label for="password-confirm">Confirm: </label></td>
        <td><input type="password" required="required" id="password-confirm"/></td>
      </tr>
      <tr>
        <td></td>
        <td><button type="submit"><strong>Sign up</strong></button></td>
      </tr>
    </table>
    <div class="success"></div>
    <div class="error"></div>
  </form>

  <?php require_once 'inc/footer.php'; ?>
  <script src="assets/js/register.js"></script>

</body>
</html>
