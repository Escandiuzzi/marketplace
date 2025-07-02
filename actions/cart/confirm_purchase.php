<?php
require "../../facade.php";
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

$clientId = $_SESSION['user_id'];
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    die('Carrinho vazio.');
}

$productDao = $factory->getProductDao();
$orderDao = $factory->getOrderDao();

$products = [];
$total = 0;


foreach ($cart as $item) {
    $product = $productDao->searchById($item['product_id']);

    if (!$product) {
        die("Produto não encontrado.");
    }

    $availableQty = $product->getStock()->getQuantity();
    $requestedQty = min($item['quantity'], $availableQty);

    if ($requestedQty <= 0) {
        continue;
    }

    $priceInCents = round($product->getStock()->getPrice() * 100);
    $subtotalInCents = $priceInCents * $requestedQty;
    $total += $subtotalInCents;

    $products[] = [
        'product_id' => $product->getId(),
        'quantity' => $requestedQty,
        'price' => $priceInCents
    ];

    $product->getStock()->setQuantity($availableQty - $requestedQty);
    $productDao->update($product);
}

$order = new Order(
    0,
    $clientId,
    $products,
    $total,
    new DateTime(),
    null,
    Status::Pending
);

$orderId = $orderDao->insert($order);

unset($_SESSION['cart']);

if ($orderId === 0) {
    die("Erro ao criar o pedido.");
}

header("Location: ../../order_success.php?order_id={$orderId}");
exit;
