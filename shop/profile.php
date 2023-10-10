<?php
session_start();

// ตรวจสอบว่ามีการเข้าสู่ระบบหรือไม่
if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit;
}

// คำสั่งเชื่อมต่อฐานข้อมูล
require_once "config.php";

$user_id = $_SESSION['id'];

$sql = "SELECT id, firstname, lastname, address, province, phone, role, email FROM users WHERE id = ?";

// ใช้ prepared statement เพื่อป้องกัน SQL injection
$stmt = mysqli_prepare($conn, $sql);

// ผูกตัวแปรกับ prepared statement
mysqli_stmt_bind_param($stmt, "i", $user_id);

// ประมวลผลคำสั่ง SQL
mysqli_stmt_execute($stmt);

// รับผลลัพธ์จากคำสั่ง SQL
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "ไม่พบข้อมูลผู้ใช้";
    exit;
}

// อย่าลืมปิด prepared statement และการเชื่อมต่อฐานข้อมูล
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Andika:ital@1&family=Audiowide&family=IBM+Plex+Sans+Thai:wght@400;500;700&family=Josefin+Sans&family=Pattaya&family=Pridi:wght@300;400&family=Roboto+Slab:wght@300;600&family=Source+Serif+Pro:ital,wght@0,300;1,400&family=Teko:wght@300&family=Ubuntu:wght@300&family=Zen+Dots&display=swap" rel="stylesheet">

<style>
    label{
        font-family: 'IBM Plex Sans Thai', sans-serif;
    }
</style>

    <title>Profile</title>
  </head>
  <body>


  <div class="container mt-5">
  <?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success" style="font-family: 'IBM Plex Sans Thai', sans-serif;">
      <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
    </div>
  <?php endif; ?>

    <div class="container mt-5">
      <h1 style="font-family: 'IBM Plex Sans Thai', sans-serif;">ข้อมูลส่วนตัว</h1>

      <div class="mb-3">
        <label for="firstname" class="form-label">ชื่อ</label>
        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $row['firstname']; ?>" readonly>
      </div>
      <!-- เพิ่มฟิลด์อื่นๆ ด้วยวิธีเดียวกัน -->
      <div class="mb-3">
        <label for="lastname" class="form-label">นามสกุล</label>
        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $row['lastname']; ?>" readonly>
      </div>

      <div class="mb-3">
        <label for="address" class="form-label">ที่อยู่ (สำหรับการจัดส่ง)</label>
        <input type="text" class="form-control" id="address" name="address" value="<?php echo $row['address']; ?>" readonly>
      </div>

      <div class="mb-3">
        <label for="province" class="form-label">จังหวัด (สำหรับการจัดส่ง)</label>
        <input type="text" class="form-control" id="province" name="province" value="<?php echo $row['province']; ?>" readonly>
      </div>

      <div class="mb-3">
        <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $row['phone']; ?>" readonly>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">อีเมล</label>
        <input type="text" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" readonly>
      </div>
      <a href="edit_profile.php" class="btn btn-primary" style="font-family: 'IBM Plex Sans Thai', sans-serif;">แก้ไขข้อมูลส่วนตัว</a>
      <a href="user.php" class="btn btn-success" style="font-family: 'IBM Plex Sans Thai', sans-serif;">กลับสู่หน้าเเรก</a>

    </div>
  </body>
</html>
