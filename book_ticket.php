<?php
session_start();
include "config.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$event_id = $_GET['event_id'];
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<title>Book Ticket</title>
</head>
<body>

<div class="container">
<h2>Book Ticket</h2>

<form action="payment.php" method="POST">

<input type="hidden" name="event_id" value="<?php echo $event_id; ?>">

<label>Number of Tickets:</label>
<input type="number" name="quantity" required min="1">

<button type="submit" name="proceed">Proceed to Payment</button>

</form>

</div>
</body>
</html>