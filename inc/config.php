<?php

// authentication
if (!defined('__CONFIG__'))
  exit('<pre>You don\'t belong here. You will leave this site *force use*.</pre>');

define('__FOOTER__', true);
// start config

include_once "classes/DB.php";

$con = DB::getConnection();

?>
<link rel="stylesheet" type="text/css" href="style.css"/>
