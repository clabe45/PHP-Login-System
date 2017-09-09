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
  <h3 style="margin-left: 64px;"><?php echo $user['name']; ?></h3>
  <a style="margin-left:100px" href="editprofile.php">Edit</a>
  <div id="content-area">
  <?php

    echo "Email: " . $user['email'] . "<br>";
    echo "Joined: " . time_ago($user['reg_time']);


  ?>
  </div>
  <?php require_once('inc/footer.php'); ?>
</body>
</html>
