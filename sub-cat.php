<?php
require_once 'config.php';

$products = getAllProducts();
$message = getMessage();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - FLASH E-Commerce</title>

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
                        <a class="nav-link" href="cat.php">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="sub-cat.php">Products</a>
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
            <h1>Our Products</h1>
            <p>Discover our amazing collection of high-quality products</p>
        </div>
    </section>

    <!-- Products Section -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="mb-5">
                <div class="row align-items-center mb-4">
                    <div class="col">
                        <h2 class="section-title">Featured Products</h2>
                    </div>
                    <div class="col-auto">
                        <div class="input-group" style="width: 250px;">
                            <input type="text" class="form-control" placeholder="Search products..." id="searchInput">
                            <button class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>

                <div class="row g-3 align-items-center">
                    <div class="col-md-6 col-lg-auto">
                        <div class="input-group" style="max-width: 200px;">
                            <label class="input-group-text">Sort by:</label>
                            <select class="form-select">
                                <option selected>Latest</option>
                                <option>Price: Low to High</option>
                                <option>Price: High to Low</option>
                                <option>Best Rated</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="products-grid" id="productsGrid">
                <?php while ($product = mysqli_fetch_assoc($products)):
                    if ($product['subcat_id'] <= 0) continue;
                ?>
                    <div class="stagger-item lazy-element product-item"
                        data-name="<?php echo strtolower($product['name']); ?>"
                        data-price="<?php echo htmlspecialchars($product['price'] ?? 0); ?>">
                        <div class="product-card h-100 hover-lift">
                            <div class="product-image">
                                <a href="product.php?id=<?php echo $product['subcat_id']; ?>">
                                    <img src="<?php echo getSafeImagePath($product['img'] ?? $product['name']); ?>"
                                        alt="<?php echo htmlspecialchars($product['name']); ?>"
                                        loading="lazy"
                                        width="300"
                                        height="250"
                                        style="width: 100%; height: 250px; object-fit: cover;">
                                </a>
                                <span class="product-badge">NEW</span>
                            </div>
                            <div class="product-body">
                                <p class="product-category" style="color: #FF6B35; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; margin-bottom: 0.5rem;">
                                    <?php echo htmlspecialchars(substr($product['name'], 0, 25)); ?>
                                </p>
                                <h5 class="product-name" style="margin-bottom: 0.5rem;">
                                    <a href="product.php?id=<?php echo $product['subcat_id']; ?>" style="color: #333; text-decoration: none;">
                                        <?php echo htmlspecialchars(substr($product['name'], 0, 35)); ?>
                                    </a>
                                </h5>
                                <p class="product-description" style="font-size: 0.9rem; color: #666; margin-bottom: 1rem; flex-grow: 1;">
                                    <?php echo htmlspecialchars(substr($product['dis'], 0, 70)) . '...'; ?>
                                </p>
                                <div class="product-rating" style="color: #FFC107; font-size: 0.9rem; margin-bottom: 1rem;">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span style="color: #666;">(<?php echo rand(50, 500); ?>)</span>
                                </div>
                                <div class="product-footer" style="display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 1rem; border-top: 1px solid #eee;">
                                    <div class="product-price" style="font-size: 1.5rem; font-weight: 800; color: #FF6B35;">
                                        <?php echo formatPrice($product['price']); ?>
                                    </div>
                                    <button class="add-to-cart-btn btn-ripple" onclick="addToCart(<?php echo $product['subcat_id']; ?>)" 
                                        title="Add to cart" 
                                        style="background: linear-gradient(135deg, #FF6B35, #F7931E); color: white; border: none; padding: 0.75rem 1.25rem; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; font-weight: 700;">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- No Products Found -->
            <div class="text-center py-5" id="noProducts" style="display: none;">
                <i class="fas fa-inbox fa-5x mb-3" style="color: #ccc;"></i>
                <h3>No Products Found</h3>
                <p class="text-muted">Try searching with different keywords</p>
            </div>

            <!-- Pagination -->
            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                </ul>
            </nav>
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
    <script>
        // Search functionality with debounce
        const searchInput = document.getElementById('searchInput');
        let searchTimeout;

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    const searchTerm = this.value.toLowerCase();
                    const products = document.querySelectorAll('.product-item');
                    let visibleCount = 0;

                    products.forEach(product => {
                        const productName = product.dataset.name;
                        if (productName.includes(searchTerm)) {
                            product.style.display = '';
                            product.classList.add('animate-fade-in');
                            visibleCount++;
                        } else {
                            product.style.display = 'none';
                        }
                    });

                    const noProducts = document.getElementById('noProducts');
                    if (noProducts) {
                        noProducts.style.display = visibleCount === 0 ? 'block' : 'none';
                    }
                }, 300);
            });
        }

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
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showToast('✗ Error adding product', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('✗ Network error', 'error');
                });
        }

        function showToast(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show m-3`;
            alertDiv.innerHTML = `${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
            document.body.insertBefore(alertDiv, document.body.firstChild);
            setTimeout(() => alertDiv.remove(), 3000);
        }
    </script>
</body>

</html>