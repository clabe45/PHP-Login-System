<?php

if (!defined('__CONFIG__'))
  exit('<pre>You don\'t belong here. You will leave this site *force use*.</pre>');

class DB {
  protected static $con;

  private function __construct() {
    try {
      self::$con = new PDO('mysql:charset=utf8mb4;host=localhost;dbname=login_course', 'root', '');
      self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      self::$con->setAttribute(PDO::ATTR_PERSISTENT, false);
    } catch (PDOException $e) {
      echo '<pre>Could not connect to database :(</pre>';
      exit;
    }
  }

  public static function getConnection() {
    if (!self::$con) new DB();  // start instance, if necessary
    return self::$con;
  }

  private function __destruct() {
    self::$con = null;  // close connection (probably not necessary, but still...)
  }
}
?>
