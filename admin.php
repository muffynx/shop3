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

$sql = "SELECT * FROM products";
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
    <a class="nav-link bg-primary" href="add_product.php" style=" padding: 10px 20px; width: 150px; color: aliceblue; border-radius: 15px; margin-bottom: 2rem;">Add product</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Price</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <th scope="row"><?= $row['id']; ?></th>
                        <td><?= $row['name']; ?></td>
                        <td><img src="<?= $row['image']; ?>" alt="<?= $row['name']; ?>" style="width: 100px; height: auto;"></td>
                        <td><?= number_format($row['price'], 2); ?> THB</td>
                        <td><?= $row['description']; ?></td>
                        <td>
                            <a href="edit_product.php?id=<?= $row['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="delete_product.php?id=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>

  </table>
</div>



   
 
</body>
</html>
