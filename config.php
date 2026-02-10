<?php

/**
 * FLASH E-COMMERCE
 * Database Configuration & Helper Functions
 */

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database Connection
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'flash_e-com');

$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$con) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($con, "utf8mb4");

// Helper Functions

/**
 * Get all categories
 */
function getAllCategories()
{
    global $con;
    $query = "SELECT * FROM cat WHERE cat_id <= 16 ORDER BY cat_id";
    return mysqli_query($con, $query);
}

/**
 * Get category by ID
 */
function getCategoryById($id)
{
    global $con;
    $id = (int)$id;
    $query = "SELECT * FROM cat WHERE cat_id = $id";
    $result = mysqli_query($con, $query);
    return mysqli_fetch_assoc($result);
}

/**
 * Get all products (sub_cat)
 */
function getAllProducts()
{
    global $con;
    $query = "SELECT * FROM sub_cat WHERE subcat_id > 0 ORDER BY subcat_id";
    return mysqli_query($con, $query);
}

/**
 * Get product by ID
 */
function getProductById($id)
{
    global $con;
    $id = (int)$id;
    $query = "SELECT * FROM sub_cat WHERE subcat_id = $id";
    $result = mysqli_query($con, $query);
    return mysqli_fetch_assoc($result);
}

/**
 * Get limited products
 */
function getProductsLimit($limit = 8)
{
    global $con;
    $limit = (int)$limit;
    $query = "SELECT * FROM sub_cat WHERE subcat_id > 0 LIMIT $limit";
    return mysqli_query($con, $query);
}

/**
 * Escape string for safety
 */
function sanitize($string)
{
    global $con;
    return mysqli_real_escape_string($con, $string);
}

/**
 * Check if user is logged in
 */
function isUserLoggedIn()
{
    return isset($_SESSION['user_email']) && isset($_SESSION['user_id']);
}

/**
 * Get current logged-in user
 */
function getCurrentUser()
{
    if (isUserLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'email' => $_SESSION['user_email']
        ];
    }
    return null;
}

/**
 * Get cart from session
 */
function getCart()
{
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    return $_SESSION['cart'];
}

/**
 * Add item to cart
 */
function addToCart($product_id, $quantity = 1)
{
    $product = getProductById($product_id);

    if (!$product) {
        return false;
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'product_id' => $product_id,
            'name' => $product['name'],
            'price' => $product['price'],
            'img' => $product['img'],
            'quantity' => $quantity
        ];
    }

    return true;
}

/**
 * Remove item from cart
 */
function removeFromCart($product_id)
{
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
        return true;
    }
    return false;
}

/**
 * Update cart quantity
 */
function updateCartQuantity($product_id, $quantity)
{
    if (isset($_SESSION['cart'][$product_id])) {
        if ($quantity <= 0) {
            removeFromCart($product_id);
        } else {
            $_SESSION['cart'][$product_id]['quantity'] = (int)$quantity;
        }
        return true;
    }
    return false;
}

/**
 * Clear cart
 */
function clearCart()
{
    $_SESSION['cart'] = [];
}

/**
 * Get cart total
 */
function getCartTotal()
{
    $total = 0;
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    }
    return $total;
}

/**
 * Get cart item count
 */
function getCartCount()
{
    if (!isset($_SESSION['cart'])) {
        return 0;
    }

    $count = 0;
    foreach ($_SESSION['cart'] as $item) {
        $count += $item['quantity'];
    }
    return $count;
}

/**
 * Format currency
 */
function formatPrice($price)
{
    return '₹' . number_format($price, 2);
}

/**
 * Redirect with message
 */
function redirectWithMessage($url, $message, $type = 'success')
{
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
    header('Location: ' . $url);
    exit;
}

/**
 * Get and clear message
 */
function getMessage()
{
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        $type = $_SESSION['message_type'] ?? 'info';
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        return ['message' => $message, 'type' => $type];
    }
    return null;
}

/**
 * Validate email
 */
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Check if email exists
 */
function emailExists($email)
{
    global $con;
    $email = sanitize($email);
    $query = "SELECT id FROM log_in WHERE email = '$email'";
    $result = mysqli_query($con, $query);
    return mysqli_num_rows($result) > 0;
}

/**
 * User login
 */
function userLogin($email, $password)
{
    global $con;
    $email = sanitize($email);
    $password = sanitize($password);

    $query = "SELECT id, email FROM log_in WHERE email = '$email' AND pass = '$password'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        return true;
    }
    return false;
}

/**
 * Register new user
 */
function userRegister($email, $password)
{
    global $con;

    if (!validateEmail($email)) {
        return ['success' => false, 'message' => 'Invalid email format'];
    }

    if (emailExists($email)) {
        return ['success' => false, 'message' => 'Email already registered'];
    }

    if (strlen($password) < 6) {
        return ['success' => false, 'message' => 'Password must be at least 6 characters'];
    }

    $email = sanitize($email);
    $password = sanitize($password);

    $query = "INSERT INTO log_in (email, pass, c_pass) VALUES ('$email', '$password', '$password')";

    if (mysqli_query($con, $query)) {
        return ['success' => true, 'message' => 'Registration successful. Please login.'];
    }

    return ['success' => false, 'message' => 'Registration failed. Please try again.'];
}

/**
 * User logout
 */
function userLogout()
{
    session_destroy();
    header('Location: index.php');
    exit;
}

/**
 * Get user orders (placeholder)
 */
function getUserOrders($user_email)
{
    return [];
}

/**
 * Get featured products
 */
