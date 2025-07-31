<?php
require_once "dbconn.php";
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['customer_id']) || !isset($_SESSION['clogin']) || $_SESSION['clogin'] !== true) {
  header("Location: clogin.php");
  exit();
}

// Fetch categories
try {
    $stmt = $conn->prepare("SELECT * FROM categories");
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}

// Default products
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

// Filter: Category
if (isset($_GET['cate'])) {
    $cid = $_GET['cateChoose'];
    $stmt = $conn->prepare("SELECT p.product_id, p.name, p.description, p.price,
                                   p.brand, p.image, p.stock, p.added_by,
                                   c.name AS categories
                            FROM products p
                            JOIN categories c ON p.category_id = c.category_id
                            WHERE c.category_id = ?");
    $stmt->execute([$cid]);
    $items = $stmt->fetchAll();
}

// Filter: Price Range
if (isset($_GET['priceRadio'])) {
    $range = $_GET['priceRange'];
    if ($range == 0) { $lower = 1; $upper = 100; }
    elseif ($range == 1) { $lower = 101; $upper = 200; }
    else { $lower = 201; $upper = 300; }

    $stmt = $conn->prepare("SELECT p.product_id, p.name, p.description, p.price,
                                   p.brand, p.image, p.stock, p.added_by,
                                   c.name AS categories
                            FROM products p
                            JOIN categories c ON p.category_id = c.category_id
                            WHERE p.price BETWEEN ? AND ?");
    $stmt->execute([$lower, $upper]);
    $items = $stmt->fetchAll();
}

// Search: Keyword
if (isset($_GET['bSearch'])) {
    $keyword = $_GET['wSearch'];
    $stmt = $conn->prepare("SELECT p.product_id, p.name, p.description, p.price,
                                   p.brand, p.image, p.stock, p.added_by,
                                   c.name AS categories
                            FROM products p
                            JOIN categories c ON p.category_id = c.category_id
                            WHERE p.name LIKE ?");
    $stmt->execute(["%" . $keyword . "%"]);
    $items = $stmt->fetchAll();
}

$_SESSION['items'] = $items;
?>

<?php if (isset($_SESSION['customerEmail']) && isset($_SESSION['clogin'])): ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>View Items</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
  body {
    font-family: 'Poppins', sans-serif;
    background-color: #f8f9fa;
  }

  .navbar {
    padding: 0.75rem 1rem;
  }

  .product-card {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  .product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
  }

  .image-container {
    background-color: #fff;
    height: 220px;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 15px;
    border-bottom: 1px solid #eee;
  }

  .image-container img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
  }

  .card-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 15px;
  }

  .card-body h5 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 5px;
    color: #333;
  }

  .card-body p {
    font-size: 0.9rem;
    margin-bottom: 4px;
  }

  .sidebar {
    background-color: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    margin-bottom: 20px;
  }

  .view button {
    background-color: #222;
    color: white;
    border-radius: 25px;
    padding: 10px 25px;
    font-weight: 500;
    border: none;
    margin-bottom: 20px;
    transition: 0.3s ease-in-out;
  }

  .view button:hover {
    background-color: #444;
    transform: scale(1.05);
  }

  .search-wrapper {
    background-color: #000;
    border-radius: 8px;
    padding: 5px 10px;
    display: flex;
    align-items: center;
  }

  .custom-search-input {
    background: #fff;
    border: none;
    border-radius: 5px;
    padding: 8px 12px;
    width: 200px;
    color: #000;
    font-size: 14px;
    outline: none;
  }

  .custom-search-btn {
    background-color: #fff;
    color: #000;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    margin-left: 5px;
    cursor: pointer;
    transition: 0.3s;
  }

  .custom-search-btn:hover {
    background-color: #000;
    color: #fff;
  }

  .form-check {
    margin-bottom: 10px;
  }

  .btn-outline-secondary.btn-sm {
    padding: 5px 10px;
  }

  @media (max-width: 768px) {
    .search-wrapper {
      flex-direction: column;
      align-items: stretch;
    }

    .custom-search-input {
      width: 100%;
      margin-bottom: 5px;
    }
  }

  .cart-icon-link {
    cursor: pointer;
    transition: color 0.3s ease;
  }

  .cart-icon-link:hover {
    color: #007bff;
    /* bootstrap primary blue on hover */
  }

  .btn-link:hover {
    text-decoration: underline;
    color: #0a58ca;
  }
  </style>
</head>

