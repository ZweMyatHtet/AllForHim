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
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <?php require_once "navbar.php"; ?>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row mt-3">
      <div class="col-md-2 py-5">
        <!-- Category filter -->
        <form action="viewItem.php" method="get" class="form border border-primary border-1 rounded">
          <select name="cateChoose" class="form-select">
            <option>Choose Category</option>
            <?php
              if (isset($categories)) {
                  foreach ($categories as $category) {
                      echo "<option value='{$category['category_id']}'>{$category['name']}</option>";
                  }
              }
            ?>
          </select>
          <button class="mt-3 btn btn-sm btn-outline-primary rounded-pill" name="cate" type="submit">Submit</button>
        </form>

        <!-- Price range filter -->
        <form action="viewItem.php" method="get" class="mt-5 form border border-primary border-1 rounded">
          <fieldset>
            <legend>
              <h6>Choose Price Range</h6>
            </legend>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="priceRange" value="0">
              <label class="form-check-label">$1-$100</label><br>
              <input class="form-check-input" type="radio" name="priceRange" value="1">
              <label class="form-check-label">$101-$200</label><br>
              <input class="form-check-input" type="radio" name="priceRange" value="2">
              <label class="form-check-label">$201-$300</label>
            </div>
            <button class="mt-3 btn btn-sm btn-outline-primary rounded-pill" name="priceRadio"
              type="submit">Submit</button>
          </fieldset>
        </form>
      </div>

      <div class="col-md-10 mx-auto py-5 mb-2">
        <div class="py-2"> <a class="btn btn-outline-primary" href="insertItem.php">Add New Item</a></div>

        <?php
        if (isset($_SESSION['insertSuccess'])) {
            echo "<p class='alert alert-success'>{$_SESSION['insertSuccess']}</p>";
            unset($_SESSION['insertSuccess']);
        } elseif (isset($_SESSION['updateSuccess'])) {
            echo "<p class='alert alert-success'>{$_SESSION['updateSuccess']}</p>";
            unset($_SESSION['updateSuccess']);
        } elseif (isset($_SESSION['deleteSuccess'])) {
            echo "<p class='alert alert-success'>{$_SESSION['deleteSuccess']}</p>";
            unset($_SESSION['deleteSuccess']);
        }
        ?>

        <!-- Items table -->
        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-primary">
              <tr>
                <th style="min-width: 100px;">Name</th>
                <th style="min-width: 100px;">Category</th>
                <th style="min-width: 100px;">Description</th>
                <th style="min-width: 80px;">Price ($)</th>
                <th style="min-width: 80px;">Brand</th>
                <th style="min-width: 200px;">Image</th>
                <th style="min-width: 50px;">Stock</th>
                <th style="min-width: 80px;">Added By</th>
                <th style="min-width: 200px;" colspan="2">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
      if (isset($items)) {
        foreach ($items as $item) {
          echo "<tr style='word-break: break-word;'>
            <td>$item[name]</td>
            <td>$item[categories]</td>
            <td>$item[description]</td>
            <td>\$$item[price]</td>
            <td>$item[brand]</td>
            <td><img src='$item[image]' style='width:80px; height:80px; object-fit:cover;' alt='Product Image'></td>
            <td>$item[stock]</td>
            <td>$item[added_by]</td>
            <td><a class='btn btn-outline-primary btn-sm rounded-pill' href='editItem.php?eid=$item[product_id]'>Edit</a></td>
            <td><a class='btn btn-outline-danger btn-sm rounded-pill' href='editItem.php?did=$item[product_id]'>Delete</a></td>
          </tr>";
        }
      }
      ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
<?php } else { header("Location:login.php"); } ?>