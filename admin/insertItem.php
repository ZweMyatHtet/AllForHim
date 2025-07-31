<?php
require_once "../user/dbconn.php";
if (!isset($_SESSION)) session_start();

// Fetch categories
$sql = "SELECT * FROM categories";
$stmt = $conn->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll();

// Fetch admins
$sqlAdmins = "SELECT admin_id, username FROM admins";
$stmtAdmins = $conn->prepare($sqlAdmins);
$stmtAdmins->execute();
$admins = $stmtAdmins->fetchAll();

// Handle form submission
if (isset($_POST['insertItem'])) {
    $pName = $_POST['pName'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $fileName = $_FILES['img']['name'];
    $filePath = "img/" . $fileName;
    $status = move_uploaded_file($_FILES['img']['tmp_name'], $filePath);
    $stock = $_POST['stock'];
    $added_by = $_POST['added_by'];

    if ($status) {
        $sql = "INSERT INTO products VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $status = $stmt->execute([null, $category, $pName, $description, $price, $brand, $filePath, $stock, $added_by]);
        $lastId = $conn->lastInsertId();
        if ($status) {
            $_SESSION['insertSuccess'] = "Product with ID $lastId has been inserted successfully!";
            header("Location: viewItem.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Insert Product</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  body {
    margin: 0;
    padding: 0;
    min-height: 100vh;
    background: #000;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Segoe UI', sans-serif;
  }

  .glass-form {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border-radius: 1.5rem;
    box-shadow: 0 8px 32px rgba(255, 255, 255, 0.25);
    padding: 2.5rem;
    width: 100%;
    max-width: 600px;
    color: #fff;
    position: relative;
  }

  .glass-form h4 {
    text-align: center;
    font-weight: 700;
    margin-bottom: 2rem;
    color: #fff;
  }

  .form-label {
    font-weight: 600;
    color: #fff;
  }

  .form-control,
  .form-select {
    background-color: rgba(255, 255, 255, 0.15);
    color: #fff;
    border: none;
    border-radius: 0.75rem;
  }

  .form-control::placeholder {
    color: #ddd;
  }

  .form-control:focus,
  .form-select:focus {
    box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.4);
  }

  .btn-primary {
    background-color: #fff;
    color: #000;
    border: none;
    padding: 0.6rem 2rem;
    border-radius: 2rem;
    font-weight: 600;
  }

  .btn-primary:hover {
    background-color: #e0e0e0;
    color: #000;
  }

  .back-button {
    position: absolute;
    top: 1rem;
    left: 1rem;
    text-decoration: none;
    color: #fff;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.25rem;
  }

  .back-button:hover {
    text-decoration: underline;
  }
  </style>
</head>

<body>
  <div class="glass-form">
    <a href="viewItem.php" class="back-button">&larr; Back</a>
    <h4>Insert New Product</h4>
    <form enctype="multipart/form-data" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
      <div class="mb-3">
        <label class="form-label">Product Name</label>
        <input type="text" class="form-control" name="pName" placeholder="e.g. Slim Jeans" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number" class="form-control" name="price" placeholder="e.g. 24900" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" rows="3" placeholder="Enter product details..."
          required></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category" class="form-select" required>
          <option value="">Select Category</option>
          <?php foreach ($categories as $category): ?>
          <option value="<?= $category['category_id'] ?>"><?= $category['name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Brand</label>
        <input type="text" class="form-control" name="brand" placeholder="e.g. Levi’s" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Product Image</label>
        <input type="file" class="form-control" name="img" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Stock</label>
        <input type="number" class="form-control" name="stock" required>
      </div>

      <div class="mb-4">
        <label class="form-label">Added By</label>
        <select name="added_by" class="form-select" required>
          <option value="">Select Admin</option>
          <?php foreach ($admins as $admin): ?>
          <option value="<?= $admin['admin_id']; ?>"><?= $admin['username']; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-primary" name="insertItem">Insert Product</button>
      </div>
    </form>
  </div>
</body>

</html>