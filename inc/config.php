<?php

$authentication_err_msg = '<pre>You don\'t belong here. You will leave this site *force use*.</pre>';

// authentication
if (!defined('__CONFIG__'))   exit($authentication_err_msg);

// sessions are always turned on
if (!isset($_SESSION)) session_start();

// start config
define('__FOOTER__', true);

include_once "classes/DB.php";

$con = DB::getConnection();

?>
