<?php

$host = 'mysql';
$user = 'PARMIDA';
$password = 'root';
$db = 'escape';
$conn = mysqli_connect($host, $user, $password, $db);

if (!$conn) {
    echo "connection error --> " . mysqli_connect_error();
}

?>