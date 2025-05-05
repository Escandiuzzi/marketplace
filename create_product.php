<?php
$page_title = "Criar Produto";
include_once "layout_header.php";
include_once "facade.php";

$supplier_id = $_GET['supplier_id'] ?? null;

if (!$supplier_id) {
    echo "ID do fornecedor não fornecido.";
    exit;
}
?>

<section class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-2xl">
        <h2 class="text-2xl font-semibold mb-6 text-center">Criar Produto</h2>

        <form action="./actions/admin/products/execute_product_create.php" method="POST" class="space-y-4">
            <input type="hidden" name="supplier_id" value="<?= $supplier_id ?>">

            <div>
                <label for="name" class="block font-medium text-gray-700 mb-1">Nome</label>
                <input type="text" name="name" id="name" required
                    class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="description" class="block font-medium text-gray-700 mb-1">Descrição</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="price" class="block font-medium text-gray-700 mb-1">Preço</label>
                    <input type="number" step="0.01" name="price" id="price" required
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="quantity" class="block font-medium text-gray-700 mb-1">Quantidade</label>
                    <input type="number" name="quantity" id="quantity" required
                        class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="text-center mt-6">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Criar Produto
                </button>
            </div>
        </form>
    </div>
</section>

<?php include_once "layout_footer.php"; ?>