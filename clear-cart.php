<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    clearCart();
    echo json_encode(['success' => true, 'message' => 'Cart cleared successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
