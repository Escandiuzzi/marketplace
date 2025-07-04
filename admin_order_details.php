<?php
$page_title = "Detalhes do Pedido";
include_once "layout_header.php";
include_once "facade.php";

$orderId = $_GET['id'] ?? null;
if (!$orderId) {
    echo "<p class='text-red-600'>ID do pedido inválido.</p>";
    include_once "layout_footer.php";
    exit;
}

$orderDao = $factory->getOrderDao();
$order = $orderDao->searchById($orderId);

if (!$order) {
    echo "<p class='text-red-600'>Pedido não encontrado.</p>";
    include_once "layout_footer.php";
    exit;
}

$clientDao = $factory->getClientDao();
$client = $clientDao->searchById($order->getClientId());

$images = [];
foreach ($order->getProducts() as $productData) {
    array_push($images, $productData['product']->getImage());
}
?>

<section class="min-h-screen bg-gray-100 py-12 px-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow">
        <a href="my_orders.php" class="text-blue-600 hover:underline text-sm mb-4 inline-block">
            &larr; Voltar para meus pedidos
        </a>

        <h1 class="text-2xl font-bold mb-4">Pedido #<?= $order->getId() ?></h1>

        <p class="mb-2"><strong>Status:</strong> <?php if ($order->getShippingDate()): ?>
                <?= $order->getShippingDate()->format('d/m/Y') ?>
            <?php elseif ($order->getStatus() == Status::Rejected): ?>
                Pedido cancelado
            <?php else: ?>
                Pendente
            <?php endif; ?></p>
        <p class="mb-2"><strong>Cliente:</strong> <?= htmlspecialchars($client->getName()) ?></p>
        <p class="mb-2"><strong>Data do Pedido:</strong> <?= $order->getCreatedAt()->format('d/m/Y H:i') ?></p>
        <p class="mb-6"><strong>Envio previsto:</strong> <?= $order->getShippingDate() ? $order->getShippingDate()->format('d/m/Y') : ($order->getStatus() == Status::Rejected ? "Pedido Cancelado" : 'aa') ?></p>

        <hr class="my-6">

        <h2 class="text-xl font-semibold mb-4">Produtos</h2>

        <?php if (!empty($images)): ?>
            <div x-data="{ active: 0 }" class="mb-10">
                <div class="relative w-full h-64 overflow-hidden rounded-xl">
                    <?php foreach ($images as $index => $img): ?>
                        <div x-show="active === <?= $index ?>"

                            class="absolute inset-0 transition-opacity duration-500"
                            x-transition:enter="opacity-0"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="opacity-100"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0">
                            <?php if ($img): ?>
                                <img src="data:image/jpeg;base64,<?= base64_encode($img) ?>"
                                    class="w-full h-full object-cover"
                                    alt="Imagem do produto">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-500">
                                    Sem imagem
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="flex justify-center items-center gap-2 mt-4">
                    <?php foreach ($images as $index => $_): ?>
                        <button class="w-3 h-3 rounded-full border border-blue-500"
                            :class="{ 'bg-blue-600': active === <?= $index ?>, 'bg-white': active !== <?= $index ?> }"
                            @click="active = <?= $index ?>"></button>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>


        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <?php foreach ($order->getProducts() as $productData):
                $product = $productData['product'];
                $quantity = $productData['quantity'];
                $price = $productData['price'];
                $total = $productData['total'];
            ?>
                <div class="bg-gray-50 p-4 rounded-lg shadow">
                    <div class="relative w-full h-48 mb-4">
                        <?php if ($product->getImage()): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($product->getImage()) ?>"
                                class="w-full h-full object-cover rounded-lg"
                                alt="Imagem do produto">
                        <?php else: ?>
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500 rounded-lg">
                                Sem imagem
                            </div>
                        <?php endif; ?>
                    </div>

                    <h3 class="text-lg font-semibold"><?= htmlspecialchars($product->getName()) ?></h3>
                    <p>ID: <?= $product->getId() ?></p>
                    <p>Quantidade: <?= $quantity ?></p>
                    <p>Preço unitário: R$ <?= number_format($price / 100, 2, ',', '.') ?></p>
                    <p>Total: <strong>R$ <?= number_format($total / 100, 2, ',', '.') ?></strong></p>
                </div>
            <?php endforeach; ?>
        </div>

        <hr class="my-6">
        <p class="text-xl font-bold text-right">Total do pedido: R$ <?= number_format($order->getTotal() / 100, 2, ',', '.') ?></p>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<?php include_once "layout_footer.php"; ?>