<?php
$page_title = "Marketplace - Homepage";
include_once "layout_header.php";
include_once "facade.php";

$productDao = $factory->getProductDao();
$search = $_GET['search'] ?? '';
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$products_per_page = 6;

$all_products = $productDao->getAll();

$filtered_products = $search
    ? array_filter($all_products, function ($product) use ($search) {
        return stripos($product->getName(), $search) !== false
            || strpos((string)$product->getId(), $search) !== false;
    })
    : $all_products;

usort($filtered_products, function ($a, $b) {
    $qtyA = $a->getStock()->getQuantity();
    $qtyB = $b->getStock()->getQuantity();

    if ($qtyA > 0 && $qtyB <= 0) return -1;
    if ($qtyA <= 0 && $qtyB > 0) return 1;
    return 0;
});

$total_products = count($filtered_products);
$total_pages = ceil($total_products / $products_per_page);
$offset = ($current_page - 1) * $products_per_page;
$products = array_slice($filtered_products, $offset, $products_per_page);
?>

<!-- Login Info and Cart -->
<div class="text-sm text-gray-700 space-x-4 flex items-center justify-end p-2 bg-white">

    <?php
    // Calculate cart quantity count
    $cart_count = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $cart_count += $item['quantity'] ?? 1;
        }
    }
    ?>

    <!-- Meus pedidos Button -->
    <a href="my_orders.php"
        class="ml-6 relative inline-flex items-center bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition text-sm">
        Meus Pedidos
    </a>

    <!-- Ver Carrinho Button -->
    <a href="checkout.php"
        class="ml-6 relative inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
        Ver Carrinho
        <?php if ($cart_count > 0): ?>
            <span
                class="ml-2 bg-white text-blue-600 font-semibold rounded-full px-2 text-xs">
                <?= $cart_count ?>
            </span>
        <?php endif; ?>
    </a>
</div>


<section class="min-h-screen bg-gray-100 py-12 px-6">
    <div class="max-w-6xl mx-auto">
        <?php if (isset($_GET['added_to_cart']) && $_GET['added_to_cart'] == 1): ?>
            <div id="cart-alert" class="mb-6 p-4 rounded-lg bg-green-100 text-green-800 border border-green-300">
                Produto adicionado ao carrinho com sucesso!
            </div>

        <?php endif; ?>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
            <h1 class="text-3xl font-bold text-gray-800">Produtos</h1>
            <form method="GET" class="flex w-full sm:w-auto gap-2">
                <input
                    type="text"
                    name="search"
                    placeholder="Buscar produto ou id..."
                    value="<?= htmlspecialchars($search) ?>"
                    class="w-full sm:w-64 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                <button
                    type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Buscar
                </button>
            </form>
        </div>

        <?php if (count($products) === 0): ?>
            <p class="text-gray-600">Nenhum produto encontrado.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($products as $product): ?>
                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">

                        <!-- Image -->
                        <?php if ($product->getImage()): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($product->getImage()) ?>" alt="Imagem do Produto"
                                class="w-full h-48 object-cover rounded mb-4">
                        <?php else: ?>
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500 mb-4 rounded">
                                Sem imagem
                            </div>
                        <?php endif; ?>

                        <!-- Info -->
                        <h2 class="text-xl font-semibold mb-1"><?= htmlspecialchars($product->getName()) ?></h2>
                        <p class="text-sm text-gray-500 mb-2">ID: <?= htmlspecialchars($product->getId()) ?></p>
                        <p class="text-gray-600 mb-1">Preço: R$ <?= number_format($product->getStock()->getPrice(), 2, ',', '.') ?></p>
                        <p class="text-gray-600 mb-1">
                            Quantidade: <?= htmlspecialchars($product->getStock()->getQuantity()) ?>
                        </p>

                        <?php if ($product->getStock()->getQuantity() <= 0): ?>
                            <span class="inline-block text-xs text-white bg-red-600 px-2 py-1 rounded mb-2">Indisponível</span>
                        <?php endif; ?>

                        <!-- Details -->
                        <a href="product_details.php?id=<?= $product->getId() ?>"
                            class="w-full block text-center bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm mt-2">
                            Ver detalhes
                        </a>
                    </div>

                <?php endforeach; ?>
            </div>

            <!-- Pagination Controls -->
            <?php if ($total_pages > 1): ?>
                <div class="mt-8 flex justify-center gap-2">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?<?= http_build_query(['search' => $search, 'page' => $i]) ?>"
                            class="px-3 py-1 rounded border text-sm
                           <?= $i === $current_page ? 'bg-blue-600 text-white' : 'bg-white text-blue-600 hover:bg-blue-100' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<script>
    setTimeout(() => {
        const alert = document.getElementById('cart-alert');
        if (alert) alert.remove();
    }, 3000);
</script>

<?php include_once "layout_footer.php"; ?>