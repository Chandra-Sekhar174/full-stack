<?php
session_start();
include "config.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];
$name = $_SESSION['name'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-page">
<div class="container">

<h2>Welcome <?php echo $name; ?></h2>
<h3>Role: <?php echo ucfirst($role); ?></h3>
<hr>

<?php
/* ================= USER PANEL ================= */
if ($role == "user") {
?>

<h3>Available Events</h3>

<?php
$events = mysqli_query($conn, "SELECT * FROM events WHERE status='approved'");

while ($row = mysqli_fetch_assoc($events)) {
    echo "<p><b>".$row['title']."</b> - ".$row['event_date']."</p>";
    echo "<a href='book_ticket.php?event_id=".$row['id']."'>
          <button>Book Ticket</button></a><br><br>";
}
?>

<hr>

<h3>Total Tickets Booked</h3>
<a href="change_password.php">Change Password</a>
<?php
$count = mysqli_query($conn, "SELECT SUM(quantity) as total FROM bookings WHERE user_id='$user_id'");
$data = mysqli_fetch_assoc($count);
$total = $data['total'] ?? 0;
echo "<p><b>".$total."</b> Tickets</p>";
?>

<hr>

<h3>Your Booking History</h3>

<?php
$history = mysqli_query($conn, "
    SELECT events.title, bookings.quantity, bookings.booking_date
    FROM bookings
    JOIN events ON bookings.event_id = events.id
    WHERE bookings.user_id='$user_id'
");

while ($h = mysqli_fetch_assoc($history)) {
    echo "<p>
          Event: ".$h['title']."<br>
          Tickets: ".$h['quantity']."<br>
          Date: ".$h['booking_date']."
          </p><hr>";
}
}

/* ================= ORGANIZER PANEL ================= */
elseif ($role == "organizer") {
?>

<h3>Organizer Panel</h3>

<a href="create_event.php">
<button>Create New Event</button>
</a>

<hr>

<h3>Your Events</h3>

<?php
$my_events = mysqli_query($conn, "SELECT * FROM events WHERE organizer_id='$user_id'");

if (mysqli_num_rows($my_events) > 0) {
    while ($e = mysqli_fetch_assoc($my_events)) {
        echo "<p>
              <b>".$e['title']."</b><br>
              Date: ".$e['event_date']."<br>
              Status: ".$e['status']."
              </p><hr>";
    }
} else {
    echo "<p>No events created yet.</p>";
}
}


/* ================= ADMIN PANEL ================= */
elseif ($role == "admin") {
?>

<h3>Admin Panel</h3>

<h4>Events Pending Approval</h4>

<?php
$pending = mysqli_query($conn, "SELECT * FROM events WHERE status='pending'");

if (mysqli_num_rows($pending) > 0) {
    while ($p = mysqli_fetch_assoc($pending)) {
        echo "<p>
              <b>".$p['title']."</b><br>
              Date: ".$p['event_date']."<br>
              <a href='approve_event.php?id=".$p['id']."'>
              <button>Approve</button></a>
              </p><hr>";
    }
} else {
    echo "<p>No pending events.</p>";
}
}
?>

<hr>

<a href="logout.php">
<button style="background:red; color:white;">Logout</button>
</a>

</div>
</body>
</html>