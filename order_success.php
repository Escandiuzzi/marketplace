<?php
$page_title = "Pedido Realizado com Sucesso!";
include_once "layout_header.php";
include_once "facade.php";

$orderId = $_GET['order_id'] ?? null;

if (!$orderId) {
    echo "<div class='p-6 text-center text-red-600'>Pedido não encontrado.</div>";
    include_once "layout_footer.php";
    exit;
}

$orderDao = $factory->getOrderDao();
$order = $orderDao->searchById((int)$orderId);

if (!$order) {
    echo "<div class='p-6 text-center text-red-600'>Pedido inválido.</div>";
    include_once "layout_footer.php";
    exit;
}

$clientDao = $factory->getClientDao();
$client = $clientDao->searchById($order->getClientId());
?>

<section class="min-h-screen bg-gray-50 py-12 px-6">
    <div class="max-w-4xl mx-auto bg-white shadow rounded-xl p-8 text-center">
        <h1 class="text-3xl font-bold text-green-600 mb-4">🎉 Pedido Confirmado!</h1>
        <p class="text-gray-700 mb-6">Obrigado por sua compra<?= $client ? ', ' . htmlspecialchars($client->getName()) : '' ?>!</p>

        <div class="text-left">
            <p class="mb-2"><strong>ID do Pedido:</strong> <?= $order->getId() ?></p>
            <p class="mb-2"><strong>Data:</strong> <?= $order->getCreatedAt()->format('d/m/Y H:i') ?></p>
            <p class="mb-4"><strong>Status:</strong> <?= $order->getStatus()->name ?></p>

            <h2 class="text-xl font-semibold mt-6 mb-2">Itens do Pedido</h2>
            <ul class="space-y-2">
                <?php foreach ($order->getProducts() as $item): ?>
                    <li class="border p-3 rounded-lg">
                        <strong><?= htmlspecialchars($item['product']->getName()) ?></strong><br>
                        Quantidade: <?= $item['quantity'] ?> <br>
                        Preço unitário: R$ <?= number_format($item['price'] / 100, 2, ',', '.') ?> <br>
                        Subtotal: R$ <?= number_format($item['total'] / 100, 2, ',', '.') ?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <p class="text-xl font-bold text-gray-800 mt-6">Total do Pedido: R$ <?= number_format($order->getTotal() / 100, 2, ',', '.') ?></p>
        </div>

        <a href="index.php" class="mt-8 inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
            Continuar Comprando
        </a>
    </div>
</section>

<?php include_once "layout_footer.php"; ?>
