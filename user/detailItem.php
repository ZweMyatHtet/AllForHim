<?php
require_once "dbconn.php";

if (!isset($_SESSION)) {
    session_start();
}

$item = null;

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    try {
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
        $stmt->execute([$product_id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

// Set correct image path
$imagePath = '';
if ($item) {
    $imagePath = "../admin/" . $item['image'];
    if (!file_exists($imagePath)) {
        $imagePath = "img/default-product.jpg"; // fallback image
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Product Detail</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
  .card-img-top {
    object-fit: contain;
    width: 100%;
    height: 300px;
    background-color: #f8f9fa;
  }
  </style>
</head>

<body>
  <div class="container py-5">
    <?php if ($item): ?>
    <div class="card mx-auto shadow" style="max-width: 450px;">
      <img src="<?= $imagePath ?>" class="card-img-top" alt="Product Image">
      <div class="card-body">
        <h4 class="card-title"><?= htmlspecialchars($item['name']) ?></h4>
        <h5 class="text-success">$<?= number_format($item['price'], 2) ?></h5>
        <p class="card-text"><?= htmlspecialchars($item['description']) ?></p>
        <a href="userViewItem.php" class="btn btn-outline-secondary w-100">← Back to Shop</a>
      </div>
    </div>
    <?php else: ?>
    <div class="alert alert-warning text-center">⚠️ Product not found.</div>
    <?php endif; ?>
  </div>
</body>

</html>