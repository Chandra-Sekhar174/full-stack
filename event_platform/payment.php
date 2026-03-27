<?php
session_start();
include "config.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];
$event_id = $_POST['event_id'];
$quantity = $_POST['quantity'];

if (isset($_POST['pay'])) {

    // Save booking after payment
    mysqli_query($conn, "INSERT INTO bookings (user_id, event_id, quantity)
    VALUES ('$user_id','$event_id','$quantity')");

    echo "<script>alert('Payment Successful! Ticket Booked.'); 
    window.location='dashboard.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<title>Payment</title>
</head>
<body>

<div class="container">
<h2>Payment</h2>

<p>Event ID: <?php echo $event_id; ?></p>
<p>Tickets: <?php echo $quantity; ?></p>

<hr>

<form method="POST">

<input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
<input type="hidden" name="quantity" value="<?php echo $quantity; ?>">

<label>Card Number:</label>
<input type="text" required placeholder="1234 5678 9012 3456">

<label>Expiry Date:</label>
<input type="text" required placeholder="MM/YY">

<label>CVV:</label>
<input type="password" required placeholder="123">

<button type="submit" name="pay">Pay Now</button>

</form>

</div>
</body>
</html>