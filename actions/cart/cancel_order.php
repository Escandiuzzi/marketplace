<?php
include_once "../../facade.php";

$orderId = $_POST['order_id'] ?? null;
if ($orderId) {
    $orderDao = $factory->getOrderDao();
    $order = $orderDao->searchById((int)$orderId);
    
    if ($order && $order->getShippingDate() === null) {
        $order->setStatus(Status::Rejected);
        $orderDao->update($order);
    }
}

header("Location: ../../admin_view_orders.php");
exit;
