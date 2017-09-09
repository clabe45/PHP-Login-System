<?php

session_start();
session_destroy();

header('Location: .'); // redirect to home page

?>
