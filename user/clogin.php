<?php
require_once "dbconn.php";
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['customerLogin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $userInfo = $stmt->fetch();

        if (!$userInfo || !password_verify($password, $userInfo['password'])) {
            $message = "Username or password might be incorrect.";
        } else {
            // Save user ID and other session variables consistently
            $_SESSION['customerEmail'] = $email;
            $_SESSION['clogin'] = true;
            $_SESSION['profile'] = $userInfo['image'];
            $_SESSION['user_id'] = $userInfo['user_id'];

            $_SESSION['customer_id'] = $userInfo['user_id'];  // <-- Add this
           
            
            

            header("Location:userViewItem.php");
            exit();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Customer Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
  <style>
  body {
    background-color: #f2f4f8;
  }



  .login-wrapper {
    margin-top: 220px;
  }

  .login-box {
    background-color: #ffffff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
  }

  legend {
    font-size: 1.5rem;
    font-weight: 600;
    text-align: center;
  }

  .signup {
    font-size: 0.95rem;
    color: #555;
  }

  .signup a {
    color: #0d6efd;
    transition: color 0.3s ease;
  }

  .signup a:hover {
    color: #0a58ca;
    text-decoration: underline;
  }
  </style>
</head>

<body>
  <?php require_once "cnavbar.php"; ?>

  <div class="container login-wrapper">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-4">
        <div class="login-box">
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <fieldset>
              <legend>Customer Login</legend>

              <?php if (isset($message)) : ?>
              <div class="alert alert-danger"><?php echo $message; ?></div>
              <?php endif; ?>

              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required />
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required />
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary rounded-pill" name="customerLogin">Login</button>
              </div>

              <div class="signup d-flex justify-content-between align-items-center mt-4">
                <p class="mb-0">Don't have an account?</p>
                <a href="signup.php" class="text-decoration-none fw-semibold">Sign Up</a>
              </div>

            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>