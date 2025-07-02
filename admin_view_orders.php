<?php
session_start();
$page_title = "Todos os Pedidos";
include_once "layout_header.php";
include_once "facade.php";

$orderDao = $factory->getOrderDao();
$clientDao = $factory->getClientDao();

$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$ordersPerPage = 5;
$offset = ($currentPage - 1) * $ordersPerPage;

$search = $_GET['search'] ?? null;

if ($search !== null && trim($search) !== '') {
    $search = trim($search);
    $clientOrders = [];

    if (is_numeric($search)) {
        $order = $orderDao->searchById((int)$search);
        if ($order) {
            $clientOrders[] = $order;
        }
    }

    $allOrders = $orderDao->getAll();
    foreach ($allOrders as $order) {
        $client = $clientDao->searchById($order->getClientId());
        if ($client && stripos($client->getName(), $search) !== false) {
            $clientOrders[] = $order;
        }
    }

    // Remover duplicatas caso tenha vindo por ID e nome
    $clientOrders = array_unique($clientOrders, SORT_REGULAR);
} else {
    $clientOrders = $orderDao->getAll();
}

$totalOrders = count($clientOrders);
$totalPages = ceil($totalOrders / $ordersPerPage);
$orders = array_slice($clientOrders, $offset, $ordersPerPage);
?>

<section class="min-h-screen bg-gray-100 py-10 px-6">
    <div class="max-w-4xl mx-auto bg-white shadow p-6 rounded-xl">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Meus Pedidos</h1>

        <!-- Formulário de busca -->
        <form method="GET" class="mb-6 flex gap-2 flex-wrap">
            <input type="text" name="search" placeholder="Buscar por ID ou nome do cliente"
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                class="border rounded-lg px-4 py-2 w-full sm:w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Buscar
            </button>
        </form>

        <?php if (empty($orders)): ?>
            <p class="text-gray-500">Nenhum pedido encontrado.</p>
        <?php else: ?>
            <ul class="space-y-4">
                <?php foreach ($orders as $order): 
                    $client = $clientDao->searchById($order->getClientId());
                ?>
                    <div class="order-card bg-white rounded-lg shadow p-4 mb-4">
                        <div class="flex justify-between items-center cursor-pointer toggle-details" data-order-id="<?= $order->getId() ?>">
                            <div>
                                <h2 class="text-lg font-bold">Pedido #<?= $order->getId() ?></h2>
                                <p>Cliente: <?= htmlspecialchars($client->getName()) ?></p>
                                <p>Status: <?= $order->getStatus()->name ?></p>
                                <p>Data: <?= $order->getCreatedAt()->format('d/m/Y') ?></p>
                            </div>
                            <span class="text-blue-600 hover:underline">Ver detalhes</span>
                        </div>

                        <div class="order-details mt-4 hidden" id="order-details-<?= $order->getId() ?>"></div>
                    </div>
                <?php endforeach; ?>
            </ul>

            <?php if (!$search && $totalPages > 1): ?>
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

        <?php if ($search !== null && empty($clientOrders)): ?>
            <p class="text-red-500 mt-4">Nenhum pedido encontrado com o termo informado.</p>
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
