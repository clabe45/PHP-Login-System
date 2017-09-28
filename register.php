<!-- PUBLIC -->
<?php

define('__CONFIG__', true); // authentication for config.php
require_once 'inc/config.php';

Page::force_home();

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
  <title>Sign up | {sitename}</title>
</head>
<body>
  <?php include_once "inc/header.php"; ?>
  <div id="content-area">
    <h1>Register</h1>
    <form id="register-form">
      <table>
        <tr>
          <td><label for="name">Full name: </label></td>
          <td><input id="name" required="required" placeholder="Joe Smith"/></td>
          <td></td><!-- for extra info -->
        </tr>
        <tr>
          <td><label for="username">Username: </label></td>
          <td><input id="username" required="required" placeholder="jsmith101"/></td>
          <td></td><!-- for extra info -->
        </tr>
        <tr>
          <td><label for="email">Email: </label></td>
          <td><input type="email" id="email" required="required" placeholder="email@example.com"/></td>
          <td><em style="color: grey"><span style="color:#990099">*</span> this will not be shown to the public</em></td>
        </tr>
        <tr>
          <td><label for="password">Password: </label></td>
          <td><input type="password" required="required" id="password"/></td>
          <td></td><!-- for extra info -->
        </tr>
        <tr>
          <td><label for="password-confirm">Confirm: </label></td>
          <td><input type="password" required="required" id="password-confirm"/></td>
          <td></td><!-- for extra info -->
        </tr>
        <tr>
          <td></td>
          <td><button type="submit"><strong>Sign up</strong></button></td>
        </tr>
      </table>
      <div class="success"></div>
      <div class="error"></div>
    </form>
  </div>

  <?php require_once 'inc/footer.php'; ?>
  <script src="assets/js/register.js"></script>

</body>
</html>
