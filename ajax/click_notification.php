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

$return = array();  // all response data

$notif_id = (int)$_POST['notification_id'];
$notif = Notification::from_id($con, $notif_id);
$notif->click(); // execute update query

echo json_encode($return);

?>
