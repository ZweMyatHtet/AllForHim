<?php
require_once "../user/dbconn.php";
if(!isset($_SESSION))
{
    session_start();
}
$sql = "select * from categories";
$stmt = $conn->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll();

$sqlAdmins = "SELECT admin_id, username FROM admins";
$stmtAdmins = $conn->prepare($sqlAdmins);
$stmtAdmins->execute();
$admins = $stmtAdmins->fetchAll();


if(isset($_GET['did'])) // it comes from clicking delete button
{
    $product_id = $_GET['did'];
    $sql = "delete from products where product_id=?";
    $stmt = $conn->prepare($sql);
    $status = $stmt->execute([$product_id]);
    if ($status)
    {  $_SESSION['deleteSuccess'] = "Product with id $product_id has been deleted successfully !!";
        header("Location:viewItem.php");

    }    

}// delete end

if(isset($_GET['eid'])) // if comes from clicking edit button
{
    $product_id = $_GET['eid']; // id from link
    try{
            $sql = "select p.product_id, p.name,
		             p.description, p.price, p.brand,
		             p.image, p.stock, p.added_by, c.name as categories

                        from products p, categories c
                    where p.category_id = c.category_id AND
                    p.product_id = ?";

                   $stmt = $conn->prepare($sql);
                   $stmt->execute([$product_id]);
                   $item = $stmt->fetch();


    }catch(PDOException $e)
    {
        echo $e->getMessage();
    }

}// end if



// update item

if(isset($_POST['updateItem'])){

  $pId = $_POST['pId'];
  $pName = $_POST['pName'];
  $price = $_POST['price'];
  $description = $_POST['description'];
  $category = $_POST['category'];
  $brand = $_POST['brand'];
  $stock = $_POST['stock'];
  $added_by = $_POST['added_by'];

  // Default image from DB (if no new file uploaded)
  $sql = "SELECT image FROM products WHERE product_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$pId]);
  $existing = $stmt->fetch();
  $filePath = $existing['image']; // Use existing image

  // Check if new image is uploaded
  if (!empty($_FILES['img']['name'])) {
      $fileName = $_FILES['img']['name'];
      $filePath = "img/" . $fileName;
      move_uploaded_file($_FILES['img']['tmp_name'], $filePath);
  }

  // Handle missing category gracefully (optional: you can enforce it)
  if (empty($category)) {
      $_SESSION['error'] = "Please select a category.";
      header("Location: viewItem.php");
      exit();
  }

  $sql = "UPDATE products 
          SET category_id=?, name=?, description=?, price=?,
              brand=?, image=?, stock=?, added_by=?
          WHERE product_id=?";
  $stmt = $conn->prepare($sql);
  $status = $stmt->execute([
      $category, $pName, $description, $price, $brand, $filePath, $stock, $added_by, $pId
  ]);

  if ($status) {
      $_SESSION['updateSuccess'] = "Product with id $pId has been updated successfully!";
      header("Location: viewItem.php");
  } else {
      $_SESSION['error'] = "Update failed.";
      header("Location: viewItem.php");
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Insert Items</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

  <style>
  img {
    width: 150px;
    height: auto;
    margin-bottom: 10px;
  }
  </style>

</head>

<body class="bg-light">
  <div class="container-fluid">
    <div class="row">
      <?php require_once "navbar.php"; ?>
    </div>
    <div class="row">

      <div class="col-md-6 mx-auto">

        <form class="form mt-2 pt-2" enctype="multipart/form-data" method="post"
          action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <fieldset>
            <legend>Edit Item</legend>
            <input type="hidden" name="pId" value="<?php echo $item['product_id']; ?>">
            <div class="mb-2">
              <label for="productName" class="form-label">Item Name</label>
              <input type="text" class="form-control" name="pName" value="<?php  echo $item['name']; ?>">
            </div>
            <div class="mb-2">
              <label for="price" class="form-label">Price</label>
              <input type="number" class="form-control" name="price" value="<?php  echo $item['price']; ?>">
            </div>
            <div class="mb-2">
              <label for="description" class="form-label">Description</label>
              <textarea name="description" class="form-control"><?php  echo $item['description']; ?></textarea>
            </div>
            <div class="mb-2">
              <label for="category" class="form-label">Category</label>
              <p>you selected <?php echo $item['categories']; ?></p>
              <select name="category" class="form-select" required>
                <option value="">Select Category</option>
                <?php if (isset($categories)) {
                                    foreach ($categories as $category) {
                                        echo $categories['category_id'];
                                        echo "<option value=$category[category_id]>$category[name]  </option>";
                                    }
                                }

                                ?>
              </select>
            </div>

            <div class="mb-2">
              <label for="brand" class="form-label">Brand</label>
              <input type="text" class="form-control" name="brand" value="<?php  echo $item['brand']; ?>">
            </div>

            <div class="mb-2">
              <img src="<?php echo $item['image']; ?>" alt="">
              <label for="img" class="form-label">Choose prodcut image</label>
              <input type="file" class="form-control" name="img">
            </div>

            <div class="mb-2">
              <label for="stock" class="form-label">Stock</label>
              <input type="number" class="form-control" name="stock" value="<?php  echo $item['stock']; ?>">
            </div>

            <div class="mb-2">
              <label for="added_by" class="form-label">Added By</label>
              <select name="added_by" class="form-select">
                <option value="">Select Admin</option>
                <?php foreach($admins as $admin): ?>
                <option value="<?= $admin['admin_id']; ?>"
                  <?= ($item['added_by'] == $admin['admin_id']) ? 'selected' : ''; ?>>
                  <?= $admin['username']; ?>
                </option>
                <?php endforeach; ?>
              </select>
            </div>


            <button type="submit" class="btn btn-primary" name="updateItem">Update Prodcut</button>

          </fieldset>
        </form>






      </div>

    </div>
  </div>
</body>

</html>