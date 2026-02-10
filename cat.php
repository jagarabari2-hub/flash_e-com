<?php
require_once 'config.php';

$categories = getAllCategories();
$message = getMessage();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Categories - FLASH E-Commerce</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="mcss/modern-style.css" media="print" onload="this.media='all'">
  <link rel="stylesheet" href="mcss/performance.css">
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
            <a class="nav-link active" href="cat.php">Categories</a>
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
              <a class="nav-link" href="logout.php">Logout</a>
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
  <section class="hero-section" style="padding: 60px 0; min-height: 400px;">
    <div class="hero-content">
      <h1>Shop by Category</h1>
      <p>Browse our wide collection of categories and find what you're looking for.</p>
    </div>
  </section>

  <!-- Categories Grid -->
  <div class="container-fluid py-5">
    <div class="container">
      <div class="mb-5">
        <div class="row align-items-center">
          <div class="col">
            <h2 class="section-title">All Categories</h2>
          </div>
          <div class="col-auto">
            <select class="form-select" style="width: auto;">
              <option selected>Sort by</option>
              <option value="1">A-Z</option>
              <option value="2">Z-A</option>
            </select>
          </div>
        </div>
      </div>

      <div class="row g-4">
        <?php while ($category = mysqli_fetch_assoc($categories)):
          if (empty($category['name'])) continue;
        ?>
          <div class="col-md-6 col-lg-4 col-xl-3 stagger-item lazy-element">
            <a href="sub-cat.php?cat_id=<?php echo $category['cat_id']; ?>" class="text-decoration-none">
              <div class="category-card h-100 hover-lift hover-glow">
                <img src="<?php echo getSafeImagePath($category['img'] ?? ''); ?>"
                  alt="<?php echo htmlspecialchars($category['name']); ?>"
                  loading="lazy"
                  width="300"
                  height="250">
                <div class="category-card-body">
                  <h5 class="category-card-title"><?php echo htmlspecialchars($category['name']); ?></h5>
                  <p class="category-card-text">Browse Collection</p>
                  <i class="fas fa-arrow-right" style="color: var(--primary-color); transition: transform 0.3s ease;"></i>
                </div>
              </div>
            </a>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>

  <!-- Features Section -->
  <div class="container py-5 mb-5">
    <div class="row g-4 text-center">
      <div class="col-md-4">
        <i class="fas fa-cube fa-3x mb-3" style="color: var(--primary-color);"></i>
        <h5>16 Categories</h5>
        <p class="text-muted">Wide variety of products</p>
      </div>
      <div class="col-md-4">
        <i class="fas fa-tag fa-3x mb-3" style="color: var(--secondary-color);"></i>
        <h5>Best Prices</h5>
        <p class="text-muted">Competitive pricing</p>
      </div>
      <div class="col-md-4">
        <i class="fas fa-truck fa-3x mb-3" style="color: var(--success-color);"></i>
        <h5>Fast Delivery</h5>
        <p class="text-muted">Quick shipping available</p>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="container py-5">
      <div class="footer-content">
        <div class="footer-section">
          <h5><i class="fas fa-bolt"></i> FLASH</h5>
          <p>Your one-stop destination for all your shopping needs.</p>
        </div>
        <div class="footer-section">
          <h5>Quick Links</h5>
          <ul>
            <li><a href="cat.php">Categories</a></li>
            <li><a href="sub-cat.php">Products</a></li>
            <li><a href="#">About Us</a></li>
          </ul>
        </div>
        <div class="footer-section">
          <h5>Customer Service</h5>
          <ul>
            <li><a href="#">Shipping Info</a></li>
            <li><a href="#">Returns</a></li>
            <li><a href="#">FAQ</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 FLASH E-Commerce. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
  <script src="js/app.js" defer></script>
</body>

</html>