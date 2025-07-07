<?php

$page_title = "Gerenciar Fornecedores";
include_once "layout_header.php";
include_once "facade.php";
require_once "auth_admin.php";

$dao = $factory->getSupplierDao();
$search = $_GET['search'] ?? '';
$all_suppliers = $dao->getAll();

$suppliers = $search
    ? array_filter($all_suppliers, function ($supplier) use ($search) {
        return stripos($supplier->getName(), $search) !== false
            || strpos((string)$supplier->getId(), $search) !== false;
    })
    : $all_suppliers;

$suppliers_per_page = 9;
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$total_suppliers = count($suppliers);
$total_pages = ceil($total_suppliers / $suppliers_per_page);
$offset = ($current_page - 1) * $suppliers_per_page;

$suppliers_paginated = array_slice($suppliers, $offset, $suppliers_per_page);
?>

<section class="min-h-screen bg-gray-100 py-12 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Fornecedores</h1>
            <a
                href="create_supplier.php"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Novo Fornecedor
            </a>
        </div>

        <form method="GET" class="mb-8">
            <div class="flex gap-2">
                <input
                    type="text"
                    name="search"
                    value="<?= htmlspecialchars($search) ?>"
                    placeholder="Buscar fornecedor por nome ou id..."
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-400">
                <button
                    type="submit"
                    class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                    Buscar
                </button>
            </div>
        </form>

        <?php if (count($suppliers_paginated) === 0): ?>
            <p class="text-gray-600">Nenhum fornecedor encontrado.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($suppliers_paginated as $supplier): ?>
                    <div class="bg-white p-6 rounded-xl shadow">
                        <h2 class="text-xl font-semibold mb-2"><?= htmlspecialchars($supplier->getName()) ?></h2>
                        <p class="text-sm text-gray-500 mb-2">ID: <?= htmlspecialchars($supplier->getId()) ?></p>
                        <p class="text-gray-600 mb-4">
                            Description: <?= htmlspecialchars($supplier->getDescription()) ?>
                        </p>
                        <div class="flex justify-between">
                            <a
                                href="edit_supplier.php?id=<?= $supplier->getId() ?>"
                                class="text-blue-600 hover:underline">
                                Editar
                            </a>
                            <a
                                href="./actions/admin/supplier/execute_delete_supplier.php?id=<?= $supplier->getId() ?>"
                                class="text-red-600 hover:underline"
                                onclick="return confirm('Tem certeza que deseja excluir este fornecedor?');">
                                Excluir
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="mt-8 flex justify-center gap-2">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a
                            href="?<?= http_build_query(['search' => $search, 'page' => $i]) ?>"
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

<?php include_once "layout_footer.php"; ?>