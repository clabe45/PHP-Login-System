<?php

// redirect user if not logged in
function forceLogIn() {
  if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
  }
}

// redirect user if logged in
function forceHome() {
  if (isset($_SESSION['user_id'])) header("Location: ."); // navigate to pseudo-root
}

?>
