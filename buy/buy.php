<?php
// buy.php
session_start();

$host = 'localhost';
$dbname = 'db_test';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_GET['id'] ?? null;

    if (!$id) {
        echo "Invalid product.";
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM tbl_image WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "Product not found.";
        exit;
    }

    // Handle purchase
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($product['quantity'] > 0) {
            // Decrease quantity by 1
            $newQty = $product['quantity'] - 1;
            $updateStmt = $pdo->prepare("UPDATE tbl_image SET quantity = :qty WHERE id = :id");
            $updateStmt->execute(['qty' => $newQty, 'id' => $id]);

            echo "<script>alert('Successfully purchased'); window.location.href = 'buy.php?id=$id';</script>";
            exit;
        } else {
            echo "<script>alert('Out of stock'); window.location.href = 'shopNow.php';</script>";
            exit;
        }
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Buy Now</title>
    <link rel="stylesheet" href="buy.css" />
</head>
<body>
    <!-- <header class="bg">
        <input type="checkbox" id="menu-toggle" />
        <label for="menu-toggle" class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </label>
        <ul class="menu">
            <li><a class="nav_link" href="../LAB(HAHAHA)/labWeb.html">Home</a></li>
            <li><a class="nav_link" href="../LAB(HAHAHA)/labWeb3D.html">Products</a></li>
            <li><a class="nav_link" href="../LAB(HAHAHA)/main.php">Shop Now!</a></li>
            <li><a class="nav_link" href="../LAB(HAHAHA)/labWebAbout.html">About</a></li>
        </ul>
    </header> -->

    <header>
        <div class="nav">
            <a href="../LAB(HAHAHA)/pic.html">
                <img src="../LAB(HAHAHA)/IMG_20241012_131430.jpg" class="logo" />
            </a>
        </div>
    </header>

    <!-- Return Arrow Button -->
    <ul>
        <li class="return">
            <a href="../LAB(HAHAHA)/shopNow.php">
                <span class="span"></span>
            </a>
        </li>
    </ul>

    <div class="container">
        <div class="images">
            <img src="/userInputs/uploads/<?= htmlspecialchars($product['filename']) ?>" class="guitar" alt="Product Image" />
        </div>
        <div class="product">
            <h3><?= htmlspecialchars($product['name']) ?></h3>
            <h3>₱<?= number_format((float)$product['price'], 2) ?></h3>
            <p class="description">
                This is a great instrument that fits both beginners and experienced musicians. Order now and enjoy making music!
            </p>

            <div class="bro">
            <label class="pick">Available Stocks: <?= htmlspecialchars($product['quantity']) ?></label><br />
            
            <form method="post">
                <input type="hidden" name="item_id" value="<?= $product['id'] ?>" />
                <div class="buttons">
                    <button type="submit" class="add">Buy Now</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Musika. All rights reserved.</p>
    </footer>
</body>
</html>
