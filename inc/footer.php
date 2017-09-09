<?php

// authentication
if (!defined('__FOOTER__'))   exit($authentication_err_msg);

// start footer

?>
<a href="/php-login-system" id="home">e</a><!-- shows up on top; in footer for convenience -->
<script src="assets/js/main.js"></script>
<script src="assets/js/functions.js"></script>
<div id="top">
<?php
  if (!isset($_SESSION['user_id']))
    echo '<a href="login.php">Log in</a> or <a class="special" href="register.php">Sign up</a>';
  else {
    echo '<a href="profile.php">Profile</a>';
    echo '<a class="special" href="logout.php">Log out</a>';
  }
?>
</div>
