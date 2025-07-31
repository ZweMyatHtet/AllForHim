<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <script src="script.js"></script>
  <style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding-top: 100px;
    line-height: 1.8;
  }

  .section {
    display: flex;
    flex-wrap: wrap;
    padding: 60px 20px;
    gap: 40px;
    align-items: center;
    justify-content: center;
  }

  .section img {
    max-width: 500px;
    width: 100%;
    border-radius: 10px;
    object-fit: cover;
  }

  .section h3 {
    font-size: 2rem;
    margin-bottom: 20px;
    font-weight: bold;
  }

  .section p {
    max-width: 700px;
    font-size: 1.1rem;
  }

  .gallery {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    padding: 40px 20px;
  }

  .gallery img {
    width: 300px;
    height: 300px;
    object-fit: cover;
    border-radius: 10px;
  }

  .footer {
    background-color: #f1f1f1;
    padding: 40px 30px;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 30px;
    font-size: 14px;
    color: #333;
  }

  .footer img.logo {
    width: 50px;
    height: 50px;
    margin-bottom: 10px;
  }

  .footer h5 {
    font-size: 16px;
    margin-bottom: 8px;
    font-weight: 600;
  }

  .footer div textarea {
    width: 100%;
    padding: 6px;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: none;
    min-height: 50px;
  }
  </style>
</head>

<body>
  <div class="discount-bar">
    <div class="discount-text">
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
        <div class="search-container">
          <input type="text" class="search-input" placeholder="Search...">
          <i class="fa-solid fa-magnifying-glass search-icon" onclick="toggleSearch()"></i>
        </div>
        <div><a href="clogin.php"><i class="fa-solid fa-circle-user account"></i></a></div>
        <div><i class="fa-solid fa-cart-shopping cart"></i></div>
      </div>
    </div>
  </header>

  <div class="section">
    <div>
      <h3>The Beginnings</h3>
      <p>Will and Kelly Watters met in the beautiful mountain town of Vail, Colorado... Western Rise, a brand dedicated
        to helping individuals experience a fulfilling life through thoughtful design and purposeful products.</p>
    </div>
    <img src="img/ab1.webp" alt="">
  </div>

  <div class="section">
    <img src="img/ab2.webp" alt="">
    <div>
      <h3>Our Journey</h3>
      <p>Founded by Kelly and Will Watters, Western Rise was born from a passion for exploration... With backgrounds in
        outdoor guiding and textiles, we set out to create a brand that bridges the gap between performance and everyday
        wear.</p>
    </div>
  </div>

  <div class="section">
    <div>
      <h3>Manifesto</h3>
      <p>We live in a time of uncertainty which is breeding a pool of fear... We invite you to pause, take a deep
        breath, and begin to look around. Join us.</p>
    </div>
    <img src="img/ab3.webp" alt="">
  </div>

  <div class="gallery">
    <img src="img/ab4.webp" alt="">
    <img src="img/ab5.jpg" alt="">
    <img src="img/ab6.webp" alt="">
    <img src="img/ab7.webp" alt="">
    <img src="img/ab8.webp" alt="">
    <img src="img/ab9.webp" alt="">
  </div>

  <div class="section">
    <img src="img/ab10.webp" alt="">
    <div>
      <h3>Our Work</h3>
      <p>We work to inspire and equip travelers for transformative journeys... to compel people to embark on their own
        adventures.</p>
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