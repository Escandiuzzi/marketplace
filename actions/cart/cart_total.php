<?php
header('Content-Type: application/json');
error_reporting(0); 
session_start();
require_once '../../facade.php';

$cart = $_SESSION['cart'] ?? [];
$productDao = $factory->getProductDao();

$cart_total = 0;

foreach ($cart as $item) {
    $product = $productDao->searchById($item['product_id']);
    if ($product && $product->getStock()->getQuantity() > 0) {
        $quantity = min($item['quantity'], $product->getStock()->getQuantity());
        $price = $product->getStock()->getPrice();
        $cart_total += $price * $quantity;
    }
}

echo json_encode([
    'success' => true,
    'cart_total' => number_format($cart_total, 2, ',', '.')
]);
