<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Last Call</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="lastCallStyle.css">
  <script src="script.js"></script>
</head>

<body>
  <!-- Discount Bar -->
  <div class="discount-bar text-white text-center py-2">
    <marquee behavior="scroll" direction="left">
      <i class="fa-solid fa-circle me-2"></i> ONCE IT'S GONE, IT'S GONE - FINAL INVENTORY CLEARANCE UP TO 68% OFF
    </marquee>
  </div>

  <!-- Header -->
  <header class="header">
    <div class="header-inner">
      <div class="small-c">
        <div><a href="home.php">Home</a></div>

        <div><a href="userViewItem.php">Shop</a></div>
        <div><a href="aboutUs.php">About</a></div>
        <div><a href="lastCall.php">Last Call</a></div>
      </div>

      <div class="logo-title">
        <img class="logo" src="img/logo.png" alt="Logo" />
        AllForHim
      </div>

      <div class="nav-bar">
        <div class="search-container">
          <input type="text" class="search-input" placeholder="Search...">
          <i class="fa-solid fa-magnifying-glass search-icon" onclick="toggleSearch()"></i>
        </div>
        <div><a href="clogin.php"><i class="fa-solid fa-circle-user account"></i></a></div>
        <div>
          <a href="viewCart.php"><i class="fa-solid fa-cart-shopping cart"></i></a>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="container py-5">
    <section class="text-center mb-5">
      <img src="img/lC1.webp" class="img-fluid mb-4" alt="Main Banner">
      <h3>A Brand for the Modern Traveler</h3>
    </section>

    <section class="text-center mb-5">
      <div class="row g-3">
        <div class="col"><img src="img/Lightweight.svg" alt="Lightweight" class="img-fluid" /></div>
        <div class="col"><img src="img/Versatile.svg" alt="Versatile" class="img-fluid" /></div>
        <div class="col"><img src="img/Durable.svg" alt="Durable" class="img-fluid" /></div>
        <div class="col"><img src="img/Easy-Maintenance.svg" alt="Easy Maintenance" class="img-fluid" /></div>
      </div>
    </section>

    <section class="row align-items-center mb-5">
      <div class="col-md-6">
        <h3>Our Mission</h3>
        <p>We make quality apparel for the modern one-bag traveler so they can carry less and experience more.</p>
        <p>We inspire change by crafting durable, functional products that enhance travel and empower fulfilling lives.
        </p>
      </div>
      <div class="col-md-6">
        <img src="img/lC3.webp" class="img-fluid" alt="Mission Image">
      </div>
    </section>

    <section class="row align-items-center mb-5">
      <div class="col-md-6">
        <img src="img/lC4.webp" class="img-fluid" alt="Belief Image">
      </div>
      <div class="col-md-6">
        <h3>We Believe Travel Transforms Lives</h3>
        <img src="img/lC5.avif" class="img-fluid mt-3" alt="Transformation Image">
      </div>
    </section>

    <section class="row align-items-center mb-5">
      <div class="col-md-6">
        <img src="img/lC6.webp" class="img-fluid" alt="Our Work Image">
      </div>
      <div class="col-md-6">
        <h3>Our Work</h3>
        <p>We craft versatile and high-performance travel clothing. Our apparel is rigorously tested around the world to
          ensure maximum functionality for travelers. We also build a global community through storytelling and shared
          journeys.</p>
      </div>
    </section>

    <section class="row text-center mb-5">
      <div class="col-12">
        <h4>"These are the pants that Tony Stark would design and wear"</h4>
      </div>
      <div class="col-md-4"><img src="img/lC7.webp" class="img-fluid" alt=""></div>
      <div class="col-md-4"><img src="img/lC8.webp" class="img-fluid" alt=""></div>
      <div class="col-md-4"><img src="img/lC9.webp" class="img-fluid" alt=""></div>
    </section>

    <section class="text-center mb-5">
      <img src="img/lC10.webp" class="img-fluid mb-3" alt="">
      <img src="img/lC11.webp" class="img-fluid mb-3" alt="">
      <img src="img/lC12.webp" class="img-fluid" alt="">
    </section>

    <section class="row align-items-center mb-5">
      <div class="col-md-12">
        <h3>Our Philosophy</h3>
        <p>We embrace simplicity and focus only on things that matter. Our products are functional, aesthetically
          pleasing, and earn their place in your life.</p>
      </div>
    </section>

    <section class="row align-items-center mb-5">
      <div class="col-md-6">
        <h3>Our Logo</h3>
        <p>Inspired by elevation markers at a mountain's peak, our logo reflects our belief in growth, adventure, and
          personal transformation.</p>
      </div>
      <div class="col-md-6">
        <img src="img/logo.png" class="img-fluid my-logo" alt="Brand Logo">
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="bg-dark text-white py-5 mt-5">
    <div class="container row mx-auto">
      <div class="col-md-3">
        <img src="img/logo.png" class="logo mb-2" alt="Logo" />
        <h5>Travel further with less.</h5>
        <p>Effortless travel staples that let you carry less and experience more.</p>
      </div>

      <div class="col-md-2">
        <h5>Shop</h5>
        <p>Travel Tops</p>
        <p>Travel Bottoms</p>
        <p>Bags</p>
        <p>Gift Cards</p>
      </div>

      <div class="col-md-2">
        <h5>Explore</h5>
        <p>About</p>
        <p>Story</p>
        <p>Journal</p>
        <p>Affiliates</p>
      </div>

      <div class="col-md-2">
        <h5>Concierge</h5>
        <p>FAQ</p>
        <p>Support</p>
        <p>Privacy Policy</p>
        <p>Contact</p>
      </div>

      <div class="col-md-2">
        <h5>Account</h5>
        <p>Login</p>
        <p>Sign up</p>
        <p>Terms</p>
      </div>

      <div class="col-md-3">
        <h5>Sign Up Now!</h5>
        <p>Get exclusive discounts and travel tips.</p>
        <textarea class="form-control mb-2" rows="2"></textarea>
        <button class="btn btn-light w-100">Subscribe</button>
      </div>
    </div>
  </footer>

</body>

</html>