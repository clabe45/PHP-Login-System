<!-- PRIVATE -->
<?php

define('__CONFIG__', true);
include_once "inc/config.php";

Page::force_log_in(); // private page

$user_id = (int)$_GET['user_id'];

//                         if this is user's page, pass true to |force_log_in|
$user = new User($user_id, $user_id==$_SESSION['user_id']);

?>

<!DOCTYPE html>
<html>
<head>
  <title><?php echo $user->username;?> | {sitename}</title>
  <link type="text/css" rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>
  <?php include_once "inc/header.php"; ?>
  <div id="content-area">
    <?php if($current_user->user_id != $user->user_id) { // someone else's page
      $status = $current_user->get_friendship_status($user->user_id);
      if (!$status) { // works because NO_FRIENDSHIP == 0
    ?>
    <div id="inner-top">
      <button onclick="modifyFriendship('friend_request.php');">Send friend request</button>
    </div>
    <?php } else if ($status == FriendshipStatus::USER_SENT_REQUEST) { ?>
      <div id="inner-top">
        <span>Friend request sent</span>
      </div>
    <?php } else if ($status == FriendshipStatus::FRIEND_SENT_REQUEST) { ?>
      <div id="inner-top">
        <span>
          <?php echo $user->username;?> has sent you a friend request
          <button style="margin-left: 20px; margin-top:-8px;" onclick="modifyFriendship('friend_accept.php');">Accept Friend Request</button>
        </span>
      </div>
    <?php } else if ($status == FriendshipStatus::FRIENDS) { ?>
      <div id="inner-top">
        <span>You are friends with <?php echo $user->username; ?></span>
      </div>
    <?php }
      }
    ?>
    <h1><?php echo $user->username; ?></h1>
    <h3 style="margin-left: 64px;"><?php echo $user->name; ?></h3>
      <?php if ($current_user->user_id == $user->user_id) { ?>
        <a style="margin-left:100px" href="edit-profile">Edit</a>
      <?php } else { ?>
        <!-- friend request -->
      <?php } ?>
    <br>
    <?php

      if ($current_user->user_id == $user->user_id) echo "Email: " . $user->email . "<br>";
      echo "Joined: " . time_ago($user->reg_time);


    ?>
  </div>
  <?php require_once('inc/footer.php'); ?>
  <script src="assets/js/profile.js"></script>
</body>
</html>
