<?php
session_start();
include "config.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM events WHERE status='approved'");
?>

<h2>Available Events</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Title</th>
    <th>Description</th>
    <th>Date</th>
    <th>Location</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['description']; ?></td>
    <td><?php echo $row['event_date']; ?></td>
    <td><?php echo $row['location']; ?></td>
</tr>
<?php } ?>

</table>

<br>
<a href="dashboard.php">Back to Dashboard</a>