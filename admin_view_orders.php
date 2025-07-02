<?php
session_start();
$page_title = "Todos os Pedidos";
include_once "layout_header.php";
include_once "facade.php";

$orderDao = $factory->getOrderDao();

$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$ordersPerPage = 5;
$offset = ($currentPage - 1) * $ordersPerPage;


$clientOrders = $orderDao->getAll();
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
                    <div class="order-card bg-white rounded-lg shadow p-4 mb-4">
                        <div class="flex justify-between items-center cursor-pointer toggle-details" data-order-id="<?= $order->getId() ?>">
                            <div>
                                <h2 class="text-lg font-bold">Pedido #<?= $order->getId() ?></h2>
                                <p>Status: <?= $order->getStatus()->name ?></p>
                                <p>Data: <?= $order->getCreatedAt()->format('d/m/Y') ?></p>
                            </div>
                            <span class="text-blue-600 hover:underline">Ver detalhes</span>
                        </div>

                        <div class="order-details mt-4 hidden" id="order-details-<?= $order->getId() ?>"></div>
                    </div>
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

<script>
document.querySelectorAll('.toggle-details').forEach(btn => {
    btn.addEventListener('click', function () {
        const orderId = this.dataset.orderId;
        const detailsContainer = document.getElementById(`order-details-${orderId}`);

        if (detailsContainer.classList.contains('hidden')) {
            if (detailsContainer.innerHTML.trim() === '') {
                // Fetch order details via AJAX
                fetch(`./actions/cart/fetch_order_details.php?id=${orderId}`)
                    .then(res => res.text())
                    .then(html => {
                        detailsContainer.innerHTML = html;
                        detailsContainer.classList.remove('hidden');
                    });
            } else {
                detailsContainer.classList.remove('hidden');
            }
        } else {
            detailsContainer.classList.add('hidden');
        }
    });
});
</script>


<?php include_once "layout_footer.php"; ?>