<?php

$page_title = "Fornecedor";
include_once "layout_header.php";
include_once "facade.php";
require_once "auth_admin.php";

$dao = $factory->getSupplierDao();
$supplier_id = $_GET['id'] ?? null;
$supplier = $dao->searchById($supplier_id);

$productDao = $factory->getProductDao();
$all_products = $productDao->getBySupplierId($supplier_id);
$product_search = $_GET['search'] ?? '';

// Filter by name or ID
$products = $product_search
    ? array_filter($all_products, function ($product) use ($product_search) {
        return stripos($product->getName(), $product_search) !== false
            || strpos((string)$product->getId(), $product_search) !== false;
    })
    : $all_products;

// Pagination logic
$products_per_page = 6;
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$total_products = count($products);
$total_pages = ceil($total_products / $products_per_page);
$offset = ($current_page - 1) * $products_per_page;
$products_paginated = array_slice($products, $offset, $products_per_page);
?>

<section class="min-h-screen bg-gray-100 py-10 px-6">
    <div class="max-w-5xl mx-auto bg-white shadow-md rounded-xl p-8">
        <h2 class="text-2xl font-bold mb-6">Editar Fornecedor</h2>

        <form action="./actions/admin/supplier/execute_supplier_update.php" method="POST" class="space-y-4">
            <input type="hidden" name="id" value="<?= $supplier->getId() ?>">

            <!-- Supplier Number -->
            <div>
                <label for="number" class="block text-gray-700 font-medium mb-1">Número</label>
                <input type="number" id="number" name="number" max="99999999999" value="<?= htmlspecialchars($supplier->getNumber()) ?>"
                    class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Name -->
            <div>
                <label for="name" class="block text-gray-700 font-medium mb-1">Nome</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($supplier->getName()) ?>"
                    class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-gray-700 font-medium mb-1">Descrição</label>
                <textarea id="description" name="description"
                    class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500"
                    required><?= htmlspecialchars($supplier->getDescription()) ?></textarea>
            </div>

            <!-- Address Fields -->
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label for="street" class="block text-gray-700 font-medium mb-1">Rua</label>
                    <input type="text" id="street" name="street" value="<?= htmlspecialchars($supplier->getAddress()->getStreet()) ?>"
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="address_number" class="block text-gray-700 font-medium mb-1">Número</label>
                    <input type="text" id="address_number" name="address_number" value="<?= htmlspecialchars($supplier->getAddress()->getNumber()) ?>"
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="complement" class="block text-gray-700 font-medium mb-1">Complemento</label>
                    <input type="text" id="complement" name="complement" value="<?= htmlspecialchars($supplier->getAddress()->getComplement()) ?>"
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="neighborhood" class="block text-gray-700 font-medium mb-1">Bairro</label>
                    <input type="text" id="neighborhood" name="neighborhood" value="<?= htmlspecialchars($supplier->getAddress()->getNeighborhood()) ?>"
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="city" class="block text-gray-700 font-medium mb-1">Cidade</label>
                    <input type="text" id="city" name="city" value="<?= htmlspecialchars($supplier->getAddress()->getCity()) ?>"
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="state" class="block text-gray-700 font-medium mb-1">Estado</label>
                    <input type="text" id="state" name="state" value="<?= htmlspecialchars($supplier->getAddress()->getState()) ?>"
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="zip" class="block text-gray-700 font-medium mb-1">CEP</label>
                    <input type="text" id="zip" name="zip" value="<?= htmlspecialchars($supplier->getAddress()->getZip()) ?>"
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Salvar Alterações
            </button>
        </form>

        <hr class="my-8">

        <div>
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Produtos do Fornecedor</h3>
                <a href="create_product.php?supplier_id=<?= $supplier->getId() ?>" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    Adicionar Produto
                </a>
            </div>

            <!-- Product Search -->
            <form method="GET" class="mb-6 flex gap-2">
                <input type="hidden" name="id" value="<?= $supplier->getId() ?>">
                <input
                    type="text"
                    name="search"
                    value="<?= htmlspecialchars($product_search) ?>"
                    placeholder="Buscar produto por nome ou id..."
                    class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                <button
                    type="submit"
                    class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-800">
                    Buscar
                </button>
            </form>

            <?php if (count($products_paginated) === 0): ?>
                <p class="text-gray-600">Nenhum produto encontrado para este fornecedor.</p>
            <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($products_paginated as $product): ?>
                        <div class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">
                            <?php if ($product->getImage()): ?>
                                <img src="data:image/jpeg;base64,<?= base64_encode($product->getImage()) ?>" alt="Imagem do Produto"
                                    class="w-full h-48 object-cover rounded mb-4">
                            <?php else: ?>
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500 mb-4 rounded">
                                    Sem imagem
                                </div>
                            <?php endif; ?>

                            <h2 class="text-xl font-semibold mb-1"><?= htmlspecialchars($product->getName()) ?></h2>
                            <p class="text-sm text-gray-500 mb-2">ID: <?= htmlspecialchars($product->getId()) ?></p>
                            <p class="text-gray-600 mb-1">Preço: R$ <?= number_format($product->getStock()->getPrice(), 2, ',', '.') ?></p>
                            <p class="text-gray-600 mb-4">Quantidade: <?= htmlspecialchars($product->getStock()->getQuantity()) ?></p>

                            <a href="edit_product.php?id=<?= $product->getId() ?>" class="text-blue-600 hover:underline text-sm">
                                Ver detalhes
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination Controls -->
                <?php if ($total_pages > 1): ?>
                    <div class="mt-8 flex justify-center gap-2">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <a
                                href="?<?= http_build_query(['id' => $supplier_id, 'search' => $product_search, 'page' => $i]) ?>"
                                class="px-3 py-1 rounded border text-sm
                                    <?= $i === $current_page ? 'bg-blue-600 text-white' : 'bg-white text-blue-600 hover:bg-blue-100' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>

            <?php endif; ?>
        </div>
    </div>
</section>

<?php include_once "layout_footer.php"; ?>