<?php
require_once "dbconn.php";
if (!isset($_SESSION)) {
    session_start();
}

$cities = [
    "Yangon", "Mandalay", "Nay Pyi Taw", "Bagan", 
    "Taunggyi", "Mawlamyine", "Pathein", "Pyin Oo Lwin"
];

if (isset($_POST['signUp'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $profile = $_FILES['profile'];
    $filepath = "img/" . $_FILES['profile']['name'];

    function isPasswordStrong($password)
    {
        $digitCount = 0;
        $capitalCount = 0;
        $specCount = 0;
        for ($i = 0; $i < strlen($password); $i++) {
            if (ctype_digit($password[$i])) $digitCount++;
            else if (ctype_upper($password[$i])) $capitalCount++;
            else if (preg_match('/[^a-zA-Z0-9\s]/', $password[$i])) $specCount++;
        }
        return $digitCount >= 1 && $capitalCount >= 1 && $specCount >= 1;
    }

    if ($password === $cpassword) {
        if (strlen($password) >= 8) {
            if (isPasswordStrong($password)) {
                try {
                    $hashCode = password_hash($password, PASSWORD_BCRYPT);
                    if (move_uploaded_file($_FILES['profile']['tmp_name'], $filepath)) {
                        $sql = "INSERT INTO users VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([null, $username, $email, $hashCode, $phone, $filepath, $gender, $city]);
                        $_SESSION['customerSignupSuccess'] = "Signup Success!! You can login here!";
                        header("Location: clogin.php");
                        exit();
                    }
                } catch (PDOException $e) {
                    $errMessage = $e->getMessage();
                }
            } else {
                $errMessage = "Password must include at least one uppercase letter, one digit, and one special character.";
            }
        } else {
            $errMessage = "Password must be at least 8 characters long.";
        }
    } else {
        $errMessage = "Password and Confirm Password do not match.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Signup</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
  body {
    background: linear-gradient(120deg, #f8f9fa, #e0eafc);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .signup-form {
    background-color: white;
    border-radius: 16px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    padding: 30px;
    width: 100%;
    max-width: 500px;
  }

  .signup-form h3 {
    text-align: center;
    margin-bottom: 25px;
    font-weight: bold;
    color: #333;
  }

  .btn-custom {
    background-color: #000;
    color: white;
    border-radius: 8px;
    padding: 10px 20px;
    transition: all 0.3s ease;
  }

  .btn-custom:hover {
    background-color: #333;
    transform: translateY(-1px);
  }
  </style>
</head>

<body>
  <div class="signup-form">
    <h3>User Sign Up</h3>
    <form action="signup.php" method="post" enctype="multipart/form-data">
      <?php if (isset($errMessage)) : ?>
      <div class="alert alert-danger"><?= $errMessage ?></div>
      <?php endif; ?>

      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="cpassword" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="tel" name="phone" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select" required>
          <option value="">Select Gender</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">City</label>
        <select name="city" class="form-select" required>
          <option value="">Choose City</option>
          <?php foreach ($cities as $city): ?>
          <option value="<?= $city ?>"><?= $city ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Choose Profile Image</label>
        <input type="file" name="profile" class="form-control" required>
      </div>

      <div class="d-grid">
        <button type="submit" name="signUp" class="btn btn-custom">Sign Up</button>
      </div>
    </form>
  </div>
</body>

</html>