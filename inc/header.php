<!-- // in the beginning of <body> -->
<?php
  if (Page::logged_in()) {
    $current_user = new User($_SESSION['user_id']);
?>
<div id="left"><!-- #top should overlap #left -->
  <?php
    echo
      'Messaging groups<br>
      ...';
    }
  ?>
</div>
<div id="top">
  <a href="/php-login-system" id="home">
    <img src="assets/images/icon.png"/>
  </a>
  <?php if (Page::logged_in()) { ?>
    <div id="search-area">
      <input id="search-box" placeholder="Type username or email"/>
      <div id="search-results">

      </div>
      search for ... <input type="radio" name="search-category" id="search-users" checked/><label for="search-users">users</label>
    </div>
  <?php } ?>

  <div id="top-right">
  <?php if (!Page::logged_in()) { ?>
    <a href="login">Log in</a> or <a class="special" href="register">Sign up</a>
  <?php } else { ?>
    <span id="notifications-count"><?php
        // count how many notifications were created after last_time_viewed_notifications
        $count = 0;
        foreach($current_user->get_notifications() as $notif) {
          if ($notif->create_time >= $current_user->last_time_viewed_notifications) {
            $count++;
          }
        }
        echo $count;
    ?></span>
    <div id="notifications-box" tabindex="-1">
      <?php require_once "inc/notifications.php" ?>
    </div>
    <a href="profile?user_id=<?php echo $current_user->user_id;?>"><?php echo $current_user->username; ?></a>
    <a class="special" href="logout">Log out</a>
  <?php } ?>
  </div>
</div>
