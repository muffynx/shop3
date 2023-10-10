<?php
session_start();


// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a product ID is received from ii.php
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Check if there is an existing cart in the session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Check if the product is already in the cart

        $_SESSION['cart'][$product_id] = 1; // Add the product with a quantity of 1
    
}

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
} else {
    header("Location: " . $_SERVER['REQUEST_URI']);

    exit;
}

// Handle increase/decrease/remove product quantity and empty cart actions
if (isset($_GET['action']) && isset($_GET['product_id'])) {
    $action = $_GET['action'];
    $product_id = $_GET['product_id'];

    if ($action == 'increase') {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += 1; // Increment the quantity
        } else {
            $_SESSION['cart'][$product_id] = 1; // Add the product with a quantity of 1
        }
        if ($_SESSION['cart'][$product_id] <= 0) {
            unset($_SESSION['cart'][$product_id]);
        }
    } elseif ($action == 'decrease') {
        $_SESSION['cart'][$product_id] -= 1;
    } elseif ($action == 'remove') {
        unset($_SESSION['cart'][$product_id]);
    } elseif ($action == 'empty') {
        $_SESSION['cart'] = array();
    }
}

// สร้างฟังก์ชันเพื่อเพิ่มข้อมูลการสั่งซื้อลงในฐานข้อมูล
function add_order_to_database($conn, $user_id, $cart) {

    echo "Cart contents:";
    print_r($cart);
    // เพิ่มรายการสั่งซื้อ
    $insert_order = "INSERT INTO orders (user_id) VALUES ($user_id)";
    $conn->query($insert_order);

    // รับ order_id ที่สร้างขึ้นล่าสุด
    $order_id = $conn->insert_id;

    // เพิ่มรายการสินค้าในตะกร้าสินค้าลงในตาราง order_items
    foreach ($cart as $product_id => $quantity) {
        $sql = "SELECT price FROM products WHERE id = " . $product_id;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $total_price = $row["price"] * $quantity;
            $insert_order_item = "INSERT INTO order_items (order_id, product_id, quantity, total_price) VALUES ($order_id, $product_id, $quantity, $total_price)";
            $conn->query($insert_order_item);
        }
    }
}


// ตรวจสอบว่ามีการกดปุ่มยืนยันคำสั่งซื้อหรือไม่
if (isset($_POST['submit_order'])) {
      // เรียกใช้ฟังก์ชัน add_order_to_database ด้วยค่า $conn, $user_id และ $cart
    add_order_to_database($conn, $user_id, $_SESSION['cart']);
    echo "<script>alert('คำสั่งซื้อของคุณถูกยืนยันแล้ว'); location.href='?action=empty';</script>";

    // ล้างตะกร้าสินค้าหลังจากยืนยันคำสั่งซื้อ
    unset($_SESSION['cart']);
}

// Retrieve the cart from the session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
?>

<!-- ต่อไปเป็นโค้ด HTML ของหน้าตะกร้าสินค้า -->
<!-- คุณสามารถลงโค้ดของคุณต่อจากนี้ได้ครับ -->


<!-- HTML for displaying the cart -->
<!DOCTYPE html>
<html lang="en">


</style>
    <script>
        function showForm() {
            let paymentType = document.getElementById("paymentType").value;
            let codForm = document.getElementById("codForm");
            let bankTransferForm = document.getElementById("bankTransferForm");

            if (paymentType === "cod") {
                codForm.classList.remove("hidden");
                bankTransferForm.classList.add("hidden");
            } else if (paymentType === "bankTransfer") {
                codForm.classList.add("hidden");
                bankTransferForm.classList.remove("hidden");
            }
        }
    </script>
    <style>
        .hidden {
            display: none;
        }
    </style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>




