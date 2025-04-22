<?php
// First line with no whitespace before
require_once 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    exit(json_encode(['success' => false, 'message' => 'Invalid request method']));
}

// Input validation
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
]);

if (!$id || !$name || !$price || !$quantity) {
    http_response_code(400);
    exit(json_encode(['success' => false, 'message' => 'Invalid data']));
}

// Cart logic
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$itemExists = false;
foreach ($_SESSION['cart'] as &$item) {
    if ($item['id'] === $id) {
        $item['quantity'] += $quantity;
        $itemExists = true;
        break;
    }
}

if (!$itemExists) {
    $_SESSION['cart'][] = [
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'quantity' => $quantity
    ];
}

header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'cartCount' => count($_SESSION['cart']),
    'cartTotal' => array_reduce($_SESSION['cart'], function($sum, $item) {
        return $sum + ($item['price'] * $item['quantity']);
    }, 0)
]);