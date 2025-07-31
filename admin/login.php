<?php
require_once "../user/dbconn.php";
if (!isset($_SESSION)) {
    session_start();
}

// checking whether login button is clicked
if (isset($_POST['adminLogin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $sql = "select username, password from admins where username=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);
        $userInfo = $stmt->fetch();
        if (!$userInfo) {
            $message = "Username or password might be incorrect. ";
        } else {
            if (password_verify($password, $userInfo['password'])) {
                $_SESSION['adminId'] = $username;
                $_SESSION['login'] = true;
                header("Location:viewItem.php");
            } else {

                $message = "Username or password might be incorrect. ";
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <style>
  body {
    padding-top: 70px;

    background-color: #f8f9fa;
  }

  .bg-customize,
  .btn-customize {
    background-color: black;
    color: white;
  }

  .btn-customize:hover {
    background-color: gray;
  }
  </style>

</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <?php require_once "navbar.php"; ?>
    </div>

    <div class="row justify-content-center" style="margin-top: 100px;">
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-header bg-customize text-white text-center">
            <h4 class="my-1">Admin Login</h4>
          </div>
          <div class="card-body">
            <?php if (isset($message)): ?>
            <div class="alert alert-danger">
              <?= $message ?>
            </div>
            <?php endif; ?>
            <form method="post" action="login.php">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
              </div>

              <div class="d-grid">
                <button type="submit" name="adminLogin" class="btn btn-customize rounded-pill">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>





  </div>

</body>

</html>