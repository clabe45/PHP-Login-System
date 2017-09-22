<?php
/*
  Marks a specific notification as "clicked"
*/

define('__CONFIG__', true); // authentication for config.php
require_once '../inc/config.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST')   exit($authentication_err_msg);

header('Content-Type: application/json');
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

$user_id = $_SESSION['user_id'];
$user = new User($user_id);

$return = array();

// count how many notifications were created after last_time_viewed_notifications
$count = 0;
foreach ($user->get_notifications() as $notif) {
  if ($notif->create_time > $user->last_time_viewed_notifications) {
    $count++;
  }
}
$return['count'] = $count;

echo json_encode($return);

?>
