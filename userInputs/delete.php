<?php
$host = 'localhost';
$dbname = 'db_test';
$username = 'root';
$password = '';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if (!isset($_GET['id'])) {
    die("No ID specified.");
  }

  $id = $_GET['id'];

  $stmt = $pdo->prepare("SELECT * FROM tbl_image WHERE id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  $image = $stmt->fetch();

  if (!$image) {
    die("Image not found.");
  }

  $image_path = 'uploads/' . $image['filename'];

  if (file_exists($image_path)) {
    unlink($image_path);
  }

  $sql = "DELETE FROM tbl_image WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->execute();

  header("Location: labAdd.php");
  exit();
} catch (PDOException $e) {
  die("Database error: " . $e->getMessage());
}