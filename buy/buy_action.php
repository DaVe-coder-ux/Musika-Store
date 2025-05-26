<?php
session_start();

$host = 'localhost';
$dbname = 'db_test';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $itemId = $_POST['item_id'];

        // Get current quantity
        $stmt = $pdo->prepare("SELECT quantity FROM tbl_image WHERE id = :id");
        $stmt->execute(['id' => $itemId]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item && $item['quantity'] > 0) {
            $newQty = $item['quantity'] - 1;

            // Update quantity
            $update = $pdo->prepare("UPDATE tbl_image SET quantity = :qty WHERE id = :id");
            $update->execute(['qty' => $newQty, 'id' => $itemId]);

            // Optional: remove from session cart
            unset($_SESSION['cart'][$itemId]);

            echo "<script>alert('Purchase successful!'); window.location.href='main.php';</script>";
        } else {
            echo "<script>alert('Out of stock!'); window.location.href='main.php';</script>";
        }
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
