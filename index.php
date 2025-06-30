<?php
$page_title = "Marketplace - Homepage";
include_once "layout_header.php";
include_once "facade.php";

$productDao = $factory->getProductDao();
$search = $_GET['search'] ?? '';

// Fetch all products
$products = $productDao->getAll();

if ($search) {
    $products = array_filter($products, function ($product) use ($search) {
        return stripos($product->getName(), $search) !== false
            || strpos((string)$product->getId(), $search) !== false;
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

                        <!-- Product Image -->
                        <?php if ($product->getImage()): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($product->getImage()) ?>" alt="Imagem do Produto"
                                class="w-full h-48 object-cover rounded mb-4">
                        <?php else: ?>
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500 mb-4 rounded">
                                Sem imagem
                            </div>
                        <?php endif; ?>

                        <!-- Product Name and ID -->
                        <h2 class="text-xl font-semibold mb-1"><?= htmlspecialchars($product->getName()) ?></h2>
                        <p class="text-sm text-gray-500 mb-2">ID: <?= htmlspecialchars($product->getId()) ?></p>

                        <!-- Stock Info -->
                        <p class="text-gray-600 mb-1">Preço: R$ <?= number_format($product->getStock()->getPrice(), 2, ',', '.') ?></p>
                        <p class="text-gray-600 mb-4">Quantidade: <?= htmlspecialchars($product->getStock()->getQuantity()) ?></p>

                        <!-- Link -->
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