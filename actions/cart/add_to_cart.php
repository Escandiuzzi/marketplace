<?php
require "../../facade.php";

session_start();

$product_id = $_POST['product_id'] ?? null;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

if ($product_id === null || $quantity <= 0) {
    header("Location: ../../index.php");
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['quantity'] = $quantity;
} else {
    $_SESSION['cart'][$product_id] = [
        'product_id' => $product_id,
        'quantity' => $quantity
    ];
}

header("Location: ../../index.php?added_to_cart=1");
exit;