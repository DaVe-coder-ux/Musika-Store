<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");

$host = 'localhost';
$dbname = 'db_test';
$username = 'root';
$password = '';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $search = $_GET['search'] ?? '';

  if (!empty($search)) {
    $sql = "SELECT * FROM tbl_image WHERE name LIKE :search OR price LIKE :search OR quantity LIKE :search";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['search' => "%$search%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } else {
    $results = $pdo->query("SELECT * FROM tbl_image ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
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
  <title>Shop Now!</title>
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="labWebShopNow.css" />
  <style>
    html, body {
      height: 100%;
      margin: 0;
    }
    .page-wrapper {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    main {
      flex: 1;
    }
  </style>
</head>
<body>
  <div class="page-wrapper">
    <header class="bg">
      <input type="checkbox" id="menu-toggle" />
      <label for="menu-toggle" class="hamburger">
        <span></span><span></span><span></span>
      </label>
      <ul class="menu">
        <li><a class="nav_link" href="labWeb.php">Home</a></li>
        <li><a class="nav_link" href="labWeb3D.html">Products</a></li>
        <li><a class="nav_link" href="shopNow.php">Shop Now!</a></li>
        <li><a class="nav_link" href="labWebAbout.html">About</a></li>
      </ul>
    </header>

    <header style="display: flex; justify-content: space-between; align-items: center;">
      <div class="nav">
        <a href="pic.html">
          <img src="IMG_20241012_131430.jpg" class="logo" />
        </a>
      </div>
      <div class="search-container">
        <form method="get">
          <input type="search" name="search" placeholder="Search Items..." value="<?= htmlspecialchars($search) ?>" style="border: 1px solid black; border-radius: 4px; padding: 5px;">
          <button type="submit" style="border: 1px solid black; padding: 5px; border-radius: 4px;">Search</button>
        </form>
      </div> 
    </header>

    <main>
      <h1>SHOP NOW!</h1>
      <div class="b-cont">
        <div class="dyn-bk-cont">
          <?php if ($results): ?>
            <?php foreach ($results as $row): ?>
              <div class="item-card">
                <div class="item-content">
                  <img src="/userInputs/uploads/<?= htmlspecialchars($row['filename']) ?>" class="preview-img" />
                  <div class="item-details">
                    <h3 class="n"><?= htmlspecialchars($row['name']) ?></h3>
                    <div class="bro">
                      <p class="price">&#8369;<?= number_format((float)$row['price'], 2) ?></p>
                    </div>
                    <div class="bro">
                      <p class="p">Stocks: <?= (int)$row['quantity'] ?></p>
                      <form method="post" action="add_to_cart.php">
                        <input type="hidden" name="item_id" value="<?= $row['id'] ?>" />
                        <button type="submit" class="add-cart-btn">
                          <?= $row['quantity'] <= 0 ? 'Out of Stock' : 'Add to Cart' ?>
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>No products found.</p>
          <?php endif; ?>
        </div>
      </div>
    </main>

    <footer>
      <p>&copy; 2024 Musika. All rights reserved.</p>
    </footer>
  </div>

  <script>
    <?php if (isset($_SESSION['alert'])): ?>
      <?php
      $alerts = [
        'success' => 'Added to cart successfully!',
        'out_of_stock' => 'Sorry, we are out of stock.',
        'not_found' => 'Item not found.',
        'invalid_id' => 'Invalid item selected.',
        'invalid_request' => 'Invalid request.',
        'error' => 'Something went wrong.'
      ];
      $msg = $alerts[$_SESSION['alert']] ?? 'Unknown error';
      ?>
      alert('<?= $msg ?>');
      <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>
  </script>
</body>
</html>
