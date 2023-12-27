<?php

$hostname = "localhost";
$database = "u6029342_HRSystems_KingLab";
$username = "u6029342";
$password = "mlbangbang";

$connect = mysqli_connect($hostname, $username, $password, $database);

if (!$connect) {
    die("Connection error" . mysqli_connect_error());
}

?>