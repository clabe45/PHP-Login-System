<?php

define('__CONFIG__', true); // authentication for config.php
require_once '../inc/config.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST')   exit($authentication_err_msg);

header('Content-Type: application/json');
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

$return = array();  // all response data

$frequest_recipient_id = $_SESSION['user_id'];  // user who is logged in ; to prevent hacks (for one thing)
$frequest_sender_id =  (int)$_POST['friend_id'];

if ($frequest_recipient_id != $frequest_sender_id) {
  try {
    // make sure both users exist (will throw exception if they don't)
    new User($frequest_sender_id);
    new User($frequest_recipient_id);

    $accept_time = date('Y-m-d H:i:s');

    $update_friendship = $con->prepare(
      "UPDATE friendships SET accept_time = :accept_time"       // make it not null, to confirm request
    );
    $update_friendship->bindParam(":accept_time", $accept_time, PDO::PARAM_STR);
    $update_friendship->execute();

    $notif_sender_id = $frequest_recipient_id;
    $notif_recipient_id = $frequest_sender_id;

    Notification::create($con, new User($notif_sender_id), new User($notif_recipient_id), "FRIEND.ACCEPT", null, null);  // notify the friend

    $return['reload'] = true;
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}

echo json_encode($return, JSON_PRETTY_PRINT);

?>
