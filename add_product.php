<?php
include 'config.php';
?>


<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://poseidon-code.github.io/supacons/dist/supacons.all.css" >

    <title>Product Management System</title>
</head>
<body>

<div class="container mt-5">
    <h1>Add Product</h1>
    <form method="post">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description"></textarea>
      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Image URL</label>
        <input type="text" class="form-control" id="image" name="image">
      </div>
      <div class="mb-3">
        <label for="category">Category</label>
        <select class="form-control" id="category" name="category">
            <option value="esan_menu">อาหารอีสาน</option>
            <option value="north_menu">อาหารเหนือ</option>
            <option value="southern_menu">อาหารใต้</option>
            <option value="thai_menu">อาหารไทย</option>
        </select>

    
      </div>
      <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
      </div>
      <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $description = $_POST["description"];
  $image = $_POST["image"];
  $price = $_POST["price"];
  $category = $_POST["category"];
  echo  $category;
  $sql = "INSERT INTO products (name, description, image, category,price ) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssd", $name, $description, $image,$category ,$price);

  if ($stmt->execute()) {
    header("Location: admin.php");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
?>
<?php include 'footer.php'; ?>
</body>
</html>
