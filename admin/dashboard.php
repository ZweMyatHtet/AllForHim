<?php
require_once "../user/dbconn.php";
if (!isset($_SESSION)) session_start();

// Get total orders
$stmt = $conn->query("SELECT COUNT(*) FROM orders");
$totalOrders = $stmt->fetchColumn();

// Get total sales
$stmt = $conn->query("SELECT SUM(price * quantity) FROM order_items");
$totalSales = $stmt->fetchColumn();

// Get top-selling product
$stmt = $conn->query("
    SELECT products.name, SUM(order_items.quantity) AS total_sold 
    FROM order_items
    JOIN products ON order_items.product_id = products.product_id
    GROUP BY order_items.product_id 
    ORDER BY total_sold DESC 
    LIMIT 1
");
$topProduct = $stmt->fetch(PDO::FETCH_ASSOC);

// Get recent 10 orders with user name and product name
$stmt = $conn->query("
    SELECT 
        o.order_id,
        u.name AS user_name,
        o.order_date,
        p.name AS product_name,
        oi.quantity,
        oi.price
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN products p ON oi.product_id = p.product_id
    ORDER BY o.order_date DESC
    LIMIT 10
");
$recentOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
  body {
    background: #f4f7fa;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
  }

  h2 {
    font-weight: 700;
    color: #212529;
  }

  .card {
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out;
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  }

  .card .card-body h5 {
    font-weight: 600;
    font-size: 1.3rem;
    margin-bottom: 0.3rem;
  }

  .card .card-body p.fs-4 {
    font-weight: 700;
    font-size: 2.2rem;
    color: #ffffff;
  }

  .btn-secondary {
    border-radius: 50px;
    padding: 0.5rem 1.5rem;
    font-weight: 600;
    transition: background-color 0.3s ease;
  }

  .btn-secondary:hover {
    background-color: #0056b3;
    color: #fff;
  }

  table thead {
    background-color: #007bff;
    color: #fff;
  }

  table thead th {
    font-weight: 600;
    text-align: center;
  }

  table tbody td {
    vertical-align: middle;
    text-align: center;
    font-size: 0.95rem;
    color: #555;
  }

  table tbody tr:hover {
    background-color: #e9f5ff;
  }

  .badge-top-product {
    background-color: #ffc107;
    color: #212529;
    font-weight: 700;
    font-size: 0.9rem;
    padding: 0.4em 0.8em;
    border-radius: 20px;
    margin-top: 0.3rem;
    display: inline-block;
  }

  @media (max-width: 576px) {
    .card .card-body p.fs-4 {
      font-size: 1.8rem;
    }
  }
  </style>
</head>

<body>
  <div class="container mt-5">
    <h2 class="mb-4 text-center">📊 Admin Dashboard</h2>

    <div class="row g-4 mb-5">
      <div class="col-md-4">
        <div class="card text-center text-bg-primary p-3">
          <div class="card-body">
            <h5>Total Orders</h5>
            <p class="fs-4"><?= $totalOrders ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center text-bg-success p-3">
          <div class="card-body">
            <h5>Total Sales</h5>
            <p class="fs-4">$<?= number_format($totalSales, 2) ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center text-bg-warning p-3">
          <div class="card-body">
            <h5>Top Product</h5>
            <p class="fs-6 mb-0"><?= htmlspecialchars($topProduct['name'] ?? 'N/A') ?></p>
            <span class="badge-top-product">Sold: <?= $topProduct['total_sold'] ?? 0 ?> units</span>
          </div>
        </div>
      </div>
    </div>

    <a href="viewItem.php" class="btn btn-secondary mb-4">&larr; Back to Products</a>

    <h4 class="mb-3">🧾 Recent Orders</h4>
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead>
          <tr>
            <th>Order ID</th>
            <th>User Name</th>
            <th>Order Date</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Total Price</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($recentOrders as $order): ?>
          <tr>
            <td><?= $order['order_id'] ?></td>
            <td><?= htmlspecialchars($order['user_name']) ?></td>
            <td><?= date('M d, Y H:i', strtotime($order['order_date'])) ?></td>
            <td><?= htmlspecialchars($order['product_name']) ?></td>
            <td><?= $order['quantity'] ?></td>
            <td>$<?= number_format($order['price'] * $order['quantity'], 2) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>