<?php
// IMPORTANT: Database Configuration File: Without Proper Configuration the system will not work
$dbServer   = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName     = "commackCL";

$conn = mysqli_connect($dbServer, $dbUsername, $dbPassword, $dbName);
?>