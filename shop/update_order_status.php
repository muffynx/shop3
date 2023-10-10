<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update order status
    $order_id = $_POST["order_id"];
    $order_status = $_POST["order_status"];
    
    // Update database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "nshop";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $order_status, $order_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Order status updated successfully.";
    } else {
        
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order Status</title>
    <!-- Add your Bootstrap and other CSS files here -->
</head>
<body>
    <h1>Update Order Status</h1>
    <form action="update_order_status.php" method="post">
        <label for="order_id">Order ID:</label>
        <input type="number" id="order_id" name="order_id" required>
        
        <label for="order_status">Order Status:</label>
        <select id="order_status" name="order_status" required>
            <option value="pending">Pending</option>
            <option value="processing">Processing</option>
            <option value="completed">Completed</option>
            <option value="canceled">Canceled</option>
        </select>
        
        <button type="submit">Update</button>
    </form>
    <!-- Add your Bootstrap and other JS files here -->
    <script>
function changeBackgroundColor() {
    const status = document.getElementById("order_status").value;
    let bgColor;

    switch (status) {
        case "pending":
            bgColor = "#FFC107"; // Yellow
            break;
        case "processing":
            bgColor = "#007BFF"; // Blue
            break;
        case "completed":
            bgColor = "#28A745"; // Green
            break;
        case "canceled":
            bgColor = "#DC3545"; // Red
            break;
        default:
            bgColor = "#FFFFFF"; // White
    }

    

    document.body.style.backgroundColor = bgColor;
}

// Attach change event listener to the order status select element
document.getElementById("order_status").addEventListener("change", changeBackgroundColor);
</script>

</body>
</html>
