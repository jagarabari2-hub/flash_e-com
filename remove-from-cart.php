<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];

    if (removeFromCart($product_id)) {
        echo json_encode(['success' => true, 'message' => 'Product removed from cart']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to remove product']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
