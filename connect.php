<?php

$dbPort = 'localhost';
$dbName = 'furniture';
$dbUserName = 'root';
$dbPassword = '';

$dbConnect = mysqli_connect($dbPort, $dbUserName, $dbPassword, $dbName);

if (mysqli_connect_errno()) {
    echo 'failed to connect to database due to the following reasons <br>' . mysqli_connect_error();
    die();
}

session_start();
