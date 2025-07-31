<?php
if (!isset($_SESSION)) {
  session_start();
}

require_once "../user/dbconn.php";

// Get current page
$currentPage = basename($_SERVER['PHP_SELF']);
$hideSearchBar = in_array($currentPage, ['insertItem.php','editItem.php']);


$adminImage = 'adminPf/defaultPf.jpg';

?>

<style>
body,
html {
  margin: 0;
  padding: 0;
  width: 100%;
  overflow-x: hidden;
}

nav.navbar {
  margin: 0;
  padding: 1rem;
  width: 100%;
}

.navbar .container-fluid {
  padding-left: 0 !important;
  padding-right: 0 !important;
  margin-left: 0 !important;
  margin-right: 0 !important;
  width: 100% !important;
}

.navbar-brand {
  font-size: 1.25rem;
}

.navbar-nav .nav-link {
  padding: 0 1rem;
}

.search-bar input[type="search"] {
  min-width: 250px;
}
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm w-100">
  <div class="container-fluid">
    <!-- Admin logo and name -->
    <a class="navbar-brand fw-bold" href="../user/home.php">
      <img src="<?php echo htmlspecialchars($adminImage); ?>" alt="Admin Logo" width="30" height="30"
        class="d-inline-block align-text-top me-2 rounded-circle">
      AllForHim E-Commerce Admin
    </a>


    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
      aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="navbarNavAltMarkup">
      <?php if (isset($_SESSION['adminId']) || isset($_SESSION['login'])) { ?>
      <div class="navbar-nav">
        <a class="nav-link<?= $currentPage === '../user/home.php' ? ' active' : '' ?>" href="../user/home.php">Home
        </a>

        <a class="nav-link<?= $currentPage === 'insertItem.php' ? ' active' : '' ?>" href="insertItem.php">Add
          Products</a>
        <a class="nav-link<?= $currentPage === 'viewItem.php' ? ' active' : '' ?>" href="viewItem.php">View All
          Products</a>

        <a class="nav-link<?= $currentPage === 'dashboard.php' ? ' active' : '' ?>" href="dashboard.php">Dashboard</a>

      </div>

      <?php if (!$hideSearchBar) { ?>
      <div class="d-flex align-items-center search-bar">
        <form class="d-flex me-3" method="get" action="viewItem.php">
          <input class="form-control rounded-pill me-2" type="search" placeholder="Search products..." name="wSearch" />
          <button class="btn btn-outline-light rounded-pill" type="submit" name="bSearch">Search</button>
        </form>
        <a class="btn btn-light" href="logout.php">Logout</a>
      </div>
      <?php } else { ?>
      <div class="ms-auto">
        <a class="btn btn-light" href="logout.php">Logout</a>
      </div>
      <?php } ?>
      <?php } else { ?>
      <div class="ms-auto">
        <a class="btn btn-outline-light" href="login.php">Login</a>
      </div>
      <?php } ?>
    </div>
  </div>
</nav>