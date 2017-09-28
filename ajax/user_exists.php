<?php
/*
 * checks if a username or email exists
 */
 
define('__CONFIG__', true); // authentication for config.php
require_once '../inc/config.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST')   exit($authentication_err_msg);

header('Content-Type: application/json');
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

$return = array();

$get_user = null;
$type = $_POST['type'];
if ($type == 'username') {
  $username = filter_var($_POST['arg'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);  // change to FILTER_SANITIZE_EMAIL?
  $get_user = $con->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
  $get_user->bindParam(':username', $username);
} else if ($type == 'email') {
  $email = filter_var($_POST['arg'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);  // change to FILTER_SANITIZE_EMAIL?
  $get_user = $con->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
  $get_user->bindParam(':email', $email);
}
$get_user->execute();
if ($get_user->rowCount() == 1)
  $return['error'] = "Another user already has this $type";
else
  $return['success'] = true;  // just to have something

echo json_encode($return);

?>
