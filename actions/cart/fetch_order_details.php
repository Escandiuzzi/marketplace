<?php
require_once '../../facade.php';

$orderId = $_GET['id'] ?? null;
if (!$orderId) exit;

$orderDao = $factory->getOrderDao();
$order = $orderDao->searchById((int)$orderId);
if (!$order) exit;

$clientDao = $factory->getClientDao();
$client = $clientDao->searchById($order->getClientId());
?>

<div class="bg-gray-50 p-4 rounded-lg">
    <p><strong>Cliente:</strong> <?= htmlspecialchars($client->getName()) ?></p>
    <p><strong>Envio previsto:</strong>
        <?php if ($order->getShippingDate()): ?>
            <?= $order->getShippingDate()->format('d/m/Y') ?>
        <?php elseif ($order->getStatus() == Status::Rejected): ?>
            Pedido cancelado
        <?php else: ?>
            Indefinido
    <div class="mt-2 flex gap-2">
        <!-- Cancel Order Button -->
        <form method="POST" action="./actions/cart/cancel_order.php">
            <input type="hidden" name="order_id" value="<?= $order->getId() ?>">
            <button type="submit" class="text-sm bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                Cancelar Pedido
            </button>
        </form>

        <!-- Set Shipping Date Form -->
        <form method="POST" action="./actions/cart/set_shipping_date.php" class="flex items-center gap-2">
            <input type="hidden" name="order_id" value="<?= $order->getId() ?>">
            <input type="date" name="shipping_date" class="border px-2 py-1 rounded text-sm">
            <button type="submit" class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                Definir Envio
            </button>
        </form>
    </div>
<?php endif; ?>
</p>


<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
    <?php foreach ($order->getProducts() as $productData):
        $product = $productData['product'];
        $quantity = $productData['quantity'];
        $price = $productData['price'];
        $total = $productData['total'];
    ?>
        <div class="border rounded p-3">
            <?php if ($product->getImage()): ?>
                <img src="data:image/jpeg;base64,<?= base64_encode($product->getImage()) ?>" class="w-full h-32 object-cover rounded mb-2">
            <?php endif; ?>
            <h3 class="font-semibold"><?= htmlspecialchars($product->getName()) ?></h3>
            <p>ID: <?= $product->getId() ?></p>
            <p>Quantidade: <?= $quantity ?></p>
            <p>Preço unitário: R$ <?= number_format($price / 100, 2, ',', '.') ?></p>
            <p><strong>Total: R$ <?= number_format($total / 100, 2, ',', '.') ?></strong></p>
        </div>
    <?php endforeach; ?>
</div>

<p class="mt-4 font-bold text-right">Total do pedido: R$ <?= number_format($order->getTotal() / 100, 2, ',', '.') ?></p>
</div>