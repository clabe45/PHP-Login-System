<?php

define('__CONFIG__', true); // authentication for config.php
require_once '../inc/config.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST')   exit($authentication_err_msg);

header('Content-Type: application/json');
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

$return = array();  // all response data

$current_pw = $_POST['current_password'];
$new_pw = $_POST['new_password'];

$get_user = $con->prepare("SELECT password FROM users WHERE user_id = :user_id LIMIT 1");
$get_user->bindParam(":user_id", $_SESSION['user_id']);
$get_user->execute();

$user = $get_user->fetch(PDO::FETCH_ASSOC);

if (password_verify($current_pw, $user['password'])) {
  $new_ps_hash = password_hash($new_pw, PASSWORD_DEFAULT);

  $update_user = $con->prepare("UPDATE users SET password=:password WHERE user_id=:user_id LIMIT 1");
  $update_user->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
  $update_user->bindParam(':password', $new_ps_hash, PDO::PARAM_STR);
  $update_user->execute();
}

$return['redirect'] = '.';

echo json_encode($return, JSON_PRETTY_PRINT);

?>
