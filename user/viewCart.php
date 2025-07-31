<?php
require_once "dbconn.php";
if (!isset($_SESSION)) session_start();

// Login check: customer_id and clogin=true required
if (!isset($_SESSION['customer_id']) || !isset($_SESSION['clogin']) || $_SESSION['clogin'] !== true) {
  header("Location: clogin.php");
  exit();
}

// Fetch product info by product ID
function itemInfo($id) {
    global $conn;
    try {
        $sql = "SELECT p.product_id, p.name, p.price, p.description, p.stock, p.brand, p.image, c.name AS category_name
                FROM products p
                JOIN categories c ON p.category_id = c.category_id
                WHERE p.product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

// Update quantities in session cart if posted
if (isset($_POST['qty']) && is_array($_POST['qty'])) {
    foreach ($_POST['qty'] as $productId => $qty) {
        if (is_numeric($productId) && is_numeric($qty) && $qty > 0) {
            $_SESSION['cart'][$productId] = $qty;
        }
    }
}

// Handle checkout / pay now
if (isset($_POST['payNow'])) {
    // Make sure user is logged in (check customer_id session)
    if (!isset($_SESSION['customer_id'])) {
        echo "<script>alert('You must be logged in to checkout.'); window.location='clogin.php';</script>";
        exit;
    }

    $userId = $_SESSION['customer_id'];
    $orderDate = date('Y-m-d H:i:s');

    try {
        // Insert new order record
        $sql = "INSERT INTO orders (user_id, order_date) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$userId, $orderDate]);
        $orderId = $conn->lastInsertId();

        // Insert each cart item into order_items
        $sqlItem = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmtItem = $conn->prepare($sqlItem);

        foreach ($_SESSION['cart'] as $prodId => $qty) {
            $product = itemInfo($prodId);
            if ($product) {
                $totalPrice = $product['price'] * $qty;  
                $stmtItem->execute([$orderId, $prodId, $qty, $totalPrice]);
            }
        }

        // Clear the cart session after successful order
        unset($_SESSION['cart']);
        header("Location: thankyou.php");
        exit;

    } catch (PDOException $e) {
        echo "Checkout failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Your Cart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
  .cart-img {
    width: 60px;
    height: 60px;
    object-fit: contain;
  }

  .qty-input {
    width: 70px;
  }

  .credit-card-box {
    max-width: 400px;
    margin: auto;
    background: #f8f9fa;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
  }

  .credit-card-box label {
    margin-top: 10px;
  }
  </style>
</head>

<body>
  <div class="container my-5">
    <h2 class="mb-4">🛒 Your Shopping Cart</h2>

    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
    <form method="post" id="cartForm">
      <table class="table table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Category</th>
            <th>Image</th>
            <th>Quantity</th>
            <th>Amount</th>
            <th class="text-center align-middle">Remove</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $id => $qty):
              $product = itemInfo($id);
              if (!$product) continue;
              $amount = $product['price'] * $qty;
              $total += $amount;
              $imagePath = "../admin/" . $product['image'];
              if (!file_exists($imagePath)) $imagePath = "img/default-product.jpg";
          ?>
          <tr>
            <td><?= htmlspecialchars($product['name']) ?></td>
            <td>$<span class="price"><?= number_format($product['price'], 2) ?></span></td>
            <td><?= htmlspecialchars($product['category_name']) ?></td>
            <td><img src="<?= $imagePath ?>" class="cart-img"></td>
            <td><input type="number" name="qty[<?= $id ?>]" class="form-control qty-input qty-field" value="<?= $qty ?>"
                min="1" /></td>
            <td>$<span class="amount"><?= number_format($amount, 2) ?></span></td>
            <td class="text-center align-middle"><a href="addCart.php?did=<?= urlencode($id) ?>"
                class="btn btn-danger btn-sm">&times;</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="d-flex justify-content-between align-items-center">
        <a href="userViewItem.php" class="btn btn-outline-primary">&larr; Back to Shop</a>
        <div class="fw-bold fs-5">Total: $<span id="totalAmount"><?= number_format($total, 2) ?></span></div>
      </div>

      <div class="credit-card-box mt-5">
        <h5 class="mb-3 text-center">💳 Secure Payment</h5>
        <div class="mb-3">
          <label for="paymentOption">Payment Method</label>
          <select id="paymentOption" name="paymentOption" class="form-select" required>
            <option value="">Choose...</option>
            <option value="ayaMPU">Visa Card</option>
            <option value="ayaCredit">Master Card</option>
            <option value="ayaVISA">Discover</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="cardNumber">Card Number</label>
          <input type="text" id="cardNumber" name="cardNumber" class="form-control" required
            pattern="^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9]{2})[0-9]{12})$"
            title="Enter a valid card number like Visa or MasterCard" placeholder="e.g., 4111111111111111" />
        </div>
        <button type="submit" name="payNow" class="btn btn-success w-100">Pay Now</button>
      </div>
    </form>
    <?php else: ?>
    <div class="alert alert-warning">Your cart is empty.</div>
    <a href="userViewItem.php" class="btn btn-primary mt-3">Go Shopping</a>
    <?php endif; ?>
  </div>

  <script>
  document.querySelectorAll('.qty-field').forEach(field => {
    field.addEventListener('change', () => {
      document.getElementById('cartForm').submit();
    });
  });

  document.querySelectorAll('.qty-field').forEach(input => {
    input.addEventListener('input', () => {
      const row = input.closest('tr');
      const price = parseFloat(row.querySelector('.price').innerText);
      const qty = parseInt(input.value);
      const newAmount = price * qty;
      row.querySelector('.amount').innerText = newAmount.toFixed(2);

      let total = 0;
      document.querySelectorAll('.amount').forEach(amount => {
        total += parseFloat(amount.innerText);
      });
      document.getElementById('totalAmount').innerText = total.toFixed(2);
    });
  });
  </script>
</body>

</html>