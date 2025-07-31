<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>AllForHim Home Page</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <script src="script.js"></script>
</head>

<body>
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
        <!-- User Icon -->
        <div class="dropdown-container">
          <i class="fa-solid fa-circle-user account" onclick="toggleDropdown()"></i>

          <!-- Dropdown Menu -->
          <div id="roleDropdown" class="dropdown-menu">
            <a href="clogin.php"> Login as User</a>
            <a href="../admin/login.php"> Login as Admin</a>
            <a href="#" onclick="toggleDropdown()">Cancel</a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <div class="container2">
    <div>
      <img src="img/img1.webp">
      <div>
        <h4>Final Inventory.
          Up to 65% Off.
        </h4>
        <a href="userViewItem.php">Shop the Final Sale
          <i class="fa-solid fa-arrow-right"></i>
        </a>
      </div>
    </div>
    <div>
      <img src="img/img2.webp">
      <div>
        <h4>A New Era of Travel Starts Now</h4>
        <a href="userViewItem.php">Explore the Future
          <i class="fa-solid fa-arrow-right"></i>
        </a>
      </div>
    </div>
  </div>

  <div class="shop-the-final-sale">
    <div>
      <div>
        <h3>Not Just A Sale. A New Start</h3>
      </div>
      <div>
        <p>We're rebuilding Western Rise from the ground up.
          Before we launch the next generation of travel apparel we have to make room. This is you only change to own
          our best sellers at our cost.</p>
      </div>
      <div>
        <a href="userViewItem.php"> <button>Shop the Final Sale</button>
        </a>
      </div>
    </div>
    <div class="last-chance">
      <div>
        <h3>Last Chance</h3>
      </div>
      <div>
        <h3>Traveler Favourite on Sale</h3>
      </div>
      <div>Last chance to own our original best-sellers - at up to 65% off.</div>
    </div>
  </div>

  <div class="shop-the-final-sales">
    <div class="image-card">
      <img src="img/pant.webp" alt="Diversion Pant">
      <div class="discount">65% OFF</div>

      <div class="text-overlay">
        <h2>Diversion™ Pant</h2>
        <p>Rugged meets refined. Combines the strength of canvas with comfort.</p>
      </div>
    </div>

    <div class="image-card">
      <img src="img/pant2.webp" alt="Evolution Pant">
      <div class="discount">65% OFF</div>

      <div class="text-overlay">
        <h2>Evolution™ Pant</h2>
        <p>Unstoppable comfort, uncompromising performance—built for life.</p>
      </div>
    </div>

    <div class="image-card">
      <img src="img/pant3.webp" alt="Warehouse Sale">
      <div class="discount">65% OFF</div>

      <div class="text-overlay">
        <h2>Warehouse Sale</h2>
        <p>Unbeatable deals on premium travel essentials—shop now!</p>
      </div>
    </div>

    <div class="shop-now-wrapper">
      <a href="userViewItem.php"> <button class="shop-now-btn">Shop Now</button>
      </a>
    </div>

  </div>

  <div class="rating">
    <div class="rating-text">
      <p>We want you to move - not just from one place to another but toward something greater.</p>
    </div>
    <div class="rating-review">
      <div class="stars">
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
      </div>
      <div class="review-title">5 Stars</div>
      <div class="review-text">Thicker pant than the Evolution, great quality, big fan.</div>
    </div>

    <div>
      <h3>The Only Gear You Need For the Road

        Ahead
      </h3>
      <p>Elevate Your Travel Experience</p>
    </div>
  </div>

  <div class="th_design">
    <div>
      <h3>
        Thoughtful Design
      </h3>
      <p>Quality and the art of true craftsmanship create beauty. We understand that beauty is the antidote to the
        overwhelming stream of noise and disposable possessions. With a discerning eye for beauty, we bring focus and
        clarity to our lives and the world around us. Our designs are not just visually appealing but also serve
        multiple functions, ensuring that every product we create is both beautiful and purposeful.

      </p>

    </div>
  </div>

  <div class="journey">
    <div><img src="img/journey.webp" alt=""></div>
    <div>
      <h3>The Journey Is
        The Destination</h3>
      <p>Western Rise is evolving. We’re building the next generation of travel apparel - designed for movement,
        adventure, and the way you explore the world. Be the first to experience what’s next.</p>
    </div>
  </div>

  <div class="follow_us">
    <div>
      <div>Follow us</div>
      <div>@AllFor_Him</div>

    </div>
    <div>
      <img src="img/home2.webp" alt="">
      <img src="img/home3.webp" alt="">
      <img src="img/home4.webp" alt="">
      <img src="img/home5.webp" alt="">
    </div>
  </div>

  <footer>
    <div class="footer">
      <div>
        <img class="logo" src="img/logo.png" alt="Logo" />
        <h5>Travel further with less.</h5>
        <p>Effortless travel staples that let you carry less and experience more.</p>
      </div>
      <div>
        <h5>Shop</h5>
        <div>Travel Tops</div>
        <div>Travel Bottoms</div>
        <div>Bags</div>
        <div>Gift Cards</div>


      </div>
      <div>
        <h5>Explore</h5>
        <div>About</div>
        <div>Story</div>
        <div>Journal</div>
        <div>Ambassadors & Affiliates</div>
      </div>
      <div>
        <h5>Concierge</h5>
        <div>FAQ </div>
        <div>Customer Support</div>
        <div>Customer Support</div>
        <div>Privacy Policy</div>
        <div>Contact</div>
      </div>
      <div>
        <h5>Account</h5>
        <div>Login</div>
        <div>Sign up</div>
        <div>Terms of Service</div>
      </div>
      <div>
        <h5>Sign Up Now!</h5>
        <div>Get exclusive discounts, plus travel hacks, packing tips and more.</div>
        <div><textarea></textarea></div>
      </div>
    </div>

  </footer>

</body>

</html>