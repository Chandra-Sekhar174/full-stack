<?php
session_start();
include "config.php";

if (!isset($_SESSION['id']) || $_SESSION['role'] != "admin") {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {

    $event_id = $_GET['id'];

    mysqli_query($conn, "UPDATE events 
                         SET status='approved' 
                         WHERE id='$event_id'");

    header("Location: dashboard.php");
    exit();
}
?>