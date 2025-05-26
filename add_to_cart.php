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
        $itemId = $_POST['item_id'] ?? null;

        // Validate item_id
        if (!$itemId || !is_numeric($itemId)) {
            $_SESSION['alert'] = 'invalid_id';
            header("Location: shopNow.php");
            exit;
        }

        // Use transaction to prevent race condition
        $pdo->beginTransaction();

        // Lock the row for update
        $stmt = $pdo->prepare("SELECT quantity FROM tbl_image WHERE id = :id FOR UPDATE");
        $stmt->execute(['id' => $itemId]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$item) {
            $pdo->rollBack();
            $_SESSION['alert'] = 'not_found';
            header("Location: shopNow.php");
            exit;
        }

        if ($item['quantity'] > 0) {
            $newQty = $item['quantity'] - 1;

            $update = $pdo->prepare("UPDATE tbl_image SET quantity = :qty WHERE id = :id");
            $update->execute(['qty' => $newQty, 'id' => $itemId]);

            $pdo->commit();
            $_SESSION['alert'] = 'success';
        } else {
            $pdo->rollBack();
            $_SESSION['alert'] = 'out_of_stock';
        }

        header("Location: shopNow.php");
        exit;
    } else {
        $_SESSION['alert'] = 'invalid_request';
        header("Location: shopNow.php");
        exit;
    }

} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['alert'] = 'error';
    header("Location: shopNow.php");
    exit;
}
