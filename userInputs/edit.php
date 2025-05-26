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

    $id = (int) $_GET['id'];

    // Fetch old image
    $stmt = $pdo->prepare("SELECT * FROM tbl_image WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $image = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$image) {
        die("Image not found.");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

if (!empty($_FILES['image']['name'])) {
    $filename = $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name'];
    $folder = "uploads/" . $filename;

    if (move_uploaded_file($tempname, $folder)) {
        if (file_exists('uploads/' . $image['filename'])) {
            unlink('uploads/' . $image['filename']);
        }
    } else {
        echo "Failed to upload.";
        exit;
    }
} else {
    $filename = $image['filename'];
}

$stmt = $pdo->prepare("UPDATE tbl_image SET filename = :filename, name = :name, price = :price, quantity = :quantity WHERE id = :id");
$stmt->execute([
    'filename' => $filename,
    'name' => $name,
    'price' => $price,
    'id' => $id,
    'quantity' => $quantity

]);

header('Location: labAdd.php');
exit;
         }
    } catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Image</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding-top: 50px;
            font-family: 'lucida calligraphy', cursive;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            max-width: 700px;
        }

        img {
            border-radius: 8px;
        }

        .form-section {
            display: flex;
            flex-wrap: wrap;
        }

        .details-section {
            flex: 1;
        }

        h2, label {
            font-family: 'segoe script', cursive;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4 text-center">Edit Image</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-section mb-4">
                <div class="image-preview">
                    <label class="form-label">Current Image:</label><br>
                    <img src="uploads/<?= htmlspecialchars($image['filename']) ?>" width="200">
                </div>
                <div class="details-section">
                    <div class="mb-3">
                        <label class="form-label">Name:</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($image['name'] ?? '') ?>" class="form-control">
                    </div>
                    <div class="mb-3" style="margin-top: 50px;">
                        <label class="form-label">Price:</label>
                        <input type="text" name="price" value="<?= htmlspecialchars($image['price'] ?? '') ?>" class="form-control">
                    </div>
                    <div class="mb-3" style="margin-top: 50px;">
                        <label class="form-label">Quantity:</label>
                        <input type="text" name="quantity" value="<?= htmlspecialchars($image['quantity'] ?? '') ?>" class="form-control">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">New Image:</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-dark">Save Changes</button>
                <a href="labAdd.php" class="btn btn-warning">Back</a>
            </div>
        </form>
    </div>
</body>
</html>