function getFeaturedProducts($limit = 8)
{
    global $con;
    $limit = (int)$limit;
    $query = "SELECT * FROM sub_cat WHERE subcat_id > 0 ORDER BY subcat_id DESC LIMIT $limit";
    return mysqli_query($con, $query);
}

/**
 * Get safe image path with fallback for missing images
 */
function getSafeImagePath($img_name)
{
    if (empty($img_name)) {
        return 'img/1.jpg';
    }

    // If it's a full URL (http/https), return it directly
    if (strpos($img_name, 'http://') === 0 || strpos($img_name, 'https://') === 0) {
        return htmlspecialchars($img_name);
    }

    // Product name to image mapping for better visuals
    $productImageMap = [
        // Electronics / Phones
        'iphone' => 'img/1.jpg',
        'phone' => 'img/1.jpg',
        'android' => 'img/2.jpg',
        'smartphone' => 'img/1.jpg',
        'mobile' => 'img/1.jpg',

        // Accessories
        'usb' => 'img/3.jpg',
        'cable' => 'img/3.jpg',
        'charger' => 'img/4.jpg',
        'power' => 'img/4.jpg',
        'headphone' => 'img/5.jpg',
        'earbuds' => 'img/5.jpg',
        'speaker' => 'img/6.jpg',

        // Computing
        'laptop' => 'img/7.jpg',
        'tablet' => 'img/8.jpg',
        'ipad' => 'img/8.jpg',
        'keyboard' => 'img/9.jpg',
        'mouse' => 'img/10.jpg',
        'monitor' => 'img/11.jpg',

        // Fashion
        'shirt' => 'img/12.jpg',
        'dress' => 'img/13.jpg',
        'shoes' => 'img/14.jpg',
        'jacket' => 'img/15.jpg',
        't-shirt' => 'img/12.jpg',
        'pants' => 'img/16.jpg',

        // Home & Garden
        'lamp' => 'img/18.jpg',
        'pillow' => 'img/19.jpg',
        'blanket' => 'img/20.jpg',
        'bed' => 'img/21.jpg',
        'furniture' => 'img/22.jpg',
        'table' => 'img/23.jpg',
        'chair' => 'img/24.jpg',

        // Books
        'book' => 'img/25.jpg',
        'novel' => 'img/25.jpg',
        'magazine' => 'img/26.jpg',

        // Sports
        'ball' => 'img/27.jpg',
        'racket' => 'img/28.jpg',
        'dumbbell' => 'img/30.jpg',
        'yoga' => 'img/31.jpg',
        'gym' => 'img/30.jpg',

        // Beauty
        'perfume' => 'img/32.jpg',
        'cosmetic' => 'img/33.jpg',
        'makeup' => 'img/33.jpg',
        'skincare' => 'img/32.jpg',

        // Toys
        'toy' => 'img/ben10.jpg',
        'action figure' => 'img/ben10.jpg',
        'doll' => 'img/dora1.jpg',
        'game' => 'img/9.jpg',

        // Automotive
        'car' => 'img/cars.webp',
        'bike' => 'img/cars2.jpg',
        'motorcycle' => 'img/cars2.jpg',

        // Pet Supplies
        'pet' => 'img/paw.jpg',
        'dog' => 'img/paw.jpg',
        'cat food' => 'img/tom.jpg',

        // Kitchen
        'kitchen' => 'img/6.jpg',
        'utensil' => 'img/6.jpg',
        'knife' => 'img/7.jpg',
        'cooking' => 'img/6.jpg',

        // Gaming
        'gaming' => 'img/9.jpg',
        'console' => 'img/9.jpg',
        'controller' => 'img/9.jpg',

        // Office
        'pen' => 'img/25.jpg',
        'notebook' => 'img/25.jpg',
        'desk' => 'img/23.jpg',
        'office' => 'img/23.jpg',

        // Travel
        'luggage' => 'img/27.jpg',
        'backpack' => 'img/27.jpg',

        // Fitness
        'fitness' => 'img/30.jpg',
        'training' => 'img/30.jpg',
        'exercise' => 'img/30.jpg'
    ];

    $lower_name = strtolower($img_name);

    // Check if product name matches any mapping
    foreach ($productImageMap as $keyword => $image) {
        if (strpos($lower_name, $keyword) !== false) {
            return $image;
        }
    }

    // List of valid image files in the img directory
    $valid_images = [
        '1.jpg',
        '1.jfif',
        '2.jpg',
        '3.jpg',
        '4.jpg',
        '4.png',
        '5.jpg',
        '5.jfif',
        '6.jpg',
        '7.jpg',
        '7.jfif',
        '8.jpg',
        '9.jpg',
        '9.jfif',
        '10.jpg',
        '11.png',
        '12.png',
        '13.jpg',
        '14.jpg',
        '15.png',
        '16.png',
        '17.jfif',
        '18.jpg',
        '19.jfif',
        '20.jpg',
        '21.jpg',
        '22.png',
        '23.jpg',
        '24.jpg',
        '25.jpg',
        '26.jpg',
        '27.jpg',
        '28.jpg',
        '30.jpg',
        '31.jpg',
        '32.jpg',
        '33.jpg',
        'ben10.jpg',
        'cars.webp',
        'cars2.jpg',
        'dora1.jpg',
        'paw.jpg',
        'tom.jpg'
    ];

    $img_path = 'img/' . htmlspecialchars($img_name);

    // If image exists in valid list, return it
    if (in_array($img_name, $valid_images)) {
        return $img_path;
    }

    // Default fallback to 1.jpg if image not found
    return 'img/1.jpg';
}
