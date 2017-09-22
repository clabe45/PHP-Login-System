<?php

define('__CONFIG__', true); // authentication for config.php
require_once '../inc/config.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST')   exit($authentication_err_msg);

header('Content-Type: application/json');
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

if ($_POST['type'] == 'user') {

  $pat = '%' . $_POST['search'] . '%';

  // make sure the user doesn't exit
  $find_users = $con->prepare(
      "SELECT user_id, username
       FROM users
       WHERE username LIKE :username_pt
       OR email LIKE :email_pat");
  $find_users->bindParam(':username_pt', $pat, PDO::PARAM_STR);
  $find_users->bindParam(':email_pat', $pat, PDO::PARAM_STR);
  $find_users->execute();

  $return = $find_users->fetchAll(PDO::FETCH_ASSOC);  // all return data right here (as list)

}

echo json_encode($return, JSON_PRETTY_PRINT);

?>
