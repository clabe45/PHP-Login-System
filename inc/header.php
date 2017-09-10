<?php // in the beginning of <body> ?>
<div id="left"><!-- #top should overlap #left -->
  <?php
    if (isset($_SESSION['user_id'])) {
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

  <div id="search-area">
    <input id="search-box"/>
    <div id="search-results">
      
    </div>
    search ... <input type="radio" name="search-category" id="search-users" checked/><label for="search-users">users</label>
  </div>

  <div id="top-right">
  <?php

    if (!isset($_SESSION['user_id']))
      echo '<a href="login.php">Log in</a> or <a class="special" href="register.php">Sign up</a>';
    else {
      echo '<a href="profile.php">Profile</a>';
      echo '<a class="special" href="logout.php">Log out</a>';
    }
  ?>
  </div>
</div>
