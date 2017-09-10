<?php

define('__CONFIG__', true);
include_once "inc/config.php";

forceLogIn(); // private page

if (isset($_GET['user_id']) && $_GET['user_id'] == $_SESSION['user_id']) header('Location: profile.php');

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_id'];

$get_user = $con->prepare("SELECT * FROM users WHERE user_id = :user_id");
$get_user->bindParam(":user_id", $user_id, PDO::PARAM_STR);
$get_user->execute();

if($get_user->rowCount() == 0) exit("<pre>This user does not exist.</pre>");

$user = $get_user->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
  <title><?php echo $user['username']; ?> | {sitename}</title>
  <link type="text/css" rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>
  <?php include_once "inc/header.php"; ?>
  <div id="content-area">
    <h1><?php echo $user['username']; ?></h1>
    <h3 style="margin-left: 64px;"><?php echo $user['name']; ?></h3>
    <?php
      if (!isset($_GET['user_id']))
        echo '<a style="margin-left:100px" href="editprofile.php">Edit</a>';
    ?>
    <br>
    <?php

      echo "Email: " . $user['email'] . "<br>";
      echo "Joined: " . time_ago($user['reg_time'], 1);


    ?>
  </div>
  <?php require_once('inc/footer.php'); ?>
</body>
</html>
