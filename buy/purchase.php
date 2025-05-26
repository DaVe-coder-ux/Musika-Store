<?php
// purchase.php
$host = 'localhost';
$dbname = 'db_test';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $item_id = $_POST['item_id'] ?? null;

    if (!$item_id) {
        echo "Invalid request.";
        exit;
    }

    // Check current stock
    $stmt = $pdo->prepare("SELECT quantity FROM tbl_image WHERE id = :id");
    $stmt->execute(['id' => $item_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "Product not found.";
        exit;
    }

    if ((int)$product['quantity'] <= 0) {
        header("Location: buy.php");
        exit;
    }

    // Decrease quantity by 1
    $stmt = $pdo->prepare("UPDATE tbl_image SET quantity = quantity - 1 WHERE id = :id AND quantity > 0");
    $stmt->execute(['id' => $item_id]);

    header("Location: buy.php?id=$item_id&message=success");
    exit;

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