<div class="container" style="width: 100%; padding: 50px;">
    <h2>Shopping Cart</h2>
    <a href="?action=empty" class="btn btn-danger mb-3">Empty Cart</a>
    <?php
    $total = 0;
    foreach ($cart as $product_id => $quantity) {
        $sql = "SELECT * FROM products WHERE id = " . $product_id;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $subtotal = $row["price"] * $quantity;
            $total += $subtotal;
            ?>
            <!-- Your existing table rows here -->
            <?php
        }
    }
    ?>
    
    
    <table class="table">
        <thead>
            <tr>
               
                <th>Name</th>
                <th>Image</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($cart as $product_id => $quantity) {
                $sql = "SELECT * FROM products WHERE id = " . $product_id;
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <tr>
                        
                        <td><?php echo $row["name"]; ?></td>
                        <td><img src="<?php echo $row["image"]; ?>" alt="<?php echo $row["name"]; ?>" width="50" height="50"></td>
                        <td><?php echo $row["price"]; ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td>
                            <a href="?action=increase&product_id=<?php echo $product_id; ?>" class="btn btn-success btn-sm">+</a>
                            <a href="?action=decrease&product_id=<?php echo $product_id; ?>" class="btn btn-warning btn-sm">-</a>
                            <a href="?action=remove&product_id=<?php echo $product_id; ?>" class="btn btn-danger btn-sm">Remove</a>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-end">Total:</th>
                <th colspan="2" style="display: flex;"><?php echo $total; ?><h6 style="margin-left: 1rem;">THB</h6></th>
            </tr>
        </tfoot>
    </table>

    <div class="buy" style="display: flex; justify-content: space-between ;">
        <a href="user.php" style="text-decoration: none; color: #000; padding: 7px 25px; border: 1px solid #000;">Go Back To Shop</a>
        <select id="paymentType" onchange="showForm()">
        <option value="">เลือกวิธีการชำระเงิน</option>
        <option value="cod">เก็บปลายทาง</option>
        <option value="bankTransfer">โอนผ่านบัญชีธนาคาร</option>
    </select>
        <form method="post">
    <button type="submit" name="submit_order" style="text-decoration: none; color: #000; padding: 7px 25px; border: 1px solid #000;">Confirm Order</button>
</form>    </div>
</div>



        
<!----------  ---------->





        </div>


  
    <div id="codForm" class="hidden container">
    <h2 style="font-size: 15px; margin-top: 2rem;">เก็บปลายทาง</h2>
    <form action="process_order.php" method="post" enctype="multipart/form-data">
   
    <div class="mb-3">
        <label for="payment_method" class="form-label">ยืนยันช่องทางการชำระ:</label>
        <input type="text" id="payment_method" name="payment_method" class="form-control" required>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">ยืนยัน</button>
    </form>
</div>


<div id="bankTransferForm" class="hidden container">
    <h2 style="font-size: 15px; margin-top: 2rem;">โอนผ่านบัญชีธนาคาร</h2>
    <form action="process_order.php" method="post" enctype="multipart/form-data">
       
        <div class="mb-3">
            <label for="qrCode" class="form-label">คิวอาร์โค้ด:</label>
            <img src="your_qr_code_image_here.jpg" alt="QR Code" id="qrCode" class="img-thumbnail">
        </div>
        <div class="mb-3">
            <label for="transferSlip" class="form-label">แนบสลิป:</label>
            <input type="file" id="slip" name="slip" class="form-control" accept="image/*" required>
        </div>
        <div class="mb-3">
            <label for="transferAmount" class="form-label">จำนวนเงินที่โอน:</label>
            <input type="number" id="transferAmount" name="transferAmount" class="form-control" required>
</div>
<div class="mb-3">
        <label for="payment_method" class="form-label">ยืนยันช่องทางการชำระ:</label>
        <input type="text" id="payment_method" name="payment_method" class="form-control" required>
    </div>
<button type="submit" name="submit" class="btn btn-primary">ยืนยัน</button>
</form>
</div>
</div>


</div>
  </div>
</div>
  



<!---------- การำระเงิน ---------->

  </div>
    

<script>
    function showForm() {
        let paymentType = document.getElementById('paymentType').value;
        let codForm = document.getElementById('codForm');
        let bankTransferForm = document.getElementById('bankTransferForm');

        if (paymentType === 'cod') {
            codForm.classList.remove('hidden');
            bankTransferForm.classList.add('hidden');
        } else if (paymentType === 'bankTransfer') {
            codForm.classList.add('hidden');
            bankTransferForm.classList.remove('hidden');
        } else {
            codForm.classList.add('hidden');
            bankTransferForm.classList.add('hidden');
        }
    }
</script>
</body>
</html>