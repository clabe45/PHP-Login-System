<?php
if (!defined('__CONFIG__'))
  exit('<pre>You don\'t belong here. You will leave this site *force use*.</pre>');

class Page {

  public static function logged_in() {
    return isset($_SESSION['user_id']);
  }

  // redirect user if not logged in
  public static function force_log_in() {
    if(!self::logged_in()) {
      header("Location: login.php");
      exit;
    }
  }

  // redirect user if logged in
  public static function force_home() {
    if (self::logged_in()) header("Location: ."); // navigate to pseudo-root
  }

  /**
   * Redirects the user to logout.php, essentially logging he/she out
   * @return {void}
   */
  public static function log_out() {
    header("Location: logout.php");
  }
}

?>
