<?php
require_once "../user/dbconn.php";
if (!isset($_SESSION)) {
    session_start();
}

try {
    $sql = "SELECT * FROM categories";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}

// Default: Fetch all items with category name
try {
    $sql = "SELECT p.product_id, p.name, p.description, p.price,
                   p.brand, p.image, p.stock, p.added_by,
                   c.name AS categories
            FROM products p
            JOIN categories c ON p.category_id = c.category_id";
    $stmt = $conn->query($sql);
    $items = $stmt->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}

// Filter by category
if (isset($_GET['cate'])) {
    $cid = $_GET['cateChoose'];
    try {
        $sql = "SELECT p.product_id, p.name, p.description, p.price,
                       p.brand, p.image, p.stock, p.added_by,
                       c.name AS categories
                FROM products p
                JOIN categories c ON p.category_id = c.category_id
                WHERE c.category_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$cid]);
        $items = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// Filter by price range
if (isset($_GET['priceRadio'])) {
    $range = $_GET['priceRange'];
    $lower = 0;
    $upper = 0;

    if ($range == 0) {
        $lower = 1;
        $upper = 100;
    } elseif ($range == 1) {
        $lower = 101;
        $upper = 200;
    } elseif ($range == 2) {
        $lower = 201;
        $upper = 300;
    }

    try {
        $sql = "SELECT p.product_id, p.name, p.description, p.price,
                       p.brand, p.image, p.stock, p.added_by,
                       c.name AS categories
                FROM products p
                JOIN categories c ON p.category_id = c.category_id
                WHERE p.price BETWEEN ? AND ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$lower, $upper]);
        $items = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// Filter by product name keyword
if (isset($_GET['bSearch'])) {
    $keyword = $_GET['wSearch'];
    try {
        $sql = "SELECT p.product_id, p.name, p.description, p.price,
                       p.brand, p.image, p.stock, p.added_by,
                       c.name AS categories
                FROM products p
                JOIN categories c ON p.category_id = c.category_id
                WHERE p.name LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["%" . $keyword . "%"]);
        $items = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>

<?php if (isset($_SESSION['adminId']) && isset($_SESSION['login'])) { ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>View Item</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <style>
  td,
  th {
    word-wrap: break-word;
    vertical-align: middle;
  }
  </style>

</head>

<body class="bg-light">
  <!-- Navbar -->
  <?php require_once "navbar.php"; ?>

  <!-- Page Container -->
  <div class="container-fluid px-4">
    <div class="row mt-3">
      <!-- Sidebar Filters -->
      <div class="col-md-3 col-lg-2 mb-4">
        <!-- Category filter -->
        <form action="viewItem.php" method="get" class="form border p-3 border-primary rounded mb-4 shadow-sm bg-white">
          <h6 class="fw-bold mb-3">Filter by Category</h6>
          <select name="cateChoose" class="form-select mb-3">
            <option disabled selected>Choose Category</option>
            <?php foreach ($categories as $category): ?>
            <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
            <?php endforeach; ?>
          </select>
          <button class="btn btn-outline-primary w-100 rounded-pill" name="cate" type="submit">Apply</button>
        </form>

        <!-- Price filter -->
        <form action="viewItem.php" method="get" class="form border p-3 border-primary rounded shadow-sm bg-white">
          <h6 class="fw-bold mb-3">Filter by Price</h6>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="priceRange" value="0" id="price0">
            <label class="form-check-label" for="price0">$1 - $100</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="priceRange" value="1" id="price1">
            <label class="form-check-label" for="price1">$101 - $200</label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="priceRange" value="2" id="price2">
            <label class="form-check-label" for="price2">$201 - $300</label>
          </div>
          <button class="btn btn-outline-primary w-100 rounded-pill" name="priceRadio" type="submit">Apply</button>
        </form>
      </div>

      <!-- Main content -->
      <div class="col-md-9 col-lg-10">
        <!-- Add new item -->
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="mb-0 fw-bold text-dark">Product List</h4>
          <div class="btn-group">
            <a class="btn btn-outline-secondary rounded-pill shadow-sm me-5" href="viewItem.php">🔄 View All</a>
            <a class="btn btn-dark rounded-pill shadow-sm" href="insertItem.php">➕ Add New Item</a>
          </div>
        </div>

        <!-- Flash messages -->
        <?php
          $flashMessages = ['insertSuccess', 'updateSuccess', 'deleteSuccess'];
          foreach ($flashMessages as $msg) {
              if (isset($_SESSION[$msg])) {
                  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                          {$_SESSION[$msg]}
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
                  unset($_SESSION[$msg]);
              }
          }
        ?>

        <!-- Products table -->
        <div class="table-responsive shadow-sm">
          <table class="table table-bordered table-hover align-middle text-center bg-white">
            <thead class="table-primary">
              <tr>
                <th style="min-width: 120px;">Name</th>
                <th style="min-width: 100px;">Category</th>
                <th style="min-width: 150px;">Description</th>
                <th>Price ($)</th>
                <th>Brand</th>
                <th>Image</th>
                <th>Stock</th>
                <th>Added By</th>
                <th colspan="2">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($items)): ?>
              <?php foreach ($items as $item): ?>
              <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= htmlspecialchars($item['categories']) ?></td>
                <td><?= htmlspecialchars($item['description']) ?></td>
                <td>$<?= $item['price'] ?></td>
                <td><?= htmlspecialchars($item['brand']) ?></td>
                <td><img src="<?= htmlspecialchars($item['image']) ?>" class="img-thumbnail"
                    style="width:80px;height:80px;object-fit:cover;" alt="Product Image"></td>
                <td><?= $item['stock'] ?></td>
                <td><?= htmlspecialchars($item['added_by']) ?></td>
                <td><a class="btn btn-sm btn-outline-primary rounded-pill"
                    href="editItem.php?eid=<?= $item['product_id'] ?>">Edit</a></td>
                <td><a class="btn btn-sm btn-outline-danger rounded-pill"
                    href="editItem.php?did=<?= $item['product_id'] ?>">Delete</a></td>
              </tr>
              <?php endforeach; ?>
              <?php else: ?>
              <tr>
                <td colspan="10" class="text-muted">No items found.</td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS + Auto Dismiss -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  // Auto-dismiss alerts after 4s
  setTimeout(() => {
    const alert = document.querySelector('.alert');
    if (alert) {
      const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
      bsAlert.close();
    }
  }, 4000);
  </script>
</body>

</html>

</html>
<?php } else { header("Location:login.php"); } ?>