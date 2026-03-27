<?php
include "config.php";

if (isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Check if email already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Email already exists!');</script>";
    } else {

        mysqli_query($conn, "INSERT INTO users (name, email, password, role)
        VALUES ('$name','$email','$password','$role')")
        or die(mysqli_error($conn));

        echo "<script>alert('Registered Successfully!'); window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="register-page">

<div class="container">
<h2>Create Account</h2>

<form method="POST">

<input type="text" name="name" placeholder="Full Name" required>
<input type="email" name="email" placeholder="Email Address" required>
<input type="password" name="password" placeholder="Password" required>

<select name="role" required>
    <option value="">Select Role</option>
    <option value="user">User</option>
    <option value="organizer">Organizer</option>
    <option value="admin">Admin</option>
</select>

<button type="submit" name="register">Register</button>

</form>

<a href="login.php">Already have an account? Login</a>

</div>

</body>
</html>
