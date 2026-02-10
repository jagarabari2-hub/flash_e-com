<?php
require_once 'config.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = getProductById($product_id);

if (!$product) {
    header('Location: sub-cat.php');
    exit;
}

$message = getMessage();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - FLASH E-Commerce</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="mcss/modern-style.css" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="mcss/performance.css">
    <noscript>
        <link rel="stylesheet" href="mcss/modern-style.css">
    </noscript>
    <meta name="description" content="<?php echo htmlspecialchars($product['name']); ?> - FLASH E-Commerce">
    <meta name="theme-color" content="#FF6B35">
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

    <!-- Breadcrumb -->
    <div class="container mt-4 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="sub-cat.php">Products</a></li>
                <li class="breadcrumb-item active"><?php echo htmlspecialchars($product['name']); ?></li>
            </ol>
        </nav>
    </div>

    <!-- Product Detail Section -->
    <div class="container mb-5 animate-fade-in">
        <div class="row g-5">
            <!-- Product Image -->
            <div class="col-md-5">
                <div class="product-detail-image" style="background: linear-gradient(135deg, #f5f5f5, #e0e0e0); border-radius: 12px; padding: 2rem; text-align: center; position: relative; overflow: hidden;">
                    <img id="mainImage"
                        src="<?php echo getSafeImagePath($product['img'] ?? ''); ?>"
                        alt="<?php echo htmlspecialchars($product['name']); ?>"
                        loading="eager"
                        style="max-width: 100%; max-height: 500px; object-fit: contain; transition: opacity 0.3s ease;">
                </div>
                <div class="mt-4 d-flex gap-2 overflow-auto" style="padding-bottom: 10px;">
                    <img src="<?php echo getSafeImagePath($product['img'] ?? ''); ?>"
                        class="product-thumbnail active"
                        style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 3px solid var(--primary-color); cursor: pointer; transition: transform 0.2s ease;"
                        onclick="this.previousElementSibling?.style.borderColor ?? null">
                    <img src="<?php echo getSafeImagePath($product['img'] ?? ''); ?>"
                        class="product-thumbnail"
                        style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #ccc; cursor: pointer; transition: all 0.2s ease;">
                    <img src="<?php echo getSafeImagePath($product['img'] ?? ''); ?>"
                        class="product-thumbnail"
                        style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #ccc; cursor: pointer; transition: all 0.2s ease;">
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-7">
                <div>
                    <span class="badge bg-success mb-3" style="padding: 0.75rem 1.5rem; font-size: 1rem;">
                        <i class="fas fa-check-circle"></i> IN STOCK
                    </span>
                    <h1 class="display-5 mb-3 text-fade-in"><?php echo htmlspecialchars($product['name']); ?></h1>

                    <div class="d-flex align-items-center mb-4">
                        <div class="product-rating" style="font-size: 1.2rem;">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="ms-2" style="color: var(--gray-600); font-size: 1rem;">(<?php echo rand(100, 500); ?> reviews)</span>
                        </div>
                    </div>

                    <div class="my-4 pb-4 border-bottom">
                        <h3 class="text-gradient mb-2" style="font-size: 2rem;"><?php echo formatPrice($product['price']); ?></h3>
                        <p class="text-muted" style="font-size: 1.1rem;"><del><?php echo formatPrice($product['price'] * 1.3); ?></del> <span class="badge bg-danger">25% OFF</span></p>
                    </div>

                    <p class="lead text-muted mb-4" style="font-size: 1.1rem; line-height: 1.8;"><?php echo htmlspecialchars($product['dis']); ?></p>

                    <div class="mb-4">
                        <h6 class="mb-3" style="font-weight: 700; color: var(--gray-800);">Product Highlights:</h6>
                        <ul class="list-unstyled" style="line-height: 2;">
                            <li><i class="fas fa-check text-success" style="width: 25px;"></i> Premium Quality Material</li>
                            <li><i class="fas fa-check text-success" style="width: 25px;"></i> Long Lasting Durability</li>
                            <li><i class="fas fa-check text-success" style="width: 25px;"></i> Stylish & Modern Design</li>
                            <li><i class="fas fa-check text-success" style="width: 25px;"></i> 100% Eco-Friendly</li>
                        </ul>
                    </div>

                    <div class="d-flex gap-3 mb-4 flex-wrap">
                        <div class="input-group" style="max-width: 150px;">
                            <button class="btn btn-outline-secondary btn-lg" type="button" onclick="decreaseQty()" style="padding: 0.75rem 1rem;">−</button>
                            <input type="number" id="quantity" class="form-control text-center" value="1" min="1" style="padding: 0.75rem; font-weight: 700;">
                            <button class="btn btn-outline-secondary btn-lg" type="button" onclick="increaseQty()" style="padding: 0.75rem 1rem;">+</button>
                        </div>
                        <button class="btn btn-primary-custom btn-lg flex-grow-1" onclick="addProductToCart(<?php echo $product['subcat_id']; ?>)" style="padding: 0.75rem 2rem; font-size: 1.1rem;">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>

                    <button class="btn btn-outline-dark w-100 mb-3" style="padding: 0.75rem; font-weight: 700; border-width: 2px;">
                        <i class="fas fa-heart"></i> Add to Wishlist
                    </button>

                    <div class="bg-light p-4 rounded-3" style="border-left: 4px solid var(--primary-color);">
                        <h6 class="mb-3" style="font-weight: 700; color: var(--gray-800);">Shipping & Returns</h6>
                        <ul class="list-unstyled text-muted" style="line-height: 2;">
                            <li><i class="fas fa-truck" style="color: var(--primary-color); width: 25px;"></i> FREE shipping on orders over ₹500</li>
                            <li><i class="fas fa-undo" style="color: var(--primary-color); width: 25px;"></i> 30-day easy returns policy</li>
                            <li><i class="fas fa-shield-alt" style="color: var(--primary-color); width: 25px;"></i> 100% Secure Payment</li>
                            <li><i class="fas fa-headset" style="color: var(--primary-color); width: 25px;"></i> 24/7 Customer Support</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="container mb-5 animate-fade-in">
        <h3 class="section-title mb-4">Related Products</h3>
        <div class="row g-4">
            <?php
            $related = getAllProducts();
            $count = 0;
            while ($rel_product = mysqli_fetch_assoc($related) && $count < 4):
                if ($rel_product['subcat_id'] != $product_id):
                    $count++;
            ?>
                    <div class="col-md-6 col-lg-3 stagger-item lazy-element">
                        <a href="product.php?id=<?php echo $rel_product['subcat_id']; ?>" class="text-decoration-none">
                            <div class="product-card hover-lift">
                                <div class="product-image">
                                    <img src="<?php echo getSafeImagePath($rel_product['img']); ?>"
                                        alt="<?php echo htmlspecialchars($rel_product['name']); ?>"
                                        loading="lazy"
                                        width="300"
                                        height="250">
                                    <span class="product-badge">SALE</span>
                                </div>
                                <div class="product-body">
                                    <h5 class="product-name" style="color: var(--gray-800);"><?php echo htmlspecialchars($rel_product['name']); ?></h5>
                                    <p class="product-description"><?php echo htmlspecialchars(substr($rel_product['dis'] ?? '', 0, 50)) . '...'; ?></p>
                                    <div class="product-rating mb-3">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <span>(<?php echo rand(50, 300); ?>)</span>
                                    </div>
                                    <div class="product-footer">
                                        <div class="product-price"><?php echo formatPrice($rel_product['price']); ?></div>
                                        <button class="add-to-cart-btn" onclick="event.preventDefault(); addToCart(<?php echo $rel_product['subcat_id']; ?>)">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
            <?php
                endif;
            endwhile;
            ?>
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
        function increaseQty() {
            const qty = document.getElementById('quantity');
            qty.value = parseInt(qty.value) + 1;
        }

        function decreaseQty() {
            const qty = document.getElementById('quantity');
            if (parseInt(qty.value) > 1) {
                qty.value = parseInt(qty.value) - 1;
            }
        }

        function addProductToCart(productId) {
            const quantity = document.getElementById('quantity').value;
            fetch('add-to-cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'product_id=' + productId + '&quantity=' + quantity
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('✓ Product added to cart!', 'success');
                        setTimeout(() => window.location.href = 'cart.php', 1500);
                    } else {
                        showToast('✗ Error adding to cart', 'error');
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

        // Initialize image gallery when page loads
        document.addEventListener('DOMContentLoaded', initImageGallery);
    </script>
</body>

</html>