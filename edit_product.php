<?php
$page_title = "Editar Produto";
include_once "layout_header.php";
include_once "facade.php";
require_once "auth_admin.php";

$dao = $factory->getProductDao();
$product_id = $_GET['id'] ?? null;

if (empty($product_id)) {
    echo "<h3>Erro: ID do produto não fornecido.</h3>";
    exit;
}

$product = $dao->searchById($product_id);
?>

<section class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-2xl">
        <h2 class="text-2xl font-semibold mb-6 text-center">Editar Produto</h2>

        <form action="./actions//admin//products/execute_product_update.php" enctype="multipart/form-data" method="POST" class="space-y-4">
            <input type="hidden" name="id" value="<?= htmlspecialchars($product->getId()) ?>">
            <input type="hidden" name="supplier_id" value="<?= htmlspecialchars($product->getSupplierId()) ?>">

            <div>
                <label for="name" class="block font-medium text-gray-700 mb-1">Nome</label>
                <input type="text" name="name" id="name" required
                    value="<?= htmlspecialchars($product->getName()) ?>"
                    class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="description" class="block font-medium text-gray-700 mb-1">Descrição</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500"><?= htmlspecialchars($product->getDescription()) ?></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="price" class="block font-medium text-gray-700 mb-1">Preço</label>
                    <input type="number" step="0.01" name="price" id="price" required
                        value="<?= htmlspecialchars($product->getStock()->getPrice()) ?>"
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="quantity" class="block font-medium text-gray-700 mb-1">Quantidade</label>
                    <input type="number" name="quantity" id="quantity" required
                        value="<?= htmlspecialchars($product->getStock()->getQuantity()) ?>"
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Imagem do Produto</label>

                <?php if ($product->getImage()): ?>
                    <div class="mb-4">
                        <img src="data:image/jpeg;base64,<?= base64_encode($product->getImage()) ?>" alt="Imagem atual" class="h-40 w-auto rounded mb-2 border">
                        <label class="inline-flex items-center text-sm">
                            <input type="checkbox" name="remove_image" value="1" class="mr-2">
                            Remover imagem atual
                        </label>
                    </div>
                <?php endif; ?>

                <input type="file" name="image" id="image" accept="image/*"
                    class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="text-center mt-6">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</section>

<?php include_once "layout_footer.php"; ?>