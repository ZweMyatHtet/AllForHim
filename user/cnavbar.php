<?php
require_once "dbconn.php";
if (!isset($_SESSION)) {
    session_start();
}

// Detect if the referrer page is signup.php
$fromSignup = false;
if (isset($_SERVER['HTTP_REFERER'])) {
    $referrer = basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH));
    if ($referrer === 'signup.php') {
        $fromSignup = true;
    }
}
?>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
<script src="script.js"></script>

<div class="discount-bar">
  <div class="discount-text">
    <i class="fa-solid fa-dot"></i> ONCE IT'S GONE IT'S GONE
    <i class="fa-solid fa-dot"></i> FINAL INVENTORY CLEARANCE - UP TO 68% OFF
    <i class="fa-solid fa-dot"></i> ONCE IT'S GONE IT'S GONE
    <i class="fa-solid fa-dot"></i> FINAL INVENTORY CLEARANCE - UP TO 68% OFF
  </div>
</div>

<header class="header">
  <div class="header-inner">

    <div class="small-c">
      <a class="nav-link active" aria-current="page" href="home.php">Home</a>

      <?php if ($fromSignup): ?>
      <!-- Only show Home, Customer Login, logo, and account icon -->
      <a class="nav-link" href="clogin.php">Customer Login</a>
      <?php else: ?>
      <?php if (!isset($_SESSION['customerEmail']) && !isset($_SESSION['clogin'])) { ?>
      <a class="nav-link" href="clogin.php">Customer Login</a>
      <?php } else { ?>
      <img class="nav-link" style="width:50px; height: 50px; border-radius: 25px;"
        src="<?php echo $_SESSION['profile']; ?>" alt="Profile Image">
      <p class="nav-link"><?php echo $_SESSION['customerEmail']; ?></p>
      <a class="nav-link" href="clogout.php">Logout</a>
      <?php } ?>
      <?php endif; ?>
    </div>

    <div class="logo-title">
      <img class="logo" src="img/logo.png" alt="Logo" />
      AllForHim
    </div>

    <div class="nav-bar">
      <div><i class="fa-solid fa-circle-user account"></i></div>
    </div>

  </div>
</header>