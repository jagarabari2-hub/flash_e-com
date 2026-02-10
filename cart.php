<?php
require_once 'config.php';

$message = getMessage();
$cart = getCart();
$total = getCartTotal();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - FLASH E-Commerce</title>

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
                        <a class="nav-link" href="sub-cat.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="cart.php">
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

    <!-- Cart Section -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="mb-5">
                <h1 class="display-5 mb-3"><i class="fas fa-shopping-cart"></i> Your Shopping Cart</h1>
                <p class="text-muted">Manage your items and proceed to checkout</p>
            </div>

            <?php if (empty($cart)): ?>
                <div class="text-center py-5 animate-fade-in">
                    <i class="fas fa-inbox fa-5x mb-3" style="color: #ddd;"></i>
                    <h3 style="font-weight: 700; font-size: 2rem; margin-bottom: 1rem;">Your Cart is Empty</h3>
                    <p class="text-muted mb-4" style="font-size: 1.1rem;">Add some amazing products to your cart and start shopping!</p>
                    <a href="sub-cat.php" class="btn btn-primary-custom" style="padding: 0.75rem 2rem; font-size: 1.1rem;">
                        <i class="fas fa-shopping-bag"></i> Continue Shopping
                    </a>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <div class="col-lg-8">
                        <?php foreach ($cart as $item): ?>
                            <div class="cart-item animate-fade-in" style="animation-delay: 0.1s;">
                                <img src="<?php echo getSafeImagePath($item['img'] ?? ''); ?>"
                                    alt="<?php echo htmlspecialchars($item['name']); ?>"
                                    loading="lazy"
                                    width="100"
                                    height="100">
                                <div class="cart-item-details">
                                    <h5><a href="product.php?id=<?php echo $item['product_id']; ?>" style="color: inherit; text-decoration: none;"><?php echo htmlspecialchars($item['name']); ?></a></h5>
                                    <p class="text-muted"><?php echo htmlspecialchars(substr($item['name'], 0, 50)); ?></p>
                                </div>
                                <input type="number" class="quantity-input" value="<?php echo $item['quantity']; ?>" min="1" max="100"
                                    onchange="updateQuantity(<?php echo $item['product_id']; ?>, this.value)">
                                <div class="cart-price" style="font-weight: 700; font-size: 1.25rem;"><?php echo formatPrice($item['price'] * $item['quantity']); ?></div>
                                <button class="remove-btn" onclick="removeItem(<?php echo $item['product_id']; ?>)" title="Remove from cart">
                                    <i class="fas fa-trash"></i> Remove
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="col-lg-4">
                        <div class="cart-summary animate-fade-in">
                            <h5 class="mb-4" style="font-weight: 700; font-size: 1.5rem;">Order Summary</h5>

                            <?php
                            $subtotal = $total;
                            $shipping = $subtotal > 500 ? 0 : 100;
                            $tax = ($subtotal * 0.18);
                            $grand_total = $subtotal + $shipping + $tax;
                            ?>

                            <div class="summary-row">
                                <span>Subtotal</span>
                                <span><?php echo formatPrice($subtotal); ?></span>
                            </div>
                            <div class="summary-row">
                                <span>Shipping</span>
                                <span class="<?php echo $shipping == 0 ? 'text-success' : ''; ?>" style="<?php echo $shipping == 0 ? 'font-weight: 700;' : ''; ?>">
                                    <?php echo $shipping == 0 ? '✓ FREE' : formatPrice($shipping); ?>
                                </span>
                            </div>
                            <div class="summary-row">
                                <span>Tax (18%)</span>
                                <span><?php echo formatPrice($tax); ?></span>
                            </div>
                            <div class="summary-row" style="font-size: 1.25rem;">
                                <span style="font-weight: 700;">Total</span>
                                <span style="color: var(--primary-color); font-weight: 700;"><?php echo formatPrice($grand_total); ?></span>
                            </div>

                            <button class="checkout-btn btn-ripple" onclick="goToCheckout()" style="margin-top: 2rem;">
                                <i class="fas fa-credit-card"></i> Proceed to Checkout
                            </button>

                            <a href="sub-cat.php" class="btn btn-outline-secondary w-100 mt-2" style="padding: 0.75rem;">
                                <i class="fas fa-arrow-left"></i> Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
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
        function removeItem(productId) {
            if (confirm('Remove this item from cart?')) {
                fetch('remove-from-cart.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'product_id=' + productId
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('✓ Item removed!', 'success');
                            setTimeout(() => location.reload(), 500);
                        } else {
                            showToast('✗ Error removing item', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('✗ Network error', 'error');
                    });
            }
        }

        function updateQuantity(productId, quantity) {
            if (quantity < 1) {
                removeItem(productId);
                return;
            }

            fetch('update-cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'product_id=' + productId + '&quantity=' + quantity
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
        }

        function goToCheckout() {
            showToast('📋 Proceeding to checkout...', 'success');
            setTimeout(() => {
                window.location.href = 'checkout.php';
            }, 500);
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