<?php
session_start();
include "config.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'organizer'){
    echo "Access Denied!";
    exit();
}

if(isset($_POST['add'])){
    $event_id = $_POST['event_id'];
    $ticket_name = $_POST['ticket_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    mysqli_query($conn, "INSERT INTO ticket_types 
    (event_id, ticket_name, price, total_quantity)
    VALUES ('$event_id','$ticket_name','$price','$quantity')");

    echo "Ticket Type Added Successfully!";
}

$events = mysqli_query($conn, "SELECT * FROM events WHERE organizer_id=".$_SESSION['user_id']." AND status='approved'");
?>

<h2>Add Ticket Type</h2>

<form method="POST">
Event:
<select name="event_id" required>
<?php while($row = mysqli_fetch_assoc($events)) { ?>
    <option value="<?php echo $row['id']; ?>">
        <?php echo $row['title']; ?>
    </option>
<?php } ?>
</select>
<br><br>

Ticket Name: <input type="text" name="ticket_name" required><br><br>
Price: <input type="number" name="price" required><br><br>
Quantity: <input type="number" name="quantity" required><br><br>

<button type="submit" name="add">Add Ticket</button>
</form>

<br>
<a href="dashboard.php">Back to Dashboard</a>