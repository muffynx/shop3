<?php
include 'config.php';

$id = $_GET['id'];

$sql = "DELETE FROM products WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
  header("Location: admin.php");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
