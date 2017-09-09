<?php

define('__CONFIG__', true); // authentication for config.php
require_once '../inc/config.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST')   exit($authentication_err_msg);

header('Content-Type: application/json');
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

$return = array();  // all response data

$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);  // change to FILTER_SANITIZE_EMAIL?

if (isset($_SESSION['user_id'])) {
  // a user is logged in
  $updateUser = $con->prepare("UPDATE users SET name=:name, username=:username, email=:email WHERE user_id=:user_id");
  $updateUser->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
  $updateUser->bindParam(':name', $name, PDO::PARAM_STR);
  $updateUser->bindParam(':username', $username, PDO::PARAM_STR);
  $updateUser->bindParam(':email', $email, PDO::PARAM_STR);
  $updateUser->execute();

  $return['redirect'] = '.';
}

echo json_encode($return, JSON_PRETTY_PRINT);

?>
