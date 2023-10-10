<?php
session_start();
include 'config.php';

if (!isset($_SESSION['id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Admin Page</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item">
                        <a class="nav-link" href="product.php">Product</a>
                    </li>
                  
                    <li class="nav-item">
                        <a class="nav-link" href="table_user.php">User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="order_items.php">Order Items</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="orders.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">User_ID</th>
                    <th scope="col">Created_at</th>
                    <th scope="col">Status</th>
                    <th scope="col">payment_method</th>
                    <th scope="col">transfer_amount</th>
                    <th scope="col">order_date</th>
                    <th scope="col">order_status</th>
             
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <th scope="row"><?= $row['id']; ?></th>
                        <td><?= $row['user_id']; ?></td>
                        <td><?= $row['created_at']; ?></td>
                        <td><?= $row['status']; ?></td>
                        <td><?= $row['payment_method']; ?></td>
                        <td><?= $row['transfer_amount']; ?></td>
                        <td><?= $row['order_date']; ?></td>
                        <td><?= $row['order_status']; ?></td>
                 
                    </tr>
                <?php endwhile; ?>
            </tbody>

  </table>
</div>



   
 
</body>
</html>
