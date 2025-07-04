<?php
session_start();
$page_title = "Meus Pedidos";
include_once "layout_header.php";
include_once "facade.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$clientId = $_SESSION["user_id"];
$orderDao = $factory->getOrderDao();

$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$ordersPerPage = 5;
$offset = ($currentPage - 1) * $ordersPerPage;


$clientOrders = $orderDao->getAllByClientId($clientId);
$totalOrders = count($clientOrders);
$totalPages = ceil($totalOrders / $ordersPerPage);
$orders = array_slice($clientOrders, $offset, $ordersPerPage);
?>

<section class="min-h-screen bg-gray-100 py-10 px-6">
    <div class="max-w-4xl mx-auto bg-white shadow p-6 rounded-xl">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Meus Pedidos</h1>

        <?php if (empty($orders)): ?>
            <p class="text-gray-500">Você ainda não realizou nenhum pedido.</p>
        <?php else: ?>
            <ul class="space-y-4">
                <?php foreach ($orders as $order): ?>
                    <li class="border p-4 rounded hover:shadow transition">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-lg font-semibold">Pedido #<?= $order->getId() ?></p>
                                <p class="text-sm text-gray-500">
                                    Data: <?= $order->getCreatedAt()->format('d/m/Y H:i') ?>
                                    • Total: R$ <?= number_format($order->getTotal() / 100, 2, ',', '.') ?>
                                    • Status: <?= $order->getShippingDate() != null ? 'Enviado' : ($order->getStatus() == Status::Rejected ? "Pedido Cancelado" : 'Pendente') ?>
                                </p>
                            </div>
                            <a href="order_details.php?id=<?= $order->getId() ?>"
                                class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 text-sm">
                                Ver Detalhes
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

            <?php if ($totalPages > 1): ?>
                <div class="mt-6 flex justify-center gap-2">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>"
                            class="px-3 py-1 rounded border text-sm
                           <?= $i === $currentPage ? 'bg-blue-600 text-white' : 'bg-white text-blue-600 hover:bg-blue-100' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?php include_once "layout_footer.php"; ?>