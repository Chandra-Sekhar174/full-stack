<?php
$host = "127.0.0.1";
$user = "root";
$password = "1234";   // your MySQL password
$database = "event_platform";
$port = 3307;

$conn = mysqli_connect($host, $user, $password, $database, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>