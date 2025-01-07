<?php
session_start();

$_SESSION = array(); //reset entire session

session_destroy();

header('Location: index.html');
exit();
?>