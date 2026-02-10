<?php
require_once 'config.php';

// Check if user is logged in
if (!isUserLoggedIn()) {
    header('Location: log.php');
    exit();
}

$user_email = $_SESSION['user_email'] ?? '';
$user_id = $_SESSION['user_id'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - FLASH E-Commerce</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="mcss/modern-style.css">
    <style>
        .profile-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 60px 0;
            margin-bottom: 40px;
        }

        .profile-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .profile-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
            margin-bottom: 20px;
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 20px;
        }

        .order-item {
            padding: 15px;
            border-left: 4px solid var(--primary-color);
            background: #f8f9fa;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .order-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-shipped {
            background: #d1ecf1;
            color: #0c5460;
        }

        .btn-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            color: white;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 25px;
            color: var(--text-dark);
            position: relative;
            padding-bottom: 12px;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .achievement-badge {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            background: #f8f9fa;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .achievement-badge:hover {
            transform: scale(1.05);
        }

        .achievement-icon {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .sidebar-nav {
            background: white;
            border-radius: 12px;
            padding: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .sidebar-nav a {
            display: block;
            padding: 15px 20px;
            border-bottom: 1px solid #e9ecef;
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar-nav a:last-child {
            border-bottom: none;
        }

        .sidebar-nav a:hover {
            background: #f8f9fa;
            padding-left: 30px;
            color: var(--primary-color);
        }

        .sidebar-nav a.active {
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
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
                        <a class="nav-link active" href="profile.php">
                            <i class="fas fa-user"></i> Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Profile Header -->
    <div class="profile-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1>My Profile</h1>
                    <p class="mb-0">Welcome back! Manage your account and view your orders.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <i class="fas fa-user-circle" style="font-size: 60px; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="container py-5">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="sidebar-nav">
                    <a href="#account" class="active" data-section="account">
                        <i class="fas fa-user me-2"></i> Account Information
                    </a>
                    <a href="#orders" data-section="orders">
                        <i class="fas fa-shopping-bag me-2"></i> My Orders
                    </a>
                    <a href="#wishlist" data-section="wishlist">
                        <i class="fas fa-heart me-2"></i> Wishlist
                    </a>
                    <a href="#addresses" data-section="addresses">
                        <i class="fas fa-map-marker-alt me-2"></i> Addresses
                    </a>
                    <a href="#settings" data-section="settings">
                        <i class="fas fa-cog me-2"></i> Settings
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Account Information Section -->
                <div class="section-content" id="account-section">
                    <h2 class="section-title">Account Information</h2>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="profile-card">
                                <div class="profile-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <p class="info-label">Email Address</p>
                                <p class="info-value"><?php echo htmlspecialchars($user_email); ?></p>
                                <button class="btn btn-custom btn-sm" data-bs-toggle="modal" data-bs-target="#editEmailModal">
                                    <i class="fas fa-edit me-2"></i> Edit
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="profile-card">
                                <div class="profile-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <p class="info-label">Member Since</p>
                                <p class="info-value"><?php echo date('F d, Y', strtotime('2025-01-20')); ?></p>
                                <button class="btn btn-sm" disabled style="background: #e9ecef; color: var(--text-muted);">
                                    View Member Badge
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="profile-card">
                                <div class="profile-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <p class="info-label">Phone Number</p>
                                <p class="info-value">+91 XXXXX XXXXX</p>
                                <button class="btn btn-custom btn-sm" data-bs-toggle="modal" data-bs-target="#editPhoneModal">
                                    <i class="fas fa-edit me-2"></i> Edit
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="profile-card">
                                <div class="profile-icon">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <p class="info-label">Password</p>
                                <p class="info-value">••••••••••</p>
                                <button class="btn btn-custom btn-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                    <i class="fas fa-lock me-2"></i> Change
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders Section -->
                <div class="section-content d-none" id="orders-section">
                    <h2 class="section-title">My Orders</h2>

                    <div class="order-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h6 class="mb-2">Order #2025001</h6>
                                <p class="text-muted mb-2" style="font-size: 14px;">
                                    <i class="fas fa-calendar me-2"></i> January 20, 2025
                                </p>
                                <p class="mb-0"><strong>Items:</strong> 3 products | <strong>Total:</strong> ₹2,499</p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <span class="order-status status-completed">
                                    <i class="fas fa-check-circle me-1"></i> Delivered
                                </span>
                                <br>
                                <small class="text-muted mt-2 d-block">Delivered on Jan 23, 2025</small>
                            </div>
                        </div>
                    </div>

                    <div class="order-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h6 class="mb-2">Order #2025002</h6>
                                <p class="text-muted mb-2" style="font-size: 14px;">
                                    <i class="fas fa-calendar me-2"></i> January 25, 2025
                                </p>
                                <p class="mb-0"><strong>Items:</strong> 2 products | <strong>Total:</strong> ₹1,899</p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <span class="order-status status-shipped">
                                    <i class="fas fa-truck me-1"></i> In Transit
                                </span>
                                <br>
                                <small class="text-muted mt-2 d-block">Expected delivery: Jan 28, 2025</small>
                            </div>
                        </div>
                    </div>

                    <div class="order-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h6 class="mb-2">Order #2025003</h6>
                                <p class="text-muted mb-2" style="font-size: 14px;">
                                    <i class="fas fa-calendar me-2"></i> February 1, 2025
                                </p>
                                <p class="mb-0"><strong>Items:</strong> 5 products | <strong>Total:</strong> ₹4,299</p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <span class="order-status status-pending">
                                    <i class="fas fa-hourglass-half me-1"></i> Processing
                                </span>
                                <br>
                                <small class="text-muted mt-2 d-block">Will ship soon</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wishlist Section -->
                <div class="section-content d-none" id="wishlist-section">
                    <h2 class="section-title">My Wishlist</h2>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="profile-card">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="<?php echo getSafeImagePath('1.jfif'); ?>" alt="Product" style="width: 100%; border-radius: 8px;">
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="mb-2">Wireless Headphones</h6>
                                        <p class="text-muted mb-3" style="font-size: 14px;">High-quality sound and comfort</p>
                                        <div class="d-flex justify-content-between">
                                            <span style="color: var(--primary-color); font-weight: 700;">₹2,499</span>
                                            <button class="btn btn-custom btn-sm">
                                                <i class="fas fa-cart-plus me-1"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="profile-card">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="<?php echo getSafeImagePath('5.jfif'); ?>" alt="Product" style="width: 100%; border-radius: 8px;">
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="mb-2">Smart Watch</h6>
                                        <p class="text-muted mb-3" style="font-size: 14px;">Fitness tracking and notifications</p>
                                        <div class="d-flex justify-content-between">
                                            <span style="color: var(--primary-color); font-weight: 700;">₹4,999</span>
                                            <button class="btn btn-custom btn-sm">
                                                <i class="fas fa-cart-plus me-1"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Addresses Section -->
                <div class="section-content d-none" id="addresses-section">
                    <h2 class="section-title">Saved Addresses</h2>

                    <div class="profile-card">
                        <div class="row">
                            <div class="col-md-10">
                                <h6 class="mb-2">
                                    <i class="fas fa-home" style="color: var(--primary-color);"></i> Home Address
                                </h6>
                                <p class="mb-2" style="color: var(--text-dark);">
                                    123 Main Street, Apartment 4B<br>
                                    New Delhi, Delhi 110001<br>
                                    India
                                </p>
                                <p class="text-muted" style="font-size: 14px;">
                                    <i class="fas fa-phone me-2"></i> +91 XXXXX XXXXX
                                </p>
                            </div>
                            <div class="col-md-2 text-md-end">
                                <button class="btn btn-sm btn-outline-primary mb-2">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-custom mt-4">
                        <i class="fas fa-plus me-2"></i> Add New Address
                    </button>
                </div>

                <!-- Settings Section -->
                <div class="section-content d-none" id="settings-section">
                    <h2 class="section-title">Account Settings</h2>

                    <div class="profile-card">
                        <div class="row align-items-center mb-4 pb-4" style="border-bottom: 1px solid #e9ecef;">
                            <div class="col">
                                <h6 class="mb-2">Email Notifications</h6>
                                <p class="text-muted mb-0" style="font-size: 14px;">Receive updates about orders and promotions</p>
                            </div>
                            <div class="col-auto">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="emailNotif" checked>
                                    <label class="form-check-label" for="emailNotif"></label>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center mb-4 pb-4" style="border-bottom: 1px solid #e9ecef;">
                            <div class="col">
                                <h6 class="mb-2">SMS Notifications</h6>
                                <p class="text-muted mb-0" style="font-size: 14px;">Receive delivery updates via SMS</p>
                            </div>
                            <div class="col-auto">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="smsNotif" checked>
                                    <label class="form-check-label" for="smsNotif"></label>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-2">Two-Factor Authentication</h6>
                                <p class="text-muted mb-0" style="font-size: 14px;">Add an extra layer of security</p>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-custom btn-sm">Enable</button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 pt-4" style="border-top: 2px solid #e9ecef;">
                        <h6 class="text-danger mb-3">Danger Zone</h6>
                        <button class="btn btn-outline-danger">
                            <i class="fas fa-trash me-2"></i> Delete Account
                        </button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle sidebar navigation
        document.querySelectorAll('.sidebar-nav a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const section = this.getAttribute('data-section');

                // Hide all sections
                document.querySelectorAll('.section-content').forEach(sec => {
                    sec.classList.add('d-none');
                });

                // Show selected section
                document.getElementById(section + '-section').classList.remove('d-none');

                // Update active link
                document.querySelectorAll('.sidebar-nav a').forEach(a => {
                    a.classList.remove('active');
                });
                this.classList.add('active');
            });
        });
    </script>
</body>

</html>