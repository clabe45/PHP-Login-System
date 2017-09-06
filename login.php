<?php

define('__CONFIG__', true); // authentication for config.php
require_once "inc/config.php";

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
  <h1>Log in</h1>
  <form>
    <table>
      <tr>
        <td><label for="email">Username or email: </label></td>
        <td><input type="email" id="email" required="required" placeholder="email@example.com"/></td>
      </tr>
      <tr>
        <td><label for="password">Password: </label></td>
        <td><input type="password" required="required" id="password"/></td>
      </tr>
      <tr>
        <td></td>
        <td><button type="submit"><strong>Log in</strong></button></td>
      </tr>
    </table>
  </form>
  <?php require_once "inc/footer.php"; ?>

</body>
</html>
