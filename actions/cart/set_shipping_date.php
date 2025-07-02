<?php
include_once "../../facade.php";

$orderId = $_POST['order_id'] ?? null;
$shippingDateStr = $_POST['shipping_date'] ?? null;

if ($orderId && $shippingDateStr) {
    try {
        $shippingDate = new DateTime($shippingDateStr);

        $orderDao = $factory->getOrderDao();
        $order = $orderDao->searchById((int)$orderId);
        if ($order && $order->getShippingDate() === null) {
            $order->setShippingDate($shippingDate);
            $order->setStatus(Status::Approved);
            $orderDao->update($order);
        }
    } catch (Exception $e) {
    }
}

header("Location: ../../admin_view_orders.php");
exit;
