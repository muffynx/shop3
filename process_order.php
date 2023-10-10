<?php

session_start();

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
  } else {
    echo "ไม่พบผู้ใช้งาน";
    exit;
  }
// ตั้งค่าการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nshop";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);


// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['id']; 
  $payment_method = $_POST['payment_method'];

  if (isset($_FILES['slip']) && $_FILES['slip']['error'] === UPLOAD_ERR_OK) {
    $temp_file = $_FILES['slip']['tmp_name'];
    $destination_path = 'slip/' . $_FILES['slip']['name']; // Specify the destination directory and filename

    if (move_uploaded_file($temp_file, $destination_path)) {
        // File was successfully saved to your device
        $slip = base64_encode(file_get_contents($destination_path));
    } else {
        // Error occurred while moving the file
        echo "Failed to move the uploaded file.";
        $slip = NULL;
    }
} else {
    $slip = NULL;
}

  $transfer_amount = isset($_POST['transferAmount']) ? $_POST['transferAmount'] : NULL;
  $order_date = date("Y-m-d H:i:s");
  $order_status = "รอยืนยัน";

  $sql = "INSERT INTO orders (user_id, payment_method, transfer_slip, transfer_amount, order_date, order_status) VALUES (?, ?, ?, ?, ?, ?)";

  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("isssss", $user_id, $payment_method, $slip, $transfer_amount, $order_date, $order_status);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
     echo "คำสั่งซื้อของคุณถูกเพิ่มเข้าสู่ระบบเรียบร้อยแล้ว กรุณากลับเพื่อกด Confirm Order ครับ";
    } else {
      echo "เกิดข้อผิดพลาดในการเพิ่มคำสั่งซื้อ: " . $stmt->error;
    }

    $stmt->close();
  } else {
    echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $conn->error;
  }
}

$conn->close();
?>
