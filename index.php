<?php
require_once 'config.php';

// Get featured products and categories
$products = getFeaturedProducts(8);
$categories = getAllCategories();
$message = getMessage();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="FLASH E-Commerce - Shop amazing products at incredible prices with fast delivery and secure payments.">
  <meta name="theme-color" content="#FF6B35">
  <title>FLASH E-Commerce - Online Shopping Made Easy</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Google Fonts with font-display swap -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">

  <!-- Modern Styles -->
  <link rel="stylesheet" href="mcss/modern-style.css" media="print" onload="this.media='all'">
  <link rel="stylesheet" href="mcss/performance.css">

  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .hero-section h1 {
      animation: slideInDown 0.8s ease-out;
    }

    .hero-section p {
      animation: slideInUp 0.8s ease-out 0.2s both;
    }
  </style>
  <noscript>
    <link rel="stylesheet" href="mcss/modern-style.css">
  </noscript>
</head>

<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <i class="fas fa-bolt"></i> FLASH
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="cat.php">Categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="sub-cat.php">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cart.php">
              <i class="fas fa-shopping-cart"></i> Cart
              <?php if (getCartCount() > 0): ?>
                <span class="badge bg-danger"><?php echo getCartCount(); ?></span>
              <?php endif; ?>
            </a>
          </li>
          <li class="nav-item">
            <?php if (isUserLoggedIn()): ?>
              <div class="nav-link dropdown">
                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                  <i class="fas fa-user-circle"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>My Profile</a></li>
                  <li><a class="dropdown-item" href="cart.php"><i class="fas fa-shopping-bag me-2"></i>Orders</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
              </div>
            <?php else: ?>
              <a class="nav-link" href="log.php">Login</a>
            <?php endif; ?>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Message Alert -->
  <?php if ($message): ?>
    <div class="alert alert-<?php echo $message['type']; ?> alert-dismissible fade show m-3" role="alert">
      <?php echo $message['message']; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="hero-content">
      <h1>Welcome to FLASH E-Commerce</h1>
      <p>Discover amazing products at incredible prices. Shop the latest trends and bestsellers.</p>
      <div class="hero-buttons">
        <a href="cat.php" class="btn btn-primary-custom">
          <i class="fas fa-shopping-bag"></i> Shop Now
        </a>
        <a href="#featured" class="btn btn-secondary-custom">
          <i class="fas fa-arrow-down"></i> Explore
        </a>
      </div>
    </div>
  </section>

  <!-- Main Container -->
  <div class="container-fluid py-5">
    <!-- Categories Section -->
    <div class="container mb-5">
      <div class="text-center mb-5">
        <h2 class="section-title">Shop by Category</h2>
      </div>
      <div class="row g-4">
        <?php
        $cat_count = 0;
        $categories = getAllCategories();
        while (($category = mysqli_fetch_assoc($categories)) && $cat_count < 8):
          if (empty($category['name']) || $category['cat_id'] <= 0) continue;
          $cat_count++;
        ?>
          <div class="col-md-6 col-lg-3 stagger-item lazy-element">
            <a href="cat.php?cat_id=<?php echo $category['cat_id']; ?>" class="text-decoration-none">
              <div class="category-card h-100 hover-lift hover-glow">
                <img src="<?php echo getSafeImagePath($category['img'] ?? ''); ?>"
                  alt="<?php echo htmlspecialchars($category['name']); ?>"
                  loading="lazy"
                  width="300"
                  height="250">
                <div class="category-card-body">
                  <h5 class="category-card-title"><?php echo htmlspecialchars($category['name']); ?></h5>
                  <p class="category-card-text">Explore Collection</p>
                  <i class="fas fa-arrow-right" style="color: var(--primary-color);"></i>
                </div>
              </div>
            </a>
          </div>
        <?php endwhile; ?>
      </div>
    </div>

    <!-- Featured Products Section -->
    <div class="container mb-5" id="featured">
      <div class="text-center mb-5">
        <h2 class="section-title">Featured Products</h2>
      </div>
      <div class="row g-4 products-grid">
        <?php
        $prod_count = 0;
        $products = getAllProducts();
        while (($product = mysqli_fetch_assoc($products)) && $prod_count < 8):
          if (empty($product['name']) || $product['subcat_id'] <= 0) continue;
          $prod_count++;
        ?>
          <div class="col-md-6 col-lg-3 stagger-item lazy-element product-card"
            data-price="<?php echo htmlspecialchars($product['price'] ?? 0); ?>"
            data-id="<?php echo htmlspecialchars($product['subcat_id']); ?>">
            <div class="product-card hover-lift">
              <div class="product-image">
                <a href="product.php?id=<?php echo $product['subcat_id']; ?>">
                  <img src="<?php echo getSafeImagePath($product['img'] ?? ''); ?>"
                    alt="<?php echo htmlspecialchars($product['name']); ?>"
                    loading="lazy"
                    width="300"
                    height="250">
                </a>
                <span class="product-badge">NEW</span>
              </div>
              <div class="product-body">
                <p class="product-category">Featured</p>
                <h5 class="product-name"><a href="product.php?id=<?php echo $product['subcat_id']; ?>" style="color: inherit; text-decoration: none;"><?php echo htmlspecialchars($product['name']); ?></a></h5>
                <p class="product-description"><?php echo htmlspecialchars(substr($product['dis'] ?? '', 0, 60)) . '...'; ?></p>
                <div class="product-rating">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
                  <span>(<?php echo rand(50, 500); ?>)</span>
                </div>
                <div class="product-footer">
                  <div class="product-price"><?php echo formatPrice($product['price'] ?? 0); ?></div>
                  <button class="add-to-cart-btn btn-ripple" onclick="addToCart(<?php echo $product['subcat_id']; ?>)" title="Add to cart">
                    <i class="fas fa-cart-plus"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
      <div class="text-center mt-5">
        <a href="sub-cat.php" class="btn btn-primary-custom">View All Products</a>
      </div>
    </div>

    <!-- Features Section -->
    <div class="container py-5 mb-5">
      <div class="row g-4 text-center">
        <div class="col-md-4">
          <div class="feature-box p-4">
            <i class="fas fa-truck fa-3x mb-3" style="color: var(--primary-color);"></i>
            <h5>Free Shipping</h5>
            <p class="text-muted">On orders over ₹500</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-box p-4">
            <i class="fas fa-undo fa-3x mb-3" style="color: var(--secondary-color);"></i>
            <h5>Easy Returns</h5>
            <p class="text-muted">30-day return policy</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-box p-4">
            <i class="fas fa-shield-alt fa-3x mb-3" style="color: var(--success-color);"></i>
            <h5>Secure Payment</h5>
            <p class="text-muted">100% secure transactions</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="container py-5">
      <div class="footer-content">
        <div class="footer-section">
          <h5><i class="fas fa-bolt"></i> FLASH</h5>
          <p>Your one-stop destination for all your shopping needs. Quality products at unbeatable prices.</p>
          <div class="mt-3">
            <a href="#" class="me-2"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="me-2"><i class="fab fa-twitter"></i></a>
            <a href="#" class="me-2"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div>
        <div class="footer-section">
          <h5>Quick Links</h5>
          <ul>
            <li><a href="cat.php">Categories</a></li>
            <li><a href="sub-cat.php">Products</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
        </div>
        <div class="footer-section">
          <h5>Customer Service</h5>
          <ul>
            <li><a href="#">Shipping Info</a></li>
            <li><a href="#">Returns</a></li>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Support</a></li>
          </ul>
        </div>
        <div class="footer-section">
          <h5>Newsletter</h5>
          <form class="mt-3">
            <div class="input-group mb-3">
              <input type="email" class="form-control" placeholder="Your email">
              <button class="btn btn-primary-custom" type="button">Subscribe</button>
            </div>
          </form>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 FLASH E-Commerce. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

  <!-- Custom App JS -->
  <script src="js/app.js" defer></script>

  <!-- Scripts -->
  <script>
    function addToCart(productId) {
      fetch('add-to-cart.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: 'product_id=' + productId
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            showToast('✓ Product added to cart!', 'success');
            updateCartCount();
          } else {
            showToast('✗ Error adding product to cart', 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showToast('✗ Network error', 'error');
        });
    }

    function updateCartCount() {
      setTimeout(() => location.reload(), 500);
    }

    function showToast(message, type) {
      const toast = document.createElement('div');
      toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show m-3`;
      toast.innerHTML = `${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
      document.body.insertBefore(toast, document.body.firstChild);
      setTimeout(() => toast.remove(), 3000);
    }
  </script>
</body>

</html>