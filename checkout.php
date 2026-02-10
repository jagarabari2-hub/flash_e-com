<?php
require_once 'config.php';

// Check if user is logged in
if (!isUserLoggedIn()) {
    header('Location: log.php');
    exit();
}

$cart = getCart();
if (empty($cart)) {
    redirectWithMessage('cart.php', 'Your cart is empty. Please add products first.', 'warning');
}
$cart_total = getCartTotal();
$user_email = $_SESSION['user_email'] ?? '';

// Calculate tax and shipping
$subtotal = $cart_total;
$tax = round($subtotal * 0.18); // 18% GST
$shipping = $subtotal > 500 ? 0 : 99;
$total = $subtotal + $tax + $shipping;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - FLASH E-Commerce</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="mcss/modern-style.css">

    <style>
        .checkout-section {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .section-header {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--primary-color);
            color: var(--text-dark);
        }

        .payment-option {
            padding: 20px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .payment-option:hover {
            border-color: var(--primary-color);
            background: #f8f9fa;
        }

        .payment-option input[type="radio"] {
            cursor: pointer;
            width: 20px;
            height: 20px;
        }

        .payment-option.active {
            border-color: var(--primary-color);
            background: rgba(255, 107, 53, 0.05);
        }

        .payment-icon {
            font-size: 32px;
            color: var(--primary-color);
            min-width: 50px;
            text-align: center;
        }

        .payment-details {
            flex: 1;
        }

        .payment-details h6 {
            margin: 0 0 5px 0;
            font-weight: 600;
            color: var(--text-dark);
        }

        .payment-details p {
            margin: 0;
            font-size: 14px;
            color: var(--text-muted);
        }

        .order-summary {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            position: sticky;
            top: 100px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .summary-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .summary-total {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid var(--primary-color);
        }

        .cart-item {
            display: flex;
            gap: 15px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            margin-bottom: 10px;
            border-left: 4px solid var(--primary-color);
        }

        .cart-item-img {
            width: 80px;
            height: 80px;
            background: #f0f0f0;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #ccc;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-info h6 {
            margin: 0 0 5px 0;
            font-weight: 600;
        }

        .cart-item-price {
            color: var(--primary-color);
            font-weight: 700;
        }

        .btn-checkout {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 100%;
            font-size: 16px;
        }

        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            color: white;
        }

        .btn-checkout:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .address-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid var(--primary-color);
        }

        .address-info p {
            margin: 0;
            font-size: 14px;
            line-height: 1.6;
        }

        .form-section {
            margin-bottom: 20px;
        }

        .form-section label {
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--text-dark);
        }

        .icon-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 107, 53, 0.1);
            border-radius: 50%;
            margin-right: 10px;
        }
    </style>
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
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sub-cat.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">
                            <i class="fas fa-shopping-cart"></i> Cart
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="checkout.php">Checkout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="container mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="cart.php">Cart</a></li>
            <li class="breadcrumb-item active">Checkout</li>
        </ol>
    </nav>

    <!-- Main Checkout Section -->
    <div class="container py-5">
        <?php if (empty($cart)): ?>
            <div class="alert alert-warning text-center">
                <i class="fas fa-shopping-cart fa-3x mb-3 d-block"></i>
                <h4>Your cart is empty!</h4>
                <p>Add some products before checking out.</p>
                <a href="sub-cat.php" class="btn btn-primary-custom mt-3">Continue Shopping</a>
            </div>
        <?php else: ?>
            <div class="row gap-4">
                <!-- Left Side - Checkout Form -->
                <div class="col-lg-8">
                    <!-- Delivery Address Section -->
                    <div class="checkout-section">
                        <h4 class="section-header">
                            <i class="fas fa-map-marker-alt me-2"></i> Delivery Address
                        </h4>

                        <div class="address-info">
                            <p><strong><?php echo htmlspecialchars($user_email); ?></strong></p>
                            <p>123 Main Street, Apartment 4B</p>
                            <p>New Delhi, Delhi 110001, India</p>
                            <p><i class="fas fa-phone me-2"></i> +91 XXXXX XXXXX</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-section">
                                <label>Full Name</label>
                                <input type="text" class="form-control" placeholder="Enter your full name">
                            </div>
                            <div class="col-md-6 form-section">
                                <label>Phone Number</label>
                                <input type="tel" class="form-control" placeholder="10-digit mobile number">
                            </div>
                            <div class="col-12 form-section">
                                <label>Address</label>
                                <textarea class="form-control" rows="3" placeholder="Enter your complete address"></textarea>
                            </div>
                            <div class="col-md-6 form-section">
                                <label>City</label>
                                <input type="text" class="form-control" placeholder="City name">
                            </div>
                            <div class="col-md-6 form-section">
                                <label>Postal Code</label>
                                <input type="text" class="form-control" placeholder="6-digit postal code">
                            </div>
                        </div>

                        <button class="btn btn-primary-custom mt-3">
                            <i class="fas fa-save me-2"></i> Save & Continue
                        </button>
                    </div>

                    <!-- Payment Method Section -->
                    <div class="checkout-section">
                        <h4 class="section-header">
                            <i class="fas fa-credit-card me-2"></i> Payment Method
                        </h4>

                        <form>
                            <!-- GPay / Google Pay -->
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="gpay" class="payment-method">
                                <div class="icon-badge">
                                    <i class="fas fa-google"></i>
                                </div>
                                <div class="payment-details">
                                    <h6>Google Pay</h6>
                                    <p>Fast and secure payment with Google Pay</p>
                                </div>
                            </label>

                            <!-- PhonePe -->
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="phonepe" class="payment-method">
                                <div class="icon-badge">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <div class="payment-details">
                                    <h6>PhonePe</h6>
                                    <p>Instant UPI payment with PhonePe app</p>
                                </div>
                            </label>

                            <!-- PayPal -->
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="paypal" class="payment-method">
                                <div class="icon-badge">
                                    <i class="fab fa-paypal"></i>
                                </div>
                                <div class="payment-details">
                                    <h6>PayPal</h6>
                                    <p>Pay securely with your PayPal account</p>
                                </div>
                            </label>

                            <!-- Paytm -->
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="paytm" class="payment-method">
                                <div class="icon-badge">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <div class="payment-details">
                                    <h6>Paytm</h6>
                                    <p>Pay using Paytm Wallet or UPI</p>
                                </div>
                            </label>

                            <!-- Razorpay -->
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="razorpay" class="payment-method">
                                <div class="icon-badge">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div class="payment-details">
                                    <h6>Razorpay</h6>
                                    <p>Debit/Credit Card, Netbanking & UPI</p>
                                </div>
                            </label>

                            <!-- UPI -->
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="upi" class="payment-method">
                                <div class="icon-badge">
                                    <i class="fas fa-money-bill"></i>
                                </div>
                                <div class="payment-details">
                                    <h6>Direct UPI</h6>
                                    <p>Direct bank transfer using UPI ID</p>
                                </div>
                            </label>

                            <!-- Cash on Delivery -->
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cod" class="payment-method">
                                <div class="icon-badge">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>
                                <div class="payment-details">
                                    <h6>Cash on Delivery (COD)</h6>
                                    <p>Pay when your order arrives at your doorstep</p>
                                </div>
                            </label>
                        </form>
                    </div>

                    <!-- Order Review Section -->
                    <div class="checkout-section">
                        <h4 class="section-header">
                            <i class="fas fa-list me-2"></i> Order Review
                        </h4>

                        <?php foreach ($cart as $item): ?>
                            <div class="cart-item">
                                <div class="cart-item-img">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="cart-item-info">
                                    <h6><?php echo htmlspecialchars($item['name']); ?></h6>
                                    <p>Quantity: <strong><?php echo $item['quantity']; ?></strong></p>
                                    <span class="cart-item-price"><?php echo formatPrice($item['price'] * $item['quantity']); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Right Side - Order Summary -->
                <div class="col-lg-4">
                    <div class="order-summary">
                        <h5 class="section-header" style="border-bottom: 2px solid var(--primary-color);">
                            <i class="fas fa-receipt me-2"></i> Order Summary
                        </h5>

                        <div class="summary-item">
                            <span>Subtotal</span>
                            <span><?php echo formatPrice($subtotal); ?></span>
                        </div>

                        <div class="summary-item">
                            <span>Tax (18% GST)</span>
                            <span><?php echo formatPrice($tax); ?></span>
                        </div>

                        <div class="summary-item">
                            <span>Shipping</span>
                            <span><?php echo $shipping == 0 ? '<span class="badge bg-success">FREE</span>' : formatPrice($shipping); ?></span>
                        </div>

                        <div class="summary-total">
                            <span>Total Amount:</span>
                            <span><?php echo formatPrice($total); ?></span>
                        </div>

                        <button class="btn-checkout mt-4" onclick="processPayment()">
                            <i class="fas fa-lock me-2"></i> Proceed to Payment
                        </button>

                        <p class="text-center text-muted mt-3" style="font-size: 12px;">
                            <i class="fas fa-shield-alt me-1"></i> Your payment is 100% secure
                        </p>

                        <hr>

                        <div class="mt-4">
                            <h6 class="mb-3">
                                <i class="fas fa-info-circle me-2"></i> Important Information
                            </h6>
                            <div style="font-size: 13px; line-height: 1.8; color: var(--text-muted);">
                                <p>✓ Free delivery on orders above ₹500</p>
                                <p>✓ 100% secure & encrypted payments</p>
                                <p>✓ Easy returns within 30 days</p>
                                <p>✓ 24/7 customer support available</p>
                            </div>
                        </div>

                        <a href="cart.php" class="btn btn-outline-secondary w-100 mt-3">
                            <i class="fas fa-arrow-left me-2"></i> Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container py-5">
            <div class="footer-content">
                <div class="footer-section">
                    <h5><i class="fas fa-bolt"></i> FLASH</h5>
                    <p>Your one-stop destination for all your shopping needs.</p>
                </div>
                <div class="footer-section">
                    <h5>Quick Links</h5>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="sub-cat.php">Products</a></li>
                        <li><a href="cat.php">Categories</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h5>Customer Service</h5>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Shipping Info</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 FLASH E-Commerce. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Payment method selection with visual feedback
        document.querySelectorAll('.payment-method').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.payment-option').forEach(opt => {
                    opt.classList.remove('active');
                });
                this.closest('.payment-option').classList.add('active');
            });
        });

        function processPayment() {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');

            if (!paymentMethod) {
                alert('Please select a payment method');
                return;
            }

            const method = paymentMethod.value;

            // Show success message
            showAlert(`Payment processing with ${method.toUpperCase()}...`, 'success');

            // Simulate payment processing
            setTimeout(() => {
                // Clear cart and redirect
                fetch('clear-cart.php', {
                        method: 'POST'
                    })
                    .then(() => {
                        alert('Order placed successfully! Order ID: #FL' + Math.random().toString(36).substr(2, 9).toUpperCase());
                        window.location.href = 'index.php';
                    });
            }, 2000);
        }

        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      `;
            document.body.insertBefore(alertDiv, document.querySelector('nav').nextElementSibling);
            setTimeout(() => alertDiv.remove(), 4000);
        }
    </script>
</body>

</html>