<?php
include 'config.php';

if (!isset($_GET['id'])) {
    header('Location: user.php');
    exit;
}

$product_id = $_GET['id'];

$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://poseidon-code.github.io/supacons/dist/supacons.all.css" >

    <title>Product Description</title>
  </head>
  <body>
    <!-- คัดลอกโค้ด navbar จากหน้า index.php มาวางที่นี่ -->

    <div class="container mt-5">
      <h2><?= $product['name']; ?></h2>
      <img src="<?= $product['image']; ?>">
      <p><?= $product['description']; ?></p>
      <a href="user.php">Back to products</a>
    </div>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  </body>
</html>
