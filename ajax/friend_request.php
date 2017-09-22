<?php

define('__CONFIG__', true); // authentication for config.php
require_once '../inc/config.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST')   exit($authentication_err_msg);

header('Content-Type: application/json');
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

$return = array();  // all response data

$sender_id = $_SESSION['user_id'];  // user who is logged in ; to prevent hacks (for one thing)
$recipient_id = (int)$_POST['friend_id'];

if ($sender_id != $recipient_id) {
  try {
    // make sure both users exist (will throw exception if they don't)
    new User($sender_id);
    new User($recipient_id);

    $insert_friendship = $con->prepare(
      "INSERT INTO friendships (sender_id, recipient_id) VALUES (:sender_id, :recipient_id)"
    );
    $insert_friendship->bindParam(":sender_id", $sender_id, PDO::PARAM_INT);
    $insert_friendship->bindParam(":recipient_id", $recipient_id, PDO::PARAM_INT);
    $insert_friendship->execute();

    // $friendship_id = $con->lastInsertId();

    Notification::create($con, new User($sender_id), new User($recipient_id), "FRIEND.REQUEST", null, null);  // notify the friend

    $return['reload'] = true;
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}

echo json_encode($return, JSON_PRETTY_PRINT);

?>
