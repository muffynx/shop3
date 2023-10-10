<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();

// ตรวจสอบว่ามี user_id ใน session หรือไม่
if (!isset($_SESSION['id'])) {
    echo "You must be logged in to view order history.";
    exit;
}

// 1. สร้าง connection กับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. ใช้ user_id จาก session
$user_id = $_SESSION['id'];

// 3. เขียนคำสั่ง SQL ในการดึงข้อมูลจากตาราง orders, order_items และ products
$sql = "SELECT orders.id as order_id, orders.status as order_status, products.name as product_name,  products.image as product_img , users.firstname as username, users.lastname as lastname, order_items.quantity as quantity, order_items.total_price as total_price, orders.created_at as order_date
        FROM orders
        JOIN order_items ON orders.id = order_items.order_id
        JOIN products ON order_items.product_id = products.id
        JOIN users ON orders.user_id = users.id
        WHERE orders.user_id = $user_id";

$result = $conn->query($sql);

function get_total_items_in_cart() {
    if (isset($_SESSION['cart'])) {
        return array_sum($_SESSION['cart']);
    } else {
        return 0;
    }
}


$conn->close();
?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <!-- Add Bootstrap 5 CSS -->
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://poseidon-code.github.io/supacons/dist/supacons.all.css" >
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Andika:ital@1&family=Audiowide&family=IBM+Plex+Sans+Thai:wght@400;500;700&family=Josefin+Sans&family=Pattaya&family=Pridi:wght@300;400&family=Roboto+Slab:wght@300;600&family=Source+Serif+Pro:ital,wght@0,300;1,400&family=Teko:wght@300&family=Ubuntu:wght@300&family=Zen+Dots&display=swap" rel="stylesheet">
    <style>
    html{
        font-family: 'IBM Plex Sans Thai', sans-serif;
    }
</style>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light" style="border: 5px solid black; background-color: #FFF;">
      <div class="container">
        <a class="navbar-brand" href="index.php">
          <img src="" width="30" height="24" class="d-inline-block align-text-top">
          LOGO
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">

          <li class="nav-item"  style="font-size: 1.5rem; display: flex;">

          <div class="ac" style="display: flex;">
              <a class="nav-link" href="profile.php" style="margin-right: 2rem;">
              <i class="fa-solid fa-user" style="display: flex; padding: 5px 13px; border: 2px solid #000; border-radius: 25px; align-items: center;"><h5 style="margin-left: 1rem; transform: translateY(3px);">My Account</h5></i>
              </a>
          </div>
            </li>

         <div class="cart" style="display: flex; align-items: center;">
            <li class="nav-item">
              <a class="nav-link" href="cart.php" style="margin-right: 10px;">

              <span class="badge bg-danger"><?php echo get_total_items_in_cart(); ?></span>

              <i class="fa-solid fa-cart-shopping" style="font-size: 1.5rem;"></i>
              </a>

              <li class="nav-item">
                  <a href="order_history.php"><i class="fa-duotone fa-treasure-chest" style="font-size: 1.5rem; margin-right: 1rem; color: #000;"></i></a>
            </li>


            <li class="nav-item">
              <a class="nav-link" href="logout.php" style="padding: 7px 15px; background: #000; color: #FFF; border: 1px solid #000; margin-right: 10px;">Logout</a>
            </li>
         </div>
           
            </li>
          </ul>
        </div>
      </div>
    </nav>




<div class="container" style="padding: 60px;  font-family: 'IBM Plex Sans Thai', sans-serif;">

<div class="goback" style="display: flex; justify-content: space-between;">
    <h1 class="my-4">Order History</h1>  
      <a href="user.php" style="text-decoration: none; font-size: 15px; padding: 7px 15px; border: 2px solid #000; height: 40px; transform: translateY(30px); font-family: 'IBM Plex Sans Thai', sans-serif; font-weight: 300; color: #000;">หน้าเเรก</a>
</div>
<?php while ($row = $result->fetch_assoc()): ?>
    <div class="card mb-3">
        <div class="card-body" style="display: flex; justify-content: space-between;">
            <p class="card-text">วันที่การสั่งซื้อ: <?= $row["order_date"] ?></p>
            <p class="card-text">ชื่อ: <?= $row["username"] . " " .$row["lastname"] ?></p>
            <p class="card-text">ชื่อสินค้า: <?= $row["product_name"] ?></p>
            <img src="<?= $row['product_img']; ?>" style="width: 100px;">
            <p class="card-text">จำนวน: <?= $row["quantity"] ?> ชิ้น</p>
            <p class="card-text">รวมราคาทั้งสิ้น: <?= $row["total_price"] ?> บาท</p>
            <p class="card-text" style="padding: 5px 15px; height: 40px;">Status: <?= $row["order_status"] ?></p>
        </div>
    </div>
<?php endwhile; ?>
</div>
    <!-- Add Bootstrap 5 JS -->

    <?php include 'footer.php'; ?>

