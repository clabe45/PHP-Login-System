<?php

define('__CONFIG__', true); // authentication for config.php
require_once '../inc/config.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST')   exit($authentication_err_msg);

header('Content-Type: application/json');
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

$return = array();  // all response data

$password = $_POST['password'];
$username_or_email = filter_var($_POST['username_or_email'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);  // change to FILTER_SANITIZE_EMAIL?

$find_user_username = $con->prepare("SELECT user_id, password FROM users WHERE username = :username LIMIT 1");
$find_user_username->bindParam(':username', $username_or_email, PDO::PARAM_STR);
$find_user_username->execute();

$find_user_email = $con->prepare("SELECT user_id, password FROM users WHERE email = LOWER(:email) LIMIT 1");
$find_user_email->bindParam(':email', $username_or_email, PDO::PARAM_STR);
$find_user_email->execute();

$find_user = $find_user_username->rowCount() == 1 ?
              $find_user_username : ($find_user_email->rowCount() == 1 ?
                $find_user_email : null);

if ($find_user != null) {
  // user exists (whether it be selected using username or email)
  $user = $find_user->fetch(PDO::FETCH_ASSOC);

  $user_id = (int)$user['user_id'];
  $hash = $user['password'];
  if (password_verify($password, $hash)) {
    // password matches what's stored in the db
    $_SESSION['user_id'] = $user_id;
    $return['redirect'] = '.';  // redirect to home page
  } else {
    // password does not match
    $return['error'] = 'Wrong username or password';  // make it ambiguous so that it's more secure
  }
} else {
  $return['error'] = 'Wrong username or password';  // username does not exist
}

echo json_encode($return, JSON_PRETTY_PRINT);

?>
