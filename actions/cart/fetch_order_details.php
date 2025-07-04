<?php
require_once '../../facade.php';

$orderId = $_GET['id'] ?? null;
if (!$orderId) exit;

$orderDao = $factory->getOrderDao();
$order = $orderDao->searchById((int)$orderId);
if (!$order) exit;

$images = [];
foreach ($order->getProducts() as $productData) {
    array_push($images, $productData['product']->getImage());
}

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
            Pendente
        <?php endif; ?>
    </p>

    <div class="grid grid-cols-1 mt-4 mb-6">
        <?php if (!empty($images)): ?>
            <div class="swiper mySwiper mt-6 w-full max-w-2xl">
                <div class="swiper-wrapper">
                    <?php foreach ($images as $img): ?>
                        <div class="swiper-slide">
                            <div class="relative w-full h-48 mb-4">
                                <?php if ($img): ?>
                                    <img src="data:image/jpeg;base64,<?= base64_encode($img) ?>"
                                        class="w-full h-full object-cover rounded-lg"
                                        alt="Imagem do produto">
                                <?php else: ?>
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500 rounded-lg">
                                        Sem imagem
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        <?php endif; ?>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
        <?php foreach ($order->getProducts() as $productData):
            $product = $productData['product'];
            $quantity = $productData['quantity'];
            $price = $productData['price'];
            $total = $productData['total'];
        ?>
            <div class="border rounded p-3">
                <?php if ($product->getImage()): ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($product->getImage()) ?>"
                        class="w-32 h-32 object-cover rounded-lg"
                        alt="Imagem do produto">
                <?php else: ?>
                    <div class="w-32 h-32 bg-gray-200 flex items-center justify-center text-gray-500 rounded-lg">
                        Sem imagem
                    </div>
                <?php endif; ?>
                <h3 class="font-semibold mt-4"><?= htmlspecialchars($product->getName()) ?></h3>
                <p>ID: <?= $product->getId() ?></p>
                <p>Descrição: <?= $product->getDescription() ?></p>
                <p>Quantidade: <?= $quantity ?></p>
                <p>Preço unitário: R$ <?= number_format($price / 100, 2, ',', '.') ?></p>
                <p><strong>Total: R$ <?= number_format($total / 100, 2, ',', '.') ?></strong></p>
            </div>
        <?php endforeach; ?>
    </div>

    <p class="mt-4 font-bold text-right">Total do pedido: R$ <?= number_format($order->getTotal() / 100, 2, ',', '.') ?></p>
</div>