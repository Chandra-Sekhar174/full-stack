<?php
session_start();
include "config.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    echo "Access Denied!";
    exit();
}

// Approve event
if(isset($_GET['approve'])){
    $id = $_GET['approve'];
    mysqli_query($conn, "UPDATE events SET status='approved' WHERE id=$id");
    header("Location: admin_panel.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM events WHERE status='pending'");
?>

<h2>Admin Panel - Pending Events</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Title</th>
    <th>Date</th>
    <th>Location</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['event_date']; ?></td>
    <td><?php echo $row['location']; ?></td>
    <td>
        <a href="admin_panel.php?approve=<?php echo $row['id']; ?>">
            Approve
        </a>
    </td>
</tr>
<?php } ?>

</table>

<br>
<a href="dashboard.php">Back to Dashboard</a>