<?php

define('__CONFIG__', true); // authentication for config.php
require_once '../inc/config.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST')   exit($authentication_err_msg);

header('Content-Type: application/json');
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

$return = array();  // all response data

$password = $_POST['password'];
$usernameOrEmail = filter_var($_POST['usernameOrEmail'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);  // change to FILTER_SANITIZE_EMAIL?

$findUserUsername = $con->prepare("SELECT user_id, password FROM users WHERE username = :username LIMIT 1");
$findUserUsername->bindParam(':username', $usernameOrEmail, PDO::PARAM_STR);
$findUserUsername->execute();

$findUserEmail = $con->prepare("SELECT user_id, password FROM users WHERE email = LOWER(:email) LIMIT 1");
$findUserEmail->bindParam(':email', $usernameOrEmail, PDO::PARAM_STR);
$findUserEmail->execute();

$findUser = $findUserUsername->rowCount() == 1 ?
              $findUserUsername : ($findUserEmail->rowCount() == 1 ?
                $findUserEmail : null);

if ($findUser != null) {
  // user exists (whether it be selected using username or email)
  $user = $findUser->fetch(PDO::FETCH_ASSOC);

  $user_id = (int)$user['user_id'];
  $hash = $user['password'];
  if (password_verify($password, $hash)) {
    // password matches what's stored in the db
    $_SESSION['user_id'] = $user_id;
    $return['redirect'] = 'dashboard.php';
  } else {
    // password does not match
    $return['error'] = 'Wrong username or password';  // make it ambiguous so that it's more secure
  }
} else {
  $return['error'] = 'Wrong username or password';  // username does not exist
}

echo json_encode($return, JSON_PRETTY_PRINT);

?>
