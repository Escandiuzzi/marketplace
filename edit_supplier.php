<?php

$page_title = "Gerenciar Fornecedores";
include_once "layout_header.php";
include_once "facade.php";
require_once "auth_admin.php";

$dao = $factory->getSupplierDao();
$supplier_id = $_GET['id'] ?? null;
$supplier = $dao->searchById($supplier_id);

$products = $factory->getProductDao()->getBySupplierId($supplier_id);
$product_search = $_GET['search'] ?? '';

if ($product_search) {
    $products = array_filter($products, function ($product) use ($product_search) {
        return stripos($product->getName(), $product_search) !== false;
    });
}
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
                    placeholder="Buscar produto por nome..."
                    class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                <button
                    type="submit"
                    class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-800">
                    Buscar
                </button>
            </form>

            <?php if (count($products) === 0): ?>
                <p class="text-gray-600">Nenhum produto encontrado para este fornecedor.</p>
            <?php else: ?>
                <div class="grid md:grid-cols-2 gap-4">
                    <?php foreach ($products as $product): ?>
                        <div class="border rounded-lg p-4 shadow bg-gray-50">
                            <h4 class="font-bold text-lg"><?= htmlspecialchars($product->getName()) ?></h4>
                            <p class="text-gray-600 mb-2">Preço: R$ <?= number_format($product->getStock()->getPrice(), 2, ',', '.') ?></p>
                            <p class="text-gray-600 mb-2">Quantidade: <?= htmlspecialchars($product->getStock()->getQuantity()) ?></p>

                            <div class="flex justify-between text-sm">
                                <a href="edit_product.php?id=<?= $product->getId() ?>" class="text-blue-600 hover:underline">Editar</a>
                                <a href="./actions/admin/products/execute_product_delete.php?id=<?= $product->getId() ?>&supplier_id=<?= $product->getSupplierId() ?>" class="text-red-600 hover:underline" onclick="return confirm('Tem certeza que deseja excluir este produto?');">Excluir</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include_once "layout_footer.php"; ?>