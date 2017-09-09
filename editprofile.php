<?php

define('__CONFIG__', true);
include_once "inc/config.php";

forceLogIn(); // private page

$getUser = $con->prepare("SELECT * FROM users WHERE user_id = :user_id");
$getUser->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_STR);
$getUser->execute();

$user = $getUser->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
  <title><?php echo $user['username']; ?> | Example</title>
  <link type="text/css" rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>
  <h1><?php echo $user['username']; ?></h1>
  <form id="edit-form">
    <table>
      <tr>
        <td>Name: </td>
        <td><input value="<?php echo $user['name']; ?>"/></td>
      </tr>
      <tr>
        <td>Username: </td>
        <td><input value="<?php echo $user['username']; ?>"/><td>
      </tr>
      <tr>
        <td>Email: </td>
        <td><input value="<?php echo $user['email']; ?>"/></td>
      </tr>
      <tr>
        <td></td>
        <td><button type="submit"><strong>Save</strong></button></td>
      </tr>
    </table>
  </form>
  <div class="success"></div>
  <div class="error"></div>

  <?php require_once('inc/footer.php'); ?>
  <script src="assets/js/editprofile.js"></script>
</body>
</html>
