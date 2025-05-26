<?php

$host = 'localhost';
$dbname = 'db_test';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $filename = $_FILES['image']['name'];
        $tempname = $_FILES['image']['tmp_name'];
        $folder = "uploads/" . $filename;

        $name = $_POST['name'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        if (move_uploaded_file($tempname, $folder)) {
            $stmt = $pdo->prepare("INSERT INTO tbl_image(filename, name, price, quantity) VALUES (:filename, :name, :price, :quantity)");
            $stmt->execute([
                'filename' => $filename,
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity
            ]);
            echo "<script>alert('Product Uploaded Successfully!');
                setTimeout(function() {
                    window.location.href = 'labAdd.php';
                    }, 1000);
                     </script>";
            exit;
        } else {
            echo "Failed to upload image.";
        }
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Image Upload Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: rgba(0, 0, 0, 0.3);
            font-family: 'lucida calligraphy', cursive;
        }

        .input-group input,
        .input-group .form-control {
            border: 1px solid black;
        }

        .container {
            max-width: 1000px;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        img.preview-img {
            width: auto;
            height: auto;
            max-width: 100%;
            max-height: 100%;
            margin: 0 auto;
            display: block;
            object-fit: conatain;
        }

        td.image-box {
            width: 250px;
            height: 150px;
            text-align: center;
            vertical-align: middle;
            background-color: #fff;
        }

        td.text-center {
            vertical-align: middle;
        }

        h2,
        h4,
        th {
            font-family: 'segoe script', cursive;
        }

        tr:hover {
            background-color: transparent !important;
        }
    </style>
</head>

<body>
    <!-- <a href="../LAB(HAHAHA)/labWeb.html" class="btn btn-dark" style="position: absolute; top: 20px; left: 20px; z-index: 1000;">
    Return
</a> -->
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Image Upload Manager</h2>

        <form action="" method="post" enctype="multipart/form-data" class="mb-5">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Price</label>
                    <input type="number" step="any" name="price" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Quantity</label>
                    <input type="number" step="any" name="quantity" class="form-control">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-warning w-100">Upload</button>
                </div>
            </div>
        </form>

        <h4 class="mb-3">Uploaded Images</h4>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Preview</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $images = $pdo->query("SELECT * FROM tbl_image ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($images as $img):
                ?>
                    <tr>
                        <td class="image-box">
                            <img src="uploads/<?= htmlspecialchars($img['filename']) ?>" class="preview-img rounded">
                        </td>
                        <td><?= htmlspecialchars($img['name']) ?></td>
                        <td><?= number_format((float) $img['price'], 2) ?></td>
                        <td><?= number_format((int) $img['quantity']) ?></td>
                        <td>
                            <div class="d-flex" style="gap: 5px;">
                                <a href="edit.php?id=<?= $img['id'] ?>" class="btn btn-sm btn-dark">Edit</a>
                                <a href="delete.php?id=<?= $img['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-warning">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>