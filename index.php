<?php
$page_title = "Marketplace - Homepage";
include_once "layout_header.php";
include_once "facade.php";

$productDao = $factory->getProductDao();
$search = $_GET['search'] ?? '';

// Fetch and filter products
$products = $productDao->getAll();

if ($search) {
    $products = array_filter($products, function ($product) use ($search) {
        return stripos($product->getName(), $search) !== false;
    });
}
?>

<section class="min-h-screen bg-gray-100 py-12 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
            <h1 class="text-3xl font-bold text-gray-800">Produtos</h1>
            <form method="GET" class="flex w-full sm:w-auto gap-2">
                <input
                    type="text"
                    name="search"
                    placeholder="Buscar produto..."
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
                        <h2 class="text-xl font-semibold mb-2"><?= htmlspecialchars($product->getName()) ?></h2>
                        <p class="text-gray-600 mb-1">Preço: R$ <?= number_format($product->getStock()->getPrice(), 2, ',', '.') ?></p>
                        <p class="text-gray-600 mb-4">Quantidade: <?= htmlspecialchars($product->getStock()->getQuantity()) ?></p>
                        <a
                            href="product_details.php?id=<?= $product->getId() ?>"
                            class="text-blue-600 hover:underline text-sm">
                            Ver detalhes
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include_once "layout_footer.php"; ?>