<body>
  <nav class="navbar navbar-dark bg-dark shadow mb-4">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <div>
        <a class="navbar-brand" href="#">AllForHim</a>
        <a class="navbar-brand" href="home.php">Home</a>

      </div>


      <div class="search-wrapper">
        <input type="text" class="custom-search-input" id="searchInput" placeholder="Search products..." name="wSearch">
        <button class="custom-search-btn" id="searchBtn" title="Search"><i class="fa fa-search"></i></button>
      </div>

      <div class="d-flex align-items-center">
        <img src="<?= $_SESSION['profile'] ?? 'img/default.jpg' ?>" alt="Profile"
          style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
        <span class="text-white"><?= htmlspecialchars($_SESSION['customerEmail']) ?></span>
        <a class="btn btn-outline-light btn-sm ms-3" href="clogout.php">Logout</a>
      </div>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2">
        <div class="sidebar">
          <form method="get">
            <label class="form-label fw-bold">Choose Category</label>
            <select name="cateChoose" class="form-select mb-2">
              <option value="">All Categories</option>
              <?php foreach ($categories as $category): ?>
              <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
              <?php endforeach; ?>
            </select>
            <button class="btn btn-primary w-100 mb-3" name="cate">Filter</button>
          </form>

          <form method="get">
            <label class="form-label fw-bold">Choose Price Range</label>
            <div class="form-check">
              <input type="radio" class="form-check-input" name="priceRange" value="0"> $1 - $100
            </div>
            <div class="form-check">
              <input type="radio" class="form-check-input" name="priceRange" value="1"> $101 - $200
            </div>
            <div class="form-check">
              <input type="radio" class="form-check-input" name="priceRange" value="2"> $201 - $300
            </div>
            <button class="btn btn-primary w-100 mt-2" name="priceRadio">Apply</button>
          </form>
        </div>
      </div>

      <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="view">
            <a href="userViewItem.php"><button class="btn btn-dark">View All Products</button></a>
          </div>

          <?php if (!empty($_SESSION['cart'])): 
      $cartCount = array_sum($_SESSION['cart']);
  ?>
          <div>
            <a href="viewCart.php" class="cart-icon-link position-relative" title="View Cart"
              style="text-decoration:none; color:#000;">
              <i class="fa fa-shopping-cart fa-2x"></i>
              <?php if ($cartCount > 0): ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                style="font-size: 0.75rem; padding: 0.25em 0.4em;">
                <?= $cartCount ?>
                <span class="visually-hidden">items in cart</span>
              </span>
              <?php endif; ?>
            </a>
          </div>
          <?php endif; ?>
        </div>

        <div class="row">
          <?php foreach ($items as $item): ?>
          <div class="col-md-4 mb-4">
            <div class="card product-card h-100">
              <?php
                $imagePath = "../admin/" . $item['image'];
                if (!file_exists($imagePath)) {
                    $imagePath = "img/default-product.jpg";
                }
              ?>
              <div class="image-container">
                <img src="<?= $imagePath ?>" alt="Product Image">
              </div>
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                <p class="text-muted">$<?= $item['price'] ?></p>
                <p class="text-secondary">Category: <?= htmlspecialchars($item['categories']) ?></p>
                <p class="small"><?= htmlspecialchars(substr($item['description'], 0, 50)) ?>...</p>

                <div class="d-flex flex-column gap-2">
                  <form action="addCart.php" method="get" class="d-flex align-items-center">
                    <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="decrease(this)">-</button>
                    <input type="text" name="qty" value="1" class="form-control mx-2 text-center" style="width: 50px;">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="increase(this)">+</button>
                    <button type="submit" class="btn btn-outline-primary btn-sm ms-2" name="addCart">Add</button>
                  </form>

                  <a href="detailItem.php?product_id=<?= $item['product_id'] ?>"
                    class="btn btn-sm btn-link text-decoration-none text-primary ps-0">
                    <i class="fa fa-eye me-1"></i> View Details
                  </a>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>

  <script>
  function decrease(btn) {
    const input = btn.nextElementSibling;
    let val = parseInt(input.value);
    if (val > 1) input.value = val - 1;
  }

  function increase(btn) {
    const input = btn.previousElementSibling;
    let val = parseInt(input.value);
    if (val < 10) input.value = val + 1;
  }

  document.getElementById('searchBtn').addEventListener('click', function() {
    const keyword = document.getElementById('searchInput').value.trim();
    if (keyword !== '') {
      window.location.href = 'userViewItem.php?bSearch=1&wSearch=' + encodeURIComponent(keyword);
    }
  });

  document.getElementById('searchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      document.getElementById('searchBtn').click();
    }
  });
  </script>
</body>

</html>
<?php else:
  header("Location: clogin.php");
endif; ?>