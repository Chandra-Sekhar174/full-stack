<?php
session_start();
include "config.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

if (isset($_POST['change'])) {

    $current = $_POST['current_password'];
    $new = $_POST['new_password'];

    // Get current password from DB
    $result = mysqli_query($conn, "SELECT password FROM users WHERE id='$user_id'");
    $row = mysqli_fetch_assoc($result);

    // Verify current password
    if (password_verify($current, $row['password'])) {

        $new_password = password_hash($new, PASSWORD_DEFAULT);

        mysqli_query($conn, "UPDATE users SET password='$new_password' WHERE id='$user_id'");

        echo "<script>alert('Password Changed Successfully');</script>";

    } else {
        echo "<script>alert('Current Password Incorrect');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<title>Change Password</title>
</head>
<body class="login-page">

<div class="container">
<h2>Change Password</h2>

<form method="POST">

<input type="password" name="current_password" placeholder="Current Password" required>

<input type="password" name="new_password" placeholder="New Password" required>

<button type="submit" name="change">Update Password</button>

</form>

<a href="dashboard.php">Back</a>

</div>

</body>
</html>