<?php

define('__CONFIG__', true); // authentication for config.php
require_once '../inc/config.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST')   exit($authentication_err_msg);

header('Content-Type: application/json');
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

$return = array();  // all response data

$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);  // change to FILTER_SANITIZE_EMAIL?

// make sure the user doesn't exit
$find_user = $con->prepare("SELECT user_id FROM users WHERE email = LOWER(:email) LIMIT 1");
$find_user->bindParam(':email', $email, PDO::PARAM_STR);
$find_user->execute();

if ($find_user->rowCount() == 1) {
  // user exists
  $return['error'] = "You already have an account";
} else {
  $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
  $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  // insert user into `users` table
  $add_user = $con->prepare("INSERT INTO users(username, name, email, password) VALUES (:username, :name, LOWER(:email), :password)");
  $add_user->bindParam(":username", $username, PDO::PARAM_STR);
  $add_user->bindParam(":name", $name, PDO::PARAM_STR);
  $add_user->bindParam(":email", $email, PDO::PARAM_STR);
  $add_user->bindParam(":password", $password, PDO::PARAM_STR);
  $add_user->execute();

  $user_id = $con->lastInsertId();

  $_SESSION['user_id'] = (int)$user_id;
  $return['redirect'] = '.?message=welcome';
}

echo json_encode($return, JSON_PRETTY_PRINT);

?>
