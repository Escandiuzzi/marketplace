<?php
session_start();
$product_id = $_POST['product_id'] ?? null;

if ($product_id && isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($product_id) {
        return $item['product_id'] != $product_id;
    });
}

header("Location: ../../checkout.php");
exit;
