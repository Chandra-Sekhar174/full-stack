<?php
session_start();
include "config.php";

if($_SESSION['role']!='organizer'){
    echo "Access Denied";
    exit();
}

if(isset($_POST['create'])){
    $title=$_POST['title'];
    $desc=$_POST['description'];
    $date=$_POST['event_date'];
    $loc=$_POST['location'];
    $org=$_SESSION['id'];

    mysqli_query($conn,"INSERT INTO events
    (organizer_id,title,description,event_date,location)
    VALUES('$org','$title','$desc','$date','$loc')");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Create Event</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h2>Create Event</h2>
<form method="POST">
<input type="text" name="title" placeholder="Title" required>
<textarea name="description" placeholder="Description" required></textarea>
<input type="date" name="event_date" required>
<input type="text" name="location" placeholder="Location" required>
<button type="submit" name="create">Create</button>
</form>
<a href="dashboard.php">Back</a>
</div>

</body>
</html>