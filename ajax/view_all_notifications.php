<?php
/*
  Sets the user's last_viewed_notifications time to now
*/

define('__CONFIG__', true); // authentication for config.php
require_once '../inc/config.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST')   exit($authentication_err_msg);

header('Content-Type: application/json');
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

$return = array();  // all response data

$user_id = $_SESSION['user_id'];
$user = new User($user_id);
$user->view_all_notifications();

echo json_encode($return);

?>
